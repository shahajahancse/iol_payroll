<!DOCTYPE html>
<html lang="en">
<head>
  <title>AddFloor</title>
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
            <a class="navbar-brand" href="<?=base_url('setup_con/floor')?>">Back To List</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="<?=base_url('payroll_con')?>">Home</a></li>
            </ul>

          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <div class="row">
        <div class="col-md-12">
          <?php
          $success = $this->session->flashdata('success');
          if ($success != "") {
           ?>
           <div class="alert alert-success"><?php echo $success; ?></div>
           <?php
            }
            $failuer = $this->session->flashdata('failuer');
            if ($failuer) {
             ?>
           <div class="alert alert-failuer"><?php echo $failuer; ?></div>
           <?php
            }
            ?>

        </div>
      </div>

  <h3>Create Floor</h3>
  <hr>
  <form enctype="multipart/form-data" method="post" name="creatfloor" action="<?php echo base_url().'crud_con/floor_add'?>">
	  <div class="row">
	    <div class="col-md-6">
	      <div class="form-group">
	        <label>Floor Name</label>
	        <input type="text" name="name"value="" class="form-control">
	        <?php echo form_error('name');?>
	      </div>
        <div class="form-group">
          <select name="floor" id= "floor" class="form-control input-lg">
            <option value="">Select Unit</option>
            <?php
            // print_r($floor);exit('mafiz');
              foreach ($floor as $row)
              {
                 echo '<option value="'.$row[unit_id].'">'.$row[unit_name].
                 '</option>';
              }

             ?>

          </select>
        </div>
	      <!-- <div class="dropdown">
	        <label>Company Unit</label>
	      	<select class="form-control" name="cars" id="cars">
			    <option value="volvo">Volvo</option>
			    <option value="saab">Saab</option>
			    <option value="opel">Opel</option>
			    <option value="audi">Audi</option>
			 </select>
		    <?php
              foreach ($unit as $row)
              {
                 echo '<option value="'.$row->unit_id.'">'.$row->unit_name.
                 '</option>';
              }

             ?>
		  </div> -->
      <br>

		<div class="form-group">
	        <button class="btn btn-primary">Create</button>
	        <a href=""class="btn-warning btn">Cancel</a>
	      </div>
	    </div>
	  </div>
</form>
</div>

</body>
</html>
