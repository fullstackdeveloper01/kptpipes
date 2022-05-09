<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('medicineType/add'));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Name'); ?>
    					       <input type="text" class="form-control" name="name" required>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Icon'); ?>
    					       <input type="file" required filesize="<?php echo file_upload_max_size(); ?>" required class="form-control" name="medicine_icon">
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
							_l('Icon'),
							_l('Name'),
							_l('Size'),
							_l('Date'),
							_l('options')
							),'medicineType'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-medicineType', window.location.href, [1], [1]);
	</script>
</body>
</html>
