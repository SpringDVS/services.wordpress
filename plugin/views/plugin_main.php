<?php
	// Pull network services
	$services = springdvs_node_request('nwservices', 'pull');
	$updates = springdvs_node_request('updates', 'pull');

	$commsError = false;
	if($services === null) {
		$commsError = true;
		$services = [];
	}
	
?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
		<strong><?php echo $nodeUri; ?></strong>
</div>
<h2>Network Services  &rsaquo; Overview</h2>


<?php if($commsError){ springdvs_notice_error_connection();} ?>

<div style="margin-right: 20px;">

	<table class="wp-list-table widefat  striped">
		<tbody class="the-list">
	<?php
		$cpage = filter_input(INPUT_GET, 'page');
		foreach($services as $service):
	?>
		<tr>

			<td>
				<a href="?<?php echo "page=$cpage&service={$service['module']}"; ?>">
					<strong><?php echo $service['title']; ?></strong>
				</a>
			</td>
			<td><?php echo $service['description']; ?></td>
		</tr>
	<?php
		endforeach;
	?>
		</tbody>
	</table>
	

</div>
<div style="margin-right: 20px; margin-top: 20px;">
<?php
$update = false;
foreach($updates as $t) {
	if(isset($t['modules'][0])) {
		$update = true;
	}
}

if($update): ?>
<strong>Module Updates</strong>

<form method="post">
	<div style="height: 45px;" class="notice notice-info"><p>Updates Available<input style="float: right;" type="submit" class="button button-primary" value="Update"></p></div>
	<table>
		<tbody>
		<input type="hidden" name="node_action" value="update">
			<?php 
				foreach($updates as $type) {
					if(!isset($type['modules'][0])) continue;
					echo "<tr><td colspan=\"2\"><strong>{$type['mtype']} Services</strong></td></tr>";
					foreach($type['modules'] as $module) {
						echo "<tr>";
						echo "<td>{$module['module']}</td>";
						echo "<td> {$module['details']['version']}</td>";
						echo "</tr>";
					}
				}
			?>
		</tbody>
	</table>
	
</form>
<?php elseif($updated): ?>
	<div class="notice notice-success"><p>Update Successful!</p></div>
<?php endif; ?>
</div>