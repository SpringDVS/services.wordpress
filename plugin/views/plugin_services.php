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
<h2>SpringDVS  &rsaquo; Network Services</h2>


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