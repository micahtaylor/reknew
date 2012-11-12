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
if (CFCT_DEBUG) { cfct_banner(__FILE__); }

?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" dir="ltr" lang="en-US"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" dir="ltr" lang="en-US"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" dir="ltr" lang="en-US"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title><?php wp_title( '-', true, 'right' ); echo esc_html( get_bloginfo('name') ); ?></title>

	<meta name="description" content="">
	<meta name="author" content="">
	<!-- <meta name="viewport" content="width=device-width,initial-scale=1"> -->

	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url') ?>" title="<?php esc_attr(printf( __( '%s latest posts', 'rk' ), get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php esc_attr(printf( __( '%s latest comments', 'rk' ), get_bloginfo('name'), 1 ) ) ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url') ?>" />
	<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />

	<?php wp_get_archives('type=monthly&format=link'); ?>
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url') ?>/assets/main/js/lib/jquery-cycle.js" type="text/javascript"></script>
	<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
	<div id="page">
		<div class="in">
			<header id="header">
				<div id="header-interior">
					<h1 id="site-name"><a id="site-logo" class="imr" href="/">ReKnew</a></h1>
					<?php cfct_form('search'); ?>
				</div><!-- #header-interior -->

				<?php $args = array(
						'theme_location'  => 'nav-main',
						'menu'       		=> 'main', 
						'container'       => 'nav', 
						'container_id'    => 'nav-main',
						'depth'			  => 1,
						'menu_class'      => 'nav', 
						'link_before'     => '<span>',
						'link_after'      => '</span>',
						'echo'            => true,
					);
					if ( in_array(cfct_context(), array('front')) ) {
						$args['depth'] = 1;
					}
					wp_nav_menu( $args );
					echo rk_get_submenu();
					
					if ( !in_array(cfct_context(), array('front')) ) {
						cfct_misc('breadcrumbs');
					}
					if ( in_array(cfct_context(), array('front')) ) {
						 cfct_misc('masthead');
					}
				?>
			</header>
			<div id="main" role="main">