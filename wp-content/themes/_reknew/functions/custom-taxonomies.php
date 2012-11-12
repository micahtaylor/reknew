<?php

// Locations
$labels = array(
	'name' => _x( 'Media', 'taxonomy general name' ),
	'singular_name' => _x( 'Media', 'taxonomy singular name' ),
	'search_items' =>  __( 'Search Media' ),
	'all_items' => __( 'All Media' ),
	'parent_item' => __( 'Parent Media' ),
	'parent_item_colon' => __( 'Parent Media:' ),
	'edit_item' => __( 'Edit Media' ), 
	'update_item' => __( 'Update Media' ),
	'add_new_item' => __( 'Add New Media' ),
	'new_item_name' => __( 'New Media Name' ),
	'menu_name' => __( 'Media' ),
); 	
register_taxonomy(
	'media',
	array('post'), 
	array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
));