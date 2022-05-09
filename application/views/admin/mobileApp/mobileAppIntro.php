<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?= $this->load->view('admin/mobileApp/sidebar'); ?>
			<div class="col-md-9">
				<div class="panel_s">
					<div class="panel-body">
					    <?= form_open_multipart(admin_url('mobileApp/introAdd'));  ?>
    					    <div class="row">
    					        <div class="col-md-4">
                                    <input type="text" placeholder="Enter Title" class="form-control" name="intro_text" />
                                </div>
    					        <div class="col-md-4">
                                    <input type="file" class="form-control" name="intro_img" />
                                </div>
                                <div class="col-md-3 text-right">
                                    <button type="submit" class="btn btn-info">Submit</button>
                                </div>
    					    </div><hr />
    					    <div class="row">
    					        <?php
    					            if($mobileapp_result->intro_img != '')
    					            {
    					                $ii = 0;
    					                $textarr = explode(',',$mobileapp_result->intro_text);
    					                $imgarr = explode(',',$mobileapp_result->intro_img);
    					                foreach($imgarr as $rr)
    					                {
    					                    if($rr)
    					                    {
    					                        ?>
            					                    <div class="col-md-4">
                                                        <img src="<?= base_url('uploads/mobileApp/'.$rr); ?>" height="100px"/>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <?= str_replace('_',' ',$textarr[$ii]); ?>
                                                    </div>
                                                    <div class="col-md-3 text-right">
                                                        <a href="<?= admin_url('mobileApp/removeIntro/'.$rr.'/'.$mobileapp_result->id);?>" data-toggle="tooltip" title="Remove intro image" class="_delete text-danger"><i class="fa fa-remove"></i></a>
                                                    </div>
                                                    <div class="col-md-12"><hr></div>
            					                <?php
    					                    }
    					                    $ii++;
    					                }
    					            }
    					        ?>
                            </div>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php init_tail(); ?>
</body>
</html>
