<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4 hide">
				<div class="panel_s">
				    <?= form_open(admin_url('tips/add'), array('id' => 'insvideo'));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" class="form-control" required  name="title">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Description'); ?>
    					       <textarea name="description" required class="form-control tinymce" rows="15"></textarea>
    					   </div>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-success">Save</button>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<div class="no-margin">
    					    <a href="<?= admin_url('tips/add'); ?>" class="btn btn-info mright5 test pull-left display-block">
                                New <?= $title; ?>
                            </a>
                        </div><h4>&nbsp;</h4>
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
