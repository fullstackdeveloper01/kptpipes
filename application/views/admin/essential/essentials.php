<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="panel_s">
    				<div class="panel-body">
    					<?= form_open_multipart(admin_url('commonPhrases/add'));  ?> 
    					    <h4 class="customer-profile-group-heading"><?= _l('Phrases'); ?></h4>
						    <hr class="hr-panel-heading" />
    					    <div class="row form-group">
        					   <div class="col-md-4">
        					       <?= _l('Image'); ?>
        					       <input type="file" class="form-control"required  name="essential">
        					    </div>
        					    <div class="col-md-4">
        					       <?= _l('Name'); ?>
        					       <input type="text" class="form-control"required  name="name">
        					    </div>
        					    <div class="col-md-4"><br/>
        					       <button type="submit" class="btn btn-info">Create Phrases</button>
        					    </div>
    					    </div>
    				    </form>
    				    <hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Image'),
							_l('Name'),
							_l('options')
							),'essential'); 
						?>
    				</div>
    			</div>
			</div>
		</div>
		<div class="row" id="subessential">
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l('Create Sub-phrases'); ?></h4>
						<hr class="hr-panel-heading" />
						<?= form_open(admin_url('commonPhrases/add'));  ?> 
        					<div class="row form-group">
        					    <div class="col-md-3 hide">
        					       <?= _l('Image'); ?>
        					       <input type="file" class="form-control" name="essential">
        					    </div>
        					    <div class="col-md-3">
        					       <?= _l('Phrases'); ?>
        					       <select class="form-control" name="parent_id" required>
        					           <option value=""></option>
        					           <?php
        					                if($essential_result) 
        					                {
        					                    foreach($essential_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>"><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					    <div class="col-md-6">
        					       <?= _l('Sub-phrases'); ?>
        					       <input type="text" required class="form-control" name="name">
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Save</button>
        					   </div>
        					</div>
        					<div class="row form-group hide">
        					    <div class="col-md-9">
        					       <?= _l('Description'); ?>
        					       <textarea name="description" class="form-control" rows="5" placeholder="Enter descrioption"></textarea>
        					   </div>
        					   <div class="col-md-3"><br>
        					       <button type="submit" class="btn btn-info">Create Subessential</button>
        					   </div>
        					</div>
        				</form>
        				<hr class="hr-panel-heading" />
						<?php render_datatable(array(
				// 			_l('Image'),
							_l('Name'),
							_l('Parent phrases'),
							_l('options')
							),'sub_essential'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-essential', window.location.href, [1], [1]);
		initDataTable('.table-sub_essential', '<?= admin_url() ?>commonPhrases/subessential', [1], [1]);
	</script>
</body>
</html>
