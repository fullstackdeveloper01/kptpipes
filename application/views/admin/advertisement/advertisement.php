<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
				    	<?= form_open_multipart(admin_url('advertisement/add/'.$article->id), array('id' => 'import_form'));  ?>
				    	<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
    					   	<div class="form-group">
    					       <?= _l('Banner'); ?>
    					       <input type="file" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="advertisement">
    					       <?php
    					            if(isset($article))
    					            {
    					                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'advertisement'))->row('file_name');
    					                echo '<img src="'.site_url('uploads/advertisement/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
    					            }
    					       ?>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Company Name'); ?>
    					       <input type="text" name="title" class="form-control" required value="<?= (isset($article))?$article->title:''; ?>">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Redirect URL'); ?>
    					       <input type="text" name="redirect_url" class="form-control" value="<?= (isset($article))?$article->redirect_url:''; ?>">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Start Date'); ?>
    					       <input type="text" name="start_date" id="start_date" required class="form-control" value="<?= (isset($article))?date('Y-m-d',$article->start_date):''; ?>">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('End Date'); ?>
    					       <input type="text" name="end_date" id="end_date" required class="form-control" value="<?= (isset($article))?date('Y-m-d',$article->end_date):''; ?>">
    					   </div>
    					   <div class="form-group"><hr>
    					       <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php echo _l('wait_text'); ?>">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'advertisement" class="btn btn-warning pull-right">Cancel</a>';
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
							_l('Banner'),
							_l('Company Name'),
							_l('Start Date'),
							_l('End Date'),
							_l('Status'),
							_l('options')
							),'advertisement'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-advertisement', window.location.href, [1], [1],'', [0, 'desc']);
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{advertisement:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{advertisement:{required:true,extension: "png,jpg,jpeg,gif"}});
        });     

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

        $("#advertid").click(function() {
			setTimeout(function(){
                $("#advertid").removeAttr("disabled");
                $("#advertid").removeClass("disabled");
                $('#advertid').text('Save');
            }, 5000);
		});
	</script>
</body>
</html>
