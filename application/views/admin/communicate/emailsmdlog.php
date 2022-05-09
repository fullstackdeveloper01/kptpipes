<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin">
                            <?php echo $title; ?>
                        </h4>
                        <hr class="hr-panel-heading" />
						<?php render_datatable(array(
							_l('Title'),
							_l('Message'),
							_l('Date'),
							_l('Type')
							),'emailsmslog'); 
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
	<script>
		initDataTable('.table-emailsmslog', window.location.href, [1], [1]);
	</script>
</body>
</html>
