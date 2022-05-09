<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style type="text/css">
	.modal-header {
	    background: #5cb9db;
	}
</style>
<div id="wrapper">
	<div class="content">
		<div class="panel_s">
			<div class="panel-body">
				<div class="row">
					<div class="col-md-12">
						<div class="no-margin">
              				<a href="javascript:void(0)" class="btn btn-info mright5 test pull-right display-block" data-toggle="modal" data-target="#exampleModal" onclick="openModel('<?= $this->uri->segment(2);?>')">
                              <?php echo _l('Claim Reward'); ?>
                            </a>
                          </div>
                        <h4><?= _l($title).' List'; ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('S.No'),
							_l('User Name'),
							_l('Brand'),
							_l('Product'),
							_l('Reward'),
							_l('Comment'),
							_l('Status'),
							// _l('Action')
							),'reward'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-reward', window.location.href, [1], [1],'', [0, 'desc']);
		
		$(function(){
            appValidateForm($('#productForm'),{product:{required:true,extension: "png,jpg,jpeg,gif"},title:{required:true},category_id:{required:true},price:{required:true}});              
        });
		function openModel(id){
        	$('input[name="userid"]').val(id);
        }
	</script>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" style="float: left;" id="exampleModalLabel">Add Reward Claim</h5>
	        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <?= form_open_multipart(admin_url('Distributors/claimReward'),array('id' => 'portfolioForm'));  ?>
	        	<input type="hidden" name="userid">
	            <div class="form-group">
                    <span id="select"><?= _l('Reward Type'); ?></span><span class="text-danger">*</span>
	        		<select class="form-control" name="claim_type" id="status" required >
                            <option value="">Select Type</option>
                            <option value="cashreward">Cash Reward</option>
                            <option value="giftvoucher">Gift Voucher</option>
                    </select>
	        	</div>

	        	<div class="form-group">
                    <span id="comment"><?= _l('Points'); ?></span><span class="text-danger">*</span>
                    <input type="text" class="form-control" pattern="[0-9]*" required name="points" placeholder="100">
                </div>

		        <div class="form-group">
                    <span id="comment"><?= _l('Comment'); ?></span><span class="text-danger">*</span>
                    <input type="text" class="form-control" required name="comment" placeholder="Enter Comment">
                </div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Save changes</button>
	      </div>
	        </form>
	    </div>
	  </div>
	</div>
</body>
</html>

