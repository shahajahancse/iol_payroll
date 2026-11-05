<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit_init  = isset($is_edit) && $is_edit && !empty($arrear);
$init_arr_id   = $is_edit_init ? $arrear->id : 0;
$init_emp_id   = $is_edit_init ? $arrear->emp_id : '';
$init_pay_mon  = $is_edit_init ? date('Y-m', strtotime($arrear->payment_month)) : date('Y-m');
$init_amount   = $is_edit_init ? (float)$arrear->amount : '';
$init_remarks  = $is_edit_init ? $arrear->remarks : '';
$init_status   = $is_edit_init ? $arrear->status : 'Approved';
$current_tab   = isset($active_tab) && in_array($active_tab, array('list', 'entry')) ? $active_tab : 'list';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Arrear Salary Module - Unified Single-Page Management Hub */
body,
.page-container,
.page-content,
.arr-wrapper,
.page-content .arr-wrapper,
.page-content .content.arr-wrapper {
    background: #ffffff !important;
    background-color: #ffffff !important;
}

.arr-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 50px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    min-height: calc(100vh - 100px);
}

/* Header Card */
.arr-header-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 22px;
    margin-bottom: 18px;
    box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 14px;
}
.arr-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.arr-header-icon {
    width: 46px;
    height: 46px;
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
.arr-header-text h2 {
    margin: 0 0 3px 0;
    font-size: 19px;
    font-weight: 700;
    color: #0f172a;
}
.arr-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 12.5px;
}

/* Stat KPI Grid */
.arr-stat-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 10px;
    margin-bottom: 18px;
}
@media (max-width: 992px) {
    .arr-stat-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 576px) {
    .arr-stat-grid { grid-template-columns: repeat(2, 1fr); }
}
.arr-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 12px 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 2px 6px rgba(15, 23, 42, 0.02);
    min-width: 0;
    transition: transform 0.15s, box-shadow 0.15s;
}
.arr-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
}
.arr-stat-icon {
    width: 38px;
    height: 38px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.arr-stat-info {
    min-width: 0;
    overflow: hidden;
}
.arr-stat-info h4 {
    margin: 0 0 2px 0;
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.arr-stat-info p {
    margin: 0;
    font-size: 10.5px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Hub Navigation Tabs */
.hub-nav-tabs {
    display: flex;
    gap: 8px;
    margin-bottom: 18px;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 0;
    overflow-x: auto;
}
.hub-tab-btn {
    padding: 11px 20px;
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

/* Filter Card */
.arr-filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 18px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
}
.arr-filter-row {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    width: 100%;
    flex-wrap: wrap;
}
.arr-filter-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
    min-width: 130px;
}
.arr-filter-group.filter-actions {
    flex: 0 0 auto;
    flex-direction: row;
    gap: 6px;
}
.arr-filter-group label {
    font-size: 10.5px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
}
.arr-filter-group .form-control {
    height: 36px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 12.5px;
    padding: 6px 10px;
}

/* Table Card */
.arr-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
    overflow: hidden;
    margin-bottom: 24px;
}
.arr-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafbfc;
    flex-wrap: wrap;
    gap: 10px;
}
.arr-card-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.table-arr-head th {
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px !important;
    border-bottom: 2px solid #e2e8f0 !important;
    white-space: nowrap;
}
.table-arr-body td {
    padding: 12px 14px !important;
    vertical-align: middle !important;
    font-size: 13px;
    border-bottom: 1px solid #f1f5f9;
}
.table-arr-body tr:hover td {
    background-color: #f8fafc;
}

/* Badges */
.badge-arr-status {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    white-space: nowrap;
}
.status-approved { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; }
.status-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.status-paid { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.status-cancelled { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }

.emp-badge {
    font-weight: 700;
    color: #0284c7;
    background: #f0f9ff;
    padding: 2px 6px;
    border-radius: 4px;
    border: 1px solid #e0f2fe;
    font-family: monospace;
    font-size: 12px;
}

/* Action Buttons */
.btn-arr-action {
    height: 28px;
    padding: 2px 8px;
    border-radius: 5px;
    font-size: 11.5px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.15s;
}
.btn-arr-edit { background: #f0f9ff; color: #0284c7; border-color: #bae6fd; }
.btn-arr-edit:hover { background: #0284c7; color: #ffffff; }
.btn-arr-approve { background: #ecfdf5; color: #059669; border-color: #a7f3d0; }
.btn-arr-approve:hover { background: #059669; color: #ffffff; }
.btn-arr-delete { background: #fff1f2; color: #e11d48; border-color: #fecdd3; }
.btn-arr-delete:hover { background: #e11d48; color: #ffffff; }

/* ========================================================================= */
/* TAB 2: ARREAR ENTRY FORM STYLES                                            */
/* ========================================================================= */
.arr-form-card {
    max-width: 780px;
    margin: 0 auto;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
    overflow: hidden;
    padding: 26px 30px;
    margin-bottom: 30px;
}
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
    cursor: pointer;
    transition: all 0.15s;
}
.btn-back-link:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}

/* Form Groups */
.form-group-item {
    margin-bottom: 20px;
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
    height: 42px;
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

<div class="content arr-wrapper">
    <!-- Top Header Card -->
    <div class="arr-header-card">
        <div class="arr-header-left">
            <div class="arr-header-icon">
                <i class="fa fa-money"></i>
            </div>
            <div class="arr-header-text">
                <h2>Arrear Salary Management</h2>
                <p>Record employee arrear bills, specify pay month, amount, and month details for payroll</p>
            </div>
        </div>
        <div style="display:flex; align-items:center; gap:8px;">
            <button type="button" class="btn btn-primary" onclick="openCreateMode()" style="height:36px; padding:6px 16px; border-radius:6px; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa fa-plus-circle"></i> Add Arrear Salary
            </button>
            <button type="button" class="btn btn-default" onclick="refreshArrearHub()" style="height:36px; padding:6px 12px; border-radius:6px; font-size:13px; display:inline-flex; align-items:center; gap:5px;" title="Refresh page">
                <i class="fa fa-refresh" id="hub_refresh_icon"></i>
            </button>
        </div>
    </div>

    <!-- KPI Summary Grid -->
    <div class="arr-stat-grid">
        <div class="arr-stat-card">
            <div class="arr-stat-icon" style="background:#e0f2fe; color:#0284c7;">
                <i class="fa fa-list-alt"></i>
            </div>
            <div class="arr-stat-info">
                <h4><?= number_format($stats->total_count) ?></h4>
                <p>Total Records</p>
            </div>
        </div>
        <div class="arr-stat-card">
            <div class="arr-stat-icon" style="background:#f0fdf4; color:#16a34a;">
                <i class="fa fa-money"></i>
            </div>
            <div class="arr-stat-info">
                <h4>৳<?= number_format($stats->total_amount, 2) ?></h4>
                <p>Total Arrear Amt</p>
            </div>
        </div>
        <div class="arr-stat-card">
            <div class="arr-stat-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="arr-stat-info">
                <h4>৳<?= number_format($stats->approved_amount, 2) ?></h4>
                <p>Approved (<?= $stats->approved_count ?>)</p>
            </div>
        </div>
        <div class="arr-stat-card">
            <div class="arr-stat-icon" style="background:#fffbeb; color:#d97706;">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="arr-stat-info">
                <h4>৳<?= number_format($stats->pending_amount, 2) ?></h4>
                <p>Pending (<?= $stats->pending_count ?>)</p>
            </div>
        </div>
        <div class="arr-stat-card">
            <div class="arr-stat-icon" style="background:#ecfdf5; color:#059669;">
                <i class="fa fa-bank"></i>
            </div>
            <div class="arr-stat-info">
                <h4>৳<?= number_format($stats->paid_amount, 2) ?></h4>
                <p>Paid in Payroll (<?= $stats->paid_count ?>)</p>
            </div>
        </div>
    </div>

    <!-- Hub Navigation Tabs -->
    <div class="hub-nav-tabs">
        <button type="button" class="hub-tab-btn <?= $current_tab === 'list' ? 'active' : '' ?>" id="tab_btn_list" onclick="switchArrearTab('list')">
            <i class="fa fa-list-alt"></i> Arrear Salary List
            <span class="hub-tab-badge" id="badge_total_count"><?= number_format($total_rows) ?></span>
        </button>
        <button type="button" class="hub-tab-btn <?= $current_tab === 'entry' ? 'active' : '' ?>" id="tab_btn_entry" onclick="switchArrearTab('entry')">
            <i class="fa fa-plus-circle"></i> <span id="lbl_entry_tab_title"><?= $is_edit_init ? 'Edit Arrear Salary #' . $init_arr_id : 'Add Arrear Salary' ?></span>
        </button>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 1: ARREAR SALARY LIST                                             -->
    <!-- ===================================================================== -->
    <div class="hub-tab-panel <?= $current_tab === 'list' ? 'active' : '' ?>" id="panel_list">
        <!-- Filters Card -->
        <div class="arr-filter-card">
            <form method="get" action="<?= base_url('arrear_salary') ?>" class="arr-filter-row">
                <input type="hidden" name="tab" value="list">
                <div class="arr-filter-group" style="flex:1.5;">
                    <label>Search Employee</label>
                    <input type="text" name="search" class="form-control" placeholder="ID or Name..." value="<?= htmlspecialchars($filters['search']) ?>">
                </div>

                <div class="arr-filter-group">
                    <label>Pay Month</label>
                    <input type="month" name="payment_month" class="form-control" value="<?= !empty($filters['payment_month']) ? date('Y-m', strtotime($filters['payment_month'])) : '' ?>">
                </div>

                <div class="arr-filter-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="">All Statuses</option>
                        <option value="Approved" <?= ($filters['status'] === 'Approved') ? 'selected' : '' ?>>Approved</option>
                        <option value="Pending" <?= ($filters['status'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                        <option value="Paid" <?= ($filters['status'] === 'Paid') ? 'selected' : '' ?>>Paid in Payroll</option>
                        <option value="Cancelled" <?= ($filters['status'] === 'Cancelled') ? 'selected' : '' ?>>Cancelled</option>
                    </select>
                </div>

                <div class="arr-filter-group">
                    <label>Unit</label>
                    <select name="unit_id" class="form-control">
                        <option value="">All Units</option>
                        <?php if (!empty($units)) { foreach ($units as $u) { ?>
                            <option value="<?= $u->unit_id ?>" <?= ($filters['unit_id'] == $u->unit_id) ? 'selected' : '' ?>><?= $u->unit_name ?></option>
                        <?php }} ?>
                    </select>
                </div>

                <div class="arr-filter-group filter-actions">
                    <button type="submit" class="btn btn-primary" style="height:36px; padding:6px 14px; border-radius:6px; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:5px;">
                        <i class="fa fa-filter"></i> Filter
                    </button>
                    <a href="<?= base_url('arrear_salary') ?>" class="btn btn-default" style="height:36px; padding:6px 12px; border-radius:6px; font-size:13px; display:inline-flex; align-items:center;" title="Reset Filter">
                        <i class="fa fa-refresh"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Data Table Card -->
        <div class="arr-card">
            <div class="arr-card-header">
                <h3><i class="fa fa-table text-primary"></i> Arrear Records List</h3>
                <span style="font-size:12px; color:#64748b; font-weight:600;">Showing <?= count($arrears) ?> of <?= $total_rows ?> entries</span>
            </div>
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead class="table-arr-head">
                        <tr>
                            <th style="width:50px;">SL</th>
                            <th>Employee</th>
                            <th>Department & Desig</th>
                            <th>Pay Month</th>
                            <th style="text-align:right;">Arrear Amount</th>
                            <th>Remarks (Month Details)</th>
                            <th>Created Info</th>
                            <th style="text-align:center;">Status</th>
                            <th style="text-align:center; width:130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-arr-body">
                        <?php if (!empty($arrears)) { 
                            $sl = 1 + (isset($_GET['page']) ? (((int)$_GET['page'] - 1) * 50) : 0);
                            foreach ($arrears as $row) { 
                                $is_paid = ($row->status === 'Paid');
                        ?>
                            <tr>
                                <td style="font-weight:600; color:#64748b;"><?= $sl++ ?></td>
                                <td>
                                    <div>
                                        <span class="emp-badge"><?= $row->emp_id ?></span> 
                                        <strong style="color:#0f172a; margin-left:4px;"><?= htmlspecialchars($row->name_en) ?></strong>
                                    </div>
                                    <?php if (!empty($row->unit_name)) { ?>
                                        <small style="color:#64748b;"><?= htmlspecialchars($row->unit_name) ?></small>
                                    <?php } ?>
                                </td>
                                <td style="color:#475569;">
                                    <strong><?= htmlspecialchars($row->dept_name ?: 'N/A') ?></strong>
                                    <br><small style="color:#64748b;"><?= htmlspecialchars($row->desig_name ?: '-') ?></small>
                                </td>
                                <td>
                                    <span style="font-weight:700; color:#0284c7; background:#f0f9ff; padding:3px 8px; border-radius:4px; border:1px solid #bae6fd;">
                                        <?= date('F Y', strtotime($row->payment_month)) ?>
                                    </span>
                                </td>
                                <td style="text-align:right;">
                                    <strong style="font-size:14px; color:#0f172a;">৳<?= number_format($row->amount, 2) ?></strong>
                                </td>
                                <td style="max-width:250px;">
                                    <div style="color:#334155; font-size:12.5px; word-break:break-word; font-weight:500;">
                                        <?= !empty($row->remarks) ? htmlspecialchars($row->remarks) : '<span style="color:#94a3b8;">-</span>' ?>
                                    </div>
                                </td>
                                <td>
                                    <small style="color:#64748b; display:block;">By: <?= htmlspecialchars($row->created_by ?: 'System') ?></small>
                                    <small style="color:#94a3b8; font-size:11px;"><?= date('d M Y, h:i A', strtotime($row->created_at)) ?></small>
                                </td>
                                <td style="text-align:center;">
                                    <?php if ($row->status === 'Approved') { ?>
                                        <span class="badge-arr-status status-approved"><i class="fa fa-check"></i> Approved</span>
                                    <?php } elseif ($row->status === 'Paid') { ?>
                                        <span class="badge-arr-status status-paid"><i class="fa fa-check-circle"></i> Paid in Payroll</span>
                                    <?php } elseif ($row->status === 'Pending') { ?>
                                        <span class="badge-arr-status status-pending"><i class="fa fa-clock-o"></i> Pending</span>
                                    <?php } else { ?>
                                        <span class="badge-arr-status status-cancelled"><i class="fa fa-ban"></i> Cancelled</span>
                                    <?php } ?>
                                </td>
                                <td style="text-align:center; white-space:nowrap;">
                                    <?php if (!$is_paid) { ?>
                                        <button type="button" class="btn-arr-action btn-arr-edit" onclick="startEditArrear(<?= $row->id ?>)" title="Edit Arrear">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <?php if ($row->status === 'Pending') { ?>
                                            <button type="button" class="btn-arr-action btn-arr-approve" onclick="approveArrear(<?= $row->id ?>)" title="Approve Arrear">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        <?php } ?>
                                        <button type="button" class="btn-arr-action btn-arr-delete" onclick="deleteArrear(<?= $row->id ?>)" title="Delete Arrear">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    <?php } else { ?>
                                        <span style="font-size:11.5px; color:#10b981; font-weight:600;"><i class="fa fa-lock"></i> Finalized</span>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }} else { ?>
                            <tr>
                                <td colspan="9" style="text-align:center; padding:45px 20px; color:#94a3b8;">
                                    <i class="fa fa-folder-open-o" style="font-size:36px; color:#cbd5e1; margin-bottom:10px; display:block;"></i>
                                    <strong style="font-size:14px; color:#475569;">No arrear salary records found.</strong>
                                    <p style="font-size:12px; margin-top:4px;">Click "Add Arrear Salary" above to create an arrear adjustment.</p>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($pagination)) { ?>
                <div style="padding:14px 20px; background:#fafbfc; border-top:1px solid #f1f5f9; display:flex; justify-content:flex-end;">
                    <?= $pagination ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- ===================================================================== -->
    <!-- TAB 2: ADD / EDIT ARREAR SALARY ENTRY FORM                            -->
    <!-- ===================================================================== -->
    <div class="hub-tab-panel <?= $current_tab === 'entry' ? 'active' : '' ?>" id="panel_entry">
        <div class="arr-form-card">
            <!-- Form Header -->
            <div class="arr-form-header">
                <div class="arr-header-title-box">
                    <div class="arr-icon-badge">
                        <i class="fa fa-money"></i>
                    </div>
                    <div class="arr-header-text">
                        <h2 id="form_header_title"><?= $is_edit_init ? 'Edit Arrear Salary <span style="color:#0284c7;">#' . $init_arr_id . '</span>' : 'Add Arrear Salary Entry' ?></h2>
                        <p id="form_header_subtitle">Select employee, choose pay month, enter amount, and mention month details in remarks</p>
                    </div>
                </div>
                <div>
                    <button type="button" onclick="cancelEditMode()" class="btn-back-link">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </button>
                </div>
            </div>

            <!-- Form Body: Only Employee, Pay Month, Amount, Remarks -->
            <form id="arrearForm" autocomplete="off">
                <input type="hidden" name="id" id="form_arrear_id" value="<?= $init_arr_id ?>">
                <input type="hidden" name="emp_id" id="form_emp_id" value="<?= htmlspecialchars($init_emp_id) ?>">
                <input type="hidden" name="status" id="form_status" value="<?= htmlspecialchars($init_status) ?>">

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
                        <button type="button" class="btn-change-emp" id="btn_change_employee">
                            <i class="fa fa-refresh"></i> Change
                        </button>
                    </div>
                </div>

                <!-- 2. Pay Month & Arrear Amount -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-item">
                            <label class="form-group-label">
                                <span>Pay Month (Add To Payroll) <span class="req">*</span></span>
                            </label>
                            <input type="month" name="payment_month" id="form_payment_month" class="input-custom" value="<?= $init_pay_mon ?>" required>
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
                                <input type="number" step="0.01" min="0.01" name="amount" id="form_amount" class="input-custom" style="padding-left:30px !important; font-weight:700; font-size:15px;" placeholder="0.00" value="<?= $init_amount ?>" required>
                            </div>
                            <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                                Must be a positive monetary amount.
                            </small>
                        </div>
                    </div>
                </div>

                <!-- 3. Remarks (Mention which month/months the arrear bill is for) -->
                <div class="form-group-item">
                    <label class="form-group-label">
                        <span>Remarks (For which month/months) <span class="req">*</span></span>
                    </label>
                    <textarea name="remarks" id="form_remarks" rows="3" class="textarea-custom" placeholder="e.g. Arrear bill for January 2026 & February 2026 salary adjustment..." required><?= htmlspecialchars($init_remarks) ?></textarea>
                    <small style="font-size:11.5px; color:#64748b; margin-top:4px; display:block;">
                        Write which month or months this arrear bill is for, or any other notes.
                    </small>
                </div>

                <!-- Action Buttons -->
                <div class="form-action-bar">
                    <button type="button" onclick="cancelEditMode()" class="btn-back-link">
                        Cancel
                    </button>
                    <button type="submit" class="btn-save-arr" id="btn_submit_arrear">
                        <i class="fa fa-check-circle"></i> <span id="btn_submit_text"><?= $is_edit_init ? 'Update Arrear' : 'Save Arrear Salary' ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
var currentTab = '<?= $current_tab ?>';

// Tab switching
function switchArrearTab(tabName) {
    currentTab = tabName;
    $('.hub-tab-btn').removeClass('active');
    $('.hub-tab-panel').removeClass('active');

    $('#tab_btn_' + tabName).addClass('active');
    $('#panel_' + tabName).addClass('active');

    // Update browser URL state without page reload
    if (history.replaceState) {
        var newUrl = '<?= base_url("arrear_salary") ?>';
        if (tabName === 'entry') {
            var arrId = parseInt($('#form_arrear_id').val(), 10);
            newUrl += (arrId > 0) ? '?tab=entry&edit_id=' + arrId : '?tab=entry';
        }
        history.replaceState(null, '', newUrl);
    }
}

// Open Form in Add New Mode
function openCreateMode() {
    $('#form_arrear_id').val('0');
    $('#form_emp_id').val('');
    $('#form_amount').val('');
    $('#form_remarks').val('');
    $('#form_status').val('Approved');

    var d = new Date();
    var curYear = d.getFullYear();
    var curMonth = String(d.getMonth() + 1).padStart(2, '0');
    var payMonth = curYear + '-' + curMonth;

    $('#form_payment_month').val(payMonth);

    // Reset employee selection box
    $('#emp_selected_badge').hide();
    $('#emp_search_box').show();
    $('#emp_search_input').val('');
    $('#emp_dropdown_results').hide().empty();

    // Reset titles
    $('#form_header_title').text('Add Arrear Salary Entry');
    $('#form_header_subtitle').text('Select employee, choose pay month, enter amount, and mention month details in remarks');
    $('#lbl_entry_tab_title').text('Add Arrear Salary');
    $('#btn_submit_text').text('Save Arrear Salary');

    switchArrearTab('entry');
    setTimeout(function() {
        $('#emp_search_input').focus();
    }, 150);
}

// Start Edit Mode for an Arrear Record
function startEditArrear(id) {
    id = parseInt(id, 10);
    if (!id) return;

    Swal.fire({
        title: 'Loading Record...',
        text: 'Please wait while fetching arrear details',
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: '<?= base_url("arrear_salary/get_arrear_ajax/") ?>' + id,
        type: 'GET',
        dataType: 'json',
        success: function(resp) {
            Swal.close();
            if (resp.status && resp.data) {
                var row = resp.data;
                var emp = resp.employee;

                $('#form_arrear_id').val(row.id);
                $('#form_emp_id').val(row.emp_id);
                $('#form_payment_month').val(resp.payment_month_val);
                $('#form_amount').val(parseFloat(row.amount).toFixed(2));
                $('#form_status').val(row.status || 'Approved');
                $('#form_remarks').val(row.remarks || '');

                if (emp) {
                    var initials = (emp.name_en || 'EM').substring(0, 2).toUpperCase();
                    $('#prev_avatar').text(initials);
                    $('#prev_emp_title').text(emp.emp_id + ' - ' + emp.name_en);
                    var sub = (emp.desig_name || '-') + ' | ' + (emp.dept_name || '-') + ' (' + (emp.unit_name || '-') + ')';
                    $('#prev_emp_sub').text(sub);
                    $('#emp_search_box').hide();
                    $('#emp_selected_badge').show();
                }

                $('#form_header_title').html('Edit Arrear Salary <span style="color:#0284c7;">#' + row.id + '</span>');
                $('#form_header_subtitle').text('Editing arrear record for ' + (emp ? (emp.emp_id + ' - ' + emp.name_en) : row.emp_id));
                $('#lbl_entry_tab_title').text('Edit Arrear #' + row.id);
                $('#btn_submit_text').text('Update Arrear');

                switchArrearTab('entry');
                $('html, body').animate({ scrollTop: $('#tab_btn_entry').offset().top - 80 }, 300);
            } else {
                Swal.fire('Error', resp.message || 'Could not load arrear record.', 'error');
            }
        },
        error: function() {
            Swal.close();
            Swal.fire('Error', 'Server error while fetching arrear record.', 'error');
        }
    });
}

// Cancel Edit Mode and return to List
function cancelEditMode() {
    $('#form_arrear_id').val('0');
    $('#lbl_entry_tab_title').text('Add Arrear Salary');
    switchArrearTab('list');
}

// Refresh Page
function refreshArrearHub() {
    var $icon = $('#hub_refresh_icon');
    $icon.addClass('fa-spin');
    location.reload();
}

// Delete Arrear Record
function deleteArrear(id) {
    Swal.fire({
        title: 'Delete Arrear Record?',
        text: 'Are you sure you want to delete this arrear record?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("arrear_salary/delete/") ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(resp) {
                    if (resp.status) {
                        Swal.fire({
                            title: 'Deleted!',
                            text: resp.message,
                            icon: 'success',
                            timer: 1400,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', resp.message || 'Failed to delete record.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Server error occurred while deleting.', 'error');
                }
            });
        }
    });
}

// Approve Arrear Record
function approveArrear(id) {
    Swal.fire({
        title: 'Approve Arrear Record?',
        text: 'This arrear will be approved and included in the selected payment month payroll calculation.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, approve!'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url("arrear_salary/approve/") ?>' + id,
                type: 'POST',
                dataType: 'json',
                success: function(resp) {
                    if (resp.status) {
                        Swal.fire({
                            title: 'Approved!',
                            text: resp.message,
                            icon: 'success',
                            timer: 1400,
                            showConfirmButton: false
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', resp.message || 'Failed to approve record.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Server error occurred while approving.', 'error');
                }
            });
        }
    });
}

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
        $('#form_emp_id').val(emp.emp_id);
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
        $('#form_emp_id').val('');
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

        var empId = $('#form_emp_id').val().trim();
        if (!empId) {
            Swal.fire('Required Field', 'Please select an employee.', 'warning');
            return;
        }

        var payMonth = $('#form_payment_month').val().trim();
        if (!payMonth) {
            Swal.fire('Required Field', 'Please select pay month.', 'warning');
            return;
        }

        var amount = parseFloat($('#form_amount').val());
        if (isNaN(amount) || amount <= 0) {
            Swal.fire('Invalid Amount', 'Please enter a valid positive arrear amount.', 'warning');
            return;
        }

        var remarks = $('#form_remarks').val().trim();
        if (!remarks) {
            Swal.fire('Required Field', 'Please write which month/months this arrear bill is for in Remarks.', 'warning');
            $('#form_remarks').focus();
            return;
        }

        var btn = $('#btn_submit_arrear');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        $.ajax({
            url: '<?= base_url("arrear_salary/save") ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(resp) {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> <span id="btn_submit_text">' + ($('#form_arrear_id').val() > 0 ? 'Update Arrear' : 'Save Arrear Salary') + '</span>');
                if (resp.status) {
                    Swal.fire({
                        title: 'Success!',
                        text: resp.message,
                        icon: 'success',
                        timer: 1600,
                        showConfirmButton: false
                    }).then(function() {
                        window.location.href = '<?= base_url("arrear_salary") ?>';
                    });
                } else {
                    Swal.fire('Error', resp.message || 'Failed to save arrear record.', 'error');
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa fa-check-circle"></i> <span id="btn_submit_text">Save Arrear Salary</span>');
                Swal.fire('Error', 'Server error occurred while saving.', 'error');
            }
        });
    });
});
</script>
