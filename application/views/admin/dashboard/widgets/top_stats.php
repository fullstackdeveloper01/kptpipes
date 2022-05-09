<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .firstbox:hover{
        background: <?= $box_result[0]->hover_color; ?>;
    }
    
    .firstbox {
        background: <?= $box_result[0]->bg_color; ?>;
    }
    
    .secondbox:hover{
        background: <?= $box_result[1]->hover_color; ?>;
    }
    
    .secondbox {
        background: <?= $box_result[1]->bg_color; ?>;
    }
    
    .thirdbox:hover{
        background: <?= $box_result[2]->hover_color; ?>;
    }
    
    .thirdbox {
        background: <?= $box_result[2]->bg_color; ?>;
    }
    
    .fourthbox:hover{
        background: <?= $box_result[3]->hover_color; ?>;
    }
    
    .fourthbox {
        background: <?= $box_result[3]->bg_color; ?>;
    }
    
    /* --- Count --- */
    .firstbox_:hover{
        background: <?= $box_result[4]->hover_color; ?>;
    }
    
    .firstbox_ {
        background: <?= $box_result[4]->bg_color; ?>;
    }
    
    .secondbox_:hover{
        background: <?= $box_result[5]->hover_color; ?>;
    }
    
    .secondbox_ {
        background: <?= $box_result[5]->bg_color; ?>;
    }
    
    .thirdbox_:hover{
        background: <?= $box_result[6]->hover_color; ?>;
    }
    
    .thirdbox_ {
        background: <?= $box_result[6]->bg_color; ?>;
    }
    
    .fourthbox_:hover{
        background: <?= $box_result[7]->hover_color; ?>;
    }
    
    .fourthbox_ {
        background: <?= $box_result[7]->bg_color; ?>;
    }
    /* --// -- */
    
    .dashboardBox{
        height: 130px;
        width: auto;
    }
    
    
    .small-box-footer {
        position: relative;
        text-align: center;
        padding: 3px 0;
        display: block;
        z-index: 10;
        text-decoration: none;
    }
    
    
    .top_stats_wrapper {
        padding: 20px;
        -webkit-box-shadow: 0;
        box-shadow: 0;
        margin-bottom: 30px;
        width: 100%;
        min-height: 138px;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(0,0,0,.125);
        border-radius: .25rem;
    }
    
.top_stats_wrapper .pull-right{
    position: absolute;
    top: 0px;
    right: 0px;
    opacity: 0.1;
    z-index: 0;
}
.top_stats_wrapper .pull-right .fa{
    font-size: 70px;
}
.top_stats_wrapper p a{
    font-weight: bold;
    color: #5d9df4;
    font-size: 1.75rem;
}
.top_stats_wrapper:hover a{
    color:#fff;
}
.top_stats_wrapper:hover p{
    color:#fff;
}
.top_stats_wrapper p small{
    font-weight: 400;
    color: #465165;
    font-size: 1.5rem;
}
.top_stats_wrapper:hover small{
    color:#fff;
}
.top_stats_wrapper .fa-arrow-right{
    color: #888;
    position: absolute;
    bottom: 19px;
    transition: 1s;
}
.firstbox:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
.secondbox:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
.thirdbox:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
.fourthbox:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}

.firstbox_:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
.secondbox_:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
.thirdbox_:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
.fourthbox_:hover .fa-arrow-right{
    color: #fff;
    margin-left: 10px;
}
</style>

<div class="widget relative hide" id="widget-<?php echo basename(__FILE__,".php"); ?>" data-name="<?php echo _l('quick_stats'); ?>">
      <div class="widget-dragger"></div>
      <div class="row">
      <?php
         $initial_column = 'col-lg-3';
         if(!is_staff_member() && ((!has_permission('invoices','','view') && !has_permission('invoices','','view_own') && (get_option('allow_staff_view_invoices_assigned') == 0
           || (get_option('allow_staff_view_invoices_assigned') == 1 && !staff_has_assigned_invoices()))))) {
            $initial_column = 'col-lg-6';
         } else if(!is_staff_member() || (!has_permission('invoices','','view') && !has_permission('invoices','','view_own') && (get_option('allow_staff_view_invoices_assigned') == 1 && !staff_has_assigned_invoices()) || (get_option('allow_staff_view_invoices_assigned') == 0 && (!has_permission('invoices','','view') && !has_permission('invoices','','view_own'))))) {
            $initial_column = 'col-lg-4';
         }
      ?>
         <?php if(has_permission('invoices','','view') || has_permission('invoices','','view_own') || (get_option('allow_staff_view_invoices_assigned') == '1' && staff_has_assigned_invoices())){ ?>
         <div class="quick-stats-invoices col-xs-12 col-md-6 col-sm-6 <?php echo $initial_column; ?>">
            <div class="top_stats_wrapper firstbox dashboardBox">
               <?php
               /*
                  $total_invoices = total_rows(db_prefix().'invoices','status NOT IN (5,6)'.(!has_permission('invoices','','view') ? ' AND ' . get_invoices_where_sql_for_staff(get_staff_user_id()) : ''));
                  $total_invoices_awaiting_payment = total_rows(db_prefix().'invoices','status NOT IN (2,5,6)'.(!has_permission('invoices','','view') ? ' AND ' . get_invoices_where_sql_for_staff(get_staff_user_id()) : ''));
                  $percent_total_invoices_awaiting_payment = ($total_invoices > 0 ? number_format(($total_invoices_awaiting_payment * 100) / $total_invoices,2) : 0);
                  */
                  ?>
                <div class="pull-right"> <i class="hidden-sm <?= $box_result[0]->icon; ?> fa-4x" style="color: <?= $box_result[0]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"> 
                    <h4><a href="<?= ($box_result[0]->link != "")?admin_url($box_result[0]->link):"#";?>" style="color:<?= $box_result[0]->heading_one_color; ?>"><?php echo _l($box_result[0]->heading_one); ?></a></h4>
                </p>
                <p>
                    <span style="color:<?= $box_result[0]->heading_two_color; ?>"><?= $box_result[0]->heading_two; ?></span>
                </p>
                <div class="clearfix"></div><br>
                <a href="<?= ($box_result[0]->link != "")?admin_url($box_result[0]->link):"#";?>"><i class="fa fa-arrow-right"></i></a>
               <!--
               <div class="progress no-margin progress-bar-mini">
                  <div class="progress-bar progress-bar-danger no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $percent_total_invoices_awaiting_payment; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $percent_total_invoices_awaiting_payment; ?>">
                  </div>
               </div>
               -->
            </div>
         </div>
         <?php } ?>
         <?php if(is_staff_member()){ ?>
         <div class="quick-stats-leads col-xs-12 col-md-6 col-sm-6 <?php echo $initial_column; ?>">
            <div class="top_stats_wrapper secondbox dashboardBox">
                <div class="pull-right"> <i class="hidden-sm <?= $box_result[1]->icon; ?> fa-4x" style="color: <?= $box_result[1]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"> 
                   <h4> <a href="<?= ($box_result[1]->link != "")?admin_url($box_result[1]->link):"#";?>" style="color:<?= $box_result[1]->heading_one_color; ?>"><?php echo _l($box_result[1]->heading_one); ?></a></h4>
                </p>
                <p>
                    <span style="color:<?= $box_result[1]->heading_two_color; ?>"><?= $box_result[1]->heading_two; ?></span>
                </p>
                <div class="clearfix"></div><br>
                <a href="<?= ($box_result[1]->link != "")?admin_url($box_result[1]->link):"#";?>"><i class="fa fa-arrow-right"></i></a>
            <!--
               <?php
                  $where = '';
                  if(!is_admin()){
                    $where .= '(addedfrom = '.get_staff_user_id().' OR assigned = '.get_staff_user_id().')';
                  }
                  // Junk leads are excluded from total
                  $total_leads = total_rows(db_prefix().'leads',($where == '' ? 'junk=0' : $where .= ' AND junk =0'));
                  if($where == ''){
                   $where .= 'status=1';
                  } else {
                   $where .= ' AND status =1';
                  }
                  $total_leads_converted = total_rows(db_prefix().'leads',$where);
                  $percent_total_leads_converted = ($total_leads > 0 ? number_format(($total_leads_converted * 100) / $total_leads,2) : 0);
                  ?>
               <p class="text-uppercase mtop5"><i class="hidden-sm fa fa-tty"></i> <?php echo _l('leads_converted_to_client'); ?>
                  <span class="pull-right"><?php echo $total_leads_converted; ?> / <?php echo $total_leads; ?></span>
               </p>
               <div class="clearfix"></div>
               <div class="progress no-margin progress-bar-mini">
                  <div class="progress-bar progress-bar-success no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $percent_total_leads_converted; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $percent_total_leads_converted; ?>">
                  </div>
               </div>
               -->
            </div>
         </div>
         <?php } ?>
         <div class="quick-stats-projects col-xs-12 col-md-6 col-sm-6 <?php echo $initial_column; ?>">
            <div class="top_stats_wrapper thirdbox dashboardBox" >
                <div class="pull-right"> <i class="hidden-sm <?= $box_result[2]->icon; ?> fa-4x" style="color: <?= $box_result[2]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"> 
                    <h4><a href="<?= ($box_result[2]->link != "")?admin_url($box_result[2]->link):"#";?>" style="color:<?= $box_result[2]->heading_one_color; ?>"><?php echo _l($box_result[2]->heading_one); ?></a></h4>
                </p>
                <p>
                    <span style="color:<?= $box_result[2]->heading_two_color; ?>"><?= $box_result[2]->heading_two; ?></span>
                </p>
                <div class="clearfix"></div><br>
                <a href="<?= ($box_result[2]->link != "")?admin_url($box_result[2]->link):"#";?>"><i class="fa fa-arrow-right"></i></a>
                <!--
               <?php
                  $_where = '';
                  $project_status = get_project_status_by_id(2);
                  if(!has_permission('projects','','view')){
                    $_where = 'id IN (SELECT project_id FROM '.db_prefix().'project_members WHERE staff_id='.get_staff_user_id().')';
                  }
                  $total_projects = total_rows(db_prefix().'projects',$_where);
                  $where = ($_where == '' ? '' : $_where.' AND ').'status = 2';
                  $total_projects_in_progress = total_rows(db_prefix().'projects',$where);
                  $percent_in_progress_projects = ($total_projects > 0 ? number_format(($total_projects_in_progress * 100) / $total_projects,2) : 0);
                  ?>
               <p class="text-uppercase mtop5"><i class="hidden-sm fa fa-cubes"></i> <?php echo _l('projects') . ' ' . $project_status['name']; ?><span class="pull-right"><?php echo $total_projects_in_progress; ?> / <?php echo $total_projects; ?></span></p>
               <div class="clearfix"></div>
               <div class="progress no-margin progress-bar-mini">
                  <div class="progress-bar no-percent-text not-dynamic" style="background:<?php echo $project_status['color']; ?>" role="progressbar" aria-valuenow="<?php echo $percent_in_progress_projects; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $percent_in_progress_projects; ?>">
                  </div>
               </div>
               -->
            </div>
         </div>
         <div class="quick-stats-tasks col-xs-12 col-md-6 col-sm-6 <?php echo $initial_column; ?>">
            <div class="top_stats_wrapper fourthbox dashboardBox" >
                <div class="pull-right"> <i class="hidden-sm <?= $box_result[3]->icon; ?> fa-4x" style="color: <?= $box_result[3]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"> 
                    <h4><a href="<?= ($box_result[3]->link != "")?admin_url($box_result[3]->link):"#";?>" style="color:<?= $box_result[3]->heading_one_color; ?>"><?php echo _l($box_result[3]->heading_one); ?></a></h4>
                </p>
                <p>
                    <span style="color:<?= $box_result[3]->heading_two_color; ?>"><?= $box_result[3]->heading_two; ?></span>
                </p>
                <div class="clearfix"></div><br>
                <a href="<?= ($box_result[3]->link != "")?admin_url($box_result[3]->link):"#";?>"><i class="fa fa-arrow-right"></i></a>
                <!--
               <?php
                  $_where = '';
                  if (!has_permission('tasks', '', 'view')) {
                    $_where = db_prefix().'tasks.id IN (SELECT taskid FROM '.db_prefix().'task_assigned WHERE staffid = ' . get_staff_user_id() . ')';
                  }
                  $total_tasks = total_rows(db_prefix().'tasks',$_where);
                  $where = ($_where == '' ? '' : $_where.' AND ').'status != '.Tasks_model::STATUS_COMPLETE;
                  $total_not_finished_tasks = total_rows(db_prefix().'tasks',$where);
                  $percent_not_finished_tasks = ($total_tasks > 0 ? number_format(($total_not_finished_tasks * 100) / $total_tasks,2) : 0);
                  ?>
               <p class="text-uppercase mtop5"><i class="hidden-sm fa fa-tasks"></i> <?php echo _l('tasks_not_finished'); ?> <span class="pull-right">
                  <?php echo $total_not_finished_tasks; ?> / <?php echo $total_tasks; ?>
                  </span>
               </p>
               <div class="clearfix"></div>
               <div class="progress no-margin progress-bar-mini">
                  <div class="progress-bar progress-bar-default no-percent-text not-dynamic" role="progressbar" aria-valuenow="<?php echo $percent_not_finished_tasks; ?>" aria-valuemin="0" aria-valuemax="100" style="width: 0%" data-percent="<?php echo $percent_not_finished_tasks; ?>">
                  </div>
               </div>
               -->
            </div>
         </div>
      </div>
   </div>

<div class="widget relative">
    <div class="widget-dragger ui-sortable-handle"></div>
    <div class="row">
        <div class="quick-stats-invoices col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper firstbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[4]->icon; ?> fa-4x" style="color: <?= $box_result[4]->icon_color; ?>;"></i></div>
                <h2><a href="<?= admin_url('distributors'); ?>"><?= $this->db->get_where('tbldistributors')->num_rows(); ?></a></h2>
                <p></p>
                <p>
                    Total Number of Distributor
                </p>
                <div class="clearfix"></div>
                <a href="<?= admin_url('distributors'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="quick-stats-leads col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper secondbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[5]->icon; ?> fa-4x" style="color: <?= $box_result[5]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"></p>
                <h2><a href="<?= admin_url('dealers'); ?>"><?= $this->db->get_where('tbldealer')->num_rows(); ?></a></h2>
                <p></p>
                <p>
                   Total Number of Dealer
                </p>
                <div class="clearfix"></div>
                <a href="<?= admin_url('dealers'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="quick-stats-projects col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper thirdbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[6]->icon; ?> fa-4x" style="color: <?= $box_result[6]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"></p>
                <h2><a href="<?= admin_url('plumbers'); ?>"><?= $this->db->get_where('tblplumber')->num_rows(); ?></a></h2>
                <p></p>
                <p>
                    Total Number of Plumber
                </p>
                <div class="clearfix"></div>
                <a href="<?= admin_url('plumbers'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="quick-stats-tasks col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper fourthbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[7]->icon; ?> fa-4x" style="color: <?= $box_result[7]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"></p>
                <h2><a href="<?= admin_url('products'); ?>"><?= $this->db->get_where('tblproducts', array('isDeleted' => 0))->num_rows(); ?></a></h2>
                <p></p>
                <p>
                    Total Product Add
                </p>
                <div class="clearfix"></div>
                <a href="<?= admin_url('products'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <div class="widget-dragger ui-sortable-handle"></div>
    <div class="row">          
        <div class="col-md-4">         
          <div class="panel_s">
            <div class="panel-body padding-10">
              <div class="widget-dragger"></div>
              <p class="padding-5"><?php echo _l('Recently Distributor Joined'); ?>
                <span class="pull-right"><a href="<?= admin_url('distributors'); ?>">View All</a></span>
              </p>
              <hr class="hr-panel-heading-dashboard">   
              <ul class="list-unstyled todo unfinished-todos todos-sortable sortable">
                <?php
                    $distributorList = $this->db->select('id,distributor_name,distributor_email')->limit(5)->order_by('id','desc')->get_where(db_prefix().'distributors', array('status' => 1))->result();
                    if(count($distributorList)>0)
                    {
                        foreach($distributorList as $rrr)
                        {
                            ?>
                                <li class="media event">
                                  <div class="media-body">
                                    <a class="title" href="<?= admin_url('distributors/add/'.$rrr->id); ?>">
                                      <strong><?= $rrr->distributor_name; ?></strong>
                                      <span class="pull-right">More info <i class="fa fa-arrow-circle-right"></i></span>
                                    </a>
                                    <p>
                                        <?= $rrr->distributor_email; ?>
                                    </p>
                                  </div>
                                </li>
                            <?php
                        }              
                    }
                    else
                    { 
                        ?>   
                            <li class="media event dataTables_empty">No records found</li>
                        <?php 
                    }
                ?>
              </ul>
            </div>
          </div>  
        </div>          
        <div class="col-md-4">         
          <div class="panel_s">
            <div class="panel-body padding-10">
              <div class="widget-dragger"></div>
              <p class="padding-5"><?php echo _l('Recently Dealer Joined'); ?>
                <span class="pull-right"><a href="<?= admin_url('dealers'); ?>">View All</a></span>
              </p>
              <hr class="hr-panel-heading-dashboard">   
              <ul class="list-unstyled todo unfinished-todos todos-sortable sortable">
                <?php
                    $dealerList = $this->db->select('id,dealer_name,dealer_email')->limit(5)->order_by('id','desc')->get_where(db_prefix().'dealer', array('status' => 1))->result();
                    if(count($dealerList)>0)
                    {
                        foreach($dealerList as $rrr)
                        {
                            ?>
                                <li class="media event">
                                  <div class="media-body">
                                    <a class="title" href="<?= admin_url('dealers/add/'.$rrr->id); ?>">
                                      <strong><?= $rrr->dealer_name; ?></strong>
                                      <span class="pull-right">More info <i class="fa fa-arrow-circle-right"></i></span>
                                    </a>
                                    <p>
                                        <?= $rrr->dealer_email; ?>
                                    </p>
                                  </div>
                                </li>
                            <?php
                        }              
                    }
                    else
                    { 
                        ?>   
                            <li class="media event dataTables_empty">No records found</li>
                        <?php 
                    }
                ?>
              </ul>
            </div>
          </div>  
        </div>          
        <div class="col-md-4">         
          <div class="panel_s">
            <div class="panel-body padding-10">
              <div class="widget-dragger"></div>
              <p class="padding-5"><?php echo _l('Recently Plumber  Joined '); ?>
                <span class="pull-right"><a href="<?= admin_url('plumbers'); ?>">View All</a></span>
              </p>
              <hr class="hr-panel-heading-dashboard">   
              <ul class="list-unstyled todo unfinished-todos todos-sortable sortable">
                <?php
                    $dealerList = $this->db->select('id,plumber_name,plumber_email')->limit(5)->order_by('id','desc')->get_where(db_prefix().'plumber', array('status' => 1))->result();
                    if(count($dealerList)>0)
                    {
                        foreach($dealerList as $rrr)
                        {
                            ?>
                                <li class="media event">
                                  <div class="media-body">
                                    <a class="title" href="<?= admin_url('plumbers/add/'.$rrr->id); ?>">
                                      <strong><?= $rrr->plumber_name; ?></strong>
                                      <span class="pull-right">More info <i class="fa fa-arrow-circle-right"></i></span>
                                    </a>
                                    <p>
                                        <?= $rrr->plumber_email; ?>
                                    </p>
                                  </div>
                                </li>
                            <?php
                        }              
                    }
                    else
                    { 
                        ?>   
                            <li class="media event dataTables_empty">No records found</li>
                        <?php 
                    }
                ?>
              </ul>
            </div>
          </div>  
        </div>          
        <!-- <div class="col-md-3">         
          <div class="panel_s">
            <div class="panel-body padding-10">
              <div class="widget-dragger"></div>
              <p class="padding-5"><?php echo _l('Distributor for Product Enquiry'); ?>
                <span class="pull-right"><a href="<?= admin_url('productEnquiry'); ?>">View All</a></span>
              </p>
              <hr class="hr-panel-heading-dashboard">   
              <ul class="list-unstyled todo unfinished-todos todos-sortable sortable">
                <?php
                /*
                    $userlistsr = $this->db->select('id,distributor_name,distributor_email')->limit(5)->order_by('id','desc')->get_where(db_prefix().'distributors', array('status' => 1))->result();
                    if(count($userlistsr)>0)
                    {
                        foreach($userlistsr as $rrr)
                        {
                            ?>
                                <li class="media event">
                                  <div class="media-body">
                                    <a class="title" href="<?= admin_url('distributors/add/'.$rrr->id); ?>">
                                      <strong><?= $rrr->distributor_name; ?></strong>
                                      <span class="pull-right">More info <i class="fa fa-arrow-circle-right"></i></span>
                                    </a>
                                    <p>
                                        <?= $rrr->distributor_email; ?>
                                    </p>
                                  </div>
                                </li>
                            <?php
                        }              
                    }
                    else
                    { 
                        ?>   
                            <li class="media event dataTables_empty">No records found</li>
                        <?php 
                    }
                    */
                ?>
                <li class="media event dataTables_empty">No records found</li>
              </ul>
            </div>
          </div>  
        </div> -->  
    </div>
    <div class="widget-dragger ui-sortable-handle"></div>
    <!-- <div class="row">
        <div class="quick-stats-invoices col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper firstbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[4]->icon; ?> fa-4x" style="color: <?= $box_result[4]->icon_color; ?>;"></i></div>
                <h2><a href="<?= admin_url('productEnquiry'); ?>"><?= $this->db->get('product_enquiry')->num_rows(); ?></a></h2>
                <p></p>
                <p>
                    Total Number Of Product Enquiry
                </p>
                <div class="clearfix"></div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="quick-stats-leads col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper secondbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[5]->icon; ?> fa-4x" style="color: <?= $box_result[5]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"></p>
                <h2><a href="<?= admin_url('category'); ?>"><?= $this->db->get_where('tblcategory', array('parent_id' => 0))->num_rows(); ?></a></h2>
                <p></p>
                <p>
                   Total Main category
                </p>
                <div class="clearfix"></div>
                <a href="<?= admin_url('category'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="quick-stats-projects col-xs-12 col-md-6 col-sm-6 col-lg-3">
            <div class="top_stats_wrapper thirdbox_ dashboardBox">
                <div class="pull-right"><i class="hidden-sm <?= $box_result[6]->icon; ?> fa-4x" style="color: <?= $box_result[6]->icon_color; ?>;"></i></div>
                <p class="text-uppercase mtop5"></p>
                <h2><a href="<?= admin_url('subCategory'); ?>"><?= $this->db->get_where('tblcategory', array('parent_id >' => 0))->num_rows(); ?></a></h2>
                <p></p>
                <p>
                    Total Sub Category
                </p>
                <div class="clearfix"></div>
                <a href="<?= admin_url('subCategory'); ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-md-3">         
          <div class="panel_s">
            <div class="panel-body padding-10">
              <div class="widget-dragger"></div>
              <p class="padding-5"><?php echo _l('Top Reward Users'); ?>
                <span class="pull-right"><a href="<?= admin_url('distributors'); ?>">View All</a></span>
              </p>
              <hr class="hr-panel-heading-dashboard">   
              <ul class="list-unstyled todo unfinished-todos todos-sortable sortable">
                <?php
                /*
                    $userlistsr = $this->db->select('id,distributor_name,distributor_email')->limit(5)->order_by('id','desc')->get_where(db_prefix().'distributors', array('status' => 1))->result();
                    if(count($userlistsr)>0)
                    {
                        foreach($userlistsr as $rrr)
                        {
                            ?>
                                <li class="media event">
                                  <div class="media-body">
                                    <a class="title" href="<?= admin_url('distributors/add/'.$rrr->id); ?>">
                                      <strong><?= $rrr->distributor_name; ?></strong>
                                      <span class="pull-right">More info <i class="fa fa-arrow-circle-right"></i></span>
                                    </a>
                                    <p>
                                        <?= $rrr->distributor_email; ?>
                                    </p>
                                  </div>
                                </li>
                            <?php
                        }              
                    }
                    else
                    { 
                        ?>   
                            <li class="media event dataTables_empty">No records found</li>
                        <?php 
                    }
                    */
                ?>
                <li class="media event dataTables_empty">No records found</li>
              </ul>
            </div>
          </div>  
        </div> 
    </div> -->
</div>
