<?php
function springdvs_settings_display() {
	
	$commsError = springdvs_update_settings();
	include __DIR__."/views/plugin_settings.php";
}

function springdvs_overview_display() {
	$service = filter_input(INPUT_GET, 'service');
	$currentPage = filter_input(INPUT_GET, 'page');
	
	$nodeUri = get_option('springdvs_node_uri');
	$nodeUri = $nodeUri == "" ? "" : "spring://$nodeUri";
	
	if(file_exists(__DIR__."/../services/$service/view.php")
	&& file_exists(__DIR__."/../services/$service/api.php")
	&& file_exists(__DIR__."/../services/$service/controller.php")) {
		include __DIR__."/../services/$service/api.php";
		include __DIR__."/../services/$service/controller.php";
		include __DIR__."/../services/$service/view.php";
		return;
	}
	include __DIR__."/views/plugin_main.php";
}

function springdvs_notice_error_connection() {
	echo '<div class="notice notice-error"><p>There is an authentication error. Please check that your remote settings are correct.</p></div>';
}