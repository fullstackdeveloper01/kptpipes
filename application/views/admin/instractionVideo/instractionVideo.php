<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('instractionVideo/add/'.$article->id), array('id' => 'insvideo'));  ?>
    					<div class="panel-body">
    					   <div class="form-group hide">
    					       <?= _l('Select Type'); ?>
    					       <select name="group_id" class="form-control">
    					           <option value=""></option>
    					           <option value="1" <?= ($article->group_id == 1)?"selected":""; ?>>Online</option>
    					           <option value="2" <?= ($article->group_id == 2)?"selected":""; ?>>Offline</option>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Name'); ?>
    					       <input type="text" value="<?= $article->name; ?>" class="form-control"required  name="name">
    					   </div>
    					   <div class="form-group">
    					        <?= _l('Upload Video'); ?>
    					        <?php $audioArray = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "instractionVideofile"))->row(); ?>
                                <video width="320" height="240" controls>
                                  <source src="<?= site_url('download/file/taskattachment/'. $audioArray->attachment_key); ?>" type="video/mp4">
                                </video>
    					        <!--<input type="file" class="form-control"  name="instractionVideofile">-->
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
							//_l('Type'),
							_l('Name'),
							_l('File Size'),
							_l('options')
							),'instractionVideos'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-instractionVideos', window.location.href, [1], [1]);
		
		$("#insvideo").validate();
	</script>
</body>
</html>
