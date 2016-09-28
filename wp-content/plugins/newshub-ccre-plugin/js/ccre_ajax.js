function callCCRE(url, categories){

	var data = {
		"q": categories?categories.length>0?categories[0].name:"INDUSTRY":"INDUSTRY",
		"industry":"UNCLASSIFIED",
		"subindustry":"UNCLASSIFIED",
		"numresults":5,
		"contentset":"MAM:2,PDP:3",
		"numresults":3	
	};

	var strData = JSON.stringify(data);
	var jqxhr =  jQuery.ajax({
					type : "POST",
					url: url,
					contentType : "application/json; charset=utf-8",
					dataType:"json",
					crossDomain: true,
					data : strData,	
					timeout : 100 * 1000,
					success: function(data){
						ccreSuccessCallback(data);
					},
					error : function(req,textStatus,error) {
						console.log(error);
						ccreErrorCallback(error);
					}
				});
};

function ccreErrorCallback(err){
	var htmlInser = "<p>Apologies , we are having trouble talking to Watson. Please check back later.</p>";
	jQuery(".ccre_widget_loader").hide();
	jQuery(".ccre_widget_entries").html(htmlInsert);	
	updateMetrics(strData, 'error', "by NewsHub content page load");
};

function ccreSuccessCallback(data){
	var htmlInsert = "";
	if(data && data.length > 0){
		for (var x=0; x< data.length ; x++){
			var className = "ibm-arrow-forward-link nh-asset-marketplace";
			if(data[x]["CONTENT TYPE"] != "markeplace"){
				className = "nh-asset-casestudy ibm-arrow-forward-link";
			}
			htmlInsert += '<li><p class="ibm-ind-link"><a class="'+className+'" data-url="'+data[x].URL+'" onclick="linkClicked(this);" href="#">'+data[x].TITLE+'</a></p></li>';
		}
	}
	jQuery(".ccre_widget_loader").hide();
	jQuery(".ccre_widget_entries").html(htmlInsert);
	updateMetrics(strData, 'success', "by NewsHub content page load");
};

jQuery(document).ready(function($){
	if(jQuery(".ccre_widget_entries") && jQuery(".ccre_widget_entries").length > 0){
		callCCRE(ccre_params.url, ccre_params.string_temp);	
	}
});

function linkClicked(e){
	
	var ev = jQuery(e);
	var data = {
		url: ev.attr("data-url"),
		title: ev.text()
	}
	updateMetrics(data, "link click", 'link click')
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




