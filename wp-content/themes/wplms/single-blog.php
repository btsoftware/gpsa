<?php
/*
Template Name Posts: Blog
*/
get_header();
$page_id = get_the_ID();
?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/publicacion.css" />


<?php
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
                    <h1>Knowledge Repository</h1>
                    <h5><?php the_sub_title(); ?></h5>
                </div>
            </div>
             <div class="col-md-3 col-sm-4">
                 <?php
                    $breadcrumbs=get_post_meta(get_the_ID(),'vibe_breadcrumbs',true);
                    if(isset($breadcrumbs) && $breadcrumbs !='' && $breadcrumbs !='H'){
                        vibe_breadcrumbs();
                    }    
                ?>
            </div>
        </div>
    </div>
</section>
<?php
}
?>
<section id="content">
    <div class="container">       
        <div class="row">         
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="content top-puplicaciones ">
                    <div class="col-md-3 col-sm-3">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="featured">
                        <?php the_post_thumbnail(get_the_ID(),'full'); ?>
                    </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="publicacionpost"><h3><?php the_title(); ?></h3></div>
                        <div class="separador"></div>
                                            
                        <div class="tags">
                              <div class="inpublication"><i class="icon-user clicked left-i p12"></i><p class="autor_material"><?php echo get_post_meta($post->ID, 'publication_author', true); ?></p></div>           
    </div>                                           
                        <?php
                        }
                            the_content();
                         ?>
                        
                        <div class="adthis"><?php do_action( 'addthis_widget', get_permalink(), get_the_title(), 'small_toolbox'); ?></div>
                    </div>
                     <div class="col-md-9 col-sm-9 trayectoria-top">
                        <div class="row autor-trayectoria">
                              <div class="col-md-2"><?php echo get_post_meta($post->ID, 'imagen_author-post', true); ?></div>
                              <div class="col-md-10">la info</div>
                         </div>
                    </div>

                    <?php
                        }
                    ?>
               </div>
      
               <div class="col-md-3 col-sm-3 blogPost">
                    <div class="sidebar">
                    <?php
                    $sidebar = apply_filters('wplms_sidebar','BlogpostSidebar',get_the_ID());
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) : ?>
                    <?php endif; ?>
                    </div>                
                </div>
         
                <?php
                }              
                ;
                endwhile;
                endif;
                ?>
            </div>    
       
    </div>
</section>
<section class="stripe aboutus-3">
    <div class="container"> 
    <div class="row">
      <?php if ( function_exists( 'echo_ald_crp' ) ) echo_ald_crp(); ?> 
    </div>
    </div>
</section>
</div>

<?php
get_footer();
?>