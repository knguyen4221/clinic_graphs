<?php
/*
 * Template Name: graph
 * Template Post Type: post, page, product
 */
  
 get_header();  ?>
 <html>
 	<head>
 		<script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
	</head>
	<?php echo get_post_meta($post->ID, 'spec_js', true); ?>
 </html>