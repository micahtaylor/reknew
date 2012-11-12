<?php

// This file is part of the Carrington Blog Theme for WordPress
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

if (function_exists('register_sidebar')) {
	$default_args = array(
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div></aside>',
			'before_title' => '<div class="header"><h3 class="widget-title">',
			'after_title' => '</h3></div><div class="body"><div class="body-interior">'
	);
	register_sidebar(
		array_merge( array('name' => 'Primary Sidebar'), $default_args )
	);
	register_sidebar(
		array_merge( array('name' => 'Footer'), $default_args )
	);
}