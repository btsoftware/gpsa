<?php

/**
 * Template Name: BuddyPress - Activity Directory
 *
 * @package BuddyPress
 * @subpackage Theme
 */

$flag=1;
$activity_view=vibe_get_option('activity_view');

if(isset($activity_view) && $activity_view){
	$flag=0;
	switch($activity_view){
		case 1:
			if(is_user_logged_in())$flag=1;
		break;
		case 2:
			if(current_user_can('edit_posts'))$flag=1;
		break;
		case 3:
			if(current_user_can('manage_options'))$flag=1;
		break;
	}
}
if(!$flag){
	$id=vibe_get_option('activity_redirect');
	if(isset($id))
	wp_redirect(get_permalink($id));
	exit();
}

get_header( 'buddypress' ); ?>

<?php do_action( 'bp_before_directory_activity_page' ); ?>
<section id="activitytitle">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="pagetitle">
                    <h1><?php the_title(); ?></h1>
                    <h5><?php the_sub_title(); ?></h5>
                </div>
            </div>
        </div>
    </div>
</section>
<section id="content">
	<div id="buddypress">
	    <div class="container">
	    	<div class="padder">
	    	<div class="row">
	    		<div class="col-md-9 col-sm-9">
	    			<?php do_action( 'template_notices' ); ?>

					<?php do_action( 'bp_before_directory_activity' ); ?>
					
					<?php do_action( 'bp_before_directory_activity_content' ); ?>

					<?php if ( is_user_logged_in() ) : ?>
						<div id="activityform">
					<?php locate_template( array( 'activity/post-form.php'), true ); ?>
						</div>
					<?php endif; ?>
				

					<div id="members-activity">	
						<div class="item-list-tabs activity-type-tabs" role="navigation">
							<ul>
								<?php do_action( 'bp_before_activity_type_tab_all' ); ?>

								<li class="selected" id="activity-all"><a href="<?php bp_activity_directory_permalink(); ?>" title="<?php _e( 'The public activity for everyone on this site.', 'vibe' ); ?>"><?php printf( __( 'All Members <span>%s</span>', 'vibe' ), bp_get_total_member_count() ); ?></a></li>

								<?php if ( is_user_logged_in() ) : ?>

									<?php do_action( 'bp_before_activity_type_tab_friends' ); ?>

									<?php if ( bp_is_active( 'friends' ) ) : ?>

										<?php if ( bp_get_total_friend_count( bp_loggedin_user_id() ) ) : ?>

											<li id="activity-friends"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_friends_slug() . '/'; ?>" title="<?php _e( 'The activity of my friends only.', 'vibe' ); ?>"><?php printf( __( 'My Friends <span>%s</span>', 'vibe' ), bp_get_total_friend_count( bp_loggedin_user_id() ) ); ?></a></li>

										<?php endif; ?>

									<?php endif; ?>

									<?php do_action( 'bp_before_activity_type_tab_groups' ); ?>

									<?php if ( bp_is_active( 'groups' ) ) : ?>

										<?php if ( bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ) : ?>

											<li id="activity-groups"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/' . bp_get_groups_slug() . '/'; ?>" title="<?php _e( 'The activity of groups I am a member of.', 'vibe' ); ?>"><?php printf( __( 'My Groups <span>%s</span>', 'vibe' ), bp_get_total_group_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

										<?php endif; ?>

									<?php endif; ?>

									<?php do_action( 'bp_before_activity_type_tab_favorites' ); ?>

									<?php if ( bp_get_total_favorite_count_for_user( bp_loggedin_user_id() ) ) : ?>

										<li id="activity-favorites"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/favorites/'; ?>" title="<?php _e( "The activity I've marked as a favorite.", 'vibe' ); ?>"><?php printf( __( 'My Favorites <span>%s</span>', 'vibe' ), bp_get_total_favorite_count_for_user( bp_loggedin_user_id() ) ); ?></a></li>

									<?php endif; ?>

									<?php if ( bp_activity_do_mentions() ) : ?>

										<?php do_action( 'bp_before_activity_type_tab_mentions' ); ?>

										<li id="activity-mentions"><a href="<?php echo bp_loggedin_user_domain() . bp_get_activity_slug() . '/mentions/'; ?>" title="<?php _e( 'Activity that I have been mentioned in.', 'vibe' ); ?>"><?php _e( 'Mentions', 'vibe' ); ?><?php if ( bp_get_total_mention_count_for_user( bp_loggedin_user_id() ) ) : ?> <strong><span><?php printf( _nx( '%s new', '%s new', bp_get_total_mention_count_for_user( bp_loggedin_user_id() ), 'Number of new activity mentions', 'vibe' ), bp_get_total_mention_count_for_user( bp_loggedin_user_id() ) ); ?></span></strong><?php endif; ?></a></li>

									<?php endif; ?>

								<?php endif; ?>

								<?php do_action( 'bp_activity_type_tabs' ); ?>
							</ul>
						</div><!-- .item-list-tabs -->
					</div>			
			
					<div id="content" class="activity_content" role="main">
						<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
							<ul>
								<li class="feed"><a href="<?php bp_sitewide_activity_feed_link(); ?>" title="<?php _e( 'RSS Feed', 'vibe' ); ?>"><?php _e( 'RSS', 'vibe' ); ?></a></li>

								<?php do_action( 'bp_activity_syndication_options' ); ?>

								<li id="activity-filter-select" class="last">
									<label for="activity-filter-by"><?php _e( 'Show:', 'vibe' ); ?></label>
									<select id="activity-filter-by">
										<option value="-1"><?php _e( 'Everything', 'vibe' ); ?></option>
										<option value="activity_update"><?php _e( 'Updates', 'vibe' ); ?></option>

										<?php if ( bp_is_active( 'blogs' ) ) : ?>

											<option value="new_blog_post"><?php _e( 'Posts', 'vibe' ); ?></option>
											<option value="new_blog_comment"><?php _e( 'Comments', 'vibe' ); ?></option>

										<?php endif; ?>

										<?php if ( bp_is_active( 'forums' ) ) : ?>

											<option value="new_forum_topic"><?php _e( 'Forum Topics', 'vibe' ); ?></option>
											<option value="new_forum_post"><?php _e( 'Forum Replies', 'vibe' ); ?></option>

										<?php endif; ?>

										<?php if ( bp_is_active( 'groups' ) ) : ?>

											<option value="created_group"><?php _e( 'New Groups', 'vibe' ); ?></option>
											<option value="joined_group"><?php _e( 'Group Memberships', 'vibe' ); ?></option>

										<?php endif; ?>

										<?php if ( bp_is_active( 'friends' ) ) : ?>

											<option value="friendship_accepted,friendship_created"><?php _e( 'Friendships', 'vibe' ); ?></option>

										<?php endif; ?>

										<option value="new_member"><?php _e( 'New Members', 'vibe' ); ?></option>

										<?php do_action( 'bp_activity_filter_options' ); ?>

									</select>
								</li>
							</ul>
						</div><!-- .item-list-tabs -->

					<?php do_action( 'bp_before_directory_activity_list' ); ?>

						<div class="activity" role="main">

						<?php locate_template( array( 'activity/activity-loop.php' ), true ); ?>

						</div><!-- .activity -->

					<?php do_action( 'bp_after_directory_activity_list' ); ?>

					<?php do_action( 'bp_directory_activity_content' ); ?>

					<?php do_action( 'bp_after_directory_activity_content' ); ?>

					<?php do_action( 'bp_after_directory_activity' ); ?>

					</div>
				</div>	
				<div class="col-md-3 col-sm-3">
					<?php get_sidebar( 'buddypress' ); ?>
				</div>
			</div>
		</div><!-- .padder -->
		
		<!-- Map Roster of practitioners -->
			<?php getMap();?>
		<!-- End Map Roster of practitioners -->
		
	</div><!-- #content -->

	<?php do_action( 'bp_after_directory_activity_page' ); ?>
</div>
</section>

<?php get_footer( 'buddypress' ); ?>
<div id="dialog-call-to-action" title="Sign up!"><p>The GPSA Knowledge Platform offers a great diversity of learning, sharing and networking activities.<br/>All these activities are free of charge and open to everyone.<br/>However, to participate you need be registered. <a href="http://gpsaknowledge.org/register/" title="Create an account"><strong>Click here to create your own account</strong></a></p></div><link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"><script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>jQuery(function() {jQuery( "#dialog-call-to-action" ).dialog({autoOpen: false,show: {effect: "blind",duration: 1000},hide: {effect: "explode",duration: 1000}}); jQuery("#dialog-call-to-action").dialog("open");});</script>
