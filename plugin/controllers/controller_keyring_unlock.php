<?php
$status = 0;
$msg = "";

if( ($passphrase = filter_input(INPUT_POST, "passphrase")) )  {

	$reason = filter_input(INPUT_GET, 'reason');

	if($reason == 'sign') {
		$keyid = filter_input(INPUT_GET, 'keyid');
		springdvs_node_push('keyring', 'post', array('passphrase' => $passphrase), 'sign', 'keyid='.$keyid);
		$status = 1;
		$msg = 'Successfully signed certificate. <a href="?page=springdvs_keyring&action=view">Go back</a>';
	}
}