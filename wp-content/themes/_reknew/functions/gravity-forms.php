<?php 

define('RK_GFID_CONTACT', 1);
define('RK_GFID_NEWSLETTER', 2);

function rk_enqueue_gf_scripts() {
	// Enqueue GravityForms Scripts
	if (xd_plugin_exists('gravity_form_enqueue_scripts')) {
		gravity_form_enqueue_scripts(RK_GFID_CONTACT, false);
		gravity_form_enqueue_scripts(RK_GFID_NEWSLETTER, false);		
	}
}
add_action('init', 'rk_enqueue_gf_scripts');

function rk_gravity_form($id, $display_title=false, $display_description=false, $display_inactive=false, $field_values=null, $ajax=false){
	if (class_exists(RGForms)) {
		echo RGForms::get_form($id, $display_title, $display_description, $display_inactive, $field_values, $ajax);
	}
}