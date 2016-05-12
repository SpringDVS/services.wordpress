<?php
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

	is_array($post) ? $post["__token"] = $token : $post = "__token=$token";

	$ch = curl_init($url);

	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$raw = curl_exec($ch);
	curl_close($ch);
	
	return trim($raw) == "unauthorised" ? null : json_decode($raw, true);
}

