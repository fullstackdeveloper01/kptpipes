<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<div class="col-md-4 hide">
				<div class="panel_s">
				    <?= form_open_multipart(admin_url('quiz/add'));  ?>
    					<div class="panel-body">
    					   <?php /* ?>
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
    					   <?php */ ?>
    					   <div class="form-group">
    					       <?= _l('Question'); ?>
    					       <!--<input type="text" class="form-control" required name="question">-->
    					       <textarea class="form-control" placeholder="Enter question here..." rows="5" name="question" required></textarea>
    					   </div>
    					   <div class="form-group">
    					       <?= _l('Options'); ?>
    					       <div class="field_wrapper">
    					       </div>
    					   </div>
    					   <div class="form-group">
    					        <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus" style="cursor:pointerr;"></i>Add Option</a><span class="pull-right">Required &nbsp;&nbsp;<input type="checkbox" name="required"></span>
    					   </div>
    					   <div class="form-group">
    					       <input type="text" class="hide" name="answer" id="answer">
    					       <button type="submit" class="btn btn-info">Save</button>
    					   </div>
    					</div>
    				</form>
    			</div>
			</div>
			<div class="col-md-12">
				<div class="panel_s">
					<div class="panel-body">
					    <div class="no-margin">
    					    <a href="<?php echo admin_url('quiz/add'); ?>" class="btn btn-info mright5 test pull-left display-block">
                                <?php echo _l('new '.$title); ?>
                            </a>
                        </div>
						<h4>&nbsp;</h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
							//_l('Category'),
							_l('Quiz'),
							_l('Options'),
							_l('Answer'),
							_l('Category'),
							_l('Gender'),
							_l('Weightage'),
                            _l('dosha'),
							_l('options')
							),'quiz'); 
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-quiz', window.location.href, [1], [1]);
	</script>
	<script type="text/javascript">
        $(document).ready(function(){
            var x = 1;
            var maxField = 5;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            //var fieldHTML = '<div><label><input type="radio" name="options" required onclick="selectAnswer('+x+')"/> &nbsp;<input type="text" required id="answerfield_'+x+'" name="options[]" value=""/>&nbsp;&nbsp;<i class="fa fa-times fa-1x remove_button" style="cursor:pointer;"></i></label></div>';
           //var x = 1;
            
            $(addButton).click(function(){
                var fieldHTML = '<div><label><input type="radio" name="option" id="selectoption_'+x+'" required onclick="selectAnswer('+x+')"/> &nbsp;<input type="text" required onkeyup="changetextval('+x+')" required id="answerfield_'+x+'" name="options[]"/>&nbsp;&nbsp;<i class="fa fa-times fa-1x remove_button" style="cursor:pointer;"></i></label></div>';
                if(x < maxField){ 
                    x++;
                    $(wrapper).append(fieldHTML);
                }
            });
            
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('label').remove();
                x--;
            });
        });
        
        // selectAnswer
        function selectAnswer(num)
        {
            var textval = $('#answerfield_'+num).val();
            if(textval != '')
            {
                $('#answer').val(textval);
            }
            else
            {
                alert('Please fill this text field');
                $('#answerfield_'+num).focus();
            }
        }
        
        // changetextval
        function changetextval(numb)
        {
            var check = $('#selectoption_'+numb).prop('checked');
            if(check == true)
            {
                selectAnswer(numb);
            }
        }
        
        // selcetCategory
        function selcetCategory(id)
        {
            if(id)
            {
                $('#sub_category_id').html('<option value="">Please waite...</option>');
    		    var str = "catid="+id+"&"+csrfData['token_name']+"="+csrfData['hash'];
    		    $.ajax({
    		        url: '<?= admin_url()?>quiz/selcetCategory',
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
    </script>
</body>
</html>
