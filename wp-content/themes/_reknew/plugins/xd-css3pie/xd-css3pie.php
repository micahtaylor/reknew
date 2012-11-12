<?php
define('XD_PIE_DIR',trailingslashit(realpath(dirname(__FILE__))));

include('classes/class.admin.php');

wp_enqueue_style('xd-pie-htc', '?xd_action=xd_pie_htc', array('jquery'), THEME_VERSION);

function xd_css3pie() {
	CSS3PieStyle::get(get_bloginfo('template_url').'?xd_action=xd_pie_htc');
}
add_action('wp_head', 'xd_css3pie');


// Request Handler
function xd_gfr_request_handler() {
	if (!empty($_GET['xd_action'])) {
		
		switch ($_GET['xd_action']) {
			case 'xd_pie_htc':
				xd_gfr_htc();
				break;
		}
		die();
	}
}
add_action('init', 'xd_gfr_request_handler', 1);

// Requests
function xd_gfr_htc() {
	header( 'Content-type: text/x-component' );
	echo file_get_contents(XD_PIE_DIR.'assets/PIE.htc');
}


