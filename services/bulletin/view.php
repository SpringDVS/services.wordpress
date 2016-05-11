<?php
	
	$bulletins = BulletinApi::getAll();
	$commsError = false;
	
	if($bulletins === null) {
		$commsError = true;
		$bulletins = [];
	}
	
?>

<h2>Network Services &rsaquo; Bulletins</h2>
<?php if($commsError):?>
	<div class="notice notice-error"><p>There is an authentication error. Please check that your remote API token is correct</p></div>
<?php endif; ?>

<div class="metabox-holder" style="margin-right: 20px;">
	<table class="wp-list-table widefat  striped">	
	<thead>
		<tr>
			<th class="manage-column column-title" style="width: 75%;">Title</th>
			<th class="manage-column column-title" style="width: 25%;">Tags</th>
			<th class="manage-column column-title">Type</th>
			<th class="manage-column column-title" style="width: 75%;"></th>
		</tr>
	</thead>
	<tbody class="the-list">
<?php foreach($bulletins as $bulletin): ?>
		<tr>
			<td><?php echo $bulletin['title']; ?></td>
			<td><?php echo $bulletin['tags']; ?></td>
			<td><?php echo $bulletin['type']; ?></td>
			<td><a href="<?php echo "?page=$currentPage&service=bulletin&task=rem&key={$bulletin['key']}";?>">delete</a></td>
		</tr>
	
<?php	endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="manage-column column-title">Title</th>
			<th class="manage-column column-title">Tags</th>
			<th class="manage-column column-title">Type</th>	
			<th class="manage-column column-title"></th>	
		</tr>
	</tfoot>
	</table>
</div>
<div class="meta-box-sortables ui-sortable" style="width: 30%; margin-top: 20px;">
	<div class="postbox">
		
		<h2 class="hndle" style="margin: 5px; margin-top: 5px; overflow: auto;">New Bulletin</h2>
		<div class="inside">
		<form method="post">
		<div class="form-field form-required term-name-wrap">
			 <label for="bf-title">Title</label>
			 <input name="title" id="bf-title" type="text">
		</div>
		<div class="form-field form-required term-name-wrap" style="margin-top: 10px;">
			<label for="bf-type">Type</label><br>
			<select name="type" id="bftype" class="postform">
					<option value="event">Event</option>
					<option value="notice">Notice</option>
					<option value="service">Service</option>
			</select>
		</div>
		<div class="form-field term-name-wrap" style="margin-top: 10px;">
			<label for="bf-tags">Tags</label>
			<input name="tags" id="bf-tags" type="text" placeholder="tag1,tag2,tag3">
			<p style="font-style: italic">Separate with commas</p>
		</div>
			<input type="submit" value="Post Bulletin" class="button button-primary button-large">
		</form>
		</div>
		
	</div>
</div>


