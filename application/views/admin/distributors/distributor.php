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
                      <table class="table table-tasks dataTable no-footer dtr-inline">
                        <thead>
                          <tr role="row">
                              <th width="20%">Login ID </th>  
                              <td><?= (isset($article)?$article->distributor_email:""); ?></td>          
                              <th width="20%">Login Password </th>  
                              <td><?= (isset($article)?$article->distributor_pass:""); ?></td>          
                          </tr>
                          <tr role="row">
                              <th width="20%">Login as </th>  
                              <td>&nbsp;&nbsp;</td>          
                              <th width="20%">Last Login</th>  
                              <td><?= (isset($article)?$article->distributor_last_login:""); ?></td> 
                          </tr>                      
                        </thead>
                      </table>
                    </div>
                  </div>
                <?php
              }
            ?>
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
                         <input type="text" class="form-control" required name="distributor_pan_number"  value="<?= (isset($article)?$article->distributor_pan_number:""); ?>">
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
                      <input type="Number" class="form-control" required  name="distributor_mobile" value="<?= (isset($article)?$article->distributor_mobile:""); ?>">
                      <span class="error" id="mobile_error"></span>
                    </div>                         
    					    </div>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('DOB'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control datepicker" id="" required name="distributor_dob" value="<?= (isset($article)?$article->distributor_dob:""); ?>">
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
                    <div class="col-md-4 form-group">
                       <?= _l('Photo'); ?><span class="text-danger">*</span>
                       <input type="file" class="form-control" name="distributor">
                    </div> 
                  </div>
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info save"> Save </button>
        					       <a href="<?= admin_url('distributors')?>" class="btn btn-warning">Cancel</a>
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
             appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',distributor:{extension: "png,jpg,jpeg,gif"}});
          else
            appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',distributor:{required:true,extension: "png,jpg,jpeg,gif"}});
        });  


        function getStatelist(Id)
        {
          $('#state').html('<option value="">Please wait...</option>');
          $('#city').html('<option value=""></option>');
          var str = "country="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
          $.ajax({
              url: '<?= admin_url()?>distributors/getStatelist',
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
              url: '<?= admin_url()?>distributors/getCitylist',
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
    $("#distributor_dob").datepicker(
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
    $('input[name="distributor_pan_number"]').on('keyup',function(){
      var panno =$(this).val();
      var str = "panno="+panno+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>distributors/checkPanNumber',
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

    $('input[name="distributor_aadhar_number"]').on('keyup',function(){
      var aadhaar_no =$(this).val();
      var str = "aadhaar_no="+aadhaar_no+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>distributors/checkAadharNumber',
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

    $('input[name="distributor_GST"]').on('keyup',function(){
      var gst =$(this).val();
      var str = "gst="+gst+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>distributors/checkGST',
          type: 'POST',
          data: str,
          datatype: 'json',
          cache: false,
          success: function(data){
            console.log(data);
              if(data > 0) {
                $('#gst_error').text('This GST Number is already used')
                $('#gst_error').css('color','red')
                $('.save').attr('type','button');
              } else {
                $('#gst_error').text('')
                if($('.error').text() ==''){
                  $('.save').attr('type','submit');
                }
              }
          }
      });
    })

    $('input[name="distributor_email"]').on('keyup',function(){
      var email =$(this).val();
      if (email=="") {
        return false;
      }else{
        var response =validateEmail(email);
      }
      var str = "email="+email+"&"+csrfData['token_name']+"="+csrfData['hash'];
      if (response== true) {
        $.ajax({
            url: '<?= admin_url()?>distributors/checkemail',
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

    $('input[name="distributor_mobile"]').on('keyup',function(){
      var mobile =$(this).val();
      if (mobile.length==10) {
        var str = "mobile="+mobile+"&"+csrfData['token_name']+"="+csrfData['hash'];
        $.ajax({
            url: '<?= admin_url()?>distributors/checkmobile',
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
      }else{
        $('#mobile_error').text('Mobile Number Length is invalid ')
        $('#mobile_error').css('color','red')
        $('.save').attr('type','button');
      }

    })
  })
</script>
</body>
</html>
