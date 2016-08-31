<?php
$importedName = null;
if( ($key = filter_input(INPUT_POST, 'key')) ) {
	$response = springdvs_node_push('keyring', 'post', array('armor' => $key),'import');
	
	if($response['result'] == 'ok') {
		$importedName = $response['name'];
	}
}