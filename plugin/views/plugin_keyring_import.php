<?php
	
?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
		<strong><?php echo $nodeUri; ?></strong>
</div>
<h2>SpringDVS  &rsaquo; <a href="?page=springdvs_keyring">Keyring</a> &rsaquo; Import</h2>
<?php if($importedName): ?>
	<div class="notice notice-success" style="margin-bottom: 15px;"><p>Successfully imported certificate for <em><?php echo $importedName; ?></em></p></div>
<?php endif; ?>

<form method="post">
	<textarea name="key" cols="65" rows="15" style="font-family: monospace; margin-bottom: 10px;"></textarea><br>
	<input type="submit" value="Import">
</form>

