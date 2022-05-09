<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
				    	<?= form_open_multipart(admin_url('category/add/'.$article->id), array('id' => 'import_form'));  ?>
				    	<h4 class="customer-profile-group-heading"><?= _l($title); ?> List</h4>
						<hr class="hr-panel-heading" />
    					   	<div class="form-group">
    					       	<?= _l('Icon'); ?><span class="text-danger">*</span>
    					       	<input type="file" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="category">
    					       	<?php
    					            if(isset($article))
    					            {
    					                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'category'))->row('file_name');
    					                echo '<img src="'.site_url('uploads/category/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
    					            }
    					       	?>
    					   	</div>
    					   	<div class="form-group">
    					       <?= _l('Brand'); ?><span class="text-danger">*</span>
    					       <select class="form-control selectpicker" name="brand_id[]" required multiple>
    					           	<?php
    					           		$brandarr = array();
    					           		if($article->brand_id)
    					           		{
    					           			$brandarr = explode(',', $article->brand_id);
    					           		}
    					                if($brand_list)
    					                {
    					                    foreach($brand_list as $rrr)
    					                    {
    					                    	if(in_array($rrr->id, $brandarr))
    					                    	{
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" selected><?= $rrr->brandname; ?></option>
        					                        <?php
    					                    	}
    					                    	else
    					                    	{
    					                    		?>
        					                            <option value="<?= $rrr->id; ?>"><?= $rrr->brandname; ?></option>
        					                        <?php
    					                    	}
    					                    }
    					                }
    					           ?>
    					       	</select>
    					   	</div>
    					   	<div class="form-group">
    					       <?= _l('Name'); ?><span class="text-danger">*</span>
    					       <input type="text" name="name" class="form-control" required value="<?= (isset($article))?$article->name:''; ?>">
    					   	</div>
    					   	<div class="form-group">
    					       <?= _l('Position'); ?><span class="text-danger">*</span>
    					       <select class="form-control selectpicker" name="position" required>
    					       		<option></option>
    					       		<option value="1" <?= ($article->position == 1)?"selected":""; ?>>1</option>
    					       		<option value="2" <?= ($article->position == 2)?"selected":""; ?>>2</option>
    					       		<option value="3" <?= ($article->position == 3)?"selected":""; ?>>3</option>
    					       		<option value="4" <?= ($article->position == 4)?"selected":""; ?>>4</option>
    					       		<option value="5" <?= ($article->position == 5)?"selected":""; ?>>5</option>
    					       		<option value="6" <?= ($article->position == 6)?"selected":""; ?>>6</option>
    					       		<option value="7" <?= ($article->position == 7)?"selected":""; ?>>7</option>
    					       		<option value="8" <?= ($article->position == 8)?"selected":""; ?>>8</option>
    					       		<option value="9" <?= ($article->position == 9)?"selected":""; ?>>9</option>
    					       </select>
    					   	</div>
    					   	<div class="form-group"><hr>
    					       	<button type="submit" class="btn btn-info">Save</button>
    					       	<?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'category" class="btn btn-warning pull-right">Cancel</a>';
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
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Logo'),
							_l('Name'),
							_l('Brand'),
							_l('Status'),
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
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{category:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{category:{required:true,extension: "png,jpg,jpeg,gif"}});
        });
	</script>
</body>
</html>
