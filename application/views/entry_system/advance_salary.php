<div class="content">

    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                    <a class="btn btn-info" href="<?php echo base_url('entry_system_con/advance_salary_form') ?>">Add New Advance Salary</a>
                </div>
            </div>
            <div class="col-md-7">
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="pull-right" style="padding:8px 0;">
                        <button type="button" id="btn-bulk-action" class="btn btn-primary btn-sm">
                            <i class="fa fa-pencil"></i> Edit
                        </button>
                    </div>
                </div>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>

    <!-- ===== Search Filter Row ===== -->
    <?php
        $cur_type   = isset($search_type)  ? $search_type  : '';
        $cur_from   = isset($from_date)    ? $from_date    : '';
        $cur_to     = isset($to_date)      ? $to_date      : '';
        $cur_month  = isset($search_month) ? $search_month : '';
        $is_month   = ($cur_type === 'month');
    ?>
    <div class="row" style="margin:4px 0 6px 0;">  
        <div class="col-md-12" style="background:#e8f4fd;padding:8px 15px;border-radius:6px;border:1px solid #b8d9f0;">
            <form method="GET" action="<?php echo base_url('entry_system_con/advance_salary') ?>"
                  style="display:flex;align-items:center;gap:6px;flex-wrap:nowrap;">

                <input type="hidden" id="search_type" name="search_type"
                       value="<?php echo htmlspecialchars($cur_type ?: 'range'); ?>">

                <!-- Toggle -->
                <div class="btn-group btn-group-sm">
                    <button type="button" id="btnTypeRange"
                        class="btn <?php echo $is_month ? 'btn-default' : 'btn-info'; ?>"
                        onclick="setSearchType('range')">
                        <i class="fa fa-calendar"></i> Date Range
                    </button>
                    <button type="button" id="btnTypeMonth"
                        class="btn <?php echo $is_month ? 'btn-info' : 'btn-default'; ?>"
                        onclick="setSearchType('month')">
                        <i class="fa fa-calendar-o"></i> Month
                    </button>
                </div>

                <!-- Date range inputs -->
                <div id="rangeInputs" style="display:<?php echo $is_month ? 'none' : 'flex'; ?>;align-items:center;gap:4px;">
                    <input type="month" name="from_date" id="from_date" class="form-control input-sm"
                           value="<?php echo htmlspecialchars($cur_from); ?>" style="width:140px;">
                    <span>–</span>
                    <input type="month" name="to_date" id="to_date" class="form-control input-sm"
                           value="<?php echo htmlspecialchars($cur_to); ?>" style="width:140px;">
                </div>

                <!-- Month input -->
                <div id="monthInput" style="display:<?php echo $is_month ? 'flex' : 'none'; ?>;align-items:center;">
                    <input type="month" name="search_month" id="search_month" class="form-control input-sm"
                           value="<?php echo htmlspecialchars($cur_month); ?>" style="width:160px;">
                </div>

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa fa-search"></i> Search
                </button>
                <a href="<?php echo base_url('entry_system_con/advance_salary') ?>" class="btn btn-default btn-sm">
                    <i class="fa fa-times"></i> Reset
                </a>

                <input id="deptSearch" type="text" class="form-control input-sm"
                       placeholder="Quick search…" style="width:150px;">
            </form>
        </div>
    </div>
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
            <?php } ?>
        </div>
    </div>
    <!-- <br> -->
    <div class="row tablebox">
        <div class="col-md-12">
            <table class="table table-bordered" id="mytable">
                <thead style="font-size: 11px !important;">
                    <tr>
                        <th style="width:30px;text-align:center;">
                            <input type="checkbox" id="checkAll" title="Select All">
                        </th>
                        <th>SL</th>
                        <th>Emp Id</th>
                        <th>Emp name </th>
                        <th style="width: 90px;">Loan Amount</th>
                        <th style="width: 90px;">Loan Month</th>
                        <th style="width: 90px;">Pay Amount</th>
                        <th style="width: 90px;">Pay Month</th>  
                        <!-- <th>Unit name</th> -->
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)) { foreach ($results as $key => $r) {?>
                    <tr>
                        <td style="text-align:center;">
                            <input type="checkbox" class="row-check"
                                data-id="<?php echo $r->id ?>"
                                data-emp-id="<?php echo htmlspecialchars($r->emp_id) ?>"
                                data-name="<?php echo htmlspecialchars($r->name_en) ?>"
                                data-loan-amt="<?php echo $r->loan_amt ?>"
                                data-pay-amt="<?php echo $r->pay_amt ?>"
                                data-loan-status="<?php echo $r->loan_status ?>"
                                data-status="<?php echo $r->status ?>"> 
                        </td>
                        <td><?php echo $key + 1  ?></td>
                        <td><?php echo $r->emp_id ?></td>
                        <td style="white-space:nowrap;"><?php echo $r->name_en ?></td>
                        <td><?php echo number_format($r->loan_amt, 2) ?></td>
                        <td><?php echo date('d M Y', strtotime($r->loan_month)) ?></td>
                        <td><?php echo number_format($r->pay_amt, 2) ?></td>
                        <td><?php echo ($r->effect_month)?date('d M Y', strtotime($r->effect_month)):'' ?></td>
                        <!-- <td>< ?php echo $r->unit_name ?></td> --> 
                        <td>
                            <?php
                                if ($r->loan_status == 1) echo '<span class="label label-warning">Not Pay</span>';
                                elseif ($r->loan_status == 2) echo '<span class="label label-success" style="background-color: #28a745 !important;">Full Pay</span>';
                                else echo '<span class="label label-info">Partial Pay</span>';
                            ?>
                        </td>
                        <td style="white-space:nowrap;">
                            <button type="button" class="btn btn-info btn-view-record"
                                data-id="<?php echo $r->id ?>"
                                title="View Details" style="padding:5px 10px !important">
                                <i class="fa fa-eye" style="color:white !important"></i>    
                            </button>
                            <button type="button" class="btn btn-warning btn-edit-record"
                                data-id="<?php echo $r->id ?>"
                                title="Edit Record" style="padding:5px 10px !important">
                                <i class="fa fa-pencil" style="color:white !important"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-delete-record"
                                data-id="<?php echo $r->id ?>"
                                data-name="<?php echo htmlspecialchars($r->name_en) ?>"
                                title="Delete Record" style="padding:5px 10px !important">
                                <i class="fa fa-trash" style="color:white !important"></i>
                            </button>
                        </td>
                    </tr>
                    <?php }} else {?>
                    <tr>
                        <td colspan="11">Records not Found</td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>

<!-- ===================== VIEW MODAL ===================== -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#0177bc; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title text-white font-weight-bold" id="viewModalLabel" ><b>Advance Salary Details</b></h4>
            </div>
            <div class="modal-body" id="view-modal-body">
                <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== EDIT MODAL (single) ===================== -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#f0ad4e; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editModalLabel"><i class="fa fa-pencil"></i> Edit Advance Salary</h4>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" id="edit_name_en" class="form-control input-sm" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee ID</label>
                                <input type="text" id="edit_emp_id" class="form-control input-sm" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loan Amount</label>
                                <input type="number" step="0.01" id="edit_loan_amt" name="loan_amt" class="form-control input-sm" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pay Amount</label>
                                <input type="number" step="0.01" id="edit_pay_amt" name="pay_amt" class="form-control input-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loan Month</label>
                                <input type="month" id="edit_loan_month" name="loan_month" class="form-control input-sm" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Effect Month</label>
                                <input type="month" id="edit_effect_month" name="effect_month" class="form-control input-sm">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Loan Status</label>
                                <select id="edit_loan_status" name="loan_status" class="form-control input-sm" required>
                                    <option value="1">Not Pay</option>
                                    <option value="2">Full Pay</option>
                                    <option value="3">Partial Pay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select id="edit_status" name="status" class="form-control input-sm" required>
                                    <option value="1">Open</option>
                                    <option value="2">Close</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="btn-save-edit"><i class="fa fa-floppy-o"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===================== BULK EDIT MODAL ===================== -->
<div class="modal fade" id="bulkEditModal" tabindex="-1" role="dialog" aria-labelledby="bulkEditModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#337ab7; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="bulkEditModalLabel" style="color: #fff;font-weight: bold;"><i class="fa fa-edit"></i> Bulk Edit – Advance Salary</h4>
            </div>
            <div class="modal-body" style="padding:10px;">
                <p class="text-muted" style="font-size:12px;margin-bottom:8px;">
                    Edit <strong>Pay Amount</strong>, <strong>Loan Status</strong>, and <strong>Status</strong> for the selected employees and click <em>Save All</em>.
                </p>
                <div style="overflow-x:auto;">
                    <table class="table table-bordered table-condensed" id="bulkEditTable" style="font-size:13px;min-width:700px;">
                        <thead style="background:#f0f4f8;">
                            <tr>
                                <th  style="width:40px;vertical-align: middle;">#</th>
                                <th style="vertical-align: middle;">Emp ID</th>
                                <th style="vertical-align: middle;">Emp Name</th>
                                <th style="vertical-align: middle;">Loan Amount</th>
                                <th style="min-width:110px;vertical-align: middle;">Pay Amount <span class="text-danger">*</span></th>
                                <th style="min-width:140px;vertical-align: middle;">
                                    Loan Status <span class="text-danger">*</span><br>
                                    <label style="font-size:10px; font-weight:normal; margin-bottom:0;"><input type="checkbox" id="bulk-set-full-pay"> Full</label>&nbsp;
                                    <label style="font-size:10px; font-weight:normal; margin-bottom:0;"><input type="checkbox" id="bulk-set-partial-pay"> Partial</label>
                                </th>
                                <th style="min-width:120px;">
                                    Status <span class="text-danger">*</span><br>
                                    <label style="font-size:10px; font-weight:normal; margin-bottom:0;"><input type="checkbox" id="bulk-set-open"> Open</label>&nbsp;
                                    <label style="font-size:10px; font-weight:normal; margin-bottom:0;"><input type="checkbox" id="bulk-set-close"> Close</label>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="bulkEditTbody">
                            <!-- Filled by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn-save-bulk">
                    <i class="fa fa-save"></i> Save All
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== DELETE CONFIRM MODAL ===================== -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#d9534f; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="deleteModalLabel"><i class="fa fa-trash"></i> Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the advance salary record for <strong id="delete-emp-name"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-delete"><i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
// ---- Search type toggle (Date Range vs Month) ----
function setSearchType(type) {
    $('#search_type').val(type);
    if (type === 'month') {
        $('#rangeInputs').hide();
        $('#rangeInputs input').prop('disabled', true);
        $('#monthInput').show();
        $('#monthInput input').prop('disabled', false);
        $('#btnTypeMonth').removeClass('btn-default').addClass('btn-info');
        $('#btnTypeRange').removeClass('btn-info').addClass('btn-default');
    } else {
        $('#monthInput').hide();
        $('#monthInput input').prop('disabled', true);
        $('#rangeInputs').show();
        $('#rangeInputs input').prop('disabled', false);
        $('#btnTypeRange').removeClass('btn-default').addClass('btn-info');
        $('#btnTypeMonth').removeClass('btn-info').addClass('btn-default');
    }
}

$(document).ready(function() {
    // Disable the inputs that are currently hidden so they don't pollute the GET params
    (function() {
        var type = $('#search_type').val();
        if (type === 'month') {
            $('#rangeInputs input').prop('disabled', true);
        } else {
            $('#monthInput input').prop('disabled', true);
        }
    })();
    oTable = $('#mytable').DataTable({
        columnDefs: [{ orderable: false, targets: 0 }],
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100]
    });
    $('#mytable_filter').css({"display": "none"});
    $('#deptSearch').keyup(function() {
        oTable.search($(this).val()).draw();
    });

    // ---- SELECT ALL checkbox (current page only) ----
    $('#checkAll').on('change', function() {
        var checked = $(this).prop('checked');
        oTable.rows({page: 'current'}).nodes().to$().find('.row-check').prop('checked', checked);
    });

    // Uncheck "select all" if any individual box unchecked (current page only)
    $(document).on('change', '.row-check', function() {
        var pageChecks = oTable.rows({page: 'current'}).nodes().to$().find('.row-check');
        $('#checkAll').prop('checked', pageChecks.filter(':not(:checked)').length === 0);
    });

    // Reset checkAll when page changes
    oTable.on('page.dt', function() {
        $('#checkAll').prop('checked', false);
    });

    // ---- BULK ACTION button ----
    $('#btn-bulk-action').on('click', function() {
        var selected = [];
        oTable.$('.row-check:checked').each(function() {
            selected.push({
                id:         $(this).data('id'),
                emp_id:     $(this).data('emp-id'),
                name:       $(this).data('name'),
                loan_amt:   $(this).data('loan-amt'),
                pay_amt:    $(this).data('pay-amt'),
                loan_status: $(this).data('loan-status'),
                status:     $(this).data('status')
            });
        });

        if (selected.length === 0) {
            alert('Please select at least one employee.');
            return;
        }

        openBulkEditModal(selected);
    });

    function openBulkEditModal(rows) {
        $('#bulk-set-full-pay, #bulk-set-partial-pay, #bulk-set-open, #bulk-set-close').prop('checked', false);
        var tbody = '';
        $.each(rows, function(i, r) {
            var lsOpts = '<option value="1"' + (r.loan_status == 1 ? ' selected' : '') + '>Not Pay</option>' +
                         '<option value="2"' + (r.loan_status == 2 ? ' selected' : '') + '>Full Pay</option>' +
                         '<option value="3"' + (r.loan_status == 3 ? ' selected' : '') + '>Partial Pay</option>';
            var stOpts = '<option value="1"' + (r.status == 1 ? ' selected' : '') + '>Open</option>' +
                         '<option value="2"' + (r.status == 2 ? ' selected' : '') + '>Close</option>';
            tbody += '<tr>' +
                '<td>' + (i + 1) + '</td>' +
                '<td>' + r.emp_id + '</td>' +
                '<td>' + r.name + '</td>' +
                '<td>' + parseFloat(r.loan_amt).toFixed(2) + '</td>' +
                '<td><input type="number" step="0.01" class="form-control input-sm bulk-pay-amt" style="min-width:90px;" value="' + parseFloat(r.pay_amt).toFixed(2) + '" data-id="' + r.id + '"></td>' +
                '<td><select class="form-control input-sm bulk-loan-status" data-id="' + r.id + '">' + lsOpts + '</select></td>' +
                '<td><select class="form-control input-sm bulk-status" data-id="' + r.id + '">' + stOpts + '</select></td>' +
            '</tr>';
        });
        $('#bulkEditTbody').html(tbody);
        $('#bulkEditModal').modal('show');
    }

    // ---- SAVE BULK ----
    $('#btn-save-bulk').on('click', function() {
        var records = [];
        var valid = true;

        $('#bulkEditTbody tr').each(function() {
            var id        = $(this).find('.bulk-pay-amt').data('id');
            var pay_amt   = $(this).find('.bulk-pay-amt').val();
            var loan_status = $(this).find('.bulk-loan-status').val();
            var status    = $(this).find('.bulk-status').val();

            if (!pay_amt || pay_amt === '') {
                valid = false;
                $(this).find('.bulk-pay-amt').addClass('has-error').css('border-color','red');
            } else {
                $(this).find('.bulk-pay-amt').removeClass('has-error').css('border-color','');
            }

            records.push({ id: id, pay_amt: pay_amt, loan_status: loan_status, status: status });
        });

        if (!valid) {
            alert('Please fill in all Pay Amount fields.');
            return;
        }

        var btn = $(this).prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: hostname + 'entry_system_con/advance_salary_bulk_update',
            type: 'POST',
            data: { records: JSON.stringify(records) },
            success: function(response) {
                $('#btn-save-bulk').prop('disabled', false).html('<i class="fa fa-save"></i> Save All');
                if (response === 'success') {
                    $('#bulkEditModal').modal('hide');
                    showMessage('success', 'Records updated successfully.');
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    showMessage('error', 'Update failed: ' + response);
                }
            },
            error: function() {
                $('#btn-save-bulk').prop('disabled', false).html('<i class="fa fa-save"></i> Save All');
                showMessage('error', 'Error updating records.');
            }
        });
    });

    // ---- VIEW button ----
    $(document).on('click', '.btn-view-record', function() {
        var id = $(this).data('id');
        $('#view-modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        $('#viewModal').modal('show');
        $.ajax({
            url: hostname + 'entry_system_con/advance_salary_get/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data) {
                    var statusLabel = '';
                    if (data.loan_status == 1) statusLabel = '<span class="label label-warning">Not Pay</span>';
                    else if (data.loan_status == 2) statusLabel = '<span class="label label-success" style="background-color: #28a745 !important;">Full Pay</span>';
                    else statusLabel = '<span class="label label-info">Partial Pay</span>';

                    var salaryType = data.salary_type ? data.salary_type : 'N/A';
                    var fromDate = data.from_date ? data.from_date : 'N/A';
                    var toDate = data.to_date ? data.to_date : 'N/A';
                    var loanDate = data.loan_date ? data.loan_date : 'N/A';

                    var thStyle = 'style="background:#f5f5f5;width:18%;white-space:nowrap;"';
                    var html = '<table class="table table-bordered table-condensed" style="font-size:13px;">' +
                        '<tr>' +
                            '<th ' + thStyle + '>Employee Name</th><td>' + (data.name_en || 'N/A') + '</td>' +
                            '<th ' + thStyle + '>Employee ID</th><td>' + (data.emp_id || 'N/A') + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Unit</th><td>' + (data.unit_name || 'N/A') + '</td>' +
                            '<th ' + thStyle + '>Salary Type</th><td>' + salaryType + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Loan Amount</th><td>' + parseFloat(data.loan_amt || 0).toFixed(2) + '</td>' +
                            '<th ' + thStyle + '>Pay Amount</th><td>' + parseFloat(data.pay_amt || 0).toFixed(2) + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Gross Salary</th><td>' + parseFloat(data.gross_salary || 0).toFixed(2) + '</td>' +
                            '<th ' + thStyle + '>OT Amount</th><td>' + parseFloat(data.ot_amt || 0).toFixed(2) + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Attendance Bonus</th><td>' + parseFloat(data.att_bouns || 0).toFixed(2) + '</td>' +
                            '<th ' + thStyle + '>Attend / Absent</th><td>' + (data.attend || 0) + ' / ' + (data.absent || 0) + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>From Date</th><td>' + fromDate + '</td>' +
                            '<th ' + thStyle + '>To Date</th><td>' + toDate + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Pay Days</th><td>' + (data.pay_days || 'N/A') + '</td>' +
                            '<th ' + thStyle + '>Loan Date</th><td>' + loanDate + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Loan Month</th><td>' + (data.loan_month || 'N/A') + '</td>' +
                            '<th ' + thStyle + '>Effect Month</th><td>' + (data.effect_month || 'N/A') + '</td>' +
                        '</tr>' +
                        '<tr>' +
                            '<th ' + thStyle + '>Loan Status</th><td colspan="3">' + statusLabel + '</td>' +
                        '</tr>' +
                        '</table>';
                    $('#view-modal-body').html(html);
                } else {
                    $('#view-modal-body').html('<div class="alert alert-danger">Record not found.</div>');
                }
            },
            error: function() {
                $('#view-modal-body').html('<div class="alert alert-danger">Error loading record.</div>');
            }
        });
    });

    // ---- EDIT button (single) ----
    $(document).on('click', '.btn-edit-record', function() {
        var id = $(this).data('id');
        $.ajax({
            url: hostname + 'entry_system_con/advance_salary_get/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data) {
                    $('#edit_id').val(data.id);
                    $('#edit_name_en').val(data.name_en || '');
                    $('#edit_emp_id').val(data.emp_id || '');
                    $('#edit_loan_amt').val(data.loan_amt || '');
                    $('#edit_pay_amt').val(data.pay_amt || '');
                    // Format to YYYY-MM for month inputs
                    if (data.loan_month) {
                        $('#edit_loan_month').val(data.loan_month.substring(0, 7));
                    }
                    if (data.effect_month) {
                        $('#edit_effect_month').val(data.effect_month.substring(0, 7));
                    }
                    $('#edit_loan_status').val(data.loan_status || '1');
                    $('#edit_status').val(data.status || '1');
                    $('#editModal').modal('show');
                } else {
                    alert('Record not found.');
                }
            },
            error: function() {
                alert('Error loading record.');
            }
        });
    });

    // ---- SAVE EDIT (single) ----
    $('#btn-save-edit').click(function() {
        var id          = $('#edit_id').val();
        var loan_amt    = $('#edit_loan_amt').val();
        var pay_amt     = $('#edit_pay_amt').val();
        var loan_month  = $('#edit_loan_month').val();
        var effect_month = $('#edit_effect_month').val();
        var loan_status = $('#edit_loan_status').val();
        var status      = $('#edit_status').val();

        if (!loan_amt || !pay_amt || !loan_month) {
            alert('Please fill all required fields.');
            return;
        }

        $.ajax({
            url: hostname + 'entry_system_con/advance_salary_update',
            type: 'POST',
            data: {
                id: id,
                loan_amt: loan_amt,
                pay_amt: pay_amt,
                loan_month: loan_month,
                effect_month: effect_month,
                loan_status: loan_status,
                status: status
            },
            success: function(response) {
                if (response === 'success') {
                    $('#editModal').modal('hide');
                    showMessage('success', 'Record updated successfully.');
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    showMessage('error', 'Update failed: ' + response);
                }
            },
            error: function() {
                showMessage('error', 'Error updating record.');
            }
        });
    });

    // ---- DELETE button ----
    $(document).on('click', '.btn-delete-record', function() {
        var id   = $(this).data('id');
        var name = $(this).data('name');
        $('#delete_id').val(id);
        $('#delete-emp-name').text(name);
        $('#deleteModal').modal('show');
    });

    // ---- CONFIRM DELETE ----
    $('#btn-confirm-delete').click(function() {
        var id = $('#delete_id').val();
        $.ajax({
            url: hostname + 'entry_system_con/advance_salary_delete_by_id',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                if (response === 'success') {
                    $('#deleteModal').modal('hide');
                    showMessage('success', 'Record deleted successfully.');
                    setTimeout(function() { location.reload(); }, 1500);
                } else {
                    showMessage('error', 'Delete failed: ' + response);
                }
            },
            error: function() {
                showMessage('error', 'Error deleting record.');
            }
        });
    });

    // ---- BULK EDIT GLOBAL CHECKBOXES ----
    $('#bulk-set-full-pay').change(function() {
        if ($(this).is(':checked')) {
            $('#bulk-set-partial-pay').prop('checked', false);
            $('.bulk-loan-status').val('2');
        }
    });
    $('#bulk-set-partial-pay').change(function() {
        if ($(this).is(':checked')) {
            $('#bulk-set-full-pay').prop('checked', false);
            $('.bulk-loan-status').val('3');
        }
    });
    $('#bulk-set-open').change(function() {
        if ($(this).is(':checked')) {
            $('#bulk-set-close').prop('checked', false);
            $('.bulk-status').val('1');
        }
    });
    $('#bulk-set-close').change(function() {
        if ($(this).is(':checked')) {
            $('#bulk-set-open').prop('checked', false);
            $('.bulk-status').val('2');
        }
    });
});
</script>
