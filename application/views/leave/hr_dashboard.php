<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
/* Modern HRM Dashboard Styles */
.leave-dashboard-wrapper {
    padding: 20px 15px;
    font-family: 'Roboto', -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: #2c3e50;
}
.page-header-box {
    background: #ffffff;
    border-radius: 8px;
    padding: 20px 24px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-left: 4px solid #3498db;
}
.page-header-box h2 {
    margin: 0 0 5px 0;
    font-size: 22px;
    font-weight: 700;
    color: #1a252f;
}
.page-header-box p {
    margin: 0;
    color: #7f8c8d;
    font-size: 13px;
}
.stat-card {
    background: #ffffff;
    border-radius: 8px;
    padding: 18px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
    border-top: 3px solid transparent;
}
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
.stat-card.active-stat {
    border-top: 3px solid #2980b9;
    background: #f8fafc;
}
.stat-icon-wrapper {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-right: 16px;
    flex-shrink: 0;
}
.stat-info h3 {
    margin: 0 0 4px 0;
    font-size: 24px;
    font-weight: 700;
    line-height: 1;
}
.stat-info span {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    white-space: nowrap;
}
/* Stat theme variations */
.stat-blue .stat-icon-wrapper { background: #e0f2fe; color: #0284c7; }
.stat-blue h3 { color: #0369a1; }
.stat-amber .stat-icon-wrapper { background: #fef3c7; color: #d97706; }
.stat-amber h3 { color: #b45309; }
.stat-green .stat-icon-wrapper { background: #dcfce7; color: #16a34a; }
.stat-green h3 { color: #15803d; }
.stat-red .stat-icon-wrapper { background: #fee2e2; color: #dc2626; }
.stat-red h3 { color: #b91c1c; }
.stat-purple .stat-icon-wrapper { background: #f3e8ff; color: #9333ea; }
.stat-purple h3 { color: #7e22ce; }

/* Filter & Content Panels */
.main-panel {
    background: #ffffff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.04);
    margin-bottom: 25px;
    overflow: hidden;
}
.panel-header-bar {
    padding: 16px 20px;
    border-bottom: 1px solid #edf2f7;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafbfc;
}
.panel-header-bar h4 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #334155;
}
.filter-box {
    padding: 18px 20px;
    background: #ffffff;
    border-bottom: 1px solid #edf2f7;
}
.filter-box .form-group {
    margin-bottom: 10px;
}
.filter-box label {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 4px;
}

/* Modern Data Table */
.modern-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}
.modern-table thead th {
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
.modern-table tbody td {
    padding: 12px 14px;
    font-size: 13px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    white-space: nowrap;
}
.modern-table tbody tr:hover {
    background-color: #f8fafc;
}
.emp-meta-box {
    display: flex;
    align-items: center;
    gap: 10px;
}
.emp-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #475569;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
}
.emp-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.emp-details {
    line-height: 1.3;
}
.emp-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 13px;
}
.emp-id-badge {
    font-size: 11px;
    color: #64748b;
}

/* Status Badges */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 9px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.badge-pending {
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}
.badge-approved {
    background: #dcfce7;
    color: #15803d;
    border: 1px solid #bbf7d0;
}
.badge-rejected {
    background: #fee2e2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}
.badge-returned {
    background: #f3e8ff;
    color: #7e22ce;
    border: 1px solid #e9d5ff;
}

/* Leave Type Badges */
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

/* Action buttons */
.btn-action-icon {
    width: 30px;
    height: 30px;
    padding: 0;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    margin: 0 2px;
    transition: all 0.2s ease;
}

/* Balance Cards in Modal */
.bal-card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
    gap: 10px;
    margin-bottom: 15px;
}
.bal-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px;
    text-align: center;
}
.bal-card .bal-title {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
}
.bal-card .bal-val {
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    margin-top: 2px;
}
.bal-card.bal-avail {
    border-color: #bbf7d0;
    background: #f0fdf4;
}
.bal-card.bal-avail .bal-val {
    color: #16a34a;
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
    margin-bottom: 18px;
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
.timeline-item.returned .timeline-dot { background: #9333ea; }
.timeline-content {
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    border-radius: 6px;
    padding: 8px 12px;
}
.timeline-time {
    font-size: 11px;
    color: #64748b;
    margin-bottom: 2px;
}
.timeline-text {
    font-size: 12px;
    color: #334155;
    font-weight: 500;
}
</style>

<div class="content leave-dashboard-wrapper">
    <!-- Header Banner -->
    <div class="page-header-box">
        <div>
            <h2><i class="fa fa-calendar-check-o" style="color: #3498db; margin-right: 8px;"></i> HR Leave Management Dashboard</h2>
            <p>Create and submit employee leaves, monitor live approval workflows, and check balance entitlements.</p>
        </div>
        <div>
            <a href="<?= base_url('entry_system_con/leave_transation') ?>" class="btn btn-success" style="font-weight: 600; padding: 8px 16px; border-radius: 6px; box-shadow: 0 2px 6px rgba(46, 204, 113, 0.3);">
                <i class="fa fa-plus-circle"></i> New Leave Entry
            </a>
        </div>
    </div>

    <!-- Statistics Summary Cards -->
    <div style="display: flex; gap: 14px; margin-bottom: 22px; flex-wrap: wrap;">
        <div style="flex: 1 1 180px; min-width: 140px;">
            <div class="stat-card stat-blue" onclick="filterByCardStatus('')">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-folder-open"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat_total">0</h3>
                    <span>Total</span>
                </div>
            </div>
        </div>
        <div style="flex: 1 1 180px; min-width: 140px;">
            <div class="stat-card stat-amber" onclick="filterByCardStatus('pending')">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-hourglass-half"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat_pending">0</h3>
                    <span>Pending</span>
                </div>
            </div>
        </div>
        <div style="flex: 1 1 180px; min-width: 140px;">
            <div class="stat-card stat-green" onclick="filterByCardStatus('approved')">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat_approved">0</h3>
                    <span>Approved</span>
                </div>
            </div>
        </div>
        <div style="flex: 1 1 180px; min-width: 140px;">
            <div class="stat-card stat-red" onclick="filterByCardStatus('rejected')">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat_rejected">0</h3>
                    <span>Rejected</span>
                </div>
            </div>
        </div>
        <div style="flex: 1 1 180px; min-width: 140px;">
            <div class="stat-card stat-purple" onclick="filterByCardStatus('returned')">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-reply"></i>
                </div>
                <div class="stat-info">
                    <h3 id="stat_returned">0</h3>
                    <span>Returned</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Panel: Filters + Table -->
    <div class="main-panel">
        <div class="panel-header-bar">
            <h4><i class="fa fa-list-alt text-primary"></i> Leave Requests & Approval Tracker</h4>
            <div style="font-size: 12px; color: #64748b;">
                <span class="badge badge-info" id="record_count_badge">0 records</span>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-box">
            <form id="hr_filter_form" onsubmit="event.preventDefault(); loadLeaveData(1);">
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-search"></i> Employee (ID or Name)</label>
                            <input type="text" class="form-control input-sm" id="f_emp_id" placeholder="Enter Emp ID or Name..." oninput="debounceFilter()">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-building"></i> Department</label>
                            <select class="form-control input-sm" id="f_dept_id" onchange="loadLeaveData(1)">
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
                            <select class="form-control input-sm" id="f_leave_type" onchange="loadLeaveData(1)">
                                <option value="">All Types</option>
                                <?php foreach($leave_types as $k => $v): ?>
                                    <option value="<?= $k ?>"><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6">
                        <div class="form-group">
                            <label><i class="fa fa-filter"></i> Status</label>
                            <select class="form-control input-sm" id="f_status" onchange="loadLeaveData(1)">
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
                            <label><i class="fa fa-calendar"></i> Date Range (Start Date)</label>
                            <div class="input-group input-group-sm">
                                <input type="date" class="form-control" id="f_from_date" onchange="loadLeaveData(1)">
                                <span class="input-group-addon">to</span>
                                <input type="date" class="form-control" id="f_to_date" onchange="loadLeaveData(1)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-left" style="margin-bottom: 6px;">
                        <button type="button" class="btn btn-success btn-sm" onclick="exportHrLeave('excel')" style="font-weight: 600; margin-right: 6px;">
                            <i class="fa fa-file-excel-o"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="exportHrLeave('pdf')" style="font-weight: 600;">
                            <i class="fa fa-file-pdf-o"></i> Export PDF / Print
                        </button>
                    </div>
                    <div class="col-sm-6 text-right" style="margin-bottom: 6px;">
                        <button type="button" class="btn btn-default btn-sm" onclick="resetFilters()">
                            <i class="fa fa-refresh"></i> Reset Filters
                        </button>
                        <button type="button" class="btn btn-primary btn-sm" onclick="loadLeaveData(1)">
                            <i class="fa fa-search"></i> Apply Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table View -->
        <div class="table-responsive">
            <table class="table modern-table" id="leave_table">
                <thead>
                    <tr>
                        <th width="40">SL</th>
                        <th>Employee</th>
                        <th>Department & Designation</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th width="70">Days</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th width="120" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="leave_tbody">
                    <tr>
                        <td colspan="9" class="text-center" style="padding: 40px; color: #94a3b8;">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                            <div style="margin-top: 8px;">Loading leave records...</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="padding: 14px 20px; background: #fafbfc; border-top: 1px solid #edf2f7; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <div style="font-size: 13px; color: #64748b;" id="pagination_info">
                Showing 0 to 0 of 0 entries
            </div>
            <ul class="pagination pagination-sm" id="pagination_controls" style="margin: 0;">
                <!-- dynamic pagination links -->
            </ul>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 1: NEW LEAVE ENTRY -->
<!-- ========================================================================= -->
<div class="modal fade" id="newLeaveModal" tabindex="-1" role="dialog" aria-labelledby="newLeaveModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #006ba3; color: #ffffff; padding: 16px 22px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-plus-circle"></i> Create & Submit Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 22px;">
                <form id="newLeaveForm" onsubmit="event.preventDefault(); submitNewLeave();">
                    <!-- Step 1: Employee Search -->
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; margin-bottom: 18px;">
                        <label style="font-size: 13px; font-weight: 600; color: #1e293b; margin-bottom: 6px;">
                            <i class="fa fa-user"></i> Select Employee
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="modal_emp_id" placeholder="Enter Employee ID (e.g. 2001, 1005)..." autofocus>
                            <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" onclick="fetchEmployeeInfo()">
                                    <i class="fa fa-search"></i> Find Employee
                                </button>
                            </span>
                        </div>
                        <div id="emp_fetch_spinner" style="display:none; margin-top: 8px; font-size: 12px; color: #0284c7;">
                            <i class="fa fa-spinner fa-spin"></i> Fetching profile and live leave balances...
                        </div>
                    </div>

                    <!-- Employee Profile & Live Balance Widget -->
                    <div id="emp_profile_card" style="display:none; margin-bottom: 20px;">
                        <div style="background: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 14px; margin-bottom: 14px;">
                            <div class="row" style="display:flex; align-items:center;">
                                <div class="col-xs-3 col-sm-2 text-center">
                                    <div class="emp-avatar" style="width: 55px; height: 55px; font-size: 18px; margin: 0 auto;" id="modal_avatar">
                                        E
                                    </div>
                                </div>
                                <div class="col-xs-9 col-sm-10">
                                    <div style="font-weight: 700; font-size: 15px; color: #0f172a;" id="modal_emp_name">-</div>
                                    <div style="font-size: 12px; color: #64748b;">
                                        ID: <span id="modal_emp_id_display" style="font-weight: 600;">-</span> |
                                        Dept: <span id="modal_emp_dept">-</span> |
                                        Designation: <span id="modal_emp_desig">-</span>
                                    </div>
                                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                        Gender: <span id="modal_emp_gender">-</span> |
                                        Join Date: <span id="modal_emp_join">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Balances Overview -->
                        <div style="margin-bottom: 15px;">
                            <label style="font-size: 12px; font-weight: 600; color: #475569; text-transform: uppercase;">
                                <i class="fa fa-balance-scale"></i> Current Year Leave Balances
                            </label>
                            <div class="bal-card-grid">
                                <div class="bal-card bal-avail">
                                    <div class="bal-title">Casual (CL)</div>
                                    <div class="bal-val" id="bal_cl">0 / 0</div>
                                </div>
                                <div class="bal-card bal-avail">
                                    <div class="bal-title">Sick (SL)</div>
                                    <div class="bal-val" id="bal_sl">0 / 0</div>
                                </div>
                                <div class="bal-card bal-avail">
                                    <div class="bal-title">Earn (EL)</div>
                                    <div class="bal-val" id="bal_el">0</div>
                                </div>
                                <div class="bal-card" id="card_bal_ml">
                                    <div class="bal-title">Maternity (ML)</div>
                                    <div class="bal-val" id="bal_ml">0 / 0</div>
                                </div>
                                <div class="bal-card" id="card_bal_pl">
                                    <div class="bal-title">Paternity (PL)</div>
                                    <div class="bal-val" id="bal_pl">0 / 0</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Form Details -->
                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 13px;">Leave Type <span class="text-danger">*</span></label>
                                <select class="form-control" id="modal_leave_type" required onchange="calculateModalDays()">
                                    <option value="">Select Leave Type</option>
                                    <option value="cl">Casual Leave (CL)</option>
                                    <option value="sl">Sick Leave (SL)</option>
                                    <option value="el">Earn Leave (EL)</option>
                                    <option value="ml">Maternity Leave (ML)</option>
                                    <option value="pl">Paternity Leave (PL)</option>
                                    <option value="wp">Without Pay (WP)</option>
                                    <option value="sp">Special Leave (SP)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 13px;">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="modal_from_date" required onchange="calculateModalDays()">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 13px;">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="modal_to_date" required onchange="calculateModalDays()">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 13px;">Total Leave Days</label>
                                <input type="number" class="form-control" id="modal_total_days" readonly style="background: #f1f5f9; font-weight: 700; color: #1e293b;">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 13px;">Application Date</label>
                                <input type="date" class="form-control" id="modal_apply_date" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 13px;">Add on Vacation / Remarks</label>
                                <input type="text" class="form-control" id="modal_addon_vacation" placeholder="e.g. Include Friday/Saturday...">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="font-weight: 600; font-size: 13px;">Reason for Leave</label>
                        <textarea class="form-control" id="modal_reason" rows="2" placeholder="Specify reason for leave..."></textarea>
                    </div>

                    <div class="alert alert-info" style="font-size: 12px; margin-bottom: 0;">
                        <i class="fa fa-info-circle"></i> <strong>Approval Policy:</strong> Leave requests submitted by HR will be marked as <strong>Pending Admin Approval</strong> and routed to the Admin approval queue. Leave will not be deducted until approved.
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #edf2f7; padding: 14px 22px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_submit_leave" onclick="submitNewLeave()" style="font-weight: 600;">
                    <i class="fa fa-paper-plane"></i> Submit for Approval
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 2: VIEW DETAILS & TIMELINE -->
<!-- ========================================================================= -->
<div class="modal fade" id="viewDetailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #006ba3; color: #ffffff; padding: 16px 22px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-file-text-o"></i> Leave Request Details & Audit Trail</h4>
            </div>
            <div class="modal-body" style="padding: 22px;" id="viewDetailsBody">
                <!-- dynamic content loaded via AJAX -->
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL 3: RESUBMIT RETURNED LEAVE -->
<!-- ========================================================================= -->
<div class="modal fade" id="resubmitModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px; overflow: hidden;">
            <div class="modal-header" style="background: #7e22ce; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-edit"></i> Modify & Resubmit Returned Request</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="alert alert-warning" id="resubmit_admin_reason_box" style="font-size: 13px;">
                    <strong><i class="fa fa-comment"></i> Admin's Return Note:</strong>
                    <div id="resubmit_return_reason" style="margin-top: 4px; font-weight: 500;"></div>
                </div>

                <form id="resubmitForm" onsubmit="event.preventDefault(); submitResubmission();">
                    <input type="hidden" id="resubmit_leave_id">
                    <div class="form-group">
                        <label>Leave Type</label>
                        <select class="form-control" id="resubmit_leave_type" required onchange="calculateResubmitDays()">
                            <option value="cl">Casual Leave (CL)</option>
                            <option value="sl">Sick Leave (SL)</option>
                            <option value="el">Earn Leave (EL)</option>
                            <option value="ml">Maternity Leave (ML)</option>
                            <option value="pl">Paternity Leave (PL)</option>
                            <option value="wp">Without Pay (WP)</option>
                            <option value="sp">Special Leave (SP)</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Start Date</label>
                                <input type="date" class="form-control" id="resubmit_from_date" required onchange="calculateResubmitDays()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>End Date</label>
                                <input type="date" class="form-control" id="resubmit_to_date" required onchange="calculateResubmitDays()">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Total Days</label>
                        <input type="number" class="form-control" id="resubmit_total_days" readonly style="background: #f1f5f9; font-weight: 700;">
                    </div>
                    <div class="form-group">
                        <label>Reason</label>
                        <textarea class="form-control" id="resubmit_reason" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Remarks / Vacation Extension</label>
                        <input type="text" class="form-control" id="resubmit_addon">
                    </div>
                    <div class="form-group">
                        <label>HR Resubmission Note to Admin</label>
                        <textarea class="form-control" id="resubmit_note" rows="2" placeholder="Explain the corrections made..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="submitResubmission()" style="background: #7e22ce; border-color: #6b21a8; font-weight: 600;">
                    <i class="fa fa-send"></i> Resubmit for Approval
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentPage = 1;
let currentLimit = 15;
let filterDebounceTimer;
let currentEmpBalances = null;

$(document).ready(function() {
    loadHRStats();
    loadLeaveData(1);

    // Enter key support for modal search
    $('#modal_emp_id').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            fetchEmployeeInfo();
        }
    });
});

function debounceFilter() {
    clearTimeout(filterDebounceTimer);
    filterDebounceTimer = setTimeout(function() {
        loadLeaveData(1);
    }, 400);
}

function filterByCardStatus(status) {
    $('#f_status').val(status ? status : 'all');
    $('.stat-card').removeClass('active-stat');
    if (status) {
        $(`[onclick*="'${status}'"]`).addClass('active-stat');
    }
    loadLeaveData(1);
}

function resetFilters() {
    $('#hr_filter_form')[0].reset();
    $('#f_status').val('all');
    $('.stat-card').removeClass('active-stat');
    loadLeaveData(1);
}

function exportHrLeave(format) {
    let emp_id = $('#f_emp_id').val() || '';
    let dept_id = $('#f_dept_id').val() || '';
    let leave_type = $('#f_leave_type').val() || '';
    let status = $('#f_status').val() || '';
    let from_date = $('#f_from_date').val() || '';
    let to_date = $('#f_to_date').val() || '';

    let params = new URLSearchParams({
        emp_id: emp_id,
        dept_id: dept_id,
        leave_type: leave_type,
        status: status,
        from_date: from_date,
        to_date: to_date
    });

    if (format === 'excel') {
        window.location.href = "<?= base_url('entry_system_con/export_leave_excel') ?>?" + params.toString();
    } else if (format === 'pdf') {
        window.open("<?= base_url('entry_system_con/export_leave_pdf') ?>?" + params.toString(), '_blank');
    }
}

function loadHRStats() {
    $.ajax({
        url: "<?= base_url('leave_con/hr_stats_ajax') ?>",
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                $('#stat_total').text(res.data.total_entries);
                $('#stat_pending').text(res.data.pending_admin);
                $('#stat_approved').text(res.data.approved);
                $('#stat_rejected').text(res.data.rejected);
                $('#stat_returned').text(res.data.returned);
            }
        }
    });
}

function loadLeaveData(page) {
    currentPage = page || 1;
    let emp_id = $('#f_emp_id').val();
    let dept_id = $('#f_dept_id').val();
    let leave_type = $('#f_leave_type').val();
    let status = $('#f_status').val();
    let from_date = $('#f_from_date').val();
    let to_date = $('#f_to_date').val();

    $('#leave_tbody').html(`
        <tr>
            <td colspan="9" class="text-center" style="padding: 40px; color: #94a3b8;">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
                <div style="margin-top: 8px;">Loading leave records...</div>
            </td>
        </tr>
    `);

    $.ajax({
        url: "<?= base_url('leave_con/hr_leave_list_ajax') ?>",
        type: "POST",
        dataType: "json",
        data: {
            page: currentPage,
            limit: currentLimit,
            emp_id: emp_id,
            dept_id: dept_id,
            leave_type: leave_type,
            status: status,
            from_date: from_date,
            to_date: to_date
        },
        success: function(res) {
            if (res.status === 'success') {
                renderTable(res.data, res.current_page, res.limit, res.total_rows);
                renderPagination(res.current_page, res.total_pages);
                $('#record_count_badge').text(res.total_rows + ' records');
                let start = res.total_rows === 0 ? 0 : (res.current_page - 1) * res.limit + 1;
                let end = Math.min(res.current_page * res.limit, res.total_rows);
                $('#pagination_info').text(`Showing ${start} to ${end} of ${res.total_rows} entries`);
            }
        },
        error: function() {
            $('#leave_tbody').html(`
                <tr>
                    <td colspan="9" class="text-center text-danger" style="padding: 30px;">
                        <i class="fa fa-exclamation-triangle fa-2x"></i>
                        <div>Failed to load data. Please refresh the page.</div>
                    </td>
                </tr>
            `);
        }
    });
}

function renderTable(rows, page, limit, total) {
    if (!rows || rows.length === 0) {
        $('#leave_tbody').html(`
            <tr>
                <td colspan="9" class="text-center" style="padding: 50px 20px; color: #94a3b8;">
                    <i class="fa fa-inbox fa-3x" style="opacity: 0.5;"></i>
                    <h5 style="margin-top: 10px; font-weight: 600; color: #64748b;">No leave records found</h5>
                    <p style="font-size: 13px; margin: 0;">Try adjusting your search criteria or create a new leave entry.</p>
                </td>
            </tr>
        `);
        return;
    }

    let html = '';
    let startSL = (page - 1) * limit;

    rows.forEach(function(row, idx) {
        let sl = startSL + idx + 1;
        let empName = row.name_en || 'Employee #' + row.emp_id;
        let initial = empName.charAt(0).toUpperCase();
        let avatarHtml = row.img_source 
            ? `<img src="<?= base_url() ?>assets/images/employee/${row.img_source}" alt="${initial}" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\\'http://www.w3.org/2000/svg\\' width=\\'36\\' height=\\'36\\'><rect width=\\'100%\\' height=\\'100%\\' fill=\\'%23e2e8f0\\'/><text x=\\'50%\\' y=\\'55%\\' font-size=\\'14\\' font-weight=\\'bold\\' fill=\\'%2364748b\\' dominant-baseline=\\'middle\\' text-anchor=\\'middle\\'>${initial}</text></svg>'">`
            : initial;

        // Status badge
        let statusBadge = '';
        if (row.status === 'pending') {
            statusBadge = `<span class="badge-status badge-pending"><i class="fa fa-clock-o"></i> Pending Admin</span>`;
        } else if (row.status === 'approved') {
            statusBadge = `<span class="badge-status badge-approved"><i class="fa fa-check-circle"></i> Approved</span>`;
        } else if (row.status === 'rejected') {
            statusBadge = `<span class="badge-status badge-rejected" title="${row.rejection_reason || ''}"><i class="fa fa-times-circle"></i> Rejected</span>`;
        } else if (row.status === 'returned') {
            statusBadge = `<span class="badge-status badge-returned" title="${row.return_reason || ''}"><i class="fa fa-reply"></i> Returned</span>`;
        }

        // Leave type badge
        let typeBadge = `<span class="type-badge type-${row.leave_type}">${(row.leave_type || '').toUpperCase()}</span>`;

        // Format dates
        let datesFormatted = `${row.leave_start} <span style="color:#94a3b8;">to</span> ${row.leave_end}`;

        // Action buttons
        let actions = `
            <button class="btn btn-default btn-action-icon" title="View Details" onclick="viewLeaveDetails(${row.id})">
                <i class="fa fa-eye text-primary"></i>
            </button>
        `;

        if (row.status === 'returned') {
            actions += `
                <button class="btn btn-warning btn-action-icon" title="Modify & Resubmit" onclick="openResubmitModal(${row.id})">
                    <i class="fa fa-pencil"></i>
                </button>
            `;
        }

        html += `
            <tr>
                <td>${sl}</td>
                <td>
                    <div class="emp-details">
                        <div class="emp-name">${escapeHtml(empName)}</div>
                        <div class="emp-id-badge">ID: ${row.emp_id}</div>
                    </div>
                </td>
                <td>
                    <div style="font-weight: 500;">${escapeHtml(row.dept_name || '-')}</div>
                    <div style="font-size: 11px; color: #64748b;">${escapeHtml(row.desig_name || '-')}</div>
                </td>
                <td>${typeBadge}</td>
                <td>${datesFormatted}</td>
                <td><strong>${row.total_leave}</strong> <span style="color:#94a3b8;font-size:11px;">day(s)</span></td>
                <td>${statusBadge}</td>
                <td>
                    <div style="font-size: 12px;">${row.applied_at ? row.applied_at.substring(0, 10) : (row.start_date || '-')}</div>
                    <div style="font-size: 11px; color: #94a3b8;">By: ${escapeHtml(row.applied_by_name || 'HR')}</div>
                </td>
                <td class="text-center">${actions}</td>
            </tr>
        `;
    });

    $('#leave_tbody').html(html);
}

function renderPagination(current, total) {
    if (total <= 1) {
        $('#pagination_controls').html('');
        return;
    }

    let html = '';
    // Previous
    if (current > 1) {
        html += `<li><a href="javascript:void(0)" onclick="loadLeaveData(${current - 1})">&laquo;</a></li>`;
    } else {
        html += `<li class="disabled"><span>&laquo;</span></li>`;
    }

    let start = Math.max(1, current - 2);
    let end = Math.min(total, current + 2);

    for (let i = start; i <= end; i++) {
        if (i === current) {
            html += `<li class="active"><span>${i}</span></li>`;
        } else {
            html += `<li><a href="javascript:void(0)" onclick="loadLeaveData(${i})">${i}</a></li>`;
        }
    }

    // Next
    if (current < total) {
        html += `<li><a href="javascript:void(0)" onclick="loadLeaveData(${current + 1})">&raquo;</a></li>`;
    } else {
        html += `<li class="disabled"><span>&raquo;</span></li>`;
    }

    $('#pagination_controls').html(html);
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

// =========================================================================
// MODAL WORKFLOWS
// =========================================================================

function openNewLeaveModal() {
    $('#newLeaveForm')[0].reset();
    $('#modal_apply_date').val(new Date().toISOString().substring(0, 10));
    $('#emp_profile_card').hide();
    currentEmpBalances = null;
    $('#newLeaveModal').modal('show');
}

function fetchEmployeeInfo() {
    let emp_id = $('#modal_emp_id').val().trim();
    if (!emp_id) {
        Swal.fire({ icon: 'warning', title: 'Input Required', text: 'Please enter an Employee ID.' });
        return;
    }

    $('#emp_fetch_spinner').show();

    $.ajax({
        url: "<?= base_url('leave_con/get_emp_info_balance_ajax') ?>",
        type: "POST",
        dataType: "json",
        data: { emp_id: emp_id },
        success: function(res) {
            $('#emp_fetch_spinner').hide();
            if (res.status === 'success') {
                let emp = res.emp;
                currentEmpBalances = res.balances;

                $('#modal_emp_name').text(emp.name_en || 'Employee #' + emp.emp_id);
                $('#modal_emp_id_display').text(emp.emp_id);
                $('#modal_emp_dept').text(emp.dept_name || '-');
                $('#modal_emp_desig').text(emp.desig_name || '-');
                $('#modal_emp_gender').text(emp.gender || '-');
                $('#modal_emp_join').text(emp.emp_join_date || '-');

                let initial = (emp.name_en || 'E').charAt(0).toUpperCase();
                $('#modal_avatar').text(initial);

                // Update Balances
                let b = res.balances;
                $('#bal_cl').text(`${b.cl.balance} left (of ${b.cl.entitled})`);
                $('#bal_sl').text(`${b.sl.balance} left (of ${b.sl.entitled})`);
                $('#bal_el').text(`${b.el.balance} days`);
                $('#bal_ml').text(`${b.ml.balance} left (of ${b.ml.entitled})`);
                $('#bal_pl').text(`${b.pl.balance} left (of ${b.pl.entitled})`);

                if (emp.gender === 'Female') {
                    $('#card_bal_ml').show();
                    $('#card_bal_pl').hide();
                } else {
                    $('#card_bal_ml').hide();
                    $('#card_bal_pl').show();
                }

                $('#emp_profile_card').slideDown();
            } else {
                $('#emp_profile_card').hide();
                Swal.fire({ icon: 'error', title: 'Not Found', text: res.message || 'Employee not found.' });
            }
        },
        error: function() {
            $('#emp_fetch_spinner').hide();
            Swal.fire({ icon: 'error', title: 'Error', text: 'Server communication error.' });
        }
    });
}

function calculateModalDays() {
    let from_date = $('#modal_from_date').val();
    let to_date = $('#modal_to_date').val();
    if (from_date && to_date) {
        let d1 = new Date(from_date);
        let d2 = new Date(to_date);
        if (d2 >= d1) {
            let diffTime = Math.abs(d2 - d1);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            $('#modal_total_days').val(diffDays);
        } else {
            $('#modal_total_days').val(0);
        }
    }
}

function submitNewLeave() {
    let emp_id = $('#modal_emp_id').val().trim();
    let leave_type = $('#modal_leave_type').val();
    let apply_date = $('#modal_apply_date').val();
    let from_date = $('#modal_from_date').val();
    let to_date = $('#modal_to_date').val();
    let reason = $('#modal_reason').val();
    let addon = $('#modal_addon_vacation').val();

    if (!emp_id) {
        Swal.fire({ icon: 'warning', title: 'Missing Info', text: 'Please search and select an Employee.' });
        return;
    }
    if (!leave_type || !from_date || !to_date) {
        Swal.fire({ icon: 'warning', title: 'Missing Info', text: 'Please select Leave Type, Start Date, and End Date.' });
        return;
    }

    $('#btn_submit_leave').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

    $.ajax({
        url: "<?= base_url('leave_con/hr_submit_leave') ?>",
        type: "POST",
        dataType: "json",
        data: {
            emp_id: emp_id,
            leave_type: leave_type,
            apply_date: apply_date,
            from_date: from_date,
            to_date: to_date,
            reason: reason,
            add_on_vacation: addon
        },
        success: function(res) {
            $('#btn_submit_leave').prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Submit for Approval');
            if (res.status === 'success') {
                $('#newLeaveModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Leave Submitted!',
                    text: res.message || 'Leave request submitted successfully. Pending Admin Approval.',
                    timer: 3000
                });
                loadHRStats();
                loadLeaveData(1);
            } else {
                Swal.fire({ icon: 'error', title: 'Submission Failed', text: res.message || 'Could not submit leave request.' });
            }
        },
        error: function() {
            $('#btn_submit_leave').prop('disabled', false).html('<i class="fa fa-paper-plane"></i> Submit for Approval');
            Swal.fire({ icon: 'error', title: 'Server Error', text: 'An unexpected error occurred.' });
        }
    });
}

// =========================================================================
// VIEW DETAILS MODAL
// =========================================================================
function viewLeaveDetails(id) {
    $('#viewDetailsBody').html(`
        <div class="text-center" style="padding: 40px; color: #64748b;">
            <i class="fa fa-spinner fa-spin fa-2x"></i>
            <div style="margin-top: 8px;">Loading request details...</div>
        </div>
    `);
    $('#viewDetailsModal').modal('show');

    $.ajax({
        url: "<?= base_url('leave_con/get_leave_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                renderDetailsModal(res.leave, res.balances, res.history);
            } else {
                $('#viewDetailsBody').html(`<div class="alert alert-danger">${res.message || 'Failed to load details.'}</div>`);
            }
        },
        error: function() {
            $('#viewDetailsBody').html(`<div class="alert alert-danger">Error communicating with server.</div>`);
        }
    });
}

function renderDetailsModal(leave, balances, history) {
    let empName = leave.name_en || 'Employee #' + leave.emp_id;
    let initial = empName.charAt(0).toUpperCase();

    // Status Badge
    let statusBadge = '';
    if (leave.status === 'pending') {
        statusBadge = `<span class="badge-status badge-pending"><i class="fa fa-clock-o"></i> Pending Admin Approval</span>`;
    } else if (leave.status === 'approved') {
        statusBadge = `<span class="badge-status badge-approved"><i class="fa fa-check-circle"></i> Approved</span>`;
    } else if (leave.status === 'rejected') {
        statusBadge = `<span class="badge-status badge-rejected"><i class="fa fa-times-circle"></i> Rejected</span>`;
    } else if (leave.status === 'returned') {
        statusBadge = `<span class="badge-status badge-returned"><i class="fa fa-reply"></i> Returned for Modification</span>`;
    }

    let returnReasonBlock = '';
    if (leave.status === 'returned' && leave.return_reason) {
        returnReasonBlock = `
            <div class="alert alert-warning" style="margin-top: 15px;">
                <strong><i class="fa fa-exclamation-triangle"></i> Returned by Admin:</strong> ${escapeHtml(leave.return_reason)}
            </div>
        `;
    }

    let rejectReasonBlock = '';
    if (leave.status === 'rejected' && leave.rejection_reason) {
        rejectReasonBlock = `
            <div class="alert alert-danger" style="margin-top: 15px;">
                <strong><i class="fa fa-ban"></i> Rejection Reason:</strong> ${escapeHtml(leave.rejection_reason)}
            </div>
        `;
    }

    // Timeline HTML
    let timelineHtml = '<div class="audit-timeline">';
    if (history && history.length > 0) {
        history.forEach(function(item) {
            let dotClass = item.action || '';
            timelineHtml += `
                <div class="timeline-item ${dotClass}">
                    <div class="timeline-dot"></div>
                    <div class="timeline-content">
                        <div class="timeline-time">${item.timestamp} &bull; <strong>${escapeHtml(item.by_name || 'System')}</strong></div>
                        <div class="timeline-text">${escapeHtml(item.note || item.reason || item.action)}</div>
                    </div>
                </div>
            `;
        });
    } else {
        timelineHtml += `<div style="font-size: 12px; color: #94a3b8;">No historical entries recorded.</div>`;
    }
    timelineHtml += '</div>';

    let html = `
        <div style="display: flex; gap: 16px; align-items: center; background: #f8fafc; padding: 14px 18px; border-radius: 8px; margin-bottom: 18px; border-left: 4px solid #006ba3;">
            <div style="flex-grow: 1;">
                <div style="font-size: 16px; font-weight: 700; color: #1e293b;">${escapeHtml(empName)}</div>
                <div style="font-size: 12px; color: #64748b; margin-top: 3px;">
                    <span style="background: #e0f2fe; color: #006ba3; font-weight: 700; padding: 2px 7px; border-radius: 4px; margin-right: 6px;">ID: ${leave.emp_id}</span>
                    Dept: <strong>${escapeHtml(leave.dept_name || '-')}</strong> | Desig: <strong>${escapeHtml(leave.desig_name || '-')}</strong>
                </div>
            </div>
            <div>${statusBadge}</div>
        </div>

        <div class="row" style="font-size: 13px;">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><td width="40%" class="text-muted">Leave Type</td><td><span class="type-badge type-${leave.leave_type}">${(leave.leave_type || '').toUpperCase()}</span></td></tr>
                    <tr><td class="text-muted">Start Date</td><td><strong>${leave.leave_start}</strong></td></tr>
                    <tr><td class="text-muted">End Date</td><td><strong>${leave.leave_end}</strong></td></tr>
                    <tr><td class="text-muted">Total Duration</td><td><strong>${leave.total_leave} day(s)</strong></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><td width="40%" class="text-muted">Apply Date</td><td>${leave.start_date || '-'}</td></tr>
                    <tr><td class="text-muted">Submitted By</td><td>${escapeHtml(leave.applied_by_name || 'HR')} (${leave.applied_at || '-'})</td></tr>
                    <tr><td class="text-muted">Admin Action</td><td>${escapeHtml(leave.admin_name || 'Pending')} (${leave.admin_action_at || '-'})</td></tr>
                    <tr><td class="text-muted">Vacation Extension</td><td>${escapeHtml(leave.add_on_vacation || 'None')}</td></tr>
                </table>
            </div>
        </div>

        <div style="background: #f8fafc; border-radius: 6px; padding: 10px 14px; margin-bottom: 15px;">
            <strong style="font-size: 12px; color: #475569;"><i class="fa fa-align-left"></i> Reason for Leave:</strong>
            <p style="margin: 4px 0 0 0; font-size: 13px; color: #1e293b;">${escapeHtml(leave.leave_descrip || 'No reason specified')}</p>
        </div>

        ${returnReasonBlock}
        ${rejectReasonBlock}

        <hr style="margin: 15px 0;">
        <h5 style="font-weight: 700; color: #334155; margin-bottom: 10px;"><i class="fa fa-history"></i> Submission & Modification Audit Trail</h5>
        ${timelineHtml}
    `;

    $('#viewDetailsBody').html(html);
}

// =========================================================================
// RESUBMISSION MODAL
// =========================================================================
function openResubmitModal(id) {
    $.ajax({
        url: "<?= base_url('leave_con/get_leave_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                let l = res.leave;
                $('#resubmit_leave_id').val(l.id);
                $('#resubmit_return_reason').text(l.return_reason || 'Please modify according to policies.');
                $('#resubmit_leave_type').val(l.leave_type);
                $('#resubmit_from_date').val(l.leave_start);
                $('#resubmit_to_date').val(l.leave_end);
                $('#resubmit_total_days').val(l.total_leave);
                $('#resubmit_reason').val(l.leave_descrip);
                $('#resubmit_addon').val(l.add_on_vacation);
                $('#resubmit_note').val('');
                $('#resubmitModal').modal('show');
            }
        }
    });
}

function calculateResubmitDays() {
    let from_date = $('#resubmit_from_date').val();
    let to_date = $('#resubmit_to_date').val();
    if (from_date && to_date) {
        let d1 = new Date(from_date);
        let d2 = new Date(to_date);
        if (d2 >= d1) {
            let diffDays = Math.ceil(Math.abs(d2 - d1) / (1000 * 60 * 60 * 24)) + 1;
            $('#resubmit_total_days').val(diffDays);
        } else {
            $('#resubmit_total_days').val(0);
        }
    }
}

function submitResubmission() {
    let leave_id = $('#resubmit_leave_id').val();
    let leave_type = $('#resubmit_leave_type').val();
    let from_date = $('#resubmit_from_date').val();
    let to_date = $('#resubmit_to_date').val();
    let reason = $('#resubmit_reason').val();
    let addon = $('#resubmit_addon').val();
    let resubmit_note = $('#resubmit_note').val();

    if (!leave_type || !from_date || !to_date) {
        Swal.fire({ icon: 'warning', title: 'Missing Info', text: 'Please fill in Leave Type and Dates.' });
        return;
    }

    $.ajax({
        url: "<?= base_url('leave_con/hr_resubmit_leave') ?>",
        type: "POST",
        dataType: "json",
        data: {
            leave_id: leave_id,
            leave_type: leave_type,
            from_date: from_date,
            to_date: to_date,
            reason: reason,
            add_on_vacation: addon,
            resubmit_note: resubmit_note
        },
        success: function(res) {
            if (res.status === 'success') {
                $('#resubmitModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Resubmitted!',
                    text: res.message || 'Request resubmitted to Admin for approval.',
                    timer: 3000
                });
                loadHRStats();
                loadLeaveData(1);
            } else {
                Swal.fire({ icon: 'error', title: 'Resubmission Failed', text: res.message });
            }
        },
        error: function() {
            Swal.fire({ icon: 'error', title: 'Server Error', text: 'Failed to resubmit request.' });
        }
    });
}
</script>
