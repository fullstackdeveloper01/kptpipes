<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>            
    				    <?= form_open_multipart(admin_url('products/add/'.$article->id), array('id' => 'portfolioForm'));  ?>
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('Product Title'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control" required name="title" value="<?= (isset($article)?$article->title:""); ?>">
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('Brand'); ?><span class="text-danger">*</span>
                        <select class="form-control" name="brand_id" required id="brand_id" onchange="getCategorylist(this.value);">
                          <option></option>
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
                      <?= _l('Color'); ?><span class="text-danger">*</span><br>
                      <?php
                        if (isset($article->color)) {
                          if ($article->color == 'red') {
                            echo '<label>Red</label>  <input type="checkbox" name="color" value="red" checked>';
                          }elseif ($article->color == 'blue') {
                            echo '<label>Blue</label>  <input type="checkbox" name="color" value="blue" checked>';
                          }elseif ($article->color == 'white') {
                            echo '<label>Green</label>  <input type="checkbox" name="color" value="green" checked>';
                          }
                        }else{
                          echo '<label>Red</label>
                                                <input type="checkbox" name="color[]" value="red" required>
                                                <label>Blue</label>
                                                <input type="checkbox" name="color[]" value="blue">
                                                <label>Green</label>
                                                <input type="checkbox" name="color[]" value="green">';
                        }
                      ?>
                      
                    </div>
                  </div>
                  <div class="row">
                    <div id="image-add"></div>
                      <?php if(isset($article)) { ?>
                        <div class="col-md-4 form-group">
                           <?= _l('Image'); ?><span class="text-danger">*</span>
                           <input type="file" class="form-control" name="<?=$article->color?>">
                          <?php if(isset($article)) {
                              $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'product'))->row('file_name');
                              echo '<img src="'.site_url('uploads/product/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                            } ?>
                        </div>
                        
                      <?php } ?>

                     
                    <div class="col-md-4 form-group">
                      <?= _l('Measurement'); ?>: (KP/Feet/Inch)<span class="text-danger">*</span>
                      <input type="text" class="form-control" required name="measurement" value="<?= (isset($article)?$article->measurement:""); ?>">
                    </div> 
                    <div class="col-md-4 form-group">
                      <?= _l('Product Unit'); ?><span class="text-danger">*</span>
                      <input type="text" class="form-control" required name="product_unit" value="<?= (isset($article)?$article->product_unit:""); ?>">
                    </div> 
                    
                    <div class="col-md-8 form-group">
                      <?= _l('Description'); ?><span class="text-danger">*</span>
                      <input type="text" class="form-control" required name="description" value="<?= (isset($article)?$article->description:""); ?>">
                    </div> 
                    <div class="col-md-4 form-group">
                      <?= _l('HSN Code'); ?>
                      <input type="text" class="form-control" name="HSN_code" value="<?= (isset($article)?$article->HSN_code:""); ?>">
                    </div> 
                    <div class="col-md-4 form-group">
                      <?= _l('SKU Number'); ?>
                      <input type="text" class="form-control" name="SKU_number" value="<?= (isset($article)?$article->SKU_number:""); ?>">
                    </div> 
                    <div class="col-md-4 form-group">
                      <?= _l('GST'); ?>
                      <?php
                        $taxList = $this->db->get_where('tbltax', array('status' => 1))->result();
                      ?>
                      <select class="form-control selectpicker" name="GST" required id="GST">
                        <option>Select Tax</option>
                        <?php
                          if($taxList)
                          {
                            foreach($taxList as $res)
                            {
                              ?>
                                <option value="<?= $res->id; ?>" <?= ($article->GST == $res->id)?"selected":""; ?>><?= $res->taxname.' ('.$res->taxvalue.')'; ?></option>                         
                              <?php
                            }
                          }
                        ?>                        
                      </select>
                    </div> 
                    <!-- <div class="col-md-2 form-group">
                      <?= _l('Product Discount'); ?>
                      <input type="text" class="form-control" name="product_discount" value="<?= (isset($article)?$article->product_discount:""); ?>">
                    </div> 
                    <div class="col-md-2 form-group">
                      <?= _l('Buy Limit'); ?>
                      <input type="number" class="form-control" name="buy_limit" value="<?= (isset($article)?$article->buy_limit:""); ?>">
                    </div> 
                  </div>  -->     
                  <!-- <div class="row"> -->
                    <div class="col-md-12 form-group">
                      <?= _l('Delivery and returns policy'); ?><span class="text-danger">*</span>
                      <textarea class="form-control tinymce" name="delivery_and_returns_policy" required><?= (isset($article)?$article->delivery_and_returns_policy:""); ?> </textarea>
                    </div> 
                  <!-- </div>          -->
    					    <hr class="hr-panel-heading" />
    					    <!-- <div class="row"> -->
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php echo _l('wait_text'); ?>"> Save </button>
        					       <a href="<?= admin_url('products')?>" class="btn btn-warning">Cancel</a>
        					   </div>
        				    <!-- </div> -->
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
            appValidateForm($('#portfolioForm'),{product:{extension: "png,jpg,jpeg,gif"}});
          else
            appValidateForm($('#portfolioForm'),{product:{required:true,extension: "png,jpg,jpeg,gif"}});
        });  


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

        function getCategorylist(Id)
        {
          $('#category_id').html('<option value="">Please wait...</option>');
          var str = "state="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
          $.ajax({
              url: '<?= admin_url()?>products/getCategorylist',
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
                  $('#category_id').html(res);
                }
                else
                {
                  $('#category_id').html('<option value=""></option>');
                }
                $('#subcategory_id').html('<option value=""></option>');
              }
          });
        }

        function getSubCategorylist(Id)
        {
          $('#subcategory_id').html('<option value="">Please wait...</option>');
          var str = "state="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
          $.ajax({
              url: '<?= admin_url()?>products/getSubCategorylist',
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
                  $('#subcategory_id').html(res);
                }
                else
                {
                  $('#subcategory_id').html('<option value=""></option>');
                }
              }
          });
        }

        $("#advertid").click(function() {
          setTimeout(function(){
              $("#advertid").removeAttr("disabled");
              $("#advertid").removeClass("disabled");
              $('#advertid').text('Save');
            }, 5000);
        });

        $(document).on('click','input[type="checkbox"]',function(){
          var value = $(this).val();
          if ($(this).is(':checked') == true) {
            var html = '<div class="col-md-4 form-group" id="'+value+'"><?= _l('Image'); ?> '+value+'<span class="text-danger">*</span><input type="file" class="form-control" name="'+value+'" required></div>'
            $('#image-add').append(html);
          }else{
            $('#'+value).remove();
          }
        });
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
</body>
</html>
