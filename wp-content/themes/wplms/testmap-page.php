<?php
/**
 * Template Name: testmap
 */

get_header();
if ( have_posts() ) : while ( have_posts() ) : the_post();

$title=get_post_meta(get_the_ID(),'vibe_title',true);
if(isset($title) && $title !='' && $title !='H'){
?>

<section id="title">
    <div class="container">
         <div class="row">
            <div class="col-md-9 col-sm-8">
                <div class="pagetitle">
                    <h1><?php the_title(); ?></h1>
                    <h5><?php the_sub_title(); ?></h5>
                </div>
            </div>
            <div class="col-md-3 col-sm-4">
                <?php
                    $breadcrumbs=get_post_meta(get_the_ID(),'vibe_breadcrumbs',true);
                    if(isset($breadcrumbs) && $breadcrumbs !='' && $breadcrumbs !='H')
                        vibe_breadcrumbs(); 
                ?>
            </div>
        </div>
    </div>
</section>
<?php
}
?>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/colorbox.css">
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.colorbox-min.js"></script>


<!-- no cargarlos si la pantalla es menor a 600 -->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/d3.min.js"></script>

<!--script src="http://d3js.org/d3.geo.projection.v0.min.js"></script-->
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/d3.geo.projection.v0.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/libs/topojson.v1.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/map_d3.js"></script>
<!-- no cargarlos si la pantalla es menor a 600 -->
<style>
 .button-uploadVideo { background-color: #f15630 !important; border-color: #f15630 !important; border-radius: 2px; color: #fff;  letter-spacing: 0.2em; margin: 83px 10px 10px 0; padding: 10px 24px; position: relative; transition: all 0.3s ease 0s; width: 143px; z-index: 1;}
</style>
<section id="title">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="pagetitleTJ-interiores">
                                        <h1>Tell us your story</h1>
                    <h5>We invite you to share with the community your lessons learned in social accountability. Just take your cellphone and record your story! <br> #SocialAccStories</h5>                </div>         
            </div>
            <div class="col-md-5">
                <a href="/share-video">
                    <h3>SHARE YOUR STORY</h3>
					</a>
                    <hr class="pleca-bca">
                <a class="button-uploadVideo youtube" href="http://www.youtube.com/embed/3_1m5dLuJ9k?rel=0&amp;wmode=transparent">
                    <span class="tutorial">Video Tutorial </span> <span id ="play">►</span> 
                </a>
            </div>

        </div>
    </div>
</section>
<!-- secci—m mapa -->
<section id="content" class="mapa">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="content" id="map_container">
                    <div class="row">
                        <div id="map-info">
					<a class="close-map-info"  onclick="document.getElementById('map-info').style.display='none';return false;">  Go to map </a>
                            <div class="map-info-data"></div>
                        </div>
                        <div id="map">
                            <!--img class="wait" src="http://www.ajaxload.info/cache/BE/95/BF/00/00/00/8-1.gif"-->
                            <img class="wait" style="position: absolute; top: 48%; left: 45%;" src="<?php echo get_template_directory_uri(); ?>/assets/images/loader.gif" >
                            
                            <!--div id="map-legend">    
                                <p> Da click en el mapa para ver los casos de cada país </p> 
                            </div-->
                        </div>


                        <div id="menu-paises">
                            <h2> Tell your stories </h2>  
                            <ul> <!-- Aquí se agregan dinamicamente los paises y sus historias --> </ul>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){
    var countries = ['Mexico', 'Togo'];
    
    /*Agregando paises a la lista*/
    for(var i = 0 in countries){
        jQuery('#menu-paises ul').append("<li class='pais'> <a href='#" + countries[i] + "'>" + countries[i] + "</a> </li>")
    }
    if ($(window).width() > 600) {
      var width = document.getElementById('map').offsetWidth 
        , height = document.getElementById('map').offsetHeight 
        , topo, projection, path, svg, g
        , tooltip = d3.select("#map").append("div").attr("class", "tooltip hidden");
      
      d3.json("<?php echo get_template_directory_uri(); ?>/assets/js/data/world-topo.json.packed", function(error, world) {
            jQuery(".wait").remove()
            setup(width, height);
            topo = topojson.feature(world, world.objects.countries).features;
            draw(topo, tooltip, countries); 
      });
    }

    jQuery(".close-map-info").on("click", function(e){
        jQuery("#map-info").toggle( "slide", { "direction": "down", "duration": 800  });
    })
	
	  $('.close-map-info').click(function(){  //Adds click event listener  
        $('#map-info').toggle('slow'); // Toggles visibility.  Use the 'slow' parameter to add a nice effect.
    });

    jQuery("li.pais a").on("click", function(e){
        var pais = jQuery(this).attr("href").substring(1);
        search_stories_by_country(pais)
        return false
    })

    $(".youtube").colorbox({iframe:true, innerWidth:340, innerHeight:190});
})

$(function() {
    $('.close-map-info').click(function(){  //Adds click event listener  
        $('#map-info').toggle('slow'); // Toggles visibility.  Use the 'slow' parameter to add a nice effect.
    });
});
</script>


<?php
endwhile;
endif; 
?>

<?php
get_footer();
?>