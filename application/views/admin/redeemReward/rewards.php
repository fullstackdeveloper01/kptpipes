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
                        </div>
                        <h4><?= _l($title).' List'; ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('User Type'),
							_l('Name'),
							_l('Claim-Type'),
							_l('points'),
							_l('status'),
							_l('Action')
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
        	console.log('id',id)
        	$('input[name="id"]').val(id);
        }
	</script>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" style="float: left;" id="exampleModalLabel">Update Redeem Request</h5>
	        <button type="button" class="close" style="float:right;" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <?= form_open_multipart(admin_url('RedeemReward/change_status'),array('id' => 'portfolioForm'));  ?>
	        	<input type="hidden" name="id">
	            <div class="form-group">
                    <span id="select"><?= _l('Select'); ?></span><span class="text-danger">*</span>
	        		<select class="form-control" name="status" id="status" required >
                            <option value="">Select Type</option>
                            <option value="1">Accept</option>
                            <option value="2">Reject</option>
                    </select>
	        	</div>
		        <div class="form-group">
                    <span id="comment"><?= _l('Comment'); ?></span><span class="text-danger">*</span>
                    <input type="text" class="form-control" required name="comment">
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
