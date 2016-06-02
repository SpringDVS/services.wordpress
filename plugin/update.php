<?php
add_filter ('pre_set_site_transient_update_plugins', 'springdvs_update_plugin_check');

function springdvs_update_plugin_check ($aggregate)
{
	$response = wp_remote_get("http://spring-dvs.org/versions/wp.springdvs.json");
	$json = $response['body'];
	$info = json_decode($json, true);

	$local = get_plugin_data(__DIR__.'/../springdvs.php', false, false)['Version'];
	if(!version_compare($local, $info['version'])) {
		return $aggregate;

	}
	$obj = new stdClass();
	$obj->slug = 'springdvs';
	$obj->plugin = 'springdvs';
	$obj->new_version = $info['version'];
	$obj->url = 'http://www.spring-dvs.org';
	$obj->tested = '4.5.2';
	$obj->package = 'http://packages.spring-dvs.org/wp.springdvs_'.$info['version'].".zip";
	$aggregate->response['springdvs/springdvs.php'] = $obj;
	
	return $aggregate;
}

