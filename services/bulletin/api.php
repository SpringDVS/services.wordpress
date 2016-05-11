<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of api
 *
 * @author cfg
 */
class BulletinApi {
	public static function getAll() {
		return springdvs_node_request('nwservice', 'get', 'bulletin', "task=all");
	}
	
	public static function pushNew($data) {
		return springdvs_node_push('nwservice', 'push', $data, 'bulletin', "task=new");
	}
	public static function pushRem($key) {
		return springdvs_node_push('nwservice', 'push', ['key' => $key], 'bulletin', "task=rem");
	}
}
