<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $this->load->view('authentication/includes/head.php'); ?>
<?php
  if($settingRes)
  {
    if($settingRes->background_type == 'color')
    {
        ?>
          <body style="background-color: <?= $settingRes->background_color; ?>;">
        <?php
    }
    else
    {
        ?>
          <body style="background-image: url('<?= base_url() ?>uploads/loginPage/<?= $settingRes->background_image; ?>');">
        <?php
    }
  }
  else
  {
    ?>
        <body class="authentication reset-password">
    <?php
  }
?>

 <div class="container">
  <div class="row">
   <div class="col-md-4 col-md-offset-4 col-sm-8 col-sm-offset-2 authentication-form-wrapper">
    <div class="company-logo">
        <?php
            if($settingRes->logo_image != '')
            {
                ?>
                    <img src="<?= base_url() ?>uploads/loginPage/<?= $settingRes->logo_image; ?>" class="img-responsive" alt="" width="40%">
                <?php
            }
        ?>
      <?php /*get_company_logo(); */?>
    </div>
   <div class="mtop40 authentication-form">
    <h1><?php echo _l('admin_auth_reset_password_heading'); ?></h1>
    <?php echo form_open($this->uri->uri_string()); ?>
    <?php echo validation_errors('<div class="alert alert-danger text-center">', '</div>'); ?>
    <?php $this->load->view('authentication/includes/alerts'); ?>
    <?php echo render_input('password','admin_auth_reset_password','','password'); ?>
    <?php echo render_input('passwordr','admin_auth_reset_password_repeat','','password'); ?>
    <div class="form-group">
      <button type="submit" class="btn btn-info btn-block"><?php echo _l('auth_reset_password_submit'); ?></button>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
</div>
</div>
</body>
</html>
