<?php

include_once __DIR__.'/widgets/latest.php';

add_action( 'init', 'springdvs_widget_bulletin_check' );

function springdvs_widget_bulletin_check() {
	$path = '/wp-content/plugins/springdvs/services/bulletin/widgets';
	SpringDvsBulletinsLatest::conditionalScriptEnqueue($path);
}