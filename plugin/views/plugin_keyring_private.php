<?php
	$pricert = springdvs_node_request('keyring', 'get', 'private');
	if($pricert['result'] != "ok") {
		$pricert = null;
	}
	
	$pubcert = springdvs_node_request('keyring', 'get', 'this');


?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
<strong><?php echo $nodeUri; ?></strong>
</div>


<h2>SpringDVS  &rsaquo; <a href="?page=springdvs_keyring">Keyring</a> &rsaquo; Private Key & Certificate</h2>

<?php if(!$pricert):?>
	<div class="notice notice-error"><p>The node does not have a private key or certificate. Please generate one in node software.</p></div>
<?php endif;?>


<div style="float: left; width: 50%;">
<h3>Private Key</h3>
<textarea name="key" cols="65" rows="15" style="font-family: monospace; margin-bottom: 10px;"><?php if($pricert) echo $pricert['key']; ?></textarea>
<h3>Public Key</h3>
<textarea name="key" cols="65" rows="15" style="font-family: monospace; margin-bottom: 10px;"><?php if($pricert) echo $pubcert['key']['armor']; ?></textarea>
</div>
<div style="float: right; width: 50%;">
<h2>Certificate</h2>
<?php 
	if($pricert) {
		echo '<strong>'.$pubcert['key']['name'].'</strong><br>';
		echo $pubcert['key']['email'];
		echo '<h4>Signatories</h4>';
		echo '<ul>';
		foreach($pubcert['key']['sigs'] as $sig) {
			echo '<li>'.$sig[0].'&nbsp;&nbsp;(<em>'.$sig[1].'</em>)</li>';
		}
		echo '</ul>';
	}
?>
</div>