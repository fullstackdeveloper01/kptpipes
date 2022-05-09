<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('caseStudy/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
        					<div class="row">      
                    <div class="col-md-2 form-group">
                       <?= _l('Thumbnail'); ?><span class="text-danger">*</span>
                       <input type="file" class="form-control" name="caseStudy">
                    </div>                 
                    <div class="col-md-2 form-group">
                      <?php
                          if(isset($article))
                          {
                              ?>
                                     <?= _l('Selected Thumbnail'); ?>
                                     <?php
                                          if(isset($article))
                                          {
                                              $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'caseStudy'))->row('file_name');
                                              echo '<img src="'.site_url('uploads/caseStudy/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                          }
                                     ?>
                              <?php
                          }
                      ?>
                      </div>        					    
                      <div class="col-md-2 form-group">
                         <?= _l('Client Image'); ?><span class="text-danger">*</span>
                         <input type="file" class="form-control" name="client_image">
                      </div> 
                      <div class="col-md-2 form-group">
                        <?php
                          if(isset($article))
                          {
                            ?>
                              <?= _l('Selected Image'); ?>
                              <?php
                                if(isset($article))
                                {
                                  $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'client_image'))->row('file_name');
                                  echo '<img src="'.site_url('uploads/client_image/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                }
                             ?>
                            <?php
                          }
                        ?>
                      </div>
    					    </div>
                  <div class="row">
                    <div class="col-md-4 form-group">
                         <?= _l('Client Name'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" name="client_name" required value="<?= (isset($article)?$article->client_name:""); ?>">
                     </div>
                    <div class="col-md-4 form-group">
                         <?= _l('Designation'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" name="designation" required value="<?= (isset($article)?$article->designation:""); ?>">
                     </div>
                    <div class="col-md-4 form-group">
                         <?= _l('Title'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" name="title" required value="<?= (isset($article)?$article->title:""); ?>">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-12 form-group">
                          <?= _l('Short Description'); ?>
                          <textarea class="form-control" rows="3" name="short_description" ><?= (isset($article)?$article->short_description:""); ?></textarea>
                     </div>
                 </div>
                  <div class="row">
                     <div class="col-md-12 form-group">
                          <?= _l('Description'); ?>
                          <textarea class="form-control tinymce" name="description" ><?= (isset($article)?$article->description:""); ?></textarea>
                     </div>
                 </div>
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info"> Save </button>
        					       <a href="<?= admin_url('caseStudy')?>" class="btn btn-warning">Cancel</a>
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
          if(sid)
            appValidateForm($('#portfolioForm'),{short_description:'required',description:'required',caseStudy:{extension: "png,jpg,jpeg,gif"},client_image:{extension: "png,jpg,jpeg,gif"}});
          else
            appValidateForm($('#portfolioForm'),{short_description:'required',description:'required',caseStudy:{required:true,extension: "png,jpg,jpeg,gif"},client_image:{required:true,extension: "png,jpg,jpeg,gif"}});
        }); 
	</script>
</body>
</html>
