<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('promocode/add'));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" required class="form-control" name="title" >
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Discount Price'); ?>
    					       <input type="text" required class="form-control" name="discount_price" >
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Start Date'); ?>
    					       <input type="text" required class="form-control" autocomplete="off" name="start_date" id="start_date">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('End Date'); ?>
    					       <input type="text" required class="form-control" autocomplete="off" name="end_date" id="end_date">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Limit'); ?>
    					       <input type="number" required class="form-control" name="code_limit" >
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
							_l('Discount Price'),
							_l('Start Date'),
							_l('End Date'),
							_l('Limit'),
							_l('options')
							),'promocode'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-promocode', window.location.href, [1], [1]);
		
		$(document).ready(function(){
            $("#start_date").datepicker({
                minDate:0,
                dateFormat: 'yy-mm-dd',
                onSelect: function(selected) {
                  $("#end_date").datepicker("option","minDate", selected)
                }
            });
            $("#end_date").datepicker({ 
                minDate:0,
                dateFormat: 'yy-mm-dd',
                onSelect: function(selected) {
                   $("#start_date").datepicker("option","maxDate", selected)
                }
            });  
        });
	</script>
</body>
</html>
