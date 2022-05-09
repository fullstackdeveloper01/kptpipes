	<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <div class="no-margin">
              				<a href="<?php echo admin_url('distributors/add'); ?>" class="btn btn-info mright5 test pull-right display-block">
                              <?php echo _l('new distributor'); ?>
                            </a>
                          </div>
              			   <h4><?php echo _l('Distributors List'); ?></h4>
                          <hr class="hr-panel-heading" />
                          <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l($title.' Summary'); ?></h4>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold totalcount"><?php echo $this->db->get_where(db_prefix().'distributors')->num_rows(); ?></h3>
                                <span class="text-dark"><?php echo _l($title.' Summary total'); ?></span>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold activecount"><?php echo $this->db->get_where(db_prefix().'distributors', array('status' => 1))->num_rows(); ?></h3>
                                <span class="text-success"><?php echo _l('Active '.$title); ?></span>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold counts" ><?php echo $this->db->get_where(db_prefix().'distributors', array('status' => 0))->num_rows(); ?></h3>
                                <span class="text-danger"><?php echo _l('Inactive Active '.$title); ?></span>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" />
              			<?php render_datatable(array(
            				_l('Name'),
                            _l('Business Name'),
            				_l('Mobile'),
                            _l('Email'),
            				_l('DOJ'),
                            _l('Permanent Address'),
                			_l('Status'),
                			_l('options')
              				),'distributors'); 
  						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-distributors', window.location.href, [1], [1], '', [0, 'desc']);
	</script>
  <script type="text/javascript">
    function changeDistributorstatus(id){
      var str = csrfData['token_name']+"="+csrfData['hash'];
      setTimeout(function () {
          $.ajax({
          url: '<?=site_url('admin/distributors/counts/0')?>',
          type: 'get',
          data: str,
          success: function (data) {
              // console.log(data)
              var count = $('.counts').text();
              if (count != data) {
                var total = parseInt($('.totalcount').text())-parseInt(data);

                $('.activecount').text(total);
              	$('.counts').text(data);
              	alert_float('success', 'Distributors updated successfully!');
              }else{
              	$('#'+id).removeAttr('checked');
              	alert_float('danger', 'Distributors Not updated!');
              }
          },
          cache: false,
          contentType: false,
          processData: false
      })
        }, 300);
      

    }
  </script>
</body>
</html>
