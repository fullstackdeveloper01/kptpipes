<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="no-margin">
              				<a href="<?php echo site_url('add-stocks'); ?>" class="btn btn-info mright5 test pull-right display-block">
                              <?php echo _l('New Stock'); ?>
                            </a>
                        </div>
                        <h4><?= _l($title).' List'; ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('S.no'),
							_l('Brand'),
							_l('Product'),
							_l('Bach-No'),
							_l('Quantity'),
				 			_l('Status'),
							_l('options')
							),'stocks'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-stocks', window.location.href, [1], [1],'', [0, 'desc']);
	</script>
</body>
</html>
