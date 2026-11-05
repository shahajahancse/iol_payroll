<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
.reg-wrapper,
.page-content .reg-wrapper,
.page-content .content.reg-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 50px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    background-color: transparent;
    min-height: calc(100vh - 100px);
}
.reg-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
}
.reg-card-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafbfc;
}
.reg-card-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 10px;
}
.reg-card-body {
    padding: 24px;
}
.form-label {
    font-weight: 600;
    font-size: 13px;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.form-control-reg {
    height: 40px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: 8px 12px;
    font-size: 13px;
    width: 100%;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.form-control-reg:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    outline: none;
}
.live-inspector-box {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;
    padding: 16px;
    margin-top: 10px;
    display: none;
}
.inspector-detected {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    margin-top: 6px;
}
.waiver-toggle-card {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 16px;
    margin-top: 15px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
}
.switch-label {
    font-weight: 700;
    font-size: 14px;
    color: #166534;
    margin: 0 0 4px 0;
}
.switch-desc {
    font-size: 12px;
    color: #15803d;
    margin: 0;
}
</style>

<div class="content reg-wrapper">
    <div class="reg-card" style="max-width: 900px; margin: 0 auto;">
        <div class="reg-card-header">
            <h3><i class="fa fa-pencil-square-o text-primary"></i> Add Attendance Regularization & Remark</h3>
            <a href="<?= base_url('attn_regularization/dashboard') ?>" class="btn btn-default btn-sm" style="font-weight:600;">
                <i class="fa fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        <div class="reg-card-body">
            <form id="regForm" method="post" action="<?= base_url('attn_regularization/save') ?>">
                
                <div class="row">
                    <!-- Unit Selection -->
                    <div class="col-md-6" style="margin-bottom:16px;">
                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                        <select name="unit_id" id="unit_id" class="form-control-reg" required>
                            <?php if (!empty($units)) { foreach ($units as $u) { ?>
                                <option value="<?= $u->unit_id ?>"><?= $u->unit_name ?></option>
                            <?php }} ?>
                        </select>
                    </div>

                    <!-- Employee ID -->
                    <div class="col-md-6" style="margin-bottom:16px;">
                        <label class="form-label">
                            Employee ID <span class="text-danger">*</span>
                            <small class="text-muted" style="float:right;">(Type ID e.g. 2001 or comma-separated)</small>
                        </label>
                        <input type="text" name="emp_id" id="emp_id" class="form-control-reg" placeholder="Enter Employee ID (e.g. 2001)" required autocomplete="off">
                    </div>
                </div>

                <div class="row">
                    <!-- Date -->
                    <div class="col-md-6" style="margin-bottom:16px;">
                        <label class="form-label">Attendance Date <span class="text-danger">*</span></label>
                        <input type="date" name="att_date" id="att_date" class="form-control-reg" value="<?= date('Y-m-d') ?>" required>
                    </div>

                    <!-- End Date (Optional for date range) -->
                    <div class="col-md-6" style="margin-bottom:16px;">
                        <label class="form-label">
                            To Date <small class="text-muted">(Optional - leave empty for single date)</small>
                        </label>
                        <input type="date" name="end_date" id="end_date" class="form-control-reg" placeholder="Optional end date">
                    </div>
                </div>

                <!-- Live Attendance Inspector Result Box -->
                <div id="inspectorBox" class="live-inspector-box">
                    <div style="display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid #e2e8f0; padding-bottom:8px; margin-bottom:8px;">
                        <div>
                            <strong id="inspEmpName" style="color:#0f172a; font-size:14px;">-</strong>
                            <span id="inspEmpDept" style="color:#64748b; font-size:12px; margin-left:8px;">-</span>
                        </div>
                        <span id="inspBadge" class="inspector-detected">-</span>
                    </div>
                    <div class="row" style="font-size:12px;">
                        <div class="col-md-3">
                            <strong>Shift:</strong> <span id="inspShift">-</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Recorded In:</strong> <span id="inspInTime" style="font-family:monospace; font-weight:600;">-</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Recorded Out:</strong> <span id="inspOutTime" style="font-family:monospace; font-weight:600;">-</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Status:</strong> <span id="inspStatus">-</span>
                        </div>
                    </div>
                </div>

                <hr style="margin:20px 0; border-top:1px solid #f1f5f9;">

                <div class="row">
                    <!-- Issue Type -->
                    <div class="col-md-6" style="margin-bottom:16px;">
                        <label class="form-label">Issue Type <span class="text-danger">*</span></label>
                        <select name="issue_type" id="issue_type" class="form-control-reg" required>
                            <option value="late">Late Office Entry</option>
                            <option value="early_out">Early Out (Left Before Shift End)</option>
                            <option value="punch_error">Punch Miss / Machine Error</option>
                            <option value="general">General Regularization</option>
                        </select>
                    </div>

                    <!-- Reason Category Preset -->
                    <div class="col-md-6" style="margin-bottom:16px;">
                        <label class="form-label">Reason Category <span class="text-danger">*</span></label>
                        <select name="reason_type" id="reason_type" class="form-control-reg" required>
                            <option value="Official Duty / Client Visit">Official Duty / Client Visit</option>
                            <option value="HOD / Management Permission">HOD / Management Permission</option>
                            <option value="Punch Machine / Biometric Error">Punch Machine / Biometric Error</option>
                            <option value="Traffic / Transport Delay">Traffic / Transport Delay</option>
                            <option value="Emergency / Personal Issue">Emergency / Personal Issue</option>
                            <option value="Medical / Sickness">Medical / Sickness</option>
                            <option value="Power Outage / Technical Glitch">Power Outage / Technical Glitch</option>
                            <option value="Others">Others (Specify in remarks)</option>
                        </select>
                    </div>
                </div>

                <!-- Detailed Remarks -->
                <div style="margin-bottom:16px;">
                    <label class="form-label">
                        Remark / Explanation <span class="text-danger">*</span>
                        <small class="text-muted">(This explanation will be printed on the Employee Job Card)</small>
                    </label>
                    <textarea name="remarks" id="remarks" rows="2" class="form-control-reg" style="height:auto;" placeholder="Enter remark details (e.g. Permission given by Dept Head for client meeting)..." required></textarea>
                </div>

                <!-- Optional Punch Time Adjustment -->
                <div class="row" style="background:#f8fafc; border-radius:8px; padding:12px 6px; margin:0 0 16px 0;">
                    <div class="col-md-12" style="margin-bottom:8px;">
                        <small style="font-weight:700; color:#475569; text-transform:uppercase;">Optional: Adjust In/Out Times (For Missing Punch Correction)</small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Adjust In Time <small class="text-muted">(hh:mm:ss)</small></label>
                        <input type="text" name="adjusted_in_time" id="adjusted_in_time" class="form-control-reg" placeholder="09:00:00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Adjust Out Time <small class="text-muted">(hh:mm:ss)</small></label>
                        <input type="text" name="adjusted_out_time" id="adjusted_out_time" class="form-control-reg" placeholder="18:00:00">
                    </div>
                </div>

                <!-- Salary Deduction Waiver Checkbox / Toggle -->
                <div class="waiver-toggle-card">
                    <input type="checkbox" name="waive_deduction" id="waive_deduction" value="1" checked style="width:20px; height:20px; accent-color:#16a34a; cursor:pointer; margin-top:2px;">
                    <div>
                        <label for="waive_deduction" class="switch-label" style="cursor:pointer;">
                            Waive Late / Salary Deduction Penalty (বেতন কর্তন মওকুফ)
                        </label>
                        <p class="switch-desc">
                            When checked, this day will be <strong>completely excluded</strong> from the salary late deduction rule (3 days late = 1 day salary cut). Status will display as normal with the remark printed on the Job Card.
                        </p>
                    </div>
                </div>

                <div style="margin-top:24px; display:flex; justify-content:flex-end; gap:12px;">
                    <a href="<?= base_url('attn_regularization/list') ?>" class="btn btn-default" style="font-weight:600; padding:8px 20px;">Cancel</a>
                    <button type="submit" id="submitBtn" class="btn btn-primary" style="font-weight:700; padding:8px 26px;">
                        <i class="fa fa-check-circle"></i> Save Regularization
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    function inspectAttendance() {
        var emp_id = $('#emp_id').val().trim();
        var date   = $('#att_date').val();

        if (emp_id === '' || date === '' || emp_id.indexOf(',') !== -1) {
            $('#inspectorBox').hide();
            return;
        }

        $.ajax({
            url: '<?= base_url('attn_regularization/ajax_get_emp_attendance') ?>',
            type: 'GET',
            data: { emp_id: emp_id, date: date },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.employee) {
                    $('#inspectorBox').slideDown();
                    $('#inspEmpName').text(res.employee.emp_id + ' - ' + res.employee.name_en);
                    $('#inspEmpDept').text(res.employee.dept_name + ' (' + res.employee.desig_name + ')');

                    if (res.log) {
                        $('#inspShift').text(res.log.shift_name || 'Standard');
                        $('#inspInTime').text(res.log.in_time || '00:00:00');
                        $('#inspOutTime').text(res.log.out_time || '00:00:00');
                        $('#inspStatus').text(res.log.present_status || '-');

                        if (res.log.late_status == 1) {
                            $('#inspBadge').attr('class', 'inspector-detected badge-late')
                                           .html('<i class="fa fa-clock-o"></i> Detected: LATE (' + res.log.late_time + 'm)');
                            $('#issue_type').val('late');
                        } else if (res.log.early_exit == 1) {
                            $('#inspBadge').attr('class', 'inspector-detected badge-early')
                                           .html('<i class="fa fa-sign-out"></i> Detected: EARLY OUT');
                            $('#issue_type').val('early_out');
                        } else if (res.log.in_time === '00:00:00' || res.log.out_time === '00:00:00') {
                            $('#inspBadge').attr('class', 'inspector-detected badge-punch')
                                           .html('<i class="fa fa-exclamation-triangle"></i> Detected: PUNCH MISS');
                            $('#issue_type').val('punch_error');
                        } else {
                            $('#inspBadge').attr('class', 'inspector-detected badge-waived')
                                           .html('<i class="fa fa-check"></i> Status: Normal Present');
                        }
                    } else {
                        $('#inspShift').text('No shift log');
                        $('#inspInTime').text('--');
                        $('#inspOutTime').text('--');
                        $('#inspStatus').text('No record');
                        $('#inspBadge').attr('class', 'inspector-detected').text('No log found for this date');
                    }
                } else {
                    $('#inspectorBox').hide();
                }
            }
        });
    }

    $('#emp_id, #att_date').on('change blur', inspectAttendance);

    // Form submit via AJAX
    $('#regForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = $('#submitBtn');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Save Regularization');
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonColor: '#0284c7'
                    }).then(() => {
                        window.location.href = '<?= base_url('attn_regularization/list') ?>';
                    });
                } else {
                    Swal.fire({
                        title: 'Notice',
                        text: res.message,
                        icon: 'warning',
                        confirmButtonColor: '#0284c7'
                    });
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Save Regularization');
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred while saving. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        });
    });
});
</script>
