<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('audioBook/add/'.$article->id));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" required class="form-control" value="<?= $article->title; ?>" name="title">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Description'); ?>
    					       <textarea name="description" class="form-control" rows="15"><?= $article->description; ?></textarea>
    					   </div>
    					   <?php $imageArray = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "audiobookimg"))->row(); ?>
    					   <?php $audioArray = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "audiobookfile"))->row(); ?>
    					   <div class="form-group">
    					       <?= _l('Upload Image'); ?>
    					       <img src="<?= site_url('download/file/taskattachment/'. $imageArray->attachment_key); ?>" width="50xp" height="50px" />
    					       <!--<input type="file" class="form-control" name="audiobookimg">-->
    					   </div>
    					   <div class="form-group">
    					        <?= _l('Upload MP3 File'); ?>
    					        <audio controls>
                                    <source src="<?= site_url('download/file/taskattachment/'. $audioArray->attachment_key); ?>" type="audio/mpeg">
                                </audio>
    					        <!--<input type="file" class="form-control" name="audiobookfile">-->
    					   </div>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Update</button>
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
							_l('Image Size'),
							_l('Audio File Size'),
							_l('Description'),
							_l('options')
							),'audioBook'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-audioBook', window.location.href, [1], [1]);
	</script>
</body>
</html>
