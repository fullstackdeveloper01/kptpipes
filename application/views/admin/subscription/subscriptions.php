<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('subscription/add'));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" required class="form-control" name="title" >
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Prive'); ?>
    					       <input type="number" required class="form-control" name="price" >
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
							_l('Title'),
							_l('Price'),
							_l('Date'),
							_l('options')
							),'subscription'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-subscription', window.location.href, [1], [1]);
	</script>
</body>
</html>
