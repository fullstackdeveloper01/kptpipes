<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row" id="carmodel"><?php /* ?>
		    <div class="col-md-3">
			    <div class="panel_s">
			        <div class="panel-body">
			            <h4 class="customer-profile-group-heading"><?= _l('State bulk upload'); ?></h4>
						<hr class="hr-panel-heading" />
    				    <div class="form-group">
					       <a href="<?= admin_url('state/sampleStateData'); ?>" class="btn btn-success">Download Sample</a>
					   </div>
					   <?= form_open_multipart(admin_url('state/saveState'));  ?>
    					   <div class="form-group">
    					       <input type="file" name="fileURL" required id="file-url" class="filestyle form-control" data-allowed-file-extensions="[XLSX, xlsx]" accept=".XLSX, .xlsx" data-buttontext="Choose File">
    					   </div>
    					   <div class="form-groupt">
                                <button type="submit" class="btn btn-primary mrgT">Import</button>
                            </div>  
                        </form>
    				</div>
			    </div>
			</div><?php */ ?>
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Add State'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('state/addState'));  ?>
        					<div class="row form-group">
        					    <div class="col-md-3">
        					       <?= _l('Country'); ?>
        					       <select class="form-control" name="country_id" required>
        					           <option value=""></option>
        					           <?php
        					                if($country_result)
        					                {
        					                    foreach($country_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>"><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					    <div class="col-md-3">
        					       <?= _l('State Code'); ?>
        					       <input type="text" required class="form-control" name="state_code">
        					   </div>
        					    <div class="col-md-3">
        					       <?= _l('State'); ?>
        					       <input type="text" required class="form-control" name="name">
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Save State</button>
        					   </div>
        					</div>
        				</form>
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Country'),
							_l('Code'),
							_l('State'),
							_l('Status'),
							_l('options')
							),'location_city'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-location_city', window.location.href, [1], [1]);
		
		function getStatelist(Id)
		{
		    $('#city_id').html('<option value="">Please wait...</option>');
		    var str = "country_id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>location/getStatelist',
		        type: 'POST',
		        data: str,
		        datatype: 'json',
		        cache: false,
		        success: function(resp_){
		            if(resp_)
		            {
		                var resp = JSON.parse(resp_);
		                var res = '<option value=""></option>';
		                for(var i=0; i<resp.length; i++)
		                {
		                   res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
		                }
		                $('#city_id').html(res);
		            }
		            else
		            {
		                $('#city_id').html('<option value=""></option>');
		            }
		        }
		    });
		}
	</script>
</body>
</html>
