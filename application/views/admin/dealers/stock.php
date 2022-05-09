<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-body">
              <div class="no-margin">
              </div>
              <h4><?php echo _l('Dealers Stock List'); ?></h4>
                
              <hr class="hr-panel-heading" />
              <?php render_datatable(array(
                _l('S.no'),
                _l('Name'),
                _l('Type'),
                _l('Product'),
                _l('Bach-No'),
                _l('quantity')
                ),'dealers-stock'); 
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
  <script>
    initDataTable('.table-dealers-stock', window.location.href, [1], [1], '', [0, 'desc']);
  </script>
</body>
</html>
