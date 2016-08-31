<?php
$updates = springdvs_node_request('updates', 'pull');
$commsError = false;

?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
		<strong><?php echo $nodeUri; ?></strong>
</div>

<h2>SpringDVS  &rsaquo; Keyring</h2>
<?php if($commsError){ springdvs_notice_error_connection();} ?>

<table class="wp-list-table widefat  striped">
		<tbody class="the-list">
			<tr>
				<td>
					<a href="?page=springdvs_keyring&action=view"><b>View</b></a>
				</td>
				<td>
					View the keyring of public keys and certificates
				</td>
			</tr>
			<tr>
				<td>
					<a href="?page=springdvs_keyring&action=import"><b>Import</b></a> 
				</td>
				<td>
					Import a public key and certificate
				</td>
			</tr>
			
			<tr>
				<td>
					<a href="?page=springdvs_keyring&action=private"><b>Private</b></a>
				</td>
				<td>
					View node's private key and certificate
				</td>
			</tr>
		</tbody>
</table>