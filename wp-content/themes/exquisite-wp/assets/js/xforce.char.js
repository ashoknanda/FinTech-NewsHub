;(function ($, window, undefined) {
	'use strict';

	var $doc = $(document),
			win = $(window),
			Modernizr = window.Modernizr,
			scrollTime = null,
			scrollTimer = null;

	var SITE = SITE || {};
	
	SITE = {
		init: function() {
		}
		xforce_chart: {
			selector: '#nav a, .extendmenu a',
			init: function() {
				
			}
		}
	}
});

	var svg = d3.select("#xforce_chart")
			.append("svg")
			.append("g")

		svg.append("g")
			.attr("class", "slices");
		svg.append("g")
			.attr("class", "labels");
		svg.append("g")
			.attr("class", "lines");

		var width = 700,
			height = 400,
			radius = Math.min(width, height) / 2;

		var pie = d3.layout.pie()
			.sort(null)
			.value(function(d) {
				return d.value;
			});

		var arc = d3.svg.arc()
			.outerRadius(radius - 40)
			.innerRadius(radius - 70);

		var outerArc = d3.svg.arc()
			.innerRadius(radius * 0.9)
			.outerRadius(radius * 0.9);

		svg.attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

		var key = function(d){
			if (d.data.label == ""){
				return 'Empty';
			}else{
				return d.data.label;
			}
		};

    var data = {};
    data.action = "xforce_chart_data_ajax",

    jQuery.ajax({
        type: "POST",
        url: ajaxurl,
        data: data,
        dataType: 'json',
        success: function(data) {
        	change(data);
        }
    });

		function change(data) {
			console.log(data);
			/* ------- PIE SLICES -------*/
			var slice = svg.select(".slices").selectAll("path.slice")
				.data(pie(data), key);

			slice.enter()
				.append("text")
				.attr("dy", "-10px")
				.attr("dx", "-60px")
				.attr("font-size", "35px")
				.attr("font-family", "arial")
				.text(function(d) {
					return 'Current';
				});

			slice.enter()
				.append("text")
				.attr("dy", "30px")
				.attr("dx", "-63px")
				.attr("font-size", "35px")
				.attr("font-family", "arial")
				.text(function(d) {
					return 'Vendors';
				});


			var color20c = d3.scale.category20c();

			slice.enter()
				.insert("path")
				.style("fill", function(d) { return color20c(d.value); })
				.attr("class", "slice");

			slice
				.transition().duration(1000)
				.attrTween("d", function(d) {
					this._current = this._current || d;
					var interpolate = d3.interpolate(this._current, d);
					this._current = interpolate(0);
					return function(t) {
						return arc(interpolate(t));
					};
				})

			slice.exit()
				.remove();

			/* ------- TEXT LABELS -------*/

			var text = svg.select(".labels").selectAll("text")
				.data(pie(data), key);

			text.enter()
				.append("text")
				.attr("dy", ".35em")
				.text(function(d) {
					if (d.data.label == ""){
						return 'Empty';
					}else{
						return d.data.label;
					}
				});

			function midAngle(d){
				return d.startAngle + (d.endAngle - d.startAngle)/2;
			}

			text.transition().duration(1000)
				.attrTween("transform", function(d) {
					this._current = this._current || d;
					var interpolate = d3.interpolate(this._current, d);
					this._current = interpolate(0);
					return function(t) {
						var d2 = interpolate(t);
						var pos = outerArc.centroid(d2);
						pos[0] = radius * (midAngle(d2) < Math.PI ? 1 : -1);
						return "translate("+ pos +")";
					};
				})
				.styleTween("text-anchor", function(d){
					this._current = this._current || d;
					var interpolate = d3.interpolate(this._current, d);
					this._current = interpolate(0);
					return function(t) {
						var d2 = interpolate(t);
						return midAngle(d2) < Math.PI ? "start":"end";
					};
				});

			text.exit()
				.remove();

			/* ------- SLICE TO TEXT POLYLINES -------*/

			var polyline = svg.select(".lines").selectAll("polyline")
				.data(pie(data), key);

			polyline.enter()
				.append("polyline");

			polyline.transition().duration(1000)
				.attrTween("points", function(d){
					this._current = this._current || d;
					var interpolate = d3.interpolate(this._current, d);
					this._current = interpolate(0);
					return function(t) {
						var d2 = interpolate(t);
						var pos = outerArc.centroid(d2);
						pos[0] = radius * 0.95 * (midAngle(d2) < Math.PI ? 1 : -1);
						return [arc.centroid(d2), outerArc.centroid(d2), pos];
					};
				});

			polyline.exit()
				.remove();
		};