<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
<?php
  if(isset($article))
  {
    ?>
      <div class="row">
        <div class="form-group">
          <table class="table table-tasks dataTable no-footer dtr-inline">
            <thead>
              <tr role="row">
                  <th width="20%">Login ID </th>  
                  <td><?= (isset($article)?$article->distributor_email:""); ?></td>     
              </tr>
              <tr role="row">     
                  <th width="20%">Login Password </th>  
                  <td><?= (isset($article)?$article->distributor_pass:""); ?></td>          
              </tr>
              <tr role="row">
                  <th width="20%">Login as </th>  
                  <td>&nbsp;&nbsp;</td>          
              </tr>
              <tr role="row">     
                  <th width="20%">Last Login</th>  
                  <td><?= (isset($article)?$article->distributor_last_login:""); ?></td> 
              </tr>                      
            </thead>
          </table>
        </div>
      </div>
      <hr class="hr-panel-heading" />
      <div class="row">
         <div class="col-md-6 form-group">
             <a href="<?= admin_url('distributors')?>" class="btn btn-warning">Back</a>
         </div>
        </div>
    <?php
  }
?>