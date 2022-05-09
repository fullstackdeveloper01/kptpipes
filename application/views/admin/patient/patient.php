<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
    				    <?= form_open_multipart(admin_url('patient/add/'.$article->id), array('id' => 'patientForm'));  ?>
        					<div class="row">
    					       <div class="col-md-6 form-group">
        					       <?= _l('Name'); ?><span class="text-danger">*</span>
        					       <input type="text" class="form-control" name="name" required value="<?= (isset($article)?$article->name:""); ?>">
        					   </div>
        					   <div class="col-md-6 form-group">
        					       <?= _l('Mobile'); ?><span class="text-danger">*</span>
        					       <input type="text" class="form-control" minlength="10" required maxlength="10" name="mobile" value="<?= (isset($article)?$article->mobile:""); ?>">
        					   </div> 
    					    </div>
    					    <div class="row">
    					        <div class="col-md-6 form-group">
        					       <?= _l('Address'); ?>
        					       <input type="text" class="form-control" maxlength="25" name="address" value="<?= (isset($article)?$article->address:""); ?>">
        					   </div>
        					   <div class="col-md-6 form-group">
        					       <div class="row">
        					           <div class="col-md-9">
        					               <?= _l('Type'); ?><span class="text-danger">*</span>
                					       <select name="type" id="folderid" required class="form-control">
                					       </select>
        					           </div>
        					           <div class="col-md-1"><br>
        					               <span class="btn btn-info" data-toggle="modal" data-target="#gallerymodel">Create</span>
        					           </div>
        					       </div>
        					   </div>
    					    </div>
    					    <hr class="hr-panel-heading" />
    					    <div class="row">
        					   <div class="col-md-6 form-group">
        					       <button type="submit" class="btn btn-success">Save</button>
        					       <a href="<?= admin_url('patient')?>" class="btn btn-warning">Cancel</a>
        					   </div>
        				    </div>
        				</form>
        			</div>
    			</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="gallerymodel" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Create New Type</h4>
            </div>
            <div class="modal-body">
                <form id="folderform">
              <input type="text" class="form-control" onkeyup="removeError('foldername');" id="foldername">
              <p class="text-danger foldername"></p>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" onclick="createNewType()" class="btn btn-success">Create</button>
            </div>
          </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
    <script>
		initDataTable('.table-patient', window.location.href, [1], [1]);
		
		/* createNewType */
		function createNewType()
		{
		    var name = $('#foldername').val();
		    if(name)
		    {
		        var str = "name="+name+"&"+csrfData['token_name']+"="+csrfData['hash'];
    		    $.ajax({
    		        url: '<?= admin_url()?>patient/createNewType',
    		        type: 'POST',
    		        data: str,
    		        datatype: 'json',
    		        cache: false,
    		        success: function(resp_){
    		            if(resp_ == 1)
    		            {
    		                $('.close').click();
    		                getTypeList();
    		                $("#folderform")[0].reset();
    		            }
    		            else if(resp_ == 2)
    		            {
    		                $('.foldername').text('Type is already exist!');
    		                return false;
    		            }
    		        }
    		    });
		    }
		    else
		    {
		        $('.foldername').text('Folder name is required!');
    		    return false;
		    }
		}
		
		function removeError(name)
		{
		    $('.'+name).text('');
		}
		
		function getTypeList()
        {
            var str = csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>patient/getTypeList',
		        type: 'POST',
		        data: str,
		        datatype: 'json',
		        cache: false,
		        success: function(resp_){
		            if(resp_)
		            {
		                var selectoptio = '<?= $article->type ?>';
		                var resp = JSON.parse(resp_);
		                var res = '<option value=""></option>';
		                for(var i=0; i<resp.length; i++)
		                {
		                    if(selectoptio == resp[i].id)
		                    {
		                        res += '<option value="'+resp[i].id+'" selected>'+resp[i].name+'</option>';
		                    }
		                    else
		                    {
		                        res += '<option value="'+resp[i].id+'">'+resp[i].name+'</option>';   
		                    }
		                }
		                $('#folderid').html(res);
		            }
		            else
		            {
		                $('#folderid').html('<option value=""></option>');
		            }
		        }
		    });
        }
        //setInterval(function(){ getFolderList(); }, 2000);
        getTypeList();
	</script>
	<script>
        $(function(){
            appValidateForm($('#patientForm'),{name:'required',mobile:'required',type:'required'});
        });
	</script>
</body>
</html>
