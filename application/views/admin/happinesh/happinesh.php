<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open(admin_url('happinesh/add/'.$article->id)); ?>
        					<div class="panel-body">
        					   <div class="form-group">
        					       <div class="row">
        					           <div class="col-md-6">
                					        <?= _l('Questions English'); ?>
                					        <?php $contents = ''; if(isset($article)){$contents = $article->question_english;} ?>
            						        <?php echo render_textarea('question_english','',$contents,array(),array(),'','tinymce'); ?>
            						    </div>
            						    <div class="col-md-6">
            						        <?= _l('Questions Hindi'); ?>
                					        <?php $contents = ''; if(isset($article)){$contents = $article->question_hindi;} ?>
            						        <?php echo render_textarea('question_hindi','',$contents,array(),array(),'','tinymce'); ?>
            						    </div>
            					    </div>
        					   </div>
        					   <div class="form-group">
                			        <div class="row">
                			            <div class="col-md-4">
                			                <label>Always</label>
                			                <input type="text" class="form-control" required value="<?= (isset($article)?$article->always:""); ?>" name="always">
                			            </div>
                			            <div class="col-md-4">
                			                <label>Sometimes</label>
                			                <input type="text" class="form-control" required value="<?= (isset($article)?$article->sometimes:""); ?>" name="sometimes">
                			            </div>
                			            <div class="col-md-4">
                			                <label>Never</label>
                			                <input type="text" class="form-control" required value="<?= (isset($article)?$article->never:""); ?>" name="never">
                			            </div>
                			        </div>    
        					   </div>
        					    <div class="form-group">
        					       <button type="submit" class="btn btn-info">Save</button>
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
</body>
</html>
