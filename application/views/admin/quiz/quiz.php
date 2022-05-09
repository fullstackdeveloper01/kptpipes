<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
		    <?php
		        if($article)
		        {
		            ?>
		                <div class="col-md-12">
            				<div class="panel_s">
            				    <?= form_open_multipart(admin_url('quiz/add/'.$article->id)); ?>
                					<div class="panel-body">
                					   <div class="form-group">
                					       <?= _l('Question'); ?>
                					       <textarea class="form-control" rows="5" name="question" required><?= $article->question; ?></textarea>
                					   </div>
                					   <div class="form-group">
                					       <?= _l('Options'); ?>
                					       <div class="field_wrapper">
                					           <?php
                					                $options_str = json_decode($article->options);
                					                $options_array = explode(',',$options_str);
                					                if($options_str)
                					                {
                					                    $ansarr = explode(',', $article->answer);
                					                    $ii = 1;
                					                    foreach($options_str as $rr)
                					                    {
                					                        ?>
                					                            <div>
                					                                <label>
                					                                   <input type="checkbox" name="answer[]" value="<?= $rr; ?>" id="selectoption_<?= $ii; ?>" <?= (in_array($rr, $ansarr))?"checked":"";?> /> &nbsp;
                					                                   <input type="text" onkeyup="changetextval(<?= $ii; ?>)" required id="answerfield_<?= $ii; ?>" name="options[]" value="<?= $rr; ?>"/>&nbsp;&nbsp;
                                                                   <?php } ?>
                                                                   <?php 

                                                                   $options_do = json_decode($article->dosha);
                                                                   foreach($options_do as $rrD)
                                                                    {

                                                                    ?>
                                                                       <input type="text"  required  name="dosha[]" value="<?= $rrD; ?>" />&nbsp;&nbsp;
                                                                    <?php 
                                                                    }
                                                                    $options_w = json_decode($article->weightage);
                                                                    foreach($options_w as $rrw)
                                                                    {

                                                                     ?>
                                                                       <input type="text"  required  name="weightage[]"  value="<?= $rrw; ?>" />&nbsp;&nbsp;
                					                                   <i class="fa fa-times fa-1x remove_button" style="cursor:pointer;"></i>
                					                               </label>
                					                           </div>
                					                        <?php
                                                                    }
                					                        $ii++;
                					                    
                					                }
                					           ?>
                					       </div>
                					   </div>
                					   <div class="form-group">
                					        <a href="javascript:void(0);" class="add_button">
                					            <i class="fa fa-plus" style="cursor:pointerr;"></i>Add Option
                					        </a>
                					        <span class="pull-right hide">Required &nbsp;&nbsp;<input type="checkbox" <?= ('Yes' == $article->required)?"checked":"";?> name="required"></span>
                					   </div>
                					   <div class="form-group">
                					       <div class="row">
            					               <div class="col-md-3">
            					                   <?= _l('Category'); ?><br>
            					                   <?php
            					                        $cateArr = explode(',', $article->category);
            					                   ?>
            					                   <input type="checkbox" <?= (in_array('Infant', $cateArr))?"checked":""; ?> name="category[]" value="Infant"><?= _l('Infant'); ?>&nbsp;&nbsp;&nbsp; 
            					                   <input type="checkbox" <?= (in_array('Child', $cateArr))?"checked":""; ?> name="category[]" value="Child"><?= _l('Child'); ?>&nbsp;&nbsp;&nbsp; 
            					                   <input type="checkbox" <?= (in_array('Adult',$cateArr))?"checked":""; ?> name="category[]" value="Adult"><?= _l('Adult'); ?>&nbsp;&nbsp;&nbsp; 
            					                   <input type="checkbox" <?= (in_array('Old', $cateArr))?"checked":""; ?> name="category[]" value="Old"><?= _l('Old'); ?>
            					                   <!--
            					                   <select required class="form-control" name="category">
            					                       <option value=""></option>
            					                       <option value="Infant" <?= ($article->category == 'Infant')?"selected":""; ?>><?= _l('Infant'); ?></option>
            					                       <option value="Child" <?= ($article->category == 'Child')?"selected":""; ?>><?= _l('Child'); ?></option>
            					                       <option value="Adult" <?= ($article->category == 'Adult')?"selected":""; ?>><?= _l('Adult'); ?></option>
            					                       <option value="Old" <?= ($article->category == 'Old')?"selected":""; ?>><?= _l('Old'); ?></option>
            					                   </select>
            					                   -->
            					               </div>
            					               <div class="col-md-3">
            					                   <?= _l('Gender'); ?><br>
            					                   <input type="radio" name="gender" <?= ($article->gender == 'Male')?"checked":""; ?> value="Male"> Male&nbsp;&nbsp;&nbsp; 
            					                   <input type="radio" name="gender" <?= ($article->gender == 'Female')?"checked":""; ?> value="Female"> Female&nbsp;&nbsp;&nbsp; 
            					                   <input type="radio" name="gender" <?= ($article->gender == 'Both')?"checked":""; ?> value="Both"> Both
            					               </div>
            					               <!-- <div class="col-md-3">
            					                   <?= _l('Weightage'); ?>
            					                   <input type="number" class="form-control" value="<?= $article->weightage; ?>" name="weightage">
            					               </div> -->
            					           </div>
                					    </div>
                					   <div class="form-group">
                					       <!--<input type="text" class="hide" name="answer" value="<?= $article->answer; ?>" id="answer">-->
                					       <button type="submit"name="update" value="Update" class="btn btn-info">Update</button>
                					   </div>
                					</div>
                				</form>
                			</div>
            			</div>
		            <?php
		        }
		        else
		        {
		            ?>
		                 <div class="col-md-12">
            				<div class="panel_s">
            				    <?= form_open_multipart(admin_url('quiz/add')); ?>
                					<div class="panel-body">
                					   <div class="form-group">
                					       <?= _l('Question'); ?>
                					       <textarea class="form-control" rows="5" name="question" required></textarea>
                					   </div>
                					   <div class="form-group">
                					       <?= _l('Options'); ?>
                					       <div class="field_wrapper">
                					           
                					       </div>
                					   </div>
                					   <div class="form-group">
                					       <a href="javascript:void(0);" class="add_button"><i class="fa fa-plus" style="cursor:pointerr;"></i>Add Option</a><span class="pull-right hide">Required &nbsp;&nbsp;<input type="checkbox" <?= ('Yes' == $article->required)?"checked":"";?> name="required"></span>
                					   </div>
                					   <div class="form-group">
                					       <div class="row">
            					               <div class="col-md-3">
            					                   <?= _l('Category'); ?><br>
            					                   <input type="checkbox" name="category[]" value="Infant"><?= _l('Infant'); ?>&nbsp;&nbsp;&nbsp; 
            					                   <input type="checkbox" name="category[]" value="Child"><?= _l('Child'); ?>&nbsp;&nbsp;&nbsp; 
            					                   <input type="checkbox" name="category[]" value="Adult"><?= _l('Adult'); ?>&nbsp;&nbsp;&nbsp; 
            					                   <input type="checkbox" name="category[]" value="Old"><?= _l('Old'); ?>
            					               </div>
            					               <div class="col-md-3">
            					                   <?= _l('Gender'); ?><br>
            					                   <input type="radio" name="gender" checked value="Male"> Male&nbsp;&nbsp;&nbsp; 
            					                   <input type="radio" name="gender" value="Female"> Female&nbsp;&nbsp;&nbsp; 
            					                   <input type="radio" name="gender" value="Both"> Both Male And Female
            					               </div>
            					              <!--  <div class="col-md-3">
            					                   <?= _l('Weightage'); ?>
            					                   <input type="number" class="form-control" name="weightage">
            					               </div> -->
            					           </div>
                					    </div>
                					    <div class="form-group">
                					       <!--<input type="text" class="hide" name="answer" value="<?= $article->answer; ?>" id="answer">-->
                					       <button type="submit"name="update" value="Update" class="btn btn-info">Save</button>
                					    </div>
                					</div>
                				</form>
                			</div>
            			</div>
		            <?php
		        }
		    ?>
            			
			<div class="col-md-8 hide">
				<div class="panel_s">
					<div class="panel-body">
						<h4 class="customer-profile-group-heading"><?= _l($title); ?></h4>
						<hr class="hr-panel-heading" />
						<?php render_datatable(array(
						//	_l('Category'),
							_l('Quiz'),
							_l('Options'),
							_l('Answer'),
                            _l('Dosha'),
                            _l('Weightage'),
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
            var x = '<?= count(json_decode($article->options)); ?>';
            var maxField = 5;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            //var fieldHTML = '<div><label><input type="radio" name="options" required onclick="selectAnswer('+x+')"/> &nbsp;<input type="text" required id="answerfield_'+x+'" name="options[]" value=""/>&nbsp;&nbsp;<i class="fa fa-times fa-1x remove_button" style="cursor:pointer;"></i></label></div>';
           //var x = 1;
            
            $(addButton).click(function(){
                var fieldHTML = '<div><label><input type="checkbox" name="answer[]" id="selectoption_'+x+'" /> &nbsp;<input type="text" onkeyup="changetextval('+x+')" required id="answerfield_'+x+'" name="options[]" value=""/>&nbsp;&nbsp;<input type="text"  required  name="dosha[]" value=""/>&nbsp;&nbsp;<input type="text"  required  name="weightage[]" value=""/>&nbsp;&nbsp;<i class="fa fa-times fa-1x remove_button" style="cursor:pointer;"></i></label></div>';
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
            /*
            var check = $('#selectoption_'+numb).prop('checked');
            if(check == true)
            {
                selectAnswer(numb);
            }
            */
            var txt = $('#answerfield_'+numb).val();
            $('#selectoption_'+numb).val(txt);
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
