<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>            
    				    <?= form_open_multipart(admin_url('products/addstock/'.$article->id), array('id' => 'portfolioForm'));  ?>
                  
                  <div class="row">
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
                         <?= _l('Product'); ?><span class="text-danger">*</span>
                        <select class="form-control" name="product_id" required id="product_id" onchange="getSubCategorylist(this.value);">
                          <option></option>
                          <?php
                            if($product_list)
                            {
                              foreach($product_list as $res)
                              {
                                ?>
                                  <option <?= ($article->product_id == $res->id)?"selected":""; ?> value="<?= $res->id; ?>"><?= $res->product_variant; ?></option>
                                <?php
                              }
                            }
                          $subcategoryList = $this->db->get_where('tblcategory', array('parent_id' => $article->category_id))->result();
                        ?>
                        </select>
                     </div> 
                      
                  </div>
                  <?php
                  $bachno = $this->db->order_by('id', 'DESC')->get_where(db_prefix().'stocks')->row('bach_no');
                  if ($bachno!="") {
                    $explode = explode('-', $bachno);
                    $explode[1] = ($explode[1]+1);
                    $bachno = implode('-', $explode);
                  }else{
                    $bachno='Batch-1';
                  }
                  ?>
                  <div class="row">
                    <div class="col-md-4 form-group">
                      <?= _l('Bach-Number'); ?><span class="text-danger">*</span>
                      <input type="text" class="form-control" required readonly name="bach_no" value="<?= (isset($article)?$article->bach_no:$bachno); ?>">
                    </div> 
                    <div class="col-md-4 form-group">
                      <?= _l('Quantity'); ?><span class="text-danger">*</span>
                      <input type="number" class="form-control" required name="quantity" value="<?= (isset($article)?$article->quantity:""); ?>">
                    </div> 
                    <div class="col-md-4 form-group">
                      <?= _l('Barcode'); ?><span class="text-danger">*</span><br>
                      <input type="radio" name="barcode" value="yes" id="yes"><label for="yes">Yes</label>
                      <input type="radio" name="barcode" value="no" id="no"><label for="no">No</label>
                    </div> 
                  </div>
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php echo _l('wait_text'); ?>"> Save </button>
        					       <a href="<?= site_url('stocks')?>" class="btn btn-warning">Cancel</a>
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
          $('#product_id').html('<option value="">Please wait...</option>');
          var str = "id="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
          $.ajax({
              url: '<?= admin_url()?>products/getProductlist',
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
        }

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

        $("#advertid").click(function() {
          setTimeout(function(){
              $("#advertid").removeAttr("disabled");
              $("#advertid").removeClass("disabled");
              $('#advertid').text('Save');
            }, 5000);
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
