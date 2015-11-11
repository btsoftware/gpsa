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

                <?php
                        $prenex=get_post_meta(get_the_ID(),'vibe_prev_next',true);
                        if(isset($prenex) && $prenex !='' && $prenex !='H'){
                    ?>
                    <div class="prev_next_links">
                        <ul class="prev_next">
                            <?php 
                            echo '<li>';previous_post_link('<strong class="prev">%link</strong>'); 
                            echo '</li><li> | </li><li>';
                            next_post_link('<strong class="next">%link</strong>');
                            echo '</li>';
                            ?>
                        </ul>    
                    </div>
                    <?php
                        }
                    ?>
                </div>
                 <div class="col-md-9 col-sm-9 trayectoria-top">
                        <div class="row autor-trayectoria">
                              <div class="col-md-2"><?php echo get_post_meta($post->ID, 'imagen_author-post', true); ?></div>
                              <div class="col-md-10">la info</div>
                         </div>
                 </div>
             <div class="col-md-3 col-sm-3 blogPost">
                <div class="sidebar">
                    <?php
                    $sidebar = apply_filters('wplms_sidebar','BlogpostSidebar',get_the_ID());
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) : ?>
                    <?php endif; ?>
                </div>               
                <?php
                $author = getPostMeta($post->ID,'vibe_author',true);
                if(isset($author) && $author && $author !='H'){?>
                <div class="postauthor">
                    <div class="auth_image">
                        <?php
                            echo get_avatar( get_the_author_meta('email'), '80');
                         ?>
                    </div>
                    <div class="author_info">
                        <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="readmore link">Courses from <?php the_author_meta( 'display_name' ); ?></a>
                        <h6><?php the_author_meta( 'display_name' ); ?></h6>
                        <div class="author_desc">
                             <?php  the_author_meta( 'description' );?>

                             <p class="website">Website : <a href="<?php  the_author_meta( 'url' );?>" target="_blank"><?php  the_author_meta( 'url' );?></a></p>
                                     <?php
                            $author_id=  get_the_author_meta('ID');
                            vibe_author_social_icons($author_id);
                        ?>  
                            
                        </div>     
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