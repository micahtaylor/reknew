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

$s = get_query_var('s');

if (get_option('permalink_structure') != '') {
	$onsubmit = "location.href=this.action+'search/'+encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;";
}
else {
	$onsubmit = '';
}

?>
<form method="get" action="<?php echo trailingslashit(get_bloginfo('url')); ?>" class="form-search" onsubmit="<?php echo $onsubmit; ?>">
	<input type="text" id="s"  name="s"  placeholder="What Are You Searching For?"  value="<?php echo esc_html($s); ?>" />
	<input type="submit" name="submit_button" value="<?php _e('Search', 'rk'); ?>" />
</form>