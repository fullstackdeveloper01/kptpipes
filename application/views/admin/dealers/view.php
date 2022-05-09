<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="panel_s">
            <div class="panel-body">
              <div class="row">
                 <div class="col-md-12">                   
                    <h4>Business Info</h4><hr>
                 </div>
              </div>
              <div class="row">
                <div class="col-md-4 form-group">
                     <?= _l('Distributor'); ?><span class="text-danger">*</span>
                    <select class="form-control" name="distributor_id" required id="distributor_id">
                      <option></option>
                      <?php
                        if($distributor_list)
                        {
                          foreach($distributor_list as $res)
                          {
                            ?>
                              <option <?= ($article->distributor_id == $res->id)?"selected":""; ?> value="<?= $res->id; ?>"><?= $res->distributor_name; ?></option>
                            <?php
                          }
                        }
                    ?>
                    </select>
                 </div> 
              </div>
              <div class="row">
                 <div class="col-md-4 form-group">
                     <?= _l('Business Name'); ?><span class="text-danger">*</span>
                     <input type="text" class="form-control" required name="dealer_business_name" value="<?= (isset($article)?$article->dealer_business_name:""); ?>">
                 </div>
                 <div class="col-md-4 form-group">
                     <?= _l('Pan no.'); ?><span class="text-danger">*</span>
                     <input type="text" class="form-control" required name="dealer_pan_number" value="<?= (isset($article)?$article->dealer_pan_number:""); ?>">
                 </div> 
                 <div class="col-md-4 form-group">
                     <?= _l('Aadhaar No.'); ?><span class="text-danger">*</span>
                     <input type="text" class="form-control" required name="dealer_aadhar_number" value="<?= (isset($article)?$article->dealer_aadhar_number:""); ?>">
                 </div> 
              </div>
              <div class="row">
                 <div class="col-md-4 form-group">
                     <?= _l('Gst No. '); ?><span class="text-danger">*</span>
                     <input type="text" class="form-control" required name="dealer_GST" value="<?= (isset($article)?$article->dealer_GST:""); ?>">
                 </div>
                 <div class="col-md-4 form-group">
                     <?= _l('Permanent Address'); ?><span class="text-danger">*</span>
                     <input type="text" class="form-control" required name="dealer_permanent_address" value="<?= (isset($article)?$article->dealer_permanent_address:""); ?>">
                 </div> 
                 <div class="col-md-2 form-group">
                     <?= _l('State'); ?><span class="text-danger">*</span>
                    <select class="form-control" name="dealer_state" required id="state" onchange="getCitylist(this.value);">
                      <option></option>
                      <?php
                        if($state_list)
                        {
                          foreach($state_list as $res)
                          {
                            ?>
                              <option <?= ($article->dealer_state == $res->id)?"selected":""; ?> value="<?= $res->id; ?>"><?= $res->name; ?></option>
                            <?php
                          }
                        }
                    ?>
                    </select>
                 </div> 
                 <div class="col-md-2 form-group">
                    <?= _l('City'); ?><span class="text-danger">*</span>
                    <select class="form-control" name="dealer_city" required id="city">
                      <?php 
                        if($article->dealer_city!='')
                        {
                          ?>
                            <option value="<?= $article->dealer_city; ?>"><?= cityname($article->dealer_city);?></option>
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
                  <input type="text" class="form-control" name="dealer_name" required value="<?= (isset($article)?$article->dealer_name:""); ?>">
                </div>
                <div class="col-md-4 form-group">
                  <?= _l('Email'); ?><span class="text-danger">*</span>
                  <input type="email" class="form-control" name="dealer_email" required value="<?= (isset($article)?$article->dealer_email:""); ?>">
                </div>
                <?php
                  if(isset($article))
                  {
                    ?>
                      <div class="col-md-2 form-group">
                        <?= _l('Selected Photo'); ?>
                        <?php
                          if(isset($article))
                          {
                            $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'dealer'))->row('file_name');
                            echo '<img src="'.site_url('uploads/dealers/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                          }
                        ?>
                      </div>
                    <?php
                  }
                ?>
                <div class="col-md-2 form-group">
                  <?= _l('Photo'); ?><span class="text-danger">*</span>
                  <input type="file" class="form-control" name="dealer">
                </div> 
              </div>
              <div class="row">
                 <div class="col-md-4 form-group">
                     <?= _l('DOJ'); ?><span class="text-danger">*</span>
                     <input type="text" class="form-control datepicker" required name="dealer_doj" value="<?= (isset($article)?$article->dealer_doj:""); ?>">
                 </div>
                 <div class="col-md-4 form-group">
                     <?= _l('Mobile Number'); ?><span class="text-danger">*</span>
                     <input type="number" class="form-control" required name="dealer_mobile" value="<?= (isset($article)?$article->dealer_mobile:""); ?>">
                 </div> 
                 <div class="col-md-2 form-group">
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
                 <div class="col-md-2 form-group">
                    <?= _l('Gender'); ?><span class="text-danger">*</span>
                    <select class="form-control" required name="dealer_gender">
                      <option value=""></option>
                      <option value="Male" <?= ($article->dealer_gender == "Male")?"selected":""; ?>>Male</option>
                      <option value="Female" <?= ($article->dealer_gender == "Female")?"selected":""; ?>>Female</option>
                    </select>
                 </div> 
              </div>                  
              <hr class="hr-panel-heading" />
              <div class="row">
                 <div class="col-md-12">                   
                    <h4>Rewards Info</h4><hr>
                 </div>
              </div>
              <div class="row">
                <div class="col-md-4 form-group">
                  <?= _l('Total Reward'); ?><span class="text-danger">*</span>
                  <input type="number" class="form-control"  disabled="" value="<?= !empty($totalpoints) ? $totalpoints : 0 ; ?>">
                </div>
                <div class="col-md-4 form-group">
                  <?= _l('Redeem Reward'); ?><span class="text-danger">*</span>
                  <input type="number" class="form-control"  disabled="" value="<?= !empty($redeempoints) ? $redeempoints : 0 ?>">
                </div>
                <div class="col-md-4 form-group">
                   <?= _l('Available Reward'); ?><span class="text-danger">*</span>
                   <input type="number" class="form-control" disabled="" value="<?= !empty($availablepoints) ? $availablepoints : 0 ?>">
                </div>         
              </div>
              <div class="row">
                 <div class="col-md-6 form-group">
                     <a href="<?= admin_url('dealers')?>" class="btn btn-info">Back</a>
                 </div>
                </div>
            </div>
          </div>
        </div>  
      </div>
   </div>
</div>
<?php init_tail(); ?>
  <script>
    var college_id = '<?= $article->id ?>';
    var pagename_ = '<?= @$pagename ?>';
    /*initDataTable('.table-dealers', window.location.href, '', '','', [0, 'asc']);*/

    if(pagename_ == 'college_slider')
    {
      initDataTable('.table-college_slider', admin_url + 'dealers/table_slider/' + college_id, '','', '', [0, 'desc']);
      appValidateForm($('#import_form'),{slider:{extension: "png,jpg,jpeg,gif"}});
    }
    if(pagename_ == 'faculty')
    {
      initDataTable('.table-college_faculty', admin_url + 'dealers/table_faculty/' + college_id, '','', '', [0, 'desc']);
      appValidateForm($('#facultyForm'));
    }
  </script>
  <script>
    $(function(){
      appValidateForm($('#employeeForm'));
    });
  </script>
  <script>
    function getStatelist(Id)
    {
      $('#state').html('<option value="">Please wait...</option>');
      $('#city').html('<option value=""></option>');
      var str = "country="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>dealers/getStatelist',
          type: 'POST',
          data: str,
          datatype: 'json',
          cache: false,
          success: function(resp_){
              if(resp_)
              {
                  var resp = JSON.parse(resp_);
                  var res = '<option value=""></option>';
                  for(var i=0; i<resp.length; i++)
                  {
                     res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
                  }
                  $('#state').html(res);
              }
              else
              {
                  $('#state').html('<option value=""></option>');
              }
          }
      });
    }

    function getCitylist(Id)
    {
      $('#city').html('<option value="">Please wait...</option>');
      var str = "state="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>dealers/getCitylist',
          type: 'POST',
          data: str,
          datatype: 'json',
          cache: false,
          success: function(resp_){
              if(resp_)
              {
                  var resp = JSON.parse(resp_);
                  var res = '<option value=""></option>';
                  for(var i=0; i<resp.length; i++)
                  {
                     res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
                  }
                  $('#city').html(res);
              }
              else
              {
                  $('#city').html('<option value=""></option>');
              }
          }
      });
    }
  </script>
   <script>
    $(function() {
      $("#dob").datepicker(
        {
          minDate: new Date(1900,1-1,1), maxDate: '-18Y',
          format: 'dd-mm-yy',
          changeMonth: true,
          changeYear: true,
          yearRange: '-110:-18'
        }
      );              
    });
  </script>
</html>
