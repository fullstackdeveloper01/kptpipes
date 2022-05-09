<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('wallpaper/add'));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Wallpaper'); ?>
    					       <input type="file" required filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="attachments[0]">
    					       <input type="text" class="hide" name="type" value="wallpaper">
    					   </div>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Save</button>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
			<div class="col-md-8">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Wallpaper'),
							_l('Size'),
							_l('Date'),
							_l('options')
							),'wallpaper'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-wallpaper', window.location.href, [1], [1]);
	</script>
</body>
</html>
