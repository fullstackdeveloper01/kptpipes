<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('clients/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
        					<div class="row">
                        <div class="col-md-5 form-group">
                          <?= _l('Name'); ?><span class="text-danger">*</span>
                          <input type="text" class="form-control" name="name" required value="<?= (isset($article)?$article->name:""); ?>">
                        </div>
                        <?php
                          if(isset($article))
                          {
                            ?>
                              <div class="col-md-2 form-group">
                                <?= _l('Selected Logo'); ?>
                                <?php
                                  if(isset($article))
                                  {
                                    $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'client_logo'))->row('file_name');
                                    echo '<img src="'.site_url('uploads/client_logo/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                  }
                                ?>
                              </div>
                            <?php
                          }
                        ?>
        					    <div class="col-md-3 form-group">
        					       <?= _l('Logo'); ?><span class="text-danger">*</span>
        					       <input type="file" class="form-control" name="client_logo">
        					    </div> 
    					    </div>
                  <div class="row">
                     <div class="col-md-5 form-group">
                         <?= _l('Project Name'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" name="project_name" required value="<?= (isset($article)?$article->project_name:""); ?>">
                     </div>
                     <div class="col-md-5 form-group">
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
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info"> Save </button>
        					       <a href="<?= admin_url('clients')?>" class="btn btn-warning">Cancel</a>
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
                appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',client_logo:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',client_logo:{required:true,extension: "png,jpg,jpeg,gif"}});
        });  
	</script>
</body>
</html>
