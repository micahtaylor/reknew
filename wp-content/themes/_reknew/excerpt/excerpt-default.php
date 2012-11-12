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
$the_date = get_the_date();
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post post-excerpt'); ?>>
	<div class="header">
		<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		<time class="datetime" datetime="<?php echo get_the_date('Y-m-dTH:i'); ?>"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></time>
		<div class="byline">
			Posted By: <?php the_author_link(); ?>
			<?php rk_render_star_rating(); ?>	
		</div>	
		
	</div>
	<div class="body">
		<?php the_post_thumbnail('post-excerpt'); ?>
		<div class="content">
			<?php the_excerpt(); ?>
		</div>
	</div>
	<div class="footer clearfix">
		<?php the_tags('<div class="tags">', ' <span class="sep">|</span> ', '</div>') ?>
		<a class="more" href="<?php the_permalink(); ?>"><span >Read More</span>&gt;</a>
	</div>
	<?php cfct_misc('nav-social-post'); ?>
</article><!-- .excerpt -->