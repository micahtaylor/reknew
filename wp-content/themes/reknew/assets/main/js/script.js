/* General Scripts */

!function($) {
	$(function() {
		var ease_nav = 50;
		// Hero Carousel
		var $masthead = $('#masthead');
		if ($masthead) {
			var $pagination = $masthead.find('.pagination');
			$masthead.find('.carousel ul').cycle({
				fx: 'scrollHorz',
				speed: 750,
				timeout: 8000,
				pager: $pagination,
				next: $masthead.find('.next'),
				prev: $masthead.find('.prev'),
				pause: 1,
				pauseOnPagerHover: 1
			});
			$pagination.css('margin-left', -Math.floor( $pagination.width() / 2 ) + 'px');
		}
		
		// Add text bullets to footer list modules
		$('#footer .item li, #footer-panel .widget .body li').each(function() {
			$(this).append('<span unselectable="on" class="bullet">&gt;</span>');
		});
		
		// Animate Main Nav items
		$('#nav-main li:not(\'.active, .active li, .category #nav-main .menu-item-resources, .single-post #nav-main .menu-item-blog, .ancestor-page-about #nav-main .menu-item-about, .ancestor-page-get-involved #nav-main .menu-item-get-involved, .ancestor-page-about #nav-main .menu-item-about\')').hover(
			function() { 
				$(this).find('a').animate({left: '8px',top: '8px'}, ease_nav);
			},
			function() { 
				$(this).find('a').animate({left: 0, top: 0}, ease_nav);
			}
		);
		
		// Reset tab stops for multiple forms
		$('form').each(function(formIdx, formVal) {
			var $form = $(this);

			$form.find('input, textarea, select').each(function(inputIdx, inputVal){
				$(this).attr('tabindex', (formIdx * 1000) + inputIdx);
			});
		});
		
		// Add Html5 placeholder support for older browsers
		$('input[placeholder], textarea[placeholder]').placeholder();
	});
}(jQuery);