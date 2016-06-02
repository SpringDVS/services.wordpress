<?php

function register_springdvs_settings() {
	register_setting('springdvs_settings','api_token');
	register_setting('springdvs_settings','node_target');
	register_setting('springdvs_settings','node_protocol');
	register_setting('springdvs_settings','cert_self_signed');
	
	add_settings_section('springdvs_plugin_main', 'Remote Settings', 'springdvs_settings_text', 'springdvs_sec_plugin');
	add_settings_field('springdvs_settings_api_token', 'API Token', 'springdvs_settings_api_input', 'springdvs_sec_plugin', 'springdvs_plugin_main');
	add_settings_field('springdvs_settings_node_hostname', 'Node Hostname', 'springdvs_settings_node_hostname_input', 'springdvs_sec_plugin', 'springdvs_plugin_main');
	add_settings_field('springdvs_settings_node_protocol', 'Protocol', 'springdvs_settings_node_protocol_input', 'springdvs_sec_plugin', 'springdvs_plugin_main');
	
	add_settings_field('springdvs_settings_cert_self_signed', 'Certificate Verification', 'springdvs_settings_cert_self_signed_input', 'springdvs_sec_plugin', 'springdvs_plugin_main');

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

function springdvs_settings_node_protocol_input() {
	$option = get_option('springdvs_node_protocol');
	echo "<select id='springdvs_setting_node_protocol' name='springdvs_settings_node_protocol'>";
	
	foreach(array('http','https') as $v) {
		$attr = $option == $v ? " selected" : "";
		echo "<option value='$v'$attr>$v</option>";
	}
	echo "</select>";
}

function springdvs_settings_cert_self_signed_input() {
	$option = get_option('springdvs_cert_verification');
	$state = get_option('springdvs_node_protocol') == 'https' ? "" : " disabled";
	echo "<select id='springdvs_settings_cert_self_signed' name='springdvs_settings_cert_self_signed'$state>";
	
	foreach(array('ca' => 'Certificate Authority','self' => 'Self-Signed') as $k => $v) {
		$attr = $option == $k ? " selected" : "";
		echo "<option value='$k'$attr>$v</option>";
	}
	echo "</select>";
}


function springdvs_update_settings() {

	$updated = false;
	
	if( ($api_token = filter_input(INPUT_POST, 'springdvs_settings_api_token')) !== null ) {
		update_option('springdvs_api_token', $api_token);
		$updated = true;
	}

	if( ($node_hostname = filter_input(INPUT_POST, 'springdvs_settings_node_hostname')) !== null ) {
		update_option('springdvs_node_hostname', $node_hostname);
		$updated = true;
	}
	
	if( ($node_protocol = filter_input(INPUT_POST, 'springdvs_settings_node_protocol')) !== null ) {
		update_option('springdvs_node_protocol', $node_protocol);
		$updated = true;
	}
	
	if( ($cert = filter_input(INPUT_POST, 'springdvs_settings_cert_self_signed')) !== null ) {
		update_option('springdvs_cert_verification', $cert);
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