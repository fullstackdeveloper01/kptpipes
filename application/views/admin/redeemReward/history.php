<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
	<div class="content">
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="no-margin">
                        </div>
                        <h4><?= _l($title).' List'; ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('User Type'),
							_l('Name'),
							_l('Claim-Type'),
							_l('points'),
							_l('Comments'),
							_l('status')
							),'reward'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-reward', window.location.href, [1], [1],'', [0, 'desc']);
		
		$(function(){
            appValidateForm($('#productForm'),{product:{required:true,extension: "png,jpg,jpeg,gif"},title:{required:true},category_id:{required:true},price:{required:true}});              
        });
	</script>
</body>
</html>
