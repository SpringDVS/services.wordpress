<?php
function springdvs_node_request($action, $method, $service = '', $query = '') {
	
	$node = get_option('springdvs_node_hostname');
	$token = get_option('springdvs_api_token');
	$protocol = get_option('springdvs_node_protocol');
	
	$url = "{$node}/node/api/$action/$method/$service?$query";
	$raw = springdvs_request($url, array('__token' => $token));
	return trim($raw) == "unauthorised" ? null : json_decode($raw, true);
}

function springdvs_node_push($action, $method, $post, $service = '', $query = '') {
	$node = get_option('springdvs_node_hostname');
	$token = get_option('springdvs_api_token');
	$url = "{$node}/node/api/$action/$method/$service?$query";
	is_array($post) ? $post["__token"] = $token : $post = "__token=$token";

	$raw = springdvs_request($url, $post);
	return trim($raw) == "unauthorised" ? null : json_decode($raw, true);
}

function springdvs_request($url, $post) {
	$protocol = get_option('springdvs_node_protocol');
	$url = "$protocol://$url";
	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	if(get_option('springdvs_cert_verification') == 'self') {
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	} else {
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	}
	
	$raw = curl_exec($ch);
	curl_close($ch);
	return $raw;
}

