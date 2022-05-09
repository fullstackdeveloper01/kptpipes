<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
 <div class="content">
  <?php echo form_open($this->uri->uri_string()); ?>
    <div class="row">
     <?php if ($this->session->flashdata('debug')) {
        ?>
       <div class="col-lg-12">
        <div class="alert alert-warning">
         <?php echo $this->session->flashdata('debug'); ?>
       </div>
     </div>
    <?php
    } ?>
     <div class="col-md-3">
        <ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked">
            <li>
                <a href="<?= admin_url('dashboardSetting');?>" data-group="dashboard-setting">
                    Main Box
                </a>
            </li>
            <li>
                <a href="<?= admin_url('dashboardSetting/countBox');?>">
                    Count Box
                </a>
            </li>
            <li class="active">
                <a href="#">
                    Graph Box
                </a>
            </li>
        </ul>
        <div class="panel_s">
            <div class="btn-bottom-toolbar text-right">
                <button type="submit" class="btn btn-info">
                    <?php echo _l('settings_save'); ?>
                </button>
            </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="panel_s">
         <div class="panel-body">
          <?php hooks()->do_action('before_settings_group_view', 'dashboard-setting'); ?>
            <div class="row">
            	<div class="col-md-12">
            	    <div class="form-group">
            	        <h4>First Graph</h4>
            	    </div>
            	    <div class="row">
                        <div class="form-group col-md-4">
                            <label for="box_one_bgcolor" class="control-label">Heading</label>
                            <input type="text" value="<?= $box_result[0]->heading; ?>" name="first_heading" id="heading" class="form-control">
                        </div> 
                        <div class="form-group col-md-4">
                            <label for="name" class="control-label">Graph For</label>
                            <select id="name" name="first_name" class="form-control">
                                <option value=""></option>
                                <option value="clients" <?= ($box_result[0]->name == "clients")?"selected":"";?>>User's List</option>
                                <option value="proposals" <?= ($box_result[0]->name == "proposals")?"selected":"";?>>Proposals</option>
                                <option value="estimates" <?= ($box_result[0]->name == "estimates")?"selected":"";?>>Estimates</option>
                                <option value="invoices" <?= ($box_result[0]->name == "invoices")?"selected":"";?>>Invoices</option>
                                <option value="payments" <?= ($box_result[0]->name == "payments")?"selected":"";?>>Payments</option>
                                <option value="subscriptions" <?= ($box_result[0]->name == "subscriptions")?"selected":"";?>>Subscriptions</option>
                                <option value="expenses" <?= ($box_result[0]->name == "expenses")?"selected":"";?>>Expenses</option>
                                <option value="tickets" <?= ($box_result[0]->name == "tickets")?"selected":"";?>>Supports</option>
                                <option value="knowledge_base" <?= ($box_result[0]->name == "knowledge_base")?"selected":"";?>>Knowledge Base</option>
                                <option value="roles" <?= ($box_result[0]->name == "roles")?"selected":"";?>>Roles</option>
                                <option value="loginPage" <?= ($box_result[0]->name == "loginPage")?"selected":"";?>>Login Page</option>
                                <option value="staff" <?= ($box_result[0]->name == "staff")?"selected":"";?>>Admin Users</option>
                                <option value="taxes" <?= ($box_result[0]->name == "taxes")?"selected":"";?>>Taxes Rate</option>
                                <option value="currencies" <?= ($box_result[0]->name == "currencies")?"selected":"";?>>Currencies</option>
                                <option value="projects" <?= ($box_result[0]->name == "projects")?"selected":"";?>>Projects</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="box_one_iconcolor" class="control-label">Status</label>
                            <div class="onoffswitch" data-toggle="tooltip">
                                <input type="checkbox" name="first_status" class="onoffswitch-checkbox" id="8" data-id="8" value="1" <?= ($box_result[0]->status == 1)?"checked":"";?>>
                                <label class="onoffswitch-label" for="8"></label>
                            </div>
                        </div> 
                    </div>
            	</div>
            </div>
          <?php hooks()->do_action('after_settings_group_view', $tab); ?>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php echo form_close(); ?>
<div class="btn-bottom-pusher"></div>
</div>
</div>
<div id="new_version"></div>
<?php init_tail(); ?>

<link href="http://php.manageprojects.in/pre-crm/modules/menu_setup/assets/font-awesome-icon-picker/css/fontawesome-iconpicker.min.css" rel="stylesheet">
<script src="http://php.manageprojects.in/pre-crm/modules/menu_setup/assets/font-awesome-icon-picker/js/fontawesome-iconpicker.js"></script>
<script>
   var iconPickerInitialized = false;
   $(function(){

     $('.icon-picker').iconpicker()
         .on({'iconpickerSetSourceValue': function(e){
           _formatMenuIconInput(e);
         }})
         iconPickerInitialized = true;
   });
  </script>
<?php hooks()->do_action('settings_tab_footer', $tab); ?>
</body>
</html>
