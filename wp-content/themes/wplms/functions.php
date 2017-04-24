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

//Misc
include_once 'includes/sharing.php';
include_once 'includes/tincan.php';

// Options Panel
get_template_part('vibe','options');

/*add bookmark*/
function bookmarks($url = false, $title = false) {
	global $wp;
	
	if($url == false) {
		$current_url = add_query_arg($wp->query_string, '', home_url($wp->request));
		$current_url = explode("?", $current_url);
		$current_url = $current_url[0];
		$title       = get_the_title();
	} else {
		$current_url = $url;
	}
	
	if(isset($_GET["msg"]) and $_GET["msg"] == "successful-bookmark") {
		echo '<span class="bookmark-successful">Bookmark added successfully</span>';
	} else {
		echo '<a class="add-bookmark" href="' . home_url() . '/add-bookmark?page=' . $current_url . '&title=' . $title . '">Add to my favorites</a>';
	}
	return true;
}

/*get bookmarks*/
function getBookmarks() {
	if(function_exists('bp_loggedin_user_link') && is_user_logged_in()) {
		echo '<h3>Bookmarks</h3>';
		
		global $wp;
		global $wpdb;
		
		$user_id = bp_loggedin_user_id();
		$myrows  = $wpdb->get_results("SELECT * FROM wp_bookmarks where user_id=$user_id order by bookmark_id desc");
		
		if($myrows) {
			echo '<ul class="ul-bookmarks">';
				foreach($myrows as $row) {
					echo '<li>';
						echo '<a href="' . $row->url . '" title="' . $row->title . '">' . $row->title . '</a>';
					echo '</li>';
				}
			echo '</ul>';
		} else {
			echo '<h2>Not bookmarks yet</h2>';
		}
	}  else {
		header('Location: '. home_url());
		exit();
	}
}

//Map of roster of practitioners
function getMap() {
	//echo "<script src='http://code.jquery.com/jquery-1.11.0.min.js'></script>";
	echo "<script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.js'></script>";
	echo "<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet'/>";
	echo "<link href='https://api.tiles.mapbox.com/mapbox.js/v1.6.2/mapbox.css' rel='stylesheet'/>";
	echo "<link href='/map/css/map-style.css' rel='stylesheet'/>";
	echo "<script src='/map/js/gpsa-rosters.geojson.js' type='text/javascript'></script>";
	
	echo "<a name='roster-of-practitioners'></a><div class='pagetitle'><h2>Roster of Experts</h2></div>";
	echo "<p class='obj'>Click on an expert to find out more about his areas of expertise, working languages, and disponibilities for short-term consultancy work.</p>";
	echo "<div id='map'><div id='themes-layers' class='layers'></div><div id='info'></div></div>";
	echo "<script src='/map/js/map-init.js' type='text/javascript'></script>";
}
					
function removeimages() {
	echo "<style>
			.bpfb_images {display: none;}
		  </style>";
	return true;
}

function cc_custom_excerpt_length() {
return '180';
}
function getSurvey() {
	echo "<style>
		#survey {
			display: block;
			height: auto;
			left: 605.5px;
			position: absolute;
			top: 180px;
			width: 455px;
			height:285px;
			left: 600;
			outline: 0 none;
			overflow: hidden;
			z-index: 100;
			border: 1px solid #ccc;
		}
		
		.border {
			border-bottom-right-radius: 4px;
			border-bottom-left-radius: 4px;
			border-top-right-radius: 4px;
			border-top-left-radius: 4px;
		}
		
		.title-survey { 
			color:#fff; 
			font-size:1.4em;
			width:100%; 
			height:95px; 
			background-color:#FF4F00; 
			border: 1px solid #FF4F00;
			position: relative;
		}
		
		.title-survey span { margin-top:20px; margin-left:20px; float:left;}
		.title-survey img { margin-top:12px; margin-left:-5px; float:left;}
		
		.content-survey {
			font-size:1.1em;
			color: #737373;
			background-color: #f1f1f1;
			height:100%;
		}
		
		.content-survey span { margin-right:20px;  margin-top:20px; margin-left:20px; float:left; }
		.content-survey span { margin-right:20px;  margin-top:20px; margin-left:20px; float:left; }
		
		#yes-survey { margin-left:155px; }
	</style>";
	
	$url_image = get_template_directory_uri() . '/images/admiracion.png';
	
	echo '<div id="survey" class="border">
		<div class="title-survey border">
		&nbsp;&nbsp;<a class="contorno-morado" href="#close">X</a>
			<span>Tell us what you think!</span>

			</div>
		<div class="content-survey">
						<span>Your feedback is very important to us! So, please give us your opinion on the GPSA Knowledge Platform and its different activities.</span>
			<a class="contorno-morado" id="yes-survey" href="https://www.surveymonkey.com/r/6YMYMC2" target="_blank">Participate </a>

			</div>
	</div>

	<script>
		jQuery(".contorno-morado").click(function () {
			jQuery("#survey").hide();
		});
	</script>';

	return true;
}

//custom category type template
function get_custom_cat_template($single_template) {
    global $post;

    if(in_category( 'expert' )) {
        $single_template = dirname( __FILE__ ) . '/single-expert.php';
    }
    
    return $single_template;
}
 
add_filter( "single_template", "get_custom_cat_template" ) ;

/*
//custom post type template
function get_custom_post_type_template($single_template) {
    global $post;
	
    if ($post->post_type == 'ajde_events') {
         $single_template = dirname( __FILE__ ) . '/single-events.php';
    }
    return $single_template;
}
 
add_filter( "single_template", "get_custom_post_type_template" ) ;
*/
//fix for cookie error while login.
/*
function set_wp_test_cookie() {
	setcookie(TEST_COOKIE, 'WP Cookie check', 0, COOKIEPATH, COOKIE_DOMAIN);
	if ( SITECOOKIEPATH != COOKIEPATH ) {
		setcookie(TEST_COOKIE, 'WP Cookie check', 0, SITECOOKIEPATH, COOKIE_DOMAIN);
	}
}
*/

add_filter( 'wp_headers', 'yourprefix_remove_x_pingback' );
function yourprefix_remove_x_pingback( $headers )
{
    unset( $headers['X-Pingback'] );
    return $headers;
}
add_action( 'after_setup_theme', 'set_wp_test_cookie', 101 );
//add button friends and message private
add_action( 'bp_member_header_actions', 'bp_add_friend_button' );
add_action( 'bp_member_header_actions', 'bp_send_private_message_button' );
function my_custom_display_topic_index_query () {
  $args['orderby'] = 'title';
  $args['order']   = 'ASC';

  return $args;
}
//add_filter('bbp_before_has_topics_parse_args', 'my_custom_display_topic_index_query' );



function recent_bbpress_topics() {  

	if ( bbp_has_topics( array( 'post_parent'=> 528, 'author' => 0, 'show_stickies' => false, 'order' => 'DESC', 'posts_per_page' => 4 , 'meta_key' => '_bbp_last_active_time' ) ) )
		bbp_get_template_part( 'bbpress/loop', 'topics' );
} 



function cc_excerpt_append_text() {
return '';
}

// Hook into action
add_action('bbp_template_after_forums_loop','recent_bbpress_topics');

/**
 * Add custom taxonomies
 * Material Type
 */
function add_custom_taxonomies() {
  // Add new "Material Type" taxonomy to Posts
  register_taxonomy('Material Type', 'post', array(
    // Hierarchical taxonomy (like categories)
    'hierarchical' => true,
    // This array of options controls the labels displayed in the WordPress Admin UI
    'labels' => array(
      'name' => _x( 'Materials', 'taxonomy general name' ),
      'singular_name' => _x( 'Material', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Materials' ),
      'all_items' => __( 'All Materials' ),
      'parent_item' => __( 'Parent Material' ),
      'parent_item_colon' => __( 'Parent Material:' ),
      'edit_item' => __( 'Edit Material' ),
      'update_item' => __( 'Update Material' ),
      'add_new_item' => __( 'Add New Material' ),
      'new_item_name' => __( 'New Material Name' ),
      'menu_name' => __( 'Materials' ),
    ),
    // Control the slugs used for this taxonomy
    'rewrite' => array(
      'slug' => 'repository', // This controls the base slug that will display before each term
      'with_front' => false, // Don't display the category base before "/locations/"
      'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );
function myplugin_cookie_expiration( $expiration, $user_id, $remember ) {
    return $remember ? $expiration : 86400;
}
add_filter( 'auth_cookie_expiration', 'myplugin_cookie_expiration', 99, 3 );

function stories_init() {
  $args = array(
    'labels' => array(
	    'name' => __( 'Stories' ),
	    'singular_name' => __( 'Story' ),
	    'add_new' => __( 'Add New Story' ),
	    'add_new_item' => __( 'Add New Story' ),
	    'edit_item' => __( 'Edit Story' ),
	    'new_item' => __( 'Add New Story' ),
	    'view_item' => __( 'View Story' ),
	    'search_items' => __( 'Search Story' ),
	    'not_found' => __( 'No stories found' ),
	    'not_found_in_trash' => __( 'No stories found in trash' )
		),
      'public' => true,
      'has_archive' => true,
      'show_ui' => true,
      'capability_type' => 'post',
      'hierarchical' => false,
      'rewrite' => array('slug' => 'stories'),
      'query_var' => true,
      'menu_position' => 5,
      'menu_icon' => 'dashicons-portfolio',
      'supports' => array(
          'title',
          'excerpt',
          'editor'
          //'custom-fields',
          //'revisions',
          //'author',
          //'page-attributes',
      )
 	);
  register_post_type( 'stories', $args );
}
add_action( 'init', 'stories_init' );

function add_events_metaboxes() {
  add_meta_box('wpt_stories_uri', 'Video', 'wpt_stories_uri', 'stories', 'normal', 'default');
  add_meta_box('wpt_stories_country', 'Country', 'wpt_stories_country', 'stories', 'normal', 'default');
}

add_action( 'add_meta_boxes', 'add_events_metaboxes' );



function wpt_stories_uri() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="storymeta_noncename" id="storymeta_noncename" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the uris data if its already been entered
	$uri = get_post_meta($post->ID, '_uri', true);
	
	// Echo out the field
	echo 'Anota solo el id del video de vimeo (https://vimeo.com/<b>158818287</b>) <br> <input type="text" name="_uri" value="' . $uri  . '" class="widefat" />';
}

function wpt_stories_country() {
	global $post;
	// Noncename needed to verify where the data originated
	echo '<input type="hidden" name="storymeta_noncename2" id="storymeta_noncename2" value="' . 
	wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	
	// Get the uris data if its already been entered
	$country = get_post_meta($post->ID, '_country', true);
	
	// Echo out the field
	echo '<input type="text" name="_country" value="' . $country  . '" class="widefat" />';
}

// Save the Metabox Data

function wpt_save_stories_meta($post_id, $post) {
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( !wp_verify_nonce( $_POST['storymeta_noncename'], plugin_basename(__FILE__) ) || 
       !wp_verify_nonce( $_POST['storymeta_noncename2'], plugin_basename(__FILE__) )    ){
      return $post->ID;
  } 

  // Is the user allowed to edit the post or page?
  if ( !current_user_can( 'edit_post', $post->ID ))
      return $post->ID;

  // OK, we're authenticated: we need to find and save the data
  // We'll put it into an array to make it easier to loop though.
  
  $events_meta['_uri'] = $_POST['_uri'];
  $events_meta['_country'] = $_POST['_country'];
  
  // Add values of $events_meta as custom fields
  
  foreach ($events_meta as $key => $value) { // Cycle through the $events_meta array!
      if( $post->post_type == 'revision' ) return; // Don't store custom data twice
      $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
      if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
          update_post_meta($post->ID, $key, $value);
      } else { // If the custom field doesn't have a value
          add_post_meta($post->ID, $key, $value);
      }
      if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
  }
}

add_action('save_post', 'wpt_save_stories_meta', 1, 2); // save the custom fields


/* Search stories by country */

// Primero incluimos nuestro archivo javascript definido anteriormente
wp_enqueue_script( 'mi-script-ajax', get_template_directory_uri() . '/assets/js/map_d3.js', array( 'jquery' ) );
  
// ahora declaramos la variable MyAjax y le pasamos el valor url (wp-admin/admin-ajax.php) al script ajax-search.js
wp_localize_script( 'mi-script-ajax', 'MyAjax', array( 'url' => admin_url( 'admin-ajax.php' ) ) );
 
//Para manejar admin-ajax tenemos que añadir estas dos acciones.
//IMPORTANTE!! Para que funcione reemplazar "buscar_posts" por vuestra action definida en ajax-search.js
 
add_action('wp_ajax_search_stories_by_country', 'search_stories_by_country_callback');
add_action('wp_ajax_nopriv_search_stories_by_country', 'search_stories_by_country_callback');
 
function search_stories_by_country_callback() {
  global $post;
  $args = array('post_type'=> 'stories', 'post_status' => 'publish' );

  $args['meta_query'][] = array(
    'key' => '_country',
    'value' =>  $_POST['country'],
    'compare' => 'LIKE',
    'posts_per_page' => 50
  );
 
  $myposts = get_posts($args);
  echo '<h1>' . $_POST['country'] . '</h1>';
  echo '<ul class="resultados">';
    foreach( $myposts as $post ) :  setup_postdata($post); ?>
      <li> 
      	<?php the_content( $more_link_text, $stripteaser ) ?>
      </li>
    <?php endforeach; 
	echo '</ul>';
  die(); // Siempre hay que terminar con die
}
//This file is needed to be able to use the wp_rss() function.
include_once(ABSPATH.WPINC.'/rss.php');

function readRss($atts) {
    extract(shortcode_atts(array(
	"feed" => 'http://',
      "num" => '2',
    ), $atts));

    return wp_rss($feed, $num);
}

add_shortcode('rss', 'readRss');

function my_deregister_javascript() 
 { 
    if ( is_page (5697) ) 
      {
        wp_deregister_script( 'jquery.touchcarousel.min.js' ); 
		wp_deregister_script( 'logos.js?ver=4.0.1' ); 

      } 
 }
add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
 