<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('recommandedApps/add'));  ?>
    					<div class="panel-body">
    					    <div class="form-group">
    					       <?= _l('Image'); ?>
    					       <input type="file" class="form-control" required name="recommendedimg">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Select Type'); ?>
    					       <select name="group_id" required class="form-control">
    					           <option value=""></option>
    					           <option value="1">Online</option>
    					           <option value="2">Offline</option>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Name'); ?>
    					       <input type="text" class="form-control"required  name="name">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('URL'); ?>
    					       <input type="url" class="form-control"required  name="url">
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
							_l('Type'),
							_l('Name'),
							_l('URL'),
							_l('options')
							),'recommandedApps'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-recommandedApps', window.location.href, [1], [1]);
	</script>
</body>
</html>
