<div class="content">
  <nav  class="navbar navbar-inverse bg_none">
    <div class="container-fluid nav_head">
      <div class="navbar-header col-md-5" style="padding: 7px;">
          <div>
          <a href="<?=base_url('entry_system_con/tax_others_deduction')?>" class="btn btn-info" role="button">Back</a>
          <a href="<?php echo base_url('payroll_con')?>" class="btn btn-primary">Home</a>
          </div>
      </div>
    </div>
  </nav>

  <div class="row">
    <div class="col-md-12">
      <?php
        $success = $this->session->flashdata('success');
        if ($success != "") { ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
      <?php }
        $failuer = $this->session->flashdata('failuer');
        if ($failuer) { ?>
        <div class="alert alert-failuer"><?php echo $failuer; ?></div>
      <?php } ?>
    </div>
  </div>
  <div class="tablebox">
    <h4 ><b>Create Tax & Other Deduct </b></h4>
    <form enctype="multipart/form-data" method="post" name="creattaxnother" action="<?php echo base_url().'crud_con/taxnother_add'?>">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <select name="unit" id= "unit" class="form-control input-lg">
              <option value="">Select Unit</option>
              <?php
                foreach ($taxnother as $row)
                {
                  echo '<option value="'.$row['unit_id'].'">'.$row['unit_name'].
                  '</option>';
                }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label>EMP ID</label>
            <input type="text" name="empid"value="" class="form-control">
            <?php echo form_error('empid');?>
          </div>

          <div class="form-group">
            <label>Tax</label>
            <input type="text" name="tax"value="" class="form-control">
            <?php echo form_error('tax');?>
          </div>

          <div class="form-group">
            <label>Other</label>
            <input type="text" name="other"value="" class="form-control">
            <?php echo form_error('other');?>
          </div>

          <div class="form-group">
            <label>Month</label>
            <input type="text" class="form-control date" name="date_out" value="<?php echo isset($itemOutData->date_out) ? set_value('date_out', date('Y-m-d', strtotime($itemOutData->date_out))) : set_value('date_out'); ?>">
          </div>
          <br>
          <div class="form-group">
            <button class="btn btn-primary">Create</button>
            <a href=""class="btn-warning btn">Cancel</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>