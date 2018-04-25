<?php

function add_theme_scripts(){

	wp_enqueue_style('front', get_stylesheet_directory_uri() . '/front.css');
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . "/style.css");

	//wp_deregister_script('jquery');
	//wp_enqueue_script('jquery', "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js");

	wp_enqueue_script('wpc-controller', get_stylesheet_directory_uri() . '/js/controller.js', array('jquery'));
	wp_localize_script( 'wpc-controller', 'WPC_Ajax', array( 'ajaxurl' => admin_url('admin-ajax.php')));
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts');



function wpc_post_graph(){
	include 'partials/renderGraph.php';
	$ret = renderGraph($_POST);
	echo $ret;
	wp_die();
}

function add_scriptfilter( $string ) {
	global $allowedtags;
	$allowedtags['script'] = array( 'src' => array () );
	return $string;
}

add_filter( 'pre_kses', 'add_scriptfilter' );
add_action( 'wp_ajax_nopriv_wpc_post_graph', 'wpc_post_graph' );
add_action( 'wp_ajax_wpc_post_graph', 'wpc_post_graph' );






?>