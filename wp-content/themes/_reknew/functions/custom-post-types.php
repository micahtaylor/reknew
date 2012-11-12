<?php

function register_post_type_carousel_slide() {

	/**
	 * Register a custom post type
	 * 
	 * Supplied is a "reasonable" list of defaults
	 * @see register_post_type for full list of options for register_post_type
	 * @see add_post_type_support for full descriptions of 'supports' options
	 * @see get_post_type_capabilities for full list of available fine grained capabilities that are supported
	 */
	
	$labels = array(
		'menu_name' => 'Carousel',
		'name' => 'Slides',
		'singular_name' => 'Slide',
		'add_new' => 'Add Slide',
		'add_new_item' => 'Add New Slide',
	);
	register_post_type('car-slide', array( 
		'labels' => $labels,
		'description' => __('Slides for the Ca', 'rk'),
		'public' => true,
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'hierarchical' => false,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
		),
	));
}
add_action('init', 'register_post_type_carousel_slide');