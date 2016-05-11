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