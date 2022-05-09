<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php
  // print_r($article);die;
?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>  
                <!-- <form> -->
                  <div class="row">
                    <div class="col-md-3 form-group">
                      <?= _l('User'); ?><span class="text-danger">*</span>
                    </div>
                    <div class="col-md-3 form-group">
                      <?= _l('Point'); ?><span class="text-danger">*</span>
                    </div>
                    <div class="col-md-3 form-group">
                      <?= _l('Value'); ?> (Reward Point value)<span class="text-danger">*</span>
                    </div> 
                    <div class="col-md-3 form-group">
                      <br>
                    </div>
                  </div>
                  <?php
                  // print_r($article);die;
                    foreach ($article as $key => $articles ) { ?> 
    				    <?= form_open_multipart(site_url('reward-value/'.$articles->id),array('id' => 'portfolioForm'));  ?>
                  <div class="row">
                    <div class="col-md-3 form-group">
                      <input type="text" class="form-control" required name="user_type" readonly="" value="<?= (isset($articles)?$articles->user_type :"1"); ?>">
                    </div>
                    <div class="col-md-3 form-group">
                      <input type="number" class="form-control" required name="reward_point" readonly="" value="<?= (isset($articles)?$articles->reward_point:"1"); ?>">
                    </div> 
                    <div class="col-md-3 form-group">
                      <input type="text" oninput="validateNumber(this);" class="form-control" required name="reward_value" value="<?= (isset($articles)?$articles->reward_value:""); ?>">
                    </div> 
                    <div class="col-md-3 form-group">
                      <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php echo _l('wait_text'); ?>"> Save </button>
                    </div>
                  </div>
                         
    					    <!-- <hr class="hr-panel-heading"/>
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php //echo _l('wait_text'); ?>"> Save </button>
        					       <a href="<? //site_url('reward-list')?>" class="btn btn-warning">Cancel</a>
        					   </div>
        				    </div> -->
        				</form>
              <?php } ?>

        			</div>
    			</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
    
    $("#advertid").click(function() {
      setTimeout(function(){
          $("#advertid").removeAttr("disabled");
          $("#advertid").removeClass("disabled");
          $('#advertid').text('Save');
        }, 5000);
    });
    var validNumber = new RegExp(/^\d*\.?\d*$/);
    var lastValid = document.getElementById("test1").value;
    function validateNumber(elem) {
      if (validNumber.test(elem.value)) {
        lastValid = elem.value;
      } else {
        elem.value = lastValid;
      }
    }
	</script>
  
</body>
</html>
