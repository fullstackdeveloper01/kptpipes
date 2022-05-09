<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('donation/add/'.$article->id), array('id' => 'import_form'));  ?>
    					<div class="panel-body">
                           <h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
                           <div class="form-group">
                               <?= _l('Icon'); ?>
                               <input type="file" filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="donation">
                               <?php
                                    if(isset($article))
                                    {
                                        $filename = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => 'donation'))->row('file_name');
                                        echo '<img src="'.site_url('uploads/donation/'.$article->id.'/'. $filename).'" width="50" height="50" alt="">';
                                    }
                               ?>
                           </div>
    					   <div class="form-group">
    					       <?= _l('Title'); ?>
    					       <input type="text" name="title" value="<?= (isset($article))?$article->title:''; ?>" required class="form-control">
    					   </div>
                           <div class="form-group">
                                <?= _l('Price'); ?>
                                <?php
                                    $priceList = $this->db->get_where(db_prefix().'master_price')->result(); 
                                ?>
                                <select class="form-control selectpicker" name="donation_price[]" required multiple data-live-search="true">
                                    <?php
                                        $priceArr = [];
                                        if(isset($article))
                                            $priceArr = explode(',', $article->donation_price);
                                        if($priceList)
                                        {
                                            foreach($priceList as $res)
                                            {
                                                ?>
                                                    <option value="<?= $res->price; ?>" <?= (in_array($res->price, $priceArr))?"selected":""; ?>><?= $res->price; ?></option>
                                                <?php
                                            }                                                
                                        }
                                    ?>                                    
                                </select>
                           </div><hr>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Save</button>
    					       <?php
    					            if(isset($article))
    					            {
    					                echo '<a href="'.admin_url().'donation" class="btn btn-warning pull-right">Cancel</a>';
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
						<h4 class="customer-profile-group-heading"><?= _l($title.' List'); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('SN'),
							_l('Image'),
                            _l('Title'),
							_l('Price List'),
							_l('Status'),
							_l('options')
							),'donation'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-donation', window.location.href, [1], [1]);
		var sid = '<?= $article->id ?>';
		$(function(){
		    if(sid)
                appValidateForm($('#import_form'),{title:{required:true},donation:{extension: "png,jpg,jpeg,gif"}});
            else
                appValidateForm($('#import_form'),{title:{required:true},donation:{required:true,extension: "png,jpg,jpeg,gif"}});
        });     
	</script>
</body>
</html>
