jQuery(document).ready(function($){
	if(jQuery(".ccre_widget_entries") && jQuery(".ccre_widget_entries").length > 0){
		callAdminAjaxaction(load_url);	
	}
});

function callAdminAjaxaction(url){
		var strData = {
			'action':"ccre_ajax_load",
			'post_id':url.post_id,
			'categories_passed':url.categories_passed
		};

		var jqxhr =  jQuery.ajax({
					type : "POST",
					url: url.ajaxurl,
					data : strData,	
					success: function(data){
						// console.log(data);
						ccreSuccessCallback(data, strData);
					},
					error : function(req,textStatus,error) {
						console.log(error);
						ccreErrorCallback(error);
					},
					timeout: 4000
				});
}

function ccreErrorCallback(err){
	var htmlInsert = "<p>I'm still learning and don't have a suggestion yet. Stay tuned.</p>";
	jQuery(".ccre_widget_loader").hide();
	jQuery(".ccre_widget_entries").html(htmlInsert);
	updateMetrics("", 'error', "NewsHub page load error");
};

function ccreSuccessCallback(data, input){
	jQuery(".ccre_widget_loader").hide();
	jQuery(".ccre_widget_entries").html(data);
	var docidsfromccre = "";
	jQuery(".ccre_container_item a").each(function(){
		docidsfromccre += $(this).attr("data-docid")+",";
	});	
	updateMetrics(docidsfromccre, input.categories_passed ? input.categories_passed : '', "NewsHub page load success");
};

function linkClicked(e){
	
	var ev = jQuery(e);
	var data = {
		url: ev.attr("data-url"),
		docid: ev.attr("data-docid"),
		title: ev.text()
	}
	updateMetrics(data, load_url.categories_passed, 'link click');
	// window.location.href = ev.attr("data-url");
	window.open(ev.attr("data-url"),"_blank");
	return false;
}

function updateMetrics(data, status, eaction){
	if(ibmStats){
		var evObj = {
			ibmEV : "customized NewsHub",
			ibmEvAction : eaction,
			ibmEvGroup : (eaction == "link click")?data.docid:data,
			ibmEvName : 'UNCLASSIFIED',
			ibmEvModule : "NewsHub CCRE Plugin",
			ibmEvSection : "NewsHub sidebar widget",
			ibmEvLinkTitle : (eaction == "link click")?data.title : "",
			ibmEvTarget : (eaction == "link click")?data.url : "",
			ibmEvFileSize : status
		};
		console.log(evObj);
		ibmStats.event(evObj);
	}
}

function likeButtonClicked(e){
	if(ibmStats){
		console.log(e);
		if(e && (e.type == 'likebtn.like' || e.type == 'likebtn.unlike' || e.type == 'likebtn.dislike')){
			var anchorEle = jQuery(e.wrapper).parent().find('a');

			var data = {
				url : anchorEle.attr("data-url"),
				docid: anchorEle.attr("data-docid"),
				title: anchorEle.text()
			};
			var clickType = e.type.replace('likebtn.','');
			console.log(data, clickType);
			updateMetrics(data, clickType, 'link click');
		}
	}
}
