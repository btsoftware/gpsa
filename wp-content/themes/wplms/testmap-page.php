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
            <div class="col-md-12">
		<div class="pagetitle"><h1>Tell us your story</h1></div>
                <h5>We invite you to share with the community your lessons learned in social accountability. Just take your cellphone and record your story!
		<b> #SocialAccStories</b>
	    </div>         
            
            <div class="col-md-12" style="margin-top: -11px; margin-bottom: 10px;">
                <a class="contorno-morado-tell" href="/share-video">Share your story</a>
                   
                <a class="contorno-morado-tell" id="484"  href="http://www.youtube.com/embed/3_1m5dLuJ9k?rel=0&amp;wmode=transparent">
                    <span class="tutorial">How to upload your video</span> <span id ="play">►</span> 
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
    var countries = ['Mexico', 'Uganda', 'Senegal','Egypt','Colombia','India','Pakistan','Argentina','Indonesia','Malawi'];
    
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

    $("#484").colorbox({iframe:true, innerWidth:340, innerHeight:190});
})

$(function() {
    $('.close-map-info').click(function(){  //Adds click event listener  
        $('#map-info').toggle('slow'); // Toggles visibility.  Use the 'slow' parameter to add a nice effect.
    });
});
</script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/wp-spamshield/js/jscripts-ftr2-min.js?7f8560"></script>
<script type='text/javascript'>
/* <![CDATA[ */
var gallery_video_resp_lightbox_obj = {"gallery_video_lightbox_slideAnimationType":"effect_1","gallery_video_lightbox_lightboxView":"view1","gallery_video_lightbox_speed_new":"600","gallery_video_lightbox_width_new":"100","gallery_video_lightbox_height_new":"100","gallery_video_lightbox_videoMaxWidth":"790","gallery_video_lightbox_overlayDuration":"150","gallery_video_lightbox_overlayClose_new":"true","gallery_video_lightbox_loop_new":"true","gallery_video_lightbox_escKey_new":"true","gallery_video_lightbox_keyPress_new":"true","gallery_video_lightbox_arrows":"true","gallery_video_lightbox_mouseWheel":"true","gallery_video_lightbox_showCounter":"true","gallery_video_lightbox_nextHtml":"","gallery_video_lightbox_prevHtml":"","gallery_video_lightbox_sequence_info":"image","gallery_video_lightbox_sequenceInfo":"of","gallery_video_lightbox_slideshow_new":"true","gallery_video_lightbox_slideshow_auto_new":"false","gallery_video_lightbox_slideshow_speed_new":"2500","gallery_video_lightbox_slideshow_start_new":"","gallery_video_lightbox_slideshow_stop_new":"","gallery_video_lightbox_watermark":"false","gallery_video_lightbox_socialSharing":"true","gallery_video_lightbox_facebookButton":"true","gallery_video_lightbox_twitterButton":"true","gallery_video_lightbox_googleplusButton":"true","gallery_video_lightbox_pinterestButton":"false","gallery_video_lightbox_linkedinButton":"false","gallery_video_lightbox_tumblrButton":"false","gallery_video_lightbox_redditButton":"false","gallery_video_lightbox_bufferButton":"false","gallery_video_lightbox_diggButton":"false","gallery_video_lightbox_vkButton":"false","gallery_video_lightbox_yummlyButton":"false","gallery_video_lightbox_watermark_text":"WaterMark","gallery_video_lightbox_watermark_textColor":"ffffff","gallery_video_lightbox_watermark_textFontSize":"30","gallery_video_lightbox_watermark_containerBackground":"000000","gallery_video_lightbox_watermark_containerOpacity":"90","gallery_video_lightbox_watermark_containerWidth":"300","gallery_video_lightbox_watermark_position_new":"9","gallery_video_lightbox_watermark_opacity":"70","gallery_video_lightbox_watermark_margin":"10","gallery_video_lightbox_watermark_img_src_new":"http:\/\/gpsaknowledge.org\/wp-content\/plugins\/gallery-video\/assets\/images\/admin_images\/No-image-found.jpg","gallery_video_lightbox_watermark_container_bg_color":"rgba(0,0,0,0.9)"};
var videoGalleryDisableRightClickLightbox = "off";
/* ]]> */
</script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/gallery-video/includes/../assets/js/lightbox.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/gallery-video/includes/../assets/js/mousewheel.min.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/gallery-video/includes/../assets/js/froogaloop2.min.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/gallery-video/includes/../assets/js/jquery.hugeitmicro.min.js?7f8560"></script>
<script type='text/javascript'>
/* <![CDATA[ */
var param_obj = {"gallery_video_ht_view2_element_linkbutton_text":"View More","gallery_video_ht_view2_element_show_linkbutton":"on","gallery_video_ht_view2_element_linkbutton_color":"FFFFFF","gallery_video_ht_view2_element_linkbutton_font_size":"14","gallery_video_ht_view2_element_linkbutton_background_color":"FF2C2C","gallery_video_ht_view2_show_popup_linkbutton":"on","gallery_video_ht_view2_popup_linkbutton_text":"View More","gallery_video_ht_view2_popup_linkbutton_background_hover_color":"C02121","gallery_video_ht_view2_popup_linkbutton_background_color":"FF2C2C","gallery_video_ht_view2_popup_linkbutton_font_hover_color":"FFFFFF","gallery_video_ht_view2_popup_linkbutton_color":"FFFFFF","gallery_video_ht_view2_popup_linkbutton_font_size":"14","gallery_video_ht_view2_description_color":"222222","gallery_video_ht_view2_description_font_size":"14","gallery_video_ht_view2_show_description":"on","gallery_video_ht_view2_thumbs_width":"75","gallery_video_ht_view2_thumbs_height":"75","gallery_video_ht_view2_thumbs_position":"before","gallery_video_ht_view2_show_thumbs":"on","gallery_video_ht_view2_popup_background_color":"FFFFFF","gallery_video_ht_view2_popup_overlay_color":"000000","gallery_video_ht_view2_popup_overlay_transparency_color":"70","gallery_video_ht_view2_popup_closebutton_style":"dark","gallery_video_ht_view2_show_separator_lines":"on","gallery_video_ht_view2_show_popup_title":"on","gallery_video_ht_view2_element_title_font_size":"18","gallery_video_ht_view2_element_title_font_color":"222222","gallery_video_ht_view2_popup_title_font_size":"18","gallery_video_ht_view2_popup_title_font_color":"222222","gallery_video_ht_view2_element_overlay_color":"FFFFFF","gallery_video_ht_view2_element_overlay_transparency":"70","gallery_video_ht_view2_zoombutton_style":"light","gallery_video_ht_view2_element_border_width":"1","gallery_video_ht_view2_element_border_color":"DEDEDE","gallery_video_ht_view2_element_background_color":"F9F9F9","gallery_video_ht_view2_element_width":"277","gallery_video_ht_view2_element_height":"160","gallery_video_ht_view5_icons_style":"dark","gallery_video_ht_view5_show_separator_lines":"on","gallery_video_ht_view5_linkbutton_text":"View More","gallery_video_ht_view5_show_linkbutton":"on","gallery_video_ht_view5_linkbutton_background_hover_color":"C02121","gallery_video_ht_view5_linkbutton_background_color":"FF2C2C","gallery_video_ht_view5_linkbutton_font_hover_color":"FFFFFF","gallery_video_ht_view5_linkbutton_color":"FFFFFF","gallery_video_ht_view5_linkbutton_font_size":"14","gallery_video_ht_view5_description_color":"555555","gallery_video_ht_view5_description_font_size":"14","gallery_video_ht_view5_show_description":"on","gallery_video_ht_view5_thumbs_width":"75","gallery_video_ht_view5_thumbs_height":"75","gallery_video_ht_view5_show_thumbs":"on","gallery_video_ht_view5_title_font_size":"16","gallery_video_ht_view5_title_font_color":"C02121","gallery_video_ht_view5_main_image_width":"275","gallery_video_ht_view5_slider_tabs_font_color":"d9d99","gallery_video_ht_view5_slider_tabs_background_color":"555555","gallery_video_ht_view5_slider_background_color":"F9F9F9","gallery_video_ht_view6_title_font_size":"16","gallery_video_ht_view6_title_font_color":"C02121","gallery_video_ht_view6_title_font_hover_color":"FF2C2C","gallery_video_ht_view6_title_background_color":"000000","gallery_video_ht_view6_title_background_transparency":"80","gallery_video_ht_view6_border_radius":"3","gallery_video_ht_view6_border_width":"0","gallery_video_ht_view6_border_color":"EEEEEE","gallery_video_ht_view6_width":"275","gallery_video_light_box_size":"17","gallery_video_light_box_width":"800","gallery_video_light_box_transition":"elastic","gallery_video_light_box_speed":"800","gallery_video_light_box_href":"False","gallery_video_light_box_title":"false","gallery_video_light_box_scalephotos":"true","gallery_video_light_box_rel":"false","gallery_video_light_box_scrolling":"false","gallery_video_light_box_opacity":"20","gallery_video_light_box_open":"false","gallery_video_light_box_overlayclose":"true","gallery_video_light_box_esckey":"false","gallery_video_light_box_arrowkey":"false","gallery_video_light_box_loop":"true","gallery_video_light_box_data":"false","gallery_video_light_box_classname":"false","gallery_video_light_box_fadeout":"300","gallery_video_light_box_closebutton":"true","gallery_video_light_box_current":"image","gallery_video_light_box_previous":"previous","gallery_video_light_box_next":"next","gallery_video_light_box_close":"close","gallery_video_light_box_iframe":"false","gallery_video_light_box_inline":"false","gallery_video_light_box_html":"false","gallery_video_light_box_photo":"false","gallery_video_light_box_height":"600","gallery_video_light_box_innerwidth":"false","gallery_video_light_box_innerheight":"false","gallery_video_light_box_initialwidth":"300","gallery_video_light_box_initialheight":"100","gallery_video_light_box_maxwidth":"","gallery_video_light_box_maxheight":"","gallery_video_light_box_slideshow":"false","gallery_video_light_box_slideshowspeed":"2500","gallery_video_light_box_slideshowauto":"true","gallery_video_light_box_slideshowstart":"start slideshow","gallery_video_light_box_slideshowstop":"stop slideshow","gallery_video_light_box_fixed":"true","gallery_video_light_box_top":"false","gallery_video_light_box_bottom":"false","gallery_video_light_box_left":"false","gallery_video_light_box_right":"false","gallery_video_light_box_reposition":"false","gallery_video_light_box_retinaimage":"true","gallery_video_light_box_retinaurl":"false","gallery_video_light_box_retinasuffix":"@2x.$1","gallery_video_light_box_returnfocus":"true","gallery_video_light_box_trapfocus":"true","gallery_video_light_box_fastiframe":"true","gallery_video_light_box_preloading":"true","gallery_video_lightbox_open_position":"5","gallery_video_light_box_style":"1","gallery_video_light_box_size_fix":"true","gallery_video_slider_crop_image":"resize","gallery_video_slider_title_color":"000000","gallery_video_slider_title_font_size":"13","gallery_video_slider_description_color":"FFFFFF","gallery_video_slider_description_font_size":"12","gallery_video_slider_title_position":"right-top","gallery_video_slider_description_position":"right-bottom","gallery_video_slider_title_border_size":"0","gallery_video_slider_title_border_color":"FFFFFF","gallery_video_slider_title_border_radius":"4","gallery_video_slider_description_border_size":"0","gallery_video_slider_description_border_color":"FFFFFF","gallery_video_slider_description_border_radius":"0","gallery_video_slider_slideshow_border_size":"0","gallery_video_slider_slideshow_border_color":"FFFFFF","gallery_video_slider_slideshow_border_radius":"0","gallery_video_slider_navigation_type":"1","gallery_video_slider_navigation_position":"bottom","gallery_video_slider_title_background_color":"FFFFFF","gallery_video_slider_description_background_color":"000000","gallery_video_slider_title_transparent":"on","gallery_video_slider_description_transparent":"on","gallery_video_slider_slider_background_color":"FFFFFF","gallery_video_slider_dots_position":"none","gallery_video_slider_active_dot_color":"FFFFFF","gallery_video_slider_dots_color":"000000","gallery_video_slider_description_width":"70","gallery_video_slider_description_height":"50","gallery_video_slider_description_background_transparency":"70","gallery_video_slider_description_text_align":"justify","gallery_video_slider_title_width":"30","gallery_video_slider_title_height":"50","gallery_video_slider_title_background_transparency":"70","gallery_video_slider_title_text_align":"right","gallery_video_slider_title_has_margin":"off","gallery_video_slider_description_has_margin":"off","gallery_video_slider_show_arrows":"on","gallery_video_thumb_image_behavior":"on","gallery_video_thumb_image_width":"240","gallery_video_thumb_image_height":"150","gallery_video_thumb_image_border_width":"1","gallery_video_thumb_image_border_color":"444444","gallery_video_thumb_image_border_radius":"5","gallery_video_thumb_margin_image":"1","gallery_video_thumb_title_font_size":"16","gallery_video_thumb_title_font_color":"FFFFFF","gallery_video_thumb_title_background_color":"CCCCCC","gallery_video_thumb_title_background_transparency":"80","gallery_video_thumb_box_padding":"28","gallery_video_thumb_box_background":"333333","gallery_video_thumb_box_use_shadow":"on","gallery_video_thumb_box_has_background":"on","gallery_video_thumb_view_text":"Watch Video","gallery_video_ht_view8_element_cssAnimation":"false","gallery_video_ht_view8_element_height":"120","gallery_video_ht_view8_element_maxheight":"155","gallery_video_ht_view8_element_show_caption":"true","gallery_video_ht_view8_element_padding":"0","gallery_video_ht_view8_element_border_radius":"5","gallery_video_ht_view8_icons_style":"dark","gallery_video_ht_view8_element_title_font_size":"13","gallery_video_ht_view8_element_title_font_color":"3AD6FC","gallery_video_ht_view8_popup_background_color":"000000","gallery_video_ht_view8_popup_overlay_transparency_color":"0","gallery_video_ht_view8_popup_closebutton_style":"dark","gallery_video_ht_view8_element_title_overlay_transparency":"90","gallery_video_ht_view8_element_size_fix":"false","gallery_video_ht_view8_element_title_background_color":"FF1C1C","gallery_video_ht_view8_element_justify":"true","gallery_video_ht_view8_element_randomize":"false","gallery_video_ht_view8_element_animation_speed":"2000","gallery_video_video_ht_view9_title_fontsize":"18","gallery_video_video_ht_view9_title_color":"FFFFFF","gallery_video_video_ht_view9_desc_color":"000000","gallery_video_video_ht_view9_desc_fontsize":"14","gallery_video_video_ht_view9_element_title_show":"true","gallery_video_video_ht_view9_element_desc_show":"true","gallery_video_video_ht_view9_general_width":"100","gallery_video_video_view9_general_position":"center","gallery_video_video_view9_title_textalign":"left","gallery_video_video_view9_desc_textalign":"justify","gallery_video_video_view9_image_position":"2","gallery_video_video_ht_view9_title_back_color":"000000","gallery_video_video_ht_view9_title_opacity":"70","gallery_video_video_ht_view9_desc_opacity":"100","gallery_video_video_ht_view9_desc_back_color":"FFFFFF","gallery_video_video_ht_view9_general_space":"0","gallery_video_video_ht_view9_general_separator_size":"0","gallery_video_video_ht_view9_general_separator_color":"010457","gallery_video_video_view9_general_separator_style":"dotted","gallery_video_video_ht_view9_paginator_fontsize":"22","gallery_video_video_ht_view9_paginator_color":"1046B3","gallery_video_video_ht_view9_paginator_icon_color":"1046B3","gallery_video_video_ht_view9_paginator_icon_size":"18","gallery_video_video_view9_paginator_position":"center","gallery_video_video_ht_view9_video_width":"100%","gallery_video_video_ht_view9_video_height":"100%","gallery_video_video_view9_video_position":"center","gallery_video_video_view9_loadmore_position":"center","gallery_video_video_ht_view9_loadmore_fontsize":"19","gallery_video_video_ht_view9_button_color":"5CADFF","gallery_video_video_ht_view9_loadmore_font_color":"FFFFFF","gallery_video_loading_type":"2","gallery_video_video_ht_view9_loadmore_text":"View More","gallery_video_video_ht_view8_paginator_position":"center","gallery_video_video_ht_view8_paginator_icon_size":"18","gallery_video_video_ht_view8_paginator_icon_color":"26A6FC","gallery_video_video_ht_view8_paginator_color":"26A6FC","gallery_video_video_ht_view8_paginator_fontsize":"18","gallery_video_video_ht_view8_loadmore_position":"center","gallery_video_video_ht_view8_loadmore_fontsize":"14","gallery_video_video_ht_view8_button_color":"26A6FC","gallery_video_video_ht_view8_loadmore_font_color":"FF1C1C","gallery_video_video_ht_view8_loading_type":"3","gallery_video_video_ht_view8_loadmore_text":"View More","gallery_video_video_ht_view7_paginator_fontsize":"22","gallery_video_video_ht_view7_paginator_color":"0A0202","gallery_video_video_ht_view7_paginator_icon_color":"333333","gallery_video_video_ht_view7_paginator_icon_size":"22","gallery_video_video_ht_view7_paginator_position":"center","gallery_video_video_ht_view7_loadmore_position":"center","gallery_video_video_ht_view7_loadmore_fontsize":"19","gallery_video_video_ht_view7_button_color":"333333","gallery_video_video_ht_view7_loadmore_font_color":"CCCCCC","gallery_video_video_ht_view7_loading_type":"1","gallery_video_video_ht_view7_loadmore_text":"View More","gallery_video_video_ht_view4_paginator_fontsize":"19","gallery_video_video_ht_view4_paginator_color":"FF2C2C","gallery_video_video_ht_view4_paginator_icon_color":"B82020","gallery_video_video_ht_view4_paginator_icon_size":"21","gallery_video_video_ht_view4_paginator_position":"center","gallery_video_video_ht_view4_loadmore_position":"center","gallery_video_video_ht_view4_loadmore_fontsize":"16","gallery_video_video_ht_view4_button_color":"5CADFF","gallery_video_video_ht_view4_loadmore_font_color":"FF0D0D","gallery_video_video_ht_view4_loading_type":"3","gallery_video_video_ht_view4_loadmore_text":"View More","gallery_video_video_ht_view1_paginator_fontsize":"22","gallery_video_video_ht_view1_paginator_color":"222222","gallery_video_video_ht_view1_paginator_icon_color":"FF2C2C","gallery_video_video_ht_view1_paginator_icon_size":"22","gallery_video_video_ht_view1_paginator_position":"left","gallery_video_video_ht_view1_loadmore_position":"center","gallery_video_video_ht_view1_loadmore_fontsize":"22","gallery_video_video_ht_view1_button_color":"FF2C2C","gallery_video_video_ht_view1_loadmore_font_color":"FFFFFF","gallery_video_video_ht_view1_loading_type":"2","gallery_video_video_ht_view1_loadmore_text":"Load More","gallery_video_video_ht_view9_loadmore_font_color_hover":"D9D9D9","gallery_video_video_ht_view9_button_color_hover":"8F827C","gallery_video_video_ht_view8_loadmore_font_color_hover":"FF4242","gallery_video_video_ht_view8_button_color_hover":"0FEFFF","gallery_video_video_ht_view7_loadmore_font_color_hover":"D9D9D9","gallery_video_video_ht_view7_button_color_hover":"8F827C","gallery_video_video_ht_view4_loadmore_font_color_hover":"FF4040","gallery_video_video_ht_view4_button_color_hover":"99C5FF","gallery_video_video_ht_view1_loadmore_font_color_hover":"F2F2F2","gallery_video_video_ht_view1_button_color_hover":"991A1A","gallery_video_ht_view2_content_in_center_popup":"off","gallery_video_ht_view2_content_in_center_lightbox":"off","gallery_video_video_natural_size_thumbnail":"resize","gallery_video_video_natural_size_contentpopup":"resize","gallery_video_version":"2.0.4","gallery_video_lightbox_slideAnimationType":"effect_1","gallery_video_lightbox_lightboxView":"view1","gallery_video_lightbox_speed_new":"600","gallery_video_lightbox_width_new":"100","gallery_video_lightbox_height_new":"100","gallery_video_lightbox_videoMaxWidth":"790","gallery_video_lightbox_overlayDuration":"150","gallery_video_lightbox_overlayClose_new":"true","gallery_video_lightbox_loop_new":"true","gallery_video_lightbox_escKey_new":"true","gallery_video_lightbox_keyPress_new":"true","gallery_video_lightbox_arrows":"true","gallery_video_lightbox_mouseWheel":"true","gallery_video_lightbox_showCounter":"true","gallery_video_lightbox_nextHtml":"","gallery_video_lightbox_prevHtml":"","gallery_video_lightbox_sequence_info":"image","gallery_video_lightbox_sequenceInfo":"of","gallery_video_lightbox_slideshow_new":"true","gallery_video_lightbox_slideshow_auto_new":"false","gallery_video_lightbox_slideshow_speed_new":"2500","gallery_video_lightbox_slideshow_start_new":"","gallery_video_lightbox_slideshow_stop_new":"","gallery_video_lightbox_watermark":"false","gallery_video_lightbox_socialSharing":"true","gallery_video_lightbox_facebookButton":"true","gallery_video_lightbox_twitterButton":"true","gallery_video_lightbox_googleplusButton":"true","gallery_video_lightbox_pinterestButton":"false","gallery_video_lightbox_linkedinButton":"false","gallery_video_lightbox_tumblrButton":"false","gallery_video_lightbox_redditButton":"false","gallery_video_lightbox_bufferButton":"false","gallery_video_lightbox_diggButton":"false","gallery_video_lightbox_vkButton":"false","gallery_video_lightbox_yummlyButton":"false","gallery_video_lightbox_watermark_text":"WaterMark","gallery_video_lightbox_watermark_textColor":"ffffff","gallery_video_lightbox_watermark_textFontSize":"30","gallery_video_lightbox_watermark_containerBackground":"000000","gallery_video_lightbox_watermark_containerOpacity":"90","gallery_video_lightbox_watermark_containerWidth":"300","gallery_video_lightbox_watermark_position_new":"9","gallery_video_lightbox_watermark_opacity":"70","gallery_video_lightbox_watermark_margin":"10","gallery_video_lightbox_watermark_img_src_new":"http:\/\/gpsaknowledge.org\/wp-content\/plugins\/gallery-video\/assets\/images\/admin_images\/No-image-found.jpg","gallery_video_lightbox_type":"new_type"};
var adminUrl = "http:\/\/gpsaknowledge.org\/wp-admin\/admin-ajax.php";
var hasYoutube = "false";
var hasVimeo = "false";
/* ]]> */
</script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/gallery-video/includes/../assets/js/view-lightbox-gallery.js?7f8560"></script>
<script type='text/javascript'>
/* <![CDATA[ */
var is_watermark = "false";
var video_lightbox_type = "new_type";
var galleryVideoId = "1";
var gallery_video_view = "lightbox-gallery";
/* ]]> */
</script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/gallery-video/includes/../assets/js/custom.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/vibe-course-module/includes/js/jquery.confirm.min.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/plugins/vibe-course-module/includes/js/html2canvas.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-includes/js/mediaelement/wp-mediaelement.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-includes/js/jquery/ui/jquery.ui.draggable.min.js?7f8560"></script>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-includes/js/jquery/ui/jquery.ui.droppable.min.js?7f8560"></script>
<script type='text/javascript'>
<script type='text/javascript' src="http://gpsaknowledge.org/wp-content/themes/wplms/js/custom.js?7f8560"></script>
    <script type="text/javascript">
	nb_lightbox = true;
	nb_touchswipe = true;
	nb_min_news_h = 150;
	nb_min_news_w = 200;
	nb_min_horiz_w = 400;
	nb_read_more_txt = "..";
	nb_fb_share_fix = "http://gpsaknowledge.org/wp-content/plugins/news-box-wp/lcis_fb_img_fix.php";
	nb_script_basepath = "http://gpsaknowledge.org/wp-content/plugins/news-box-wp/js/nb/";
	
	nb_short_d_names = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
	nb_full_d_names = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
	nb_short_m_names = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	nb_full_m_names = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
	nb_elapsed_names = ["ago", "seconds", "minute", "minutes", "hour", "hours", "day", "days", "week", "weeks", "month", "months"];
	
		if( typeof(lcnb_loaded_themes) == 'undefined' ) {lcnb_loaded_themes = new Array();}
	lcnb_loaded_themes.push('wpdt');
		</script>
		<script type="text/javascript">
		(function() {
			var request, b = document.body, c = 'className', cs = 'customize-support', rcs = new RegExp('(^|\\s+)(no-)?'+cs+'(\\s+|$)');

			request = true;

			b[c] = b[c].replace( rcs, ' ' );
			b[c] += ( window.postMessage && request ? ' ' : ' no-' ) + cs;
		}());
	</script>

<?php
endwhile;
endif; 
?>

<?php
get_footer();
?>