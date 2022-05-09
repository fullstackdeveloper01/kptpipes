<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-12">
    			<div class="panel_s">
				    <?= form_open_multipart(admin_url('listen/add/'.$article->id));  ?>
    					<div class="panel-body">
    					    <div class="row">
    					        <div class="col-md-3 form-group">
        					       <?= _l('Category'); ?>
        					       <select class="form-control" name="category_id" onchange="selcetCategory(this.value)" required>
        					           <option value=""></option>
        					           <?php 
        					                $subcategory_result = $this->db->get_where(db_prefix().'category', array('parent_id' => $article->category_id))->result();
        					                if($category_result)
        					                {
        					                    foreach($category_result as $res)
        					                    {
        					                        ?>
        					                            <option value="<?= $res->id; ?>" <?= ($article->category_id == $res->id)?"selected":"";?>><?= $res->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        				    
        					   <div class="col-md-3 form-group">
        					       <?= _l('Sub Category'); ?>
        					       <select class="form-control" name="sub_category_id" id="sub_category_id">
        					           <option value=""></option>
        					           <?php
        					                if($subcategory_result)
        					                {
        					                    foreach($subcategory_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" <?= ($article->sub_category_id == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
    					        <div class="col-md-3 form-group">
        					       <?= _l('Phrases'); ?>
        					       <select class="form-control" name="phrasesID" onchange="selcetPhrases(this.value)" required>
        					           <option value=""></option>
        					           <?php 
        					                $subphrases_result = $this->db->get_where(db_prefix().'essential_phrases', array('parent_id' => $article->phrasesID))->result();
        					                if($phrases_result)
        					                {
        					                    foreach($phrases_result as $res)
        					                    {
        					                        ?>
        					                            <option value="<?= $res->id; ?>" <?= ($article->phrasesID == $res->id)?"selected":"";?>><?= $res->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        				    
        					   <div class="col-md-3 form-group">
        					       <?= _l('Sub Phrases'); ?>
        					       <select class="form-control" name="subPhrasesID" id="subPhrasesID">
        					           <option value=""></option>
        					           <?php
        					                if($subphrases_result)
        					                {
        					                    foreach($subphrases_result as $rrr)
        					                    {
        					                        ?>
        					                            <option value="<?= $rrr->id; ?>" <?= ($article->subPhrasesID == $rrr->id)?"selected":"";?>><?= $rrr->name; ?></option>
        					                        <?php
        					                    }
        					                }
        					           ?>
        					       </select>
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?= _l('Name'); ?>
        					       <select class="form-control" name="user_id">
        					           <option value=""></option>
            					       <?php
            					            foreach($userlist as $rrr)
            					            {
            					                ?>
            					                    <option value="<?= $rrr->id; ?>" <?= ($article->user_id == $rrr->id)?"selected":""; ?>><?= $rrr->name; ?></option>
            					                <?php
            					            }
            					       ?>
        					       </select>
        					   </div>
    					    </div>
    					    <!--
    					    <div class="row form-group">
        					   <div class="col-md-3 form-group">
        					       <?= _l('User 1 MP3 audio file'); ?>
        					       <input type="file" class="form-control" name="listenuser1">
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?php $audioArray1 = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "listenuser1"))->row(); ?>
        					        <audio controls>
                                        <source src="<?= site_url('download/file/taskattachment/'. $audioArray1->attachment_key); ?>" type="audio/mpeg">
                                    </audio>
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?= _l('User 2 MP3 audio file'); ?>
        					       <input type="file" class="form-control" name="listenuser2">
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?php $audioArray2 = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "listenuser2"))->row(); ?>
        					        <audio controls>
                                        <source src="<?= site_url('download/file/taskattachment/'. $audioArray2->attachment_key); ?>" type="audio/mpeg">
                                    </audio>
        					   </div>
        					 </div>
        					 -->
    					    <div class="row form-group">
        					   <div class="col-md-3 form-group">
        					       <?= _l('MP3 audio file'); ?>
        					       <input type="file" class="form-control" name="listenfile">
        					   </div>
        					   <div class="col-md-3 form-group">
        					       <?php $audioArray = $this->db->get_where(db_prefix().'files', array('rel_id' => $article->id, 'rel_type' => "listenfile"))->row(); ?>
        					        <audio controls>
                                        <source src="<?= site_url('download/file/taskattachment/'. $audioArray->attachment_key); ?>" type="audio/mpeg">
                                    </audio>
        					   </div>
        					 </div>
        					 <div class="row form-group">
        					   <div class="col-md-12">
        					       <?= _l('Message'); ?>
        					       <!--<textarea name="message" required class="form-control" rows="15"><?= $article->message; ?></textarea>-->
        					       <?php $contents = ''; if(isset($article)){$contents = $article->message;} ?>
						        <?php echo render_textarea('message','',$contents,array(),array(),'','tinymce'); ?>
        					   </div>
        					 </div>
    					   <div class="row form-group">
    					        <div class="col-md-6">
    					            <p>Multi-language</p>
    					        </div>
    					   </div>
    					   <div class="row">
        					   <?php
        					        if($language_result)
        					        {
        					            foreach($language_result as $rrr)
        					            {
        					                $msg = $this->db->get_where(db_prefix().'listen_translate', array('listen_id' => $article->id, 'language_id' => $rrr->id))->row('message');
        					                ?>
        					                    <div class="form-group col-md-6">
                        					        <?= _l($rrr->name); ?>
                        					        <input type="text" class="hide" value="<?= $rrr->id; ?>" name="language_<?= $rrr->id; ?>">
                        					        <textarea id="message_<?= $rrr->id; ?>" name="message_<?= $rrr->id; ?>" class="form-control tinymce" rows="4" aria-hidden="true"><?= $msg; ?></textarea>
                        					    </div>
        					                <?php
        					                $msg = '';
        					            }
        					        }
        					   ?>
        					</div>
        					<div class="row form-group">
        					   <div class="col-md-6">
        					       <button type="submit" class="btn btn-info">Update</button>
        					   </div>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
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
