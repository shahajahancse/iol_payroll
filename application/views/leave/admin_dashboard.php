<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
/* Admin HRM Leave Dashboard Styles */
.admin-dashboard-wrapper {
    padding: 20px 15px;
    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #1e293b;
}
.admin-header-box {
    background: #ffffff;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 4px solid #0f172a;
}
.admin-header-box h2 {
    margin: 0 0 5px 0;
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
}
.admin-header-box p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}
.admin-badge {
    background: #0f172a;
    color: #ffffff;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: inline-block;
}

/* Stat Cards */
.admin-stat-card {
    background: #ffffff;
    border-radius: 8px;
    padding: 16px 18px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    border: 1px solid #e2e8f0;
}
.admin-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
.admin-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    margin-right: 14px;
    flex-shrink: 0;
}
.admin-stat-info h3 {
    margin: 0 0 3px 0;
    font-size: 22px;
    font-weight: 700;
    line-height: 1;
}
.admin-stat-info span {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
/* Stat color presets */
.stat-navy .admin-stat-icon { background: #e2e8f0; color: #1e293b; }
.stat-navy h3 { color: #0f172a; }
.stat-warning .admin-stat-icon { background: #fef3c7; color: #d97706; }
.stat-warning h3 { color: #b45309; }
.stat-success .admin-stat-icon { background: #dcfce7; color: #16a34a; }
.stat-success h3 { color: #15803d; }
.stat-danger .admin-stat-icon { background: #fee2e2; color: #dc2626; }
.stat-danger h3 { color: #b91c1c; }
.stat-returned .admin-stat-icon { background: #f3e8ff; color: #9333ea; }
.stat-returned h3 { color: #7e22ce; }
.stat-teal .admin-stat-icon { background: #ccfbf1; color: #0d9488; }
.stat-teal h3 { color: #0f766e; }

/* Tabs Navigation */
.nav-tabs-custom {
    background: #ffffff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    margin-bottom: 25px;
}
.nav-tabs-custom > .nav-tabs {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 0 15px;
}
.nav-tabs-custom > .nav-tabs > li > a {
    color: #64748b;
    font-weight: 600;
    font-size: 13px;
    border: none;
    padding: 14px 20px;
    margin-right: 4px;
    border-bottom: 2px solid transparent;
    transition: all 0.2s;
}
.nav-tabs-custom > .nav-tabs > li.active > a,
.nav-tabs-custom > .nav-tabs > li > a:hover {
    color: #0f172a;
    background: #ffffff;
    border-bottom: 2px solid #2563eb;
}
.nav-tabs-custom > .tab-content {
    padding: 0;
}

/* Filter Box */
.admin-filter-bar {
    padding: 16px 20px;
    background: #ffffff;
    border-bottom: 1px solid #edf2f7;
}
.admin-filter-bar .form-group {
    margin-bottom: 8px;
}
.admin-filter-bar label {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 3px;
}

/* Table */
.admin-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}
.admin-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 2px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}
.admin-table tbody td {
    padding: 12px 14px;
    font-size: 13px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
}
.admin-table tbody tr:hover {
    background-color: #f8fafc;
}

/* Action Buttons */
.btn-approve {
    background: #16a34a;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    transition: background 0.2s;
}
.btn-approve:hover {
    background: #15803d;
    color: #ffffff;
}
.btn-reject {
    background: #dc2626;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    transition: background 0.2s;
}
.btn-reject:hover {
    background: #b91c1c;
    color: #ffffff;
}
.btn-modify {
    background: #2563eb;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    transition: background 0.2s;
}
.btn-modify:hover {
    background: #1d4ed8;
    color: #ffffff;
}
.btn-return {
    background: #9333ea;
    color: #ffffff;
    border: none;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 4px;
    transition: background 0.2s;
}
.btn-return:hover {
    background: #7e22ce;
    color: #ffffff;
}

/* Badges */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 8px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 16px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
.badge-returned { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }

.type-badge {
    padding: 3px 8px;
    font-size: 11px;
    font-weight: 700;
    border-radius: 4px;
    display: inline-block;
}
.type-cl { background: #e0f2fe; color: #0369a1; }
.type-sl { background: #ccfbf1; color: #0f766e; }
.type-el { background: #dcfce7; color: #166534; }
.type-ml { background: #fce7f3; color: #be185d; }
.type-pl { background: #ede9fe; color: #5b21b6; }
.type-wp { background: #f1f5f9; color: #475569; }
.type-sp { background: #ffedd5; color: #c2410c; }

/* Pulse animation for queue count */
.pulse-badge {
    animation: pulse-animation 2s infinite;
}
@keyframes pulse-animation {
    0% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0.4); }
    70% { box-shadow: 0 0 0 8px rgba(217, 119, 6, 0); }
    100% { box-shadow: 0 0 0 0 rgba(217, 119, 6, 0); }
}

/* Timeline */
.audit-timeline {
    position: relative;
    padding-left: 25px;
    margin-top: 15px;
}
.audit-timeline::before {
    content: '';
    position: absolute;
    top: 5px;
    bottom: 5px;
    left: 8px;
    width: 2px;
    background: #e2e8f0;
}
.timeline-item {
    position: relative;
    margin-bottom: 16px;
}
.timeline-dot {
    position: absolute;
    left: -25px;
    top: 2px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: #3b82f6;
    border: 3px solid #ffffff;
    box-shadow: 0 0 0 1px #cbd5e1;
}
.timeline-item.approved .timeline-dot { background: #16a34a; }
.timeline-item.rejected .timeline-dot { background: #dc2626; }
.timeline-item.returned_for_modification .timeline-dot { background: #9333ea; }
.timeline-item.modified_by_admin .timeline-dot { background: #2563eb; }
.timeline-content {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 6px;
    padding: 8px 12px;
}
</style>

<div class="content admin-dashboard-wrapper">
    <!-- Top Admin Header -->
    <div class="admin-header-box">
        <div>
            <h2><i class="fa fa-shield text-primary" style="margin-right: 8px;"></i> Admin Leave Approval Dashboard</h2>
            <p>Review, approve, reject, modify, or return leave requests with real-time balance calculations and full audit history.</p>
        </div>
        <div>
            <span class="admin-badge"><i class="fa fa-lock"></i> Admin Role Active</span>
            <a href="<?= base_url('leave_con/hr_dashboard') ?>" class="btn btn-default" style="font-weight: 600; padding: 6px 14px; border-radius: 6px; margin-left: 10px;">
                <i class="fa fa-arrow-left"></i> HR View
            </a>
        </div>
    </div>

    <!-- 6 Real-Time Database Summary Cards -->
    <div class="row">
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="admin-stat-card stat-navy" onclick="selectTabAndFilter('all', '')">
                <div class="admin-stat-icon"><i class="fa fa-folder-open-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_total">0</h3>
                    <span>Total Requests</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="admin-stat-card stat-warning" onclick="selectTabAndFilter('queue', 'pending')">
                <div class="admin-stat-icon"><i class="fa fa-clock-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_pending">0</h3>
                    <span>Pending Approval</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="admin-stat-card stat-success" onclick="selectTabAndFilter('all', 'approved')">
                <div class="admin-stat-icon"><i class="fa fa-check-square-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_approved">0</h3>
                    <span>Approved</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="admin-stat-card stat-danger" onclick="selectTabAndFilter('all', 'rejected')">
                <div class="admin-stat-icon"><i class="fa fa-ban"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_rejected">0</h3>
                    <span>Rejected</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="admin-stat-card stat-returned" onclick="selectTabAndFilter('all', 'returned')">
                <div class="admin-stat-icon"><i class="fa fa-reply"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_returned">0</h3>
                    <span>Returned</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="admin-stat-card stat-teal" onclick="selectTabAndFilter('all', '')">
                <div class="admin-stat-icon"><i class="fa fa-calendar-check-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_today">0</h3>
                    <span>Starting Today</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabbed Navigation Panels -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" id="admin_tabs">
            <li class="active">
                <a href="#tab_queue" data-toggle="tab" onclick="switchTab('queue')">
                    <i class="fa fa-hourglass-half text-warning"></i> Pending Approval Queue 
                    <span class="label label-warning pulse-badge" id="tab_queue_badge" style="margin-left: 5px;">0</span>
                </a>
            </li>
            <li>
                <a href="#tab_all" data-toggle="tab" onclick="switchTab('all')">
                    <i class="fa fa-list"></i> All Leave Requests & History
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- Filter Bar -->
            <div class="admin-filter-bar">
                <form id="admin_filter_form" onsubmit="event.preventDefault(); loadAdminData(1);">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <div class="form-group">
                                <label><i class="fa fa-search"></i> Employee ID or Name</label>
                                <input type="text" class="form-control input-sm" id="admin_f_emp" placeholder="Search employee..." oninput="debounceAdminSearch()">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label><i class="fa fa-building"></i> Department</label>
                                <select class="form-control input-sm" id="admin_f_dept" onchange="loadAdminData(1)">
                                    <option value="">All Departments</option>
                                    <?php foreach($departments as $d): ?>
                                        <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <div class="form-group">
                                <label><i class="fa fa-tag"></i> Leave Type</label>
                                <select class="form-control input-sm" id="admin_f_type" onchange="loadAdminData(1)">
                                    <option value="">All Types</option>
                                    <option value="cl">Casual (CL)</option>
                                    <option value="sl">Sick (SL)</option>
                                    <option value="el">Earn (EL)</option>
                                    <option value="ml">Maternity (ML)</option>
                                    <option value="pl">Paternity (PL)</option>
                                    <option value="wp">Without Pay (WP)</option>
                                    <option value="sp">Special (SP)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6" id="status_filter_wrapper">
                            <div class="form-group">
                                <label><i class="fa fa-filter"></i> Status</label>
                                <select class="form-control input-sm" id="admin_f_status" onchange="loadAdminData(1)">
                                    <option value="all">All Statuses</option>
                                    <option value="pending">Pending Approval</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="returned">Returned for Modification</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="form-group">
                                <label><i class="fa fa-calendar"></i> Date Range</label>
                                <div class="input-group input-group-sm">
                                    <input type="date" class="form-control" id="admin_f_from" onchange="loadAdminData(1)">
                                    <span class="input-group-addon">to</span>
                                    <input type="date" class="form-control" id="admin_f_to" onchange="loadAdminData(1)">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-default btn-sm" onclick="resetAdminFilters()">
                                <i class="fa fa-refresh"></i> Reset Filters
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="loadAdminData(1)">
                                <i class="fa fa-search"></i> Apply Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Container -->
            <div class="table-responsive">
                <table class="table admin-table" id="admin_table">
                    <thead>
                        <tr>
                            <th width="40">SL</th>
                            <th>Employee</th>
                            <th>Department & Designation</th>
                            <th>Type</th>
                            <th>Duration</th>
                            <th width="70">Days</th>
                            <th>Status</th>
                            <th>Submitted By</th>
                            <th width="240" class="text-center">Admin Approval Actions</th>
                        </tr>
                    </thead>
                    <tbody id="admin_tbody">
                        <tr>
                            <td colspan="9" class="text-center" style="padding: 40px; color: #94a3b8;">
                                <i class="fa fa-spinner fa-spin fa-2x"></i>
                                <div style="margin-top: 8px;">Loading queue records...</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination Bar -->
            <div style="padding: 14px 20px; background: #fafbfc; border-top: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
                <div style="font-size: 13px; color: #64748b;" id="admin_pagination_info">
                    Showing 0 to 0 of 0 entries
                </div>
                <ul class="pagination pagination-sm" id="admin_pagination_controls" style="margin: 0;">
                    <!-- dynamic pagination links -->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: APPROVE CONFIRMATION WITH OPTIONAL REMARKS -->
<!-- ========================================================================= -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #16a34a; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-check-circle"></i> Approve Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input type="hidden" id="approve_leave_id">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px; margin-bottom: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #166534;" id="approve_emp_name">-</div>
                    <div style="font-size: 12px; color: #15803d; margin-top: 4px;">
                        Leave: <strong id="approve_leave_summary">-</strong>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">Admin Remarks / Approval Note (Optional)</label>
                    <textarea class="form-control" id="approve_remarks" rows="3" placeholder="Add any conditions or remarks for HR..."></textarea>
                </div>
                <p style="font-size: 12px; color: #64748b; margin: 0;">
                    <i class="fa fa-info-circle"></i> Upon approval, leave will be deducted according to official policy and integrated with monthly attendance records.
                </p>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="btn_confirm_approve" onclick="executeApprove()" style="font-weight: 600;">
                    <i class="fa fa-check"></i> Confirm Approval
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: REJECT LEAVE (MANDATORY REASON) -->
<!-- ========================================================================= -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #dc2626; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-times-circle"></i> Reject Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input type="hidden" id="reject_leave_id">
                <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 14px; margin-bottom: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #991b1b;" id="reject_emp_name">-</div>
                    <div style="font-size: 12px; color: #b91c1c; margin-top: 4px;">
                        Leave: <strong id="reject_leave_summary">-</strong>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Rejection Reason <span class="text-danger">* (Mandatory)</span>
                    </label>
                    <textarea class="form-control" id="reject_reason" rows="3" placeholder="Provide reason for rejection (visible to HR)..." required></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn_confirm_reject" onclick="executeReject()" style="font-weight: 600;">
                    <i class="fa fa-ban"></i> Reject Request
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: RETURN TO HR FOR MODIFICATION -->
<!-- ========================================================================= -->
<div class="modal fade" id="returnModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #9333ea; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-reply"></i> Return to HR for Modification</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input type="hidden" id="return_leave_id">
                <div style="background: #faf5ff; border: 1px solid #e9d5ff; border-radius: 8px; padding: 14px; margin-bottom: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #6b21a8;" id="return_emp_name">-</div>
                    <div style="font-size: 12px; color: #7e22ce; margin-top: 4px;">
                        Leave: <strong id="return_leave_summary">-</strong>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">
                        Modification Instructions to HR <span class="text-danger">* (Mandatory)</span>
                    </label>
                    <textarea class="form-control" id="return_reason" rows="3" placeholder="Explain what changes HR must make before resubmission..." required></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_confirm_return" onclick="executeReturn()" style="background: #9333ea; border-color: #7e22ce; font-weight: 600;">
                    <i class="fa fa-reply"></i> Return Request
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: MODIFY LEAVE DETAILS BY ADMIN -->
<!-- ========================================================================= -->
<div class="modal fade" id="modifyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #2563eb; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-edit"></i> Admin Modification of Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <input type="hidden" id="modify_leave_id">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #1e40af;" id="modify_emp_name">-</div>
                    <div style="font-size: 12px; color: #1d4ed8;" id="modify_emp_details">-</div>
                </div>

                <form id="modifyForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600;">Leave Type</label>
                                <select class="form-control" id="modify_leave_type" required onchange="calculateModifyDays()">
                                    <option value="cl">Casual (CL)</option>
                                    <option value="sl">Sick (SL)</option>
                                    <option value="el">Earn (EL)</option>
                                    <option value="ml">Maternity (ML)</option>
                                    <option value="pl">Paternity (PL)</option>
                                    <option value="wp">Without Pay (WP)</option>
                                    <option value="sp">Special (SP)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600;">Start Date</label>
                                <input type="date" class="form-control" id="modify_from_date" required onchange="calculateModifyDays()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600;">End Date</label>
                                <input type="date" class="form-control" id="modify_to_date" required onchange="calculateModifyDays()">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600;">Calculated Duration</label>
                                <input type="number" class="form-control" id="modify_total_days" readonly style="background: #f1f5f9; font-weight: 700;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label style="font-weight: 600;">Admin Modification Remarks</label>
                                <input type="text" class="form-control" id="modify_remarks" placeholder="Reason for modification by Admin...">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="executeModify('save')" style="font-weight: 600;">
                    <i class="fa fa-save"></i> Save Changes as Pending
                </button>
                <button type="button" class="btn btn-success" onclick="executeModify('save_and_approve')" style="font-weight: 600;">
                    <i class="fa fa-check-circle"></i> Save & Approve Immediately
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: VIEW DETAILS & AUDIT TIMELINE -->
<!-- ========================================================================= -->
<div class="modal fade" id="adminViewModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-id-card"></i> Detailed Leave & Profile Inspection</h4>
            </div>
            <div class="modal-body" style="padding: 22px;" id="adminViewBody">
                <!-- dynamic content -->
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentAdminTab = 'queue'; // 'queue' or 'all'
let currentAdminPage = 1;
let currentAdminLimit = 15;
let adminSearchTimer;

$(document).ready(function() {
    loadAdminStats();
    loadAdminData(1);
});

function switchTab(tab) {
    currentAdminTab = tab;
    if (tab === 'queue') {
        $('#status_filter_wrapper').hide();
        $('#admin_f_status').val('pending');
    } else {
        $('#status_filter_wrapper').show();
    }
    loadAdminData(1);
}

function selectTabAndFilter(tab, status) {
    if (tab === 'queue') {
        $('#admin_tabs a[href="#tab_queue"]').tab('show');
        switchTab('queue');
    } else {
        $('#admin_tabs a[href="#tab_all"]').tab('show');
        switchTab('all');
        $('#admin_f_status').val(status ? status : 'all');
        loadAdminData(1);
    }
}

function debounceAdminSearch() {
    clearTimeout(adminSearchTimer);
    adminSearchTimer = setTimeout(function() {
        loadAdminData(1);
    }, 400);
}

function resetAdminFilters() {
    $('#admin_filter_form')[0].reset();
    if (currentAdminTab === 'queue') {
        $('#admin_f_status').val('pending');
    } else {
        $('#admin_f_status').val('all');
    }
    loadAdminData(1);
}

function loadAdminStats() {
    $.ajax({
        url: "<?= base_url('leave_con/admin_stats_ajax') ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                $('#stat_total').text(res.data.total_requests);
                $('#stat_pending').text(res.data.pending_approval);
                $('#stat_approved').text(res.data.approved);
                $('#stat_rejected').text(res.data.rejected);
                $('#stat_returned').text(res.data.returned);
                $('#stat_today').text(res.data.starting_today);
                $('#tab_queue_badge').text(res.data.pending_approval);
            }
        }
    });
}

function loadAdminData(page) {
    currentAdminPage = page || 1;
    let emp_id = $('#admin_f_emp').val();
    let dept_id = $('#admin_f_dept').val();
    let leave_type = $('#admin_f_type').val();
    let status = (currentAdminTab === 'queue') ? 'pending' : $('#admin_f_status').val();
    let from_date = $('#admin_f_from').val();
    let to_date = $('#admin_f_to').val();

    $('#admin_tbody').html(`
        <tr>
            <td colspan="9" class="text-center" style="padding: 40px; color: #94a3b8;">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
                <div style="margin-top: 8px;">Loading ${currentAdminTab === 'queue' ? 'pending queue' : 'leave records'}...</div>
            </td>
        </tr>
    `);

    $.ajax({
        url: "<?= base_url('leave_con/admin_leave_list_ajax') ?>",
        type: "POST",
        dataType: "json",
        data: {
            page: currentAdminPage,
            limit: currentAdminLimit,
            emp_id: emp_id,
            dept_id: dept_id,
            leave_type: leave_type,
            status: status,
            from_date: from_date,
            to_date: to_date,
            queue_only: (currentAdminTab === 'queue') ? 1 : 0
        },
        success: function(res) {
            if (res.status === 'success') {
                renderAdminTable(res.data, res.current_page, res.limit, res.total_rows);
                renderAdminPagination(res.current_page, res.total_pages);
                let start = res.total_rows === 0 ? 0 : (res.current_page - 1) * res.limit + 1;
                let end = Math.min(res.current_page * res.limit, res.total_rows);
                $('#admin_pagination_info').text(`Showing ${start} to ${end} of ${res.total_rows} entries`);
            }
        },
        error: function() {
            $('#admin_tbody').html(`
                <tr>
                    <td colspan="9" class="text-center text-danger" style="padding: 30px;">
                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                        <div>Error loading data.</div>
                    </td>
                </tr>
            `);
        }
    });
}

function renderAdminTable(rows, page, limit, total) {
    if (!rows || rows.length === 0) {
        let msg = (currentAdminTab === 'queue') 
            ? 'No pending requests in approval queue! All caught up.' 
            : 'No matching leave requests found.';
        $('#admin_tbody').html(`
            <tr>
                <td colspan="9" class="text-center" style="padding: 50px 20px; color: #94a3b8;">
                    <i class="fa fa-check-circle-o fa-3x" style="color: #10b981;"></i>
                    <h5 style="margin-top: 10px; font-weight: 600; color: #475569;">${msg}</h5>
                </td>
            </tr>
        `);
        return;
    }

    let html = '';
    let startSL = (page - 1) * limit;

    rows.forEach(function(row, idx) {
        let sl = startSL + idx + 1;
        let empName = row.name_en || 'Emp #' + row.emp_id;
        let initial = empName.charAt(0).toUpperCase();

        // Status badge
        let statusBadge = '';
        if (row.status === 'pending') {
            statusBadge = `<span class="badge-status badge-pending"><i class="fa fa-clock-o"></i> Pending</span>`;
        } else if (row.status === 'approved') {
            statusBadge = `<span class="badge-status badge-approved"><i class="fa fa-check-circle"></i> Approved</span>`;
        } else if (row.status === 'rejected') {
            statusBadge = `<span class="badge-status badge-rejected"><i class="fa fa-times-circle"></i> Rejected</span>`;
        } else if (row.status === 'returned') {
            statusBadge = `<span class="badge-status badge-returned"><i class="fa fa-reply"></i> Returned</span>`;
        }

        let typeBadge = `<span class="type-badge type-${row.leave_type}">${(row.leave_type || '').toUpperCase()}</span>`;
        let datesFormatted = `${row.leave_start} <span style="color:#94a3b8;">to</span> ${row.leave_end}`;

        // Action Buttons:
        let actions = '';
        if (row.status === 'pending') {
            actions = `
                <button class="btn btn-approve" title="Approve Leave" onclick="openApproveModal(${row.id}, '${escapeHtml(empName)}', '${row.leave_type.toUpperCase()} - ${row.total_leave} day(s)')">
                    <i class="fa fa-check"></i> Approve
                </button>
                <button class="btn btn-reject" title="Reject Leave" onclick="openRejectModal(${row.id}, '${escapeHtml(empName)}', '${row.leave_type.toUpperCase()} - ${row.total_leave} day(s)')">
                    <i class="fa fa-times"></i> Reject
                </button>
                <button class="btn btn-return" title="Return to HR" onclick="openReturnModal(${row.id}, '${escapeHtml(empName)}', '${row.leave_type.toUpperCase()} - ${row.total_leave} day(s)')">
                    <i class="fa fa-reply"></i>
                </button>
                <button class="btn btn-modify" title="Modify Details" onclick="openModifyModal(${row.id})">
                    <i class="fa fa-pencil"></i>
                </button>
            `;
        } else {
            actions = `
                <button class="btn btn-default btn-xs" style="padding: 4px 8px;" onclick="viewAdminDetails(${row.id})">
                    <i class="fa fa-eye text-primary"></i> View Details
                </button>
            `;
        }

        html += `
            <tr>
                <td>${sl}</td>
                <td>
                    <div style="font-weight: 600; color: #0f172a;">${escapeHtml(empName)}</div>
                    <div style="font-size: 11px; color: #64748b;">ID: <strong>${row.emp_id}</strong></div>
                </td>
                <td>
                    <div>${escapeHtml(row.dept_name || '-')}</div>
                    <div style="font-size: 11px; color: #64748b;">${escapeHtml(row.desig_name || '-')}</div>
                </td>
                <td>${typeBadge}</td>
                <td>${datesFormatted}</td>
                <td><strong>${row.total_leave}</strong> <span style="font-size:11px; color:#64748b;">day(s)</span></td>
                <td>${statusBadge}</td>
                <td>
                    <div style="font-size: 12px;">${row.applied_at ? row.applied_at.substring(0, 16) : '-'}</div>
                    <div style="font-size: 11px; color: #64748b;">By: ${escapeHtml(row.applied_by_name || 'HR')}</div>
                </td>
                <td class="text-center" style="white-space: nowrap;">
                    ${actions}
                </td>
            </tr>
        `;
    });

    $('#admin_tbody').html(html);
}

function renderAdminPagination(current, total) {
    if (total <= 1) {
        $('#admin_pagination_controls').html('');
        return;
    }
    let html = '';
    if (current > 1) {
        html += `<li><a href="javascript:void(0)" onclick="loadAdminData(${current - 1})">&laquo;</a></li>`;
    } else {
        html += `<li class="disabled"><span>&laquo;</span></li>`;
    }
    let start = Math.max(1, current - 2);
    let end = Math.min(total, current + 2);
    for (let i = start; i <= end; i++) {
        if (i === current) {
            html += `<li class="active"><span>${i}</span></li>`;
        } else {
            html += `<li><a href="javascript:void(0)" onclick="loadAdminData(${i})">${i}</a></li>`;
        }
    }
    if (current < total) {
        html += `<li><a href="javascript:void(0)" onclick="loadAdminData(${current + 1})">&raquo;</a></li>`;
    } else {
        html += `<li class="disabled"><span>&raquo;</span></li>`;
    }
    $('#admin_pagination_controls').html(html);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// =========================================================================
// ACTION MODALS LOGIC
// =========================================================================

// APPROVE
function openApproveModal(id, empName, summary) {
    $('#approve_leave_id').val(id);
    $('#approve_emp_name').text(empName);
    $('#approve_leave_summary').text(summary);
    $('#approve_remarks').val('');
    $('#approveModal').modal('show');
}

function executeApprove() {
    let id = $('#approve_leave_id').val();
    let remarks = $('#approve_remarks').val();

    $('#btn_confirm_approve').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Approving...');

    $.ajax({
        url: "<?= base_url('leave_con/admin_action') ?>",
        type: "POST",
        dataType: "json",
        data: {
            action: 'approve',
            leave_id: id,
            admin_remarks: remarks
        },
        success: function(res) {
            $('#btn_confirm_approve').prop('disabled', false).html('<i class="fa fa-check"></i> Confirm Approval');
            if (res.status === 'success') {
                $('#approveModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Approved!', text: res.message, timer: 2500 });
                loadAdminStats();
                loadAdminData(currentAdminPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Action Failed', text: res.message });
            }
        },
        error: function() {
            $('#btn_confirm_approve').prop('disabled', false).html('<i class="fa fa-check"></i> Confirm Approval');
            Swal.fire({ icon: 'error', title: 'Error', text: 'Server communication error.' });
        }
    });
}

// REJECT
function openRejectModal(id, empName, summary) {
    $('#reject_leave_id').val(id);
    $('#reject_emp_name').text(empName);
    $('#reject_leave_summary').text(summary);
    $('#reject_reason').val('');
    $('#rejectModal').modal('show');
}

function executeReject() {
    let id = $('#reject_leave_id').val();
    let reason = $('#reject_reason').val().trim();

    if (!reason) {
        Swal.fire({ icon: 'warning', title: 'Reason Required', text: 'Please provide a reason for rejecting this leave request.' });
        return;
    }

    $('#btn_confirm_reject').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Rejecting...');

    $.ajax({
        url: "<?= base_url('leave_con/admin_action') ?>",
        type: "POST",
        dataType: "json",
        data: {
            action: 'reject',
            leave_id: id,
            rejection_reason: reason
        },
        success: function(res) {
            $('#btn_confirm_reject').prop('disabled', false).html('<i class="fa fa-ban"></i> Reject Request');
            if (res.status === 'success') {
                $('#rejectModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Rejected', text: res.message, timer: 2500 });
                loadAdminStats();
                loadAdminData(currentAdminPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Action Failed', text: res.message });
            }
        },
        error: function() {
            $('#btn_confirm_reject').prop('disabled', false).html('<i class="fa fa-ban"></i> Reject Request');
            Swal.fire({ icon: 'error', title: 'Error', text: 'Server communication error.' });
        }
    });
}

// RETURN
function openReturnModal(id, empName, summary) {
    $('#return_leave_id').val(id);
    $('#return_emp_name').text(empName);
    $('#return_leave_summary').text(summary);
    $('#return_reason').val('');
    $('#returnModal').modal('show');
}

function executeReturn() {
    let id = $('#return_leave_id').val();
    let reason = $('#return_reason').val().trim();

    if (!reason) {
        Swal.fire({ icon: 'warning', title: 'Instruction Required', text: 'Please explain what needs modification before return.' });
        return;
    }

    $('#btn_confirm_return').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Returning...');

    $.ajax({
        url: "<?= base_url('leave_con/admin_action') ?>",
        type: "POST",
        dataType: "json",
        data: {
            action: 'return',
            leave_id: id,
            return_reason: reason
        },
        success: function(res) {
            $('#btn_confirm_return').prop('disabled', false).html('<i class="fa fa-reply"></i> Return Request');
            if (res.status === 'success') {
                $('#returnModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Returned to HR', text: res.message, timer: 2500 });
                loadAdminStats();
                loadAdminData(currentAdminPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Action Failed', text: res.message });
            }
        },
        error: function() {
            $('#btn_confirm_return').prop('disabled', false).html('<i class="fa fa-reply"></i> Return Request');
            Swal.fire({ icon: 'error', title: 'Error', text: 'Server communication error.' });
        }
    });
}

// MODIFY
function openModifyModal(id) {
    $.ajax({
        url: "<?= base_url('leave_con/get_leave_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                let l = res.leave;
                $('#modify_leave_id').val(l.id);
                $('#modify_emp_name').text(l.name_en || 'Emp #' + l.emp_id);
                $('#modify_emp_details').text(`ID: ${l.emp_id} | Dept: ${l.dept_name || '-'} | Applied: ${l.total_leave} day(s) (${l.leave_type.toUpperCase()})`);
                $('#modify_leave_type').val(l.leave_type);
                $('#modify_from_date').val(l.leave_start);
                $('#modify_to_date').val(l.leave_end);
                $('#modify_total_days').val(l.total_leave);
                $('#modify_remarks').val(l.admin_remarks || '');
                $('#modifyModal').modal('show');
            }
        }
    });
}

function calculateModifyDays() {
    let d1 = new Date($('#modify_from_date').val());
    let d2 = new Date($('#modify_to_date').val());
    if (d2 >= d1) {
        let diff = Math.ceil(Math.abs(d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
        $('#modify_total_days').val(diff);
    } else {
        $('#modify_total_days').val(0);
    }
}

function executeModify(modAction) {
    let id = $('#modify_leave_id').val();
    let leave_type = $('#modify_leave_type').val();
    let from_date = $('#modify_from_date').val();
    let to_date = $('#modify_to_date').val();
    let remarks = $('#modify_remarks').val();

    if (!leave_type || !from_date || !to_date) {
        Swal.fire({ icon: 'warning', title: 'Input Required', text: 'Please fill in Leave Type and Dates.' });
        return;
    }

    $.ajax({
        url: "<?= base_url('leave_con/admin_action') ?>",
        type: "POST",
        dataType: "json",
        data: {
            action: 'modify',
            leave_id: id,
            mod_leave_type: leave_type,
            mod_from_date: from_date,
            mod_to_date: to_date,
            mod_remarks: remarks,
            mod_action: modAction
        },
        success: function(res) {
            if (res.status === 'success') {
                $('#modifyModal').modal('hide');
                Swal.fire({ icon: 'success', title: 'Updated!', text: res.message, timer: 2500 });
                loadAdminStats();
                loadAdminData(currentAdminPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Modification Failed', text: res.message });
            }
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Server communication error.' });
        }
    });
}

// VIEW DETAILS (ADMIN)
function viewAdminDetails(id) {
    $('#adminViewBody').html(`
        <div class="text-center" style="padding: 40px; color: #64748b;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <div style="margin-top: 8px;">Loading request details...</div>
        </div>
    `);
    $('#adminViewModal').modal('show');

    $.ajax({
        url: "<?= base_url('leave_con/get_leave_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                renderAdminDetailsBody(res.leave, res.balances, res.history);
            } else {
                $('#adminViewBody').html(`<div class="alert alert-danger">${res.message || 'Error'}</div>`);
            }
        }
    });
}

function renderAdminDetailsBody(leave, balances, history) {
    let empName = leave.name_en || 'Emp #' + leave.emp_id;
    let initial = empName.charAt(0).toUpperCase();

    let statusBadge = '';
    if (leave.status === 'pending') statusBadge = `<span class="badge-status badge-pending"><i class="fa fa-clock-o"></i> Pending</span>`;
    else if (leave.status === 'approved') statusBadge = `<span class="badge-status badge-approved"><i class="fa fa-check-circle"></i> Approved</span>`;
    else if (leave.status === 'rejected') statusBadge = `<span class="badge-status badge-rejected"><i class="fa fa-times-circle"></i> Rejected</span>`;
    else if (leave.status === 'returned') statusBadge = `<span class="badge-status badge-returned"><i class="fa fa-reply"></i> Returned</span>`;

    // Balances
    let b = balances;
    let balHtml = `
        <div style="display: flex; gap: 8px; margin-bottom: 14px; flex-wrap: wrap;">
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:6px 12px; font-size:12px;">
                CL: <strong>${b.cl.balance}</strong> / ${b.cl.entitled}
            </div>
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:6px 12px; font-size:12px;">
                SL: <strong>${b.sl.balance}</strong> / ${b.sl.entitled}
            </div>
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:6px 12px; font-size:12px;">
                EL: <strong>${b.el.balance}</strong>
            </div>
            ${b.gender === 'Female' ? `<div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:6px 12px; font-size:12px;">ML: <strong>${b.ml.balance}</strong> / ${b.ml.entitled}</div>` : ''}
            ${b.gender === 'Male' ? `<div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:6px; padding:6px 12px; font-size:12px;">PL: <strong>${b.pl.balance}</strong> / ${b.pl.entitled}</div>` : ''}
        </div>
    `;

    // Timeline
    let timelineHtml = '<div class="audit-timeline">';
    if (history && history.length > 0) {
        history.forEach(function(item) {
            timelineHtml += `
                <div class="timeline-item ${item.action || ''}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div style="font-size: 11px; color: #64748b;">${item.timestamp} &bull; <strong>${escapeHtml(item.by_name || 'System')}</strong> (${item.action})</div>
                        <div style="font-size: 12px; color: #1e293b; margin-top: 2px;">${escapeHtml(item.note || item.reason || '-')}</div>
                    </div>
                </div>
            `;
        });
    } else {
        timelineHtml += '<div style="font-size:12px; color:#94a3b8;">No audit history recorded.</div>';
    }
    timelineHtml += '</div>';

    let html = `
        <div style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:12px 16px; border-radius:8px; margin-bottom:15px;">
            <div>
                <h4 style="margin:0; font-weight:700; color:#0f172a;">${escapeHtml(empName)} (ID: ${leave.emp_id})</h4>
                <div style="font-size:12px; color:#64748b;">Dept: ${escapeHtml(leave.dept_name || '-')} | Desig: ${escapeHtml(leave.desig_name || '-')} | Unit: ${escapeHtml(leave.unit_name || '-')}</div>
            </div>
            <div>${statusBadge}</div>
        </div>

        <label style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Live Leave Balances</label>
        ${balHtml}

        <table class="table table-bordered" style="font-size:13px;">
            <tr><td width="35%" class="text-muted">Leave Type</td><td><span class="type-badge type-${leave.leave_type}">${leave.leave_type.toUpperCase()}</span></td></tr>
            <tr><td class="text-muted">Date Range</td><td><strong>${leave.leave_start}</strong> to <strong>${leave.leave_end}</strong> (${leave.total_leave} days)</td></tr>
            <tr><td class="text-muted">Reason</td><td>${escapeHtml(leave.leave_descrip || 'None')}</td></tr>
            <tr><td class="text-muted">Remarks / Extension</td><td>${escapeHtml(leave.add_on_vacation || 'None')}</td></tr>
            <tr><td class="text-muted">Submitted By</td><td>${escapeHtml(leave.applied_by_name || 'HR')} at ${leave.applied_at || '-'}</td></tr>
            <tr><td class="text-muted">Admin Action By</td><td>${escapeHtml(leave.admin_name || 'Pending')} at ${leave.admin_action_at || '-'}</td></tr>
            ${leave.admin_remarks ? `<tr><td class="text-muted">Admin Remarks</td><td class="text-success font-weight-bold">${escapeHtml(leave.admin_remarks)}</td></tr>` : ''}
            ${leave.rejection_reason ? `<tr><td class="text-muted">Rejection Reason</td><td class="text-danger font-weight-bold">${escapeHtml(leave.rejection_reason)}</td></tr>` : ''}
            ${leave.return_reason ? `<tr><td class="text-muted">Return Reason</td><td class="text-purple font-weight-bold">${escapeHtml(leave.return_reason)}</td></tr>` : ''}
        </table>

        <h5 style="font-weight:700; color:#334155; margin-top:20px;"><i class="fa fa-history"></i> Complete History Audit Trail</h5>
        ${timelineHtml}
    `;

    $('#adminViewBody').html(html);
}
</script>
