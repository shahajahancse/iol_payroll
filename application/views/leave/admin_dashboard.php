<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
/* ========================================================================= */
/* ADMIN LEAVE APPROVAL DASHBOARD - MODERN EXECUTIVE THEME                    */
/* ========================================================================= */
.admin-dashboard-wrapper {
    padding: 22px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    background: #f8fafc;
    min-height: calc(100vh - 100px);
}

/* Header Card */
.admin-header-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 22px;
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
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.2);
    flex-shrink: 0;
}
.admin-header-text h2 {
    margin: 0 0 4px 0;
    font-size: 21px;
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
    border-color: #94a3b8;
    color: #0f172a;
}

/* Stat Cards Grid */
.admin-stat-grid {
    display: flex;
    flex-wrap: wrap;
    margin-left: -7px;
    margin-right: -7px;
    margin-bottom: 8px;
}
.admin-stat-col {
    flex: 1 1 0;
    min-width: 170px;
    padding: 0 7px;
    margin-bottom: 14px;
}
@media (max-width: 991px) {
    .admin-stat-col {
        flex: 0 0 33.333%;
        max-width: 33.333%;
    }
}
@media (max-width: 767px) {
    .admin-stat-col {
        flex: 0 0 50%;
        max-width: 50%;
    }
}
.admin-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px 16px;
    margin-bottom: 0;
    height: 100%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    user-select: none;
}
.admin-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 22px -5px rgba(0, 0, 0, 0.08);
}
.admin-stat-card.active-stat-card {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2), 0 8px 18px rgba(37, 99, 235, 0.1);
    background: #f8faff;
}
.admin-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.admin-stat-info {
    flex-grow: 1;
    min-width: 0;
}
.admin-stat-info h3 {
    margin: 0 0 2px 0;
    font-size: 25px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.5px;
}
.admin-stat-info span {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Stat Card Colors */
.stat-navy .admin-stat-icon { background: #f1f5f9; color: #334155; }
.stat-navy h3 { color: #0f172a; }
.stat-navy:hover { border-color: #94a3b8; }

.stat-warning .admin-stat-icon { background: #fef3c7; color: #d97706; }
.stat-warning h3 { color: #d97706; }
.stat-warning:hover { border-color: #f59e0b; }

.stat-success .admin-stat-icon { background: #dcfce7; color: #16a34a; }
.stat-success h3 { color: #16a34a; }
.stat-success:hover { border-color: #22c55e; }

.stat-danger .admin-stat-icon { background: #fee2e2; color: #dc2626; }
.stat-danger h3 { color: #dc2626; }
.stat-danger:hover { border-color: #ef4444; }

.stat-returned .admin-stat-icon { background: #f3e8ff; color: #9333ea; }
.stat-returned h3 { color: #9333ea; }
.stat-returned:hover { border-color: #a855f7; }

.stat-teal .admin-stat-icon { background: #ccfbf1; color: #0d9488; }
.stat-teal h3 { color: #0d9488; }
.stat-teal:hover { border-color: #14b8a6; }

/* Segmented Navigation Tabs */
.admin-tabs-nav-wrapper {
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.admin-tabs-nav {
    display: inline-flex;
    background: #e2e8f0;
    padding: 4px;
    border-radius: 10px;
    list-style: none;
    margin: 0;
}
.admin-tabs-nav > li {
    margin: 0;
}
.admin-tabs-nav > li > a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    text-decoration: none;
    transition: all 0.2s ease;
    border: none;
}
.admin-tabs-nav > li.active > a {
    background: #ffffff;
    color: #0f172a;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
.admin-tabs-nav > li > a:hover:not(.active) {
    color: #0f172a;
}
.queue-counter-badge {
    background: #f59e0b;
    color: #ffffff;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 12px;
    display: inline-block;
}
.admin-tabs-actions {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

/* Modern Card Container for Content */
.admin-content-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
    overflow: hidden;
}

/* Modern Filter Bar */
.admin-filter-bar {
    padding: 18px 20px 14px 20px;
    background: #fbfcfe;
    border-bottom: 1px solid #e2e8f0;
}
.admin-filter-bar .form-group {
    margin-bottom: 10px;
}
.admin-filter-bar label {
    font-size: 11px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.admin-filter-bar .form-control {
    height: 38px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    color: #1e293b;
    box-shadow: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.admin-filter-bar .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
.admin-filter-bar .input-group-addon {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
    padding: 0 10px;
}
.btn-filter-action {
    height: 36px;
    padding: 0 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}

/* Modern Table */
.admin-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}
.admin-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 13px 16px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}
.admin-table tbody td {
    padding: 12px 16px;
    font-size: 13px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #1e293b;
    white-space: nowrap;
}
.admin-table tbody tr {
    transition: background-color 0.15s ease;
}
.admin-table tbody tr:hover {
    background-color: #f8fafc;
}

/* Employee cell */
.emp-cell {
    display: flex;
    align-items: center;
    gap: 12px;
    white-space: nowrap;
}
.emp-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #e0e7ff;
    color: #3730a3;
    font-weight: 700;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    border: 1px solid #c7d2fe;
}
.emp-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 13px;
    line-height: 1.2;
    white-space: nowrap;
}
.emp-id-badge {
    display: inline-block;
    background: #f1f5f9;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
    padding: 1px 6px;
    border-radius: 4px;
    margin-top: 2px;
    white-space: nowrap;
}

/* Status badges with glowing dot */
.badge-status {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 10px;
    font-size: 11px;
    font-weight: 600;
    border-radius: 20px;
    letter-spacing: 0.3px;
}
.badge-status .status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}
.badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-pending .status-dot { background: #d97706; }
.badge-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.badge-approved .status-dot { background: #16a34a; }
.badge-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
.badge-rejected .status-dot { background: #dc2626; }
.badge-returned { background: #f3e8ff; color: #7e22ce; border: 1px solid #e9d5ff; }
.badge-returned .status-dot { background: #9333ea; }

/* Leave Type Badge */
.type-badge {
    padding: 4px 8px;
    font-size: 11px;
    font-weight: 700;
    border-radius: 6px;
    display: inline-block;
    letter-spacing: 0.4px;
}
.type-cl { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.type-sl { background: #ccfbf1; color: #0f766e; border: 1px solid #99f6e4; }
.type-el { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
.type-ml { background: #fce7f3; color: #be185d; border: 1px solid #fbcfe8; }
.type-pl { background: #ede9fe; color: #5b21b6; border: 1px solid #ddd6fe; }
.type-wp { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
.type-sp { background: #ffedd5; color: #c2410c; border: 1px solid #fed7aa; }

/* Micro Action Buttons */
.admin-action-btn-group {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-action-approve {
    background: #16a34a;
    color: #ffffff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 1px 3px rgba(22, 163, 74, 0.3);
    transition: all 0.15s;
    cursor: pointer;
}
.btn-action-approve:hover {
    background: #15803d;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(22, 163, 74, 0.4);
    transform: translateY(-1px);
}
.btn-action-reject {
    background: #dc2626;
    color: #ffffff;
    border: none;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    box-shadow: 0 1px 3px rgba(220, 38, 38, 0.3);
    transition: all 0.15s;
    cursor: pointer;
}
.btn-action-reject:hover {
    background: #b91c1c;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(220, 38, 38, 0.4);
    transform: translateY(-1px);
}
.btn-action-return {
    background: #ffffff;
    color: #9333ea;
    border: 1px solid #d8b4fe;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s;
    cursor: pointer;
}
.btn-action-return:hover {
    background: #f3e8ff;
    color: #7e22ce;
    border-color: #c084fc;
}
.btn-action-modify {
    background: #ffffff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
    padding: 6px 10px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s;
    cursor: pointer;
}
.btn-action-modify:hover {
    background: #eff6ff;
    color: #1d4ed8;
    border-color: #93c5fd;
}
.btn-action-view {
    background: #ffffff;
    color: #334155;
    border: 1px solid #cbd5e1;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.15s;
    cursor: pointer;
}
.btn-action-view:hover {
    background: #f8fafc;
    color: #0f172a;
    border-color: #94a3b8;
}

/* Empty State Box */
.admin-empty-state {
    padding: 50px 20px;
    text-align: center;
}
.admin-empty-icon {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin: 0 auto 16px auto;
}
.empty-green {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}
.empty-gray {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #cbd5e1;
}
.admin-empty-state h4 {
    font-size: 17px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 6px 0;
}
.admin-empty-state p {
    font-size: 13px;
    color: #64748b;
    max-width: 440px;
    margin: 0 auto 18px auto;
    line-height: 1.5;
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
    <!-- Top Executive Header Card -->
    <div class="admin-header-card">
        <div class="admin-header-left">
            <div class="admin-header-icon">
                <i class="fa fa-shield"></i>
            </div>
            <div class="admin-header-text">
                <h2>Admin Leave Approval Dashboard</h2>
                <p>Review, approve, reject, modify, or return employee leave requests with real-time balance calculations.</p>
            </div>
        </div>
        <div class="admin-header-actions">
            <button type="button" class="btn-header-refresh" onclick="loadAdminStats(); loadAdminData(currentAdminPage);" title="Refresh live statistics">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- 5 Real-Time Database Summary Cards -->
    <div class="admin-stat-grid">
        <div class="admin-stat-col">
            <div class="admin-stat-card stat-navy" id="card_stat_total" onclick="selectTabAndFilter('all', '', 'total')">
                <div class="admin-stat-icon"><i class="fa fa-folder-open-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_total">0</h3>
                    <span>Total</span>
                </div>
            </div>
        </div>
        <div class="admin-stat-col">
            <div class="admin-stat-card stat-warning active-stat-card" id="card_stat_pending" onclick="selectTabAndFilter('queue', 'pending', 'pending')">
                <div class="admin-stat-icon"><i class="fa fa-clock-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_pending">0</h3>
                    <span>Pending</span>
                </div>
            </div>
        </div>
        <div class="admin-stat-col">
            <div class="admin-stat-card stat-success" id="card_stat_approved" onclick="selectTabAndFilter('all', 'approved', 'approved')">
                <div class="admin-stat-icon"><i class="fa fa-check-square-o"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_approved">0</h3>
                    <span>Approved</span>
                </div>
            </div>
        </div>
        <div class="admin-stat-col">
            <div class="admin-stat-card stat-danger" id="card_stat_rejected" onclick="selectTabAndFilter('all', 'rejected', 'rejected')">
                <div class="admin-stat-icon"><i class="fa fa-ban"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_rejected">0</h3>
                    <span>Rejected</span>
                </div>
            </div>
        </div>
        <div class="admin-stat-col">
            <div class="admin-stat-card stat-returned" id="card_stat_returned" onclick="selectTabAndFilter('all', 'returned', 'returned')">
                <div class="admin-stat-icon"><i class="fa fa-reply"></i></div>
                <div class="admin-stat-info">
                    <h3 id="stat_returned">0</h3>
                    <span>Returned</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Segmented Tab Navigation -->
    <div class="admin-tabs-nav-wrapper">
        <ul class="admin-tabs-nav" id="admin_tabs">
            <li class="active">
                <a href="#tab_queue" data-toggle="tab" onclick="switchTab('queue')">
                    <i class="fa fa-hourglass-half text-warning"></i> Pending Approval Queue 
                    <span class="queue-counter-badge" id="tab_queue_badge">0</span>
                </a>
            </li>
            <li>
                <a href="#tab_all" data-toggle="tab" onclick="switchTab('all')">
                    <i class="fa fa-list"></i> All Leave Requests & History
                </a>
            </li>
        </ul>
        <div class="admin-tabs-actions">
            <button type="button" class="btn btn-success btn-filter-action" onclick="exportAdminLeave('excel')" style="background: #16a34a; border-color: #16a34a; color: #ffffff; font-weight: 600;">
                <i class="fa fa-file-excel-o"></i> Export Excel
            </button>
            <button type="button" class="btn btn-danger btn-filter-action" onclick="exportAdminLeave('pdf')" style="background: #dc2626; border-color: #dc2626; color: #ffffff; font-weight: 600;">
                <i class="fa fa-file-pdf-o"></i> Export PDF / Print
            </button>
        </div>
    </div>

    <!-- Main Content Card (Filter Bar + Table) -->
    <div class="admin-content-card">
        <!-- Modern Filter Bar -->
        <div class="admin-filter-bar">
            <form id="admin_filter_form" onsubmit="event.preventDefault(); loadAdminData(1);">
                <div class="row" style="margin-left: -6px; margin-right: -6px;">
                    <div class="col-md-3 col-sm-6" style="padding: 0 6px;">
                        <div class="form-group">
                            <label><i class="fa fa-search text-muted"></i> Employee Search</label>
                            <input type="text" class="form-control" id="admin_f_emp" placeholder="Name or Employee ID..." oninput="debounceAdminSearch()">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6" style="padding: 0 6px;">
                        <div class="form-group">
                            <label><i class="fa fa-building-o text-muted"></i> Department</label>
                            <select class="form-control" id="admin_f_dept" onchange="loadAdminData(1)">
                                <option value="">All Departments</option>
                                <?php foreach($departments as $d): ?>
                                    <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6" style="padding: 0 6px;">
                        <div class="form-group">
                            <label><i class="fa fa-tag text-muted"></i> Leave Type</label>
                            <select class="form-control" id="admin_f_type" onchange="loadAdminData(1)">
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
                    <div class="col-md-2 col-sm-6" id="status_filter_wrapper" style="padding: 0 6px; display: none;">
                        <div class="form-group">
                            <label><i class="fa fa-filter text-muted"></i> Status</label>
                            <select class="form-control" id="admin_f_status" onchange="loadAdminData(1)">
                                <option value="all">All Statuses</option>
                                <option value="pending">Pending Approval</option>
                                <option value="approved">Approved</option>
                                <option value="rejected">Rejected</option>
                                <option value="returned">Returned for Modification</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12" style="padding: 0 6px;">
                        <div class="form-group">
                            <label><i class="fa fa-calendar text-muted"></i> Leave Date Range</label>
                            <div class="input-group">
                                <input type="date" class="form-control" id="admin_f_from" onchange="loadAdminData(1)">
                                <span class="input-group-addon">to</span>
                                <input type="date" class="form-control" id="admin_f_to" onchange="loadAdminData(1)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 4px; padding: 0 6px;">
                    <div class="col-sm-12 text-right" style="margin-bottom: 6px;">
                        <button type="button" class="btn btn-default btn-filter-action" onclick="resetAdminFilters()" style="background: #ffffff; border: 1px solid #cbd5e1; color: #475569; margin-right: 6px;">
                            <i class="fa fa-refresh"></i> Reset Filters
                        </button>
                        <button type="button" class="btn btn-primary btn-filter-action" onclick="loadAdminData(1)" style="background: #2563eb; border-color: #2563eb; color: #ffffff;">
                            <i class="fa fa-search"></i> Apply Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="table-responsive" style="border: none;">
            <table class="table admin-table" id="admin_table">
                <thead>
                    <tr>
                        <th width="45">SL</th>
                        <th style="min-width: 190px; white-space: nowrap;">Employee</th>
                        <th style="min-width: 180px; white-space: nowrap;">Department & Designation</th>
                        <th width="75" class="text-center" style="white-space: nowrap;">Type</th>
                        <th style="min-width: 190px; white-space: nowrap;">Duration</th>
                        <th width="75" class="text-center" style="white-space: nowrap;">Days</th>
                        <th width="115" class="text-center" style="white-space: nowrap;">Status</th>
                        <th style="min-width: 150px; white-space: nowrap;">Submitted By</th>
                        <th width="220" class="text-center" style="white-space: nowrap;">Admin Approval Actions</th>
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

<!-- ========================================================================= -->
<!-- MODAL: APPROVE CONFIRMATION WITH OPTIONAL REMARKS -->
<!-- ========================================================================= -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #16a34a; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-check-circle"></i> Approve Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 22px;">
                <input type="hidden" id="approve_leave_id">
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px; margin-bottom: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #166534;" id="approve_emp_name">-</div>
                    <div style="font-size: 12px; color: #15803d; margin-top: 4px;">
                        Leave: <strong id="approve_leave_summary">-</strong>
                    </div>
                </div>
                <div class="form-group">
                    <label style="font-size: 13px; font-weight: 600; color: #334155;">Admin Remarks / Approval Note (Optional)</label>
                    <textarea class="form-control" id="approve_remarks" rows="3" placeholder="Add any conditions or remarks for HR..." style="border-radius: 8px; border: 1px solid #cbd5e1;"></textarea>
                </div>
                <p style="font-size: 12px; color: #64748b; margin: 0;">
                    <i class="fa fa-info-circle"></i> Upon approval, leave will be deducted according to official policy and integrated with monthly attendance records.
                </p>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" class="btn btn-success" id="btn_confirm_approve" onclick="executeApprove()" style="font-weight: 600; border-radius: 8px; background: #16a34a; border-color: #16a34a; padding: 6px 16px;">
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
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #dc2626; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-times-circle"></i> Reject Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 22px;">
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
                    <textarea class="form-control" id="reject_reason" rows="3" placeholder="Provide reason for rejection (visible to HR)..." required style="border-radius: 8px; border: 1px solid #cbd5e1;"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn_confirm_reject" onclick="executeReject()" style="font-weight: 600; border-radius: 8px; background: #dc2626; border-color: #dc2626; padding: 6px 16px;">
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
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #9333ea; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-reply"></i> Return to HR for Modification</h4>
            </div>
            <div class="modal-body" style="padding: 22px;">
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
                    <textarea class="form-control" id="return_reason" rows="3" placeholder="Explain what changes HR must make before resubmission..." required style="border-radius: 8px; border: 1px solid #cbd5e1;"></textarea>
                </div>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_confirm_return" onclick="executeReturn()" style="background: #9333ea; border-color: #7e22ce; font-weight: 600; border-radius: 8px; padding: 6px 16px;">
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
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #006ba3; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-edit"></i> Admin Modification of Leave Request</h4>
            </div>
            <div class="modal-body" style="padding: 22px;">
                <input type="hidden" id="modify_leave_id">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 8px; padding: 14px 16px; margin-bottom: 18px;">
                    <div style="font-size: 14px; font-weight: 700; color: #1e40af;" id="modify_emp_name">-</div>
                    <div style="font-size: 12px; color: #1d4ed8; margin-top: 2px;" id="modify_emp_details">-</div>
                </div>

                <form id="modifyForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 12px; color: #334155;">Leave Type</label>
                                <select class="form-control" id="modify_leave_type" required onchange="calculateModifyDays()" style="border-radius: 8px;">
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
                                <label style="font-weight: 600; font-size: 12px; color: #334155;">Start Date</label>
                                <input type="date" class="form-control" id="modify_from_date" required onchange="calculateModifyDays()" style="border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 12px; color: #334155;">End Date</label>
                                <input type="date" class="form-control" id="modify_to_date" required onchange="calculateModifyDays()" style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 12px; color: #334155;">Calculated Duration</label>
                                <input type="number" class="form-control" id="modify_total_days" readonly style="background: #f1f5f9; font-weight: 700; border-radius: 8px;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <label style="font-weight: 600; font-size: 12px; color: #334155;">Admin Modification Remarks</label>
                                <input type="text" class="form-control" id="modify_remarks" placeholder="Reason for modification by Admin..." style="border-radius: 8px;">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px;">Cancel</button>
                <button type="button" class="btn btn-info" onclick="executeModify('save')" style="font-weight: 600; border-radius: 8px;">
                    <i class="fa fa-save"></i> Save Changes as Pending
                </button>
                <button type="button" class="btn btn-success" onclick="executeModify('save_and_approve')" style="font-weight: 600; border-radius: 8px;">
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
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="background: #006ba3; color: #ffffff; padding: 16px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.9; text-shadow: none;">&times;</button>
                <h4 class="modal-title" style="font-weight: 600;"><i class="fa fa-id-card"></i> Detailed Leave & Profile Inspection</h4>
            </div>
            <div class="modal-body" style="padding: 22px;" id="adminViewBody">
                <!-- dynamic content -->
            </div>
            <div class="modal-footer" style="background: #f8fafc; padding: 14px 20px; border-top: 1px solid #e2e8f0;">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 8px; padding: 6px 18px;">Close</button>
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

function getAvatarColor(str) {
    const colors = [
        { bg: '#e0e7ff', color: '#3730a3', border: '#c7d2fe' },
        { bg: '#dbeafe', color: '#1e40af', border: '#bfdbfe' },
        { bg: '#ccfbf1', color: '#0f766e', border: '#99f6e4' },
        { bg: '#fef3c7', color: '#92400e', border: '#fde68a' },
        { bg: '#fce7f3', color: '#9d174d', border: '#fbcfe8' },
        { bg: '#ede9fe', color: '#5b21b6', border: '#ddd6fe' }
    ];
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
        hash = str.charCodeAt(i) + ((hash << 5) - hash);
    }
    let index = Math.abs(hash) % colors.length;
    return colors[index];
}

function switchTab(tab) {
    currentAdminTab = tab;
    $('.admin-stat-card').removeClass('active-stat-card');
    if (tab === 'queue') {
        $('#card_stat_pending').addClass('active-stat-card');
        $('#status_filter_wrapper').hide();
        $('#admin_f_status').val('pending');
    } else {
        $('#card_stat_total').addClass('active-stat-card');
        $('#status_filter_wrapper').show();
    }
    loadAdminData(1);
}

function selectTabAndFilter(tab, status, cardKey) {
    $('.admin-stat-card').removeClass('active-stat-card');
    if (cardKey) {
        $('#card_stat_' + cardKey).addClass('active-stat-card');
    }

    if (tab === 'queue') {
        $('#admin_tabs a[href="#tab_queue"]').tab('show');
        currentAdminTab = 'queue';
        $('#status_filter_wrapper').hide();
        $('#admin_f_status').val('pending');
        loadAdminData(1);
    } else {
        $('#admin_tabs a[href="#tab_all"]').tab('show');
        currentAdminTab = 'all';
        $('#status_filter_wrapper').show();
        $('#admin_f_status').val(status ? status : 'all');
        loadAdminData(1);
    }
}

function debounceAdminSearch() {
    clearTimeout(adminSearchTimer);
    adminSearchTimer = setTimeout(function() {
        loadAdminData(1);
    }, 350);
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

function exportAdminLeave(format) {
    let emp_id = $('#admin_f_emp').val() || '';
    let dept_id = $('#admin_f_dept').val() || '';
    let leave_type = $('#admin_f_type').val() || '';
    let status = (currentAdminTab === 'queue') ? 'pending' : ($('#admin_f_status').val() || '');
    let from_date = $('#admin_f_from').val() || '';
    let to_date = $('#admin_f_to').val() || '';

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
        if (currentAdminTab === 'queue') {
            $('#admin_tbody').html(`
                <tr>
                    <td colspan="9">
                        <div class="admin-empty-state">
                            <div class="admin-empty-icon empty-green">
                                <i class="fa fa-check"></i>
                            </div>
                            <h4>Pending Approval Queue is Clear!</h4>
                            <p>There are currently no leave requests awaiting admin decision. All submitted applications have been reviewed.</p>
                            <button type="button" class="btn btn-sm btn-action-view" onclick="selectTabAndFilter('all', '', 'total')">
                                <i class="fa fa-history text-primary"></i> View All Leave Requests & History
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        } else {
            $('#admin_tbody').html(`
                <tr>
                    <td colspan="9">
                        <div class="admin-empty-state">
                            <div class="admin-empty-icon empty-gray">
                                <i class="fa fa-search"></i>
                            </div>
                            <h4>No Matching Records Found</h4>
                            <p>No leave applications match your current search criteria or date filter. Try clearing filters to see more results.</p>
                            <button type="button" class="btn btn-sm btn-action-view" onclick="resetAdminFilters()">
                                <i class="fa fa-refresh text-primary"></i> Reset All Filters
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        }
        return;
    }

    let html = '';
    let startSL = (page - 1) * limit;

    rows.forEach(function(row, idx) {
        let sl = startSL + idx + 1;
        let empName = row.name_en || 'Emp #' + row.emp_id;
        let initial = empName.charAt(0).toUpperCase();
        let avatarTheme = getAvatarColor(empName);

        // Status badge
        let statusBadge = '';
        if (row.status === 'pending') {
            statusBadge = `<span class="badge-status badge-pending"><span class="status-dot"></span> Pending</span>`;
        } else if (row.status === 'approved') {
            statusBadge = `<span class="badge-status badge-approved"><span class="status-dot"></span> Approved</span>`;
        } else if (row.status === 'rejected') {
            statusBadge = `<span class="badge-status badge-rejected"><span class="status-dot"></span> Rejected</span>`;
        } else if (row.status === 'returned') {
            statusBadge = `<span class="badge-status badge-returned"><span class="status-dot"></span> Returned</span>`;
        }

        let typeBadge = `<span class="type-badge type-${row.leave_type}">${(row.leave_type || '').toUpperCase()}</span>`;
        let datesFormatted = `<span style="font-weight: 600; color: #0f172a; white-space: nowrap;">${row.leave_start} <span style="font-weight: normal; color: #94a3b8; font-size: 11px;">to</span> ${row.leave_end}</span>`;

        // Action Buttons:
        let actions = '';
        if (row.status === 'pending') {
            actions = `
                <div class="admin-action-btn-group" style="white-space: nowrap;">
                    <button class="btn-action-approve" title="Approve Leave" onclick="openApproveModal(${row.id}, '${escapeHtml(empName)}', '${row.leave_type.toUpperCase()} - ${row.total_leave} day(s)')">
                        <i class="fa fa-check"></i> Approve
                    </button>
                    <button class="btn-action-reject" title="Reject Leave" onclick="openRejectModal(${row.id}, '${escapeHtml(empName)}', '${row.leave_type.toUpperCase()} - ${row.total_leave} day(s)')">
                        <i class="fa fa-times"></i> Reject
                    </button>
                    <button class="btn-action-return" title="Return to HR for Modification" onclick="openReturnModal(${row.id}, '${escapeHtml(empName)}', '${row.leave_type.toUpperCase()} - ${row.total_leave} day(s)')">
                        <i class="fa fa-reply"></i>
                    </button>
                    <button class="btn-action-modify" title="Edit Dates or Type Directly" onclick="openModifyModal(${row.id})">
                        <i class="fa fa-pencil"></i>
                    </button>
                </div>
            `;
        } else {
            actions = `
                <button class="btn-action-view" onclick="viewAdminDetails(${row.id})" style="white-space: nowrap;">
                    <i class="fa fa-eye text-primary"></i> View Details
                </button>
            `;
        }

        html += `
            <tr>
                <td style="color: #64748b; font-weight: 600; white-space: nowrap;">${sl}</td>
                <td style="white-space: nowrap;">
                    <div>
                        <div class="emp-name" style="white-space: nowrap;">${escapeHtml(empName)}</div>
                        <span class="emp-id-badge" style="white-space: nowrap;">ID: ${row.emp_id}</span>
                    </div>
                </td>
                <td style="white-space: nowrap;">
                    <div style="font-weight: 600; color: #334155; white-space: nowrap;">${escapeHtml(row.dept_name || '-')}</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px; white-space: nowrap;">
                        <i class="fa fa-briefcase" style="font-size: 10px; margin-right: 3px;"></i>${escapeHtml(row.desig_name || '-')}
                    </div>
                </td>
                <td class="text-center" style="white-space: nowrap;">${typeBadge}</td>
                <td style="white-space: nowrap;">${datesFormatted}</td>
                <td class="text-center" style="white-space: nowrap;">
                    <span class="badge" style="background: #eff6ff; color: #1d4ed8; font-size: 11px; font-weight: 700; padding: 4px 8px; border-radius: 12px; border: 1px solid #bfdbfe; white-space: nowrap;">
                        ${row.total_leave} d
                    </span>
                </td>
                <td class="text-center" style="white-space: nowrap;">${statusBadge}</td>
                <td style="white-space: nowrap;">
                    <div style="font-size: 12px; color: #334155; white-space: nowrap;">${row.applied_at ? row.applied_at.substring(0, 16) : '-'}</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px; white-space: nowrap;">
                        <i class="fa fa-user-circle-o" style="margin-right: 3px;"></i>${escapeHtml(row.applied_by_name || 'HR')}
                    </div>
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

    let statusBadge = '';
    if (leave.status === 'pending') statusBadge = `<span class="badge-status badge-pending"><span class="status-dot"></span> Pending</span>`;
    else if (leave.status === 'approved') statusBadge = `<span class="badge-status badge-approved"><span class="status-dot"></span> Approved</span>`;
    else if (leave.status === 'rejected') statusBadge = `<span class="badge-status badge-rejected"><span class="status-dot"></span> Rejected</span>`;
    else if (leave.status === 'returned') statusBadge = `<span class="badge-status badge-returned"><span class="status-dot"></span> Returned</span>`;

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
        <div style="display:flex; justify-content:space-between; align-items:center; background:#f8fafc; padding:12px 16px; border-radius:8px; margin-bottom:15px; border: 1px solid #e2e8f0;">
            <div>
                <h4 style="margin:0; font-weight:700; color:#0f172a;">${escapeHtml(empName)} (ID: ${leave.emp_id})</h4>
                <div style="font-size:12px; color:#64748b; margin-top: 2px;">Dept: ${escapeHtml(leave.dept_name || '-')} | Desig: ${escapeHtml(leave.desig_name || '-')} | Unit: ${escapeHtml(leave.unit_name || '-')}</div>
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
            ${leave.return_reason ? `<tr><td class="text-muted">Return Reason</td><td style="color: #7e22ce; font-weight: bold;">${escapeHtml(leave.return_reason)}</td></tr>` : ''}
        </table>

        <h5 style="font-weight:700; color:#334155; margin-top:20px;"><i class="fa fa-history"></i> Complete History Audit Trail</h5>
        ${timelineHtml}
    `;

    $('#adminViewBody').html(html);
}
</script>
