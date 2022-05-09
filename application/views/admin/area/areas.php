<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row" id="locationArea">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Area'); ?></h4>
						<div class="row">
						    <div class="col-md-3">
						        <div class="form-group">
						            <p><?= _l('Sample file'); ?></p>
        					       <a href="<?= admin_url('area/sampledataArea'); ?>" class="btn btn-success">Download Sample</a>
        					    </div>
						    </div>
						    <div class="col-md-6">
						        <?= form_open_multipart(admin_url('area/saveArea'), array('id' => 'import_form'));  ?>
    						        <div class="row">
    						            <div class="col-md-6">
    						                <div class="form-group">
    						                    <p><?= _l('Area and pincode Bulk upload'); ?></p>
                    					       <input type="file" name="fileURL" required id="file-url" class="filestyle" data-allowed-file-extensions="[XLSX, xlsx]" accept=".XLSX, .xlsx" data-buttontext="Choose File">
                    					   </div>
    						            </div>
    						            <div class="col-md-6">
    						                <div class="form-groupt">
    						                    <p><?= _l('Action'); ?></p>
                                                <button type="submit" class="btn btn-primary mrgT">Import</button>
                                            </div> 
    						            </div>
						            </div>
                                </form>
						    </div>
						</div>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('area/add'), ['id' => 'area_form']);  ?>
        					<div class="row form-group">
        					    <div class="col-md-3">
        					       <?= _l('Country'); ?>
        					       <select class="form-control" name="country_id" onchange="getStatelist(this.value);">
        					           <option value=""></option>
        					           <?php
        					                if($country_result)
        					                {
        					                    foreach($country_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" <?= ($Area_result->country_id == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3">
        					       <?= _l('State'); ?>
        					       <select class="form-control" name="state_id" required id="state_id" onchange="getCitylist(this.value);">
        					           <option value=""></option>
        					       </select>
        					   </div>
        					    <div class="col-md-3">
        					       <?= _l('City'); ?>
        					       <select class="form-control" name="city_id" required id="city_id">
        					           <option value=""></option>
        					       </select>
        					   </div>
        					   <div class="col-md-3">
        					       <?= _l('Area'); ?>
        					       <input type="text" required class="form-control" name="areaname">
        					   </div>
        					</div>
        					<div class="row form-group">
        					    <div class="col-md-3">
        					       <?= _l('Extra charge'); ?>
        					       <input type="number" class="form-control" name="extra_charge">
        					   </div>
        					   <div class="col-md-3">
        					       <?= _l('Time slot'); ?>
        					       <!--<input type="time" required class="form-control" name="from_time">-->
        					       <select class="form-control selectpicker" data-live-search="true" name="time_slot[]" multiple required>
        					            <?php
        					                if($timeslot_list)
        					                {
            					                foreach($timeslot_list as $r)
            					                {
            					                    ?>
            					                        <option value="<?= $r->time_text; ?>"><?= $r->time_text; ?></option>                
            					                    <?php
            					                }
        					                }
        					            ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Submit</button>
        					   </div>
        					</div>
        				</form>
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Country'),
							_l('State'),
							_l('City'),
							_l('Area'),
							_l('Extra Price'),
							_l('Time Slot'),
							_l('Status'),
							_l('options')
							),'area'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-area', window.location.href, [1], [1]);
		//initDataTable('.table-location_country', window.location.href, [1], [1]);
		//initDataTable('.table-location_city', '<?= admin_url() ?>location/citytable', [1], [1]);
		//initDataTable('.table-location_area', '<?= admin_url() ?>location/areatable', [1], [1]);
		
		$(function(){
            appValidateForm($('#area_form'),{country_id:required});
        });
		
		function getStatelist(Id)
		{
		    $('#state_id').html('<option value="">Please wait...</option>');
		    $('#city_id').html('<option value=""></option>');
		    var str = "country_id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>area/getStatelist',
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
		                $('#state_id').html(res);
		            }
		            else
		            {
		                $('#state_id').html('<option value=""></option>');
		            }
		        }
		    });
		}
		
		function getCitylist(Id)
		{
		    $('#city_id').html('<option value="">Please wait...</option>');
		    var str = "state_id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>area/getCitylist',
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
		$(function(){
            appValidateForm($('#import_form'),{fileURL:{required:true,extension: "csv"}});
        });
	</script>
</body>
</html>
