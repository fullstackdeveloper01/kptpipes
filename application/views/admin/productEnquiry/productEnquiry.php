<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?> List</h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Enquiry ID'),
							_l('Product Title'),
							_l('Distributor'),
							_l('Mobile'),
							_l('Product QTY'),
							_l('Product Price'),
							_l('Status'),
							_l('options')
							),'productEnquiry'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-productEnquiry', window.location.href, [1], [1],'', [0, 'desc']);		    
	</script>
</body>
</html>
