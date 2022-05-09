<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
	    <div class="panel_s">
			<div class="panel-body">
				<h4 class="customer-profile-group-heading"><?= _l($title).' Summary'; ?></h4>
				<div class="row mbot15">
                    <!-- <div class="col-md-12">
                        <h4 class="no-margin"><?php echo _l($heading_text.' Summary'); ?></h4>
                    </div> -->
                    <?php 
                        // $order_p = $this->db->get_where(db_prefix().'orders',array('status' =>'0'))->num_rows();
                        // $order_d = $this->db->get_where(db_prefix().'orders',array('status' =>'1'))->num_rows();
                        // $order_c = $this->db->get_where(db_prefix().'orders',array('status' =>'2'))->num_rows();
                    ?>
                    <!-- <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo $order_t; ?></h3>
                        <span class="text-dark"><?php echo _l('Total '.$heading_text.' Summary'); ?></span>
                    </div>
                    <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo $order_p; ?></h3>
                        <span class="text-warning"><?php echo _l('Pending '.$heading_text); ?></span>
                    </div>
                    <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo $order_a; ?></h3>
                        <span class="text-success"><?php echo _l('Accept '.$heading_text); ?></span>
                    </div>
                    <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo $order_d; ?></h3>
                        <span class="text-primary"><?php echo _l('Delivered '.$heading_text); ?></span>
                    </div>
                    <div class="col-md-2 col-xs-6 border-right">
                        <h3 class="bold"><?php echo $order_c; ?></h3>
                        <span class="text-danger"><?php echo _l('Cancelled '.$heading_text); ?></span>
                    </div>
                    <div class="col-md-2 col-xs-6">
                        <h4><?= _l('Sort By');?></h4>
                        <select class="form-control selectpicker" onchange="selectFilter(this.value)">
                            <option value="">All</option>
                            <option value="0">Pending</option>
                            <option value="1">Accept</option>
                            <option value="2">cancelled</option>
                            <option value="3">Completed</option>
                        </select>
                    </div> -->
                </div>
                <!-- <hr class="hr-panel-heading" /> -->
        		<div class="row">
        			<div class="col-md-12">
						<?php render_datatable(array(
                            _l('OrderId'),
							_l('User Type'),
							_l('User name'),
							_l('Phone No'),
                            _l('Brand'),
				 			_l('Product Name'),
							_l('Quantity'),
				 			_l('Order Status'),
							_l('Order date'),
							// _l('Option'),
							),'order-report'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-order-report', window.location.href, [1], [1],'', [0, 'desc']);

	</script>
	<script>
		//initDataTable('.table-order', window.location.href, [1], [1]);

  function setOrderStatus(status,id)
    {
        var str = "status="+status+"&"+"id="+id+"&"+csrfData['token_name']+"="+csrfData['hash'];
        $.ajax({
            url: '<?= site_url()?>admin/orders/setOrderStatus',
            type: 'POST',
            data: str,
            dataType: 'json',
            cache: false,
            success: function(response){
                if(response.status == true){
                    alert_float('success', response.message);
                    location.reload();
                }else{
                    alert_float('warning', response.message);
                }
            }
        });
    }
    
    /* selectFilter */
	function selectFilter(sid)
	{
        console.log(sid)
	    if(sid)
	    {
	        var table = $('.table-order').DataTable();
                table.destroy();
            var _table_api = initDataTable('.table-order', '<?= admin_url() ?>orders/selectFilter/'+sid, [1], [1],'', [0, 'desc']);
                _table_api.ajax.reload();
	    }
	    else
	    {
	        var table = $('.table-order').DataTable();
                table.destroy();
            var _table_api = initDataTable('.table-order', window.location.href, [1], [1],'', [0, 'desc']);
                _table_api.ajax.reload();
	    }
	}

	</script>

</body>
</html>