<?php 

class CSS3PieStyle {
	private static $selectors = array();

	public static function add($val) {
		if(is_array($val)) {
			self::$selectors = array_merge(self::$selectors, $val);
		}
		else {
			self::$selectors[] = $val;
		}
	}
	public static function get($pie_url) {
		if ( count(self::$selectors > 0) ) :
		?>
			<style type="text/css" media="screen">
				<?php echo implode(', ', self::$selectors); ?> {
					behavior: url(<?php echo $pie_url ?>);
				}
			</style>
		<?php
		endif;
	}
}