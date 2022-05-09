<?= form_open_multipart(admin_url('distributors/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
  <div class="row">
     <div class="col-md-12">                   
        <h4>Business Info</h4><hr>
     </div>
  </div>
  <div class="row">
     <div class="col-md-4 form-group">
         <?= _l('Business Name'); ?><span class="text-danger">*</span>
         <input type="text" class="form-control" required name="distributor_business_name" value="<?= (isset($article)?$article->distributor_business_name:""); ?>">
     </div>
     <div class="col-md-4 form-group">
         <?= _l('Pan no.'); ?><span class="text-danger">*</span>
         <input type="text" class="form-control" required name="distributor_pan_number" value="<?= (isset($article)?$article->distributor_pan_number:""); ?>">
         <span class="error" id="pan_error"></span>
     </div> 
     <div class="col-md-4 form-group">
         <?= _l('Aadhaar No.'); ?><span class="text-danger">*</span>
         <input type="text" class="form-control" required name="distributor_aadhar_number" value="<?= (isset($article)?$article->distributor_aadhar_number:""); ?>">
         <span class="error" id="aadhar_error"></span>
     </div> 
  </div>
  <div class="row">
     <div class="col-md-4 form-group">
         <?= _l('Gst No. '); ?><span class="text-danger">*</span>
         <input type="text" class="form-control" required name="distributor_GST" value="<?= (isset($article)?$article->distributor_GST:""); ?>">
         <span class="error" id="gst_error"></span>
     </div>
     <div class="col-md-4 form-group">
         <?= _l('Permanent Address'); ?><span class="text-danger">*</span>
         <input type="text" class="form-control" required name="distributor_permanent_address" value="<?= (isset($article)?$article->distributor_permanent_address:""); ?>">
     </div> 
     <div class="col-md-4 form-group">
         <?= _l('State'); ?><span class="text-danger">*</span>
        <select class="form-control" name="distributor_state" required id="state" onchange="getCitylist(this.value);">
          <option></option>
          <?php
            if($state_list)
            {
              foreach($state_list as $res)
              {
                ?>
                  <option <?= ($article->distributor_state == $res->id)?"selected":""; ?> value="<?= $res->id; ?>"><?= $res->name; ?></option>
                <?php
              }
            }
        ?>
        </select>
     </div> 
     <div class="col-md-4 form-group">
        <?= _l('City'); ?><span class="text-danger">*</span>
        <select class="form-control" name="distributor_city" required id="city">
          <?php 
            if($article->distributor_city!='')
            {
              ?>
                <option value="<?= $article->distributor_city; ?>"><?= cityname($article->distributor_city);?></option>
              <?php 
            }
            else
            { 
              ?>
                <option value=""></option>
              <?php 
            } 
          ?>
        </select>
     </div> 
  </div>
  <div class="row">
     <div class="col-md-12">                   
        <h4>Personal Info</h4><hr>
     </div>
  </div>
  <div class="row">
    <div class="col-md-4 form-group">
      <?= _l('Name'); ?><span class="text-danger">*</span>
      <input type="text" class="form-control" name="distributor_name" required value="<?= (isset($article)?$article->distributor_name:""); ?>">
    </div>
    <div class="col-md-4 form-group">
      <?= _l('Email'); ?><span class="text-danger">*</span>
      <input type="email" class="form-control" name="distributor_email" required value="<?= (isset($article)?$article->distributor_email:""); ?>">
      <span class="error" id="email_error"></span>
    </div>
    <div class="col-md-4 form-group">
       <?= _l('Mobile Number'); ?><span class="text-danger">*</span>
       <input type="number" class="form-control" required name="distributor_mobile" value="<?= (isset($article)?$article->distributor_mobile:""); ?>">
       <span class="error" id="mobile_error"></span>
    </div>         
  </div>
  <div class="row">
     <div class="col-md-4 form-group">
         <?= _l('DOB'); ?><span class="text-danger">*</span>
         <input type="text" class="form-control datepicker" required id="distributor_dob" name="distributor_dob" value="<?= (isset($article)?$article->distributor_dob:""); ?>">
     </div>
     <div class="col-md-4 form-group">
         <?= _l('DOJ'); ?><span class="text-danger">*</span>
         <input type="text" class="form-control datepicker" required name="distributor_doj" value="<?= (isset($article)?$article->distributor_doj:""); ?>">
     </div>
     
     <div class="col-md-4 form-group">
        <?= _l('Brand'); ?><span class="text-danger">*</span>
        <select class="form-control" required name="brand_id">
          <option value=""></option>
          <?php
            if($brandList)
            {
              foreach($brandList as $res)
              {
                ?>
                  <option value="<?= $res->id; ?>" <?= ($article->brand_id == $res->id)?"selected":""; ?>><?= $res->brandname; ?></option>
                <?php
              }
            }
          ?>
        </select>
     </div>
  </div>
  <div class="row">
     <div class="col-md-4 form-group">
        <?= _l('Gender'); ?><span class="text-danger">*</span>
        <select class="form-control" required name="distributor_gender">
          <option value=""></option>
          <option value="Male" <?= ($article->distributor_gender == "Male")?"selected":""; ?>>Male</option>
          <option value="Female" <?= ($article->distributor_gender == "Female")?"selected":""; ?>>Female</option>
        </select>
     </div> 
    <div class="col-md-4 form-group">
     <?= _l('Photo'); ?><span class="text-danger">*</span>
     <input type="file" class="form-control" name="distributor">
    </div> 
    <?php
      if(isset($article))
      {
        ?>
          <div class="col-md-4 form-group">
            <?= _l('Selected Photo'); ?>
            <?php
              if(isset($article))
              {
                $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'distributor'))->row('file_name');
                echo '<img src="'.site_url('uploads/distributors/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
              }
            ?>
          </div>
        <?php
      }
    ?>
  </div>                  
  <hr class="hr-panel-heading" />
  <div class="row">
     <div class="col-md-6 form-group">
         <button type="submit" class="btn btn-info save"> Save </button>
         <a href="<?= admin_url('distributors')?>" class="btn btn-warning">Cancel</a>
     </div>
    </div>
</form>