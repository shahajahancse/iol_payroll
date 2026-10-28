<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit       = isset($is_edit) && $is_edit;
$arrear_id     = ($is_edit && !empty($arrear)) ? $arrear->id : 0;
$sel_emp_id    = ($is_edit && !empty($arrear)) ? $arrear->emp_id : '';
$arr_month_val = ($is_edit && !empty($arrear)) ? date('Y-m', strtotime($arrear->arrear_month)) : date('Y-m', strtotime('-1 month'));
$pay_month_val = ($is_edit && !empty($arrear)) ? date('Y-m', strtotime($arrear->payment_month)) : date('Y-m');
$amount_val    = ($is_edit && !empty($arrear)) ? (float)$arrear->amount : '';
$remarks_val   = ($is_edit && !empty($arrear)) ? $arrear->remarks : '';
$status_val    = ($is_edit && !empty($arrear)) ? $arrear->status : 'Approved';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
body,
.page-container,
.page-content,
.arr-form-wrapper,
.page-content .arr-form-wrapper,
.page-content .content.arr-form-wrapper {
    background: #ffffff !important;
    background-color: #ffffff !important;
}

.arr-form-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 60px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    min-height: calc(100vh - 100px);
}

.arr-form-container {
    max-width: 780px;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    padding: 24px 28px;
}

/* Header */
.arr-form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f1f5f9;
    padding-bottom: 18px;
    margin-bottom: 22px;
    flex-wrap: wrap;
    gap: 12px;
}
.arr-header-title-box {
    display: flex;
    align-items: center;
    gap: 14px;
}
.arr-icon-badge {
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
.arr-header-text h2 {
    margin: 0 0 3px 0;
    font-size: 19px;
    font-weight: 700;
    color: #0f172a;
}
.arr-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}

.btn-back-link {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 7px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s;
}
.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}

/* Form Groups */
.form-group-item {
    margin-bottom: 18px;
}
.form-group-label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #334155;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.form-group-label .req {
    color: #ef4444;
}
.input-custom {
    width: 100%;
    height: 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    padding: 8px 12px;
    color: #0f172a;
    background: #ffffff;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.input-custom:focus {
    border-color: #0284c7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
}
.textarea-custom {
    width: 100%;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    padding: 10px 12px;
    color: #0f172a;
    background: #ffffff;
    resize: vertical;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.textarea-custom:focus {
    border-color: #0284c7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
}

/* Employee Search Box */
.emp-search-container {
    position: relative;
}
.emp-search-input-wrap {
    position: relative;
}
.emp-search-input-wrap .search-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 15px;
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
    display: none;
}
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
    max-height: 250px;
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
    font-size: 13px;
}
.emp-item-details {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 2px;
}

/* Selected Employee Card */
.emp-selected-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.emp-selected-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.emp-selected-avatar {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #0284c7;
    color: #ffffff;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}
.emp-selected-title {
    font-weight: 700;
    color: #0f172a;
    font-size: 13.5px;
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
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
    cursor: pointer;
}
.btn-change-emp:hover {
    background: #f1f5f9;
    color: #0f172a;
}

/* Buttons */
.form-action-bar {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    border-top: 1px solid #f1f5f9;
    padding-top: 18px;
    margin-top: 24px;
}
.btn-save-arr {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border: none;
    padding: 9px 22px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    transition: all 0.2s;
}
.btn-save-arr:hover {
    box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
    transform: translateY(-1px);
}
</style>

<div class="content arr-form-wrapper">
    <div class="arr-form-container">
        <!-- Header -->
        <div class="arr-form-header">
            <div class="arr-header-title-box">
                <div class="arr-icon-badge">
                    <i class="fa fa-money"></i>
                </div>
                <div class="arr-header-text">
                    <h2><?= $is_edit ? 'Edit Arrear Salary #' . $arrear_id : 'Add Arrear Salary Entry' ?></h2>
                    <p>Enter employee, arrear month, payment month, and amount</p>
                </div>
            </div>
            <div>
                <a href="<?= base_url('arrear_salary') ?>" class="btn-back-link">
                    <i class="fa fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Form Body -->
        <form id="arrearForm" autocomplete="off">
            <input type="hidden" name="id" id="arrear_id" value="<?= $arrear_id ?>">
            <input type="hidden" name="emp_id" id="emp_id" value="<?= htmlspecialchars($sel_emp_id) ?>">

            <!-- 1. Employee Selection -->
            <div class="form-group-item">
                <label class="form-group-label">
                    <span>Select Employee <span class="req">*</span></span>
                </label>

                <!-- Search Input Box -->
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

                <!-- Selected Employee Badge -->
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

            <input type="hidden" name="status" id="status" value="<?= htmlspecialchars($status_val) ?>">

            <!-- 2. Pay Month & Arrear Amount -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group-item">
                        <label class="form-group-label">
                            <span>Pay Month (Add To Payroll) <span class="req">*</span></span>
                        </label>
                        <input type="month" name="payment_month" id="payment_month" class="input-custom" value="<?= $pay_month_val ?>" required>
                        <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                            Select the payroll month in which this arrear will be paid.
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group-item">
                        <label class="form-group-label">
                            <span>Arrear Amount (৳) <span class="req">*</span></span>
                        </label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-weight:700; color:#64748b; font-size:15px;">৳</span>
                            <input type="number" step="0.01" min="0.01" name="amount" id="amount" class="input-custom" style="padding-left:30px !important; font-weight:700; font-size:15px;" placeholder="0.00" value="<?= $amount_val ?>" required>
                        </div>
                        <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                            Must be a positive monetary amount.
                        </small>
                    </div>
                </div>
            </div>

            <!-- 3. Remarks (Mention which month/months the arrear is for) -->
            <div class="form-group-item">
                <label class="form-group-label">
                    <span>Remarks (For which month/months) <span class="req">*</span></span>
                </label>
                <textarea name="remarks" id="remarks" rows="3" class="textarea-custom" placeholder="e.g. Arrear bill for January 2026 and February 2026 salary adjustment..." required><?= htmlspecialchars($remarks_val) ?></textarea>
                <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                    Write which month or months this arrear bill is for, or any other notes.
                </small>
            </div>

            <!-- Action Buttons -->
            <div class="form-action-bar">
                <a href="<?= base_url('arrear_salary') ?>" class="btn-back-link">
                    Cancel
                </a>
                <button type="submit" class="btn-save-arr" id="btn_submit">
                    <i class="fa fa-check-circle"></i> <?= $is_edit ? 'Update Arrear' : 'Save Arrear Salary' ?>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {
    // Search Autocomplete
    var searchTimer = null;
    $('#emp_search_input').on('keyup', function(e) {
        var term = $(this).val().trim();
        if (term.length > 0) {
            $('#btn_clear_search').show();
        } else {
            $('#btn_clear_search').hide();
        }

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
                url: '<?= base_url("arrear_salary/employee_search_ajax") ?>',
                type: 'POST',
                data: { q: term },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        var html = '';
                        res.data.forEach(function(emp) {
                            var sub = (emp.desig_name || '-') + ' | ' + (emp.dept_name || '-') + ' (' + (emp.unit_name || '-') + ')';
                            html += '<div class="emp-dropdown-item" data-emp=\'' + JSON.stringify(emp).replace(/'/g, "&apos;") + '\'>' +
                                    '<div>' +
                                    '<div class="emp-item-name">' + emp.emp_id + ' - ' + emp.name_en + '</div>' +
                                    '<div class="emp-item-details">' + sub + '</div>' +
                                    '</div>' +
                                    '<i class="fa fa-chevron-right" style="color:#cbd5e1; font-size:12px;"></i>' +
                                    '</div>';
                        });
                        $('#emp_dropdown_results').html(html).show();
                    } else {
                        $('#emp_dropdown_results').html('<div style="padding:12px; font-size:12.5px; color:#94a3b8; text-align:center;">No matching employee found</div>').show();
                    }
                }
            });
        }, 250);
    });

    // Select employee from dropdown
    $(document).on('click', '.emp-dropdown-item', function() {
        var dataStr = $(this).attr('data-emp');
        if (!dataStr) return;
        var emp = JSON.parse(dataStr);
        selectEmployee(emp);
    });

    function selectEmployee(emp) {
        $('#emp_id').val(emp.emp_id);
        var initials = (emp.name_en || 'EM').substring(0, 2).toUpperCase();
        $('#prev_avatar').text(initials);
        $('#prev_emp_title').text(emp.emp_id + ' - ' + emp.name_en);
        var sub = (emp.desig_name || '-') + ' | ' + (emp.dept_name || '-') + ' (' + (emp.unit_name || '-') + ')';
        $('#prev_emp_sub').text(sub);

        $('#emp_search_box').hide();
        $('#emp_selected_badge').show();
        $('#emp_dropdown_results').hide();
    }

    function lookupExactEmployee(empId) {
        if (!empId) return;
        $.ajax({
            url: '<?= base_url("arrear_salary/get_employee_ajax") ?>',
            type: 'POST',
            data: { emp_id: empId },
            dataType: 'json',
            success: function(res) {
                if (res.status && res.data) {
                    selectEmployee(res.data);
                } else {
                    Swal.fire('Not Found', 'Employee with ID "' + empId + '" was not found.', 'error');
                }
            }
        });
    }

    $('#btn_clear_search').on('click', function() {
        $('#emp_search_input').val('').focus();
        $(this).hide();
        $('#emp_dropdown_results').hide();
    });

    $('#btn_change_employee').on('click', function() {
        $('#emp_id').val('');
        $('#emp_selected_badge').hide();
        $('#emp_search_box').show();
        $('#emp_search_input').val('').focus();
    });

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.emp-search-container').length) {
            $('#emp_dropdown_results').hide();
        }
    });

    // Form Submit
    $('#arrearForm').on('submit', function(e) {
        e.preventDefault();

        var empId = $('#emp_id').val().trim();
        if (!empId) {
            Swal.fire('Required Field', 'Please select an employee.', 'warning');
            return;
        }

        var amount = parseFloat($('#amount').val());
        if (isNaN(amount) || amount <= 0) {
            Swal.fire('Invalid Amount', 'Please enter a valid positive arrear amount.', 'warning');
            return;
        }

        var btn = $('#btn_submit');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '<?= base_url("arrear_salary/save") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(resp) {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Save Arrear Salary');
                if (resp.status) {
                    Swal.fire({
                        title: 'Success!',
                        text: resp.message,
                        icon: 'success',
                        timer: 1600,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = resp.redirect || '<?= base_url("arrear_salary") ?>';
                    });
                } else {
                    Swal.fire('Error', resp.message || 'Failed to save arrear record.', 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> Save Arrear Salary');
                Swal.fire('Error', 'Server error occurred while saving.', 'error');
            }
        });
    });
});
</script>
