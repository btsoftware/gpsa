var svg;
function setup(width, height){
  projection = d3.geo.mollweide()
    .center([0, 0])
    .scale( (width / height) * 75 )
    .translate([width/2, height/2])
    .precision(0.1);

  path = d3.geo.path()
      .projection(projection);

  graticule = d3.geo.graticule();

  svg = d3.select("#map").append("svg")
      .attr("width", width)
      .attr("height", height)
      .append("g")

  svg.append("defs").append("path")
    .datum({type: "Sphere"})
    .attr("id", "sphere")
    .attr("d", path);

  svg.append("use")
    .attr("class", "stroke fill")
    .attr("xlink:href", "#sphere");

  svg.append("path")
    .datum(graticule)
    .attr("class", "graticule")
    .attr("d", path);

  g = svg.append("g");

}

function draw(topo, tooltip, elected) {

  var country = g.selectAll(".country").data(topo);

  country.enter().insert("path")
      .attr("class", function(d,i) { 
        
        var c = "country";
        if(d.properties.elected == "true") c += " elected"
        return c
      })
      .attr("d", path)
      .attr("id", function(d,i) { return d.id; })
      .attr("title", function(d,i) { return d.properties.name; })
      
  //tooltips
  country.on("mousemove", function(d,i) {
      var mouse = d3.mouse(svg.node()).map( function(d) { return parseInt(d); } );
        if( d.properties.elected == "true" ){
          tooltip
            .classed("hidden", false)
            .attr("style", "left:"+(mouse[0] + 30)+"px;top:"+(mouse[1])+"px")
            .html(d.properties.name)
        }
      })
    .on("mouseout",  function(d,i) {
      tooltip.classed("hidden", true)
    })
    .on("click",  function(d,i) {
      if( elected.indexOf(d.properties.name) >= 0 ) search_stories_by_country(d.properties.name)
    }); 
} 
   

function search_stories_by_country(country){
  setTimeout(function(){document.getElementById('map-info').style.display='block';}, 1000);

  $.post(MyAjax.url, {action : 'search_stories_by_country' , country : country }, function(response) {
    jQuery("#map-info .map-info-data").html(response);
    var dir = ( jQuery("#map-info").css("display") == "block")? "up" : "down";
    jQuery("#map-info").toggle( "slide", { "direction": dir, "duration": 0  });
  });
}

