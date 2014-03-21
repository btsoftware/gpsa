/*load map - mapbox fundarmexico*/
var map     = L.mapbox.map('map', 'fundarmexico.zuz69a4i').setView([0,0], 3);
var markers = new L.LayerGroup();

/*disable scroll and tocuh zoom*/
map.touchZoom.disable();
map.scrollWheelZoom.disable();

/*marker style-options*/
var geojsonMarkerOptions = {
	radius : 17,
	fillColor: "transparent",
	color: "#a9d7ef",
	weight: 13,
	opacity: 0.7,
	fillOpacity: 0.8
};

function draw(value) {
	var theme = parseInt(value);
	
	/*on each marker*/
	function onEachFeature(feature, layer) {
		var feature = feature;
		
		/*search index theme on array [0,1] number of experts for country*/
		var indexof  = jQuery.inArray(theme, feature.properties.themes[0]);
		var indexof2 = jQuery.inArray(theme, feature.properties.themes[1]);
		var indexof3 = jQuery.inArray(theme, feature.properties.themes[2]);
		var indexof4 = jQuery.inArray(theme, feature.properties.themes[3]);
		
		if(indexof != -1 || indexof2 != -1 || indexof3 != -1 || indexof4 != -1 || theme == 0) {
			var circle = L.circleMarker([feature.geometry.coordinates[1], feature.geometry.coordinates[0]], geojsonMarkerOptions);
		   
			/*Listen for individual marker CLICK*/
			circle.on('click',function(e) {
				var info  = '<h2>' + feature.properties.name + '</h2>';
				
				for(i in feature.properties.names) {
					if(jQuery.inArray(theme, feature.properties.themes[i] != -1 || theme == 0) {
						info += '<p class="name-expert"><a href="' + feature.properties.urls[i] + '" title="' + feature.properties.names[i] + '">' + feature.properties.names[i] + '</a></p>';
					}
				}

				document.getElementById('info').innerHTML = info;
			});
			
			/*Listen for individual marker OVER*/
			circle.on('mouseover',function(e) {
				var info  = '<h2>' + feature.properties.name + '</h2>';
				
				for(i in feature.properties.names) {
					if(jQuery.inArray(theme, feature.properties.themes[i] != -1 || theme == 0) {
						info += '<p class="name-expert"><a href="' + feature.properties.urls[i] + '" title="' + feature.properties.names[i] + '">' + feature.properties.names[i] + '</a></p>';
					}
				}

				document.getElementById('info').innerHTML = info;
			});
			
			/*add to group layer*/
			markers.addLayer(circle);
		}
	}

	/*load geojson.js*/
	L.geoJson(geojson, {
		onEachFeature: onEachFeature
	});
}

/*add layer to map*/
markers.addTo(map);

/*on each theme set legend*/
var themes = '<a id="theme-0" data-control="layer">All themes</a>';

for(i in geojson.properties.themes) {
	themes += '<a id="theme-' + geojson.properties.themes[i].id_theme + '" data-control="layer">' + geojson.properties.themes[i].name + '</a>';
}
document.getElementById('themes-layers').innerHTML = themes;

$(document).ready (function () {
	$('.layers > a').click(function() {
		$(".layers > a").removeClass('active');
		
		if($(this).hasClass('active')) {
			$(this).removeClass('active');
		} else {
			$(this).addClass('active');
		}
		
		setTheme();
	});
	
	$("#theme-0").click();
});

function setTheme() {
	markers.clearLayers();
	
	var active = $(".layers > a.active").attr("id");
	
	draw(active.replace("theme-", ""));
}
