<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
				    <div class="panel-body">
				        <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
				        <?= form_open_multipart(admin_url('tips/add/'.$article->id), array('id' => 'insvideo'));  ?>
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" value="<?= $article->title; ?>" class="form-control" required  name="title">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Description'); ?>
    					       <textarea name="description" required class="form-control tinymce" rows="15"><?= $article->description; ?></textarea>
    					   </div>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-success">Submit</button>
    					       <a href="<?= admin_url('tips'); ?>" class="btn btn-warning">Cancel</a>
    					   </div>
    				    </form>
    				</div>
    			</div>
			</div>
			<div class="col-md-8 hide">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Title'),
							_l('Description'),
							_l('options')
							),'tips'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-tips', window.location.href, [1], [1]);
		
		$("#insvideo").validate();
	</script>
</body>
</html>
