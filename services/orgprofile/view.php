<?php
	$profile = OrgProfileApi::getProfile();
	$commsError = false;
	
	if($profile === null) {
		$commsError = true;
		$profile = [];
	}
	
?>

<h2>Network Services &rsaquo; Organisation Profile</h2>
<?php if($commsError):?>
	<div class="notice notice-error"><p>There is an authentication error. Please check that your remote API token is correct</p></div>
<?php endif; ?>

<div class="metabox-holder" style="margin-right: 20px;">
	<div class="postbox">
		
		<h2 class="hndle" style="margin: 5px; margin-top: 5px; overflow: auto;">Profile</h2>
		<div class="inside">
			<h1><?php echo $profile['name']; ?></h1>
			<div>
				<a hfref="<?php echo $profile['website']; ?>">
					<strong><?php echo $profile['website']; ?></strong>
				</a>
			</div>
			<div style="margin-top: 10px;">
					<em><?php echo $profile['tags']; ?></em>
			</div>
		</div>
		
	</div>
</div>
<div class="metabox-holder">
<div class="meta-box-sortables ui-sortable" style="width: 50%;">
	<div class="postbox">
		
		<h2 class="hndle" style="margin: 5px; margin-top: 5px; overflow: auto;">Update</h2>
		<div class="inside">
		<form method="post">
		<div class="form-field form-required term-name-wrap">
			 <label for="bf-name">Name</label>
			 <input name="name" id="bf-name" type="text"  value="<?php echo $profile['name']; ?>">
		</div>
			
		<div class="form-field form-required term-name-wrap" style="margin-top: 10px;">
			<label for="bf-type">Web Site</label><br>
			<input name="website" id="bf-website" type="text" value="<?php echo $profile['website']; ?>">
		</div>
		<div class="form-field term-name-wrap" style="margin-top: 10px;">
			<label for="bf-tags">Tags</label>
			<input name="tags" id="bf-tags" type="text" value="<?php echo $profile['tags']; ?>" placeholder="tag1,tag2,tag3">
			<p style="font-style: italic">Separate with commas</p>
		</div>
			<input type="submit" value="Update" class="button button-primary button-large">
		</form>
		</div>
		
	</div>
</div>
</div>

