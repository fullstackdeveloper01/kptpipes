<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<style type="text/css">
  input[type=checkbox], input[type=radio] {
    margin-top: -2px;
    height: 24px;
    line-height: normal;
    width: 24px;
    /* display: block; */
    /* float: left; */
    /* margin-top: -5px; */
    position: relative;
    top: 6px;
}
</style>
<div id="wrapper">
    <div class="content">
        <?php echo form_open_multipart($this->uri->uri_string(),array('id'=>'article-form')); ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel_s">
                       <div class="panel-body">
                          <h4 class="no-margin">
                             <?php echo $title; ?>
                          </h4>
                          <hr class="hr-panel-heading" />
                          <div class="clearfix"></div>
                          <div class="form-group">
                            <div class="row">
                                <div class="col-md-4">
                                    <label><?= _l('Message To'); ?></label>
                                    <?php
                                        $userlist = $this->db->select('email,firstname')->get_where(db_prefix().'contacts', array('active' => 1))->result();
                                    ?>
                                    <select class="selectpicker" id="messageto" multiple data-live-search="true" name="emails[]">
                                        <?php
                                            if($userlist)
                                            {
                                                foreach($userlist as $rrr){
                                                    ?>
                                                        <option value="<?= $rrr->email; ?>"><?= $rrr->firstname; ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <input type="checkbox" onclick="checkuncheckAll();" id="select-all" > &nbsp;&nbsp;<?= _l('Select All'); ?>                                    
                                </div>
                            </div>
                          </div>
                          <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <?= _l('Title'); ?>
                                        <input type="text" class="form-control" required name="title">
                                    </div>
                                    <div class="col-md-5">
                                        <?= _l('Attachment'); ?>
                                        <input type="file" class="form-control" name="attachment">
                                    </div>
                                </div>
                          </div>
                          <?php $contents = '';?>
                          <?php echo render_textarea('description','Description',$contents,array(),array(),'','tinymce tinymce-manual'); ?>
                       </div>
                    </div>
                </div>
                <div class="btn-bottom-toolbar btn-toolbar-container-out text-right">
                    <button type="submit" class="btn btn-info pull-right">Send</button>
                </div>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
<?php init_tail(); ?>
<script>
    $(function(){
        init_editor('#description', {append_plugins: 'stickytoolbar'});
        appValidateForm($('#article-form'),{subject:'required',articlegroup:'required'});
    });
    
    function checkuncheckAll()
    {
        if($('#select-all').prop('checked') === true){
            $("#messageto option").each(function()
            {
                $(this).prop('selected', true);
            });
        }else{
            $("#messageto option").each(function()
            {
                $(this).prop('selected', false);
            });
        }
        
        //$('#messageto').chosen().find('option').prop('selected', $(this).hasClass('select')).parent().trigger('chosen:updated');
            
    }
</script>
</body>
</html>
