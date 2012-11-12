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

$args = array(
	'type'			=> 'post', 
	'child_of'		=> 0,
	'orderby'		=> 'name',
	'order'			=> 'ASC',
	'exclude'		=> 1, // Uncategorized
	'hide_empty'	=> 0,
	'hierarchical'	=> 1,
	'taxonomy'		=> 'category',
	'pad_counts'		=> false
);
$categories = get_categories($args);

?>
<section id="page-<?php the_ID(); ?>" <?php post_class('post post-page'); ?>>
	<ul class="cat-grid clearfix">
		<?php foreach ($categories as $cat): ?>
			<li class="cat">
				<a href="<?php echo get_category_link($cat->term_id); ?>">
					<?php
						$args = array(
							'category_name' => $cat->slug,
						);
						query_posts($args);

						$args = array(
							'image_size' => 'category',

							'attr' => array(
								'title' => '',
								'alt' => '',
								'class' => 'cat-image',
							),
						);
						print apply_filters( 'taxonomy-images-queried-term-image', '', $args);
					?>
					<h2 class="cat-title"><?php echo $cat->name; ?></h2>
				</a>
				
			</li>
			<?php 
			wp_reset_query();
		endforeach; 
		?>
	</ul>
</section>