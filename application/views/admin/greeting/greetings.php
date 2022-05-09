<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    
              			   <h4><?php echo _l('Greetings List'); ?></h4>
                          <hr class="hr-panel-heading"/>
                          <!-- <div class="row mbot15">
                            <div class="col-md-12">
                                <h4 class="no-margin"><?php echo _l($title.' Summary'); ?></h4>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold totalcount"><?php echo $this->db->get_where(db_prefix().'dealer')->num_rows(); ?></h3>
                                <span class="text-dark"><?php echo _l($title.' Summary total'); ?></span>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold activecount"><?php echo $this->db->get_where(db_prefix().'dealer', array('status' => 1))->num_rows(); ?></h3>
                                <span class="text-success"><?php echo _l('Active '.$title); ?></span>
                            </div>
                            <div class="col-md-4 col-xs-6 border-right">
                                <h3 class="bold counts"><?php echo $this->db->get_where(db_prefix().'dealer', array('status' => 0))->num_rows(); ?></h3>
                                <span class="text-danger"><?php echo _l('Inactive Active '.$title); ?></span>
                            </div>
                        </div>
                        <hr class="hr-panel-heading" /> -->
              			<?php render_datatable(array(
            				  _l('S.no'),
                      _l('Type'),
                      _l('Brand'),
                      _l('Name'),
            				  _l('Mobile'),
                      _l('Email'),
                      _l('Date'),
                			_l('Action')
              				),'greeting'); 
  						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-greeting', window.location.href, [1], [1], '', [0, 'desc']);
	</script>
  <!-- <script type="text/javascript">
    function changeDealerstatus(id){
      var str = csrfData['token_name']+"="+csrfData['hash'];
      setTimeout(function () {
          $.ajax({
          url: '<?=site_url('admin/dealers/counts/0')?>',
          type: 'get',
          data: str,
          success: function (data) {
              var count = $('.counts').text();
              if (count != data) {
                var total = parseInt($('.totalcount').text())-parseInt(data);

                $('.activecount').text(total);
                $('.counts').text(data);
                alert_float('success', 'Dealer updated successfully!');
              }else{
                $('#'+id).removeAttr('checked');
                alert_float('danger', 'Dealer Not updated!');
              }
          },
          cache: false,
          contentType: false,
          processData: false
      })
        }, 300);
    }
  </script> -->
</body>
</html>
