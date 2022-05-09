<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <h4 class="customer-profile-group-heading"><?= _l('Website Heading'); ?></h4>
              <hr class="hr-panel-heading" />
						  <?php render_datatable(array(
    							_l('Heading'),
    							_l('Button Text'),
    							_l('Button Link'),
    							_l('options')
							),'websiteHeading'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-websiteHeading', window.location.href, [1], [1], '', [0, 'desc']);
	</script>
</body>
</html>
