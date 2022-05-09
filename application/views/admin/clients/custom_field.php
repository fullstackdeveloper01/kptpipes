<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <a href="<?php echo admin_url('clients/addField'); ?>" class="btn btn-info mright5 test pull-left display-block">
                                <?php echo _l('New '.$subtext_); ?>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                       <h4 class="no-margin">
                          <?php echo $title; ?>
                       </h4>
                       <hr class="hr-panel-heading" />              
                        <?php echo form_open_multipart($this->uri->uri_string()); ?>
                            <div class="row">
                              <div class="col-md-12">
                                <div class="panel_s">
                                   <div class="panel-body">
                                        <div class="row mbot15">
                                            <div class="col-md-12">
                                                <div class="form-group favicon_upload">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                          <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('first_name', $customFields_result))?"checked":"";?> name="custome_field[]" value="first_name" /> 
                                                          First name</label>  &nbsp;&nbsp;&nbsp;
                                                          <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('first_name', $requiredFields_result))?"checked":"";?> name="required_field[]" value="first_name" /> 
                                                          Required</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                             <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('last_name', $customFields_result))?"checked":"";?> name="custome_field[]" value="last_name" />
                                                             Last name</label> &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('last_name', $requiredFields_result))?"checked":"";?> name="required_field[]" value="last_name" />
                                                            Required</label>
                                                        </div> 
                                                        <div class="col-md-4">
                                                          <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('email', $customFields_result))?"checked":"";?> name="custome_field[]" value="email" />
            
                                                          Email</label>
                                                          &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('email', $requiredFields_result))?"checked":"";?> name="required_field[]" value="email" />
                                                            Required</label>
                                                        </div>
                                                    </div><hr />
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                             <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('phone', $customFields_result))?"checked":"";?> name="custome_field[]" value="phone" />
            
                                                             Phone</label>
                                                             &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('phone', $requiredFields_result))?"checked":"";?> name="required_field[]" value="phone" />
                                                            Required</label>
                                                        </div>                                    
                                                    
                                                        <div class="col-md-4">
                                                          <label for="logo_image" class="control-label">
                                                           <input type="checkbox" <?= (in_array('zip_code', $customFields_result))?"checked":"";?> name="custome_field[]" value="zip_code" />
            
                                                          Zip Code</label>
                                                          &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('zip_code', $requiredFields_result))?"checked":"";?> name="required_field[]" value="zip_code" />
                                                            Required</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                             <label for="logo_image" class="control-label">
                                                                <input type="checkbox" <?= (in_array('address', $customFields_result))?"checked":"";?> name="custome_field[]" value="address" />
            
                                                             Address</label>
                                                              &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('address', $requiredFields_result))?"checked":"";?> name="required_field[]" value="address" />
                                                            Required</label>
                                                        </div>                                    
                                                    </div><hr />
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                          <label for="vat_number" class="control-label">
                                                           <input type="checkbox" <?= (in_array('vat_number', $customFields_result))?"checked":"";?> name="custome_field[]" value="vat_number" />
                                                           VAT Number</label>
                                                           &nbsp;&nbsp;&nbsp;
                                                            <label for="vat_number" class="control-label">
                                                            <input type="checkbox" <?= (in_array('vat_number', $requiredFields_result))?"checked":"";?> name="required_field[]" value="vat_number" />
                                                            Required</label>
                                                        </div>
                                                        <div class="col-md-4">
                                                             <label for="logo_image" class="control-label"><input type="checkbox" name="custome_field[]" <?= (in_array('company_name', $customFields_result))?"checked":"";?> value="company_name" /> Company name</label>
                                                              &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('company_name', $requiredFields_result))?"checked":"";?> name="required_field[]" value="company_name" />
                                                            Required</label>
                                                            
                                                        </div>  
                                                        <div class="col-md-4">
                                                          <label for="logo_image" class="control-label">
                                                           <input type="checkbox" <?= (in_array('password', $customFields_result))?"checked":"";?> name="custome_field[]" value="password" />
                                                            Password</label>
                                                           &nbsp;&nbsp;&nbsp;
                                                            <label for="password" class="control-label">
                                                            <input type="checkbox" <?= (in_array('password', $requiredFields_result))?"checked":"";?> name="required_field[]" value="password" />
                                                            Required</label>
                                                        </div>
                                                    </div><hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                             <label for="website" class="control-label"><input type="checkbox" name="custome_field[]" <?= (in_array('website', $customFields_result))?"checked":"";?> value="website" /> Website</label>
                                                              &nbsp;&nbsp;&nbsp;
                                                            <label for="website" class="control-label">
                                                            <input type="checkbox" <?= (in_array('website', $requiredFields_result))?"checked":"";?> name="required_field[]" value="website" />
                                                            Required</label>
                                                        </div>                            
                                                    
                                                        <div class="col-md-4">
                                                             <label for="currency" class="control-label"><input type="checkbox" name="custome_field[]" <?= (in_array('currency', $customFields_result))?"checked":"";?> value="currency" /> Currency</label>
                                                              &nbsp;&nbsp;&nbsp;
                                                            <label for="currency" class="control-label">
                                                            <input type="checkbox" <?= (in_array('currency', $requiredFields_result))?"checked":"";?> name="required_field[]" value="currency" />
                                                            Required</label>                              
                                                        </div> 
                                                        <div class="col-md-4">
                                                          <label for="logo_image" class="control-label">
                                                           <input type="checkbox" <?= (in_array('city', $customFields_result))?"checked":"";?> name="custome_field[]" value="city" />
                                                            City</label>
                                                           &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('city', $requiredFields_result))?"checked":"";?> name="required_field[]" value="city" />
                                                            Required</label>
                                                        </div>
                                                         
                                                    </div><hr>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                             <label for="logo_image" class="control-label"><input type="checkbox" name="custome_field[]" <?= (in_array('state', $customFields_result))?"checked":"";?> value="state" /> State</label>
                                                              &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('state', $requiredFields_result))?"checked":"";?> name="required_field[]" value="state" />
                                                            Required</label>                              
                                                        </div> 
                                                        <div class="col-md-4">
                                                             <label for="logo_image" class="control-label"><input type="checkbox" name="custome_field[]" <?= (in_array('country', $customFields_result))?"checked":"";?> value="country" /> Country</label>
                                                              &nbsp;&nbsp;&nbsp;
                                                            <label for="logo_image" class="control-label">
                                                            <input type="checkbox" <?= (in_array('country', $requiredFields_result))?"checked":"";?> name="required_field[]" value="country" />
                                                            Required</label>                                                
                                                        </div>                                   
                                                    </div><hr>
                                                    <div class="form-group">
                                                        <?php
                                                            if($customfield_data)
                                                            {
                                                                $ee = 1;
                                                                $k = 5;
                                                                foreach($customfield_data as $rrs)
                                                                {
                                                                    if($ee % 2 != 0)
                                                                    {
                                                                        if($k == 5)
                                                                        echo '<div class="row">';
                                                                    }
                                                                    ?>
                                                                        <div class="col-md-4">
                                                                            <label for="<?= $rrs->name; ?>" class="control-label">
                                                                                <input type="checkbox" name="custom_fieldvalue[]" value="<?= $rrs->id; ?>" id="field_<?= $rrs->id?>" <?= ($rrs->active == 1)?"checked":""; ?>/>
                                                                                <?= $rrs->name; ?>
                                                                            </label>
                                                                          &nbsp;&nbsp;&nbsp;
                                                                            <label for="<?= $rrs->name; ?>" class="control-label">
                                                                            <input type="checkbox" name="custom_fieldrequired[]" value="<?= $rrs->id; ?>" <?= ($rrs->required == 1)?"checked":"";?> />
                                                                            Required</label>
                                                                        </div>
                                                                    <?php
                                                                    if($ee % 2 == 0)
                                                                    {
                                                                        $k = 4;
                                                                        echo '</div><hr>';
                                                                    }
                                                                    $ee++;
                                                                    $k++;
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                </div>                                 
                                            </div>
                                        </div>
                                        <div class="btn-bottom-toolbar text-right">
                                            <button type="submit" class="btn btn-info">
                                                Save Settings                  
                                             </button>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="clearfix"></div>
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
   $(function(){
        initDataTable('.table-customer-groups', window.location.href, [1], [1]);
   });
   
   function fieldShowHide(id)
   {
       var field_val = '';
       if($('#field_'+id).prop("checked") == true)
         field_val = 1;
       else
        field_val = 0;
        
        var str = 'field_val='+field_val+'&ID='+id;
        $.ajax({
            url: '<?= admin_url()?>clients/fieldsOption',
            type: 'POST',
            data: str,
            cache: false,
            success: function(resp){
                
            }
        });
   }
</script>
</body>
</html>
