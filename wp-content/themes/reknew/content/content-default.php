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
<?php 	if (function_exists('wp_gdsr_render_review')) { wp_gdsr_render_review(get_the_ID(), 16, 'oxygen', 12); } ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
	<div class="header">
		<h1 class="title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h1>
		<time class="datetime" datetime="<?php echo get_the_date('Y-m-dTH:i'); ?>">
			<span class="day"><?php echo get_the_date('d'); ?></span>
			<span class="month"><?php echo get_the_date('M'); ?></span>
			<span class="year"><?php echo get_the_date('Y'); ?></span>
		</time>
		<div class="byline">
			Posted By: <?php the_author_posts_link(); ?>
			<?php rk_render_star_rating(); ?>
		</div>
	</div>
	<div class="body">
		<?php the_post_thumbnail('post'); ?>
		<div class="content">
			<?php the_content(); ?>
		</div>
	</div>
	<div class="footer clearfix">
		<?php 
			the_tags('<div class="tags">', ' <span class="sep">|</span> ', '</div>');
			cfct_misc('nav-post');
		?>
	</div>
	<?php cfct_misc('nav-social-post'); ?>
</article><!-- .post -->