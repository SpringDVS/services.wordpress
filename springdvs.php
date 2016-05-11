<?php
defined( 'ABSPATH' ) or die( 'Error' );

/*
Plugin Name: SpringDVS
Plugin URI:  http://spring-dvs.org
Description: Plugin for managing node services
Version:     1.0
Author:      The Care Connections Initiative c.i.c
Author URI:  http://spring-dvs.org
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: springdvs
*/

add_action( 'admin_menu', 'springdvs_menu');

function springdvs_menu() {
	
	add_action( 'admin_init', 'register_springdvs_settings' );
	
	add_options_page('SpringDVS Options', 'SpringDVS', 'manage_options', 'springdvs', 
		'springdvs_settings_display');
	/*,'/wp-content/plugins/springdvs/res/icon2.png'*/
	add_menu_page( 'SpringDVS Services', 'SpringDVS', 'edit_pages', 'springdvs_overview', 'springdvs_overview_display');
}

function springdvs_settings_display() {
	
	springdvs_update_options();
	include __DIR__."/config/plugin_settings.php";
}

function springdvs_node_request($action, $method, $service = '', $query = '') {
	$node = get_option('springdvs_node_hostname');
	$token = get_option('springdvs_api_token');
	$query = $query == "" ? $query : "&$query";
	$raw = file_get_contents("http://{$node}/node/api/$action/$method/$service?__token=$token$query");
	return trim($raw) == "unauthorised" ? null : json_decode($raw, true);
}

function springdvs_overview_display() {
	$service = filter_input(INPUT_GET, 'service');
	
	if(file_exists(__DIR__."/services/$service/view.php")
	&& file_exists(__DIR__."/services/$service/api.php")) {
		include __DIR__."/services/$service/api.php";
		include __DIR__."/services/$service/view.php";
		return;
	}
	include __DIR__."/plugin_main.php";
}

function register_springdvs_settings() {
	register_setting('springdvs_settings','api_token');
	register_setting('springdvs_settings','node_target');
	add_settings_section('springdvs_plugin_main', 'Remote Settings', 'springdvs_settings_text', 'springdvs_sec_plugin');
	add_settings_field('springdvs_settings_api_token', 'API Token', 'springdvs_settings_api_input', 'springdvs_sec_plugin', 'springdvs_plugin_main');
	add_settings_field('springdvs_settings_node_hostname', 'Node Hostname', 'springdvs_settings_node_hostname_input', 'springdvs_sec_plugin', 'springdvs_plugin_main');
}

function springdvs_settings_text() {
	echo "These are the settings for configuring the plugin with the node";
}

function springdvs_settings_api_input() {
	$option = get_option('springdvs_api_token');
	echo "<input id='springdvs_setting_api_text' name='springdvs_settings_api_token' size='40' type='text' value='{$option}'>";
}

function springdvs_settings_node_hostname_input() {
	$option = get_option('springdvs_node_hostname');
	echo "<input id='springdvs_setting_node_hostname' name='springdvs_settings_node_hostname' size='40' type='text' value='{$option}'>";
}

function springdvs_update_options() {
	if( ($api_token = filter_input(INPUT_POST, 'springdvs_settings_api_token')) !== null ) {
		update_option('springdvs_api_token', $api_token);
	}
	if( ($node_hostname = filter_input(INPUT_POST, 'springdvs_settings_node_hostname')) !== null ) {
		update_option('springdvs_node_hostname', $node_hostname);
	}
}
?>