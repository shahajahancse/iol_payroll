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
            <!-- <h3 style="font-weight: 600;"><?= $title ?></h3> -->
            <div class="col-md-6">
                <div class="form-group" style="margin-bottom: 10px !important;">
                    <label>Unit <span style="color: red;">*</span> </label>
                    <select name="unit_id" id="unit_id" class="form-control input-sm">
                        <option value="">Select Unit</option>
                        <?php
                        foreach ($dept as $row) {
                            if ($row['unit_id'] == $user_data->unit_name) {
                                $select_data = "selected";
                            } else {
                                $select_data = '';
                            }
                            echo '<option ' . $select_data . '  value="' . $row['unit_id'] . '">' . $row['unit_name'] .
                                '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <!-- department -->
            <div class="col-md-6">
                <div class="form-group" style="margin-bottom: 10px !important;">
                    <label>Department </label>
                    <select class="form-control input-sm dept" id='dept' name='dept'>
                        <?php if (!empty($user_data->unit_name)) {
                            $dpts = $this->db->where('unit_id', $user_data->unit_name)->get('emp_depertment'); ?>
                        <option value=''>Select Department</option>
                        <?php foreach ($dpts->result() as $key => $val) { ?>
                        <option value='<?= $val->dept_id ?>'><?= $val->dept_name ?></option>
                        <?php }
                        } ?>
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
            <!-- line -->
            <div class="col-md-6">
                <div class="form-group" style="margin-bottom: 10px !important;">
                    <label class="control-label">Line </label>
                    <select class="form-control input-sm line" id='line' name='line'>
                        <option value=''></option>
                    </select>
                </div>
            </div>
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
                        <option value="<?= $row->id ?>" <?= ($row->id == 1) ? 'selected' : '' ?>>
                            <?= $row->status_type; ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:5px;">
            <img src="<?php echo base_url('images/ajax-loader.gif'); ?>" />
        </div>

        <!-- tax entry form   -->
        <div id="tax_entry" class="row nav_head">
            <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                <!-- <div > -->
                <style>
                fieldset {
                    display: block;
                    padding-block-start: 0.35em;
                    padding-inline-start: 0.75em;
                    padding-inline-end: 0.75em;
                    padding-block-end: 0.625em;
                    min-inline-size: min-content;
                    border-width: 2px;
                    border-style: solid;
                    border-color: rgb(192, 192, 192);
                }

                legend {
                    width: fit-content;
                    margin-bottom: 0px !important;
                    display: block;
                    border-width: initial;
                    border-style: none;
                    border-color: initial;
                    border-image: initial;
                }
                </style>
                <fieldset>
                    <legend>Tax Entry </legend>
                    <form method="post" id="tax_entry_form">
                        <div class="raw">
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">amount</label>
                                    <input class="form-control input-sm " id="amount" name="amount" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Effect Month</label>
                                    <input class="form-control input-sm" type='month' id="effect_date"
                                        name="effect_date" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Status</label>
                                    <select class="form-control input-sm" id="status" name="status">
                                        <option>Select status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group"
                                    style="padding: 2px 5px !important; margin-top: 15px; margin-bottom: 3px !important;">
                                    <input class="btn btn-primary" onclick='tax_entry(event)' type="button"
                                        value='Save' />
                                </div>
                            </div>
                        </div>
                    </form>
                </fieldset>
            </div>
        </div>
        <!-- Advanced Loan form   -->
        <!-- <div id="advanced_loan_entry" class="row nav_head">
            <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
                <fieldset>
                    <legend>Advanced Loan</legend>
                    <form method="post" id="advanced_loan_entry_form">
                        <div class="raw">
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Loan Month</label>
                                    <input class="form-control input-sm" type='month' id="loan_month" name="loan_month"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Loan Amount</label>
                                    <input class="form-control input-sm " id="loan_amount" name="loan_amount"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Effect Month</label>
                                    <input class="form-control input-sm" type='month' id="effect_month"
                                        name="effect_month" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Pay amount</label>
                                    <input class="form-control input-sm " id="pay_amount" name="pay_amount"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="raw">
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group" style="margin-bottom: 3px !important;">
                                    <label class="control-label">Status</label>
                                    <select name="status" id="status" class="form-control input-sm ">
                                        <option>Select status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 5px !important">
                                <div class="form-group"
                                    style="padding: 2px 5px !important; margin-top: 15px; margin-bottom: 3px !important;">
                                    <input class="btn btn-primary" onclick='advance_loan_entry(event)' type="button"
                                        value='Save' />
                                </div>
                            </div>
                        </div>

                    </form>
                </fieldset>
            </div>
        </div> -->
    </div>

    <!-- employee list for right side -->
    <div class="col-md-4 tablebox">
        <input type="text" id="searchi" class="form-control" placeholder="Search">
        <div style="height: 80vh; overflow-y: scroll;">
            <table class="table table-hover" id="fileDiv">
                <thead>
                    <tr style="position: sticky;top: 0;z-index:1">
                        <th class="active" style="width:10%"><input type="checkbox" id="select_all"
                                class="select-all checkbox" name="select-all"></th>
                        <th class="" style="background:#0177bcc2;color:white">Id</th>
                        <th class=" text-center" style="background:#0177bc;color:white">Name</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                    <?php if (!empty($employees)) {
                        foreach ($employees as $key => $emp) {
                    ?>
                    <tr class="removeTr">
                        <td><input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]"
                                value="<?= $emp->emp_id ?>">
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
function advance_loan_entry(e) {
    e.preventDefault();
    var checkboxes = document.getElementsByName('emp_id[]');
    var sql = get_checked_value(checkboxes);
    let emp_id = sql.split(",");
    if (emp_id == '') {
        showMessage('error', 'Please select employee Id');
        return false;
    }
    unit_id = document.getElementById('unit_id').value;
    if (unit_id == '') {
        showMessage('error', 'Please select Unit');
        return false;
    }
    loan_month = document.getElementById('loan_month').value;
    if (loan_month == '') {
        showMessage('error', 'Please enter the loan month');
        return false;
    }
    loan_amount = document.getElementById('loan_amount').value;
    if (loan_amount == '') {
        showMessage('error', 'Please select the loan amount');
        return false;
    }
    effect_month = document.getElementById('effect_month').value;
    if (effect_month == '') {
        showMessage('error', 'Please select the effect month');
        return false;
    }
    pay_amount = document.getElementById('pay_amount').value;
    if (pay_amount == '') {
        showMessage('error', 'Please enter the pay amount');
        return false;
    }
    status = document.getElementById('status').value;
    if (status == '') {
        showMessage('error', 'Please select the status');
        return false;
    }
    var formdata = $("#advanced_loan_entry_form").serialize();
    var data = "unit_id=" + unit_id + "&emp_id=" + emp_id + "&loan_month=" + loan_month + "&loan_amount=" +
        loan_amount + "&effect_month=" + effect_month + "&pay_amount=" + pay_amount + "&status=" + status + "&" +
        formdata; // Merge the data

    loading_open();
    $.ajax({
        type: "POST",
        url: hostname + "entry_system_con/advance_loan_entry",
        data: data,
        success: function(data) {
            loading_close();
            if (data == 'success') {
                showMessage('success', 'Loan Inserted Successfully');
            } else {
                showMessage('error', 'Loan not Inserted');
            }
        },
        error: function(data) {
            loading_close();
            showMessage('error', 'Loan not Inserted');
        }
    })
}

function tax_entry(e) {
    e.preventDefault();
    var checkboxes = document.getElementsByName('emp_id[]');
    var sql = get_checked_value(checkboxes);
    let emp_id = sql.split(",");
    if (emp_id == '') {
        showMessage('error', 'Please select employee Id');
        return false;
    }

    unit_id = document.getElementById('unit_id').value;
    if (unit_id == '') {
        showMessage('error', 'Please select Unit');
        return false;
    }

    amount = document.getElementById('amount').value;
    if (amount == '') {
        showMessage('error', 'Please enter the amount');
        return false;
    }
    effect_date = document.getElementById('effect_date').value;
    if (effect_date == '') {
        showMessage('error', 'Please select the date');
        return false;
    }
    status = document.getElementById('status').value;
    if (status == '') {
        showMessage('error', 'Please select the status');
        return false;
    }

    var formdata = $("#tax_entry_form").serialize();
    var data = "unit_id=" + unit_id + "&amount=" + amount + "&effect_date=" + effect_date + "&status=" + status +
        "&emp_id=" + emp_id + "&" + formdata; // Merge the data

    loading_open();
    $.ajax({
        type: "POST",
        url: hostname + "entry_system_con/tax_entry",
        data: data,
        success: function(data) {
            loading_close();
            if (data == 'success') {
                showMessage('success', 'Tax Inserted Successfully');
            } else {
                showMessage('error', 'Tax not Inserted');
            }
        },
        error: function(data) {
            loading_close();
            showMessage('error', 'Tax not Inserted');
        }
    })
}
</script>

<script>
$(document).ready(function() {
    $("#searchi").on("keyup", function() {
        grid_emp_list()
    });
});
</script>
<script>
function loading_open() {
    $('#loader').css('display', 'block');
}
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

    url = hostname + "common/grid_emp_list/" + unit + "/" + dept + "/" + section + "/" + line + "/" + desig;
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            "status": status,
            "searchi": searchi
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

    //Designation dropdown
    $('#line').change(function() {
        $('.desig').addClass('form-control input-sm');
        $(".desig > option").remove();
        var id = $('#line').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_designation_by_line_id/" + id,
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

    //Line dropdown
    $('#section').change(function() {
        $('.line').addClass('form-control input-sm');
        $(".line > option").remove();
        $(".desig > option").remove();
        var id = $('#section').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_line_by_sec_id/" + id,
            success: function(func_data) {
                $('.line').append("<option value=''>-- Select Line --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.line').append(opt);
                });
            }
        });
        // load employee
        grid_emp_list();
    });

    //section dropdown
    $('#dept').change(function() {
        $('.section').addClass('form-control input-sm');
        $(".section > option").remove();
        $(".line > option").remove();
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
        // load employee
        grid_emp_list();
    });

    //Department dropdown
    $('#unit_id').change(function() {
        $('.dept').addClass('form-control input-sm');
        $(".dept > option").remove();
        $(".section > option").remove();
        $(".line > option").remove();
        $(".desig > option").remove();
        var id = $('#unit_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_department_by_unit_id/" + id,
            success: function(func_data) {
                $('.dept').append("<option value=''>-- Select Department --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.dept').append(opt);
                });
            }
        });
        // load employee
        grid_emp_list();
    });
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