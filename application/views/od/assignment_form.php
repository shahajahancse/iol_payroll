<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit     = isset($od) && !empty($od);
$od_id       = $is_edit ? $od->id : 0;
$sel_emp_id  = $is_edit ? $od->emp_id : '';
$start_val   = ($is_edit && !empty($od->start_date)) ? $od->start_date : date('Y-m-d');
$end_val     = ($is_edit && !empty($od->end_date)) ? $od->end_date : date('Y-m-d');
$purpose_val = $is_edit ? $od->purpose : '';
$remarks_val = $is_edit ? $od->remarks : '';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) SIMPLIFIED CREATE / EDIT FORM                           */
/* ========================================================================= */
.od-simple-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 60px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    min-height: calc(100vh - 100px);
    background-color: transparent;
}

.od-container {
    max-width: 780px;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
    overflow: hidden;
    margin-top: 10px;
    padding: 10px 20px
}

/* Header Banner */
.od-card-header {
    background: transparent;
    border: none;
    border-radius: 0;
    padding: 0 0 18px 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.od-header-title-box {
    display: flex;
    align-items: center;
    gap: 14px;
}
.od-icon-badge {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    flex-shrink: 0;
}
.od-header-text h2 {
    margin: 0 0 3px 0;
    font-size: 19px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.2px;
}
.od-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}

/* Back Link Button */
.btn-back-link {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}

/* Form Body Card */
.od-card-body {
    background: transparent;
    border: none;
    border-radius: 0;
    padding: 0;
    box-shadow: none;
}

.form-group-item {
    margin-bottom: 22px;
}
.form-group-label {
    font-size: 13.5px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.form-group-label .req {
    color: #ef4444;
    margin-left: 2px;
}

/* Custom Controls */
.input-custom {
    width: 100%;
    height: 42px;
    padding: 8px 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 14px;
    color: #1e293b;
    background: #ffffff;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    box-shadow: none;
    box-sizing: border-box;
}
.input-custom:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
}
textarea.input-custom {
    height: auto;
    min-height: 75px;
    resize: vertical;
}

/* Employee Search & Selector */
.emp-search-container {
    position: relative;
}
.emp-search-input-wrap {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
}
.emp-search-input-wrap i.search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 15px;
    pointer-events: none;
    z-index: 2;
}
.emp-search-input-wrap .input-custom,
#emp_search_input {
    padding-left: 42px !important;
    padding-right: 40px !important;
}
.emp-search-input-wrap .clear-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
    display: none;
    z-index: 3;
}
.emp-search-input-wrap .clear-btn:hover {
    color: #ef4444;
}

/* Search Dropdown */
.emp-search-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    z-index: 1050;
    max-height: 260px;
    overflow-y: auto;
    display: none;
    margin-top: 4px;
}
.emp-dropdown-item {
    padding: 10px 14px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: background 0.15s;
}
.emp-dropdown-item:hover {
    background: #f0f9ff;
}
.emp-dropdown-item:last-child {
    border-bottom: none;
}
.emp-item-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 13.5px;
}
.emp-item-details {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 2px;
}
.emp-item-unit {
    background: #e0f2fe;
    color: #0369a1;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
    white-space: nowrap;
}

/* Selected Employee Badge */
.emp-selected-card {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 10px;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.emp-selected-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.emp-selected-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.emp-selected-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}
.emp-selected-sub {
    font-size: 12px;
    color: #64748b;
    margin-top: 2px;
}
.btn-change-emp {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    white-space: nowrap;
}
.btn-change-emp:hover {
    background: #fee2e2;
    border-color: #fca5a5;
    color: #b91c1c;
}

/* Date Range Grid */
.date-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}
@media (max-width: 600px) {
    .date-grid {
        grid-template-columns: 1fr;
    }
}
.days-pill {
    font-size: 12px;
    font-weight: 600;
    color: #0369a1;
    background: #e0f2fe;
    padding: 3px 9px;
    border-radius: 14px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Conflict Alert */
.conflict-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    border-radius: 8px;
    padding: 10px 14px;
    margin-top: 10px;
    display: none;
    font-size: 12.5px;
}


/* Footer Submit Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    margin-top: 18px;
    padding-top: 0;
    border: none;
    background: transparent;
}
.btn-save-od {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    transition: all 0.2s;
}
.btn-save-od:hover {
    box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
    transform: translateY(-1px);
}
.btn-cancel-link {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 10px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel-link:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}
</style>

<div class="content od-simple-wrapper ">
    <div class="od-container">

        <!-- Header Card -->
        <div class="od-card-header">
            <div class="od-header-title-box">
                <div class="od-icon-badge">
                    <i class="fa fa-briefcase"></i>
                </div>
                <div class="od-header-text">
                    <h2><?= $is_edit ? 'Edit Outside Duty (OD) #' . $od_id : 'Assign Outside Duty (OD)' ?></h2>
                    <p>Enter employee, date range, purpose, and remarks</p>
                </div>
            </div>
            <div>
                <a href="<?= base_url('od_management_con/list') ?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> OD List
                </a>
            </div>
        </div>

        <!-- Form Card Body -->
        <div class="od-card-body">
            <form id="odSimpleForm" autocomplete="off">
                <input type="hidden" name="od_id" id="od_id" value="<?= $od_id ?>">
                <input type="hidden" name="emp_id" id="emp_id" value="<?= htmlspecialchars($sel_emp_id) ?>">
                <input type="hidden" name="status" value="approved">

                <!-- 1. Employee Selection -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Select Employee <span class="req">*</span></span>
                    </label>

                    <!-- Search Input Box (Shown when no employee selected) -->
                    <div class="emp-search-container" id="emp_search_box" style="<?= !empty($employee) ? 'display:none;' : '' ?>">
                        <div class="emp-search-input-wrap">
                            <i class="fa fa-search search-icon"></i>
                            <input type="text" class="input-custom" id="emp_search_input"
                                   style="padding-left: 42px !important; padding-right: 40px !important;"
                                   placeholder="Type Employee ID or Name (e.g. 1001, Rahim)..."
                                   value="" autocomplete="off">
                            <button type="button" class="clear-btn" id="btn_clear_search">&times;</button>
                        </div>
                        <div class="emp-search-dropdown" id="emp_dropdown_results"></div>
                        <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                            Search by Employee ID or Name, or type exact ID and press Enter
                        </small>
                    </div>

                    <!-- Selected Employee Badge (Shown when an employee is chosen) -->
                    <div class="emp-selected-card" id="emp_selected_badge" style="<?= empty($employee) ? 'display:none;' : '' ?>">
                        <div class="emp-selected-left">
                            <div class="emp-selected-avatar" id="prev_avatar">
                                <?= isset($employee) ? strtoupper(substr($employee->name_en, 0, 2)) : 'EM' ?>
                            </div>
                            <div>
                                <div class="emp-selected-title" id="prev_emp_title">
                                    <?= isset($employee) ? htmlspecialchars($employee->emp_id . ' - ' . $employee->name_en) : '' ?>
                                </div>
                                <div class="emp-selected-sub" id="prev_emp_sub">
                                    <?= isset($employee) ? htmlspecialchars(($employee->desig_name ?: '-') . ' | ' . ($employee->dept_name ?: '-') . ' (' . ($employee->unit_name ?: '-') . ')') : '' ?>
                                </div>
                            </div>
                        </div>
                        <?php if (!$is_edit): ?>
                        <button type="button" class="btn-change-emp" id="btn_change_employee">
                            <i class="fa fa-refresh"></i> Change
                        </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- 2. Date Range: Start Date & End Date -->
                <div class="form-group-item">
                    <div class="date-grid">
                        <div>
                            <label class="form-group-label">
                                <span>Start Date <span class="req">*</span></span>
                            </label>
                            <input type="date" class="input-custom" name="start_date" id="start_date"
                                   value="<?= $start_val ?>" required>
                        </div>
                        <div>
                            <label class="form-group-label">
                                <span>End Date <span class="req">*</span></span>
                                <span class="days-pill" id="days_badge"><i class="fa fa-calendar-check-o"></i> 1 Day</span>
                            </label>
                            <input type="date" class="input-custom" name="end_date" id="end_date"
                                   value="<?= $end_val ?>" required>
                        </div>
                    </div>

                    <!-- Schedule Conflict Box -->
                    <div class="conflict-alert" id="conflict_alert_box">
                        <i class="fa fa-exclamation-triangle"></i> <strong>Schedule Conflict Alert:</strong>
                        <div id="conflict_message_text" style="margin-top:3px;"></div>
                    </div>
                </div>

                <!-- 3. Purpose (Single Text Field) -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Purpose <span class="req">*</span></span>
                    </label>
                    <input type="text" class="input-custom" name="purpose" id="purpose" required
                           placeholder="Enter OD purpose (e.g. Client Meeting, Bank Work, Field Inspection, Official Tour...)"
                           value="<?= htmlspecialchars($purpose_val) ?>">
                </div>

                <!-- 4. Remark -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Remark / Note <span style="font-weight:normal; color:#64748b; font-size:12px;">(Optional)</span></span>
                    </label>
                    <textarea class="input-custom" name="remarks" id="remarks" rows="2"
                              placeholder="Enter any additional notes or remarks..."><?= htmlspecialchars($remarks_val) ?></textarea>
                </div>


                <!-- Footer Buttons -->
                <div class="form-actions">
                    <a href="<?= base_url('od_management_con/list') ?>" class="btn-cancel-link">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-save-od" id="btn_submit_od">
                        <i class="fa fa-check"></i> <?= $is_edit ? 'Update Outside Duty' : 'Save Outside Duty' ?>
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>

<script>
$(document).ready(function() {

    // 1. Calculate OD Days Pill & Trigger Conflict Check
    function updateDaysCount() {
        var s = $('#start_date').val();
        var e = $('#end_date').val();
        if (!s) return;
        if (!e) {
            $('#end_date').val(s);
            e = s;
        }
        var d1 = new Date(s);
        var d2 = new Date(e);
        if (d2 < d1) {
            $('#days_badge').html('<span style="color:#ef4444;"><i class="fa fa-exclamation-circle"></i> End < Start</span>');
            return;
        }
        var diff = Math.ceil(Math.abs(d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
        $('#days_badge').html('<i class="fa fa-calendar-check-o"></i> <strong>' + diff + '</strong> Day' + (diff > 1 ? 's' : ''));
        checkConflicts();
    }

    // Auto adjust end_date if start_date changes
    var prevStartDate = $('#start_date').val();
    $('#start_date').on('change', function() {
        var newStart = $(this).val();
        var currentEnd = $('#end_date').val();
        if (!currentEnd || currentEnd === prevStartDate || currentEnd < newStart) {
            $('#end_date').val(newStart);
        }
        prevStartDate = newStart;
        updateDaysCount();
    });

    $('#end_date').on('change', function() {
        updateDaysCount();
    });

    updateDaysCount();

    // 2. Real-time Conflict Check
    function checkConflicts() {
        var empId = $('#emp_id').val();
        var s = $('#start_date').val();
        var e = $('#end_date').val() || s;
        if (!empId || !s || !e) {
            $('#conflict_alert_box').hide();
            return;
        }
        var d1 = new Date(s);
        var d2 = new Date(e);
        if (d2 < d1) return;

        var dates = [];
        var cur = new Date(s);
        while (cur <= d2) {
            var y = cur.getFullYear();
            var m = String(cur.getMonth() + 1).padStart(2, '0');
            var d = String(cur.getDate()).padStart(2, '0');
            dates.push(y + '-' + m + '-' + d);
            cur.setDate(cur.getDate() + 1);
        }

        $.ajax({
            url: '<?= base_url("od_management_con/check_conflicts_ajax") ?>',
            type: 'POST',
            data: {
                emp_id: empId,
                dates: dates,
                exclude_id: $('#od_id').val()
            },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.has_conflict) {
                    var msgs = [];
                    if (res.conflicts.existing_ods && res.conflicts.existing_ods.length > 0) {
                        res.conflicts.existing_ods.forEach(function(o) {
                            msgs.push('Existing OD on <strong>' + o.date + '</strong> (' + o.status + ')');
                        });
                    }
                    if (res.conflicts.leaves && res.conflicts.leaves.length > 0) {
                        res.conflicts.leaves.forEach(function(l) {
                            msgs.push('Approved Leave on <strong>' + l.date + '</strong> (' + l.leave_type + ')');
                        });
                    }
                    $('#conflict_message_text').html(msgs.join('<br>'));
                    $('#conflict_alert_box').slideDown(150);
                } else {
                    $('#conflict_alert_box').slideUp(150);
                }
            }
        });
    }

    // 3. Employee Search & Selection Logic
    var searchTimer = null;
    $('#emp_search_input').on('keyup', function(e) {
        var term = $(this).val().trim();
        if (term.length > 0) {
            $('#btn_clear_search').show();
        } else {
            $('#btn_clear_search').hide();
        }

        // On Enter, try exact lookup
        if (e.keyCode === 13) {
            e.preventDefault();
            lookupExactEmployee(term);
            return;
        }

        clearTimeout(searchTimer);
        if (term.length < 1) {
            $('#emp_dropdown_results').hide();
            return;
        }

        searchTimer = setTimeout(function() {
            $.ajax({
                url: '<?= base_url("od_management_con/employee_search_ajax") ?>',
                type: 'POST',
                data: { q: term },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        var html = '';
                        res.data.forEach(function(emp) {
                            var sub = (emp.desig_name || '-') + ' | ' + (emp.dept_name || '-');
                            html += '<div class="emp-dropdown-item" data-emp=\'' + JSON.stringify(emp).replace(/'/g, "&apos;") + '\'>' +
                                    '<div>' +
                                    '<div class="emp-item-name">' + emp.emp_id + ' - ' + emp.name_en + '</div>' +
                                    '<div class="emp-item-details">' + sub + '</div>' +
                                    '</div>' +
                                    '<span class="emp-item-unit">' + (emp.unit_name || '') + '</span>' +
                                    '</div>';
                        });
                        $('#emp_dropdown_results').html(html).show();
                    } else {
                        $('#emp_dropdown_results').html('<div style="padding:10px 14px; color:#64748b; font-size:12px;">No employees found matching "' + term + '"</div>').show();
                    }
                }
            });
        }, 250);
    });

    // Clear search input
    $('#btn_clear_search').on('click', function() {
        $('#emp_search_input').val('').focus();
        $(this).hide();
        $('#emp_dropdown_results').hide();
    });

    // Select employee from dropdown
    $(document).on('click', '.emp-dropdown-item', function() {
        var empData = $(this).attr('data-emp');
        if (empData) {
            var emp = JSON.parse(empData);
            setEmployeeSelected(emp);
        }
    });

    function lookupExactEmployee(empId) {
        if (!empId) return;
        $.ajax({
            url: '<?= base_url("od_management_con/employee_info_ajax") ?>',
            type: 'POST',
            data: { emp_id: empId },
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success' && res.data) {
                    setEmployeeSelected(res.data);
                }
            }
        });
    }

    function setEmployeeSelected(emp) {
        $('#emp_id').val(emp.emp_id);
        var initials = emp.name_en ? emp.name_en.substring(0, 2).toUpperCase() : 'EM';
        $('#prev_avatar').text(initials);
        $('#prev_emp_title').text(emp.emp_id + ' - ' + (emp.name_en || ''));
        var sub = (emp.desig_name || '-') + ' | ' + (emp.dept_name || '-') + ' (' + (emp.unit_name || '-') + ')';
        $('#prev_emp_sub').text(sub);

        $('#emp_dropdown_results').hide();
        $('#emp_search_box').hide();
        $('#emp_selected_badge').slideDown(150);

        checkConflicts();
    }

    // Change / Clear selected employee
    $('#btn_change_employee').on('click', function() {
        $('#emp_id').val('');
        $('#emp_selected_badge').hide();
        $('#emp_search_box').slideDown(150);
        $('#emp_search_input').val('').focus();
        $('#btn_clear_search').hide();
        $('#conflict_alert_box').hide();
    });

    // Hide dropdown on click outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#emp_search_box').length) {
            $('#emp_dropdown_results').hide();
        }
    });

    // 4. Form Submit Handler
    $('#odSimpleForm').on('submit', function(e) {
        e.preventDefault();

        var empId = $('#emp_id').val();
        if (!empId) {
            Swal.fire({
                title: 'Employee Required',
                text: 'Please search and select an employee first.',
                icon: 'warning',
                confirmButtonColor: '#0284c7'
            });
            $('#emp_search_input').focus();
            return false;
        }

        var startDate = $('#start_date').val();
        if (!startDate) {
            Swal.fire({
                title: 'Date Required',
                text: 'Please select start date.',
                icon: 'warning',
                confirmButtonColor: '#0284c7'
            });
            return false;
        }

        var endDate = $('#end_date').val() || startDate;
        if (endDate < startDate) {
            Swal.fire({
                title: 'Invalid Date Range',
                text: 'End date cannot be earlier than start date.',
                icon: 'warning',
                confirmButtonColor: '#0284c7'
            });
            return false;
        }

        var purpose = $('#purpose').val().trim();
        if (!purpose) {
            Swal.fire({
                title: 'Purpose Required',
                text: 'Please enter the OD purpose.',
                icon: 'warning',
                confirmButtonColor: '#0284c7'
            });
            $('#purpose').focus();
            return false;
        }

        var btn = $('#btn_submit_od');
        var origHtml = btn.html();
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html(origHtml);
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'OD Saved Successfully!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'Go to OD List',
                        showCancelButton: true,
                        cancelButtonText: 'Add Another OD',
                        confirmButtonColor: '#0284c7',
                        cancelButtonColor: '#64748b'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url("od_management_con/list") ?>';
                        } else {
                            window.location.href = '<?= base_url("od_management_con/create") ?>';
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Cannot Save OD',
                        html: res.message,
                        icon: 'error',
                        confirmButtonColor: '#0284c7'
                    });
                }
            },
            error: function() {
                btn.prop('disabled', false).html(origHtml);
                Swal.fire({
                    title: 'Server Error',
                    text: 'An unexpected server error occurred. Please try again.',
                    icon: 'error',
                    confirmButtonColor: '#0284c7'
                });
            }
        });
    });

});
</script>
