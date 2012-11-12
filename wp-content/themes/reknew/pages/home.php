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

get_header();
?>
<div class="col col-ab">
	<div class="page-header">
		<h1 class="page-title">What&rsquo;s New</h1>
	</div>
	
	<?php cfct_template_file('loop', 'custom-front'); ?>
	<a href="blog">see more posts</a>
</div>
<div class="col col-c">
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>