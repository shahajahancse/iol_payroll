<!DOCTYPE html>
<html lang="en">
<head>
  <title>Leave Management Edit</title>
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
            <a class="navbar-brand" href="#">Update Leave Management</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo base_url('payroll_con') ?>">Home</a></li>
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

  <h3>Update Leave Management</h3>
  <hr>
  <form enctype="multipart/form-data" method="post" name="editleave" action="<?php echo base_url().'crud_con/leave_edit/'.$pr_leave->lv_id;?>">
  <div class="row">
    <div class="col-md-6">
      <input type="hidden" name="id"value="<?=$pr_leave->lv_id;?>" class="form-control"> 
      

     <div class="form-group">
        <label>Leave Name</label>
        <input type="text" name="lvname"value="<?=set_value('lv_name',$pr_leave->lv_name)?>" class="form-control">
        <?php echo form_error('lvname');?>
      </div>
     <div class="form-group">
    
        <label>Status ID</label>
        <input type="text" name="stid"value="<?=set_value('status_id',$pr_leave->status_id)?>" class="form-control">
        <?php echo form_error('stid');?>
      </div>
     <div class="form-group">
    
        <label>Sick Leave</label>
        <input type="text" name="sicklv"value="<?=set_value('lv_sl',$pr_leave->lv_sl)?>" class="form-control">
        <?php echo form_error('sicklv');?>
      </div>
     <div class="form-group">
    
        <label>Casual Leave</label>
        <input type="text" name="cullv"value="<?=set_value('lv_cl',$pr_leave->lv_cl)?>" class="form-control">
        <?php echo form_error('cullv');?>
      </div>
     <div class="form-group">
    
        <label>Maternity Leave</label>
        <input type="text" name="matrlv"value="<?=set_value('lv_ml',$pr_leave->lv_ml)?>" class="form-control">
        <?php echo form_error('matrlv');?>
      </div>
      <label>Paternity Leave</label>
        <input type="text" name="patlv"value="<?=set_value('lv_pl',$pr_leave->lv_pl)?>" class="form-control">
        <?php echo form_error('patlv');?>
      </div>
     
     </div><br>
     
      <div class="form-group">
        <button class="btn btn-primary">Update</button>
        <a href=""class="btn-warning btn">Cancel</a>
      </div>
    </div>
  </div>
</form>
</div>

</body>
</html>