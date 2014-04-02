<?php
/*
Template Name Posts: Publicaciones
*/
?>

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
                <div class="content top-puplicaciones">
                    <div class="col-md-3 col-sm-3">
                    <?php if(has_post_thumbnail()){ ?>
                    <div class="featured">
                        <?php the_post_thumbnail(get_the_ID(),'full'); ?>
                    </div>
                    </div>
                    <div class="col-md-9 col-sm-8">
                    <div class="publicacionpost"><h3><?php the_title(); ?></h3></div>
                    <div class="separador"></div>
                    <?php
                    }
                        the_content();

                     ?>
                     <div class="tags">
                    <?php the_tags('<ul><li>','</li><li>','</li></ul>'); ?>
                    <?php wp_link_pages('before=<div class="page-links"><ul>&link_before=<li>&link_after=</li>&after=</ul></div>'); ?>
                    </div>
                    </div>
                </div>
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
                
                <?php
                }
                
                comments_template();
                endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</section>
</div>

<?php
get_footer();
?>