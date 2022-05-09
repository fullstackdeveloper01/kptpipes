<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
	    <div class="row hide">
			<div class="col-md-12">
				<div class="panel_s">
    				<div class="panel-body">
    					<?= form_open_multipart(admin_url('listen/addaudiofile'));  ?> 
    					<?php
    					    $userlist = $this->db->get_where(db_prefix().'listen_name')->result(); 
    					    ?>
    					    <h4 class="customer-profile-group-heading"><?= _l('Name and audio file'); ?></h4>
						    <hr class="hr-panel-heading" />
    					    <div class="row form-group">
        					    <div class="col-md-3">
        					       <?= _l('User 1'); ?>
        					       <input type="text" class="form-control" value="<?= $userlist[0]->name; ?>" required name="name1">
        					    </div>
        					    <div class="col-md-3">
        					       <?= _l('User 2'); ?>
        					       <input type="text" class="form-control" value="<?= $userlist[1]->name; ?>" required name="name2">
        					    </div>
        					    <div class="col-md-3">
        					        <?= _l('MP3 audio file'); ?>
        					        <?php $audioArray = $this->db->get_where(db_prefix().'files', array('rel_id' => 1, 'rel_type' => "listenfile"))->row(); ?>
        					        <audio controls>
                                        <source src="<?= site_url('download/file/taskattachment/'. $audioArray->attachment_key); ?>" type="audio/mpeg">
                                    </audio>
        					        <input type="file" class="form-control" name="listenfile">
        					    </div>
        					    <div class="col-md-3"><br/>
        					        <button type="submit" class="btn btn-info">Save</button>
        					    </div>
    					    </div>
    				    </form>
    				</div>
    			</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('listen/add'));  ?>
    					<div class="panel-body">
    					    <div class="form-group">
    					       <?= _l('Category'); ?>
    					       <select class="form-control" name="category_id" onchange="selcetCategory(this.value)" required>
    					           <option value=""></option>
    					           <?php 
    					                if($category_result)
    					                {
    					                    foreach($category_result as $res)
    					                    {
    					                        ?>
    					                            <option value="<?= $res->id; ?>"><?= $res->name; ?></option>
    					                        <?php
    					                    }
    					                }
    					           ?>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Sub Category'); ?>
    					       <select class="form-control" name="sub_category_id" id="sub_category_id">
    					           <option value=""></option>
    					       </select>
    					   </div>
    					    <div class="form-group">
    					       <?= _l('Phrases'); ?>
    					       <select class="form-control" name="phrasesID" onchange="selcetPhrases(this.value)" required>
    					           <option value=""></option>
    					           <?php 
    					                if($phrases_result)
    					                {
    					                    foreach($phrases_result as $res)
    					                    {
    					                        ?>
    					                            <option value="<?= $res->id; ?>"><?= $res->name; ?></option>
    					                        <?php
    					                    }
    					                }
    					           ?>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Sub Phrases'); ?>
    					       <select class="form-control" name="subPhrasesID" id="subPhrasesID">
    					           <option value=""></option>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Name'); ?>
    					       <select class="form-control" required name="user_id">
    					           <option value=""></option>
        					       <?php
        					            foreach($userlist as $rrr)
        					            {
        					                ?>
        					                    <option value="<?= $rrr->id; ?>"><?= $rrr->name; ?></option>
        					                <?php
        					            }
        					       ?>
    					       </select>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Message'); ?>
    					       <!--<textarea name="message" required class="form-control" rows="15"></textarea>-->
    					        <?php $contents = ''; if(isset($announcement)){$contents = $announcement->message;} ?>
						        <?php echo render_textarea('message','',$contents,array(),array(),'','tinymce'); ?>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('MP3 audio file'); ?>
    					       <input type="file" class="form-control" required name="listenfile">
    					   </div><hr>
    					   <div class="form-group">
    					       <p>Multi-language</p>
    					   </div>
    					   
    					   <?php
    					        if($language_result)
    					        {
    					            foreach($language_result as $rrr)
    					            {
    					                ?>
    					                    <div class="form-group">
                    					        <?= _l($rrr->name); ?>
                    					        <input type="text" class="hide" value="<?= $rrr->id; ?>" name="language_<?= $rrr->id; ?>">
                    					        <textarea id="message_<?= $rrr->id; ?>" name="message_<?= $rrr->id; ?>" class="form-control tinymce" rows="4" aria-hidden="true"></textarea>
                    					    </div>
    					                <?php
    					            }
    					        }
    					   ?>
    					   <!--
    					   <div class="form-group">
    					       <?= _l('User 1 MP3 audio file'); ?>
    					       <input type="file" class="form-control" required name="listenuser1">
    					   </div>
    					   <div class="form-group">
    					       <?= _l('User 2 MP3 audio file'); ?>
    					       <input type="file" class="form-control" required name="listenuser2">
    					   </div>
    					   -->
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Save</button>
    					   </div><hr>
    					   <div class="form-group">
    					       <p><b>Reference Link</b>: <a href="https://www.text2speech.org/" target="_blank">Text-to-speech converter</a></p>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
			<div class="col-md-8">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Category'),
							_l('Sub Category'),
							_l('User'),
							_l('Message'),
							_l('options')
							),'listen'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-listen', window.location.href, [1], [1]);
	</script>
	<script>
        // selcetCategory
        function selcetCategory(id)
        {
            if(id)
            {
                $('#sub_category_id').html('<option value="">Please waite...</option>');
    		    var str = "catid="+id+"&"+csrfData['token_name']+"="+csrfData['hash'];
    		    $.ajax({
    		        url: '<?= admin_url()?>listen/selcetCategory',
    		        type: 'POST',
    		        data: str,
    		        datatype: 'json',
    		        cache: false,
    		        success: function(resp_){
    		            if(resp_)
    		            {
    		                var resp = JSON.parse(resp_);
    		                var res = '<option value=""></option>';
    		                for(var i=0; i<resp.length; i++)
    		                {
    		                   res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
    		                }
    		                $('#sub_category_id').html(res);
    		            }
    		            else
    		            {
    		                $('#sub_category_id').html('<option value=""></option>');
    		            }
    		        }
    		    });
            }
            else
            {
                $('#sub_category_id').html('<option value=""></option>');
            }
        }
        
        // selcetPhrases
        function selcetPhrases(id)
        {
            if(id)
            {
                $('#subPhrasesID').html('<option value="">Please waite...</option>');
    		    var str = "catid="+id+"&"+csrfData['token_name']+"="+csrfData['hash'];
    		    $.ajax({
    		        url: '<?= admin_url()?>listen/selcetPhrases',
    		        type: 'POST',
    		        data: str,
    		        datatype: 'json',
    		        cache: false,
    		        success: function(resp_){
    		            if(resp_)
    		            {
    		                var resp = JSON.parse(resp_);
    		                var res = '<option value=""></option>';
    		                for(var i=0; i<resp.length; i++)
    		                {
    		                   res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';
    		                }
    		                $('#subPhrasesID').html(res);
    		            }
    		            else
    		            {
    		                $('#subPhrasesID').html('<option value=""></option>');
    		            }
    		        }
    		    });
            }
            else
            {
                $('#subPhrasesID').html('<option value=""></option>');
            }
        }
    </script>
</body>
</html>
