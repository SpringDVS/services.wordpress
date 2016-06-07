<?php
	
	$bulletins = BulletinApi::getAll();
	$commsError = false;
	
	if($bulletins === null) {
		$commsError = true;
		$bulletins = [];
	}

	$pageTask = filter_input(INPUT_GET, 'task');
	$pageKey = filter_input(INPUT_GET, 'key');
	
?>
<div style="margin-top: 20px; margin-right: 20px; float: right;">
		<strong><?php echo $nodeUri; ?></strong>
</div>
<h2>Network Services &rsaquo; Bulletins</h2>
<?php if($commsError){ springdvs_notice_error_connection();} ?>

<div class="metabox-holder" style="margin-right: 20px;">
	<table class="wp-list-table widefat  striped">	
	<thead>
		<tr>
			<th class="manage-column column-title" style="width: 75%;">Title</th>
			<th class="manage-column column-title" style="width: 25%;">Tags</th>
			<th class="manage-column column-title" style="width: 75%;"></th>
		</tr>
	</thead>
	<tbody class="the-list">
<?php foreach($bulletins as $bulletin): ?>
		<tr>

			<?php if($pageTask == 'view' && $pageKey == $bulletin['key']): ?>
				<td><a href="<?php echo "?page=$currentPage&service=bulletin";?>"><?php echo $bulletin['title']; ?></a></td>
			<?php else: ?>
				<td><a href="<?php echo "?page=$currentPage&service=bulletin&task=view&key={$bulletin['key']}";?>"><?php echo $bulletin['title']; ?></a></td>
			<?php endif;?>

			<td><?php echo $bulletin['tags']; ?></td>
			<td><a href="<?php echo "?page=$currentPage&service=bulletin&task=rem&key={$bulletin['key']}";?>">delete</a></td>
		</tr>
		<?php if($pageTask == 'view' && $pageKey == $bulletin['key']): ?>
			<tr>
				<td colspan="3">
					<?php echo str_replace("\n", '<br>', $bulletin['content']); ?>
					<div style="font-size: 12px; width: 100%; text-align: right;"><?php echo $bulletin['uid']?></div>
				</td>
			</tr>
		<?php endif ?>
	
<?php	endforeach; ?>
	</tbody>
	<tfoot>
		<tr>
			<th class="manage-column column-title">Title</th>
			<th class="manage-column column-title">Tags</th>	
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
			<label for="bf-content">Content</label><br>
			<textarea name="content" id="bf-content"></textarea>
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


