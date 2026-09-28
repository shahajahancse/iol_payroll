<div class="content">
<!-- Static navbar -->
  <div class="container-fluid">
    <!-- <div class="navbar-header"> -->
      <div class="col-md-6" style="padding: 7px;">
        <h3 style="color: white; background-color: #86df13; padding: 10px; border-radius: 5px;">Update Member</h3>
      </div>
    <!-- </div> -->
  </div><!--/.container-fluid -->

  <!-- <h3>Update Member</h3> -->
    <!-- Validation Errors -->
    <?php if(validation_errors()){ ?>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>

  <div style="padding-left: 20px; padding-top: 10px;">
    <form enctype="multipart/form-data" method="post" name="creatcompanyunit" action="<?php echo base_url('setting_con/update_member/').$row->id;?>">
      <div class="row">
        <div class="col-md-6">
          <input type="hidden" name="id"value="<?=$row->id?>" class="form-control">
          <div class="form-group">

            <label>User ID</label>
            <input type="text" name="id_number"value="<?=set_value('id_number',$row->id_number)?>" class="form-control">
            <?php echo form_error('id_number','<div class="text-danger">','</div>'); ?>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password"value="<?=set_value('password',$row->password)?>" class="form-control">
            <?php echo form_error('password','<div class="text-danger">','</div>'); ?>
          </div>

          <div class="form-group">
            <label>Level</label>
              <select name="level" id= "field-level" class="form-control chosen-select chzn-done" required>
                <?php if ($user_level == 'Unit') { ?>
                  <option value="Unit" selected>Unit</option>
                <?php } else { ?>
                  <option value="">Select level</option>
                  <option value="All">All</option>
                  <option value="Unit">Unit</option>
                <?php } ?>
              </select>
          </div>

          <div class="form-group">
            <label>Unit Name</label>
              <select name="unit_name" id= "field-unit_name" class="form-control">
                <option value="">Select Unit</option>
                <?php foreach ($pr_units as $r) { ?>
                  <option <?= ($row->unit_name == $r->unit_id)? 'selected':'' ?> value="<?= $r->unit_id ?>"> <?= $r->unit_name?> </option>
                <?php } ?>
              </select>
          </div>

          <div class="form-group">
            <label>Buyer Mood</label>
              <select name="user_mode" id= "field-mode" class="form-control">
                <option value="">select buyer mood</option>
                <option <?= ($row->user_mode == '0')? 'selected':'' ?> value="0">All</option>
                <option <?= ($row->user_mode == '1')? 'selected':'' ?> value="1">7pm</option>
                <option <?= ($row->user_mode == '2')? 'selected':'' ?> value="2">9pm</option>
                <option <?= ($row->user_mode == '3')? 'selected':'' ?> value="3">12pm</option>
              </select>
          </div>

          <div class="form-group">
            <label>Status</label>
              <select name="status" id= "field-status" class="form-control">
                <option value="">select status</option>
                <option <?= ($row->status == 'Enable')? 'selected':'' ?> value="Enable">Enable</option>
                <option <?= ($row->status == 'Disable')? 'selected':'' ?> value="Disable">Disable</option>
              </select>
          </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-6">
          <div class="form-group">
            <button class="btn btn-primary">Update</button>
            <a href="<?=base_url('setting_con/acl')?>" class="btn btn-warning">Cancel</a>
          </div>
        </div>

      </div>
    </form>
  </div>

</div>
