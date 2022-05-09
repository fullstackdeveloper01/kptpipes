<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<?php
  //print_r($article);die;
?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>            
    				    <?= form_open_multipart(admin_url('reward/add/'.$article->id),array('id' => 'portfolioForm'));  ?>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('User Type'); ?><span class="text-danger">*</span>
                         <select class="form-control" <?=isset($article) && $article!="" ? 'disabled' : 'name="user_type" id="user_type"' ?>  required>
                          <option value="">Select</option>
                          <option value="distributor" <?=($article->user_type=='distributor')?'selected':''?>>Distributor</option>
                          <option value="dealer" <?=($article->user_type=='dealer')?'selected':''?>>Dealer</option>
                          <option value="plumber" <?=($article->user_type=='plumber')?'selected':''?>>Plumber</option>
                        </select>
                        <span id="usertype_error"></span>
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('Brand'); ?><span class="text-danger">*</span>
                        <select class="form-control"<?=isset($article) && $article!="" ? 'disabled' : 'name="brand_id" id="brand_id"' ?> required >
                          <option>Select</option>
                          <?php
                            if($brand_list)
                            {
                              foreach($brand_list as $res)
                              {
                                ?>
                                  <option <?= ($article->brand_id == $res->id)?"selected":""; ?> value="<?= $res->id; ?>"><?= $res->brandname; ?></option>
                                <?php
                              }
                            }
                        ?>
                        </select>
                     </div> 
                     <div class="col-md-4 form-group">
                        <?= _l('Products'); ?><span class="text-danger">*</span>
                        <select class="form-control" <?=isset($article) && $article!="" ? 'disabled' : 'name="product_id" id="product_id"' ?>  required >
                          <?php 
                            if($product_list)
                            {
                              foreach($product_list as $res)
                              {
                                ?>
                                  <option value="<?= $res->id; ?>" <?= ($article->product_list == $res->id)?"selected":""; ?>><?= $res->product_variant; ?></option>
                                <?php 
                              }
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
                    <div class="col-md-4 form-group">
                      <span id="reward"><?= _l('Reward'); ?> (Points)</span><span class="text-danger">*</span>
                      <input type="number" class="form-control" required name="percent" value="<?= (isset($article)?$article->percent:""); ?>">
                    </div> 
                  </div>
                         
    					    <hr class="hr-panel-heading"/>
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php echo _l('wait_text'); ?>"> Save </button>
        					       <a href="<?= site_url('reward-list')?>" class="btn btn-warning">Cancel</a>
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
    // function getStatelist(Id)
    // {
    //   $('#state').html('<option value="">Please wait...</option>');
    //   $('#city').html('<option value=""></option>');
    //   var str = "country="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
    //   $.ajax({
    //       url: '<?= admin_url()?>products/getStatelist',
    //       type: 'POST',
    //       data: str,
    //       datatype: 'json',
    //       cache: false,
    //       success: function(resp_){
    //           if(resp_)
    //           {
    //             var resp = JSON.parse(resp_);
    //             var res = '<option value=""></option>';
    //             for(var i=0; i<resp.length; i++)
    //             {
    //               res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
    //             }
    //             $('#state').html(res);
    //           }
    //           else
    //           {
    //             $('#state').html('<option value=""></option>');
    //           }
    //       }
    //   });
    // }

    // function getSubCategorylist(Id)
    // {
    //   $('#subcategory_id').html('<option value="">Please wait...</option>');
    //   var str = "state="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
    //   $.ajax({
    //       url: '<?= admin_url()?>products/getSubCategorylist',
    //       type: 'POST',
    //       data: str,
    //       datatype: 'json',
    //       cache: false,
    //       success: function(resp_){
    //         if(resp_)
    //         {
    //           var resp = JSON.parse(resp_);
    //           var res = '<option value=""></option>';
    //           for(var i=0; i<resp.length; i++)
    //           {
    //              res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
    //           }
    //           $('#subcategory_id').html(res);
    //         }
    //         else
    //         {
    //           $('#subcategory_id').html('<option value=""></option>');
    //         }
    //       }
    //   });
    // }


    // $('#user_type').on('change',function(){
    //   $('select[name="brand_id"]').prop('selectedIndex',0);
    //   $('#usertype_error').text('');
    //   if($(this).val() != 'distributor'){
    //     $('#reward').text('Points')
    //   }else{
    //     $('#reward').text('<?= _l('Reward'); ?> (Percent)')
    //   }
    // })
    $('select[name="brand_id"]').on('change',function(){
      var dealer= $('#user_type').val();
      if (dealer!="") {
        var Id =$(this).val();
        $('#product_id').html('<option value="">Please wait...</option>');
        var str = "dealer="+dealer+"&"+"product="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
        // console.log('id',str)
        $.ajax({
            url: '<?= site_url("check-product")?>',
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
                   res += '<option value="'+resp[i].id+'">'+resp[i].product_variant+'</option>';
                }
                $('#product_id').html(res);
              }
              else
              {
                $('#product_id').html('<option value=""></option>');
              }
            }
        });
      }else{
        $('#usertype_error').css('color','red');
        $('#usertype_error').text('Please First select user type');
      }
    })
    $("#advertid").click(function() {
      setTimeout(function(){
          $("#advertid").removeAttr("disabled");
          $("#advertid").removeClass("disabled");
          $('#advertid').text('Save');
        }, 5000);
    });
	</script>
  <script>
  // $(function() {
  //   $("#dob").datepicker(
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
