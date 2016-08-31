<?php
function springdvs_settings_display() {
	
	$commsError = springdvs_update_settings();
	include __DIR__."/views/plugin_settings.php";
}

function springdvs_services_display() {
	$service = filter_input(INPUT_GET, 'service');
	$currentPage = filter_input(INPUT_GET, 'page');
	
	$nodeUri = get_option('springdvs_node_uri');
	$nodeUri = $nodeUri == "" ? "" : "spring://$nodeUri";
	$updated = false;
	if(filter_input(INPUT_POST, 'node_action') == 'update') {
		springdvs_node_request('updates', 'push');
		$updated = true;
	}
	if(file_exists(__DIR__."/../services/$service/view.php")
	&& file_exists(__DIR__."/../services/$service/api.php")
	&& file_exists(__DIR__."/../services/$service/controller.php")) {
		include __DIR__."/../services/$service/api.php";
		include __DIR__."/../services/$service/controller.php";
		include __DIR__."/../services/$service/view.php";
		return;
	}
	include __DIR__."/views/plugin_services.php";
}

function springdvs_overview_display() {
	
	$service = filter_input(INPUT_GET, 'service');
	$currentPage = filter_input(INPUT_GET, 'page');
	$nodeUri = get_option('springdvs_node_uri');
	$nodeUri = $nodeUri == "" ? "" : "spring://$nodeUri";
	$updated = false;
	if(filter_input(INPUT_POST, 'node_action') == 'update') {
		springdvs_node_request('updates', 'push');
		$updated = true;
	}
	
	include __DIR__."/views/plugin_main.php";
}

function springdvs_keyring_display() {
	$nodeUri = get_option('springdvs_node_uri');
	$nodeUri = $nodeUri == "" ? "" : "spring://$nodeUri";
	
	$action = filter_input(INPUT_GET, 'action'); 
	if($action == 'view') {
		include __DIR__."/views/plugin_keyring_view.php";
	} else if($action == "import") {
		include __DIR__."/controllers/controller_keyring_import.php";
		include __DIR__."/views/plugin_keyring_import.php";
	} else if($action == "private") {
		include __DIR__."/controllers/controller_keyring_private.php";
		include __DIR__."/views/plugin_keyring_private.php";
	} else if($action == "unlock") {
		include __DIR__."/controllers/controller_keyring_unlock.php";
		include __DIR__."/views/plugin_keyring_unlock.php";
	} else {
		include __DIR__."/views/plugin_keyring.php";
	}
	
}

function springdvs_notice_error_connection() {
	echo '<div class="notice notice-error"><p>There is an authentication error. Please check that your remote settings are correct.</p></div>';
}