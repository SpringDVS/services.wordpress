<?php
$reason = filter_input(INPUT_GET, 'reason');
$info = null;
if($reason == "sign") {
	$reason = "Sign";
	$info = "By signing, you are vouching the certificate is genuine";
}
?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
<strong><?php echo $nodeUri; ?></strong>
</div>


<h2>SpringDVS  &rsaquo; <a href="?page=springdvs_keyring">Keyring</a> &rsaquo; Unlock to `<?php echo $reason; ?>`</h2>
<?php if($status == 1): ?>
	<div class="notice notice-success" style="margin-bottom: 15px;"><p><?php echo $msg; ?></p></div>
<?php endif; ?>

<?php if($info && $status == 0): ?>
	<div class="notice notice-info" style="margin-bottom: 15px;"><p><?php echo $info; ?></p></div>
<?php endif; ?>
<form method="post">
Private Key Passphrase:<br>
<input type="password" placeholder="Passphrase" name="passphrase"><br>
<input name="submission" type="submit" value="Unlock Key" style="margin-top: 10px;">
</form>