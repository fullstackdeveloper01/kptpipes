<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Country Update'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('location/add/'.$article->id));  ?>
        					<div class="row form-group">
        					    <div class="col-md-6">
        					       <?= _l('Country'); ?>
        					       <input type="text" required value="<?= (isset($article) ? $article->name : '')?>" class="form-control" name="name">
        					   </div>
        					   <div class="col-md-6"><br>
        					       <button type="submit" class="btn btn-info">Update Country</button>
        					   </div>
        					</div>
        				</form>
        				<!--
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Country'),
							_l('options')
							),'location_country'); 
						?>
						-->
					</div>
				</div>
			</div>
		</div>
		<?php /* ?>
		<div class="row" id="locationCity">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Add City'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('location/addCity'));  ?>
        					<div class="row form-group">
        					    <div class="col-md-4">
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
        					    <div class="col-md-4">
        					       <?= _l('City'); ?>
        					       <input type="text" required class="form-control" name="name">
        					   </div>
        					   <div class="col-md-4"><br>
        					       <button type="submit" class="btn btn-info">Update City</button>
        					   </div>
        					</div>
        				</form>
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Country'),
							_l('City'),
							_l('options')
							),'location_city'); 
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row" id="locationArea">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Add Area'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('location/addArea'));  ?>
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
        					       <?= _l('City'); ?>
        					       <select class="form-control" name="city_id" required>
        					           <option value=""></option>
        					           <?php
        					                if($city_result)
        					                {
        					                    foreach($city_result as $rrr)
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
        					       <?= _l('Area'); ?>
        					       <input type="text" required class="form-control" name="name">
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Save Area</button>
        					   </div>
        					</div>
        				</form>
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Country'),
							_l('City'),
							_l('Area'),
							_l('options')
							),'location_area'); 
						?>
					</div>
				</div>
			</div>
		</div>
		<?php */ ?>
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
