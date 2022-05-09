<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
    				<div class="panel-body">
    					<?= form_open_multipart(admin_url('category/add/'.$article->id));  ?> 
    					    <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						    <hr class="hr-panel-heading" />
    					    <div class="row form-group">
        					   <div class="col-md-4">
        					       <?= _l('Selected Image'); ?>
        					       <input type="file" class="form-control"required  name="category">
        					       <?php $imageArray = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "category"))->row('file_name'); ?>
        					       <img src="<?= site_url('uploads/category/'. $article->id.'/'.$imageArray); ?>" width="50xp" height="50px" onerror="this.onerror=null;this.src='<?php echo base_url(); ?>uploads/No-image.jpeg';" />
        					    </div>
        					    <div class="col-md-4">
        					       <?= _l('Name'); ?>
        					       <input type="text" class="form-control"required value="<?= $article->name; ?>" name="name">
        					    </div>
        					    <div class="col-md-4"><br/>
        					       <button type="submit" class="btn btn-info">Update</button>
        					    </div>
    					    </div>
    				    </form>
    				    <hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Image'),
							_l('Name'),
							_l('options')
							),'category'); 
						?>
    				</div>
    			</div>
			</div>
		</div>
		<div class="row hide" id="subcategory">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Sub-'.$title); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open_multipart(admin_url('category/add'));  ?> 
        					<div class="row form-group">
        					    <div class="col-md-4">
        					       <?= _l('Image'); ?>
        					       <input type="file" class="form-control"required  name="category">
        					    </div>
        					    <div class="col-md-4">
        					       <?= _l($title); ?>
        					       <select class="form-control" name="parent_id" required>
        					           <option value=""></option>
        					           <?php
        					                if($category_result)
        					                {
        					                    foreach($category_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>"><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					    <div class="col-md-4">
        					       <?= _l('Sub-'.$title); ?>
        					       <input type="text" required class="form-control" name="name">
        					   </div>
        					</div>
        					<div class="row form-group">
        					    <div class="col-md-9 hide">
        					       <?= _l('Description'); ?>
        					       <textarea name="description" class="form-control" rows="5" placeholder="Enter descrioption"></textarea>
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Save</button>
        					   </div>
        					</div>
        				</form>
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Image'),
							_l('Name'),
							_l('Parent '.$title),
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
		initDataTable('.table-category', window.location.href, [1], [1]);
		initDataTable('.table-sub_category', '<?= admin_url() ?>category/subCategory', [1], [1]);
	</script>
</body>
</html>
