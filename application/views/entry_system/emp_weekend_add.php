<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
<style>
#fileDiv #removeTr td {
    padding: 5px 10px !important;
    font-size: 14px;
}
</style>
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->

<?php
    $this->load->model('common_model');
    $unit = $this->common_model->get_unit_id_name();
?>
<div class="content">
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
    <!-- <div class="container-fluid">	 -->
    <div class="col-md-8">
        <div class="row tablebox" style="display: block;">
        <a class="btn btn-info" href="<?= base_url('entry_system_con/weekend_list') ?>">List</a>
        <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Dashboard</a> -->
            <h3></h3>
            <!-- <h3 style="font-weight: 600;"><?= $title ?></h3> -->
                <input type="hidden" name="unit_id" id="unit_id" value="1">
                <!-- shift -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label>Shift </label>
                        <select class="form-control input-sm shift" id='shift' name='shift' onChange="grid_emp_list()">
                            <option value=''>Select Shift</option>
                            <?php 
                                $shifts = $this->db->get('pr_emp_shift');
                                if (!empty($shifts)) {
                                    foreach ($shifts->result() as $key => $val) { ?>
                                        <option value='<?= $val->id ?>'><?= $val->shift_name ?></option>
                                <?php } } ?>
                        </select>
                    </div>
                </div>
                <!-- department -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label>Department </label>
                        <select class="form-control input-sm dept" id='dept' name='dept'>
                            <?php 
                                $dpts = $this->db->where('unit_id', 1)->get('emp_depertment'); ?>
                                <option value=''>Select Department</option>
                                <?php foreach ($dpts->result() as $key => $val) { ?>
                                    <option value='<?= $val->dept_id ?>'><?= $val->dept_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <!-- section -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Section </label>
                        <select class="form-control input-sm section" id='section' name='section'>
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- line (hidden) -->
                <input type="hidden" class="line" id="line" name="line" value="0">
                <!-- Designation -->
                <div class="col-md-6">
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Designation</label>
                        <select class="form-control input-sm desig" id='desig' name='desig' onChange="grid_emp_list()">
                            <option value=''></option>
                        </select>
                    </div>
                </div>
                <!-- status -->
                <div class="col-md-6">
                    <?php $categorys = $this->db->get('emp_category_status')->result(); ?>
                    <div class="form-group" style="margin-bottom: 10px !important;">
                        <label class="control-label">Status </label>
                        <select name="status" id="status" class="form-control input-sm" onChange="grid_emp_list()">
                            <option value="">All Employee</option>
                            <?php foreach ($categorys as $key => $row) { ?>
                                <option value="<?= $row->id ?>" <?= ($row->id == 1) ? 'selected' : '' ?>><?= $row->status_type; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        <br>
        <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:10px;">
            <img src="<?php echo base_url('images/ajax-loader.gif');?>" />
        </div>

        <style>
            .input-group .form-control {
                width: 90% !important;
            }
            .input-group-btn .btn {
                padding: 8px 10px !important;
            }
        </style>

        <!-- Button section -->
        <div class="row nav_head">
            <div class="col-lg-4">
                <span style="font-size: 20px;"><?= $title ?></span>
            </div><!-- /.col-lg-6 -->
            <div class="col-lg-5">
                <div class="input-group" style="gap: 14px; display: flex;">
                    <input type="text" class="form-control date" id="date" placeholder="select date">
                    <span class="input-group-btn" style="display: flex; gap: 10px;">
                        <input class="btn btn-primary" onclick='add_weekend()' type="button" value='Add Weekend' />
                        <input class="btn btn-danger" onclick="delete_weekend()" type="button" value="Delete">
                    </span>
                </div><!-- /input-group -->
            </div><!-- /.col-lg-6 -->
        </div><!-- /.row -->
    </div>


    <!-- employee list for right side -->
    <div class="col-md-4 tablebox">
        <input type="text" id="searchi" class="form-control" placeholder="Search">
        <div style="height: 80vh; overflow-y: scroll;">
            <table class="table table-hover" id="fileDiv">
                <thead>
                    <tr style="position: sticky;top: 0;z-index:1">
                        <th class="active" style="width:10%"><input type="checkbox" id="select_all" class="select-all checkbox" name="select-all"></th>
                        <th class="" style="background:#0177bcc2;color:white">Id</th>
                        <th class=" text-center" style="background:#0177bc;color:white">Name</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php if (!empty($employees)) {
                        foreach ($employees as $key => $emp) {
                    ?>
                            <tr class="removeTr">
                                <td><input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="<?= $emp->emp_id ?>">
                                </td>
                                <td class="success"><?= $emp->emp_id ?></td>
                                <td class="warning "><?= $emp->name_en ?></td>
                            </tr>
                    <?php }
                    } ?>
                    <tr class="removeTrno">
                        <td colspan="3" class="text-center"> No data found</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- </div> -->
</div>

<script>
    function loading_open() {
        $('#loader').css('display', 'block');
    }
</script>

<script>
        $(document).ready(function() {
            $("#searchi").on("keyup", function() {
                grid_emp_list()
            });
        });
    </script>

<script type="text/javascript">
    // on load employee
    function grid_emp_list() {
            $('.removeTr').remove();

            var unit = document.getElementById('unit_id').value;
            var dept = document.getElementById('dept').value;
            var section = document.getElementById('section').value;
            var line = document.getElementById('line').value;
            var desig = document.getElementById('desig').value;
            var status = document.getElementById('status').value;
            var searchi = document.getElementById('searchi').value;
            var shift = document.getElementById('shift') ? document.getElementById('shift').value : '';

            url = hostname + "common/grid_emp_list/" + unit + "/" + dept + "/" + section + "/" + line + "/" + desig;
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    "status": status,
                    "searchi": searchi,
                    "shift": shift
                },
                contentType: "application/json",
                dataType: "json",


                success: function(response) {
                    $('.removeTr').remove();
                    if (response.length != 0) {
                        $('.removeTrno').hide();
                        var items = '';
                        $.each(response, function(index, value) {
                            items += `
                                <tr class="removeTr">
                                    <td><input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="${value.emp_id }" ></td>
                                    <td class="success">${value.emp_id}</td>
                                    <td class="warning ">${value.name_en}</td>
                                </tr>`
                        });
                        // console.log(items);
                        $('#fileDiv tr:last').after(items);
                    } else {
                        $('.removeTrno').show();
                        $('.removeTr').remove();
                    }
                }
            });
        }

    $(document).ready(function() {
        // select all item or deselect all item
        $("#select_all").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });

        // Load designation on section change
        $('#section').change(function() {
            $('.desig').addClass('form-control input-sm');
            $(".desig > option").remove();
            $.ajax({
                type: "POST",
                url: hostname + "common/ajax_designation_by_unit/1",
                success: function(func_data) {
                    $('.desig').append("<option value=''>-- Select Designation --</option>");
                    $.each(func_data, function(id, name) {
                        var opt = $('<option />');
                        opt.val(id);
                        opt.text(name);
                        $('.desig').append(opt);
                    });
                }
            });
            // load employee
            grid_emp_list();
        });

        // Section dropdown on dept change
        $('#dept').change(function() {
            $('.section').addClass('form-control input-sm');
            $(".section > option").remove();
            $(".desig > option").remove();
            var id = $('#dept').val();
            $.ajax({
                type: "POST",
                url: hostname + "common/ajax_section_by_dept_id/" + id,
                success: function(func_data) {
                    $('.section').append("<option value=''>-- Select Section --</option>");
                    $.each(func_data, function(id, name) {
                        var opt = $('<option />');
                        opt.val(id);
                        opt.text(name);
                        $('.section').append(opt);
                    });
                }
            });
            $.ajax({
                type: "POST",
                url: hostname + "common/ajax_designation_by_unit/1",
                success: function(func_data) {
                    $('.desig').append("<option value=''>-- Select Designation --</option>");
                    $.each(func_data, function(id, name) {
                        var opt = $('<option />');
                        opt.val(id);
                        opt.text(name);
                        $('.desig').append(opt);
                    });
                }
            });
            // load employee
            grid_emp_list();
        });

        // Initial load of designations and employee list
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_designation_by_unit/1",
            success: function(func_data) {
                $('.desig').append("<option value=''>-- Select Designation --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.desig').append(opt);
                });
            }
        });
        grid_emp_list();
    });
</script>

<script>
  function get_checked_value(checkboxes) {
    var vals = Array.from(checkboxes)
      .filter(checkbox => checkbox.checked)
      .map(checkbox => checkbox.value)
      .join(",");
    return vals;
  }
</script>



<script>
  function add_weekend() {
    $("#loader").show();
    var checkboxes = document.getElementsByName('emp_id[]');
    var sql = get_checked_value(checkboxes);
    if (sql =='') {
      alert('Please select employee Id');
      $("#loader").hide();
      return false;
    }
    var date = $('#date').val();
    if (date =='') {
      alert('Please select Date');
      $("#loader").hide();
      return false;
    }
    var unit_id = $('#unit_id').val();
    if (unit_id =='') {
      alert('Please select Unit');
      $("#loader").hide();
      return false;
    }
    $.ajax({
      type: "POST",
      url: hostname + "entry_system_con/weekend_add_ajax",
      data: {
        sql: sql,
        date: date,
        unit_id: unit_id
      },
      success: function(data) {
        // console.log(data);
          $("#loader").hide();
          if (data == 'success') {
              showMessage('success', 'Weekend Added Successfully');
          }else {
              showMessage('error', 'Weekend Not Added');
          }
      }
    })
  }
</script>

<script>
  function delete_weekend() {
    $("#loader").show();
    var checkboxes = document.getElementsByName('emp_id[]');
    var sql = get_checked_value(checkboxes);
    if (sql =='') {
      alert('Please select employee Id');
      $("#loader").hide();
      return false;
    }
    var date = $('#date').val();
    if (date =='') {
      alert('Please select Date');
      $("#loader").hide();
      return false;
    }
    var unit_id = $('#unit_id').val();
    if (unit_id =='') {
      alert('Please select Unit');
      $("#loader").hide();
      return false;
    }
    $.ajax({
      type: "POST",
      url: hostname + "entry_system_con/weekend_delete_all",
      data: {
        sql: sql,
        date: date,
        unit_id: unit_id
      },
      success: function(data) {
        // console.log(data);
          $("#loader").hide();
          if (data == 'success') {
              showMessage('success', 'Weekend Deleted Successfully');
          }else {
              showMessage('error', 'Weekend Not Deleted');
          }
      }
    })
  }
</script>
