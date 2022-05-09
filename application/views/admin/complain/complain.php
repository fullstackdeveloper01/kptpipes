<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
    				<div class="panel-body">
				    	<?= form_open_multipart(admin_url('complain/add/'.$article->id), array('id' => 'import_form'));  ?>
				    	<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
                           <div class="form-group">
                               <?= _l('Type'); ?>
                               <input type="text"class="form-control" placeholder="Enter Type" <?= (isset($article))?'disabled':''; ?>  value="<?= (isset($article))?$article->type:''; ?>">
                           </div>
    					   <div class="form-group">
    					       <?= _l('Name'); 
                                $type['type']=$article->type;
                                $response = databasetable($type);
                                $name = $this->db->get_where($response['table'],['id',$article->userid])->row($response['name']);
                               ?>
    					       <input type="text"class="form-control" placeholder="Enter Name" <?= (isset($article))?'disabled':''; ?>  value="<?= (isset($article))?$name:''; ?>">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Message'); ?>
                               <textarea class="form-control" placeholder="Enter Message" <?= (isset($article))?'disabled':''; ?> ><?= (isset($article))?$article->message:''; ?></textarea>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Reply'); ?>
    					       <textarea class="form-control" name="reply" required="" placeholder="Enter Reply"></textarea>
    					   </div>
    					   <div class="form-group"><hr>
    					       
    					       <?php
    					            if(isset($article))
    					            {
                                        echo '<button type="submit" class="btn btn-info" id="advertid" data-loading-text="'._l('wait_text').'">Save</button>';
    					                echo '<a href="'.admin_url().'advertisement" class="btn btn-warning pull-right">Cancel</a>';
    					            }
    					       ?>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
			<div class="col-md-8">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?> List</h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('S.No'),
							_l('User Name'),
							_l('Type'),
							_l('Message'),
							_l('Status'),
							_l('options')
							),'complain'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-complain', window.location.href, [1], [1],'', [0, 'desc']);
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{advertisement:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{advertisement:{required:true,extension: "png,jpg,jpeg,gif"}});
        });     

  //       $(document).ready(function(){
  //           $("#start_date").datepicker({
  //               minDate:0,
  //               dateFormat: 'yy-mm-dd',
  //               onSelect: function(selected) {
  //                 $("#end_date").datepicker("option","minDate", selected)
  //               }
  //           });
  //           $("#end_date").datepicker({ 
  //               minDate:0,
  //               dateFormat: 'yy-mm-dd',
  //               onSelect: function(selected) {
  //                  $("#start_date").datepicker("option","maxDate", selected)
  //               }
  //           });  
  //       });

  //       $("#advertid").click(function() {
		// 	setTimeout(function(){
  //               $("#advertid").removeAttr("disabled");
  //               $("#advertid").removeClass("disabled");
  //               $('#advertid').text('Save');
  //           }, 5000);
		// });
	</script>
</body>
</html>
