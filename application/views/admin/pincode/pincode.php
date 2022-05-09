<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Edit Pincode'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('pincode/add/'.$article->id));  ?>
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
        					                            <option value="<?= $rrr->id; ?>" <?= ($article->country_id == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3">
        					       <?= _l('State'); ?>
        					       <select class="form-control" name="state_id" required id="state_id" onchange="getCitylist(this.value);">
        					           <option value="<?= $article->state_id; ?>"><?= statename($article->state_id);?></option>
        					       </select>
        					   </div>
        					    <div class="col-md-3">
        					       <?= _l('City'); ?>
        					       <select class="form-control" name="city_id" required id="city_id" onchange="getArealist(this.value);">
        					           <option value="<?= $article->city_id; ?>"><?= cityname($article->city_id);?></option>
        					       </select>
        					   </div>
        					   <div class="col-md-3">
        					       <?= _l('Area'); ?>
        					       <select class="form-control" name="area_id" required id="area_id">
        					           <option value="<?= $article->area_id; ?>"><?= areaname($article->area_id);?></option>
        					       </select>
        					   </div>
        					</div>
        					<div class="row form-group">
        					    <div class="col-md-3">
        					       <?= _l('Pincode'); ?>
        					       <input type="number" class="form-control" value="<?= $article->pincode; ?>" name="pincode">
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
		function getStatelist(Id)
		{
		    $('#state_id').html('<option value="">Please wait...</option>');
		    $('#city_id').html('<option value=""></option>');
		    $('#area_id').html('<option value=""></option>');
		    var str = "country_id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>pincode/getStatelist',
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
		    $('#area_id').html('<option value=""></option>');
		    var str = "state_id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>pincode/getCitylist',
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
		
		function getArealist(Id)
		{
		    $('#area_id').html('<option value="">Please wait...</option>');
		    var str = "city_id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>pincode/getArealist',
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
		                   res += '<option value="'+resp[i].id+'">'+resp[i].areaname+'</option>';
		                }
		                $('#area_id').html(res);
		            }
		            else
		            {
		                $('#area_id').html('<option value=""></option>');
		            }
		        }
		    });
		}
	</script>
</body>
</html>
