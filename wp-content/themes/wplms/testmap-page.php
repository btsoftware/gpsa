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
<!-- secci—m mapa -->
<section id="content" class="mapa">
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="content" id="map_container">
                    <div class="row">
                        <div id="map-info">
                            <a class="close-map-info">  Go to map </a>
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
<?php
endwhile;
endif; 
?>
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






<?php
get_footer();
?>