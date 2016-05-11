<?php
	// Pull network services
	$services = springdvs_node_request('nwservices', 'pull');
	
	
	$commsError = false;
	if($services === null) {
		$commsError = true;
		$services = [];
	}
	
?>
<h2>Network Services  &rsaquo; Overview</h2>
<?php if($commsError):?>
	<div class="notice notice-error"><p>There is an authentication error. Please check that your remote API token is correct</p></div>
<?php endif; ?>
<table>
<?php
	$cpage = filter_input(INPUT_GET, 'page');
	foreach($services as $service):
?>
	<tr>
		
		<td>
			<a href="?<?php echo "page=$cpage&service={$service['module']}"; ?>">
			<?php echo $service['title']; ?>
			</a>
		</td>
		<td><?php echo $service['description']; ?></td>
	</tr>
<?php
	endforeach;
?>
</table>
