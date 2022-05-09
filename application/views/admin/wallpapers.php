<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('wallpaper/add'));  ?>
    					<div class="panel-body">
    					   <div class="form-group">
    					       <?= _l('Gallery'); ?>
    					       <input type="file" required filesize="<?php echo file_upload_max_size(); ?>" class="form-control" name="gallery">
    					       <input type="text" class="hide" name="type" value="gallery">
    					   </div>
    					   <div class="form-group">
    					       <div class="row">
    					           <div class="col-md-8">
    					               <?= _l('Folder'); ?>
            					       <select name="folderid" id="folderid" required class="form-control">
            					       </select>
    					           </div>
    					           <div class="col-md-2"><br>
    					               <span class="btn btn-info" data-toggle="modal" data-target="#gallerymodel">Create </span>
    					           </div>
    					       </div>
    					   </div>
    					   <div class="form-group">
    					       <button type="submit" class="btn btn-info">Save</button>
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
							_l('Gallery'),
							_l('Folder Name'),
							_l('Date'),
							_l('options')
							),'wallpaper'); 
						?>
					</div>
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
          <h4 class="modal-title">Create New Folder</h4>
        </div>
        <div class="modal-body">
            <form id="folderform">
          <input type="text" class="form-control" onkeyup="removeError('foldername');" id="foldername">
          <p class="text-danger foldername"></p>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" onclick="createNewFolder()" class="btn btn-success">Create</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-wallpaper', window.location.href, [1], [1]);
		
		/* createNewFolder */
		function createNewFolder()
		{
		    var name = $('#foldername').val();
		    if(name)
		    {
		        var str = "name="+name+"&"+csrfData['token_name']+"="+csrfData['hash'];
    		    $.ajax({
    		        url: '<?= admin_url()?>wallpaper/createNewFolder',
    		        type: 'POST',
    		        data: str,
    		        datatype: 'json',
    		        cache: false,
    		        success: function(resp_){
    		            if(resp_ == 1)
    		            {
    		                $('.close').click();
    		                getFolderList();
    		                $("#folderform")[0].reset();
    		            }
    		            else if(resp_ == 2)
    		            {
    		                $('.foldername').text('Folder name is already exist!');
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
		
		function getFolderList()
        {
            var str = csrfData['token_name']+"="+csrfData['hash'];
		    $.ajax({
		        url: '<?= admin_url()?>wallpaper/getFolderList',
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
        getFolderList();
	</script>
</body>
</html>
