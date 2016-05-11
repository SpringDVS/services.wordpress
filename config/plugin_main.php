<?php
	// Pull network services
	$node = get_option('springdvs_node_hostname');
	$token = get_option('springdvs_api_token');
	$raw = file_get_contents("http://{$node}/node/api/nwservices/pull/?__token=$token");

	$services = [];
	$commsError = false;
	if(trim($raw) == "unauthorised") {
		$commsError = true;
	} else {
		$services = json_decode($raw);
	}
	
?>
<h2>Network Services</h2>
<?php if($commsError):?>
	<div class="notice notice-error"><p>There is an authentication error. Please check that your remote API token is correct</p></div>
<?php endif; ?>
<table>
<?php
	
	foreach($services as $service):
		
?>
	<tr>
		
		<td><strong><?php echo $service->title; ?></strong></td>
		<td><?php echo $service->description; ?></td>
	</tr>
<?php
	endforeach;
?>
</table>
