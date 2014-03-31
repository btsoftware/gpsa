<?php
get_header();

if ( have_posts() ) : while ( have_posts() ) : the_post();
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
                    if(isset($breadcrumbs) && $breadcrumbs !='' && $breadcrumbs !='H'){
                        vibe_breadcrumbs();
                    }    
                    
                    $data["name"] = get_post_meta($post->ID, 'Name', true);
                ?>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        
        <div class="row">
            <div class="col-md-9 col-sm-8">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="content">
                    <div class="bp-widget wp-profile">
						
						<h4><?php echo $data["name"];?></h4>

						<table class="wp-profile-fields">

							<?php if ( $ud->display_name ) : ?>

								<tr id="wp_displayname">
									<td class="label"><?php _e( 'Name', 'vibe' ); ?></td>
									<td class="data"><?php echo $ud->display_name; ?></td>
								</tr>

							<?php endif; ?>

							<?php if ( $ud->user_description ) : ?>

								<tr id="wp_desc">
									<td class="label"><?php _e( 'About Me', 'vibe' ); ?></td>
									<td class="data"><?php echo $ud->user_description; ?></td>
								</tr>

							<?php endif; ?>

							<?php if ( $ud->user_url ) : ?>

								<tr id="wp_website">
									<td class="label"><?php _e( 'Website', 'vibe' ); ?></td>
									<td class="data"><?php echo make_clickable( $ud->user_url ); ?></td>
								</tr>

							<?php endif; ?>

							<?php if ( $ud->jabber ) : ?>

								<tr id="wp_jabber">
									<td class="label"><?php _e( 'Jabber', 'vibe' ); ?></td>
									<td class="data"><?php echo $ud->jabber; ?></td>
								</tr>

							<?php endif; ?>

							<?php if ( $ud->aim ) : ?>

								<tr id="wp_aim">
									<td class="label"><?php _e( 'AOL Messenger', 'vibe' ); ?></td>
									<td class="data"><?php echo $ud->aim; ?></td>
								</tr>

							<?php endif; ?>

							<?php if ( $ud->yim ) : ?>

								<tr id="wp_yim">
									<td class="label"><?php _e( 'Yahoo Messenger', 'vibe' ); ?></td>
									<td class="data"><?php echo $ud->yim; ?></td>
								</tr>

							<?php endif; ?>
						<?php endwhile;?>
						</table>
					</div>
                </div>
            </div>
            
            <div class="col-md-3 col-sm-3">
                <div class="sidebar">
                    <?php
                    $sidebar=getPostMeta($post->ID,'vibe_sidebar');
                    ((isset($sidebar) && $sidebar)?$sidebar:$sidebar='mainsidebar');
                    if ( !function_exists('dynamic_sidebar')|| !dynamic_sidebar($sidebar) ) : ?>
                   <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<?php

endif;

get_footer();
