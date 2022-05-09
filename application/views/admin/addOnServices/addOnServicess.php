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
				        <?= form_open_multipart(admin_url('addOnServices/add/'.$article->id), array('id' => 'import_form'));  ?>
    					   <div class="form-group">
    					       <?= _l('Image'); ?><sup> [Extension: "png,jpg,jpeg,gif"]</sup>
    					       <input type="file" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="product">
    					       <?php
    					            if(isset($article))
    					            {
    					                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'product'))->row('file_name');
    					                echo '<img src="'.site_url('uploads/product/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
    					            }
    					       ?>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" name="title" value="<?= (isset($article))?$article->title:''; ?>" required class="form-control">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Price'); ?>
    					       <input type="number" name="price" value="<?= (isset($article))?$article->price:''; ?>" required class="form-control">
    					   </div><hr>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'addOnServices" class="btn btn-warning pull-right">Cancel</a>';
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
						<h4 class="customer-profile-group-heading"><?= _l($title.' List'); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('SN'),
							_l('Image'),
							_l('Title'),
							_l('Price'),
							_l('Size'),
							_l('Status'),
							_l('options')
							),'addOnServices'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-addOnServices', window.location.href, [1], [1]);
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{addOnServices:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{addOnServices:{required:true,extension: "png,jpg,jpeg,gif"}});
        });     

	</script>
</body>
</html>
