<?php

if(function_exists('bp_loggedin_user_link') && is_user_logged_in()) {	
	if(isset($_GET["page"]) and isset($_GET["title"])) {
		global $wp;
		global $wpdb;
		
		$current_url = $_GET["page"];
		$title       = $_GET["title"];
		$id_user     = bp_loggedin_user_id();
		
		$wpdb->insert('bookmarks', array('id_user' => $id_user, 'url' => $current_url, 'title' => $title));
		
		header('Location: '. $current_url);
		exit();
	} else {
		header('Location: '. home_url());
		exit();
	}
} else {
	header('Location: '. home_url());
	exit();
}
