<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
				    	<?= form_open_multipart(admin_url('subCategory/add/'.$article->id), array('id' => 'import_form'));  ?>
				    	<h4 class="customer-profile-group-heading"><?= _l($title); ?> List</h4>
						<hr class="hr-panel-heading" />
    					   	<div class="form-group">
    					       <?= _l('Icon'); ?>
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
    					       <?= _l('Main Category'); ?>
    					       <select class="form-control" name="parent_id" required>
    					           <option value=""></option>
    					           <?php
    					                if($category_result)
    					                {
    					                    foreach($category_result as $rrr)
    					                    {
    					                        ?>
    					                            <option value="<?= $rrr->id; ?>" <?= ($article->parent_id == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
    					                        <?php
    					                    }
    					                }
    					           ?>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Name'); ?>
    					       <input type="text" name="name" class="form-control" required value="<?= (isset($article))?$article->name:''; ?>">
    					   </div>
    					   <div class="form-group"><hr>
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'subCategory" class="btn btn-warning pull-right">Cancel</a>';
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
							_l('Main Category'),
							_l('Name'),
							_l('Status'),
							_l('options')
							),'sub_category'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-sub_category', window.location.href, [1], [1],'', [0, 'desc']);
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
