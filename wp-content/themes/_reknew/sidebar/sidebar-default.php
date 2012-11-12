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


			




<div id="sidebar">
	<div id="primary-sidebar">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) : ?>
			<aside class="widget">
				<div class="header">
					<h3 class="widget-title">Archives</h3>
				</div>
				<div class="body">
					<div class="body-interior">
						<ul>
							<?php wp_get_archives(); ?>
						</ul>
					</div>
				</div>
			</aside><!--.widget-->
			<aside class="widget">
				<div class="header">
					<h3 class="widget-title">Pages</h3>
				</div>
				<div class="body">
					<div class="body-interior">
						<ul>
							<?php wp_list_pages('title_li='); ?>
						</ul>
					</div>
				</div>
			</aside><!--.widget-->
		<?php endif; ?>
	</div><!--#primary-sidebar-->
</div><!--#sidebar-->
