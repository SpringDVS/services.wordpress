<?php
function springdvs_widget_services() {
	
	$dirs = array_filter(glob(__DIR__.'/../services/*'), 'is_dir');
	$result = array();
	foreach($dirs as $d) {
		$path = $d.'/widgets.php';
		
		if(!file_exists($path)) continue;

		$result[] = $d;
	}
	return $result;		
}

include_once __DIR__.'/../services/bulletin/widgets.php';

function springdvs_init_widgets() {
	register_widget('SpringDvsBulletinsLatest');	
}