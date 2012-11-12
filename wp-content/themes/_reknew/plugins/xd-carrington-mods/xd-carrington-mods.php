<?php
function xd_carrington_add_context ($context) {
	if ( is_front_page() && $context != 'home' ) { // If no Front page is explicitly set, we want the home page to be 'home'
		$context = 'front';
	}
	return $context;
}
add_filter('cfct_context', 'xd_carrington_add_context');