<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <div class="no-margin">
    					    <a href="<?php echo admin_url('patient/add'); ?>" class="btn btn-info mright5 test pull-left display-block">
                                <?php echo _l('new '.$title); ?>
                            </a>
                        </div>
						<h4>&nbsp;</h4>
						<hr class="hr-panel-heading" />
						<div class="row mbot15">
						    <?php
						        $where_summary = '';
						    ?>
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l($heading_text.' Summary'); ?></h4>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold"><?php echo total_rows(db_prefix().'_patient',($where_summary != '' ? substr($where_summary,5) : '')); ?></h3>
                                <span class="text-dark"><?php echo _l($heading_text.' Summary total'); ?></span>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold"><?php echo total_rows(db_prefix().'_patient','status=1'.$where_summary); ?></h3>
                                <span class="text-success"><?php echo _l('Active '.$heading_text); ?></span>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold"><?php echo total_rows(db_prefix().'_patient','status=0'.$where_summary); ?></h3>
                                <span class="text-danger"><?php echo _l('Inactive Active '.$heading_text); ?></span>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
						<?php render_datatable(array(
    							_l('Name'),
    							_l('Mobile'),
    							_l('Date of birth'),
    							_l('Age'),
    							_l('State'),
    							_l('City'),
    							_l('Address'),
    							_l('Type'),
    							_l('options')
							),'patient'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-patient', window.location.href, [1], [1]);
	</script>
</body>
</html>
