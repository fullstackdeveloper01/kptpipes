<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s mbot5">
  <div class="panel-body padding-10">
      <h4 class="bold">
        <?php echo $title;?>
      </h4>
  </div>
</div>
<ul class="nav navbar-pills navbar-pills-flat nav-tabs nav-stacked customer-tabs" role="tablist">
  <li class="customer_tab_colleges <?= ($pagename == 'profile')?'active':'';?>">
    <a data-group="profile" href="<?php echo admin_url('distributors/add/'.$article->id); ?>">
      <i class="fa fa-user-circle menu-icon" aria-hidden="true"></i>
      <?= _l('Information'); ?>
    </a>
  </li>
   <li class="customer_tab_colleges <?= ($pagename == 'loginDetails')?'active':'';?>">
    <a data-group="loginDetails" href="<?php echo admin_url('distributors/loginDetails/'.$article->id); ?>">
      <i class="fa fa-lock menu-icon" aria-hidden="true"></i>
      <?= _l('Login Details'); ?>
    </a>
  </li>
</ul>