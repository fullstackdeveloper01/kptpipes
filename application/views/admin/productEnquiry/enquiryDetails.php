<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('productEnquiry/details/'.$article->id), array('id' => 'enquiryForm'));  ?>
        					<div class="row">
      					    <div class="col-md-4 form-group">
                      <?= _l('Title'); ?><span class="text-danger">*</span>
                      <input type="text" class="form-control" name="product_title" required value="<?= (isset($article)?$article->product_title:""); ?>">
                    </div>
    					    </div>
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info"> Save </button>
        					       <a href="<?= admin_url('productEnquiry')?>" class="btn btn-warning">Cancel</a>
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
        $(function(){
          appValidateForm($('#enquiryForm'));
        });  
	</script>
</body>
</html>
