<?php
/*
Plugin Name: SpringDVS
Plugin URI:  http://spring-dvs.org
Description: Plugin for managing node services
Version:     1.4.0
Author:      The Care Connections Initiative c.i.c
Author URI:  http://spring-dvs.org
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: springdvs
*/

defined( 'ABSPATH' ) or die( 'Error' );

include __DIR__.'/plugin/request.php';
include __DIR__.'/plugin/settings.php';
include __DIR__.'/plugin/views.php';
include __DIR__.'/plugin/widgets.php';
include __DIR__.'/plugin/update.php';



add_action('widgets_init', 'springdvs_init_widgets');


add_action( 'admin_menu', 'springdvs_menu');

function springdvs_menu() {
	
	add_action( 'admin_init', 'register_springdvs_settings' );
	
	add_options_page('SpringDVS Options', 'SpringDVS', 'manage_options', 'springdvs', 
		'springdvs_settings_display');
	
	
	add_menu_page( 'SpringDVS Overview', 'SpringDVS', 'edit_pages', 'springdvs_overview', 'springdvs_overview_display');
	add_submenu_page( 'springdvs_overview', 'Network Services', 'Services', 'edit_pages','springdvs_services', 'springdvs_services_display');
	add_submenu_page( 'springdvs_overview', 'Keyring', 'Keyring', 'edit_pages','springdvs_keyring', 'springdvs_keyring_display');
}
?>
