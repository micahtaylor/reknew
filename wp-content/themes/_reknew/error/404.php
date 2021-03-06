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
	<section <?php post_class(); ?>>
		<h1 class="section-title">Page Not Found</h1>
		<?php _e('Sorry, we\'re not sure what you\'re looking for here.', 'rk');  ?>
	</section>
	<?php cfct_loop(); ?>
</div>
<div class="col col-c">
	<?php get_sidebar(); ?>
</div>	
<?php get_footer(); ?>