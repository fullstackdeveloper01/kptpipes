<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(site_url('greeting/'.$this->uri->segment(2).'/'.$this->uri->segment(3)), array('id' => 'portfolioForm'));  ?>
                  <div class="row">
                     <div class="col-md-12">                   
                        <h4>User Info</h4><hr>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                         <?= _l('Type'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" disabled  value="<?= (isset($response)?$response->type:""); ?>">
                     </div>
                     <div class="col-md-6 form-group">
                         <?= _l('Name'); ?><span class="text-danger">*</span>
                         <?php if ($response->type=="distributor") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->distributor_name  :""); ?>">
                         <?php } elseif ($response->type=="dealer") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->dealer_name  :""); ?>">
                         <?php } elseif ($response->type=="plumber") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->plumber_name  :""); ?>">
                         <?php } ?>
                         <span class="error" id="pan_error"></span>
                     </div> 
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                         <?= _l('Mobile'); ?><span class="text-danger">*</span>
                         <?php if ($response->type=="distributor") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->distributor_mobile  :""); ?>">
                         <?php } elseif ($response->type=="dealer") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->dealer_mobile  :""); ?>">
                         <?php } elseif ($response->type=="plumber") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->plumber_mobile  :""); ?>">
                         <?php } ?>
                         <span class="error" id="aadhar_error"></span>
                     </div> 
                     <div class="col-md-6 form-group">
                         <?= _l('Email'); ?><span class="text-danger">*</span>
                         <?php if ($response->type=="distributor") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->distributor_email  :""); ?>">
                         <?php } elseif ($response->type=="dealer") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->dealer_email  :""); ?>">
                         <?php } elseif ($response->type=="plumber") {?>
                            <input type="text" class="form-control" disabled   value="<?= (isset($response)?$response->plumber_email  :""); ?>">
                         <?php } ?>
                         <span class="error" id="gst_error"></span>
                     </div>
                     <div class="col-md-6 form-group">
                         <?= _l('Occation'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" readonly name="greeting_msg" value="<?= (isset($notification)?$notification->description:""); ?>">
                     </div>
                     <div class="col-md-6 form-group">
                         <?= _l('Date'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" readonly value="<?= (isset($notification)?date('d-m-Y',strtotime($notification->date)):""); ?>">
                     </div>
                     <div class="col-md-6 form-group">
                         <?= _l('Reward Point'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control number" required name="points" >
                     </div> 
                     <div class="col-md-6 form-group">
                         <?= _l('Greeting Message'); ?><span class="text-danger">*</span>
                        <textarea name="message" class="form-control" required></textarea>
                     </div> 
                  </div>
                  
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group btndiv">
        					       <button type="submit" class="btn btn-info save"> Save </button>
        					       <a href="javascript:history.back()" class="btn btn-warning">Cancel</a>
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


        // function getStatelist(Id)
        // {
        //   $('#state').html('<option value="">Please wait...</option>');
        //   $('#city').html('<option value=""></option>');
        //   var str = "country="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
        //   $.ajax({
        //       url: '<?= admin_url()?>distributors/getStatelist',
        //       type: 'POST',
        //       data: str,
        //       datatype: 'json',
        //       cache: false,
        //       success: function(resp_){
        //           if(resp_)
        //           {
        //               var resp = JSON.parse(resp_);
        //               var res = '<option value=""></option>';
        //               for(var i=0; i<resp.length; i++)
        //               {
        //                  res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
        //               }
        //               $('#state').html(res);
        //           }
        //           else
        //           {
        //               $('#state').html('<option value=""></option>');
        //           }
        //       }
        //   });
        // }

        // function getCitylist(Id)
        // {
        //   $('#city').html('<option value="">Please wait...</option>');
        //   var str = "state="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
        //   $.ajax({
        //       url: '<?= admin_url()?>distributors/getCitylist',
        //       type: 'POST',
        //       data: str,
        //       datatype: 'json',
        //       cache: false,
        //       success: function(resp_){
        //           if(resp_)
        //           {
        //               var resp = JSON.parse(resp_);
        //               var res = '<option value=""></option>';
        //               for(var i=0; i<resp.length; i++)
        //               {
        //                  res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
        //               }
        //               $('#city').html(res);
        //           }
        //           else
        //           {
        //               $('#city').html('<option value=""></option>');
        //           }
        //       }
        //   });
        // }

	</script>
  <script type="text/javascript">
            $('.number').keyup(function(e) {
                if(this.value == 0){
                    this.value =this.value.replace(/[^1-9\.]/g,'');
                }else if(this.value < 0){
                    this.value =this.value.replace(/[^0-9\.]/g,'');
                }else{
                    this.value =this.value.replace(/[^0-9\.]/g,'');
                }                
            });
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
  // function validateEmail($email) {
  //     var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  //     return emailReg.test( $email );
  //   }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
  // $(document).ready(function(){
    

    // $('input[name="distributor_aadhar_number"]').on('keyup',function(){
    //   var aadhaar_no =$(this).val();
    //   var str = "aadhaar_no="+aadhaar_no+"&"+csrfData['token_name']+"="+csrfData['hash'];
    //   $.ajax({
    //       url: '<?= admin_url()?>distributors/checkAadharNumber',
    //       type: 'POST',
    //       data: str,
    //       datatype: 'json',
    //       cache: false,
    //       success: function(data){
    //         console.log(data);
    //         // return false;
    //           if(data > 0) {
    //             $('#aadhar_error').text('This Aadhaar Number is already used')
    //             $('#aadhar_error').css('color','red')
    //             $('.save').attr('type','button');
    //           } else {
    //             $('#aadhar_error').text('')
    //             if($('.error').text() ==''){
    //               $('.save').attr('type','submit');
    //             }
    //           }
    //       }
    //   });
    // })

    // $('input[name="distributor_GST"]').on('keyup',function(){
    //   var gst =$(this).val();
    //   var str = "gst="+gst+"&"+csrfData['token_name']+"="+csrfData['hash'];
    //   $.ajax({
    //       url: '<?= admin_url()?>distributors/checkGST',
    //       type: 'POST',
    //       data: str,
    //       datatype: 'json',
    //       cache: false,
    //       success: function(data){
    //         console.log(data);
    //           if(data > 0) {
    //             $('#gst_error').text('This GST Number is already used')
    //             $('#gst_error').css('color','red')
    //             $('.save').attr('type','button');
    //           } else {
    //             $('#gst_error').text('')
    //             if($('.error').text() ==''){
    //               $('.save').attr('type','submit');
    //             }
    //           }
    //       }
    //   });
    // })

    // $('input[name="distributor_email"]').on('keyup',function(){
    //   var email =$(this).val();
    //   if (email=="") {
    //     return false;
    //   }else{
    //     var response =validateEmail(email);
    //   }
    //   var str = "email="+email+"&"+csrfData['token_name']+"="+csrfData['hash'];
    //   if (response== true) {
    //     $.ajax({
    //         url: '<?= admin_url()?>distributors/checkemail',
    //         type: 'POST',
    //         data: str,
    //         datatype: 'json',
    //         cache: false,
    //         success: function(data){
    //           console.log(data);
    //             if(data > 0) {
    //               $('#email_error').text('This Email is already used')
    //               $('#email_error').css('color','red')
    //               $('.save').attr('type','button');
    //             } else {
    //               $('#email_error').text('')
    //               if($('.error').text() ==''){
    //                 $('.save').attr('type','submit');
    //               }
    //             }
    //         }
    //     });
    //   }
    // })

    // $('input[name="distributor_mobile"]').on('keyup',function(){
    //   var mobile =$(this).val();
    //   if (mobile.length==10) {
    //     var str = "mobile="+mobile+"&"+csrfData['token_name']+"="+csrfData['hash'];
    //     $.ajax({
    //         url: '<?= admin_url()?>distributors/checkmobile',
    //         type: 'POST',
    //         data: str,
    //         datatype: 'json',
    //         cache: false,
    //         success: function(data){
    //           console.log(data);
    //             if(data > 0) {
    //               $('#mobile_error').text('This Mobile No is already used')
    //               $('#mobile_error').css('color','red')
    //               $('.save').attr('type','button');
    //             } else {
    //               $('#mobile_error').text('')
    //               if($('.error').text() ==''){
    //                 $('.save').attr('type','submit');
    //               }
    //             }
    //         }
    //     });
    //   }else{
    //     $('#mobile_error').text('Mobile Number Length is invalid ')
    //     $('#mobile_error').css('color','red')
    //     $('.save').attr('type','button');
    //   }

    // })
  // })

  $(document).on('submit','#portfolioForm',function(event){
      event.preventDefault(); // avoid to execute the actual submit of the form.
      var form = $(this);
      var actionUrl = form.attr('action');
      $.ajax({
          type: form.attr('method'),
          url: form.attr('action'),
          data: form.serialize(),
          datatype: 'json',
          cache: false,
          success: function(datas){
              if(datas == 'true') {
                $('.btndiv').html('');
                toastr.success("Gift Successfully Send To User");
              }else{
                toastr.error("Gift Not Send To User");
              }
          }
      });
    })
</script>
</body>
</html>
