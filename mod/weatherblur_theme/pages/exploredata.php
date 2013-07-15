<?php
	// Load Elgg engine
	include_once dirname(dirname(dirname(dirname(__FILE__)))) . "/engine/start.php";
	
	$title = elgg_echo('Explore Data');

	$area2 = elgg_view_title($title); 
	
	//TODO Add Explore Data stuff
	
	$body = elgg_view_layout("one_column", array('content' => $area2));

	echo elgg_view_page($title, $body);

?>