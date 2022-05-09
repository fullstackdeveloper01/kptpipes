<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('websiteHeading/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
        					<div class="row">
                        <div class="col-md-10 form-group">
                          <?= _l('Heading'); ?><span class="text-danger">*</span>
                          <textarea class="form-control" rows="3" name="heading" required><?= (isset($article)?$article->heading:""); ?></textarea>
                        </div>
    					    </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                         <?= _l('Button Text'); ?>
                         <input type="text" class="form-control" name="button_text" value="<?= (isset($article)?$article->button_text:""); ?>">
                     </div>
                     <div class="col-md-6 form-group">
                         <?= _l('Button Link'); ?>
                         <input type="url" class="form-control" name="button_link" value="<?= (isset($article)?$article->button_link:""); ?>">
                     </div>
                  </div>
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info"> Save </button>
        					       <a href="<?= admin_url('websiteHeading')?>" class="btn btn-warning">Cancel</a>
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
        var sid = '<?= $article->id ?>';
        $(function(){
          appValidateForm($('#portfolioForm'));
        });  
	</script>
</body>
</html>
