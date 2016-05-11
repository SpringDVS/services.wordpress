<?php
	include __DIR__."/BulletinTable.php";
	$bulletins = BulletinApi::getAll();
	$commsError = false;
	
	if($bulletins === null) {
		$commsError = true;
		$bulletins = [];
	}
	
?>

<h2>Network Services</h2>
<h3>Bulletins</h3>
<?php if($commsError):?>
	<div class="notice notice-error"><p>There is an authentication error. Please check that your remote API token is correct</p></div>
<?php endif; ?>

	<table class="wp-list-table widefat  striped">	
	<thead>
		<tr>
			<th class="manage-column column-title" style="width: 75%;">Title</th>
			<th class="manage-column column-title" style="width: 25%;">Tags</th>
			<th class="manage-column column-title">Type</th>
			
		</tr>
	</thead>
	<tbody class="the-list">
<?php foreach($bulletins as $bulletin): ?>
		<tr class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
			<td><?php echo $bulletin['title']; ?></td>
			<td><?php echo $bulletin['tags']; ?></td>
			<td><?php echo $bulletin['type']; ?></td>
		</tr>
	
<?php	endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="manage-column column-title">Title</th>
			<th class="manage-column column-title">Type</th>
			<th class="manage-column column-title">Tags</th>	
		</tr>
	</tfoot>
	</table>


