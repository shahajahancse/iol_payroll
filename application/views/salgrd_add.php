<div class="content">
<!-- Static navbar -->
   <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-3" style="padding: 7px;">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/salary_grade') ?>">
                        < < Back</a>
                            <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a>
                </div>
            </div>
            <div class="col-md-6">
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="">
                        <form class="navbar-form pull-right" role="search">
                            <div class="input-group">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
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
           <?php }?>
        </div>
      </div>
<div class="tablebox">
  <h3>Create Salary Grade</h3>
  <hr>
  <form enctype="multipart/form-data" method="post" name="creatsalarygrade" action="<?php echo base_url().'crud_con/salgrd_add'?>">
	  <div class="row">
	    <div class="col-md-4">
	      <div class="form-group">
	        <label>Grade Name</label>
	        <input type="text" name="gr_name" value="" class="form-control">
	        <?php echo form_error('gr_name');?>
	      </div>
        <br>
      </div>

      <div class="col-md-4">
	      <div class="form-group">
	        <label>Salary</label>
	        <input type="number" name="salary" value="" class="form-control">
	        <?php echo form_error('salary');?>
	      </div>
        <br>
      </div>
      <br>
      <div class="form-group">
          <button class="btn btn-primary">Create</button>
          <a href="" class="btn btn-warning ">Cancel</a>
        </div>
    </div>
  </form>
</div>


</div>

