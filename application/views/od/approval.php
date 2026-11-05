<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) APPROVAL WORKFLOW - EXECUTIVE THEME                     */
/* ========================================================================= */
.page-content .content.od-approval-wrapper {
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
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
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

/* Tab Navigation */
.nav-tabs-custom {
    display: flex;
    gap: 8px;
    margin-bottom: 18px;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0;
}
.tab-link-custom {
    padding: 10px 20px;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    border: none;
    background: transparent;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}
.tab-link-custom:hover {
    color: #0f172a;
}
.tab-link-custom.active {
    color: #059669;
    border-bottom-color: #059669;
    background: transparent;
}
.tab-badge {
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    background: #f1f5f9;
    color: #475569;
}
.tab-link-custom.active .tab-badge {
    background: #dcfce7;
    color: #15803d;
}

/* Bulk Action Bar */
.bulk-bar {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 12px 18px;
    margin-bottom: 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.bulk-info {
    font-size: 13px;
    font-weight: 600;
    color: #166534;
    display: flex;
    align-items: center;
    gap: 8px;
}
.btn-bulk-approve {
    background: #059669;
    color: #ffffff;
    border: none;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    transition: background 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-bulk-approve:hover {
    background: #047857;
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
    font-size: 13px;
    margin: 0;
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

/* Status Pills */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
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

/* Action Buttons */
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
</style>

<div class="content od-approval-wrapper">

        <!-- Top Header Card -->
        <div class="od-header-card">
            <div class="od-header-left">
                <div class="od-header-icon">
                    <i class="fa fa-check-square-o"></i>
                </div>
                <div class="od-header-text">
                    <h2>Outside Duty (OD) Approval & Management</h2>
                    <p>Review, verify, and approve pending employee outside duty assignments with live attendance integration</p>
                </div>
            </div>
            <div>
                <a href="<?= base_url('od_management_con/list') ?>" class="btn-action-outline">
                    <i class="fa fa-list"></i> View All OD List
                </a>
                <button type="button" class="btn-action-outline" onclick="loadQueue()">
                    <i class="fa fa-refresh"></i> Refresh Queue
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs-custom">
            <button type="button" class="tab-link-custom active" id="tab_btn_queue" onclick="switchTab('queue')">
                <i class="fa fa-clock-o"></i> Pending Queue 
                <span class="tab-badge" id="lbl_queue_badge">0</span>
            </button>
            <button type="button" class="tab-link-custom" id="tab_btn_history" onclick="switchTab('history')">
                <i class="fa fa-history"></i> Approval History
            </button>
        </div>

        <!-- Tab 1: Pending Queue Content -->
        <div id="tab_content_queue">
            <!-- Bulk Actions Bar -->
            <div class="bulk-bar" id="bulk_bar" style="display:none;">
                <div class="bulk-info">
                    <i class="fa fa-check-circle"></i> <span id="lbl_selected_count">0</span> assignment(s) selected
                </div>
                <div>
                    <button type="button" class="btn-bulk-approve" onclick="bulkApprove()">
                        <i class="fa fa-check"></i> Approve Selected
                    </button>
                </div>
            </div>

            <!-- Queue Table Card -->
            <div class="table-card">
                <div class="table-responsive-custom">
                    <table class="table-od">
                        <thead>
                            <tr>
                                <th style="width:36px; text-align:center;">
                                    <input type="checkbox" id="chk_select_all" onchange="toggleSelectAll(this)">
                                </th>
                                <th style="width:45px;">SL</th>
                                <th style="width:90px;">Emp ID</th>
                                <th>Employee Name</th>
                                <th>Department & Designation</th>
                                <th>OD Dates</th>
                                <th style="width:60px; text-align:center;">Days</th>
                                <th>Purpose & Location</th>
                                <th>Assigned By & Date</th>
                                <th style="text-align:center; width:130px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="queueTableBody">
                            <tr>
                                <td colspan="10" style="text-align:center; padding:30px; color:#64748b;">
                                    <i class="fa fa-spinner fa-spin"></i> Loading pending approval queue...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 2: Approval History Content -->
        <div id="tab_content_history" style="display:none;">
            <div class="table-card">
                <div class="table-responsive-custom">
                    <table class="table-od">
                        <thead>
                            <tr>
                                <th style="width:45px;">SL</th>
                                <th style="width:90px;">Emp ID</th>
                                <th>Employee Name</th>
                                <th>OD Dates</th>
                                <th>Purpose & Location</th>
                                <th style="text-align:center;">Status</th>
                                <th>Reviewed By</th>
                                <th>Review Remarks / Reason</th>
                                <th style="text-align:center; width:60px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <tr>
                                <td colspan="9" style="text-align:center; padding:30px; color:#64748b;">
                                    <i class="fa fa-spinner fa-spin"></i> Loading approval history...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

<!-- Modal: Approve Remarks -->
<div class="modal fade" id="modalApproveOd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none;">
            <div class="modal-header-custom" style="background:#f0fdf4; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                <h4 class="modal-title-custom" style="color:#15803d; margin:0;"><i class="fa fa-check-circle"></i> Approve OD Assignment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="padding:20px;">
                <input type="hidden" id="approve_od_id">
                <p style="font-size:13px; color:#475569;">You are approving this Outside Duty assignment. This will automatically update attendance status to <strong>OD</strong> for all assigned dates.</p>
                <div class="form-group" style="margin-top:12px;">
                    <label style="font-size:12px; font-weight:600; color:#334155;">Approval Remarks (Optional):</label>
                    <input type="text" class="form-control" id="approve_remarks_text" placeholder="e.g. Approved as per requisition..." style="border-radius:8px;">
                </div>
            </div>
            <div class="modal-footer" style="background:#f8fafc; padding:12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn_confirm_approve" onclick="confirmApprove()">Approve Assignment</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Reject OD Reason -->
<div class="modal fade" id="modalRejectOd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none;">
            <div class="modal-header-custom" style="background:#fef2f2; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                <h4 class="modal-title-custom" style="color:#b91c1c; margin:0;"><i class="fa fa-times-circle"></i> Reject OD Assignment</h4>
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

<!-- Modal: View Assignment Details -->
<div class="modal fade" id="modalViewOd" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius:14px; overflow:hidden; border:none; box-shadow:0 15px 35px rgba(0,0,0,0.15);">
            <div class="modal-header-custom" style="background:#f8fafc; border-bottom:1px solid #e2e8f0; padding:16px 20px; display:flex; justify-content:space-between; align-items:center;">
                <h4 class="modal-title-custom" style="margin:0;"><i class="fa fa-file-text-o" style="color:#0284c7;"></i> Outside Duty Assignment Details</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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

<script>
var selectedIds = [];

function switchTab(tab) {
    if (tab === 'queue') {
        $('#tab_btn_queue').addClass('active');
        $('#tab_btn_history').removeClass('active');
        $('#tab_content_queue').show();
        $('#tab_content_history').hide();
        loadQueue();
    } else {
        $('#tab_btn_queue').removeClass('active');
        $('#tab_btn_history').addClass('active');
        $('#tab_content_queue').hide();
        $('#tab_content_history').show();
        loadHistory();
    }
}

function loadQueue() {
    $('#chk_select_all').prop('checked', false);
    selectedIds = [];
    updateBulkBar();

    $('#queueTableBody').html('<tr><td colspan="10" style="text-align:center; padding:30px; color:#64748b;"><i class="fa fa-spinner fa-spin"></i> Loading pending approval queue...</td></tr>');

    $.ajax({
        url: '<?= base_url("od_management_con/list_ajax") ?>',
        type: 'GET',
        data: { status: 'pending', limit: 100 },
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                var records = res.records || [];
                $('#lbl_queue_badge').text(records.length);

                if (records.length === 0) {
                    $('#queueTableBody').html('<tr><td colspan="10" style="text-align:center; padding:35px; color:#059669; font-weight:600;"><i class="fa fa-check-circle" style="font-size:24px; display:block; margin-bottom:8px;"></i> All caught up! No pending Outside Duty assignments awaiting approval.</td></tr>');
                    return;
                }

                var html = '';
                var sl = 1;
                records.forEach(function(row) {
                    var dateDisplay = (row.start_date === row.end_date) ? 
                        '<span style="font-weight:600;">' + row.start_date + '</span>' :
                        '<span style="font-weight:600;">' + row.start_date + '</span><br><span style="font-size:11px; color:#64748b;">to ' + row.end_date + '</span>';

                    html += '<tr>' +
                            '<td style="text-align:center;"><input type="checkbox" class="queue-chk" value="' + row.id + '" onchange="handleRowCheck(this)"></td>' +
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
                            '<td>' +
                                '<div style="font-size:12px; color:#334155;">' + (row.assigned_by || '-') + '</div>' +
                                '<div style="font-size:11px; color:#94a3b8;">' + row.created_at + '</div>' +
                            '</td>' +
                            '<td style="text-align:center;">' +
                                '<div class="action-btn-group" style="justify-content:center;">' +
                                    '<button type="button" class="btn-sm-action btn-approve" title="Approve" onclick="openApproveModal(' + row.id + ')"><i class="fa fa-check"></i></button>' +
                                    '<button type="button" class="btn-sm-action btn-reject" title="Reject" onclick="openRejectModal(' + row.id + ')"><i class="fa fa-times"></i></button>' +
                                    '<button type="button" class="btn-sm-action" title="View Details" onclick="viewDetails(' + row.id + ')"><i class="fa fa-eye"></i></button>' +
                                '</div>' +
                            '</td>' +
                            '</tr>';
                });

                $('#queueTableBody').html(html);
            }
        }
    });
}

function loadHistory() {
    $('#historyTableBody').html('<tr><td colspan="9" style="text-align:center; padding:30px; color:#64748b;"><i class="fa fa-spinner fa-spin"></i> Loading approval history...</td></tr>');

    $.ajax({
        url: '<?= base_url("od_management_con/list_ajax") ?>',
        type: 'GET',
        data: { limit: 50 },
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                var records = (res.records || []).filter(function(r) { return r.status === 'approved' || r.status === 'rejected'; });

                if (records.length === 0) {
                    $('#historyTableBody').html('<tr><td colspan="9" style="text-align:center; padding:30px; color:#64748b;">No recent approval/rejection history found.</td></tr>');
                    return;
                }

                var html = '';
                var sl = 1;
                records.forEach(function(row) {
                    html += '<tr>' +
                            '<td>' + (sl++) + '</td>' +
                            '<td><span style="font-weight:700; color:#0284c7;">' + row.emp_id + '</span></td>' +
                            '<td><span style="font-weight:600; color:#0f172a;">' + (row.name_en || '-') + '</span></td>' +
                            '<td>' + row.start_date + ' (' + row.total_days + 'd)</td>' +
                            '<td>' + row.purpose + '<br><small style="color:#64748b;">' + row.location + '</small></td>' +
                            '<td style="text-align:center;"><span class="status-pill ' + row.status + '">' + row.status + '</span></td>' +
                            '<td>' + (row.approved_by || '-') + '<br><small style="color:#94a3b8;">' + (row.approved_at || '') + '</small></td>' +
                            '<td>' + (row.status === 'rejected' ? (row.rejection_reason || '-') : (row.remarks || '-')) + '</td>' +
                            '<td style="text-align:center;"><button type="button" class="btn-sm-action" onclick="viewDetails(' + row.id + ')"><i class="fa fa-eye"></i></button></td>' +
                            '</tr>';
                });

                $('#historyTableBody').html(html);
            }
        }
    });
}

function toggleSelectAll(master) {
    var checked = $(master).is(':checked');
    $('.queue-chk').prop('checked', checked);
    selectedIds = [];
    if (checked) {
        $('.queue-chk').each(function() {
            selectedIds.push($(this).val());
        });
    }
    updateBulkBar();
}

function handleRowCheck(box) {
    var val = $(box).val();
    if ($(box).is(':checked')) {
        if (selectedIds.indexOf(val) === -1) selectedIds.push(val);
    } else {
        selectedIds = selectedIds.filter(function(id) { return id !== val; });
        $('#chk_select_all').prop('checked', false);
    }
    updateBulkBar();
}

function updateBulkBar() {
    $('#lbl_selected_count').text(selectedIds.length);
    if (selectedIds.length > 0) {
        $('#bulk_bar').slideDown(150);
    } else {
        $('#bulk_bar').slideUp(150);
    }
}

function openApproveModal(id) {
    $('#approve_od_id').val(id);
    $('#approve_remarks_text').val('');
    $('#modalApproveOd').modal('show');
}

function confirmApprove() {
    var id = $('#approve_od_id').val();
    var remarks = $('#approve_remarks_text').val().trim();

    $.ajax({
        url: '<?= base_url("od_management_con/approve_ajax") ?>',
        type: 'POST',
        data: { id: id, remarks: remarks },
        dataType: 'json',
        success: function(res) {
            $('#modalApproveOd').modal('hide');
            if (res.status === 'success') {
                Swal.fire('Approved!', res.message, 'success');
                loadQueue();
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

function bulkApprove() {
    if (selectedIds.length === 0) return;

    Swal.fire({
        title: 'Bulk Approve?',
        text: 'Are you sure you want to approve ' + selectedIds.length + ' selected Outside Duty assignment(s)?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Approve Selected'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("od_management_con/bulk_approve_ajax") ?>',
                type: 'POST',
                data: { ids: selectedIds },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire('Approved!', res.message, 'success');
                        loadQueue();
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
                loadQueue();
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
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
                var datesHtml = (d.dates_list && d.dates_list.length > 0) ?
                    d.dates_list.map(function(dt) { return '<span class="date-tag" style="margin-right:6px; margin-bottom:4px; display:inline-block; background:#e0f2fe; color:#0369a1; padding:3px 8px; border-radius:12px; font-size:11px;"><i class="fa fa-calendar"></i> ' + dt + '</span>'; }).join(' ') :
                    d.start_date + ' to ' + d.end_date;

                var html = '<div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:12px 18px;">' +
                           '<div><strong style="font-size:11px; color:#64748b;">ASSIGNMENT ID:</strong><div style="font-weight:700; font-size:14px;">#' + d.id + '</div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">STATUS:</strong><div><span class="status-pill ' + d.status + '">' + d.status + '</span></div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">EMPLOYEE:</strong><div style="font-weight:600;">' + d.emp_id + ' - ' + (d.name_en || '-') + '</div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">DEPARTMENT:</strong><div>' + (d.dept_name || '-') + '</div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">PURPOSE:</strong><div style="font-weight:600;">' + d.purpose + '</div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">LOCATION:</strong><div><i class="fa fa-map-marker" style="color:#ef4444;"></i> ' + d.location + '</div></div>' +
                           '<div style="grid-column:span 2;"><strong style="font-size:11px; color:#64748b;">WORK DESCRIPTION:</strong><div style="background:#f8fafc; padding:8px 12px; border-radius:6px; border:1px solid #e2e8f0; margin-top:4px;">' + (d.work_description || '-') + '</div></div>' +
                           '<div style="grid-column:span 2;"><strong style="font-size:11px; color:#64748b;">ASSIGNED DATES (' + d.total_days + ' Days):</strong><div style="margin-top:4px;">' + datesHtml + '</div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">ASSIGNED BY:</strong><div>' + (d.assigned_by || '-') + ' (' + d.created_at + ')</div></div>' +
                           '<div><strong style="font-size:11px; color:#64748b;">EXPECTED TIME:</strong><div>Dep: ' + (d.departure_time || 'N/A') + ' | Ret: ' + (d.return_time || 'N/A') + '</div></div>' +
                           '</div>';

                $('#modal_view_body').html(html);
            }
        }
    });
}

$(document).ready(function() {
    loadQueue();
});
</script>
