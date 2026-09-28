<!DOCTYPE html>
<html lang="en">
<head>
  <title>Department Edit</title>
  <meta charset="utf-8">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url('/assets/bootstrap/css/bootstrap.min.css') ?>">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="<?php echo base_url('/assets/bootstrap/js/bootstrap.js') ?>"></script>
</head>
<body>

<div class="container" style="padding-top: 10px;">
  <!-- Static navbar -->
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Update Member</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo base_url('payroll_con') ?>">Home</a></li>
            </ul>

          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

  <!-- <h3>Update Member</h3> -->
  <!-- <hr> -->

      <!-- Success Message -->
    <?php if($this->session->flashdata('success')){ ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php } ?>

    <!-- Validation Errors -->
    <?php if(validation_errors()){ ?>
        <div class="alert alert-danger">
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>

  <div style="padding-left: 20px; padding-top: 10px;">
    <form enctype="multipart/form-data" method="post" name="creatcompanyunit" action="<?php echo base_url().'setting_con/member_insert';?>">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>User ID</label>
            <input type="text" name="id_number" class="form-control" required>
            <?php echo form_error('id_number','<div class="text-danger">','</div>'); ?>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" required>
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
              <select name="unit_name" id= "field-unit_name" class="form-control" required>
                <option value="">Select Unit</option>
                <?php foreach ($pr_units as $row) {
                  if ($row->unit_id == $_SESSION['data']->unit_name) {
                    $select_data = "selected";
                  } else {
                    $select_data = "";
                  }
                  echo '<option ' . $select_data . '  value="' . $row->unit_id . '">' . $row->unit_name.'</option>';
                } ?>
              </select>
          </div>
          <div class="form-group">
            <label>Buyer Mood</label>
              <select name="user_mode" id= "field-mode" class="form-control" required>
                <option value="">Select Buyer Mood</option>
                <option value="0">All</option>
                <option value="1">7pm</option>
                <option value="2">9pm</option>
                <option value="3">12pm</option>
              </select>
          </div>
          <div class="form-group">
            <label>Status</label>
              <select name="status" id= "field-status" class="form-control" required>
                <option value="">Select Status</option>
                <option value="Enable">Enable</option>
                <option value="Disable">Disable</option>
              </select>
          </div>
        </div>

        <div class="clearfix"></div>
        <div class="col-md-6">
          <div class="form-group">
            <button class="btn btn-primary">Submit</button>
            <a href=""class="btn-warning btn">Cancel</a>
          </div>
        </div>

      </div>
    </form>
  </div>

</div>

</body>
</html>
