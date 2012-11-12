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
<section id="page-<?php the_ID(); ?>" <?php post_class('post post-page'); ?>>
	<div class="header">
		<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
	</div>
	<div class="body">
		<div class="content">
			<?php the_content(); ?>
		</div>
	</div>
</section><!-- .page -->