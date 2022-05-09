<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <div class="no-margin">
        				<a href="<?php echo site_url('add-user'); ?>" class="btn btn-info mright5 test pull-right display-block">
                  <?php echo _l('New User'); ?>
                </a>
              </div>
    			    <h4><?php echo _l('Users List'); ?></h4>
              <hr class="hr-panel-heading"/>
        			<?php render_datatable(array(
        				_l('S.no'),
                _l('Name'),
                _l('Email'),
        				_l('Mobile'),
                _l('role'),
          			_l('Status'),
          			_l('options')
        				),'users'); 
						  ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-users', window.location.href, [1], [1], '', [0, 'desc']);
	</script>
  <!-- <script type="text/javascript">
    function changeUserstatus(){
      var str = csrfData['token_name']+"="+csrfData['hash'];
      setTimeout(function () {
          $.ajax({
          url: '<?=site_url('admin/dealers/counts/0')?>',
          type: 'get',
          data: str,
          success: function (data) {
              console.log(data)
              $('.counts').text(data);
              alert_float('success', 'Dealer updated successfully!');
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
