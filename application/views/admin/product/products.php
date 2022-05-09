<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="no-margin">
              				<a href="<?php echo admin_url('products/add'); ?>" class="btn btn-info mright5 test pull-right display-block">
                              <?php echo _l('new Product'); ?>
                            </a>
                        </div>
                        <h4><?= _l($title).' List'; ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Image'),
							_l('Title'),
							// _l('Category'),
							// _l('Sub Category'),
							_l('Brand'),
							_l('HSN Code'),
							_l('SKU Code'),
							_l('Size'),
							_l('Color'),
							_l('Created Date'),
				 			_l('Status'),
							_l('options')
							),'products'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-products', window.location.href, [1], [1],'', [0, 'desc']);
		
		$(function(){
            appValidateForm($('#productForm'),{product:{required:true,extension: "png,jpg,jpeg,gif"},title:{required:true},category_id:{required:true},price:{required:true}});              
        });
	</script>
</body>
</html>
