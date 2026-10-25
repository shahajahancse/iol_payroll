<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* ADMIN DAILY OT APPROVAL DASHBOARD - MODERN EXECUTIVE THEME                 */
/* ========================================================================= */
.page-content .content.ot-dashboard-wrapper {
    padding-top: 85px !important;
    padding-left: 18px !important;
    padding-right: 18px !important;
    padding-bottom: 40px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    background-color: transparent;
    min-height: calc(100vh - 100px);
}

/* Header Card */
.admin-header-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 18px 24px;
    margin-bottom: 20px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.admin-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.admin-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #006ba3 0%, #004d77 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(0, 107, 163, 0.25);
    flex-shrink: 0;
}
.admin-header-text h2 {
    margin: 0 0 4px 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.3px;
}
.admin-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}
.admin-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}
.admin-pill-badge {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #cbd5e1;
    padding: 6px 14px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-header-refresh {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-header-refresh:hover {
    background: #f8fafc;
    border-color: #006ba3;
    color: #006ba3;
}

/* Stat Cards */
.ot-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 14px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    display: flex;
    align-items: center;
    gap: 12px;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    user-select: none;
}
.ot-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 22px -5px rgba(0, 0, 0, 0.08);
}
.ot-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    flex-shrink: 0;
    transition: transform 0.2s ease;
}
.ot-stat-card:hover .ot-stat-icon {
    transform: scale(1.08);
}
.ot-stat-info {
    flex-grow: 1;
    min-width: 0;
}
.ot-stat-info h3 {
    margin: 0 0 2px 0;
    font-size: 23px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.5px;
}
.ot-stat-info span, .ot-stat-info p {
    margin: 0;
    font-size: 11px;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Stat Card Colors */
.stat-navy .ot-stat-icon { background: #e0f2fe; color: #006ba3; }
.stat-navy h3 { color: #0f172a; }
.stat-navy:hover { border-color: #006ba3; }

.stat-actual .ot-stat-icon { background: #eff6ff; color: #0284c7; }
.stat-actual h3 { color: #006ba3; }
.stat-actual:hover { border-color: #38bdf8; }

.stat-warning .ot-stat-icon { background: #fef3c7; color: #d97706; }
.stat-warning h3 { color: #d97706; }
.stat-warning:hover { border-color: #f59e0b; }

.stat-success .ot-stat-icon { background: #dcfce7; color: #16a34a; }
.stat-success h3 { color: #16a34a; }
.stat-success:hover { border-color: #22c55e; }

.stat-danger .ot-stat-icon { background: #fee2e2; color: #dc2626; }
.stat-danger h3 { color: #dc2626; }
.stat-danger:hover { border-color: #ef4444; }

.stat-purple .ot-stat-icon { background: #f3e8ff; color: #9333ea; }
.stat-purple h3 { color: #9333ea; }
.stat-purple:hover { border-color: #a855f7; }

/* Active Filter States */
.ot-stat-card.active-filter {
    border-color: #006ba3 !important;
    background: #f0f7fb !important;
    box-shadow: 0 0 0 2px rgba(0, 107, 163, 0.2), 0 8px 18px rgba(0, 107, 163, 0.1) !important;
}
#card_total_eligible.active-filter {
    border-color: #006ba3 !important;
    background: #f0f7fb !important;
    box-shadow: 0 0 0 2px rgba(0, 107, 163, 0.25), 0 8px 18px rgba(0, 107, 163, 0.12) !important;
}
#card_actual_ot.active-filter {
    border-color: #006ba3 !important;
    background: #e0f2fe !important;
    box-shadow: 0 0 0 2px rgba(0, 107, 163, 0.25), 0 8px 18px rgba(0, 107, 163, 0.12) !important;
}
#card_pending.active-filter {
    border-color: #d97706 !important;
    background: #fefce8 !important;
    box-shadow: 0 0 0 2px rgba(217, 119, 6, 0.25), 0 8px 18px rgba(217, 119, 6, 0.12) !important;
}
#card_approved.active-filter {
    border-color: #16a34a !important;
    background: #f0fdf4 !important;
    box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.25), 0 8px 18px rgba(22, 163, 74, 0.12) !important;
}
#card_rejected.active-filter {
    border-color: #dc2626 !important;
    background: #fef2f2 !important;
    box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.25), 0 8px 18px rgba(220, 38, 38, 0.12) !important;
}
#card_approved_hours.active-filter {
    border-color: #9333ea !important;
    background: #faf5ff !important;
    box-shadow: 0 0 0 2px rgba(147, 51, 234, 0.25), 0 8px 18px rgba(147, 51, 234, 0.12) !important;
}

/* Unified Filter & Toolbar Box */
.ot-filter-box {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
}
.ot-date-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.ot-date-group {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}
.ot-date-label {
    margin: 0;
    font-weight: 700;
    font-size: 13px;
    white-space: nowrap;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ot-date-inputs {
    display: flex;
    align-items: center;
    gap: 6px;
}
.ot-date-inputs input[type="date"] {
    height: 34px;
    width: 140px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    padding: 4px 8px;
    box-shadow: none;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.ot-date-inputs input[type="date"]:focus {
    border-color: #006ba3;
    box-shadow: 0 0 0 3px rgba(0, 107, 163, 0.15);
}
.ot-date-to {
    font-weight: 700;
    color: #94a3b8;
    font-size: 12px;
    text-transform: lowercase;
}
.ot-action-buttons {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}
.ot-filter-divider {
    height: 1px;
    background: #f1f5f9;
    margin: 14px 0;
}
.ot-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-end;
}
.ot-filter-item {
    flex: 1;
    min-width: 130px;
}
.ot-filter-search {
    flex: 1.6;
    min-width: 170px;
}
.ot-filter-item label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #475569;
    margin-bottom: 5px;
    letter-spacing: 0.3px;
}
.ot-filter-item .form-control {
    height: 35px;
    font-size: 13px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    box-shadow: none;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.ot-filter-item .form-control:focus {
    border-color: #006ba3;
    box-shadow: 0 0 0 3px rgba(0, 107, 163, 0.15);
}
.ot-filter-reset {
    flex: 0 0 auto;
}
.btn-filter-reset {
    height: 35px;
    padding: 0 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* Control Buttons */
.btn-ot-primary {
    background: #006ba3;
    color: #ffffff;
    border: 1px solid #006ba3;
    font-weight: 600;
    font-size: 13px;
    padding: 7px 16px;
    border-radius: 6px;
    transition: all 0.2s;
    box-shadow: 0 2px 6px rgba(0, 107, 163, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-ot-primary:hover {
    background: #005582;
    border-color: #005582;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(0, 107, 163, 0.35);
}
.btn-ot-success {
    background: #16a34a;
    color: #ffffff;
    border: 1px solid #16a34a;
    font-weight: 600;
    font-size: 13px;
    padding: 7px 16px;
    border-radius: 6px;
    transition: all 0.2s;
    box-shadow: 0 2px 6px rgba(22, 163, 74, 0.25);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-ot-success:hover {
    background: #15803d;
    border-color: #15803d;
    color: #ffffff;
    box-shadow: 0 4px 10px rgba(22, 163, 74, 0.35);
}
.btn-ot-default {
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    font-weight: 600;
    font-size: 12px;
    padding: 6px 12px;
    border-radius: 6px;
    transition: all 0.2s;
}
.btn-ot-default:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    color: #0f172a;
}

/* Table Card */
.ot-table-box {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 25px;
}
.ot-table-header {
    padding: 16px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #ffffff;
}
.table-header-indicator {
    width: 4px;
    height: 18px;
    border-radius: 2px;
    background: #006ba3;
}
.ot-table-header h4 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.ot-table-header .table-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

/* Custom Table */
.ot-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}
.ot-table th {
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 10px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
    vertical-align: middle;
}
.ot-table th.sortable {
    cursor: pointer;
    user-select: none;
}
.ot-table th.sortable:hover {
    color: #006ba3;
}
.ot-table td {
    padding: 11px 12px;
    vertical-align: middle;
    font-size: 13px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    white-space: nowrap;
}
.ot-table tbody tr:hover {
    background-color: #f8fafc;
}
.ot-table tbody tr.row-flagged {
    background-color: #fffbeb !important;
}

/* Status Badges */
.badge-status {
    padding: 4px 10px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    letter-spacing: 0.3px;
    line-height: 1.2;
}
.badge-status i {
    font-size: 10px;
    margin: 0;
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
.badge-flagged {
    background: #fef3c7;
    color: #b45309;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 3px;
    font-weight: 700;
    margin-left: 4px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    white-space: nowrap;
    line-height: 1.2;
}

/* Action Buttons inside Table */
.btn-action-icon {
    width: 28px;
    height: 28px;
    padding: 0;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    margin: 0 1px;
    border: 1px solid transparent;
    transition: all 0.15s;
}
.btn-action-approve {
    background: #dcfce7;
    color: #16a34a;
    border-color: #bbf7d0;
}
.btn-action-approve:hover {
    background: #16a34a;
    color: #ffffff;
}
.btn-action-modify {
    background: #e0f2fe;
    color: #006ba3;
    border-color: #bae6fd;
}
.btn-action-modify:hover {
    background: #006ba3;
    color: #ffffff;
}
.btn-action-reject {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fecaca;
}
.btn-action-reject:hover {
    background: #dc2626;
    color: #ffffff;
}
.btn-action-view {
    background: #f1f5f9;
    color: #475569;
    border-color: #cbd5e1;
}
.btn-action-view:hover {
    background: #475569;
    color: #ffffff;
}

/* Audit Timeline */
.timeline {
    position: relative;
    padding: 10px 0 10px 20px;
    margin-left: 10px;
    border-left: 2px solid #e2e8f0;
}
.timeline-item {
    position: relative;
    margin-bottom: 16px;
}
.timeline-point {
    position: absolute;
    left: -26px;
    top: 2px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #006ba3;
    border: 2px solid #ffffff;
    box-shadow: 0 0 0 2px #006ba3;
}
.timeline-content {
    background: #f8fafc;
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 12px;
    border: 1px solid #e2e8f0;
}
.timeline-header {
    display: flex;
    justify-content: space-between;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}
.timeline-time {
    color: #94a3b8;
    font-size: 11px;
}
</style>

<div class="content ot-dashboard-wrapper">
    <!-- Top Executive Header Card -->
    <div class="admin-header-card">
        <div class="admin-header-left">
            <div class="admin-header-icon">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="admin-header-text">
                <h2 style="margin: 0;">Daily Overtime (OT) Approval</h2>
            </div>
        </div>
        <div class="admin-header-actions">
            <button type="button" class="btn-header-refresh" onclick="loadDashboardStats(); loadOtList(0);" title="Refresh live statistics">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- 6 Real-Time Database Summary Cards -->
    <div class="row">
        <!-- Card 1: Total OT Eligible -->
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="ot-stat-card stat-navy" id="card_total_eligible" onclick="filterByCard('total_eligible')" title="Total OT Eligible Employees">
                <div class="ot-stat-icon">
                    <i class="fa fa-users"></i>
                </div>
                <div class="ot-stat-info">
                    <h3 id="stat_total_eligible">0</h3>
                    <span>Eligible</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Employees with Actual OT -->
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="ot-stat-card stat-actual" id="card_actual_ot" onclick="filterByCard('actual_ot')" title="Employees with Actual OT Worked">
                <div class="ot-stat-icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="ot-stat-info">
                    <h3 id="stat_with_actual_ot">0</h3>
                    <span>Actual OT</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Pending Approvals -->
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="ot-stat-card stat-warning" id="card_pending" onclick="filterByCard('pending')" title="Pending Approvals">
                <div class="ot-stat-icon">
                    <i class="fa fa-hourglass-half"></i>
                </div>
                <div class="ot-stat-info">
                    <h3 id="stat_pending_count">0</h3>
                    <span>Pending</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Approved OT -->
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="ot-stat-card stat-success" id="card_approved" onclick="filterByCard('approved')" title="Approved Overtime Records">
                <div class="ot-stat-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="ot-stat-info">
                    <h3 id="stat_approved_count">0</h3>
                    <span>Approved</span>
                </div>
            </div>
        </div>

        <!-- Card 5: Rejected OT -->
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="ot-stat-card stat-danger" id="card_rejected" onclick="filterByCard('rejected')" title="Rejected Overtime Records">
                <div class="ot-stat-icon">
                    <i class="fa fa-times-circle"></i>
                </div>
                <div class="ot-stat-info">
                    <h3 id="stat_rejected_count">0</h3>
                    <span>Rejected</span>
                </div>
            </div>
        </div>

        <!-- Card 6: Total Approved OT Hours -->
        <div class="col-md-2 col-sm-4 col-xs-6">
            <div class="ot-stat-card stat-purple" id="card_approved_hours" onclick="filterByCard('approved_hours')" title="Total Approved OT Hours">
                <div class="ot-stat-icon">
                    <i class="fa fa-history"></i>
                </div>
                <div class="ot-stat-info">
                    <h3 id="stat_approved_hours">0.00</h3>
                    <span>OT Hours</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Unified Date Navigation & Filter Panel -->
    <div class="ot-filter-box">
        <!-- Date Navigation & Action Bar -->
        <div class="ot-date-toolbar">
            <div class="ot-date-group">
                <label class="ot-date-label">
                    <i class="fa fa-calendar" style="color: #006ba3;"></i> Date Range:
                </label>
                <div class="ot-date-inputs">
                    <input type="date" id="filter_start_date" class="form-control" value="<?= htmlspecialchars($default_date) ?>" onchange="onDateChanged()" title="From Date">
                    <span class="ot-date-to">to</span>
                    <input type="date" id="filter_end_date" class="form-control" value="<?= htmlspecialchars($default_date) ?>" onchange="onDateChanged()" title="To Date">
                </div>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-ot-default" onclick="changeDateOffset(-1)" title="Previous Day"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-ot-default" onclick="changeDateToday()" title="Today">Today</button>
                    <button type="button" class="btn btn-ot-default" onclick="changeDateOffset(1)" title="Next Day"><i class="fa fa-chevron-right"></i></button>
                </div>
                <div class="btn-group btn-group-sm" style="margin-left: 2px;">
                    <button type="button" class="btn btn-ot-default" onclick="setDatePreset('last7')" title="Last 7 Days">7 Days</button>
                    <button type="button" class="btn btn-ot-default" onclick="setDatePreset('this_month')" title="This Month">This Month</button>
                </div>
            </div>
            <div class="ot-action-buttons">
                <button type="button" class="btn btn-ot-primary" id="btn_generate_ot" onclick="generateDailyOt()">
                    <i class="fa fa-refresh" id="refresh_icon"></i> Generate / Refresh Daily OT List
                </button>
                <button type="button" class="btn btn-ot-success" id="btn_bulk_approve" onclick="openBulkApproveModal()" style="display: none;">
                    <i class="fa fa-check-square-o"></i> Bulk Approve Selected (<span id="bulk_count">0</span>)
                </button>
            </div>
        </div>

        <div class="ot-filter-divider"></div>

        <!-- Multi-criteria Filter Bar -->
        <div class="ot-filter-row">
            <div class="ot-filter-item ot-filter-search">
                <label><i class="fa fa-search" style="color: #64748b;"></i> Search Employee</label>
                <input type="text" id="filter_search" class="form-control" placeholder="Search by ID or Name..." onkeyup="debounceSearch()">
            </div>
            <div class="ot-filter-item">
                <label>Department</label>
                <select id="filter_dept" class="form-control" onchange="loadOtList(0)">
                    <option value="">All Departments</option>
                    <?php foreach ($departments as $d): ?>
                        <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ot-filter-item">
                <label>Section</label>
                <select id="filter_sec" class="form-control" onchange="loadOtList(0)">
                    <option value="">All Sections</option>
                    <?php foreach ($sections as $s): ?>
                        <option value="<?= $s->id ?>"><?= htmlspecialchars($s->sec_name_en) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ot-filter-item">
                <label>Designation</label>
                <select id="filter_desig" class="form-control" onchange="loadOtList(0)">
                    <option value="">All Designations</option>
                    <?php foreach ($designations as $dg): ?>
                        <option value="<?= $dg->id ?>"><?= htmlspecialchars($dg->desig_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ot-filter-item">
                <label>Shift</label>
                <select id="filter_shift" class="form-control" onchange="loadOtList(0)">
                    <option value="">All Shifts</option>
                    <?php foreach ($shifts as $sh): ?>
                        <option value="<?= $sh->id ?>"><?= htmlspecialchars($sh->shift_name) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="ot-filter-item">
                <label>OT Status</label>
                <select id="filter_status" class="form-control" onchange="onStatusFilterChanged()">
                    <option value="all">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                    <option value="actual_ot">With Actual OT (>0)</option>
                </select>
            </div>
            <div class="ot-filter-reset">
                <button type="button" class="btn btn-ot-default btn-filter-reset" onclick="resetFilters()" title="Reset all filters">
                    <i class="fa fa-undo"></i> Reset
                </button>
            </div>
        </div>
    </div>

    <!-- Main OT Records Table -->
    <div class="ot-table-box">
        <div class="ot-table-header">
            <div>
                <h4><i class="fa fa-list"></i> Daily OT Approval Records (<span id="total_records_badge">0</span>)</h4>
            </div>
            <div class="table-actions">
                <span id="flagged_warning" style="display: none; color: #b45309; font-size: 12px; font-weight: 700; margin-right: 10px;">
                    <i class="fa fa-exclamation-triangle"></i> <span id="flagged_count_text">0</span> record(s) flagged due to attendance recalculation
                </span>
                <label style="font-size: 12px; margin: 0; color: #64748b;">Per Page:</label>
                <select id="page_limit" class="form-control input-sm" style="width: 75px; display: inline-block; height: 30px;" onchange="loadOtList(0)">
                    <option value="15">15</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table ot-table" id="ot_records_table">
                <thead>
                    <tr>
                        <th style="width: 35px; text-align: center;">
                            <input type="checkbox" id="select_all" onchange="toggleSelectAll(this)">
                        </th>
                        <th class="sortable" onclick="sortTable('emp_id')">Emp ID <i class="fa fa-sort"></i></th>
                        <th class="sortable" onclick="sortTable('name')">Employee Name <i class="fa fa-sort"></i></th>
                        <th class="sortable" onclick="sortTable('dept_name')">Department <i class="fa fa-sort"></i></th>
                        <th class="sortable" onclick="sortTable('desig_name')">Designation <i class="fa fa-sort"></i></th>
                        <th>Shift</th>
                        <th class="sortable" onclick="sortTable('ot_date')">Date <i class="fa fa-sort"></i></th>
                        <th class="sortable" onclick="sortTable('in_time')">In Time <i class="fa fa-sort"></i></th>
                        <th class="sortable" onclick="sortTable('out_time')">Out Time <i class="fa fa-sort"></i></th>
                        <th title="Regular duty hours">Reg. Hrs</th>
                        <th class="sortable" onclick="sortTable('actual_ot_hours')" title="Calculated actual OT">Actual OT</th>
                        <th title="Calculated OT Duration">Calc. OT</th>
                        <th class="sortable" onclick="sortTable('approved_ot_hours')" title="Admin approved duration">Approved OT</th>
                        <th class="sortable" onclick="sortTable('status')" style="white-space: nowrap; text-align: center;">OT Status <i class="fa fa-sort"></i></th>
                        <th>Admin Remarks</th>
                        <th style="text-align: center; width: 120px;">Action</th>
                    </tr>
                </thead>
                <tbody id="ot_table_body">
                    <tr>
                        <td colspan="16" class="text-center" style="padding: 40px; color: #94a3b8;">
                            <i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading records...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        <div style="padding: 12px 20px; background: #fafbfc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <div id="pagination_info" style="font-size: 13px; color: #64748b;">
                Showing 0 to 0 of 0 entries
            </div>
            <div id="pagination_controls" style="display: flex; gap: 4px;">
                <!-- Generated by JS -->
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODALS -->
<!-- ========================================================================= -->

<!-- Quick Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #f0fdf4; border-bottom: 1px solid #bbf7d0; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #166534; font-weight: 700;"><i class="fa fa-check-circle"></i> Approve Overtime</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="app_record_id">
                <div style="margin-bottom: 12px;">
                    <strong id="app_emp_info" style="font-size: 14px; color: #0f172a;"></strong>
                    <div style="font-size: 12px; color: #64748b;" id="app_date_info"></div>
                </div>
                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Calculated Actual OT:</label>
                    <input type="text" id="app_actual_hours_disp" class="form-control" readonly style="background: #f8fafc; font-weight: 700;">
                </div>
                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Hours to Approve <span class="text-danger">*</span></label>
                    <input type="number" step="0.5" min="0" id="app_approved_hours" class="form-control" style="font-weight: 700; font-size: 15px; color: #16a34a;">
                    <small class="text-muted">Must be ≤ Actual OT (<span id="app_max_hours"></span> hrs)</small>
                </div>
                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Admin Remarks (Optional)</label>
                    <textarea id="app_remarks" class="form-control" rows="2" placeholder="Optional approval remarks..."></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #fafbfc; border-radius: 0 0 8px 8px;">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-ot-success btn-sm" onclick="submitApproveSingle()">Confirm Approval</button>
            </div>
        </div>
    </div>
</div>

<!-- Modify Hours Modal -->
<div class="modal fade" id="modifyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #f0f9ff; border-bottom: 1px solid #bae6fd; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #0369a1; font-weight: 700;"><i class="fa fa-pencil-square-o"></i> Modify Approved OT Hours</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="mod_record_id">
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 16px; margin-bottom: 16px;">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <strong id="mod_emp_info" style="font-size: 14px; color: #0f172a;"></strong>
                            <div id="mod_dept_info" style="font-size: 12px; color: #64748b;"></div>
                        </div>
                        <div class="text-right">
                            <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b;">Working Date</span>
                            <div id="mod_date_info" style="font-weight: 700; color: #0f172a;"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size: 12px; font-weight: 700; color: #475569;">Actual Calculated OT</label>
                            <div class="input-group">
                                <input type="text" id="mod_actual_hours" class="form-control" readonly style="background: #f1f5f9; font-weight: 700; font-size: 15px;">
                                <span class="input-group-addon">Hrs</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label style="font-size: 12px; font-weight: 700; color: #006ba3;">Adjusted Approved OT <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.5" min="0" id="mod_approved_hours" class="form-control" style="font-weight: 700; font-size: 15px; color: #006ba3;">
                                <span class="input-group-addon">Hrs</span>
                            </div>
                            <small class="text-muted">Must be ≤ Actual OT</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #b91c1c;">Modification Reason <span class="text-danger">* Mandatory</span></label>
                    <textarea id="mod_reason" class="form-control" rows="2" placeholder="State why the approved hours differ from calculated actual OT..."></textarea>
                </div>

                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Admin Remarks (Optional)</label>
                    <input type="text" id="mod_remarks" class="form-control" placeholder="Additional notes...">
                </div>
            </div>
            <div class="modal-footer" style="background: #fafbfc; border-radius: 0 0 8px 8px;">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-ot-primary btn-sm" onclick="submitModifySingle()">Save & Approve Modified Hours</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #fef2f2; border-bottom: 1px solid #fecaca; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #991b1b; font-weight: 700;"><i class="fa fa-times-circle"></i> Reject Overtime</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rej_record_id">
                <div style="margin-bottom: 12px;">
                    <strong id="rej_emp_info" style="font-size: 14px; color: #0f172a;"></strong>
                    <div style="font-size: 12px; color: #64748b;" id="rej_date_info"></div>
                </div>

                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #b91c1c;">Rejection Reason <span class="text-danger">* Mandatory</span></label>
                    <textarea id="rej_reason" class="form-control" rows="3" placeholder="Provide reason for rejecting OT (e.g. Unscheduled work, unauthorized stay, punch irregularity)..."></textarea>
                </div>

                <div class="form-group">
                    <label style="font-size: 12px; font-weight: 700; color: #475569;">Admin Remarks (Optional)</label>
                    <input type="text" id="rej_remarks" class="form-control" placeholder="Optional notes...">
                </div>
            </div>
            <div class="modal-footer" style="background: #fafbfc; border-radius: 0 0 8px 8px;">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" onclick="submitRejectSingle()">Confirm Rejection</button>
            </div>
        </div>
    </div>
</div>

<!-- Record Details & Audit Trail Modal -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700;"><i class="fa fa-history"></i> Overtime Record & Audit Trail</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <div class="row" style="margin-bottom: 20px;">
                    <!-- Employee Details -->
                    <div class="col-md-6">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px 16px;">
                            <h5 style="margin: 0 0 10px 0; font-weight: 700; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                                <i class="fa fa-user"></i> Employee Information
                            </h5>
                            <table style="width: 100%; font-size: 13px;">
                                <tr><td style="width: 120px; color: #64748b; padding: 3px 0;">Employee ID:</td><td style="font-weight: 700;" id="det_emp_id">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Name:</td><td style="font-weight: 700;" id="det_emp_name">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Department:</td><td id="det_dept_name">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Section:</td><td id="det_sec_name">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Designation:</td><td id="det_desig_name">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Shift:</td><td id="det_shift_name">-</td></tr>
                            </table>
                        </div>
                    </div>

                    <!-- Attendance & Overtime Details -->
                    <div class="col-md-6">
                        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 14px 16px;">
                            <h5 style="margin: 0 0 10px 0; font-weight: 700; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 6px;">
                                <i class="fa fa-clock-o"></i> Working Day Attendance & OT
                            </h5>
                            <table style="width: 100%; font-size: 13px;">
                                <tr><td style="width: 140px; color: #64748b; padding: 3px 0;">Working Date:</td><td style="font-weight: 700;" id="det_ot_date">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Punch In Time:</td><td id="det_in_time">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Punch Out Time:</td><td id="det_out_time">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Regular Hours:</td><td id="det_reg_hours">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Actual OT Hours:</td><td style="font-weight: 700; color: #006ba3;" id="det_actual_ot">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Approved OT Hours:</td><td style="font-weight: 700; color: #16a34a;" id="det_approved_ot">-</td></tr>
                                <tr><td style="color: #64748b; padding: 3px 0;">Status:</td><td id="det_status_badge">-</td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Modification / Rejection Reasons -->
                <div id="det_reason_section" style="display: none; margin-bottom: 20px;">
                    <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; padding: 12px 16px;">
                        <strong style="color: #b45309; font-size: 13px;" id="det_reason_title">Reason:</strong>
                        <p style="margin: 4px 0 0 0; color: #78350f; font-size: 13px;" id="det_reason_content"></p>
                    </div>
                </div>

                <!-- Audit History Timeline -->
                <h5 style="font-weight: 700; color: #0f172a; margin: 15px 0 10px 0;"><i class="fa fa-list-alt"></i> Complete Audit Trail</h5>
                <div class="timeline" id="det_audit_timeline">
                    <!-- Populated by JS -->
                </div>
            </div>
            <div class="modal-footer" style="background: #fafbfc; border-radius: 0 0 8px 8px;">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT LOGIC -->
<!-- ========================================================================= -->
<script>
var currentSortCol = 'o.id';
var currentSortDir = 'DESC';
var currentOffset = 0;
var searchTimer = null;

$(document).ready(function() {
    loadDashboardStats();
    loadOtList(0);
});

// Filter by clicking Summary Cards
function filterByCard(type) {
    var cardSelector = '#card_' + type;
    var wasActive = $(cardSelector).hasClass('active-filter');

    // Remove active state from all cards
    $('.ot-stat-card').removeClass('active-filter');

    if (wasActive) {
        // Toggle off -> show all
        $('#filter_status').val('all');
        loadOtList(0);
        return;
    }

    $(cardSelector).addClass('active-filter');

    if (type === 'total_eligible') {
        $('#filter_status').val('all');
    } else if (type === 'actual_ot') {
        $('#filter_status').val('actual_ot');
    } else if (type === 'pending') {
        $('#filter_status').val('pending');
    } else if (type === 'approved') {
        $('#filter_status').val('approved');
    } else if (type === 'rejected') {
        $('#filter_status').val('rejected');
    } else if (type === 'approved_hours') {
        $('#filter_status').val('approved');
        $('#card_approved_hours').addClass('active-filter');
    }

    loadOtList(0);
}

// Backward-compatible alias
function quickFilterStatus(status) {
    filterByCard(status);
}

// When dropdown changes manually, synchronize card highlights
function onStatusFilterChanged() {
    var val = $('#filter_status').val();
    $('.ot-stat-card').removeClass('active-filter');
    if (val === 'pending') {
        $('#card_pending').addClass('active-filter');
    } else if (val === 'approved') {
        $('#card_approved').addClass('active-filter');
    } else if (val === 'rejected') {
        $('#card_rejected').addClass('active-filter');
    } else if (val === 'actual_ot') {
        $('#card_actual_ot').addClass('active-filter');
    } else if (val === 'all') {
        $('#card_total_eligible').addClass('active-filter');
    }
    loadOtList(0);
}

// Date offset change (-1, +1 day)
function changeDateOffset(days) {
    var cur = new Date($('#filter_start_date').val());
    if (isNaN(cur.getTime())) {
        cur = new Date();
    }
    cur.setDate(cur.getDate() + days);
    var yyyy = cur.getFullYear();
    var mm = String(cur.getMonth() + 1).padStart(2, '0');
    var dd = String(cur.getDate()).padStart(2, '0');
    var dateStr = yyyy + '-' + mm + '-' + dd;
    $('#filter_start_date').val(dateStr);
    $('#filter_end_date').val(dateStr);
    onDateChanged();
}

// Date change to today
function changeDateToday() {
    var cur = new Date();
    var yyyy = cur.getFullYear();
    var mm = String(cur.getMonth() + 1).padStart(2, '0');
    var dd = String(cur.getDate()).padStart(2, '0');
    var todayStr = yyyy + '-' + mm + '-' + dd;
    $('#filter_start_date').val(todayStr);
    $('#filter_end_date').val(todayStr);
    onDateChanged();
}

// Quick Date Range Presets
function setDatePreset(type) {
    var now = new Date();
    var yyyy = now.getFullYear();
    var mm = String(now.getMonth() + 1).padStart(2, '0');
    var dd = String(now.getDate()).padStart(2, '0');
    var todayStr = yyyy + '-' + mm + '-' + dd;

    if (type === 'today') {
        $('#filter_start_date').val(todayStr);
        $('#filter_end_date').val(todayStr);
    } else if (type === 'yesterday') {
        var yest = new Date();
        yest.setDate(yest.getDate() - 1);
        var yDate = yest.getFullYear() + '-' + String(yest.getMonth() + 1).padStart(2, '0') + '-' + String(yest.getDate()).padStart(2, '0');
        $('#filter_start_date').val(yDate);
        $('#filter_end_date').val(yDate);
    } else if (type === 'last7') {
        var d7 = new Date();
        d7.setDate(d7.getDate() - 6);
        var d7Str = d7.getFullYear() + '-' + String(d7.getMonth() + 1).padStart(2, '0') + '-' + String(d7.getDate()).padStart(2, '0');
        $('#filter_start_date').val(d7Str);
        $('#filter_end_date').val(todayStr);
    } else if (type === 'this_month') {
        var firstDay = yyyy + '-' + mm + '-01';
        $('#filter_start_date').val(firstDay);
        $('#filter_end_date').val(todayStr);
    }
    onDateChanged();
}

function onDateChanged() {
    var start = $('#filter_start_date').val();
    var end = $('#filter_end_date').val();
    if (start && end && start > end) {
        // Swap if start is after end
        $('#filter_end_date').val(start);
        $('#filter_start_date').val(end);
    }
    loadDashboardStats();
    loadOtList(0);
}

function debounceSearch() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() {
        loadOtList(0);
    }, 350);
}

function resetFilters() {
    $('#filter_search').val('');
    $('#filter_dept').val('');
    $('#filter_sec').val('');
    $('#filter_desig').val('');
    $('#filter_shift').val('');
    $('#filter_status').val('all');
    $('.ot-stat-card').removeClass('active-filter');
    loadOtList(0);
}

// Sorting
function sortTable(col) {
    if (currentSortCol === col) {
        currentSortDir = (currentSortDir === 'ASC') ? 'DESC' : 'ASC';
    } else {
        currentSortCol = col;
        currentSortDir = 'DESC';
    }
    loadOtList(currentOffset);
}

// Load statistics for summary cards
function loadDashboardStats() {
    var startDate = $('#filter_start_date').val();
    var endDate   = $('#filter_end_date').val();
    $.ajax({
        url: "<?= base_url('ot_approval_con/admin_stats_ajax') ?>",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
            ot_date: startDate
        },
        dataType: "json",
        success: function(res) {
            $('#stat_total_eligible').text(res.total_eligible || 0);
            $('#stat_with_actual_ot').text(res.with_actual_ot || 0);
            $('#stat_pending_count').text(res.pending_count || 0);
            $('#stat_approved_count').text(res.approved_count || 0);
            $('#stat_rejected_count').text(res.rejected_count || 0);
            $('#stat_approved_hours').text(parseFloat(res.total_approved_hours || 0).toFixed(2));

            if (res.flagged_count > 0) {
                $('#flagged_count_text').text(res.flagged_count);
                $('#flagged_warning').show();
            } else {
                $('#flagged_warning').hide();
            }
        }
    });
}

// Load OT list with filters and pagination
function loadOtList(offset) {
    if (typeof offset === 'undefined') {
        offset = currentOffset;
    }
    currentOffset = offset;

    var limit = parseInt($('#page_limit').val(), 10);
    var startDate = $('#filter_start_date').val();
    var endDate   = $('#filter_end_date').val();
    var search = $('#filter_search').val();
    var dept = $('#filter_dept').val();
    var sec = $('#filter_sec').val();
    var desig = $('#filter_desig').val();
    var shift = $('#filter_shift').val();
    var status = $('#filter_status').val();

    $('#ot_table_body').html('<tr><td colspan="16" class="text-center" style="padding: 30px; color: #94a3b8;"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading records...</td></tr>');
    $('#select_all').prop('checked', false);
    updateBulkButton();

    $.ajax({
        url: "<?= base_url('ot_approval_con/admin_ot_list_ajax') ?>",
        type: "GET",
        data: {
            start_date: startDate,
            end_date: endDate,
            ot_date: startDate,
            search: search,
            dept_id: dept,
            sec_id: sec,
            desig_id: desig,
            shift_id: shift,
            status: status,
            limit: limit,
            offset: offset,
            sort_col: currentSortCol,
            sort_dir: currentSortDir
        },
        dataType: "json",
        success: function(res) {
            $('#total_records_badge').text(res.total_rows);
            renderTableRows(res.records);
            renderPagination(res.total_rows, limit, offset);
        },
        error: function() {
            $('#ot_table_body').html('<tr><td colspan="16" class="text-center text-danger" style="padding: 30px;"><i class="fa fa-exclamation-circle fa-2x"></i><br>Failed to load records.</td></tr>');
        }
    });
}

// Render Table Rows
function renderTableRows(records) {
    if (!records || records.length === 0) {
        $('#ot_table_body').html('<tr><td colspan="16" class="text-center" style="padding: 40px; color: #94a3b8;"><i class="fa fa-inbox fa-3x" style="opacity: 0.5;"></i><br><strong style="font-size: 15px;">No eligible OT records found for this working date.</strong><br><small>Click "Generate / Refresh Daily OT List" to sync from attendance punches.</small></td></tr>');
        return;
    }

    var html = '';
    records.forEach(function(row) {
        var isFlagged = (row.attendance_modified_flag == 1);
        var rowClass = isFlagged ? 'row-flagged' : '';

        // Status badge
        var statusBadge = '';
        if (row.status === 'pending') {
            statusBadge = '<span class="badge-status badge-pending"><i class="fa fa-hourglass-half"></i> Pending</span>';
        } else if (row.status === 'approved') {
            statusBadge = '<span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>';
        } else if (row.status === 'rejected') {
            statusBadge = '<span class="badge-status badge-rejected"><i class="fa fa-times"></i> Rejected</span>';
        }

        if (isFlagged) {
            statusBadge += ' <span class="badge-flagged" title="Attendance punch changed after decision! Review required."><i class="fa fa-warning"></i> Modified</span>';
        }

        // Actions
        var actions = '<div style="white-space: nowrap;">';
        if (row.status === 'pending') {
            actions += '<button type="button" class="btn-action-icon btn-action-approve" onclick="openApproveModal(' + row.id + ', ' + row.actual_ot_hours + ', \'' + escapeHtml(row.emp_id) + '\', \'' + escapeHtml(row.emp_name) + '\', \'' + row.ot_date + '\')" title="Quick Approve"><i class="fa fa-check"></i></button>';
            actions += '<button type="button" class="btn-action-icon btn-action-modify" onclick="openModifyModal(' + row.id + ', ' + row.actual_ot_hours + ', ' + row.approved_ot_hours + ', \'' + escapeHtml(row.emp_id) + '\', \'' + escapeHtml(row.emp_name) + '\', \'' + escapeHtml(row.dept_name || '') + '\', \'' + row.ot_date + '\')" title="Modify Hours"><i class="fa fa-pencil"></i></button>';
            actions += '<button type="button" class="btn-action-icon btn-action-reject" onclick="openRejectModal(' + row.id + ', \'' + escapeHtml(row.emp_id) + '\', \'' + escapeHtml(row.emp_name) + '\', \'' + row.ot_date + '\')" title="Reject OT"><i class="fa fa-times"></i></button>';
        } else {
            // Already approved or rejected: allow modify or review
            actions += '<button type="button" class="btn-action-icon btn-action-modify" onclick="openModifyModal(' + row.id + ', ' + row.actual_ot_hours + ', ' + row.approved_ot_hours + ', \'' + escapeHtml(row.emp_id) + '\', \'' + escapeHtml(row.emp_name) + '\', \'' + escapeHtml(row.dept_name || '') + '\', \'' + row.ot_date + '\')" title="Adjust Approved Hours"><i class="fa fa-pencil"></i></button>';
            if (row.status === 'approved') {
                actions += '<button type="button" class="btn-action-icon btn-action-reject" onclick="openRejectModal(' + row.id + ', \'' + escapeHtml(row.emp_id) + '\', \'' + escapeHtml(row.emp_name) + '\', \'' + row.ot_date + '\')" title="Reject Record"><i class="fa fa-times"></i></button>';
            }
        }
        actions += '<button type="button" class="btn-action-icon btn-action-view" onclick="openDetailsModal(' + row.id + ')" title="View Audit Trail"><i class="fa fa-eye"></i></button>';
        actions += '</div>';

        // Checkbox only available for pending records
        var chkBox = (row.status === 'pending') 
            ? '<input type="checkbox" class="row-checkbox" value="' + row.id + '" onchange="updateBulkButton()">'
            : '<input type="checkbox" disabled style="opacity: 0.3;" title="Only pending records can be bulk approved">';

        html += '<tr class="' + rowClass + '">';
        html += '<td style="text-align: center;">' + chkBox + '</td>';
        html += '<td><strong style="color: #006ba3;">' + escapeHtml(row.emp_id) + '</strong></td>';
        html += '<td style="white-space: nowrap;"><strong>' + escapeHtml(row.emp_name || '-') + '</strong></td>';
        html += '<td style="white-space: nowrap;">' + escapeHtml(row.dept_name || '-') + '</td>';
        html += '<td>' + escapeHtml(row.desig_name || '-') + '</td>';
        html += '<td>' + escapeHtml(row.shift_name || '-') + '</td>';
        html += '<td>' + row.ot_date + '</td>';
        html += '<td><span class="label label-default" style="font-size: 11px;">' + (row.in_time || '-') + '</span></td>';
        html += '<td><span class="label label-default" style="font-size: 11px;">' + (row.out_time || '-') + '</span></td>';
        html += '<td>' + parseFloat(row.regular_hours || 8).toFixed(1) + 'h</td>';
        html += '<td><strong style="color: #006ba3;">' + parseFloat(row.actual_ot_hours || 0).toFixed(1) + 'h</strong></td>';
        html += '<td>' + parseFloat(row.calculated_ot_hours || row.actual_ot_hours || 0).toFixed(1) + 'h</td>';
        html += '<td><strong style="color: #16a34a; font-size: 14px;">' + parseFloat(row.approved_ot_hours || 0).toFixed(1) + 'h</strong></td>';
        html += '<td style="white-space: nowrap; text-align: center;">' + statusBadge + '</td>';
        html += '<td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="' + escapeHtml(row.admin_remarks || '') + '">' + escapeHtml(row.admin_remarks || '-') + '</td>';
        html += '<td style="text-align: center;">' + actions + '</td>';
        html += '</tr>';
    });

    $('#ot_table_body').html(html);
}

// Render pagination buttons
function renderPagination(totalRows, limit, offset) {
    var start = (totalRows === 0) ? 0 : offset + 1;
    var end = Math.min(offset + limit, totalRows);
    $('#pagination_info').text('Showing ' + start + ' to ' + end + ' of ' + totalRows + ' entries');

    var totalPages = Math.ceil(totalRows / limit);
    var curPage = Math.floor(offset / limit) + 1;

    if (totalPages <= 1) {
        $('#pagination_controls').html('');
        return;
    }

    var html = '';
    html += '<button type="button" class="btn btn-default btn-xs" ' + (curPage === 1 ? 'disabled' : '') + ' onclick="loadOtList(' + ((curPage - 2) * limit) + ')"><i class="fa fa-chevron-left"></i></button>';

    var startPage = Math.max(1, curPage - 2);
    var endPage = Math.min(totalPages, curPage + 2);

    for (var p = startPage; p <= endPage; p++) {
        var activeClass = (p === curPage) ? 'btn-primary' : 'btn-default';
        html += '<button type="button" class="btn ' + activeClass + ' btn-xs" onclick="loadOtList(' + ((p - 1) * limit) + ')">' + p + '</button>';
    }

    html += '<button type="button" class="btn btn-default btn-xs" ' + (curPage === totalPages ? 'disabled' : '') + ' onclick="loadOtList(' + (curPage * limit) + ')"><i class="fa fa-chevron-right"></i></button>';
    $('#pagination_controls').html(html);
}

// Checkbox select all
function toggleSelectAll(master) {
    $('.row-checkbox:not(:disabled)').prop('checked', master.checked);
    updateBulkButton();
}

function updateBulkButton() {
    var count = $('.row-checkbox:checked').length;
    $('#bulk_count').text(count);
    if (count > 0) {
        $('#btn_bulk_approve').show();
    } else {
        $('#btn_bulk_approve').hide();
    }
}

// Generate or Refresh Daily OT List
function generateDailyOt() {
    var startDate = $('#filter_start_date').val();
    var endDate   = $('#filter_end_date').val();
    $('#refresh_icon').addClass('fa-spin');
    $('#btn_generate_ot').prop('disabled', true);

    $.ajax({
        url: "<?= base_url('ot_approval_con/generate_daily_ot_ajax') ?>",
        type: "POST",
        data: {
            start_date: startDate,
            end_date: endDate,
            ot_date: startDate
        },
        dataType: "json",
        success: function(res) {
            $('#refresh_icon').removeClass('fa-spin');
            $('#btn_generate_ot').prop('disabled', false);
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'List Refreshed',
                    text: res.message,
                    timer: 2500,
                    showConfirmButton: false
                });
                loadDashboardStats();
                loadOtList(0);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function() {
            $('#refresh_icon').removeClass('fa-spin');
            $('#btn_generate_ot').prop('disabled', false);
            Swal.fire('Error', 'Failed to communicate with server.', 'error');
        }
    });
}

// Single Approve Modal
function openApproveModal(id, actualHours, empId, empName, otDate) {
    $('#app_record_id').val(id);
    $('#app_emp_info').text(empId + ' - ' + empName);
    $('#app_date_info').text('Working Date: ' + otDate);
    $('#app_actual_hours_disp').val(actualHours + ' Hours');
    $('#app_approved_hours').val(actualHours);
    $('#app_max_hours').text(actualHours);
    $('#app_approved_hours').attr('max', actualHours);
    $('#app_remarks').val('');
    $('#approveModal').modal('show');
}

function submitApproveSingle() {
    var id = $('#app_record_id').val();
    var hours = parseFloat($('#app_approved_hours').val());
    var maxHours = parseFloat($('#app_max_hours').text());
    var remarks = $('#app_remarks').val();

    if (isNaN(hours) || hours < 0) {
        Swal.fire('Invalid Input', 'Please enter valid approved OT hours.', 'warning');
        return;
    }
    if (hours > maxHours) {
        Swal.fire('Limit Exceeded', 'Approved OT hours cannot exceed calculated actual OT (' + maxHours + ' hrs). To approve a modified duration, please use the Modify Hours option.', 'warning');
        return;
    }

    $.ajax({
        url: "<?= base_url('ot_approval_con/admin_approve_single') ?>",
        type: "POST",
        data: {
            id: id,
            approved_hours: hours,
            remarks: remarks
        },
        dataType: "json",
        success: function(res) {
            $('#approveModal').modal('hide');
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Approved!',
                    text: res.message,
                    timer: 1800,
                    showConfirmButton: false
                });
                loadDashboardStats();
                loadOtList();
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

// Modify Modal
function openModifyModal(id, actualHours, approvedHours, empId, empName, deptName, otDate) {
    $('#mod_record_id').val(id);
    $('#mod_emp_info').text(empId + ' - ' + empName);
    $('#mod_dept_info').text(deptName || '');
    $('#mod_date_info').text(otDate);
    $('#mod_actual_hours').val(actualHours);
    $('#mod_approved_hours').val(approvedHours > 0 ? approvedHours : actualHours);
    $('#mod_approved_hours').attr('max', actualHours);
    $('#mod_reason').val('');
    $('#mod_remarks').val('');
    $('#modifyModal').modal('show');
}

function submitModifySingle() {
    var id = $('#mod_record_id').val();
    var hours = parseFloat($('#mod_approved_hours').val());
    var actualHours = parseFloat($('#mod_actual_hours').val());
    var reason = $.trim($('#mod_reason').val());
    var remarks = $('#mod_remarks').val();

    if (isNaN(hours) || hours < 0) {
        Swal.fire('Invalid Input', 'Please enter valid approved OT hours.', 'warning');
        return;
    }
    if (hours > actualHours) {
        Swal.fire('Policy Limit', 'Approved OT hours cannot exceed actual calculated OT (' + actualHours + ' hrs).', 'warning');
        return;
    }
    if (reason === '') {
        Swal.fire('Reason Required', 'Please provide a modification reason explaining why the approved hours differ from actual OT.', 'warning');
        return;
    }

    $.ajax({
        url: "<?= base_url('ot_approval_con/admin_modify_single') ?>",
        type: "POST",
        data: {
            id: id,
            approved_hours: hours,
            modification_reason: reason,
            remarks: remarks
        },
        dataType: "json",
        success: function(res) {
            $('#modifyModal').modal('hide');
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Modified & Approved',
                    text: res.message,
                    timer: 1800,
                    showConfirmButton: false
                });
                loadDashboardStats();
                loadOtList();
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

// Reject Modal
function openRejectModal(id, empId, empName, otDate) {
    $('#rej_record_id').val(id);
    $('#rej_emp_info').text(empId + ' - ' + empName);
    $('#rej_date_info').text('Working Date: ' + otDate);
    $('#rej_reason').val('');
    $('#rej_remarks').val('');
    $('#rejectModal').modal('show');
}

function submitRejectSingle() {
    var id = $('#rej_record_id').val();
    var reason = $.trim($('#rej_reason').val());
    var remarks = $('#rej_remarks').val();

    if (reason === '') {
        Swal.fire('Reason Required', 'Please provide a rejection reason.', 'warning');
        return;
    }

    $.ajax({
        url: "<?= base_url('ot_approval_con/admin_reject_single') ?>",
        type: "POST",
        data: {
            id: id,
            rejection_reason: reason,
            remarks: remarks
        },
        dataType: "json",
        success: function(res) {
            $('#rejectModal').modal('hide');
            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Rejected',
                    text: res.message,
                    timer: 1800,
                    showConfirmButton: false
                });
                loadDashboardStats();
                loadOtList();
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

// Bulk Approve Modal & Execution
function openBulkApproveModal() {
    var checkedIds = [];
    $('.row-checkbox:checked').each(function() {
        checkedIds.push($(this).val());
    });

    if (checkedIds.length === 0) {
        Swal.fire('No Selection', 'Please select at least one pending record.', 'info');
        return;
    }

    Swal.fire({
        title: 'Bulk Approve Overtime?',
        text: 'Are you sure you want to approve calculated actual OT hours for ' + checkedIds.length + ' selected employee(s)?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#16a34a',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Approve All'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('ot_approval_con/admin_bulk_approve') ?>",
                type: "POST",
                data: {
                    ids: checkedIds,
                    remarks: 'Bulk approved by Admin'
                },
                dataType: "json",
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire('Bulk Approved', res.message, 'success');
                        loadDashboardStats();
                        loadOtList();
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }
            });
        }
    });
}

// Details & Audit History Modal
function openDetailsModal(id) {
    $.ajax({
        url: "<?= base_url('ot_approval_con/get_ot_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status !== 'success') {
                Swal.fire('Error', res.message, 'error');
                return;
            }

            var rec = res.record;
            $('#det_emp_id').text(rec.emp_id);
            $('#det_emp_name').text(rec.emp_name || '-');
            $('#det_dept_name').text(rec.dept_name || '-');
            $('#det_sec_name').text(rec.sec_name || '-');
            $('#det_desig_name').text(rec.desig_name || '-');
            $('#det_shift_name').text(rec.shift_name || '-');

            $('#det_ot_date').text(rec.ot_date);
            $('#det_in_time').text(rec.in_time || '-');
            $('#det_out_time').text(rec.out_time || '-');
            $('#det_reg_hours').text(parseFloat(rec.regular_hours || 8).toFixed(1) + ' hrs');
            $('#det_actual_ot').text(parseFloat(rec.actual_ot_hours || 0).toFixed(1) + ' hrs');
            $('#det_approved_ot').text(parseFloat(rec.approved_ot_hours || 0).toFixed(1) + ' hrs');

            var badge = '';
            if (rec.status === 'pending') {
                badge = '<span class="badge-status badge-pending">Pending Approval</span>';
            } else if (rec.status === 'approved') {
                badge = '<span class="badge-status badge-approved">Approved</span>';
            } else if (rec.status === 'rejected') {
                badge = '<span class="badge-status badge-rejected">Rejected</span>';
            }
            $('#det_status_badge').html(badge);

            // Reason section
            if (rec.modification_reason) {
                $('#det_reason_title').text('Modification Reason:');
                $('#det_reason_content').text(rec.modification_reason);
                $('#det_reason_section').show();
            } else if (rec.rejection_reason) {
                $('#det_reason_title').text('Rejection Reason:');
                $('#det_reason_content').text(rec.rejection_reason);
                $('#det_reason_section').show();
            } else {
                $('#det_reason_section').hide();
            }

            // Timeline audit
            var auditHtml = '';
            if (res.audit && res.audit.length > 0) {
                res.audit.forEach(function(item) {
                    var actTitle = item.action.replace(/_/g, ' ').toUpperCase();
                    auditHtml += '<div class="timeline-item">';
                    auditHtml += '<div class="timeline-point"></div>';
                    auditHtml += '<div class="timeline-content">';
                    auditHtml += '<div class="timeline-header">';
                    auditHtml += '<span>' + escapeHtml(actTitle) + '</span>';
                    auditHtml += '<span class="timeline-time">' + (item.timestamp || '') + '</span>';
                    auditHtml += '</div>';

                    if (item.by) {
                        auditHtml += '<div><strong>By:</strong> ' + escapeHtml(item.by) + '</div>';
                    }
                    if (item.approved_hours !== undefined) {
                        auditHtml += '<div><strong>Approved Duration:</strong> ' + item.approved_hours + ' hrs</div>';
                    }
                    if (item.modification_reason) {
                        auditHtml += '<div><strong>Reason:</strong> ' + escapeHtml(item.modification_reason) + '</div>';
                    }
                    if (item.rejection_reason) {
                        auditHtml += '<div><strong>Reason:</strong> ' + escapeHtml(item.rejection_reason) + '</div>';
                    }
                    if (item.remarks) {
                        auditHtml += '<div><strong>Remarks:</strong> ' + escapeHtml(item.remarks) + '</div>';
                    }
                    if (item.note) {
                        auditHtml += '<div style="color: #b45309;"><i class="fa fa-warning"></i> ' + escapeHtml(item.note) + '</div>';
                    }
                    auditHtml += '</div></div>';
                });
            } else {
                auditHtml = '<div style="color: #94a3b8; font-size: 13px;">No recorded history.</div>';
            }
            $('#det_audit_timeline').html(auditHtml);

            $('#detailsModal').modal('show');
        }
    });
}

function escapeHtml(text) {
    if (!text) return '';
    return String(text)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
</script>
