<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) LIST - EXECUTIVE THEME                                  */
/* ========================================================================= */
.page-content .content.od-list-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 50px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    background-color: transparent;
    min-height: calc(100vh - 100px);
}

/* Header Card */
.od-header-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.od-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.od-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    flex-shrink: 0;
}
.od-header-text h2 {
    margin: 0 0 4px 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.3px;
}
.od-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}
.od-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.btn-action-primary {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border: none;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 3px 10px rgba(2, 132, 199, 0.25);
    transition: all 0.2s;
}
.btn-action-primary:hover {
    background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
    color: #ffffff;
    text-decoration: none;
}
.btn-action-outline {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-action-outline:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}

/* Filters Card */
.filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px 22px;
    margin-bottom: 20px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
}
.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
    gap: 14px;
    align-items: flex-end;
}
.filter-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 5px;
}
.filter-input {
    width: 100%;
    padding: 8px 11px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    background: #ffffff;
    color: #1e293b;
    outline: none;
    transition: all 0.2s;
}
.filter-input:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
}
.filter-actions {
    display: flex;
    gap: 8px;
}
.btn-filter-apply {
    background: #0284c7;
    color: #ffffff;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-filter-apply:hover {
    background: #0369a1;
}
.btn-filter-reset {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-filter-reset:hover {
    background: #e2e8f0;
}

/* Table Card */
.table-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
}
.table-responsive-custom {
    width: 100%;
    overflow-x: auto;
}
.table-od {
    width: 100%;
    border-collapse: collapse;
    margin: 0;
    font-size: 13px;
}
.table-od th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.table-od td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    color: #334155;
}
.table-od tbody tr:hover {
    background: #f8fafc;
}
.table-od tbody tr:last-child td {
    border-bottom: none;
}

/* Badges & Status Pills */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: capitalize;
}
.status-pill.approved {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}
.status-pill.pending {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}
.status-pill.rejected {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}
.status-pill.cancelled {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #cbd5e1;
}

.attn-status-badge {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
}

/* Action Dropdown / Buttons */
.action-btn-group {
    display: flex;
    gap: 6px;
    align-items: center;
}
.btn-sm-action {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
}
.btn-sm-action:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}
.btn-sm-action.btn-approve {
    border-color: #86efac;
    color: #16a34a;
    background: #f0fdf4;
}
.btn-sm-action.btn-approve:hover {
    background: #16a34a;
    color: #ffffff;
}
.btn-sm-action.btn-reject {
    border-color: #fca5a5;
    color: #dc2626;
    background: #fef2f2;
}
.btn-sm-action.btn-reject:hover {
    background: #dc2626;
    color: #ffffff;
}

/* Pagination Footer */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    font-size: 13px;
    color: #64748b;
    flex-wrap: wrap;
    gap: 12px;
}
.pagination-controls {
    display: flex;
    gap: 6px;
    align-items: center;
}
.btn-page {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    padding: 5px 12px;
    border-radius: 6px;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.15s;
}
.btn-page:hover:not(:disabled) {
    background: #f1f5f9;
    border-color: #0284c7;
    color: #0284c7;
}
.btn-page.active {
    background: #0284c7;
    border-color: #0284c7;
    color: #ffffff;
}
.btn-page:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Modal styles */
.modal-header-custom {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-title-custom {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}
.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px 18px;
    margin-bottom: 16px;
}
.detail-item .lbl {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
}
.detail-item .val {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
    margin-top: 2px;
}
.audit-list {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px;
    max-height: 140px;
    overflow-y: auto;
    font-size: 12px;
}
.audit-item {
    margin-bottom: 6px;
    padding-bottom: 6px;
    border-bottom: 1px dashed #cbd5e1;
}
.audit-item:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}
</style>

<div class="content od-list-wrapper">

        <!-- Top Header Card -->
        <div class="od-header-card">
            <div class="od-header-left">
                <div class="od-header-icon">
                    <i class="fa fa-list-alt"></i>
                </div>
                <div class="od-header-text">
                    <h2>Outside Duty (OD) Assignments List</h2>
                    <p>Track, manage, and monitor all employee outside duty assignments and attendance statuses</p>
                </div>
            </div>
            <div class="od-header-actions">
                <a href="<?= base_url('od_management_con/create') ?>" class="btn-action-primary">
                    <i class="fa fa-plus"></i> Assign New OD
                </a>
                <button type="button" class="btn-action-outline" id="btn_export_csv" onclick="exportData('csv')">
                    <i class="fa fa-file-excel-o"></i> Export CSV
                </button>
                <button type="button" class="btn-action-outline" id="btn_print_list" onclick="exportData('print')">
                    <i class="fa fa-print"></i> Print Report
                </button>
                <button type="button" class="btn-action-outline" id="btn_refresh_list" onclick="loadOdList(1)">
                    <i class="fa fa-refresh"></i> Refresh
                </button>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="filter-card">
            <div class="filter-grid">
                <?php if (empty($unit_id) || $unit_id === 'All'): ?>
                <div class="filter-group">
                    <label>Branch / Unit</label>
                    <select class="filter-input" id="flt_unit">
                        <option value="">-- All Units --</option>
                        <?php if (!empty($units)): foreach ($units as $u): ?>
                            <option value="<?= $u->unit_id ?>"><?= htmlspecialchars($u->unit_name) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <?php endif; ?>

                <div class="filter-group">
                    <label>Department</label>
                    <select class="filter-input" id="flt_dept">
                        <option value="">-- All Departments --</option>
                        <?php if (!empty($departments)): foreach ($departments as $d): ?>
                            <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>OD Status</label>
                    <select class="filter-input" id="flt_status">
                        <option value="">-- All Statuses --</option>
                        <option value="pending">Pending Approval</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Purpose</label>
                    <select class="filter-input" id="flt_purpose">
                        <option value="">-- All Purposes --</option>
                        <?php if (!empty($od_purposes)): foreach ($od_purposes as $pval => $plbl): ?>
                            <option value="<?= htmlspecialchars($pval) ?>"><?= htmlspecialchars($pval) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>From Date</label>
                    <input type="date" class="filter-input" id="flt_from_date">
                </div>

                <div class="filter-group">
                    <label>To Date</label>
                    <input type="date" class="filter-input" id="flt_to_date">
                </div>

                <div class="filter-group">
                    <label>Employee ID / Name</label>
                    <input type="text" class="filter-input" id="flt_emp" placeholder="ID or Name...">
                </div>

                <div class="filter-actions">
                    <button type="button" class="btn-filter-apply" onclick="loadOdList(1)">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                    <button type="button" class="btn-filter-reset" onclick="resetFilters()">
                        <i class="fa fa-undo"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            <div class="table-responsive-custom">
                <table class="table-od" id="odListTable">
                    <thead>
                        <tr>
                            <th style="width:45px;">SL</th>
                            <th style="width:90px;">Emp ID</th>
                            <th>Employee Name</th>
                            <th>Department & Desig</th>
                            <th>OD Date(s)</th>
                            <th style="width:60px; text-align:center;">Days</th>
                            <th>Purpose & Location</th>
                            <th>Assigned By</th>
                            <th style="text-align:center;">Approval</th>
                            <th style="text-align:center;">Attendance</th>
                            <th style="text-align:center; width:110px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="odTableBody">
                        <tr>
                            <td colspan="11" style="text-align:center; padding:30px; color:#64748b;">
                                <i class="fa fa-spinner fa-spin"></i> Loading Outside Duty assignments...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination & Records Info -->
            <div class="table-footer">
                <div>
                    Showing <span id="lbl_start_idx">0</span> to <span id="lbl_end_idx">0</span> of <span id="lbl_total_records">0</span> records
                </div>
                <div class="pagination-controls" id="pagination_controls">
                    <!-- Dynamic page buttons -->
                </div>
            </div>
        </div>

    </div>

<!-- Modal: View Assignment Details -->
<div class="modal fade" id="modalViewOd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 15px 35px rgba(0,0,0,0.15);">
            <div class="modal-header-custom">
                <h4 class="modal-title-custom"><i class="fa fa-file-text-o" style="color:#0284c7;"></i> Outside Duty Assignment Details</h4>
                <button type="button" class="close" data-dismiss="modal" style="font-size:24px; color:#64748b; opacity:0.8;">&times;</button>
            </div>
            <div class="modal-body" style="padding:22px;" id="modal_view_body">
                <div style="text-align:center; padding:20px;"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
            </div>
            <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:8px;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Reject OD Reason -->
<div class="modal fade" id="modalRejectOd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none;">
            <div class="modal-header-custom" style="background:#fef2f2;">
                <h4 class="modal-title-custom" style="color:#b91c1c;"><i class="fa fa-times-circle"></i> Reject OD Assignment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <input type="hidden" id="reject_od_id">
                <p style="font-size:13px; color:#475569;">Please state the reason for rejecting this Outside Duty assignment:</p>
                <textarea class="form-control" id="reject_reason_text" rows="3" placeholder="Enter rejection reason..." style="border-radius:8px;"></textarea>
            </div>
            <div class="modal-footer" style="background:#f8fafc; padding:12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn_confirm_reject" onclick="confirmReject()">Confirm Rejection</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Cancel OD Reason -->
<div class="modal fade" id="modalCancelOd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none;">
            <div class="modal-header-custom" style="background:#f8fafc;">
                <h4 class="modal-title-custom" style="color:#475569;"><i class="fa fa-ban"></i> Cancel OD Assignment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <input type="hidden" id="cancel_od_id">
                <p style="font-size:13px; color:#475569;">Please state the reason for cancelling this assignment:</p>
                <textarea class="form-control" id="cancel_reason_text" rows="3" placeholder="Enter cancellation reason..." style="border-radius:8px;"></textarea>
            </div>
            <div class="modal-footer" style="background:#f8fafc; padding:12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-warning" id="btn_confirm_cancel" onclick="confirmCancel()">Confirm Cancellation</button>
            </div>
        </div>
    </div>
</div>

<script>
var currentPage = 1;
var pageLimit = 20;
var isAdmin = <?= $is_admin ? 'true' : 'false' ?>;

function getFilters() {
    return {
        unit_id: $('#flt_unit').length ? $('#flt_unit').val() : '',
        dept_id: $('#flt_dept').val(),
        status: $('#flt_status').val(),
        purpose: $('#flt_purpose').val(),
        from_date: $('#flt_from_date').val(),
        to_date: $('#flt_to_date').val(),
        emp_id: $('#flt_emp').val().trim()
    };
}

function resetFilters() {
    if ($('#flt_unit').length) $('#flt_unit').val('');
    $('#flt_dept').val('');
    $('#flt_status').val('');
    $('#flt_purpose').val('');
    $('#flt_from_date').val('');
    $('#flt_to_date').val('');
    $('#flt_emp').val('');
    loadOdList(1);
}

function loadOdList(page) {
    currentPage = page || 1;
    var params = getFilters();
    params.page = currentPage;
    params.limit = pageLimit;

    $('#odTableBody').html('<tr><td colspan="11" style="text-align:center; padding:30px; color:#64748b;"><i class="fa fa-spinner fa-spin"></i> Loading Outside Duty assignments...</td></tr>');

    $.ajax({
        url: '<?= base_url("od_management_con/list_ajax") ?>',
        type: 'GET',
        data: params,
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                renderTable(res.records, res.total);
            } else {
                $('#odTableBody').html('<tr><td colspan="11" style="text-align:center; padding:20px; color:#ef4444;">Failed to load data.</td></tr>');
            }
        },
        error: function() {
            $('#odTableBody').html('<tr><td colspan="11" style="text-align:center; padding:20px; color:#ef4444;">Error communicating with server.</td></tr>');
        }
    });
}

function renderTable(records, total) {
    if (!records || records.length === 0) {
        $('#odTableBody').html('<tr><td colspan="11" style="text-align:center; padding:30px; color:#64748b;">No Outside Duty assignments found matching the criteria.</td></tr>');
        $('#lbl_start_idx').text(0);
        $('#lbl_end_idx').text(0);
        $('#lbl_total_records').text(0);
        $('#pagination_controls').html('');
        return;
    }

    var startIdx = ((currentPage - 1) * pageLimit) + 1;
    var endIdx = Math.min(currentPage * pageLimit, total);
    $('#lbl_start_idx').text(startIdx);
    $('#lbl_end_idx').text(endIdx);
    $('#lbl_total_records').text(total);

    var html = '';
    var sl = startIdx;

    records.forEach(function(row) {
        // Date formatting
        var dateDisplay = '';
        if (row.start_date === row.end_date) {
            dateDisplay = '<span style="font-weight:600; color:#0f172a;">' + row.start_date + '</span>';
        } else {
            dateDisplay = '<span style="font-weight:600; color:#0f172a;">' + row.start_date + '</span><br><span style="font-size:11px; color:#64748b;">to ' + row.end_date + '</span>';
        }

        // Attendance badge
        var attnBadge = '-';
        if (row.status === 'approved') {
            attnBadge = '<span class="attn-status-badge"><i class="fa fa-check"></i> OD</span>';
        } else if (row.status === 'pending') {
            attnBadge = '<span style="font-size:11px; color:#94a3b8;">Pending</span>';
        } else {
            attnBadge = '<span style="font-size:11px; color:#94a3b8;">N/A</span>';
        }

        // Action Buttons
        var actions = '<div class="action-btn-group">';
        actions += '<button type="button" class="btn-sm-action" title="View Details" onclick="viewDetails(' + row.id + ')"><i class="fa fa-eye"></i></button>';

        if (row.status === 'pending') {
            if (isAdmin) {
                actions += '<button type="button" class="btn-sm-action btn-approve" title="Approve OD" onclick="approveOd(' + row.id + ')"><i class="fa fa-check"></i></button>';
                actions += '<button type="button" class="btn-sm-action btn-reject" title="Reject OD" onclick="openRejectModal(' + row.id + ')"><i class="fa fa-times"></i></button>';
            }
            actions += '<a href="<?= base_url("od_management_con/edit/") ?>' + row.id + '" class="btn-sm-action" title="Edit Assignment"><i class="fa fa-pencil"></i></a>';
        }

        if (row.status === 'approved' && isAdmin) {
            actions += '<button type="button" class="btn-sm-action" title="Cancel OD" style="color:#d97706;" onclick="openCancelModal(' + row.id + ')"><i class="fa fa-ban"></i></button>';
        }

        actions += '</div>';

        html += '<tr>' +
                '<td>' + (sl++) + '</td>' +
                '<td><span style="font-weight:700; color:#0284c7;">' + row.emp_id + '</span></td>' +
                '<td><span style="font-weight:600; color:#0f172a;">' + (row.name_en || '-') + '</span></td>' +
                '<td>' +
                    '<div style="font-weight:600; font-size:12px;">' + (row.dept_name || '-') + '</div>' +
                    '<div style="font-size:11px; color:#64748b;">' + (row.desig_name || '-') + '</div>' +
                '</td>' +
                '<td>' + dateDisplay + '</td>' +
                '<td style="text-align:center;"><span class="badge" style="background:#f1f5f9; color:#334155; font-weight:700;">' + row.total_days + 'd</span></td>' +
                '<td>' +
                    '<div style="font-weight:600; color:#0f172a;">' + row.purpose + '</div>' +
                    '<div style="font-size:11px; color:#64748b;"><i class="fa fa-map-marker"></i> ' + row.location + '</div>' +
                '</td>' +
                '<td><span style="font-size:12px; color:#475569;">' + (row.assigned_by || '-') + '</span></td>' +
                '<td style="text-align:center;"><span class="status-pill ' + row.status + '">' + row.status + '</span></td>' +
                '<td style="text-align:center;">' + attnBadge + '</td>' +
                '<td style="text-align:center;">' + actions + '</td>' +
                '</tr>';
    });

    $('#odTableBody').html(html);
    renderPagination(total);
}

function renderPagination(total) {
    var totalPages = Math.ceil(total / pageLimit);
    if (totalPages <= 1) {
        $('#pagination_controls').html('');
        return;
    }

    var html = '';
    html += '<button type="button" class="btn-page" ' + (currentPage === 1 ? 'disabled' : '') + ' onclick="loadOdList(' + (currentPage - 1) + ')"><i class="fa fa-chevron-left"></i> Prev</button>';

    var startP = Math.max(1, currentPage - 2);
    var endP = Math.min(totalPages, currentPage + 2);

    for (var p = startP; p <= endP; p++) {
        html += '<button type="button" class="btn-page ' + (p === currentPage ? 'active' : '') + '" onclick="loadOdList(' + p + ')">' + p + '</button>';
    }

    html += '<button type="button" class="btn-page" ' + (currentPage === totalPages ? 'disabled' : '') + ' onclick="loadOdList(' + (currentPage + 1) + ')">Next <i class="fa fa-chevron-right"></i></button>';

    $('#pagination_controls').html(html);
}

function viewDetails(id) {
    $('#modal_view_body').html('<div style="text-align:center; padding:30px;"><i class="fa fa-spinner fa-spin"></i> Loading details...</div>');
    $('#modalViewOd').modal('show');

    $.ajax({
        url: '<?= base_url("od_management_con/details_ajax/") ?>' + id,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success' && res.data) {
                var d = res.data;
                var datesHtml = '';
                if (d.dates_list && d.dates_list.length > 0) {
                    datesHtml = d.dates_list.map(function(dt) {
                        return '<span class="date-tag" style="margin-right:6px; margin-bottom:4px; display:inline-block; background:#e0f2fe; color:#0369a1; padding:3px 8px; border-radius:12px; font-size:11px;"><i class="fa fa-calendar"></i> ' + dt + '</span>';
                    }).join(' ');
                } else {
                    datesHtml = d.start_date + ' to ' + d.end_date;
                }

                var auditHtml = '<span class="text-muted">No audit history recorded.</span>';
                if (d.audit_list && d.audit_list.length > 0) {
                    auditHtml = '<div class="audit-list">' + d.audit_list.map(function(a) {
                        return '<div class="audit-item"><strong>' + a.action + '</strong> by <em>' + a.by + '</em> at ' + a.at + (a.remarks ? ' - ' + a.remarks : '') + '</div>';
                    }).join('') + '</div>';
                }

                var html = '<div class="detail-grid">' +
                           '<div class="detail-item"><div class="lbl">Assignment ID</div><div class="val">#' + d.id + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Status</div><div class="val"><span class="status-pill ' + d.status + '">' + d.status + '</span></div></div>' +
                           '<div class="detail-item"><div class="lbl">Employee</div><div class="val">' + d.emp_id + ' - ' + (d.name_en || '-') + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Dept & Designation</div><div class="val">' + (d.dept_name || '-') + ' / ' + (d.desig_name || '-') + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Branch / Unit</div><div class="val">' + (d.unit_name || '-') + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Purpose / Category</div><div class="val">' + d.purpose + '</div></div>' +
                           '<div class="detail-item" style="grid-column:span 2;"><div class="lbl">Outside Duty Location</div><div class="val"><i class="fa fa-map-marker" style="color:#ef4444;"></i> ' + d.location + '</div></div>' +
                           '<div class="detail-item" style="grid-column:span 2;"><div class="lbl">Work Description</div><div class="val" style="font-weight:normal; background:#f8fafc; padding:8px 12px; border-radius:6px; border:1px solid #e2e8f0;">' + (d.work_description || '-') + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Departure Time</div><div class="val">' + (d.departure_time || 'Not specified') + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Return Time</div><div class="val">' + (d.return_time || 'Not specified') + '</div></div>' +
                           '<div class="detail-item" style="grid-column:span 2;"><div class="lbl">Assigned Dates (' + d.total_days + ' Days)</div><div class="val" style="margin-top:6px;">' + datesHtml + '</div></div>' +
                           '<div class="detail-item"><div class="lbl">Assigned By</div><div class="val">' + (d.assigned_by || '-') + ' (' + d.created_at + ')</div></div>' +
                           '<div class="detail-item"><div class="lbl">Approved By</div><div class="val">' + (d.approved_by || '-') + (d.approved_at ? ' (' + d.approved_at + ')' : '') + '</div></div>' +
                           (d.rejection_reason ? '<div class="detail-item" style="grid-column:span 2;"><div class="lbl">Rejection Reason</div><div class="val" style="color:#b91c1c;">' + d.rejection_reason + '</div></div>' : '') +
                           (d.remarks ? '<div class="detail-item" style="grid-column:span 2;"><div class="lbl">Remarks</div><div class="val">' + d.remarks + '</div></div>' : '') +
                           '</div>' +
                           '<div style="margin-top:14px;"><div style="font-size:12px; font-weight:700; color:#475569; margin-bottom:6px;">Audit Trail History:</div>' + auditHtml + '</div>';

                $('#modal_view_body').html(html);
            } else {
                $('#modal_view_body').html('<div class="alert alert-danger">Could not load details.</div>');
            }
        }
    });
}

function approveOd(id) {
    Swal.fire({
        title: 'Approve Outside Duty?',
        text: 'This will approve the OD assignment and mark the employee attendance status as "OD" for the assigned dates.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Approve Now!'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("od_management_con/approve_ajax") ?>',
                type: 'POST',
                data: { id: id },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire('Approved!', res.message, 'success');
                        loadOdList(currentPage);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }
            });
        }
    });
}

function openRejectModal(id) {
    $('#reject_od_id').val(id);
    $('#reject_reason_text').val('');
    $('#modalRejectOd').modal('show');
}

function confirmReject() {
    var id = $('#reject_od_id').val();
    var reason = $('#reject_reason_text').val().trim();
    if (!reason) {
        Swal.fire('Notice', 'Please provide a reason for rejection.', 'warning');
        return;
    }

    $.ajax({
        url: '<?= base_url("od_management_con/reject_ajax") ?>',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(res) {
            $('#modalRejectOd').modal('hide');
            if (res.status === 'success') {
                Swal.fire('Rejected', res.message, 'info');
                loadOdList(currentPage);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

function openCancelModal(id) {
    $('#cancel_od_id').val(id);
    $('#cancel_reason_text').val('');
    $('#modalCancelOd').modal('show');
}

function confirmCancel() {
    var id = $('#cancel_od_id').val();
    var reason = $('#cancel_reason_text').val().trim();

    $.ajax({
        url: '<?= base_url("od_management_con/cancel_ajax") ?>',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(res) {
            $('#modalCancelOd').modal('hide');
            if (res.status === 'success') {
                Swal.fire('Cancelled', res.message, 'info');
                loadOdList(currentPage);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

function exportData(type) {
    var f = getFilters();
    var q = $.param(f);
    if (type === 'csv') {
        window.location.href = '<?= base_url("od_management_con/export_excel") ?>?type=list&' + q;
    } else {
        window.open('<?= base_url("od_management_con/export_pdf") ?>?type=list&' + q, '_blank');
    }
}

$(document).ready(function() {
    loadOdList(1);
});
</script>
