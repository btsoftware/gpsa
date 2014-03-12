<?php

if(function_exists('bp_loggedin_user_link') && is_user_logged_in()) {	
	if(isset($_GET["page"]) and isset($_GET["title"])) {
		die(var_dump($_GET));
		
		global $wp;
		$current_url = add_query_arg($wp->query_string, '', home_url( $wp->request ));
		$current_url = explode("add-bookmark/", $current_url);
		$current_url = $current_url[1];
		$id_user     = bp_member_user_id();
		
		die(var_dump($current_url));
		$wpdb->insert('bookmarks', array('id_user' => $id_user, 'value' => $current_url));
	} else {
		header('Location: '. home_url());
		exit();
	}
}
