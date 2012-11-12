<?php

// This file is part of the Carrington JAM Theme for WordPress
// http://carringtontheme.com
//
// Copyright (c) 2008-2010 Crowd Favorite, Ltd. All rights reserved.
// http://crowdfavorite.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

load_theme_textdomain('rk');

define('CFCT_DEBUG', false);
define('CFCT_PATH', trailingslashit(TEMPLATEPATH));
define('THEME_VERSION', '1.0');
define('CFCT_IS_PRODUCTION', false);

include_once(CFCT_PATH.'carrington-core/carrington.php');
include_once(CFCT_PATH.'functions/custom-post-types.php');
include_once(CFCT_PATH.'functions/custom-taxonomies.php');
include_once(CFCT_PATH.'functions/sidebars.php');
include_once(CFCT_PATH.'functions/class-walker-nav-main.php');
include_once(CFCT_PATH.'functions/gravity-forms.php');

// WordPress menus 
$nav_locations = array(
	'nav-main' => 'Main Navigation',
	'nav-sub' => 'Sub Navigation',
	'nav-footer' => 'Footer Navigation',
);
register_nav_menus( $nav_locations );

// Post Thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size( 'carousel', 930, 326, true );
add_image_size( 'category', 295, 240, true );
add_image_size( 'post', 560, 292, true );
add_image_size( 'post-excerpt', 324, 268, true );


/**
 * Theme Setup
 */
function cfct_theme_setup() {
	if(!is_admin()) {
		// Enqueue Styles
		wp_enqueue_style('css_main_fonts', get_bloginfo('template_url') . '/assets/main/css/fonts.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_base', get_bloginfo('template_url') . '/assets/main/css/base.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_utility', get_bloginfo('template_url') . '/assets/main/css/utility.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_grid', get_bloginfo('template_url') . '/assets/main/css/grid.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_3d', get_bloginfo('template_url') . '/assets/main/css/3d.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_typography', get_bloginfo('template_url') . '/assets/main/css/typography.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_structure', get_bloginfo('template_url') . '/assets/main/css/structure.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_content', get_bloginfo('template_url') . '/assets/main/css/content.css', array(), THEME_VERSION);
		wp_enqueue_style('css_main_rating', get_bloginfo('template_url') . '/assets/main/css/rating.css', array(), THEME_VERSION);

		// Enqueue Scripts
		wp_enqueue_script('modernizr', get_bloginfo('template_url') . '/assets/main/js/lib/modernizr.js', array(), THEME_VERSION);
		wp_enqueue_script('jquery-placeholder', get_bloginfo('template_url') . '/assets/main/js/lib/jquery-placeholder.js', array(), THEME_VERSION);
		wp_enqueue_script('jquery-cycle', get_bloginfo('template_url') . '/assets/main/js/lib/jquery-cycle.js', array(), THEME_VERSION);
		wp_enqueue_script('script_main', get_bloginfo('template_url') . '/assets/main/js/script.js', array(), THEME_VERSION);

		// Threaded Comments
		if ( is_singular() ) { wp_enqueue_script( 'comment-reply' ); }
	}
}
add_action( 'init', 'cfct_theme_setup' );

function rk_css3pie() {
	cfct_misc('css3pie');
}
add_action( 'wp_head', 'rk_css3pie' );

function rk_analytics() {
	echo cfct_get_option('ga');
}
add_action( 'wp_footer', 'rk_analytics' );

function rk_shareThis() {
?>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher:'<?php echo cfct_get_option('share-this-key'); ?>'});</script>
<?php
}
//add_action( 'wp_head', 'rk_shareThis' );

if(!CFCT_IS_PRODUCTION) {
	function rk_disqus_developer() {
	?>
		<script type="text/javascript">
			var disqus_developer = 1; // developer mode is on
		</script>
	<?php
	}
	add_action( 'wp_head', 'rk_disqus_developer', 1 );
}


/**
 * Filters
 */

// Customize Theme Settings Titles
function rk_get_theme_settings_title () {
	return "ReKnew Theme Settings";
}
add_filter('cfct_admin_settings_title', 'rk_get_theme_settings_title');
add_filter('cfct_admin_settings_form_title', 'rk_get_theme_settings_title');

function rk_get_theme_settings_title_menu () {
	return "ReKnew Settings";
}
add_filter('cfct_admin_settings_menu','rk_get_theme_settings_title_menu');

// Customize Theme Setting Options
function rk_get_theme_settings_options () {
	$cfct_options = array(
		'cfct' => array(
			'label' => '',
			//This is a callback, use cfct_options_blank to display nothing
			'description' => 'cfct_options_blank',
			'fields' => array(
				'share-this-key' => array(
					'type' => 'text',
					'label' => __('ShareThis Key', 'rk'),
					'name' => 'share-this-key',
					'class' => 'cfct-text-long',
				),
				'topics-limit' => array(
					'type' => 'text',
					'label' => __('Topics Limit', 'rk'),
					'name' => 'topics-limit',
					'class' => 'cfct-text-short',
				),
				'ga' => array(
					'type' => 'textarea',
					'label' => __('Google Analytics', 'rk'),
					'name' => 'ga',
					'class' => 'cfct-text-long',
				),
			),
		),
	);
	return $cfct_options;
}
add_filter('cfct_options', 'rk_get_theme_settings_options');

// Modify Archive Format
function rk_set_yearly_archive($args) {
	$args['type'] = 'yearly';
	return $args;
}
add_filter('widget_archives_args', 'rk_set_yearly_archive');

function add_slug_class_to_menu_item($output){
	$ps = get_option('permalink_structure');
	if(!empty($ps)){
		$idstr = preg_match_all('/<li id="menu-item-(\d+)/', $output, $matches);
		foreach($matches[1] as $mid){
			$id = get_post_meta($mid, '_menu_item_object_id', true);
			$slug = basename(get_permalink($id));
			$output = preg_replace('/menu-item-'.$mid.'">/', 'menu-item-'.$mid.' menu-item-'.$slug.'">', $output, 1);
		}
	}
	return $output;
}
add_filter('wp_nav_menu', 'add_slug_class_to_menu_item');

// Add active state to nav menus
function cfct_additional_classes_menu ( $classes = array(), $menu_item = false ){
	if ( in_array( 'current-menu-item', $menu_item->classes ) ){
		$classes[] = 'active';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'cfct_additional_classes_menu', 10, 2 );

// Augment Body Classes
function cfct_modify_classes_body($classes) {
	global $wp_query;
	$post_obj = $wp_query->get_queried_object();
	
	// Add frontpage identifier class
	if ( cfct_context() == 'front' ) {
	    $classes[] = 'front';
	}
	
	// Add subnav identifier class
	if (rk_get_submenu() != '') {
		$classes[] = 'has-sub-menu';
	}

	// Add class for current page
	$classes[] = cfct_context().'-'.$post_obj->post_name;
	
	// Add class for ancestor page (if applicable)
	$post_ancestors = get_post_ancestors($post_obj);
	if (!empty($post_ancestors)) {
		$post_root = get_post($post_ancestors[0]);
		$classes[] = 'ancestor-'.cfct_context().'-'.$post_root->post_name;
	}
	return $classes;
}
add_filter('body_class', 'cfct_modify_classes_body');

// Add Featured Image detection in Post
function cfct_modify_classes_post($classes) {
	global $post;
	$classes[] = 'post';
	$classes[] = 'post-'.$post->post_type;

	if ( has_post_thumbnail() ) {
	    $classes[] = 'has-featured-image';
	}
	
	return $classes;
}
add_filter('post_class', 'cfct_modify_classes_post');

// Add "Read More" link to Excerpts
function cfct_excerpt_read_more($more) {
	global $post;
	return '&hellip;';
}
add_filter('excerpt_more', 'cfct_excerpt_read_more');

function rk_get_submenu() {
	$ret = '';
	
	$args = array(
		'theme_location'  => 'nav-sub',
		'menu'       		=> 'main', 
		'container'       => 'nav', 
		'container_id'    => 'nav-sub',
		'depth'			  => 2,
		'menu_class'      => 'nav', 
		'link_before'     => '<span>',
		'link_after'      => '</span>',
		'echo'            => 0,
		'walker'          => new Custom_Walker_Nav_Sub_Menu()
	);
	$subnav = wp_nav_menu( $args );

	$pos = strpos($subnav, 'class="menu-item');
	if ( $pos > 0) {
		$ret= $subnav;
	}
	return $ret;
}

function rk_render_star_rating() {
	if(xd_plugin_exists('kk_star_ratings', 'KK Star Ratings')) {
		global $post;
		echo kk_star_ratings($post->ID); 
	}
}

function xd_plugin_exists($plugin_function, $plugin_name = null) {
	if(function_exists($plugin_function)) {
		return true;
	} else {
		if($plugin_name != null) {
			echo 'Please install and activate the ' . $plugin_name . ' plugin!';
		}
		return false;
	}
	
}
