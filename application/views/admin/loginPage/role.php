<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
<div class="content">
   <div class="row">
      <div class="col-md-12">
         <div class="panel_s">
            <div class="panel-body">
               <h4 class="no-margin">
                  <?php echo $title; ?>
               </h4>
               <hr class="hr-panel-heading" />              
               <?php echo form_open_multipart($this->uri->uri_string()); ?>
               <div class="row">
                  <div class="col-md-12">
                    <div class="panel_s">
                       <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group favicon_upload">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label for="logo_image" class="control-label">Logo Image</label>
                                             <input type="file" name="logo_image" class="form-control" />
                                          </div>
                                          <div class="col-md-6">
                                             <img src="<?= base_url()?>uploads/loginPage/<?= @$editDetails->logo_image; ?>" width="60" height="70" alt=""/>
                                          </div>                                    
                                        </div>
                                    </div> <hr/>
                                    <div class="form-group">
                                        <label> Background Default </label><br>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" id="background_type_color" onClick="showBackground('color_')" name="background_type" <?= ($editDetails->background_type == 'color')?"checked":"";?> value="color" />
                                            <label for="background_type"> Color </label>
                                        </div>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" onClick="showBackground('image_')" id="background_type" <?= ($editDetails->background_type == 'image')?"checked":"";?> name="background_type" value="image" />
                                            <label> Image </label>
                                        </div>
                                    </div>
                                    <div class="form-group background_ image_" style="display: <?= ($editDetails->background_type == 'image')?"block":"none";?>;">
                                       <div class="row">
                                          <div class="col-md-6">
                                              <label for="background_image">Background Image</label>
                                              <input type="file" name="background_image" class="form-control" value="" data-toggle="tooltip" />
                                          </div>
                                          <div class="col-md-6">
                                             <img src="<?= base_url()?>uploads/loginPage/<?= @$editDetails->background_image; ?>" width="60" height="70" alt="" />
                                          </div>
                                       </div>
                                    </div>
                                 
                                    <div class="form-group background_ color_" style="display: <?= ($editDetails->background_type == 'color')?"block":"none";?>;">
                                        <label for="company_logo_dark" class="control-label">Background color </label>
                                        <input type="color" name="background_color" id="background_color" value="#51647c"/>
                                    </div>                                    
                                    <hr />
                                    <div class="form-group">
                                        <label> Show Re-captcha </label><br>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" id="background_type_yes" name="re_captcha_option" <?= ($editDetails->re_captcha_option == 'yes')?"checked":"";?> value="yes" />
                                            <label for="re_captcha_option_yes"> Yes </label>
                                        </div>
                                        <div class="radio radio-primary radio-inline">
                                            <input type="radio" <?= ($editDetails->re_captcha_option == 'no')?"checked":"";?> id="re_captcha_option_no" name="re_captcha_option" value="no" />
                                            <label> No </label>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-md-6">
                                             <label>Site Key</label>
                                             <input type="text" id="site_key" value="<?= @$editDetails->site_key; ?>" name="site_key" class="form-control" />
                                          </div>
                                          <div class="col-md-6">
                                             <label for="secret_key" class="control-label">Secret Key</label>
                                             <input type="text" value="<?= @$editDetails->secret_key; ?>" id="secret_key" name="secret_key" class="form-control" />
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
            </div>
         </div>
      </div>
   </div>
</div>
<?php init_tail(); ?>
<script>
   function showBackground(type)
   {
      $('.background_').hide();
      $('.'+type).show();
   }

   $(function(){
     appValidateForm($('form'),{name:'required'});
   });
</script>
</body>
</html>
