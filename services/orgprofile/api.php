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
class OrgProfileApi {
	public static function getProfile() {
		return springdvs_node_request('nwservice', 'get', 'orgprofile', "task=profile");
	}
	
	public static function pushUpdate($data) {
		return springdvs_node_push('nwservice', 'push', $data, 'orgprofile', "task=update");
	}

}
