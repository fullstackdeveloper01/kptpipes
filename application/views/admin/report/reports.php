<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
	    <div class="panel_s">
			<div class="panel-body">
				<h4 class="customer-profile-group-heading"><?= _l($title).' List'; ?></h4>
				<div class="row mbot15">
                    <div class="col-md-3 pull-right">
                        <select class="form-control selectpicker" onchange="selectFilter(this.value)">
                            <option value=""></option>
                            <option value="">Total Report</option>
                            <option value="1">Monthly</option>
                            <option value="2">Weekly</option>
                            <option value="3">Today</option>
                        </select>
                    </div>
                </div>
                <hr class="hr-panel-heading" />
        		<div class="row">
        			<div class="col-md-12">
						<?php render_datatable(array(
							_l('#Id'),
							_l('User name'),
							_l('Phone No'),
							_l('Price'),
				 			_l('Status'),
							_l('Order date'),
							),'report'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-report', window.location.href, 'undefined','undefined','undefined', [0,'DESC']);
		
		/* selectFilter */
		function selectFilter(sid)
		{
		    if(sid)
		    {
		        var table = $('.table-report').DataTable();
                    table.destroy();
                var _table_api = initDataTable('.table-report', '<?= admin_url() ?>report/selectFilter/'+sid, 'undefined','undefined','undefined', [0,'DESC']);
                    _table_api.ajax.reload();
		    }
		    else
		    {
		        var table = $('.table-report').DataTable();
                    table.destroy();
                var _table_api = initDataTable('.table-report', window.location.href, 'undefined','undefined','undefined', [0,'DESC']);
                    _table_api.ajax.reload();
		    }
		}
	</script>
</body>
</html>