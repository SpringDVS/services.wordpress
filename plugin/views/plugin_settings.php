<div class="wrap">
<h2>SpringDVS Network</h2>
<form method="post">
<?php
	settings_fields( 'springdvs_settings' );
	do_settings_sections( 'springdvs_sec_plugin' );
?>
<?php submit_button(); ?>
</form>
</div>
<div class="wrap">
<h3>Node URI</h3>
<?php
$node = get_option('springdvs_node_uri');

$node = $node == "" ? "Unresolved" : "spring://$node";
?>
<strong><?php echo $node ?></strong>
<?php if($commsError){ springdvs_notice_error_connection();} else if($node == "Unresolved"):?>
	<div class="notice notice-warning"><p>The node has not been resolved. This could be due to incorrect remote settings in the plugin.</p></div>
<?php else: ?>
	<div class="notice notice-success"><p>Link with node is resolved and holding steady!</p></div>
<?php endif; ?>
</div>