<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-4" style="padding: 7px;">
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/emp_roster_shift') ?>">
                    Back</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                </div>
            </div>
            <div class="col-md-8" style="padding: 7px;">
                <div id="navbar" class="pull-right">
                    <button onclick="schedule_change(<?= $roster_shift->id ?>)" class="btn btn-success">Shift Change</button>
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
            $failuer = $this->session->flashdata('failure');
            ?>
        </div>
    </div>
    <!-- <h3>Create Designation</h3> -->
    <!-- <hr> -->
    <form action="<?= base_url('setup_con/roster_edit') . '/' . $roster_shift->id ?>" enctype="multipart/form-data" method="post">
        <div class="tablebox">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control select22" required>
                            <option value="">Select Unit</option>
                            <?php foreach ($pr_units as $key => $value) {?>
                            <option <?=$roster_shift->unit_id == $value->unit_id ? 'selected' : ''?>  value="<?php echo $value->unit_id; ?>"><?php echo $value->unit_name; ?></option>
                            <?php } ?>
                        </select>
                        <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">Name</label>
                        <input type="text" name="name" value="<?= $roster_shift->name ?>" id="name" class="form-control" placeholder="Name" required>
                        <?= (isset($failuer['name'])) ? '<div class="alert alert-failuer">' . $failuer['name'] . '</div>' : ''; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">Duration</label>
                        <input type="text" name="duration"  value="<?= $roster_shift->duration ?>" id="duration" class="form-control" placeholder="Duration" required>
                        <?= (isset($failuer['duration'])) ? '<div class="alert alert-failuer">' . $failuer['duration'] . '</div>' : ''; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">Start Date</label>
                        <input type="text" name="start_date" value="<?= date('d-m-Y', strtotime($roster_shift->start_date)) ?>" value="<?= $roster_shift->start_date ?>" id="start_date" class="form-control date" placeholder="Start Date" required>
                        <?= (isset($failuer['start_date'])) ? '<div class="alert alert-failuer">' . $failuer['start_date'] . '</div>' : ''; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="unit">End Date </label>
                        <input type="text" name="end_date" value="<?= date('d-m-Y', strtotime($roster_shift->end_date)) ?>" id="end_date" class="form-control date" placeholder="End Date" required>
                        <?= (isset($failuer['end_date'])) ? '<div class="alert alert-failuer">' . $failuer['end_date'] . '</div>' : ''; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <style>
                        .select2-container, .source {
                            border: 1px solid #0aa699 !important;
                            padding: 0;
                        }
                    </style>
                    <div class="col-md-12">
                        <label for="unit">Shift Type</label>
                        <select  name="shift_type[]" id="shift_type" class="select22 col-md-12" multiple="multiple">
                            <option value="">Select Shift Type</option>
                            <?php
                            $roster_shift=json_decode($roster_shift->shift_type)[0];
                            foreach ($pr_emp_shift as $key => $value) { ?>
                            <option <?=in_array($value->id, $roster_shift) ? 'selected' : ''?>  value="<?php echo $value->id; ?>"><?php echo $value->shift_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary ">Submit</button>
                <a href="<?= base_url('setup_con/emp_roster_shift') ?>" class="btn-warning btn">Cancel</a>
            </div>
        </div>
    </form>

    <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:10px;">
        <img src="<?php echo base_url('images/ajax-loader.gif');?>" />
    </div>
</div>

<script>
  function schedule_change(id) {
    $("#loader").show();
    var unit_id = $('#unit_id').val();
    $.ajax({
      type: "POST",
      url: "<?= base_url('setup_con/roster_schedule_change') ?>",
      data: {
        id: id,
        unit_id: unit_id,
      },
      success: function(data) {
          alert(data);
      },
      error: function(data) {
          $("#loader").hide();
          alert(data);
      },
      complete: function(data) {
          $("#loader").hide();
      }
    })
  }
</script>

<script>
  function loading_open() {
    $('#loader').css('display', 'block');
  }
</script>

<script>
  function get_data() {
      var unit_id = $('#unit_id').val();
      $.ajax({
          type: "POST",
          url: "<?= base_url('setup_con/get_data_degi') ?>",
          data: {
              unit_id: unit_id
          },
          success: function(d) {
            var data = JSON.parse(d);

            var attn_bonus = data.attn_bonus;
            var holiday_weekend = data.holiday_weekend;
            var iftar = data.iftar;
            var night = data.night;
            var tiffin = data.tiffin;

            var attnIdSelect = $("#attn_id");
            var holidayWeekendIdSelect = $("#holiday_weekend_id");
            var iftarIdSelect = $("#iftar_id");
            var nightAlIdSelect = $("#night_al_id");
            var tiffinIdSelect = $("#tiffin_id");

            if (attn_bonus.length > 0) {
              attnIdSelect.empty().append("<option value=''>Select Attendance Bonus</option>");
              attn_bonus.forEach(function(item) {
                attnIdSelect.append(`<option value='${item.id}'>${item.rule_name} >> ${item.rule}</option>`);
              });
            }

            if (holiday_weekend.length > 0) {
              holidayWeekendIdSelect.empty().append("<option value=''>Select Holiday/Weekend</option>");
              holiday_weekend.forEach(function(item) {
                holidayWeekendIdSelect.append(`<option value='${item.id}'>${item.rule_name} >> ${item.allowance_amount}</option>`);
              });
            }


            if (iftar.length > 0) {
              iftarIdSelect.empty().append("<option value=''>Select Iftar</option>");
              iftar.forEach(function(item) {
                iftarIdSelect.append(`<option value='${item.id}'>${item.rule_name} >> ${item.allowance_amount}</option>`);
              });
            }


            if (night.length > 0) {
              nightAlIdSelect.empty().append("<option value=''>Select Night Allowance</option>");
              night.forEach(function(item) {
                nightAlIdSelect.append(`<option value='${item.id}'>${item.rule_name} >> ${item.night_allowance}</option>`);
              });
            }


            if (tiffin.length > 0) {
              tiffinIdSelect.empty().append("<option value=''>Select Tiffin</option>");
              tiffin.forEach(function(item) {
                tiffinIdSelect.append(`<option value='${item.id}'>${item.rule_name} >> ${item.allowance_amount}</option>`);
              });
            }
          },
          error: function(data) {

          }
      })
  }
</script>
