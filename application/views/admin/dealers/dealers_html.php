<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
   <div class="content">
      <div class="row">
        <?php
          if(@$article->id != '')
          {
            ?>
              <div class="col-md-3">
                <?php $this->load->view('admin/dealers/sidebar'); ?>         
              </div>
              <div class="col-md-9">
                <div class="panel_s">
                  <div class="panel-body">
                    <?php $this->load->view('admin/dealers/'.$pagename); ?>
                  </div>
                </div>
              </div>  
            <?php
          }
          else
          {
            ?>
              <div class="col-md-12">
                <div class="panel_s">
                  <div class="panel-body">
                    <h4 class="customer-profile-group-heading text-danger"><?= _l("Access denied"); ?></h4>
                    <div class="row">
                      <div class="col-md-6 form-group">
                        <a href="<?= admin_url('dealers')?>" class="btn btn-warning">Go Back</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
            <?php
          }
        ?>            
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
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
      }
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
    $('input[name="dealer_pan_number"]').on('keyup',function(){
      var panno =$(this).val();
      var str = "panno="+panno+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>dealers/checkPanNumber',
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

    $('input[name="dealer_aadhar_number"]').on('keyup',function(){
      var aadhaar_no =$(this).val();
      var str = "aadhaar_no="+aadhaar_no+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>dealers/checkAadharNumber',
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

    $('input[name="dealer_GST"]').on('keyup',function(){
      var gst =$(this).val();
      var str = "gst="+gst+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      $.ajax({
          url: '<?= admin_url()?>dealers/checkGST',
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

    $('input[name="dealer_email"]').on('keyup',function(){
      var email =$(this).val();
      if (email=="") {
        return false;
      }else{
        var response =validateEmail(email);
      }
      var str = "email="+email+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
      if (response== true) {
        $.ajax({
            url: '<?= admin_url()?>dealers/checkemail',
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

    $('input[name="dealer_mobile"]').on('keyup',function(){
      var mobile =$(this).val();
      if (mobile.length==10) {
        var str = "mobile="+mobile+"& id="+'<?php echo $article->id?>'+"&"+csrfData['token_name']+"="+csrfData['hash'];
        $.ajax({
            url: '<?= admin_url()?>dealers/checkmobile',
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
</html>
