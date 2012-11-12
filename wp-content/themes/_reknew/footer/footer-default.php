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
			</div><!-- #main -->
		</div><!-- .in -->

		<footer id="footer">
			<div class="in">
				<div class="col col-ab">
					<?php cfct_misc('footer-widgets'); ?>
				</div>
				<div class="col col-c">
					<h4 class="title">Newsletter Sign Up</h4>
					<?php cfct_form('newsletter'); ?>
					<?php cfct_misc('nav-social-footer'); ?>
				</div>
				
				<?php $args = array(
					'theme_location'  => 'nav-footer',
					'container'       => 'nav', 
					'container_id'    => 'nav-footer',
					'menu_class'      => 'nav', 
					'echo'            => true,
				);
				wp_nav_menu( $args ); ?>
			</div><!-- .in -->
		</footer>
		
	</div><!-- #page -->
</body>

</html>











			<?php

			
			wp_footer();
			?>
