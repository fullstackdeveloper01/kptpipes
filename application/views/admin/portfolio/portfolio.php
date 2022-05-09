<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('portfolio/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
        					<div class="row">
                    <div class="col-md-3 form-group">
                       <?= _l('Thumbnail'); ?>
                       <input type="file" class="form-control" name="portfolio_thumbnail">
                    </div>
        					   <div class="col-md-3 form-group">
                        <?php
                            if(isset($article))
                            {
                                ?>
            					       <?= _l('Selected Thumbnail'); ?>
            					       <?php
                                            if(isset($article))
                                            {
                                                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'portfolio_thumbnail'))->row('file_name');
                                                echo '<img src="'.site_url('uploads/portfolio_thumbnail/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                            }
                                       ?>
                                <?php
                            }
                        ?>
            					</div>
        					    <div class="col-md-3 form-group">
        					       <?= _l('Image'); ?><span class="text-danger">*</span>
        					       <input type="file" class="form-control" name="portfolio">
        					    </div> 
                      <div class="col-md-3 form-group">
                        <?php
                            if(isset($article))
                            {
                                ?>
                                       <?= _l('Selected Thumbnail'); ?>
                                       <?php
                                            if(isset($article))
                                            {
                                                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'portfolio'))->row('file_name');
                                                echo '<img src="'.site_url('uploads/portfolio/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                            }
                                       ?>
                                <?php
                            }
                        ?>
                    </div>
    					    </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                         <?= _l('Project Name'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" name="project_name" required value="<?= (isset($article)?$article->project_name:""); ?>">
                     </div>
                     <div class="col-md-6 form-group">
                         <?= _l('Technology'); ?><span class="text-danger">*</span>
                         <select class="form-control selectpicker" required multiple name="technology_id[]" >
                             <?php
                                $technologyArr = [];
                                if(isset($article))
                                {
                                  $technologyArr = explode(',', $article->technology_id);
                                }
                                if($technology_list)
                                {
                                  foreach($technology_list as $res)
                                  {
                                    if(in_array($res->id, $technologyArr))
                                    {
                                      ?>
                                        <option value="<?= $res->id?>" selected><?= $res->technology; ?></option>
                                      <?php
                                    }else
                                    {
                                      ?>
                                        <option value="<?= $res->id?>"><?= $res->technology; ?></option>
                                      <?php
                                    }
                                  }
                                }
                             ?>
                         </select>
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
        					       <a href="<?= admin_url('portfolio')?>" class="btn btn-warning">Cancel</a>
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
                appValidateForm($('#portfolioForm'),{project_name:'required',description:'required',technology_id:'required',portfolio_thumbnail:{extension: "png,jpg,jpeg,gif"},portfolio:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#portfolioForm'),{project_name:'required',description:'required',technology_id:'required',portfolio_thumbnail:{required:true,extension: "png,jpg,jpeg,gif"},portfolio:{required:true,extension: "png,jpg,jpeg,gif"}});
        });          
	</script>
</body>
</html>
