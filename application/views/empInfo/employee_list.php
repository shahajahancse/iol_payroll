<div class="content">
    <div class="row tablebox" style="display: block; padding: 20px; background: #fff; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #0177bc; padding-bottom: 10px;">
            <h3 style="font-weight: 600; margin: 0; color: #0177bc;"><i class="fa fa-users"></i> Employee List</h3>
            <a href="<?= base_url('emp_info_con/personal_info_short') ?>" class="btn btn-sm btn-success" style="font-weight: 600;">
                <i class="fa fa-plus-circle"></i> Add New Employee
            </a>
        </div>

        <!-- Filter Options Card -->
        <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border: 1px solid #e9ecef; margin-bottom: 20px;">
            <div class="row">
                <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 600; color: #495057;">Search ID / Name / Mobile</label>
                    <input type="text" id="search_input" class="form-control input-sm" placeholder="ID, Punch ID, Name, Mobile...">
                </div>
                <div class="col-md-2 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 600; color: #495057;">Unit</label>
                    <select id="filter_unit" class="form-control input-sm">
                        <option value="">All Units</option>
                        <?php if (!empty($units)) { foreach ($units as $u) { ?>
                            <option value="<?= $u->unit_id ?>"><?= $u->unit_name ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 600; color: #495057;">Department</label>
                    <select id="filter_dept" class="form-control input-sm">
                        <option value="">All Departments</option>
                        <?php if (!empty($departments)) { foreach ($departments as $d) { ?>
                            <option value="<?= $d->dept_id ?>"><?= $d->dept_name ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-2 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 600; color: #495057;">Section</label>
                    <select id="filter_sec" class="form-control input-sm">
                        <option value="">All Sections</option>
                        <?php if (!empty($sections)) { foreach ($sections as $s) { ?>
                            <option value="<?= $s->sec_id ?>"><?= $s->sec_name ?></option>
                        <?php } } ?>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6" style="margin-bottom: 10px;">
                    <label style="font-size: 12px; font-weight: 600; color: #495057;">Designation</label>
                    <select id="filter_desig" class="form-control input-sm">
                        <option value="">All Designations</option>
                        <?php if (!empty($designations)) { foreach ($designations as $des) { ?>
                            <option value="<?= $des->id ?>"><?= $des->desig_name ?></option>
                        <?php } } ?>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-2 col-sm-6">
                    <label style="font-size: 12px; font-weight: 600; color: #495057;">Status</label>
                    <select id="filter_status" class="form-control input-sm">
                        <option value="" selected>All Status</option>
                        <option value="1">Regular / Active</option>
                        <option value="2">Left</option>
                        <option value="3">Resigned</option>
                    </select>
                </div>
                <div class="col-md-10 col-sm-6 style-actions" style="display: flex; align-items: flex-end; justify-content: flex-end; gap: 10px; margin-top: 15px;">
                    <button type="button" id="btn_filter" class="btn btn-sm btn-primary" style="font-weight: 600; padding: 5px 20px;">
                        <i class="fa fa-filter"></i> Filter Results
                    </button>
                    <button type="button" id="btn_reset" class="btn btn-sm btn-default" style="font-weight: 600; padding: 5px 15px;">
                        <i class="fa fa-refresh"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Employee Data Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="emp_table" style="font-size: 13px;">
                <thead>
                    <tr style="background: #0177bc; color: white;">
                        <th style="width: 40px; text-align: center;">#</th>
                        <th style="width: 80px;">Emp ID</th>
                        <th style="width: 80px;">Punch ID</th>
                        <th>Employee Name</th>
                        <th>Unit</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Mobile</th>
                        <th>Joining Date</th>
                        <th style="width: 70px; text-align: center;">Status</th>
                        <th style="width: 140px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody id="emp_tbody">
                    <tr>
                        <td colspan="11" class="text-center text-muted" style="padding: 30px;">
                            <i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading employee records...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; font-size: 13px; color: #6c757d;">
            <div>Showing <span id="record_count" style="font-weight: bold; color: #000;">0</span> employees</div>
        </div>
    </div>
</div>

<!-- View Details Modal -->
<div class="modal fade" id="empDetailsModal" tabindex="-1" role="dialog" aria-labelledby="empDetailsModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 85%;">
        <div class="modal-content">
            <div class="modal-header" style="background: #0177bc; color: white; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="empDetailsModalLabel" style="font-weight: 600;">
                    <i class="fa fa-user"></i> Employee Details — <span id="v_emp_id"></span>
                </h4>
            </div>
            <div class="modal-body" style="padding: 20px; background: #f8f9fa;">
                <div class="row">
                    <!-- Left Info Column -->
                    <div class="col-md-6">
                        <!-- Basic Info Card -->
                        <div class="panel panel-default" style="box-shadow: none; border-color: #dee2e6;">
                            <div class="panel-heading" style="background: #e9ecef; font-weight: 600; color: #495057;">
                                <i class="fa fa-address-card"></i> Basic & Personal Information
                            </div>
                            <table class="table table-sm table-bordered" style="margin-bottom: 0; font-size: 13px;">
                                <tr><th style="width: 35%; background: #f1f3f5;">Name (English)</th><td id="v_name_en">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Name (Bangla)</th><td id="v_name_bn" style="font-family: SutonnyMJ, sans-serif;">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Father's Name</th><td id="v_father_name">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Mother's Name</th><td id="v_mother_name">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Gender</th><td id="v_gender">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Date of Birth</th><td id="v_dob">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Blood Group</th><td id="v_blood">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Religion</th><td id="v_religion">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Mobile Number</th><td id="v_mobile">-</td></tr>
                            </table>
                        </div>
                    </div>

                    <!-- Right Info Column -->
                    <div class="col-md-6">
                        <!-- Job Info Card -->
                        <div class="panel panel-default" style="box-shadow: none; border-color: #dee2e6;">
                            <div class="panel-heading" style="background: #e9ecef; font-weight: 600; color: #495057;">
                                <i class="fa fa-briefcase"></i> Job & Company Information
                            </div>
                            <table class="table table-sm table-bordered" style="margin-bottom: 0; font-size: 13px;">
                                <tr><th style="width: 35%; background: #f1f3f5;">Employee ID</th><td id="v_emp_id_val" style="font-weight: bold; color: #0177bc;">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Punch / Proxy ID</th><td id="v_proxi_id" style="font-weight: bold;">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Unit</th><td id="v_unit_name">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Department</th><td id="v_dept_name">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Section</th><td id="v_sec_name">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Designation</th><td id="v_desig_name">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Joining Date</th><td id="v_join_date">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Gross Salary</th><td id="v_gross_sal" style="font-weight: bold; color: #28a745;">-</td></tr>
                                <tr><th style="background: #f1f3f5;">Bank / bKash Account</th><td id="v_bank_acc">-</td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="background: #fff; border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;">
                <a id="v_edit_btn" href="#" class="btn btn-warning" style="font-weight: 600;">
                    <i class="fa fa-pencil"></i> Edit Employee Profile
                </a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    load_employees();

    $('#btn_filter').click(function() {
        load_employees();
    });

    $('#btn_reset').click(function() {
        $('#search_input').val('');
        $('#filter_unit').val('');
        $('#filter_dept').val('');
        $('#filter_sec').val('');
        $('#filter_desig').val('');
        $('#filter_status').val('');
        load_employees();
    });

    $('#search_input').keypress(function(e) {
        if(e.which == 13) {
            load_employees();
        }
    });

    function load_employees() {
        $('#emp_tbody').html('<tr><td colspan="11" class="text-center text-muted" style="padding:30px;"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading employee records...</td></tr>');

        var params = {
            search: $('#search_input').val(),
            unit_id: $('#filter_unit').val(),
            dept_id: $('#filter_dept').val(),
            sec_id: $('#filter_sec').val(),
            desig_id: $('#filter_desig').val(),
            status: $('#filter_status').val()
        };

        $.ajax({
            url: '<?= site_url("emp_info_con/get_employee_list_ajax") ?>',
            type: 'GET',
            data: params,
            dataType: 'json',
            success: function(data) {
                var html = '';
                if (data && data.length > 0) {
                    $('#record_count').text(data.length);
                    $.each(data, function(idx, emp) {
                        var status_badge = '';
                        if (emp.emp_cat_id == 1) {
                            status_badge = '<span class="label label-success" style="background-color:#28a745; color:#fff; padding:3px 7px; border-radius:3px;">Regular</span>';
                        } else if (emp.emp_cat_id == 2) {
                            status_badge = '<span class="label label-warning" style="background-color:#ffc107; color:#000; padding:3px 7px; border-radius:3px;">Left</span>';
                        } else if (emp.emp_cat_id == 3) {
                            status_badge = '<span class="label label-danger" style="background-color:#dc3545; color:#fff; padding:3px 7px; border-radius:3px;">Resigned</span>';
                        } else {
                            status_badge = '<span class="label label-default" style="background-color:#6c757d; color:#fff; padding:3px 7px; border-radius:3px;">Inactive</span>';
                        }

                        var join_date = emp.emp_join_date ? emp.emp_join_date : '-';
                        var mobile = emp.personal_mobile ? emp.personal_mobile : '-';

                        html += '<tr>';
                        html += '<td class="text-center">' + (idx + 1) + '</td>';
                        html += '<td><strong style="color:#0177bc;">' + (emp.emp_id || '-') + '</strong></td>';
                        html += '<td>' + (emp.proxi_id || '-') + '</td>';
                        html += '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>';
                        html += '<td>' + (emp.unit_name || '-') + '</td>';
                        html += '<td>' + (emp.dept_name || '-') + '</td>';
                        html += '<td>' + (emp.desig_name || '-') + '</td>';
                        html += '<td>' + mobile + '</td>';
                        html += '<td>' + join_date + '</td>';
                        html += '<td class="text-center">' + status_badge + '</td>';
                        html += '<td class="text-center">';
                        html += '<button type="button" class="btn btn-xs btn-info btn-view-details" data-empid="' + emp.emp_id + '" style="margin-right:4px;"><i class="fa fa-eye"></i> View</button>';
                        html += '<a href="<?= site_url("emp_info_con/personal_info_short") ?>?emp_id=' + emp.emp_id + '" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Edit</a>';
                        html += '</td>';
                        html += '</tr>';
                    });
                } else {
                    $('#record_count').text('0');
                    html = '<tr><td colspan="11" class="text-center text-muted" style="padding:30px;"><em>No employee records found matching criteria.</em></td></tr>';
                }
                $('#emp_tbody').html(html);
            },
            error: function() {
                $('#emp_tbody').html('<tr><td colspan="11" class="text-center text-danger" style="padding:20px;">Failed to load employee data. Please try again.</td></tr>');
            }
        });
    }

    $(document).on('click', '.btn-view-details', function() {
        var emp_id = $(this).data('empid');
        if (!emp_id) return;

        $.ajax({
            url: '<?= site_url("emp_info_con/get_employee_details") ?>',
            type: 'GET',
            data: { emp_id: emp_id },
            dataType: 'json',
            success: function(res) {
                if (res.status && res.data) {
                    var emp = res.data;
                    $('#v_emp_id').text(emp.emp_id);
                    $('#v_emp_id_val').text(emp.emp_id);
                    $('#v_proxi_id').text(emp.proxi_id || '-');
                    $('#v_name_en').text(emp.name_en || '-');
                    $('#v_name_bn').text(emp.name_bn || '-');
                    $('#v_father_name').text(emp.father_name || '-');
                    $('#v_mother_name').text(emp.mother_name || '-');
                    $('#v_gender').text(emp.gender || '-');
                    $('#v_dob').text(emp.emp_dob || '-');
                    $('#v_blood').text(emp.blood || '-');
                    $('#v_religion').text(emp.religion || '-');
                    $('#v_mobile').text(emp.personal_mobile || '-');
                    
                    $('#v_unit_name').text(emp.unit_name || '-');
                    $('#v_dept_name').text(emp.dept_name || '-');
                    $('#v_sec_name').text(emp.sec_name || '-');
                    $('#v_desig_name').text(emp.desig_name || '-');
                    $('#v_join_date').text(emp.emp_join_date || '-');
                    $('#v_gross_sal').text(emp.gross_sal ? '৳ ' + emp.gross_sal : '-');
                    $('#v_bank_acc').text(emp.bank_bkash_no || '-');

                    $('#v_edit_btn').attr('href', '<?= site_url("emp_info_con/personal_info_short") ?>?emp_id=' + emp.emp_id);
                    $('#empDetailsModal').modal('show');
                } else {
                    alert('Could not fetch employee details.');
                }
            }
        });
    });
});
</script>
