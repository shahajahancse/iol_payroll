<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit_initial = isset($is_edit) && $is_edit && isset($od) && !empty($od);
$init_od_id      = $is_edit_initial ? $od->id : 0;
$init_emp_id     = $is_edit_initial ? $od->emp_id : '';
$init_start_date = ($is_edit_initial && !empty($od->start_date)) ? $od->start_date : date('Y-m-d');
$init_end_date   = ($is_edit_initial && !empty($od->end_date)) ? $od->end_date : date('Y-m-d');
$init_purpose    = $is_edit_initial ? $od->purpose : '';
$init_location   = ($is_edit_initial && !empty($od->location)) ? $od->location : '';
$init_remarks    = $is_edit_initial ? $od->remarks : '';
$current_tab     = isset($active_tab) && in_array($active_tab, array('list', 'assign', 'reports')) ? $active_tab : 'list';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) SINGLE-PAGE MANAGEMENT HUB - EXECUTIVE THEME           */
/* ========================================================================= */
.page-content .content.od-manage-wrapper {
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

/* Action Buttons */
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
    cursor: pointer;
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

/* KPI Summary Cards */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 16px;
    margin-bottom: 22px;
}
.kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
}
.kpi-icon-wrap {
    width: 46px;
    height: 46px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.kpi-icon-today { background: #e0f2fe; color: #0284c7; }
.kpi-icon-month { background: #e0e7ff; color: #4338ca; }
.kpi-icon-approved { background: #dcfce7; color: #15803d; }
.kpi-icon-status { background: #fef3c7; color: #b45309; }
.kpi-val {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.2;
}
.kpi-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    margin-top: 2px;
}

/* Main Hub Navigation Tabs */
.hub-nav-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 20px;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0;
    overflow-x: auto;
}
.hub-tab-btn {
    padding: 12px 20px;
    font-size: 13.5px;
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
    white-space: nowrap;
    border-radius: 6px 6px 0 0;
}
.hub-tab-btn:hover {
    color: #0284c7;
    background: #f8fafc;
}
.hub-tab-btn.active {
    color: #0284c7;
    font-weight: 700;
    border-bottom-color: #0284c7;
    background: #ffffff;
}
.hub-tab-badge {
    background: #e0f2fe;
    color: #0284c7;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 7px;
    border-radius: 10px;
}

/* Tab Panels */
.hub-tab-panel {
    display: none;
}
.hub-tab-panel.active {
    display: block;
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
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 14px;
    align-items: flex-end;
}
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 5px;
}
.filter-group label {
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    margin: 0;
}
.filter-input {
    height: 38px;
    padding: 6px 12px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13px;
    color: #1e293b;
    background-color: #ffffff;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
    width: 100%;
}
.filter-input:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
}
.filter-actions {
    display: flex;
    gap: 8px;
}
.btn-filter-apply {
    background: #0284c7;
    color: #ffffff;
    border: none;
    padding: 0 16px;
    height: 38px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: background 0.2s;
    white-space: nowrap;
}
.btn-filter-apply:hover { background: #0369a1; }
.btn-filter-reset {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    padding: 0 14px;
    height: 38px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
    white-space: nowrap;
}
.btn-filter-reset:hover { background: #e2e8f0; color: #0f172a; }

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
    text-align: left;
}
.table-od thead th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px;
    border-bottom: 1px solid #e2e8f0;
    white-space: nowrap;
}
.table-od tbody td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
}
.table-od tbody tr:hover {
    background-color: #f8fafc;
}

/* Status Badges */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.status-pill.approved { background: #dcfce7; color: #15803d; }
.status-pill.pending  { background: #fef3c7; color: #b45309; }
.status-pill.rejected { background: #fee2e2; color: #b91c1c; }
.status-pill.cancelled { background: #f1f5f9; color: #64748b; }

.attn-status-badge {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 700;
    font-size: 11px;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* Row Action Buttons */
.action-btn-group {
    display: inline-flex;
    gap: 5px;
}
.btn-sm-action {
    width: 30px;
    height: 30px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.2s;
    text-decoration: none;
}
.btn-sm-action:hover {
    background: #f1f5f9;
    color: #0284c7;
    border-color: #0284c7;
    text-decoration: none;
}
.btn-sm-action.btn-approve:hover {
    background: #dcfce7;
    color: #15803d;
    border-color: #15803d;
}
.btn-sm-action.btn-reject:hover {
    background: #fee2e2;
    color: #b91c1c;
    border-color: #b91c1c;
}

/* Pagination Footer */
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    font-size: 13px;
    color: #64748b;
    flex-wrap: wrap;
    gap: 10px;
}
.pagination-controls {
    display: flex;
    gap: 4px;
}
.btn-page {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    min-width: 32px;
    height: 32px;
    padding: 0 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-page:hover:not(:disabled) {
    background: #f1f5f9;
    color: #0284c7;
}
.btn-page.active {
    background: #0284c7;
    color: #ffffff;
    border-color: #0284c7;
}
.btn-page:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ========================================================================= */
/* TAB 2: ASSIGN / EDIT OUTSIDE DUTY FORM STYLES                             */
/* ========================================================================= */
.assign-form-container {
    max-width: 820px;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
}
.form-banner-edit {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    border-radius: 10px;
    padding: 12px 18px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.form-banner-edit strong {
    color: #1e40af;
    font-size: 14px;
}
.form-group-item {
    margin-bottom: 20px;
}
.form-group-label {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
}
.form-group-label .req {
    color: #ef4444;
}
.input-custom {
    width: 100%;
    padding: 9px 14px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    font-size: 13.5px;
    color: #0f172a;
    background: #ffffff;
    box-sizing: border-box;
    transition: all 0.2s;
}
.input-custom:focus {
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
    border: none;
    background: none;
    color: #94a3b8;
    font-size: 18px;
    cursor: pointer;
}
.emp-search-dropdown {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    max-height: 240px;
    overflow-y: auto;
    z-index: 1000;
    display: none;
}
.emp-dropdown-item {
    padding: 10px 14px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
}
.emp-dropdown-item:hover {
    background: #f8fafc;
}
.emp-item-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #e0f2fe;
    color: #0284c7;
    font-weight: 700;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.emp-item-info {
    flex: 1;
}
.emp-item-name {
    font-size: 13px;
    font-weight: 600;
    color: #0f172a;
}
.emp-item-sub {
    font-size: 11px;
    color: #64748b;
}

/* Selected Employee Banner */
.emp-selected-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
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
    border-radius: 50%;
    background: #0284c7;
    color: #ffffff;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.emp-selected-title {
    font-weight: 700;
    font-size: 14px;
    color: #0f172a;
}
.emp-selected-sub {
    font-size: 12px;
    color: #64748b;
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
}
.btn-change-emp:hover {
    background: #f1f5f9;
    color: #0f172a;
}

/* Dates Grid */
.date-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}
.days-pill {
    background: #dcfce7;
    color: #15803d;
    font-weight: 700;
    font-size: 12px;
    padding: 2px 10px;
    border-radius: 12px;
}

/* Schedule Conflict Box */
.conflict-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 12.5px;
    margin-top: 10px;
    display: none;
}


/* Form Action Buttons */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 26px;
    padding-top: 18px;
    border-top: 1px solid #f1f5f9;
}
.btn-save-od {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border: none;
    padding: 9px 22px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    transition: all 0.2s;
}
.btn-save-od:hover {
    background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
}
.btn-cancel-form {
    background: #f1f5f9;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-cancel-form:hover {
    background: #e2e8f0;
    color: #0f172a;
    text-decoration: none;
}

/* ========================================================================= */
/* TAB 3: REPORTS TAB STYLES                                                 */
/* ========================================================================= */
.report-subtabs {
    display: flex;
    gap: 6px;
    margin-bottom: 16px;
}
.report-subtab-btn {
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 12.5px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.report-subtab-btn.active {
    background: #0284c7;
    color: #ffffff;
    border-color: #0284c7;
}

/* Modal Details */
.modal-header-custom {
    padding: 16px 22px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.modal-title-custom {
    font-size: 16px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}
.detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}
.detail-item .lbl {
    font-size: 11.5px;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 3px;
    text-transform: uppercase;
}
.detail-item .val {
    font-size: 13.5px;
    font-weight: 600;
    color: #0f172a;
}
.audit-list {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px;
    max-height: 140px;
    overflow-y: auto;
    font-size: 11.5px;
}
.audit-item {
    padding: 4px 0;
    border-bottom: 1px dashed #e2e8f0;
}
.audit-item:last-child {
    border-bottom: none;
}
</style>

<div class="content od-manage-wrapper">

    <!-- Top Executive Header Card -->
    <div class="od-header-card">
        <div class="od-header-left">
            <div class="od-header-icon">
                <i class="fa fa-briefcase"></i>
            </div>
            <div class="od-header-text">
                <h2>Outside Duty (OD) Management</h2>
                <p>Assign official outside duty, manage attendance synchronization, and monitor employee field movements</p>
            </div>
        </div>
        <div class="od-header-actions">
            <button type="button" class="btn-action-primary" id="btn_top_assign" onclick="switchToTab('assign')">
                <i class="fa fa-plus"></i> Assign Outside Duty
            </button>
            <button type="button" class="btn-action-outline" onclick="exportData('csv')">
                <i class="fa fa-file-excel-o text-success"></i> Export CSV
            </button>
            <button type="button" class="btn-action-outline" onclick="exportData('print')">
                <i class="fa fa-print"></i> Print
            </button>
            <button type="button" class="btn-action-outline" id="btn_hub_refresh" onclick="refreshHubData()">
                <i class="fa fa-refresh"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Executive KPI Summary Cards -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon-wrap kpi-icon-today">
                <i class="fa fa-users"></i>
            </div>
            <div>
                <div class="kpi-val" id="kpi_today_count"><?= isset($stats['today_count']) ? $stats['today_count'] : 0 ?></div>
                <div class="kpi-label">On Outside Duty Today</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon-wrap kpi-icon-month">
                <i class="fa fa-calendar"></i>
            </div>
            <div>
                <div class="kpi-val" id="kpi_month_count"><?= isset($stats['this_month_count']) ? $stats['this_month_count'] : 0 ?></div>
                <div class="kpi-label">This Month Assignments</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon-wrap kpi-icon-approved">
                <i class="fa fa-check-circle"></i>
            </div>
            <div>
                <div class="kpi-val" id="kpi_approved_count"><?= isset($stats['approved_count']) ? $stats['approved_count'] : 0 ?></div>
                <div class="kpi-label">Total Approved Records</div>
            </div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon-wrap kpi-icon-status">
                <i class="fa fa-clock-o"></i>
            </div>
            <div>
                <div class="kpi-val" style="font-size:16px; color:#b45309;">Live Attendance</div>
                <div class="kpi-label">Status marked as <strong style="color:#0284c7;">OD</strong> (Present)</div>
            </div>
        </div>
    </div>

    <!-- Navigation Hub Tabs -->
    <div class="hub-nav-tabs">
        <button type="button" class="hub-tab-btn <?= $current_tab === 'list' ? 'active' : '' ?>" id="tab_btn_list" onclick="switchToTab('list')">
            <i class="fa fa-list-alt"></i> OD Assignments List
            <span class="hub-tab-badge" id="badge_list_count">0</span>
        </button>
        <button type="button" class="hub-tab-btn <?= $current_tab === 'assign' ? 'active' : '' ?>" id="tab_btn_assign" onclick="switchToTab('assign')">
            <i class="fa fa-plus-circle"></i> <span id="lbl_tab_assign_title"><?= $is_edit_initial ? 'Edit Outside Duty #' . $init_od_id : 'Assign Outside Duty' ?></span>
        </button>
        <button type="button" class="hub-tab-btn <?= $current_tab === 'reports' ? 'active' : '' ?>" id="tab_btn_reports" onclick="switchToTab('reports')">
            <i class="fa fa-bar-chart"></i> OD Reports Center
        </button>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 1: OD ASSIGNMENTS LIST                                            -->
    <!-- ===================================================================== -->
    <div class="hub-tab-panel <?= $current_tab === 'list' ? 'active' : '' ?>" id="panel_list">

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
                        <option value="approved">Approved</option>
                        <option value="pending">Pending Approval</option>
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
                            <th style="text-align:center;">Status</th>
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

    <!-- ===================================================================== -->
    <!-- TAB 2: ASSIGN / EDIT OUTSIDE DUTY                                     -->
    <!-- ===================================================================== -->
    <div class="hub-tab-panel <?= $current_tab === 'assign' ? 'active' : '' ?>" id="panel_assign">

        <div class="assign-form-container">

            <!-- Edit Mode Banner -->
            <div class="form-banner-edit" id="edit_mode_banner" style="<?= $is_edit_initial ? '' : 'display:none;' ?>">
                <div>
                    <i class="fa fa-info-circle text-primary"></i> <strong>Editing Outside Duty #<span id="txt_edit_banner_id"><?= $init_od_id ?></span></strong>
                    <div style="font-size:12px; color:#475569; margin-top:2px;">Modify dates, purpose, or remarks and click Update to save.</div>
                </div>
                <button type="button" class="btn btn-xs btn-default" onclick="cancelEditMode()">
                    <i class="fa fa-times"></i> Cancel Edit Mode
                </button>
            </div>

            <form id="odAssignForm" autocomplete="off">
                <input type="hidden" name="od_id" id="od_id" value="<?= $init_od_id ?>">
                <input type="hidden" name="emp_id" id="emp_id" value="<?= htmlspecialchars($init_emp_id) ?>">
                <input type="hidden" name="assignment_mode" value="range">
                <input type="hidden" name="status" value="approved">

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
                                   style="padding-left: 38px !important; padding-right: 36px !important;"
                                   placeholder="Type Employee ID or Name (e.g. 1001, Rahim)..."
                                   value="" autocomplete="off">
                            <button type="button" class="clear-btn" id="btn_clear_search">&times;</button>
                        </div>
                        <div class="emp-search-dropdown" id="emp_dropdown_results"></div>
                        <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                            Search by Employee ID or Name, or enter exact ID and press Enter
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
                        <button type="button" class="btn-change-emp" id="btn_change_employee">
                            <i class="fa fa-refresh"></i> Change Employee
                        </button>
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
                                   value="<?= $init_start_date ?>" required>
                        </div>
                        <div>
                            <label class="form-group-label">
                                <span>End Date <span class="req">*</span></span>
                                <span class="days-pill" id="days_badge"><i class="fa fa-calendar-check-o"></i> 1 Day</span>
                            </label>
                            <input type="date" class="input-custom" name="end_date" id="end_date"
                                   value="<?= $init_end_date ?>" required>
                        </div>
                    </div>

                    <!-- Schedule Conflict Box -->
                    <div class="conflict-alert" id="conflict_alert_box">
                        <i class="fa fa-exclamation-triangle"></i> <strong>Schedule Conflict Alert:</strong>
                        <div id="conflict_message_text" style="margin-top:3px;"></div>
                    </div>
                </div>

                <!-- 3. Purpose -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Purpose / Category <span class="req">*</span></span>
                    </label>
                    <input type="text" class="input-custom" name="purpose" id="purpose" required
                           placeholder="Enter OD purpose (e.g. Client Visit, Bank Work, Field Inspection, Official Tour...)"
                           value="<?= htmlspecialchars($init_purpose) ?>">
                </div>

                <!-- 4. Location -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Location / Destination <span style="font-weight:normal; color:#64748b; font-size:12px;">(Optional)</span></span>
                    </label>
                    <input type="text" class="input-custom" name="location" id="location"
                           placeholder="e.g. Uttara Branch, Head Office, Sonali Bank Motijheel, Factory site..."
                           value="<?= htmlspecialchars($init_location) ?>">
                </div>

                <!-- 5. Remark -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Remark / Note <span style="font-weight:normal; color:#64748b; font-size:12px;">(Optional)</span></span>
                    </label>
                    <textarea class="input-custom" name="remarks" id="remarks" rows="2"
                              placeholder="Enter any additional notes or instructions..."><?= htmlspecialchars($init_remarks) ?></textarea>
                </div>

                <!-- Footer Buttons -->
                <div class="form-actions">
                    <button type="button" class="btn-cancel-form" onclick="resetAssignForm()">
                        <i class="fa fa-undo"></i> Reset
                    </button>
                    <button type="submit" class="btn-save-od" id="btn_submit_od">
                        <i class="fa fa-check"></i> <span id="lbl_save_btn"><?= $is_edit_initial ? 'Update Outside Duty' : 'Save Outside Duty' ?></span>
                    </button>
                </div>

            </form>
        </div>

    </div>

    <!-- ===================================================================== -->
    <!-- TAB 3: OD REPORTS & PRINT                                             -->
    <!-- ===================================================================== -->
    <div class="hub-tab-panel <?= $current_tab === 'reports' ? 'active' : '' ?>" id="panel_reports">

        <!-- Report Type Sub-Tabs -->
        <div class="report-subtabs">
            <button type="button" class="report-subtab-btn active" id="btn_rpt_daily" onclick="switchReportType('daily')">
                <i class="fa fa-calendar-check-o"></i> Daily OD Report
            </button>
            <button type="button" class="report-subtab-btn" id="btn_rpt_monthly" onclick="switchReportType('monthly')">
                <i class="fa fa-calendar"></i> Monthly Summary
            </button>
            <button type="button" class="report-subtab-btn" id="btn_rpt_employee" onclick="switchReportType('employee')">
                <i class="fa fa-user"></i> Employee History
            </button>
            <button type="button" class="report-subtab-btn" id="btn_rpt_department" onclick="switchReportType('department')">
                <i class="fa fa-building"></i> Department Summary
            </button>
        </div>

        <!-- Dynamic Filter Controls -->
        <div class="filter-card">
            <div class="filter-grid" id="rpt_filter_container">
                <!-- Dynamically rendered based on active report type -->
            </div>
        </div>

        <!-- Report Table Card -->
        <div class="table-card">
            <div class="table-responsive-custom">
                <table class="table-od" id="reportTable">
                    <thead id="reportTableHead"></thead>
                    <tbody id="reportTableBody">
                        <tr>
                            <td colspan="10" style="text-align:center; padding:30px; color:#64748b;">
                                <i class="fa fa-spinner fa-spin"></i> Loading report data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <div>Total Records: <strong id="lbl_report_total">0</strong></div>
                <div>Outside Duty (OD) Management Hub</div>
            </div>
        </div>

    </div>

</div>

<!-- ========================================================================= -->
<!-- MODALS                                                                    -->
<!-- ========================================================================= -->

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
                <p style="font-size:13px; color:#475569;">Are you sure you want to cancel this Outside Duty assignment? Attendance for these dates will revert to normal shifts.</p>
                <textarea class="form-control" id="cancel_reason_text" rows="2" placeholder="Optional cancellation reason..." style="border-radius:8px;"></textarea>
            </div>
            <div class="modal-footer" style="background:#f8fafc; padding:12px 20px;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Keep Active</button>
                <button type="button" class="btn btn-warning" id="btn_confirm_cancel" style="background:#d97706; border-color:#d97706; color:#fff;" onclick="confirmCancel()">Confirm Cancellation</button>
            </div>
        </div>
    </div>
</div>

<script>
var isAdmin = <?= $is_admin ? 'true' : 'false' ?>;
var currentPage = 1;
var pageLimit = 20;
var currentTab = '<?= $current_tab ?>';
var activeReportType = 'daily';

$(document).ready(function() {
    // Initial Load
    loadOdList(1);
    refreshHubStats();
    renderReportFilterControls();
    updateDaysCount();

    // Employee search autocomplete
    var searchTimer = null;
    $('#emp_search_input').on('input', function() {
        var term = $.trim($(this).val());
        clearTimeout(searchTimer);
        if (term.length === 0) {
            $('#emp_dropdown_results').hide().empty();
            return;
        }
        searchTimer = setTimeout(function() {
            searchEmployeeAjax(term);
        }, 250);
    });

    $('#emp_search_input').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            var term = $.trim($(this).val());
            if (term.length > 0) {
                searchEmployeeAjax(term, true);
            }
        }
    });

    $('#btn_clear_search').on('click', function() {
        $('#emp_search_input').val('').focus();
        $('#emp_dropdown_results').hide().empty();
    });

    $('#btn_change_employee').on('click', function() {
        $('#emp_id').val('');
        $('#emp_selected_badge').hide();
        $('#emp_search_box').show();
        $('#emp_search_input').val('').focus();
        $('#conflict_alert_box').hide();
    });

    // Date changes calculate days and check conflicts
    $('#start_date, #end_date').on('change', function() {
        updateDaysCount();
        checkConflictsAjax();
    });

    // Assign Form Submit
    $('#odAssignForm').on('submit', function(e) {
        e.preventDefault();
        submitAssignForm();
    });
});

// =========================================================================
// TAB SWITCHING
// =========================================================================
function switchToTab(tabName) {
    currentTab = tabName;
    $('.hub-tab-btn').removeClass('active');
    $('.hub-tab-panel').removeClass('active');

    $('#tab_btn_' + tabName).addClass('active');
    $('#panel_' + tabName).addClass('active');

    if (tabName === 'list') {
        loadOdList(currentPage);
    } else if (tabName === 'reports') {
        fetchReportData();
    }
}



// =========================================================================
// STATS / KPI REFRESH
// =========================================================================
function refreshHubData() {
    var $btn = $('#btn_hub_refresh');
    $btn.find('i').addClass('fa-spin');

    refreshHubStats();
    if (currentTab === 'list') {
        loadOdList(currentPage);
    } else if (currentTab === 'reports') {
        fetchReportData();
    }

    setTimeout(function() {
        $btn.find('i').removeClass('fa-spin');
    }, 600);
}

function refreshHubStats() {
    $.ajax({
        url: '<?= base_url("od_management_con/dashboard_stats_ajax") ?>',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.status === 'success' && res.data) {
                $('#kpi_today_count').text(res.data.today_count || 0);
                $('#kpi_month_count').text(res.data.this_month_count || 0);
                $('#kpi_approved_count').text(res.data.approved_count || 0);
            }
        }
    });
}

// =========================================================================
// TAB 1: OD LIST AJAX & RENDERING
// =========================================================================
function getFilters() {
    return {
        unit_id: $('#flt_unit').val() || '',
        dept_id: $('#flt_dept').val() || '',
        status: $('#flt_status').val() || '',
        purpose: $('#flt_purpose').val() || '',
        from_date: $('#flt_from_date').val() || '',
        to_date: $('#flt_to_date').val() || '',
        emp_id: $('#flt_emp').val() || ''
    };
}

function resetFilters() {
    $('#flt_unit').val('');
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
    $('#badge_list_count').text(total || 0);

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
        var dateDisplay = '';
        if (row.start_date === row.end_date) {
            dateDisplay = '<span style="font-weight:600; color:#0f172a;">' + row.start_date + '</span>';
        } else {
            dateDisplay = '<span style="font-weight:600; color:#0f172a;">' + row.start_date + '</span><br><span style="font-size:11px; color:#64748b;">to ' + row.end_date + '</span>';
        }

        var attnBadge = '-';
        if (row.status === 'approved') {
            attnBadge = '<span class="attn-status-badge"><i class="fa fa-check"></i> OD</span>';
        } else if (row.status === 'pending') {
            attnBadge = '<span style="font-size:11px; color:#94a3b8;">Pending</span>';
        } else {
            attnBadge = '<span style="font-size:11px; color:#94a3b8;">N/A</span>';
        }

        var actions = '<div class="action-btn-group">';
        actions += '<button type="button" class="btn-sm-action" title="View Details" onclick="viewDetails(' + row.id + ')"><i class="fa fa-eye"></i></button>';

        if (row.status === 'pending') {
            if (isAdmin) {
                actions += '<button type="button" class="btn-sm-action btn-approve" title="Approve OD" onclick="approveOd(' + row.id + ')"><i class="fa fa-check"></i></button>';
                actions += '<button type="button" class="btn-sm-action btn-reject" title="Reject OD" onclick="openRejectModal(' + row.id + ')"><i class="fa fa-times"></i></button>';
            }
            actions += '<button type="button" class="btn-sm-action" title="Edit Assignment" onclick="startEditAssignment(' + row.id + ')"><i class="fa fa-pencil"></i></button>';
        } else if (row.status === 'approved') {
            actions += '<button type="button" class="btn-sm-action" title="Edit Assignment" onclick="startEditAssignment(' + row.id + ')"><i class="fa fa-pencil"></i></button>';
            if (isAdmin) {
                actions += '<button type="button" class="btn-sm-action" title="Cancel OD" style="color:#d97706;" onclick="openCancelModal(' + row.id + ')"><i class="fa fa-ban"></i></button>';
            }
        }
        actions += '</div>';

        var subInfo = '';
        if (row.location) {
            subInfo = '<div style="font-size:11px; color:#64748b;"><i class="fa fa-map-marker" style="color:#ef4444;"></i> ' + row.location + '</div>';
        } else if (row.remarks) {
            subInfo = '<div style="font-size:11px; color:#64748b;"><i class="fa fa-comment-o"></i> ' + row.remarks + '</div>';
        }

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
                    subInfo +
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

// =========================================================================
// TAB 2: ASSIGN / EDIT OUTSIDE DUTY LOGIC
// =========================================================================
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
        $('#days_badge').html('<span style="color:#ef4444;"><i class="fa fa-warning"></i> End &lt; Start</span>');
        return;
    }
    var diffTime = Math.abs(d2 - d1);
    var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
    $('#days_badge').html('<i class="fa fa-calendar-check-o"></i> ' + diffDays + (diffDays === 1 ? ' Day' : ' Days'));
}

function searchEmployeeAjax(term, autoSelectFirst) {
    $.ajax({
        url: '<?= base_url("od_management_con/employee_search_ajax") ?>',
        type: 'GET',
        data: { q: term },
        dataType: 'json',
        success: function(res) {
            if (res && res.status === 'success' && res.data && res.data.length > 0) {
                if (autoSelectFirst && res.data.length === 1) {
                    selectEmployee(res.data[0]);
                    return;
                }
                var html = '';
                res.data.forEach(function(emp) {
                    var initials = emp.name_en ? emp.name_en.substring(0,2).toUpperCase() : 'EM';
                    html += '<div class="emp-dropdown-item" onclick=\'selectEmployee(' + JSON.stringify(emp) + ')\'>' +
                                '<div class="emp-item-avatar">' + initials + '</div>' +
                                '<div class="emp-item-info">' +
                                    '<div class="emp-item-name">' + emp.emp_id + ' - ' + emp.name_en + '</div>' +
                                    '<div class="emp-item-sub">' + (emp.desig_name || '-') + ' | ' + (emp.dept_name || '-') + ' (' + (emp.unit_name || '-') + ')</div>' +
                                '</div>' +
                            '</div>';
                });
                $('#emp_dropdown_results').html(html).show();
            } else {
                $('#emp_dropdown_results').html('<div style="padding:12px; color:#94a3b8; text-align:center; font-size:12px;">No matching employees found.</div>').show();
            }
        }
    });
}

function selectEmployee(emp) {
    $('#emp_id').val(emp.emp_id);
    var initials = emp.name_en ? emp.name_en.substring(0,2).toUpperCase() : 'EM';
    $('#prev_avatar').text(initials);
    $('#prev_emp_title').text(emp.emp_id + ' - ' + emp.name_en);
    $('#prev_emp_sub').text((emp.desig_name || '-') + ' | ' + (emp.dept_name || '-') + ' (' + (emp.unit_name || '-') + ')');

    $('#emp_search_box').hide();
    $('#emp_dropdown_results').hide().empty();
    $('#emp_selected_badge').show();

    checkConflictsAjax();
}

function checkConflictsAjax() {
    var empId = $('#emp_id').val();
    var s = $('#start_date').val();
    var e = $('#end_date').val();
    var odId = $('#od_id').val() || 0;

    if (!empId || !s || !e) {
        $('#conflict_alert_box').hide();
        return;
    }

    var dates = [];
    var curr = new Date(s);
    var last = new Date(e);
    while (curr <= last) {
        var dStr = curr.toISOString().split('T')[0];
        dates.push(dStr);
        curr.setDate(curr.getDate() + 1);
    }

    $.ajax({
        url: '<?= base_url("od_management_con/check_conflicts_ajax") ?>',
        type: 'POST',
        data: {
            emp_id: empId,
            dates: dates,
            exclude_id: odId
        },
        dataType: 'json',
        success: function(res) {
            if (res && res.has_conflict) {
                var msgs = [];
                if (res.conflicts.existing_ods && res.conflicts.existing_ods.length > 0) {
                    var odDates = res.conflicts.existing_ods.map(function(o){ return o.date + ' (' + o.status + ')'; }).join(', ');
                    msgs.push('Already assigned to OD on: ' + odDates);
                }
                if (res.conflicts.leaves && res.conflicts.leaves.length > 0) {
                    var lvDates = res.conflicts.leaves.map(function(l){ return l.date + ' (' + l.leave_type + ')'; }).join(', ');
                    msgs.push('Has approved Leave on: ' + lvDates);
                }
                $('#conflict_message_text').html(msgs.join('<br>'));
                $('#conflict_alert_box').show();
            } else {
                $('#conflict_alert_box').hide();
            }
        }
    });
}

function submitAssignForm() {
    var empId = $('#emp_id').val();
    if (!empId) {
        Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select an employee first.' });
        return;
    }

    var s = $('#start_date').val();
    var e = $('#end_date').val();
    if (!s || !e) {
        Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select both start and end date.' });
        return;
    }
    if (e < s) {
        Swal.fire({ icon: 'error', title: 'Invalid Dates', text: 'End date cannot be earlier than start date.' });
        return;
    }

    var purpose = $.trim($('#purpose').val());
    if (!purpose) {
        Swal.fire({ icon: 'warning', title: 'Required', text: 'Please enter the OD purpose.' });
        return;
    }

    var $btn = $('#btn_submit_od');
    $btn.prop('disabled', true).find('i').removeClass('fa-check').addClass('fa-spinner fa-spin');

    var odId = parseInt($('#od_id').val()) || 0;
    var targetUrl = (odId > 0) ? '<?= base_url("od_management_con/edit/") ?>' + odId : '<?= base_url("od_management_con/create") ?>';

    $.ajax({
        url: targetUrl,
        type: 'POST',
        data: $('#odAssignForm').serialize(),
        dataType: 'json',
        success: function(res) {
            $btn.prop('disabled', false).find('i').removeClass('fa-spinner fa-spin').addClass('fa-check');
            if (res && res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.message || 'Outside Duty assignment saved successfully!',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Reset assign form to blank
                resetAssignForm();

                // Refresh List & KPI stats
                refreshHubStats();
                loadOdList(1);

                // Switch back to List tab
                switchToTab('list');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: res.message || 'Could not save OD assignment. Please try again.'
                });
            }
        },
        error: function(xhr) {
            $btn.prop('disabled', false).find('i').removeClass('fa-spinner fa-spin').addClass('fa-check');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Server communication error. Please try again.'
            });
        }
    });
}

function startEditAssignment(id) {
    // Fetch details via ajax and populate Tab 2
    $.ajax({
        url: '<?= base_url("od_management_con/details_ajax/") ?>' + id,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res && res.status === 'success' && res.data) {
                var d = res.data;
                $('#od_id').val(d.id);
                $('#txt_edit_banner_id').text(d.id);
                $('#edit_mode_banner').show();
                $('#lbl_tab_assign_title').text('Edit Outside Duty #' + d.id);
                $('#lbl_save_btn').text('Update Outside Duty');

                // Fill employee
                $('#emp_id').val(d.emp_id);
                var initials = d.name_en ? d.name_en.substring(0,2).toUpperCase() : 'EM';
                $('#prev_avatar').text(initials);
                $('#prev_emp_title').text(d.emp_id + ' - ' + (d.name_en || ''));
                $('#prev_emp_sub').text((d.desig_name || '-') + ' | ' + (d.dept_name || '-') + ' (' + (d.unit_name || '-') + ')');
                $('#emp_search_box').hide();
                $('#emp_selected_badge').show();

                // Dates & fields
                $('#start_date').val(d.start_date);
                $('#end_date').val(d.end_date);
                $('#purpose').val(d.purpose || '');
                $('#location').val(d.location || '');
                $('#remarks').val(d.remarks || '');

                updateDaysCount();
                checkConflictsAjax();

                // Switch to Assign Tab
                switchToTab('assign');
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Could not load OD assignment details for editing.' });
            }
        }
    });
}

function cancelEditMode() {
    resetAssignForm();
    switchToTab('list');
}

function resetAssignForm() {
    $('#od_id').val(0);
    $('#edit_mode_banner').hide();
    $('#lbl_tab_assign_title').text('Assign Outside Duty');
    $('#lbl_save_btn').text('Save Outside Duty');

    $('#emp_id').val('');
    $('#emp_selected_badge').hide();
    $('#emp_search_box').show();
    $('#emp_search_input').val('');
    $('#emp_dropdown_results').hide().empty();

    var today = new Date().toISOString().split('T')[0];
    $('#start_date').val(today);
    $('#end_date').val(today);
    $('#purpose').val('');
    $('#location').val('');
    $('#remarks').val('');
    $('#conflict_alert_box').hide();

    updateDaysCount();
}

// =========================================================================
// TAB 3: OD REPORTS AJAX & RENDERING
// =========================================================================
function switchReportType(type) {
    activeReportType = type;
    $('.report-subtab-btn').removeClass('active');
    $('#btn_rpt_' + type).addClass('active');

    renderReportFilterControls();
    fetchReportData();
}

function renderReportFilterControls() {
    var html = '';
    var unitOptions = '<?= !empty($units) ? addslashes(implode('', array_map(function($u){ return "<option value='{$u->unit_id}'>".htmlspecialchars($u->unit_name)."</option>"; }, $units))) : "" ?>';
    var deptOptions = '<?= !empty($departments) ? addslashes(implode('', array_map(function($d){ return "<option value='{$d->dept_id}'>".htmlspecialchars($d->dept_name)."</option>"; }, $departments))) : "" ?>';

    if (activeReportType === 'daily') {
        html += '<div class="filter-group"><label>Report Date</label><input type="date" class="filter-input" id="rpt_date" value="<?= date('Y-m-d') ?>"></div>';
        <?php if (empty($unit_id) || $unit_id === 'All'): ?>
        html += '<div class="filter-group"><label>Branch / Unit</label><select class="filter-input" id="rpt_unit"><option value="">-- All Units --</option>' + unitOptions + '</select></div>';
        <?php endif; ?>
        html += '<div class="filter-group"><label>Department</label><select class="filter-input" id="rpt_dept"><option value="">-- All Departments --</option>' + deptOptions + '</select></div>';
    } else if (activeReportType === 'monthly') {
        html += '<div class="filter-group"><label>Report Month</label><input type="month" class="filter-input" id="rpt_month" value="<?= date('Y-m') ?>"></div>';
        <?php if (empty($unit_id) || $unit_id === 'All'): ?>
        html += '<div class="filter-group"><label>Branch / Unit</label><select class="filter-input" id="rpt_unit"><option value="">-- All Units --</option>' + unitOptions + '</select></div>';
        <?php endif; ?>
        html += '<div class="filter-group"><label>Department</label><select class="filter-input" id="rpt_dept"><option value="">-- All Departments --</option>' + deptOptions + '</select></div>';
    } else if (activeReportType === 'employee') {
        html += '<div class="filter-group"><label>Employee ID <span style="color:#ef4444;">*</span></label><input type="text" class="filter-input" id="rpt_emp_id" placeholder="Enter Emp ID (e.g. 2001)"></div>';
        html += '<div class="filter-group"><label>From Date</label><input type="date" class="filter-input" id="rpt_from_date"></div>';
        html += '<div class="filter-group"><label>To Date</label><input type="date" class="filter-input" id="rpt_to_date"></div>';
    } else {
        html += '<div class="filter-group"><label>From Date</label><input type="date" class="filter-input" id="rpt_from_date" value="<?= date('Y-m-01') ?>"></div>';
        html += '<div class="filter-group"><label>To Date</label><input type="date" class="filter-input" id="rpt_to_date" value="<?= date('Y-m-t') ?>"></div>';
    }

    html += '<div class="filter-group"><button type="button" class="btn-filter-apply" onclick="fetchReportData()"><i class="fa fa-filter"></i> Generate Report</button></div>';

    $('#rpt_filter_container').html(html);
}

function getReportFilterParams() {
    return {
        report_type: activeReportType,
        date: $('#rpt_date').val() || '',
        month: $('#rpt_month').val() || '',
        emp_id: $('#rpt_emp_id').val() || '',
        from_date: $('#rpt_from_date').val() || '',
        to_date: $('#rpt_to_date').val() || '',
        unit_id: $('#rpt_unit').val() || '',
        dept_id: $('#rpt_dept').val() || ''
    };
}

function fetchReportData() {
    var params = getReportFilterParams();
    $('#reportTableBody').html('<tr><td colspan="10" style="text-align:center; padding:30px; color:#64748b;"><i class="fa fa-spinner fa-spin"></i> Generating report...</td></tr>');

    $.ajax({
        url: '<?= base_url("od_management_con/report_data_ajax") ?>',
        type: 'POST',
        data: params,
        dataType: 'json',
        success: function(res) {
            if (res && res.status === 'success') {
                renderReportTable(res.data);
            } else {
                $('#reportTableBody').html('<tr><td colspan="10" style="text-align:center; padding:30px; color:#ef4444;"><i class="fa fa-exclamation-circle"></i> ' + (res.message || 'Unable to retrieve report data.') + '</td></tr>');
            }
        },
        error: function() {
            $('#reportTableBody').html('<tr><td colspan="10" style="text-align:center; padding:30px; color:#ef4444;"><i class="fa fa-exclamation-triangle"></i> Failed to load report data.</td></tr>');
        }
    });
}

function renderReportTable(data) {
    data = data || [];
    $('#lbl_report_total').text(data.length);

    if (activeReportType === 'daily') {
        $('#reportTableHead').html('<tr><th style="width:45px;">SL</th><th>Date</th><th style="width:90px;">Emp ID</th><th>Employee Name</th><th>Department</th><th>Designation</th><th>Purpose</th><th>Location</th><th>Time</th><th style="text-align:center;">Status</th></tr>');
        if (data.length === 0) {
            $('#reportTableBody').html('<tr><td colspan="10" style="text-align:center; padding:30px; color:#64748b;">No employees on Outside Duty for selected date.</td></tr>');
            return;
        }
        var html = '';
        var sl = 1;
        data.forEach(function(r) {
            html += '<tr>' +
                    '<td>' + (sl++) + '</td>' +
                    '<td><strong>' + (r.od_date || '') + '</strong></td>' +
                    '<td><span style="font-weight:700; color:#0284c7;">' + (r.emp_id || '') + '</span></td>' +
                    '<td><span style="font-weight:600;">' + (r.name_en || '-') + '</span></td>' +
                    '<td>' + (r.dept_name || '-') + '</td>' +
                    '<td>' + (r.desig_name || '-') + '</td>' +
                    '<td>' + (r.purpose || '-') + '</td>' +
                    '<td>' + (r.location ? '<i class="fa fa-map-marker" style="color:#ef4444;"></i> ' + r.location : '-') + '</td>' +
                    '<td>' + (r.departure_time ? r.departure_time + ' - ' + (r.return_time || '-') : 'Full Day') + '</td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#e0f2fe; color:#0369a1; font-weight:700;">OD</span></td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeReportType === 'monthly') {
        $('#reportTableHead').html('<tr><th style="width:45px;">SL</th><th style="width:90px;">Emp ID</th><th>Employee Name</th><th>Department</th><th>Designation</th><th style="text-align:center;">Total OD Days</th><th>Assigned Dates</th></tr>');
        if (data.length === 0) {
            $('#reportTableBody').html('<tr><td colspan="7" style="text-align:center; padding:30px; color:#64748b;">No Outside Duty records found for selected month.</td></tr>');
            return;
        }
        var html = '';
        var sl = 1;
        data.forEach(function(r) {
            html += '<tr>' +
                    '<td>' + (sl++) + '</td>' +
                    '<td><span style="font-weight:700; color:#0284c7;">' + (r.emp_id || '') + '</span></td>' +
                    '<td><span style="font-weight:600;">' + (r.name_en || '-') + '</span></td>' +
                    '<td>' + (r.dept_name || '-') + '</td>' +
                    '<td>' + (r.desig_name || '-') + '</td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#dcfce7; color:#15803d; font-size:13px; font-weight:700;">' + (r.total_od_days || 0) + ' Days</span></td>' +
                    '<td><small style="color:#475569;">' + (r.od_dates || '-') + '</small></td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeReportType === 'employee') {
        $('#reportTableHead').html('<tr><th style="width:45px;">SL</th><th>OD Date</th><th style="width:90px;">Emp ID</th><th>Employee Name</th><th>Purpose</th><th>Location</th><th>Status</th><th>Departure / Return</th></tr>');
        if (data.length === 0) {
            $('#reportTableBody').html('<tr><td colspan="8" style="text-align:center; padding:30px; color:#64748b;">No Outside Duty history found for this employee.</td></tr>');
            return;
        }
        var html = '';
        var sl = 1;
        data.forEach(function(r) {
            html += '<tr>' +
                    '<td>' + (sl++) + '</td>' +
                    '<td><strong>' + (r.od_date || '') + '</strong></td>' +
                    '<td>' + (r.emp_id || '') + '</td>' +
                    '<td>' + (r.name_en || '-') + '</td>' +
                    '<td>' + (r.purpose || '-') + '</td>' +
                    '<td>' + (r.location || '-') + '</td>' +
                    '<td><span class="badge" style="background:#e0f2fe; color:#0369a1;">' + (r.date_status || 'approved') + '</span></td>' +
                    '<td>' + (r.departure_time ? (r.departure_time + ' / ' + (r.return_time || '-')) : 'Full Day') + '</td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeReportType === 'department') {
        $('#reportTableHead').html('<tr><th style="width:45px;">SL</th><th>Department Name</th><th style="text-align:center;">Total OD Days</th><th style="text-align:center;">Total Employees Count</th></tr>');
        if (data.length === 0) {
            $('#reportTableBody').html('<tr><td colspan="4" style="text-align:center; padding:30px; color:#64748b;">No department records.</td></tr>');
            return;
        }
        var html = '';
        var sl = 1;
        data.forEach(function(r) {
            html += '<tr>' +
                    '<td>' + (sl++) + '</td>' +
                    '<td><span style="font-weight:600;">' + (r.dept_name || '-') + '</span></td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#dcfce7; color:#15803d; font-weight:700;">' + (r.total_days || 0) + ' Days</span></td>' +
                    '<td style="text-align:center;">' + (r.employee_count || 0) + '</td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    }
}

// =========================================================================
// MODAL ACTIONS: VIEW, APPROVE, REJECT, CANCEL, EXPORT
// =========================================================================
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
                           '<div class="detail-item" style="grid-column:span 2;"><div class="lbl">Outside Duty Location</div><div class="val"><i class="fa fa-map-marker" style="color:#ef4444;"></i> ' + (d.location || 'Not specified') + '</div></div>' +
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
        text: 'This will approve the OD assignment and mark the employee attendance status as "OD" for all assigned dates.',
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
                    if (res && res.status === 'success') {
                        Swal.fire({ icon: 'success', title: 'Approved!', text: res.message, timer: 1500, showConfirmButton: false });
                        refreshHubStats();
                        loadOdList(currentPage);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Failed', text: res.message || 'Could not approve.' });
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
    var reason = $.trim($('#reject_reason_text').val());
    if (!reason) {
        Swal.fire({ icon: 'warning', title: 'Required', text: 'Please enter a rejection reason.' });
        return;
    }
    $.ajax({
        url: '<?= base_url("od_management_con/reject_ajax") ?>',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(res) {
            $('#modalRejectOd').modal('hide');
            if (res && res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Rejected', text: res.message, timer: 1500, showConfirmButton: false });
                refreshHubStats();
                loadOdList(currentPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Failed', text: res.message || 'Could not reject.' });
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
    var reason = $.trim($('#cancel_reason_text').val());
    $.ajax({
        url: '<?= base_url("od_management_con/cancel_ajax") ?>',
        type: 'POST',
        data: { id: id, reason: reason },
        dataType: 'json',
        success: function(res) {
            $('#modalCancelOd').modal('hide');
            if (res && res.status === 'success') {
                Swal.fire({ icon: 'success', title: 'Cancelled', text: res.message, timer: 1500, showConfirmButton: false });
                refreshHubStats();
                loadOdList(currentPage);
            } else {
                Swal.fire({ icon: 'error', title: 'Failed', text: res.message || 'Could not cancel.' });
            }
        }
    });
}

function exportData(format) {
    var params;
    if (currentTab === 'reports') {
        params = getReportFilterParams();
        params.type = activeReportType;
    } else {
        params = getFilters();
        params.type = 'list';
    }
    var q = $.param(params);

    if (format === 'csv') {
        window.location.href = '<?= base_url("od_management_con/export_excel") ?>?' + q;
    } else {
        window.open('<?= base_url("od_management_con/export_pdf") ?>?' + q, '_blank');
    }
}
</script>
