<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					<h4 class="no-margin">
					<?php echo $title; ?>
					</h4>
					<hr class="hr-panel-heading" />
						<?php echo form_open($this->uri->uri_string()); ?>
						<div class="row editform" style="display:none">
						    <div class="col-md-4">
						        <?= _l('Price'); ?>
						        <?php $contents = ''; if(isset($aboutus)){$contents = $aboutus;} ?>
        						<input type="number" name="description" class="form-control" value="<?= $contents; ?>" required>
						    </div>
						    <div class="col-md-1">
						        <br><button type="submit" class="btn btn-info pull-right"><?php echo _l('submit'); ?></button>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-12">
						        <table class="table table-location_country dataTable no-footer dtr-inline" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th >Price</th>
                                            <th >Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr role="row" class="odd">
                                            <td class="sorting_1" tabindex="0">
                                                <?= $contents; ?>
                                            </td>
                                            <td>
                                                <span class="btn btn-default btn-icon" onclick="priceEdit()" style="cursor:pointer">
                                                    <i class="fa fa-pencil-square-o"></i>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
						    </div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
<script>
    function priceEdit()
    {
        $('.editform').css('display','block');
    }
</script>
</body>
</html>
