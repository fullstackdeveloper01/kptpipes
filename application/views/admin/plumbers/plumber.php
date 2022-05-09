<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
            <?php
              if(isset($article))
              {
                ?>
                  <div class="row">
                    <div class="form-group">
                      <table class="table table-tasks dataTable no-footer dtr-inline" style="border: 1px solid black;">
                        <thead>
                          <tr role="row">
                              <th width="20%">Login ID </th>  
                              <td><?= (isset($article)?$article->plumber_email:""); ?></td>          
                              <th width="20%">Login Password </th>  
                              <td><?= (isset($article)?$article->plumber_pass:""); ?></td>          
                          </tr>
                          <tr role="row">
                              <th width="20%">Login as </th>  
                              <td>&nbsp;&nbsp;</td>          
                              <th width="20%">Last Login</th>  
                              <td><?= (isset($article)?$article->plumber_last_login:""); ?></td> 
                          </tr>                      
                        </thead>
                      </table>
                    </div>
                  </div>
                <?php
              }
            ?>
    				    <?= form_open_multipart(admin_url('plumbers/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
                  <div class="row">
                     <div class="col-md-12">                   
                        <h4>Business Info</h4><hr>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('Business Name'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" required name="plumber_business_name" value="<?= (isset($article)?$article->plumber_business_name:""); ?>">
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('Pan no.'); ?>
                         <input type="text" class="form-control" name="plumber_pan_number" value="<?= (isset($article)?$article->plumber_pan_number:""); ?>">
                         <span class="error" id="pan_error"></span>
                     </div> 
                     <div class="col-md-4 form-group">
                         <?= _l('Aadhaar No.'); ?>
                         <input type="text" class="form-control" name="plumber_aadhar_number" value="<?= (isset($article)?$article->plumber_aadhar_number:""); ?>">
                         <span class="error" id="aadhar_error"></span>
                     </div> 
                  </div>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('Permanent Address'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" required name="plumber_permanent_address" value="<?= (isset($article)?$article->plumber_permanent_address:""); ?>">
                     </div> 
                     <div class="col-md-4 form-group">
                         <?= _l('State'); ?><span class="text-danger">*</span>
                        <select class="form-control" name="plumber_state" required id="state" onchange="getCitylist(this.value);">
                          <option></option>
                          <?php
                            if($state_list)
                            {
                              foreach($state_list as $res)
                              {
                                ?>
                                  <option <?= ($article->plumber_state == $res->id)?"selected":""; ?> value="<?= $res->id; ?>"><?= $res->name; ?></option>
                                <?php
                              }
                            }
                        ?>
                        </select>
                     </div> 
                     <div class="col-md-4 form-group">
                        <?= _l('City'); ?><span class="text-danger">*</span>
                        <select class="form-control" name="plumber_city" required id="city">
                          <?php 
                            if($article->plumber_city!='')
                            {
                              ?>
                                <option value="<?= $article->plumber_city; ?>"><?= cityname($article->plumber_city);?></option>
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
                          <input type="text" class="form-control" name="plumber_name" required value="<?= (isset($article)?$article->plumber_name:""); ?>">
                        </div>
                        <div class="col-md-4 form-group">
                          <?= _l('Email'); ?><span class="text-danger">*</span>
                          <input type="email" class="form-control" name="plumber_email" required value="<?= (isset($article)?$article->plumber_email:""); ?>">
                          <span class="error" id="email_error"></span>
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
                                    $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'plumber'))->row('file_name');
                                    echo '<img src="'.site_url('uploads/plumbers/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                  }
                                ?>
                              </div>
                            <?php
                          }
                        ?>
        					    <div class="col-md-2 form-group">
        					       <?= _l('Photo'); ?><span class="text-danger">*</span>
        					       <input type="file" class="form-control" name="plumber">
        					    </div> 
    					    </div>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('DOB'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control datepicker" required name="plumber_dob" id="" value="<?= (isset($article)?$article->plumber_dob:""); ?>">
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('DOJ'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control datepicker" required name="plumber_doj" value="<?= (isset($article)?$article->plumber_doj:""); ?>">
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('Mobile Number'); ?><span class="text-danger">*</span>
                         <input type="number" class="form-control" required name="plumber_mobile" value="<?= (isset($article)?$article->plumber_mobile:""); ?>">
                         <span class="error" id="mobile_error"></span>
                     </div> 
                     <div class="col-md-4 form-group">
                        <?= _l('Gender'); ?><span class="text-danger">*</span>
                        <select class="form-control" required name="plumber_gender">
                          <option value=""></option>
                          <option value="Male" <?= ($article->plumber_gender == "Male")?"selected":""; ?>>Male</option>
                          <option value="Female" <?= ($article->plumber_gender == "Female")?"selected":""; ?>>Female</option>
                        </select>
                     </div> 
                  </div>                  
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info save"> Save </button>
        					       <a href="<?= admin_url('plumbers')?>" class="btn btn-warning">Cancel</a>
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
             appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',plumber:{extension: "png,jpg,jpeg,gif"}});
          else
            appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',plumber:{required:true,extension: "png,jpg,jpeg,gif"}});
        });  


        function getStatelist(Id)
        {
          $('#state').html('<option value="">Please wait...</option>');
          $('#city').html('<option value=""></option>');
          var str = "country="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
          $.ajax({
              url: '<?= admin_url()?>plumbers/getStatelist',
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
              url: '<?= admin_url()?>plumbers/getCitylist',
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
  function validateEmail($email) {
      var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
      return emailReg.test( $email );
    }
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('input[name="plumber_pan_number"]').on('keyup',function(){
      var panno =$(this).val();
      var str = "panno="+panno+"& id="+'<?= $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>plumbers/checkPanNumber',
          type: 'POST',
          data: str,
          datatype: 'json',
          cache: false,
          success: function(data){
              if(data > 0) {
                $('#pan_error').text('This PAN Number is already used')
                $('#pan_error').css('color','red')
                $('.save').attr('type','button');
              } else {
                $('#pan_error').text('')
                if($('.error').text() ==''){
                  $('.save').attr('type','submit');
                }
              }
          }
      });
    })

    $('input[name="plumber_aadhar_number"]').on('keyup',function(){
      var aadhaar_no =$(this).val();
      var str = "aadhaar_no="+aadhaar_no+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>plumbers/checkAadharNumber',
          type: 'POST',
          data: str,
          datatype: 'json',
          cache: false,
          success: function(data){
            console.log(data);
            // return false;
              if(data > 0) {
                $('#aadhar_error').text('This Aadhaar Number is already used')
                $('#aadhar_error').css('color','red')
                $('.save').attr('type','button');
              } else {
                $('#aadhar_error').text('')
                if($('.error').text() ==''){
                  $('.save').attr('type','submit');
                }
              }
          }
      });
    })

    $('input[name="plumber_email"]').on('keyup',function(){
      var email =$(this).val();
      if (email=="") {
        return false;
      }else{
        var response =validateEmail(email);
      }
      var str = "email="+email+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      if (response== true) {
        $.ajax({
            url: '<?= admin_url()?>plumbers/checkemail',
            type: 'POST',
            data: str,
            datatype: 'json',
            cache: false,
            success: function(data){
              console.log(data);
                if(data > 0) {
                  $('#email_error').text('This Email is already used')
                  $('#email_error').css('color','red')
                  $('.save').attr('type','button');
                } else {
                  $('#email_error').text('')
                  if($('.error').text() ==''){
                    $('.save').attr('type','submit');
                  }
                }
            }
        });
      }
    })

    $('input[name="plumber_mobile"]').on('keyup',function(){
      var mobile =$(this).val();
      var str = "mobile="+mobile+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
        $.ajax({
            url: '<?= admin_url()?>plumbers/checkmobile',
            type: 'POST',
            data: str,
            datatype: 'json',
            cache: false,
            success: function(data){
              console.log(data);
                if(data > 0) {
                  $('#mobile_error').text('This Mobile No is already used')
                  $('#mobile_error').css('color','red')
                  $('.save').attr('type','button');
                } else {
                  $('#mobile_error').text('')
                  if($('.error').text() ==''){
                    $('.save').attr('type','submit');
                  }
                }
            }
        });
    })
  })
</script>
</body>
</html>
