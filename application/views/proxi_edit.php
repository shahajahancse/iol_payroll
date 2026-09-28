<!DOCTYPE html>
<html lang="en">
<head>
  <title>Proxi ID Edit</title>
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
            <a class="navbar-brand" href="#">Update Proxi ID</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?php echo base_url('payroll_con') ?>">Home</a></li>
            </ul>
            
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

  <h3>Update Proxi ID</h3>
  <hr>
  <form enctype="multipart/form-data" method="post" name="creatcompanyunit" action="<?php echo base_url().'crud_con/proxi_edit/'.$pr_id_proxi->emp_id;?>">
  <div class="row">
    <div class="col-md-6">
      <input type="hidden" name="id"value="<?=$pr_id_proxi->emp_id?>" class="form-control">
      <div class="form-group">
    
        <label>Emp ID</label>
        <p style="font-size: 20px"><?=$pr_id_proxi->emp_id?></p>
        <!-- <input type="text" name="empId"value="<?=set_value('emp_id',$pr_id_proxi->emp_id)?>" class="form-control"> -->
       <!--  <?php echo form_error('empId');?> -->
      </div>
      <div class="form-group">
    
        <label>Proxi ID</label>
        <input type="text" name="proxiId"value="<?=set_value('proxi_id',$pr_id_proxi->proxi_id)?>" class="form-control">
        <?php echo form_error('proxiId');?>
      </div>
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