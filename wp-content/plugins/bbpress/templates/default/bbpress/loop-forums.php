<?php

/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<br/><br/><br/>
<p><h3>Welcome to the GPSA Knowledge Platform Forums!</h3></p>
<br/><br/><br/><p>This section offers users the opportunity to interact and exchange knowledge and lessons<br/> learned on selected social accountability issues through two types of online forums:</p><br/>

<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">

	<li class="bbp-header">

		<ul class="forum-titles">
			<li class="bbp-forum-info"><?php _e( 'Forum', 'bbpress' ); ?></li>
			<li class="bbp-forum-topic-count"><?php _e( 'Topics', 'bbpress' ); ?></li>
			<li class="bbp-forum-reply-count"><?php bbp_show_lead_topic() ? _e( 'Replies', 'bbpress' ) : _e( 'Posts', 'bbpress' ); ?></li>
			<li class="bbp-forum-freshness"><?php _e( 'Freshness', 'bbpress' ); ?></li>
		</ul>

	</li><!-- .bbp-header -->

	<li class="bbp-body">

		<?php while ( bbp_forums() ) : bbp_the_forum(); ?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</li><!-- .bbp-body -->

	<li class="bbp-footer">

		<div class="tr">
			<p class="td colspan4">&nbsp;</p>
		</div><!-- .tr -->

	</li><!-- .bbp-footer -->

</ul><!-- .forums-directory -->

<!-- Dialog! -->
<div id="dialog-call-to-action" title="Sign up!"><p>The GPSA Knowledge Platform offers a great diversity of learning, sharing and networking activities.<br/>All these activities are free of charge and open to everyone.<br/>However, to participate you need be registered. <a href="http://gpsaknowledge.org/register/" title="Create an account"><strong>Click here to create your own account</strong></a></p></div><link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css"><script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script><script>jQuery(function() {jQuery( "#dialog-call-to-action" ).dialog({autoOpen: false,show: {effect: "blind",duration: 1000},hide: {effect: "explode",duration: 1000}}); jQuery("#dialog-call-to-action").dialog("open");});</script>
<!-- Dialog! -->

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
