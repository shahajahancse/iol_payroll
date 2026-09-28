



<div class="content" >
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
                    <a class="btn btn-info" href='<?php echo base_url("setup_con/salary_grade") ?>'>
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

  <h3>Update Salary Grade</h3>
  <hr>
  <form enctype="multipart/form-data" method="post" name="creatcompanyunit" action="<?php echo base_url().'crud_con/salgrd_edit/'.$pr_grade->gr_id;?>">
  <div class="row">
    <div class="col-md-4">
      <input type="hidden" name="id"value="<?=$pr_grade->gr_id;?>" class="form-control"> 
      <div class="form-group">
        <label>Grade Name</label>
        <input type="text" name="gr_name"value="<?=set_value('gr_name',$pr_grade->gr_name)?>" class="form-control">
        <?php echo form_error('gr_name');?>
      </div>
    </div>
    <div class="col-md-4">
      <input type="hidden" name="id"value="<?=$pr_grade->gr_id;?>" class="form-control"> 
      <div class="form-group">
        <label>Salary</label>
        <input type="text" name="salary"value="<?=set_value('salary',$pr_grade->salary)?>" class="form-control">
        <?php echo form_error('salary');?>
      </div>
    </div>
    <br>
      <div class="form-group">
        <button class="btn btn-primary">Update</button>
        <a href=""class="btn-warning btn">Cancel</a>
      </div>
  </div>
</form>
</div>