jQuery(document).ready(function($){
	if(jQuery(".ccre_widget_entries") && jQuery(".ccre_widget_entries").length > 0){
		callAdminAjaxaction(load_url);	
	}
});

function callAdminAjaxaction(url){
		var strData = {
			'action':"ccre_ajax_load",
			'post_id':url.post_id
		};
		var jqxhr =  jQuery.ajax({
					type : "POST",
					url: url.ajaxurl,
					data : strData,	
					success: function(data){
						// console.log(data);
						ccreSuccessCallback(data);
					},
					error : function(req,textStatus,error) {
						console.log(error);
						ccreErrorCallback(error);
					}
				});
}

function ccreErrorCallback(err){
	var htmlInser = "<p>Apologies , we are having trouble talking to Watson. Please check back later.</p>";
	jQuery(".ccre_widget_loader").hide();
	jQuery(".ccre_widget_entries").html(htmlInsert);	
	updateMetrics("", 'error', "by NewsHub content page load");
};

function ccreSuccessCallback(data){
	jQuery(".ccre_widget_loader").hide();
	jQuery(".ccre_widget_entries").html(data);
	updateMetrics("", 'success', "by NewsHub content page load");
};

function linkClicked(e){
	
	var ev = jQuery(e);
	var data = {
		url: ev.attr("data-url"),
		docid: ev.attr("data-docid"),
		title: ev.text()
	}
	updateMetrics(data, "link click", 'link click');
	// window.location.href = ev.attr("data-url");
	window.open(ev.attr("data-url"),"_blank");
	return false;
}

function updateMetrics(data, status, eaction){
	ibmStats.event({
		ibmEV : "customized NewsHub",
		ibmEvAction : eaction,
		ibmEvGroup : status,
		ibmEvName : data,
		ibmEvModule : "NewsHub CCRE Plugin",
		ibmEvSection : "NewsHub sidebar widget",
		ibmEvLinkTitle : (status == "link click")?data.title : "",
		ibmEvTarget : (status == "link click")?data.url : ""
	})
}

function likeButtonClicked(e){
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
