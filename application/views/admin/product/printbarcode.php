<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
	<div class="content">
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="no-margin">
              				<a href="javascript:void(0)" class="btn btn-info mright5 test pull-right display-block printMe">
                              <?php echo _l('Print Barcode'); ?>
                            </a>
                        </div>
                    </div>
                </div>
				<div class="row " id="outprint">
					<?php
						foreach ($response as $key => $value) {
							if (($key % 2)==0) {
								$class="left";
							}else{
								$class="right";
							}
							?>
							<div class="col-sm-6" style="padding-bottom: 80px; float: <?=$class?>;">
								<img src="<?=site_url().'/'.$value['image']?>" width="250" height="125">
							</div>
						<?php }
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		$(".printMe").click(function(){
		   // window.print();
		   var printContents = document.getElementById('outprint').innerHTML;
		     var originalContents = document.body.innerHTML;

		     document.body.innerHTML = printContents;

		     window.print();

		     // document.body.innerHTML = originalContents;
		});
		// initDataTable('.table-stocks', window.location.href, [1], [1],'', [0, 'desc']);
	</script>
</body>
</html>
