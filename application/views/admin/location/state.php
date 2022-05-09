<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row" id="locationCity">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Edit State'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('state/addState/'.$city_result->id));  ?>
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
        					                            <option value="<?= $rrr->id; ?>" <?= ($city_result->country_id == $rrr->id)?"selected":""; ?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					    <div class="col-md-3">
        					       <?= _l('State Code'); ?>
        					       <input type="text" required class="form-control" value="<?= $city_result->state_code; ?>" name="state_code">
        					   </div>
                                                    <div class="col-md-3">
                                                       <?= _l('State'); ?>
                                                       <input type="text" required class="form-control" value="<?= $city_result->name; ?>" name="name">
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
	</script>
</body>
</html>
