<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
				    	<?= form_open_multipart(admin_url('discount/add/'.$article->id), array('id' => 'import_form'));  ?>
				    	<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" name="title" class="form-control" required value="<?= (isset($article))?$article->title:''; ?>">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Discount Price'); ?>
    					       <input type="number" name="discount_value" class="form-control" required value="<?= (isset($article))?$article->discount_value:''; ?>">
    					   </div>
    					   <div class="form-group">
    					       	<?= _l('Discount Type'); ?>
    					       	<select name="discount_type" class="form-control" required>
    					      		<option></option>
    					      		<option value="Fixed" <?= ($article->discount_type == "Fixed")?"selected":""; ?>>Fixed</option>
    					      		<option value="Percentage" <?= ($article->discount_type == "Percentage")?"selected":""; ?>>Percentage</option>
    					       	</select>
    					   </div>
    					   <div class="form-group"><hr>
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'discount" class="btn btn-warning pull-right">Cancel</a>';
    					            }
    					       ?>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
			<div class="col-md-8">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?> List</h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Title'),
							_l('Discount Value'),
							_l('Type'),
							_l('Status'),
							_l('options')
							),'discount'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-discount', window.location.href, [1], [1],'', [0, 'desc']);
		$(function(){
            appValidateForm($('#import_form'));
        });     
	</script>
</body>
</html>
