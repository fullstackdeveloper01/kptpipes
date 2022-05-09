<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
    				<div class="panel-body">
    					<?= form_open_multipart(admin_url('category/add'));  ?> 
    					    <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						    <hr class="hr-panel-heading" />
    					    <div class="row form-group">
        					   <div class="col-md-3">
        					       <?= _l('Icon'); ?>
        					       <input type="file" class="form-control" required name="category">
        					    </div>
        					    <div class="col-md-3">
        					       <?= _l('Brand'); ?>
        					       <input type="text" class="form-control" required name="name">
        					    </div>
        					    <div class="col-md-3">
        					       <?= _l('Name'); ?>
        					       <input type="text" class="form-control" required name="name">
        					    </div>
        					    <div class="col-md-3"><br/>
        					       <button type="submit" class="btn btn-info">Save</button>
        					    </div>
    					    </div>
    				    </form>
    				    <hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Icon'),
							_l('Name'),
							_l('Brand'),
							_l('options')
							),'category'); 
						?>
    				</div>
    			</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-category', window.location.href, [1], [1],'', [0, 'desc']);
		//initDataTable('.table-sub_category', '<?= admin_url() ?>category/subCategory', [1], [1]);
	</script>
</body>
</html>
