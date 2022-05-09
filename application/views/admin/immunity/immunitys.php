<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <div class="no-margin">
    					    <a href="<?php echo admin_url('immunity/add'); ?>" class="btn btn-info mright5 test pull-left display-block">
                                <?php echo _l('new '.$title); ?>
                            </a>
                        </div>
						<h4>&nbsp;</h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('SNo.'),
							_l('Questions English'),
							_l('Questions Hindi'),
							_l('Always'),
							_l('Sometimes'),
							_l('Never'),
							_l('options')
							),'immunity'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-immunity', window.location.href, [1], [1]);
	</script>
</body>
</html>
