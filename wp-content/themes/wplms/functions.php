<?php

// Essentials
include_once 'includes/config.php';
include_once 'includes/init.php';

// Register & Functions
include_once 'includes/register.php';
include_once 'includes/func.php';


include_once 'includes/ratings.php';


// Customizer
include_once 'includes/customizer/customizer.php';
include_once 'includes/customizer/css.php';


include_once 'includes/vibe-menu.php';

include_once 'includes/author.php';

if ( function_exists('bp_get_signup_allowed')) {
    include_once 'includes/bp-custom.php';
}

include_once '_inc/ajax.php';

//Widgets
include_once('includes/widgets/custom_widgets.php');
if ( function_exists('bp_get_signup_allowed')) {
include_once('includes/widgets/custom_bp_widgets.php');
}
include_once('includes/widgets/advanced_woocommerce_widgets.php');
include_once('includes/widgets/twitter.php');
include_once('includes/widgets/flickr.php');
include_once('includes/widgets/instagram.php');

//Misc
include_once 'includes/sharing.php';
include_once 'includes/tour.php';

// Options Panel
get_template_part('vibe','options');


function bookmarks() {
	global $wp;
	
	$current_url = add_query_arg($wp->query_string, '', home_url( $wp->request ));
	$current_url = explode("?", $current_url);
	$current_url = $current_url[0];
	
	echo '<a href="' . vibe_site_url() . 'add-bookmark/' . $current_url . '">Add to favorites</a>';
}
?>
