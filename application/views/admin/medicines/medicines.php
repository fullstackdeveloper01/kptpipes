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
				        <?= form_open(admin_url('medicines/add/'.$article->id));  ?>
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <?= _l('Name'); ?>
        					       <input type="text" class="form-control" name="name" value="<?= $article->name; ?>" required>
        					   </div>
        					   <div class="col-md-6 form-group"><br>
        					       <button type="submit" class="btn btn-success">Update</button>
        					   </div>
        					</div>
    				    </form>
        			</div>
        			<hr class="hr-panel-heading" />
    			    <div class="col-md-12">
        				<?php render_datatable(array(
        					_l('Name'),
        					_l('Date'),
        					_l('options')
        					),'medicines'); 
        				?>
        			</div>
    			</div>
    		</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-medicines', window.location.href, [1], [1]);
	</script>
</body>
</html>
