<?php
add_action( 'wp_enqueue_scripts', 'cariera_child_enqueue_scripts', 20 );
function cariera_child_enqueue_scripts() {
	wp_enqueue_style( 'cariera-child-style', get_stylesheet_uri() );
}