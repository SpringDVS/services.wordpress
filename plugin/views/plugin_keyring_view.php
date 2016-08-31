<?php
	$keyrem = filter_input(INPUT_GET, 'remove');
	if($keyrem) {
		springdvs_node_request('keyring', 'post','remove','keyid='.$keyrem);
	}

	$keyids = springdvs_node_request("keyring", "get", "all");
	$keysel = filter_input(INPUT_GET, 'key');
	
	$cert  = null;
	if($keysel) {
		$check = springdvs_node_request("keyring", "get", $keysel);
		if($check['result'] == "ok") {
			$cert = $check['key']; 
		}
	}
	
	
	
	
?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
		<strong><?php echo $nodeUri; ?></strong>
</div>
<h2>SpringDVS  &rsaquo; <a href="?page=springdvs_keyring">Keyring</a> &rsaquo; View</h2>


<table class="wp-list-table widefat">
<?php
	foreach($keyids as $key) {
		echo '<tr><td>';
		echo '<a href="?page=springdvs_keyring&action=view&key='.$key[0].'">'.$key[1]."</a>";
		echo "</td></tr>";
		if($key[0] == $keysel && $cert) {
			echo '<tr style="background-color:#EFEFEF;"><td>';
			echo '<div style="float:left; width: 50%;">';
				echo '<h2>' . $cert['name'] . "</h2>";
				echo '<em>' . $cert['email'] . "</em>";
				echo '<h3>Signatories</h3>';
				echo '<ul>';
				foreach($cert['sigs'] as $sig) {
					echo '<li>'.$sig[0].' (<em>'.$sig[1].'</em>)</li>';
				}
				echo '</ul>';
			if(!$cert['signed']) {
				echo '<a href="?page=springdvs_keyring&action=unlock&reason=sign&keyid='.$key[0].'">Sign</a>';
			}
			echo "</div>";
			echo '<div style="float:right; width: 50%;">';
				echo '<textarea style="font-family: monospace; font-size: 0.9em; float:right;" rows="12" cols="65">'.$cert['public'].'</textarea><br>';
				echo '<a style="float: right; clear: both;" href="?page=springdvs_keyring&action=view&remove='.$key[0].'">Delete Key</a>';
			echo '</div>';

			echo "</td></tr>";
		}
	}
?>

</table>

