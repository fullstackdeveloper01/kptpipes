<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row" id="locationArea">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Edit City'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('city/addCity/'.$cityRow->id));  ?>
        					<div class="row form-group">
        					    <div class="col-md-3">
        					       <?= _l('Country'); ?>
        					       <select class="form-control" name="country_id" required onchange="getStatelist(this.value);">
        					           <option value=""></option>
        					           <?php
        					                if($country_result)
        					                {
        					                    foreach($country_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" <?= ($cityRow->country_id == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3">
        					       <?= _l('State'); ?>
        					       <select class="form-control" name="state_id" required id="state_id">
        					           <option value=""></option>
        					           <?php
        					                if($state_result)
        					                {
        					                    foreach($state_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" <?= ($cityRow->state_id == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					    <div class="col-md-3">
        					       <?= _l('City'); ?>
        					       <input type="text" required class="form-control" value="<?= $cityRow->name; ?>" name="name">
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Update</button>
        					   </div>
        					</div>
        				</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		//initDataTable('.table-location_country', window.location.href, [1], [1]);
		//initDataTable('.table-location_city', '<?= admin_url() ?>location/citytable', [1], [1]);
		//initDataTable('.table-location_area', '<?= admin_url() ?>location/areatable', [1], [1]);
		
		function getStatelist(Id)
		{
		    $('#state_id').html('<option value="">Please wait...</option>');
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
		                $('#state_id').html(res);
		            }
		            else
		            {
		                $('#state_id').html('<option value=""></option>');
		            }
		        }
		    });
		}
	</script>
</body>
</html>
