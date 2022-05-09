<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
				    	<?= form_open_multipart(admin_url('brand/add/'.$article->id), array('id' => 'import_form'));  ?>
				    	<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
    					   	<div class="form-group">
    					       <?= _l('Logo'); ?>
    					       <input type="file" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="brand">
    					       <?php
    					            if(isset($article))
    					            {
    					                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'brand'))->row('file_name');
    					                echo '<img src="'.site_url('uploads/brand/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
    					            }
    					       ?>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Name'); ?>
    					       <input type="text" name="brandname" class="form-control" required value="<?= (isset($article))?$article->brandname:''; ?>">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Website'); ?>
    					       <input type="text" name="website" class="form-control" value="<?= (isset($article))?$article->website:''; ?>">
    					   </div>
    					   <div class="form-group"><hr>
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'brand" class="btn btn-warning pull-right">Cancel</a>';
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
							_l('Logo'),
							_l('Name'),
							_l('Website'),
							_l('Size'),
							_l('Status'),
							_l('options')
							),'brand'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-brand', window.location.href, [1], [1],'', [0, 'desc']);
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{brand:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{brand:{required:true,extension: "png,jpg,jpeg,gif"}});
        });     
	</script>
</body>
</html>
