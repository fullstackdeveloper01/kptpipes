<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
	    <div class="panel_s">
	        <div class="panel-body">
        		<div class="row">
        			<div class="col-md-12">
        			    <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
            			<hr class="hr-panel-heading" />
				        <?= form_open(admin_url('assign/add/'.$article->id), array('id' => 'assignForm'));  ?>
    					    <div class="row">
        					   <div class="col-md-4 form-group">
        					       <?= _l('Patient Name'); ?>
        					       <select name="patient_id" class="form-control" required>
        					           <option value=""></option>
        					           <?php
        					                if($patientResult)
        					                {
        					                    foreach($patientResult as $p)
        					                    {
        					                        ?>
        					                            <option value="<?= $p->id; ?>" <?= ($article->patient_id == $p->id)?"selected":""; ?>><?= $p->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?= _l('Mediciens Name'); ?>
        					       <select name="medicien_id" class="form-control" required>
        					           <option value=""></option>
        					           <?php
        					                if($medicienResult)
        					                {
        					                    foreach($medicienResult as $m)
        					                    {
        					                        ?>
        					                            <option value="<?= $m->id; ?>" <?= ($article->medicien_id == $m->id)?"selected":""; ?>><?= $m->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?= _l('Types Of Medicines'); ?>
        					       <select name="types_of_medicines" class="form-control" required>
        					           <option value=""></option>
        					           <?php
        					                if($medicienTypeResult)
        					                {
        					                    foreach($medicienTypeResult as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" <?= ($article->types_of_medicines == $rrr->id)?"selected":""; ?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					           <!--
        					           <option value="Liquid" <?= ($article->types_of_medicines == 'Liquid')?"selected":""; ?>>Liquid</option>
        					           <option value="Tablet" <?= ($article->types_of_medicines == 'Tablet')?"selected":""; ?>>Tablet</option>
        					           <option value="Capsules" <?= ($article->types_of_medicines == 'Capsules')?"selected":""; ?>>Capsules</option>
        					           <option value="Suppositories" <?= ($article->types_of_medicines == 'Suppositories')?"selected":""; ?>>Suppositories</option>
        					           <option value="Drops" <?= ($article->types_of_medicines == 'Drops')?"selected":""; ?>>Drops</option>
        					           <option value="Inhalers" <?= ($article->types_of_medicines == 'Inhalers')?"selected":""; ?>>Inhalers</option>
        					           <option value="Injections" <?= ($article->types_of_medicines == 'Injections')?"selected":""; ?>>Injections</option>
        					           -->
        					       </select>
        					   </div>
        					</div>
        					<div class="row">
        					    <div class="col-md-2 form-group">
        					       <?= _l('Drug Dosage'); ?>
        					        <select name="drug_dosage" class="form-control" required onchange="setDosage(this.value)">
        					           <option value=""></option>
        					           <option value="1" <?= ($article->drug_dosage == "1")?"selected":""; ?>>1 time a day</option>
        					           <option value="2" <?= ($article->drug_dosage == "2")?"selected":""; ?>>2 times a day</option>
        					           <option value="3" <?= ($article->drug_dosage == "3")?"selected":""; ?>>3 times a day</option>
        					           <option value="6" <?= ($article->drug_dosage == "6")?"selected":""; ?>>6 times a day</option>
        					       </select>
        					   </div>
        					   <div class="col-md-2 form-group">
        					       <?= _l('Drug Time'); ?>
        					        <div class="drugtime">
        					            <?php
        					                $grugtimearr = explode(',',$article->drug_time);
        					                if($grugtimearr)
        					                {
        					                    foreach($grugtimearr as $rrr)
        					                    {
        					                        ?>
        					                            <input type="time" name="drug_time[]" required value="<?= $rrr; ?>">
        					                        <?php
        					                    }
        					                }
        					            ?>
        					        </div>
        					   </div>
        					   <div class="col-md-3 form-group">
        					        <?= _l('Start Date'); ?>
    					            <input type="text" required class="form-control" autocomplete="off" value="<?= $article->from_date; ?>" name="from_date" id="start_date">
        					   </div>
        					   <div class="col-md-3 form-group">
        					        <?= _l('End Date'); ?>
    					            <input type="text" required class="form-control" autocomplete="off" value="<?= $article->to_date; ?>" name="to_date" id="end_date">
        					   </div>
        					   <div class="col-md-2 form-group">
        					       <br>
        					       <button type="submit" class="btn btn-success">Update</button>
        					   </div>
        					</div>
    				    </form>
        			</div>
        			<hr class="hr-panel-heading" />
    			    <div class="col-md-12">
        				<?php render_datatable(array(
        					_l('Patient Name'),
        					_l('Medicien'),
        					_l('Types Of Medicines'),
        					_l('Drug Dosage'),
        					_l('Drug Time'),
        					_l('From Date'),
        					_l('To Date'),
        					//_l('Status'),
        					_l('Created Date'),
        					_l('options')
        					),'assign'); 
        				?>
        			</div>
    			</div>
    		</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-assign', window.location.href, [1], [1]);
		
		$(document).ready(function(){
            $("#start_date").datepicker({
                minDate:0,
                dateFormat: 'dd-mm-yy',
                onSelect: function(selected) {
                  $("#end_date").datepicker("option","minDate", selected)
                }
            });
            $("#end_date").datepicker({ 
                minDate:0,
                dateFormat: 'dd-mm-yy',
                onSelect: function(selected) {
                   $("#start_date").datepicker("option","maxDate", selected)
                }
            });  
        });
        
        function setDosage(num)
        {
            if(num)
            {
                var res = '';
                for(var i = 0; i<num; i++)
                {
                    res += '<input type="time" name="drug_time[]" required>';
                }
                $('.drugtime').html(res);
            }
            else
            {
                $('.drugtime').html('');
            }
        }
        
        $("#assignForm").validate();
	</script>
</body>
</html>
