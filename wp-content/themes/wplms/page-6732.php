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

    $v_add_content = get_post_meta( $post->ID, '_add_content', true );
 
?>
<?php 
removeimages(); 

add_filter( 'bp_activity_excerpt_length', 'cc_custom_excerpt_length' );
add_filter( 'bp_activity_excerpt_append_text', 'cc_excerpt_append_text' );


?>
<?php //quientado encuesta getSurvey(); ?>
<section id="content"> 
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="<?php echo $v_add_content;?> content">
                    <?php
                        the_content();
                     ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="second-content">
        <div class="container">
             <div class="row">
                  <div class="col-md-12">
		          <div class="v_module v_column col-md-4 col-sm-4 v_first">
                                <!-- webinars -->
                                <div class="block_home" style="margin-top: 50px;">
								<?php $args = array( 'post_type' => 'Story', 'posts_per_page' => 5 );?>

                                <?php $service_query = new WP_Query($args);
                                while ( $service_query->have_posts() ) : $service_query->the_post(); 
								the_title();
								echo '<div class="entry-content">';
								the_content();
								echo '</div>';
								endwhile;
								?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                                         <div class="animate zoom load">
                                             <h4 class="bloque_title">
						<a class="" href="/event-type/webinars/"><?php the_title(); ?></a> </h4>  
                                                <a href="/event-type/webinars/"><img class="th_home"  <?php echo get_the_post_thumbnail(); ?></a>                                                                                  
                                                 </div> 	<!-- end .post-thumbnail -->					
                                                 <div class="block_info">						
                                                     <?php the_content(); ?>
                                                  </div> 	<!-- end .post_content -->                                                                                  
                                                <a class="more" href="/event-type/webinars/"><span>Read more</span></a>
			            </article> <!-- end .entry -->
                                 <?php endwhile; // end of the loop. ?>
                                </div>
			  </div>
			  <div class="v_module v_column col-md-4 col-sm-4">
			    <!-- forums -->
			     <div class="block_home" style="margin-top: 50px;">
			      <?php $service_query = new WP_Query('page_id=182');
			      while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
				 <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
			     
					 <div class="animate zoom load">
					 <h4 class="bloque_title"><a class="" href="http://gpsaknowledge.org/tell-your-story"><?php the_title(); ?></a> </h4>  
					 <a href="http://gpsaknowledge.org/tell-your-story"><img class="th_home"  <?php echo get_the_post_thumbnail(); ?></a>                                                                                  
					 </div> 	<!-- end .post-thumbnail -->					
					 <div class="block_info">						
						 <?php the_content(); ?>
					 </div> 	<!-- end .post_content -->                                                                                  
					  <a class="more" href="http://gpsaknowledge.org/tell-your-story"><span>Read more</span></a>

				 </article> <!-- end .entry -->
				 <?php endwhile; // end of the loop. ?>
			      </div>
			  </div>
			  <div class="v_module v_column col-md-4 col-sm-4">
			    <!-- blog -->
			    <div class="block_home" style="margin-top: 50px;">
			    <?php $service_query = new WP_Query('page_id=178');
			    while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
			       <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
			   
				       <div class="animate zoom load">
				       <h4 class="bloque_title"><a class="" href="http://gpsaknowledge.org/category/blog/"><?php the_title(); ?></a> </h4>  
				       <a href="http://gpsaknowledge.org/category/blog/"><img class="th_home"  <?php echo get_the_post_thumbnail(); ?></a>                                                                                 
				       </div> 	<!-- end .post-thumbnail -->					
				       <div class="block_info">						
					       <?php the_content(); ?>
				       </div> 	<!-- end .post_content -->                                                                                  

					<a class="more" href="http://gpsaknowledge.org/category/blog/"><span>Read more</span></a>

			       </article> <!-- end .entry -->
			       <?php endwhile; // end of the loop. ?>
			       
			         <?php
                                                        endwhile;
                                                        endif;
                                                        ?> 
			    </div>  
			  </div>
		  </div>
	     </div>
	</div>
</section>
<!-- third home -->
<section id="content" style="background: none repeat scroll 0% 0% rgb(255, 255, 255);">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-8">
                    <div id="networking-home"class="content" style="padding: 0px ! important; margin-top: 18px ! important;">
				<!--Inicio Networking -->				     
				<h2 class="logos_title"><a class="" href="http://gpsaknowledge.org/networking/">Networking Board</a> </h2>
				<div class="block_networking">
					     <?php if ( bp_has_activities( bp_ajax_querystring( 'activity' ) . '&action=activity_update' .'&max=4') ) : ?>
																	     
						     <?php while ( bp_activities() ) : bp_the_activity(); ?>
						     <?php locate_template( array( 'activity/entry2.php' ), true, false ); ?>
						     <?php endwhile; ?>
						     <?php endif; ?>
				</div>
				    
				<!-- Fin de Networking -->
				<!--Inicio carrusel -->
                                <?php $service_query = new WP_Query('page_id=813');
                                while ( $service_query->have_posts() ) : $service_query->the_post(); ?>
                               <article id="post-<?php the_ID(); ?>" <?php post_class(''); ?>>
                                     <h2 class="logos_title "><?php the_title(); ?></h4>                                                                  				
                                     <div><?php the_content(); ?></div><!-- end .post_content -->                                                                                                                                                         
                                </article> <!-- end .entry -->
                                <?php endwhile; // end of the loop. ?>                       
                                <!-- fin carrusel logos ongs -->  				                                                                                             
                     </div>        														
            </div><!--fin colummna derecha -->
            <div class="col-md-3 col-sm-4">
			<div class="sidebar">
				<?php 
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar('homesidebar') ) : ?>
                <?php endif; ?>
			</div>
            </div>
        </div>
    </div>
</section>
<?php
?>
</div>

<?php
get_footer();
?>