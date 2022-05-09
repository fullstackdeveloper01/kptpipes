<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style type="text/css">
  .center{
    text-align: center;
  }
</style>
<?php
  $where['id']=$response[0]['user_id'];
  $userdata = $this->db->select('distributor_name as name,distributor_mobile as mobile,brand_id')->get_where(db_prefix().'distributors',$where)->row_array();
  $userdata['orderId']=$response[0]['order_id'];
  $userdata['user_type']=$response[0]['user_type'];
  $userdata['brand']=brandname($userdata['brand_id']);

?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>            
    				    <?= form_open_multipart(admin_url('orders/update/'.$this->uri->segment(4)), array('id' => 'portfolioForm'));  ?>
                  <input type="hidden" name="user_id" value="<?=$response[0]['user_id']?>" >
                  <div class="row">
                     <div class="col-md-4 form-group">
                         <?= _l('Order-Id'); ?><span class="text-danger">*</span>
                         <input type="text" class="form-control"disabled  value="<?= (isset($userdata)?$userdata['orderId']:""); ?>">
                     </div>
                     <div class="col-md-4 form-group">
                         <?= _l('User-Type'); ?><span class="text-danger">*</span>
                        <input type="text" class="form-control" disabled value="<?= (isset($userdata)?$userdata['user_type']:""); ?>">
                     </div>
                     
                     <div class="col-md-4 form-group">
                      <?= _l('Brand'); ?><span class="text-danger">*</span>
                      <input type="text" class="form-control" disabled  value="<?= (isset($userdata)?$userdata['brand']:""); ?>">
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                         <?= _l('Name'); ?><span class="text-danger">*</span>
                        <input type="text" class="form-control" disabled  value="<?= (isset($userdata)?$userdata['name']:""); ?>">
                     </div> 
                     <div class="col-md-6 form-group">
                        <?= _l('Mobile'); ?><span class="text-danger">*</span>
                        <input type="text" class="form-control" disabled  value="<?= (isset($userdata)?$userdata['mobile']:""); ?>">
                     </div>
                  </div>
                  <?php
                  if (!empty($response)) {
                    foreach ($response as $key => $value) { ?> 
                      <table class="table table-responsive table-bordered">
                        <thead>
                          <th>
                            <?= _l('Product'); ?> <span class="text-danger">*</span>
                          </th>
                          <th>
                            <?= _l('Product Quantity'); ?> (Ordered)<span class="text-danger">*</span>
                          </th>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?= productVariant($value['product_id']); ?></td>
                            <td><?= $value['quantity'] ?></td>
                          </tr>
                        </tbody>
                      </table>
                      <table class="table table-responsive table-bordered">
                        <thead>
                          <th class="center"><?= _l('Bach-No'); ?><span class="text-danger">*</span></th>
                          <th class="center"><?= _l('Quantity'); ?> (Available)<span class="text-danger">*</span></th>
                          <th class="center"><?= _l('Assgin'); ?> (Quantity)<span class="text-danger">*</span></th>
                          <th class="center"><?= _l('Per-Unit'); ?> (Price Per Unit)<span class="text-danger">*</span></th>
                          <th class="center"><?= _l('Amount'); ?><span class="text-danger">*</span></th>
                        </thead>
                        <tbody>
                  <?php
                    $stockCount=count($value['stock']);
                    if ($value['status']==3) {
                      $complete = $this->db->select('*')->from(db_prefix().'orders_history')->where(['order_id'=>$value['id']])->get()->result_array();
                      $totalqty=0;
                      $amtqty=0;
                      foreach ($complete as $ck => $cv) { 
                        $totalqty+=$cv['quantity'];
                        $amtqty+=$cv['price'];
                        ?>
                        <tr class="<?= $cv['bach_no'] ?>">
                          <td class="center"><?= $cv['bach_no'] ?></td>
                          <td class="center"><?= $cv['quantity'] ?></td>
                          <td class="center"><input type="text" class="form-control" value="<?= $cv['quantity'] ?>" disabled></td>
                          <td class="center"><input type="text" class="form-control" value="<?= $cv['unit'] ?>" disabled></td>
                          <td class="center"><input type="text" class="form-control" value="<?= $cv['price'] ?>" disabled></td>
                        </tr>
                      <?php } ?>
                        <tr class="">
                          <td class="center" colspan="2">Total</td>
                          <td class="center " id="" ><?=$totalqty?></td>  
                          <td class="center" id="" colspan="2"><?=$amtqty?></td>  
                        </tr>
              <?php }elseif($value['status']==1){
                      $accept = $this->db->select('*')->from(db_prefix().'orders_history')->where(['order_id'=>$value['id']])->get()->result_array();
                      $totalqty=0;
                      $amtqty=0;
                      foreach ($accept as $ck => $cv) { 
                        $totalqty+=$cv['quantity'];
                        $amtqty+=$cv['price'];
                        ?>
                        <tr class="<?// $cv['bach_no'] ?>">
                          <td class="center"><?= $cv['bach_no'] ?></td>
                          <td class="center" id="quantity"><?= $cv['quantity'] ?></td>
                          <td class="center"><input type="text" class="form-control quantity <?=$key.$value['order_id']?>" value="<?= $cv['quantity'] ?>" disabled></td>
                          <td class="center"><input type="text" class="form-control" value="<?= $cv['unit'] ?>" disabled></td>
                          <td class="center"><input type="text" class="form-control amount A<?=$key.$value['order_id']?>" value="<?= $cv['price'] ?>" disabled></td>
                        </tr>
                      <?php } 
                        // $remainqty =  $value['quantity'] -$totalqty ;
                        foreach ($value['stock'] as $skey => $svalue) { 
                          if ($svalue['status']==1 && $svalue['trash']==0 ) { ?>
                          <tr class="<?= $svalue['bach_no'] ?>">
                            <td class="center"><?= $svalue['bach_no'] ?></td>
                            <td class="center" id="quantity"><?= $svalue['quantity'] ?></td>
                            <td class="center">
                              <input type="text" class="form-control quantity <?=$key.$value['order_id']?>" oninput="this.value=this.value.replace(/[^0-9.,]/g,'');" onkeyup="Quantity(this.value,'<?= $svalue['bach_no'] ?>','<?=$key.$value['order_id']?>','A<?=$key.$value['order_id']?>','<?= $value['quantity'] ?>')" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][quantity]" value="">
                              <input type="hidden" class="form-control" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][type]" value="distributor">
                              <span class="span"></span></td>
                            <td class="center">
                              <input type="text" class="form-control unit" oninput="this.value=this.value.replace(/[^0-9.,]/g,'');" onkeyup="Unit(this.value,'<?= $svalue['bach_no'] ?>','<?=$key.$value['order_id']?>','A<?=$key.$value['order_id']?>','<?= $value['quantity'] ?>')" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][unit]" value="">
                              <input type="hidden" class="form-control" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][product_id]" value="<?= $value['product_id']?>">
                              <span id="span"></span></td>
                            <td class="center"><input type="text" class="form-control amount A<?=$key.$value['order_id']?>" required readonly="" name=""></td>
                          </tr>
                      <?php } if (($skey+1)==$stockCount) { ?>
                          <tr class="<?=$key.$value['order_id']?>">
                            <td class="center" colspan="2">Total</td>
                            <input type="hidden" name="" class="assgin_quantity">
                            <td class="center " id="assgin_quantity" ><?=$totalqty?></td>  
                            <td class="center" id="total_amount" colspan="2"><?=$amtqty?></td>  
                          </tr> 
                      <?php } 
                        }?>
              <?php }else{
                    if (!empty($value['stock'])) {
                      $stock_numcount=0;
                      foreach ($value['stock'] as $skey => $svalue) {
                      if ($svalue['status']==1 && $svalue['trash']==0 ) { 
                        $stock_numcount++;
                        ?>
                        <tr class="<?= $svalue['bach_no'] ?>">
                          <td class="center"><?= $svalue['bach_no'] ?></td>
                          <td class="center" id="quantity"><?= $svalue['quantity'] ?></td>
                          <td class="center">
                            <input type="text" class="form-control quantity <?=$key.$value['order_id']?>" oninput="this.value=this.value.replace(/[^0-9.,]/g,'');" onkeyup="Quantity(this.value,'<?= $svalue['bach_no'] ?>','<?=$key.$value['order_id']?>','A<?=$key.$value['order_id']?>','<?= $value['quantity'] ?>')" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][quantity]" value="">
                            <input type="hidden" class="form-control" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][type]" value="distributor">
                            <span class="span"></span></td>
                          <td class="center">
                            <input type="text" class="form-control unit" oninput="this.value=this.value.replace(/[^0-9.,]/g,'');" onkeyup="Unit(this.value,'<?= $svalue['bach_no'] ?>','<?=$key.$value['order_id']?>','A<?=$key.$value['order_id']?>','<?= $value['quantity'] ?>')" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][unit]" value="">
                            <input type="hidden" class="form-control" name="<?=$value['order_id']?>[<?=$value['id']?>][<?= $svalue['bach_no'] ?>][product_id]" value="<?= $value['product_id']?>">
                            <span id="span"></span></td>
                          <td class="center"><input type="text" class="form-control amount A<?=$key.$value['order_id']?>" required readonly="" name=""></td>
                        </tr>
                    <?php } if (($skey+1)==$stockCount) { 
                                if ($stock_numcount!=0) { ?>
                                  <tr class="<?=$key.$value['order_id']?>">
                                    <td class="center" colspan="2">Total</td>
                                    <input type="hidden" name="" class="assgin_quantity">
                                    <td class="center " id="assgin_quantity" >0</td>  
                                    <td class="center" id="total_amount" colspan="2">0</td>  
                                  </tr> 
                    <?php }else{
                          echo'<tr><td style="text-align: center;" colspan="5">Out Of Stock</td></tr>';
                    } }
                      }
                    }else{ ?>
                      <tr><td style="text-align: center;" colspan="5">Out Of Stock</td></tr>
                    <?php }
                  }  ?>
                        </tbody>
                    </table>
                  <?php }
                  }
                  ?>
                        
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-info" id="advertid" data-loading-text="<?php echo _l('wait_text'); ?>"> Save </button>
        					       <a href="<?= site_url('orders')?>" class="btn btn-warning">Cancel</a>
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
    function Quantity(value,id,QId,Aid,Tqty) {

      var head = $('.'+id);
      var maxquantity = head.find('#quantity').text();
      var values =(Math.trunc(value));
      if (parseInt(values) > 0 && parseInt(values) <= parseInt(maxquantity)) {
        head.find('.unit').attr('required',true);
        var unit = head.find('.unit').val();
        if (unit!="") {
          //this is for to calculate amount
          var amount=(parseFloat(values) * parseFloat(unit));
          //this is for to check assgin quantity
          var qtySum = 0 ;
          $('.'+QId).each( function( i, el ) {
            var elem = $( el );
            if(elem.val()!=''){
              qtySum +=  parseInt(elem.val());
            }
          });
          //this is for tocheck required qty to total qty
          if (qtySum <= parseInt(Tqty)) {
            head.find('.amount').val(amount)
            //this is for to calculate Total amount
            var amtSum = 0 ;
            $('.'+Aid).each( function( i, el ) {
              var elem = $( el );
              if(elem.val()!=''){
                amtSum +=  parseInt(elem.val());
              }
            });
            //this is for if qty is less than equal to assgin qty
            $('.'+QId).find('#total_amount').text(amtSum);
            $('.'+QId).find('#assgin_quantity').text(qtySum);
            head.find('.span').text('');
          }else{
            //this is for if qty is assgin is greater than required
            head.find('.quantity').val('');
            head.find('.amount').val('');
            //this is for to calculate quantity
            var qtySum = 0 ;
            $('.'+QId).each( function( i, el ) {
              var elem = $( el );
              if(elem.val()!=''){
                qtySum +=  parseInt(elem.val());
              }
            });
            //this is for to calculate Total amount
            var amtSum = 0 ;
            $('.'+Aid).each( function( i, el ) {
              var elem = $( el );
              if(elem.val()!=''){
                amtSum +=  parseInt(elem.val());
              }
            });

            $('.'+QId).find('#assgin_quantity').text(qtySum);
            $('.'+QId).find('#total_amount').text(amtSum);
            head.find('.span').css('color','red');
            head.find('.span').text('Request Less Quantity Than assgin');
            alert('Request Quantity Is Less Than assgin');
          }
        } else {
          //this is for to check assgin quantity
          var qtySum = 0 ;
          $('.'+QId).each( function( i, el ) {
            var elem = $( el );
            if(elem.val()!=''){
              qtySum +=  parseInt(elem.val());
            }
          });
          //this is for tocheck required qty to total qty
          if (qtySum <= parseInt(Tqty)) {
            //this is for if qty is less than equal to assgin qty
            $('.'+QId).find('#assgin_quantity').text(qtySum);
            head.find('.span').text('');
          }else{
            //this is for if qty is assgin is greater than required
            head.find('.quantity').val('');
            var qtySum = 0 ;
            $('.'+QId).each( function( i, el ) {
              var elem = $( el );
              if(elem.val()!=''){
                qtySum +=  parseInt(elem.val());
              }
            });
            $('.'+QId).find('#assgin_quantity').text(qtySum);
            head.find('.span').css('color','red');
            head.find('.span').text('Request Less Quantity Than assgin');
            alert('Request Quantity Is Less Than assgin');
          }
        }
      }else if (parseInt(values) >= parseInt(maxquantity)){
        head.find('.quantity').val(values)
        head.find('.span').css('color','red')
        head.find('.span').text('Input Quantity Is Greater than Available');
      }else if (parseInt(values) ==""){
        head.find('.unit').removeAttr('required');
        head.find('.quantity').removeAttr('required');
        head.find('.span').css('color','red')
        head.find('.span').text('Input Quantity Required');
      }
    }

    function Unit(value,id,QId,Aid,Tqty) {
      var head=$('.'+id);
      console.log('value-ali',value)
      var quantity = head.find('.quantity').val();
      if (parseInt(value) > 0 && parseInt(quantity) > 0) {
          var amount=(parseFloat(value) * parseFloat(quantity));
          head.find('.amount').val(amount);
          head.find('#span').text('');
          //this is for to calculate total amount
          var amtSum = 0 ;
          $('.'+Aid).each( function( i, el ) {
            var elem = $( el );
            if(elem.val()!=''){
              amtSum +=  parseInt(elem.val());
            }
          });
          //this is for to check assgin quantity
          var qtySum = 0 ;
          $('.'+QId).each( function( i, el ) {
            var elem = $( el );
            if(elem.val()!=''){
              qtySum +=  parseInt(elem.val());
            }
          });
          if (qtySum <= parseInt(Tqty)) {
            $('.'+QId).find('#total_amount').text(amtSum);
          }else{
            alert('Request Quantity Is Less Than assgin');
          }
          
      }else if (parseInt(value) == 0){
        console.log('else-if-1')
        head.find('.quantity').removeAttr('required');
        head.find('#span').css('color','red')
        head.find('#span').text('Input Value Should Be Greater Than 0');
      }else if (parseInt(value) == ""){
        console.log('else-if-2')
        head.find('.quantity').removeAttr('required');
        head.find('#span').css('color','red')
        head.find('#span').text('');
      }else if (quantity == ''){
        console.log('else-if-3')
        head.find('.quantity').removeAttr('required');
        head.find('.span').css('color','red')
        head.find('.span').text(' ');
      }
    }
        // var sid = '<?= $article->id ?>';
        // $(function(){
        //   if(sid)
        //     appValidateForm($('#portfolioForm'),{product:{extension: "png,jpg,jpeg,gif"}});
        //   else
        //     appValidateForm($('#portfolioForm'),{product:{required:true,extension: "png,jpg,jpeg,gif"}});
        // });  


        // function getStatelist(Id)
        // {
        //   $('#state').html('<option value="">Please wait...</option>');
        //   $('#city').html('<option value=""></option>');
        //   var str = "country="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
        //   $.ajax({
        //       url: '<?// admin_url()?>products/getStatelist',
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

        // function getCategorylist(Id)
        // {
        //   $('#category_id').html('<option value="">Please wait...</option>');
        //   var str = "state="+Id+"&"+csrfData['token_name']+"="+csrfData['hash'];
        //   $.ajax({
        //       url: '<?= admin_url()?>products/getCategorylist',
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
        //           $('#category_id').html(res);
        //         }
        //         else
        //         {
        //           $('#category_id').html('<option value=""></option>');
        //         }
        //         $('#subcategory_id').html('<option value=""></option>');
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

        $("#advertid").click(function() {
          setTimeout(function(){
              $("#advertid").removeAttr("disabled");
              $("#advertid").removeClass("disabled");
              $('#advertid').text('Save');
            }, 5000);
        });
	</script>
  <!-- <script>
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
</script> -->
</body>
</html>
