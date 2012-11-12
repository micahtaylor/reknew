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

?>
<div class="pagination pagination-post clearfix">
	<span class="prev"><?php previous_post_link( '%link', __('&laquo; <span>Previous</span>', 'kong') ) ?></span>
	<span class="sep">|</span>
	<span class="next"><?php next_post_link( '%link', __('<span>Next</span> &raquo;', 'kong') ) ?></span>
</div>