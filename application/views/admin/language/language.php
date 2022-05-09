<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('language/add/'.@$article->id));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Language'); ?>
    					       <input type="text" class="form-control" value="<?= (isset($article)?$article->name:""); ?>" name="name" />
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Flag'); ?>
    					       <?php
    					            if(isset($article))
    					            {
    					                $imageArray = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "languageflag"))->row();
    					                ?>
    					                    <img src="<?= site_url('download/file/taskattachment/'. $imageArray->attachment_key); ?>" width="50xp" height="50px" />
    					                <?php
    					            }
    					       ?>
    					       <input type="file" name="languageflag" />
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
							_l('Language'),
							_l('Date'),
							_l('options')
							),'language'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-language', window.location.href, [1], [1]);
	</script>
</body>
</html>
