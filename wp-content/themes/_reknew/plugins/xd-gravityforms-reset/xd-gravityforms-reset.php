<?php

/*
Plugin Name: Xylem Digital GravityForms Reset
Description: Dequeue's GravityForms' default styles and replaces it with a form reset.
Version: 0.1
Author: David Lawson
*/

/**
 * Copyright (c) 2011 Your Name. All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

define('XD_GFR_VERSION', '0.1');
define('XD_GFR_DIR',trailingslashit(realpath(dirname(__FILE__))));

// Enqueue Reset Style
function xd_gfr_setup() {
	wp_enqueue_style('xd_gfr_stylesheet', '?xd_action=xd_gfr_css');
}
add_action('init', 'xd_gfr_setup');

// Remove GravityForms Styles
function remove_gravityforms_style() {
	wp_dequeue_style('gforms_css');
}
add_action('wp_print_styles', 'remove_gravityforms_style');


// Request Handler
function xd_gfr_request_handler() {
	if (!empty($_GET['xd_action'])) {
		
		switch ($_GET['xd_action']) {
			case 'xd_gfr_css':
				xd_gfr_css();
				break;
		}
		die();
	}
}
add_action('init', 'xd_gfr_request_handler');

// Requests
function xd_gfr_css() {
	header('Content-type: text/css');
	echo file_get_contents(XD_GFR_DIR.'css/xd-gravityforms-reset.css');
}
