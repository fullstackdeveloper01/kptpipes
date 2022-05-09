<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <div class="no-margin">
    					    <a href="<?php echo admin_url('caseStudy/add'); ?>" class="btn btn-info mright5 test pull-right display-block">
                                <?php echo _l('new '.$title); ?>
                            </a>
                        </div>
						<h4><?php echo _l('Case Study List'); ?></h4>
                        <hr class="hr-panel-heading" />
						<?php render_datatable(array(
    							_l('Thumbnail'),
                                _l('Client Name'),
                                _l('Designation'),
                                _l('Title'),
    							_l('Short description'),
    							_l('Featured'),
    							_l('Status'),
    							_l('options')
							),'caseStudy'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-caseStudy', window.location.href, [1], [1], '', [0, 'desc']);

		function manageMenu(mid)
        {
          var status = '';
          if ($('#f'+mid).is(":checked"))
            status = 1;
          else
            status = 0;
          var str = "mid="+mid+"&"+"status="+status+"&"+csrfData['token_name']+"="+csrfData['hash'];
          $.ajax({
              url: '<?= admin_url()?>caseStudy/change_featured',
              type: 'POST',
              data: str,
              datatype: 'json',
              cache: false,
              success: function(resp_){
                if(resp_)
                {
                  alert_float('success', 'Updated successfully');
                }
              }
          });
        }
	</script>
</body>
</html>
