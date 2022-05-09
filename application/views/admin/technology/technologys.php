<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
                        <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
                        <hr class="hr-panel-heading" />
				        <?= form_open_multipart(admin_url('technology/add/'.$article->id), array('id' => 'import_form'));  ?>
    					   <div class="form-group">
    					       <?= _l('Icon'); ?>
    					       <input type="file" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="technology">
    					       <?php
    					            if(isset($article))
    					            {
    					                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'technology'))->row('file_name');
    					                echo '<img src="'.site_url('uploads/technology/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
    					            }
    					       ?>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Technology'); ?>
    					       <input type="text" name="technology_name" value="<?= (isset($article))?$article->technology:''; ?>" required class="form-control">
    					   </div>
    					   <div class="form-group"><hr>
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo ' <a href="'.admin_url().'technology" class="btn btn-warning">Cancel</a>';
    					            }
    					       ?>
    					   </div>
    				    </form>
    				</div>
    			</div>
			</div>
			<div class="col-md-8">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?> List</h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('SN'),
							_l('Icon'),
							_l('Technology'),
							_l('Status'),
							_l('options')
							),'technology'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-technology', window.location.href, [1], [1], '', [0, 'desc']);
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{technology:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{technology:{required:true,extension: "png,jpg,jpeg,gif"}});
        });     

	</script>
</body>
</html>
