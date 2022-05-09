<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <div class="panel-body">
				        <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open(admin_url('priceRange/add/'.$article->id), array('id' => 'import_form'));  ?>
    					   <div class="form-group">
    					       <?= _l('Price'); ?>
    					       <input type="number" name="price" autocomplete="off" min="1" max="9999999" value="<?= (isset($article))?$article->price:''; ?>" required class="form-control">
    					   </div><hr>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'priceRange" class="btn btn-warning pull-right">Cancel</a>';
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
							_l('Price'),
							_l('options')
							),'priceRange'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-priceRange', window.location.href, [1], [1]);
		var sid = '<?= $article->id ?>';
	
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{price:{required:true}});
            else
                appValidateForm($('#import_form'),{price:{required:true}});
        });     

	</script>
</body>
</html>
