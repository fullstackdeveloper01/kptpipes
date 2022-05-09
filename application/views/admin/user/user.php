<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('User/add/'.base64_encode($article->staffid)), array('id' => 'portfolioForm'));  ?>
                  <div class="row">
                     <div class="col-md-12">                   
                        <h4>User Info</h4><hr>
                     </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4 form-group">
                         <?= _l('Select Role'); ?><span class="text-danger">*</span>
                        <select class="form-control" name="role" required id="role">
                          <option>Select Role</option>
                          <option value="3" <?= (isset($article)&& $article->role == 3 ?'selected':""); ?>>Admin User</option>
                          <option value="4" <?= (isset($article)&& $article->role == 4 ?'selected':""); ?>>Account User</option>
                        </select>
                     </div> 
                     <div class="col-md-4 form-group">
                         <?= _l('Name'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" required name="firstname" value="<?= (isset($article)?$article->firstname:""); ?>">
                     </div> 
                     <div class="col-md-4 form-group">
                         <?= _l('Last Name'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" required name="lastname" value="<?= (isset($article)?$article->lastname:""); ?>">
                     </div> 
                  </div>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('Email'); ?><span class="text-danger">*</span>
                         <input type="email" class="form-control" required name="email" value="<?= (isset($article)?$article->email:""); ?>">
                         <span class="error" id="email_error"></span>
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('Mobile. '); ?><span class="text-danger">*</span>
                         <input type="number" class="form-control" required name="phonenumber" value="<?= (isset($article)?$article->phonenumber:""); ?>">
                         <span class="error" id="mobile_error"></span>
                     </div>
                     <?php
                      if (empty($article->password)) {?>
                         <div class="col-md-4 form-group">
                             <?= _l('Password. '); ?><span class="text-danger">*</span>
                             <input type="password" class="form-control" required name="password" value="<?= (isset($article)?$article->phonenumber:""); ?>">
                         </div>
                      <?php }
                     ?>
                  </div>
                  
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info save"> Save </button>
        					       <a href="<?= site_url('users')?>" class="btn btn-warning">Cancel</a>
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
        // var sid = '<?= $article->id ?>';
        // $(function(){
        //   if(sid)
        //      appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',dealer:{extension: "png,jpg,jpeg,gif"}});
        //   else
        //     appValidateForm($('#portfolioForm'),{name:'required',project_name:'required',technology_id:'required',dealer:{required:true,extension: "png,jpg,jpeg,gif"}});
        // });  

    	function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
      }
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $('input[name="email"]').on('keyup',function(){
      var email =$(this).val();
      if (email=="") {
        return false;
      }else{
        var response =validateEmail(email);
      }
      var str = "email="+email+"&"+csrfData['token_name']+"="+csrfData['hash'];
      if (response== true) {
        $.ajax({
            url: '<?= admin_url()?>user/checkemail',
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

    $('input[name="phonenumber"]').on('keyup',function(){
      var mobile =$(this).val();
      var str = "mobile="+mobile+"&"+csrfData['token_name']+"="+csrfData['hash'];
        $.ajax({
            url: '<?= admin_url()?>user/checkmobile',
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
  <script>
  // $(function() {
  //   $("#dealer_dob").datepicker(
  //     {
  //       minDate: new Date(1900,1-1,1), maxDate: '-18Y',
  //       format: 'dd-mm-yy',
  //       changeMonth: true,
  //       changeYear: true,
  //       yearRange: '-110:-18'
  //     }
  //   );              
  // });
</script>
</body>
</html>
