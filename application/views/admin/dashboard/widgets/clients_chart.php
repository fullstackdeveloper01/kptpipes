<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="widget" id="widget-<?php echo basename(__FILE__,".php"); ?>" data-name="<?php echo _l('s_chart',_l('Users')); ?>">
  <div class="row">
    <div class="col-md-12">
     <div class="panel_s">
       <div class="panel-body padding-10">
        <div class="widget-dragger"></div>
        <p class="padding-5"><?php echo _l('Users Chart'); ?></p>
        <hr class="hr-panel-heading-dashboard">
        <div class="relative" style="height:250px">
         <canvas class="chart" height="250" id="client_graph_by_status"></canvas>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
