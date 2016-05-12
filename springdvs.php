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
	
	$commsError = springdvs_update_options();
	include __DIR__."/config/plugin_settings.php";
}

function springdvs_node_request($action, $method, $service = '', $query = '') {

	$node = get_option('springdvs_node_hostname');
	$token = get_option('springdvs_api_token');
	
	$url = "http://{$node}/node/api/$action/$method/$service?$query";
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, array('__token' => $token));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$raw = curl_exec($ch);	
	curl_close($ch);
	
	//$raw = file_get_contents("http://{$node}/node/api/$action/$method/$service?__token=$token$query");
	return trim($raw) == "unauthorised" ? null : json_decode($raw, true);
}
function springdvs_node_push($action, $method, $post, $service = '', $query = '') {
	$node = get_option('springdvs_node_hostname');
	$token = get_option('springdvs_api_token');
	
	
	$url = "http://{$node}/node/api/$action/$method/$service?$query";
	
	$post = is_array($post) ? $post['__token'] = $token : "__token=$token";
	
	
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$raw = curl_exec($ch);
	curl_close($ch);
	
	return trim($raw) == "unauthorised" ? null : json_decode($raw, true);
}


function springdvs_overview_display() {
	$service = filter_input(INPUT_GET, 'service');
	$currentPage = filter_input(INPUT_GET, 'page');
	
	$nodeUri = get_option('springdvs_node_uri');
	$nodeUri = $nodeUri == "" ? "" : "spring://$nodeUri";
	
	if(file_exists(__DIR__."/services/$service/view.php")
	&& file_exists(__DIR__."/services/$service/api.php")
	&& file_exists(__DIR__."/services/$service/controller.php")) {
		include __DIR__."/services/$service/api.php";
		include __DIR__."/services/$service/controller.php";
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
	$updated = false;
	
	if( ($api_token = filter_input(INPUT_POST, 'springdvs_settings_api_token')) !== null ) {
		update_option('springdvs_api_token', $api_token);
		$updated = true;
	}

	if( ($node_hostname = filter_input(INPUT_POST, 'springdvs_settings_node_hostname')) !== null ) {
		update_option('springdvs_node_hostname', $node_hostname);
		$updated = true;
	}

	if(!$updated) return false;

	update_option('springdvs_node_uri', "");
	$response = springdvs_node_request('springnet', 'get');
	
	if($response == null) return true;
	
	$network = $response['springname'].'.'.$response['network'];
	update_option('springdvs_node_uri', $network);
	return false;
}
?>