<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
	<div class="content">
		<div class="row">
			<?= $this->load->view('admin/mobileApp/sidebar'); ?>
			<div class="col-md-9">
				<div class="panel_s">
					<div class="panel-body">
					    <?= form_open_multipart(admin_url('mobileApp/add'));  ?>
    					    <div class="row">
    					        <?php
    					            if($mobileapp_result->splash_screen != '')
    					            {
    					                ?>
    					                    <div class="col-md-9">
                                                <img src="<?= base_url('uploads/mobileApp/'.$mobileapp_result->splash_screen); ?>" class="img img-responsive" />
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <a href="<?= admin_url('mobileApp/removeSplash/'.$mobileapp_result->splash_screen);?>" data-toggle="tooltip" title="Remove splash screen" class="_delete text-danger"><i class="fa fa-remove"></i></a>
                                            </div>
    					                <?php
    					            }
    					            else
    					            {
    					                ?>
    					                    <div class="col-md-9">
                                                <input type="file" class="form-control" name="splash_screen" />
                                            </div>
                                            <div class="col-md-3 text-right">
                                                <button type="submit" class="btn btn-info">Submit</button>
                                            </div>
    					                <?php
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
