<?php
	// Pull network services
	$services = springdvs_node_request('nwservices', 'pull');
	
	
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


<?php if($commsError):?>
	<div class="notice notice-error"><p>There is an authentication error. Please check that your remote API token is correct</p></div>
<?php endif; ?>
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
