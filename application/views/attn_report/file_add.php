
  <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
  <div class="content">
    <nav class="navbar navbar-inverse">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
            <a class="navbar-brand" href="<?php echo base_url('attn_process_con/file_upload') ?>">Back to List</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="<?=base_url('payroll_con')?>" >Home</a></li>
          </ul>
          <div class="pull-right">
            <form class="navbar-form pull-right" role="search">
              <div class="input-group">
                <input id="deptSearch" type="text" class="form-control" placeholder="Search">
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                </div>
              </div>
            </form>
          </div>
        </div><!--/.nav-collapse -->
      </div><!--/.container-fluid -->
    </nav>

    <div class="row">
      <div class="col-md-8">
        <?php $success = $this->session->flashdata('success');
        if ($success != "") { ?>
         <div class="alert alert-success"><?php echo $success; ?></div>
         <?php } 
         $error = $this->session->flashdata('error');
         if ($error) { ?>
         <div class="alert alert-failuer"><?php echo $error; ?></div>
         <?php } ?>
      </div>
    </div>

    <div id="target-div">
      <div class="container-fluid">

        <h3><?= $title ?></h3>
        <hr>
        <form enctype="multipart/form-data" method="post" name="creatdepartment" action="<?php echo base_url('attn_process_con/file_add')?>">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <select name="unit_id" id= "unit_id" class="form-control input-sm" required>
                  <option value="">Select Unit</option>
                  <?php 
                    foreach ($dept as $row) {
                      if($row['unit_id'] == $user_data->unit_name){
                        $select_data="selected";
                      }else{
                        if ($user_data->level != "All") {
                            continue;
                        }
                      }
                       echo '<option '.$select_data.'  value="'.$row['unit_id'].'">'.$row['unit_name'].
                       '</option>';
                    }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label>Date</label>
                <input type="text" name="upload_date"value="" class="form-control date" required>
                <?php echo form_error('upload_date');?>
              </div>

              <div class="form-group">
                <label>Select File</label>
                <input type="file" name="upload_file" class="form-control" required style="height: 35px !important; line-height: 20px !important;" accept=".txt">
                <?php echo form_error('upload_file');?>
              </div>


              <br>
              <div id="loader"  align="center" style="margin:0 auto; width:600px; overflow:hidden; display:none; margin-top:10px;">
                <img src="<?php echo base_url('images/ajax-loader.gif');?>" />
              </div>

              <div class="form-group">
                <button class="btn btn-primary" onclick="loading_open()">Save</button>
                <a href=""class="btn-warning btn">Cancel</a>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>

  <script>
    function loading_open() {
      $('#loader').css('display','block');
    }

  </script>