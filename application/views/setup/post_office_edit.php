
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
          <a class="navbar-brand" ><?= $title ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a  href="<?php echo base_url('setup_con/post_office') ?>">Post Office List</a></li>
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
         $failuer = $this->session->flashdata('failuer');
         if ($failuer) { ?>
         <div class="alert alert-failuer"><?php echo $failuer; ?></div>
         <?php } ?>
      </div>
    </div>

    <div id="target-div">
      <div class="container-fluid">
        <h3><?= $title ?></h3>
        <hr>
        <form enctype="multipart/form-data" method="post" name="creatcompanyunit" action="<?php echo base_url("setup_con/post_office_edit/$post->id");?>">
          <div class="row">

            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">বিভাগ</label>
                <?php echo form_error('division'); ?>
                <select name="division" id= "division" class="form-control input-sm" style="min-height: 35px !important; border: 1px solid #0aa699;">
                  <option value="">Select Unit</option>
                  <?php 
                    foreach ($divisions as $row) { ?>
                      <option value="<?= $row['id'] ?>" <?php echo ($post->div_id == $row['id'] )? 'selected':''; ?> ><?= $row['name_bn']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $dis = $this->db->where('id', $post->dis_id)->get('emp_districts')->row(); ?>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">জেলা</label>
                <?php echo form_error('district'); ?>
                <select name="district" id= "district" class="district_val form-control input-sm" style="min-height: 35px !important; border: 1px solid #0aa699;">
                  <option value="<?= $post->dis_id ?>"><?= $dis->name_bn ?></option>
                </select>
              </div>
            </div>

            <?php $uz = $this->db->where('id', $post->up_zil_id)->get('emp_upazilas')->row(); ?>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">উপজেলা / থানা</label>
                <?php echo form_error('upazila'); ?>
                <select name="upazila" id= "upazila" class="upazila_thana form-control input-sm" style="min-height: 35px !important; border: 1px solid #0aa699;">
                  <option value="<?= $post->up_zil_id ?>"><?= $uz->name_bn ?></option>
                </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>পোস্ট অফিস বাংলা</label>
                <?php echo form_error('post_office'); ?>
                <input type="text" name="post_office" class="form-control bfont" value="<?= $post->name_bn ?>" required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label>Post Office English</label>
                <?php echo form_error('post_office_en');?>
                <input type="text" name="post_office_en" class="form-control" value="<?= $post->name_en ?>" required>
              </div>
            </div>

            <br>
            <div class="col-md-12">
              <div class="form-group pull-right">
                <button class="btn btn-primary">Save</button>
                <a href=""class="btn-warning btn">Cancel</a>
              </div>
            </div>

          </div>
        </form>
      </div>
    </div>

  </div>



<script type="text/javascript">
  $(document).ready(function () {
    //division dropdown
    $('#division').change(function(){
      $('.district_val').addClass('form-control input-sm');
      $(".district_val > option").remove();
      $(".upazila_thana > option").remove();
      var id = $('#division').val();
      $.ajax({
          type: "POST",
          url: hostname +"common/ajax_district_by_div/" + id,
          success: function(func_data)
          {
            $('.district_val').append("<option value=''>-- Select District --</option>");
            $.each(func_data,function(id,name)
            {
                var opt = $('<option />');
                opt.val(id);
                opt.text(name);
                $('.district_val').append(opt);
            });
          }
      });
    });


    //district dropdown
    $('#district').change(function(){
      $('.upazila_thana').addClass('form-control input-sm');
      $(".upazila_thana > option").remove();
      var dis_id = $('#district').val();
      $.ajax({
          type: "POST",
          url: hostname +"common/ajax_upazila_by_dis/" + dis_id,
          success: function(upazilaThanas)
          {
            $('.upazila_thana').append("<option value=''>-- Select Upazila --</option>");
            $.each(upazilaThanas,function(id,ut_name)
            {
                var opt = $('<option />');
                opt.val(id);
                opt.text(ut_name);
                $('.upazila_thana').append(opt);
            });
          }
      });
    });
  });
</script>