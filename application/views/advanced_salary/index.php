<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Advanced Salary Management Module Styles -->
<style>
.adv-container {
    padding: 15px 20px 40px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
}

/* Page Header */
.adv-header-card {
    background: #ffffff;
    border-radius: 8px;
    padding: 16px 22px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.adv-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.adv-header-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    background: linear-gradient(135deg, #006ba3, #0284c7);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
}
.adv-header-text h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
}
.adv-header-text p {
    margin: 2px 0 0 0;
    font-size: 13px;
    color: #64748b;
}

/* Top Summary KPI Cards */
.adv-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
    position: relative;
    overflow: hidden;
}
.adv-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
}
.adv-stat-card.active-filter {
    border-color: #006ba3;
    box-shadow: 0 0 0 2px #006ba3;
}
.adv-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.adv-stat-info {
    flex-grow: 1;
    min-width: 0;
}
.adv-stat-info h3 {
    margin: 0;
    font-size: 19px;
    font-weight: 700;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.adv-stat-info span {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.stat-blue .adv-stat-icon   { background: #e0f2fe; color: #0284c7; }
.stat-green .adv-stat-icon  { background: #dcfce7; color: #16a34a; }
.stat-amber .adv-stat-icon  { background: #fef3c7; color: #d97706; }
.stat-purple .adv-stat-icon { background: #f3e8ff; color: #9333ea; }
.stat-teal .adv-stat-icon   { background: #ccfbf1; color: #0d9488; }

/* Main Card & Tabs */
.adv-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}
.adv-nav-tabs {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 0 16px;
    margin: 0;
    list-style: none;
    display: flex;
    gap: 4px;
}
.adv-nav-tabs > li > a {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 14px 18px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    text-decoration: none;
    border-bottom: 2px solid transparent;
    transition: all 0.15s ease;
}
.adv-nav-tabs > li > a:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.adv-nav-tabs > li.active > a {
    color: #006ba3;
    border-bottom-color: #006ba3;
    background: #ffffff;
    font-weight: 700;
}

/* Filter Toolbar */
.adv-filter-toolbar {
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.adv-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-end;
}
.adv-filter-item {
    flex: 1 1 170px;
    min-width: 150px;
}
.adv-filter-item label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
}
.adv-filter-item .form-control {
    height: 36px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    box-shadow: none;
}
.adv-filter-item .form-control:focus {
    border-color: #006ba3;
    outline: none;
}
.adv-filter-actions {
    display: flex;
    gap: 8px;
    align-items: flex-end;
}

/* Action Buttons */
.btn-adv-primary {
    background: #006ba3;
    color: #ffffff;
    border: 1px solid #005a8a;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    height: 36px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}
.btn-adv-primary:hover {
    background: #005a8a;
    color: #ffffff;
}
.btn-adv-default {
    background: #ffffff;
    color: #475569;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    height: 36px;
    padding: 0 14px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.15s ease;
}
.btn-adv-default:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.btn-adv-success {
    background: #16a34a;
    color: #ffffff;
    border: 1px solid #15803d;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    height: 36px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-adv-success:hover {
    background: #15803d;
    color: #ffffff;
}

/* Data Table */
.adv-table-responsive {
    overflow-x: auto;
    min-height: 250px;
}
.adv-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
    margin: 0;
}
.adv-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    padding: 12px 14px;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
}
.adv-table th.sortable {
    cursor: pointer;
    user-select: none;
}
.adv-table th.sortable:hover {
    background: #f1f5f9;
    color: #006ba3;
}
.adv-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    vertical-align: middle;
}
.adv-table tbody tr:hover {
    background: #f8fafc;
}

/* Status Badges */
.badge-adv {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.badge-adv-approved    { background: #e0f2fe; color: #0369a1; }
.badge-adv-partially   { background: #fef3c7; color: #b45309; }
.badge-adv-completed   { background: #dcfce7; color: #15803d; }
.badge-adv-cancelled   { background: #f1f5f9; color: #64748b; }
.badge-adv-pending     { background: #fff7ed; color: #c2410c; }
.badge-adv-disbursed   { background: #f3e8ff; color: #7e22ce; }

/* Table Action Buttons */
.btn-action-icon {
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
    margin: 0 2px;
    transition: all 0.15s ease;
    cursor: pointer;
}
.btn-action-icon:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.btn-action-icon.btn-view:hover   { background: #e0f2fe; color: #0284c7; border-color: #bae6fd; }
.btn-action-icon.btn-edit:hover   { background: #fef3c7; color: #d97706; border-color: #fde68a; }
.btn-action-icon.btn-cancel:hover { background: #fee2e2; color: #dc2626; border-color: #fecaca; }
.btn-action-icon.btn-delete:hover { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

/* Form Styles */
.adv-form-wrapper {
    padding: 24px;
}
.adv-form-section-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 8px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.adv-form-group {
    margin-bottom: 16px;
}
.adv-form-group label {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 6px;
    display: block;
}
.adv-form-group .form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    box-shadow: none;
}
.adv-form-group .form-control:focus {
    border-color: #006ba3;
}

/* Employee Preview Card */
.emp-preview-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
    margin-top: 10px;
    display: none;
}
.emp-preview-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 12px;
    font-size: 12px;
}
.emp-preview-grid .item-label {
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}
.emp-preview-grid .item-val {
    font-weight: 700;
    color: #0f172a;
}

/* Autocomplete Suggestion Dropdown */
.autocomplete-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    z-index: 1050;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    max-height: 240px;
    overflow-y: auto;
    display: none;
    margin-top: 2px;
}
.autocomplete-item {
    padding: 8px 12px;
    font-size: 13px;
    cursor: pointer;
    border-bottom: 1px solid #f1f5f9;
}
.autocomplete-item:hover {
    background: #f0f9ff;
    color: #0284c7;
}

/* Progress bar in Details Modal */
.adv-progress-container {
    background: #f1f5f9;
    border-radius: 8px;
    height: 12px;
    overflow: hidden;
    margin: 10px 0;
}
.adv-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #16a34a, #0284c7);
    transition: width 0.4s ease;
}

/* Deduction History Table */
.ded-history-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    overflow: hidden;
}
.ded-history-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 700;
    padding: 8px 12px;
    border-bottom: 1px solid #e2e8f0;
}
.ded-history-table td {
    padding: 8px 12px;
    border-bottom: 1px solid #f1f5f9;
}
</style>

<div class="content adv-container">

    <!-- Top Executive Header Card -->
    <div class="adv-header-card">
        <div class="adv-header-left">
            <div class="adv-header-icon">
                <i class="fa fa-money"></i>
            </div>
            <div class="adv-header-text">
                <h2>Advanced Salary Management</h2>
                <p>Track advanced salary disbursements, automatic payroll deductions, and remaining balances</p>
            </div>
        </div>
        <div class="adv-header-actions">
            <button type="button" class="btn btn-adv-default" onclick="refreshAll()" title="Refresh live statistics">
                <i class="fa fa-refresh"></i> Refresh
            </button>
            <button type="button" class="btn btn-adv-primary" onclick="switchToTab('tab_entry')" title="Create New Advance">
                <i class="fa fa-plus-circle"></i> New Advance
            </button>
        </div>
    </div>

    <!-- 5 Real-Time Summary Cards -->
    <div class="row">
        <!-- Card 1: Total Advanced Salary -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="adv-stat-card stat-blue" id="kpi_card_total" onclick="filterByKpi('all')" title="Total Advanced Salary Issued">
                <div class="adv-stat-icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="adv-stat-info">
                    <h3 id="stat_total_advanced">৳ 0.00</h3>
                    <span>Total Advanced</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Deducted -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="adv-stat-card stat-green" id="kpi_card_deducted" onclick="filterByKpi('deducted')" title="Total Deducted Through Payroll">
                <div class="adv-stat-icon">
                    <i class="fa fa-check-circle-o"></i>
                </div>
                <div class="adv-stat-info">
                    <h3 id="stat_total_deducted">৳ 0.00</h3>
                    <span>Total Deducted</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Outstanding Balance -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="adv-stat-card stat-amber" id="kpi_card_outstanding" onclick="filterByKpi('outstanding')" title="Total Outstanding Balance">
                <div class="adv-stat-icon">
                    <i class="fa fa-hourglass-half"></i>
                </div>
                <div class="adv-stat-info">
                    <h3 id="stat_total_outstanding">৳ 0.00</h3>
                    <span>Outstanding Balance</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Active Advances -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="adv-stat-card stat-purple" id="kpi_card_active" onclick="filterByKpi('active')" title="Active / In-Progress Advances">
                <div class="adv-stat-icon">
                    <i class="fa fa-refresh"></i>
                </div>
                <div class="adv-stat-info">
                    <h3 id="stat_active_count">0</h3>
                    <span>Active Advances</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation & Tabs -->
    <div class="adv-main-card">
        <ul class="adv-nav-tabs" role="tablist">
            <li role="presentation" class="active" id="tab_btn_list">
                <a href="#tab_list" aria-controls="tab_list" role="tab" data-toggle="tab" onclick="onTabChanged('list')">
                    <i class="fa fa-list"></i> Advance List & Management
                </a>
            </li>
            <li role="presentation" id="tab_btn_entry">
                <a href="#tab_entry" aria-controls="tab_entry" role="tab" data-toggle="tab" onclick="onTabChanged('entry')">
                    <i class="fa fa-plus-circle"></i> New Advance Entry
                </a>
            </li>
            <li role="presentation" id="tab_btn_report">
                <a href="#tab_report" aria-controls="tab_report" role="tab" data-toggle="tab" onclick="onTabChanged('report')">
                    <i class="fa fa-bar-chart"></i> Reports & Summary
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- ============================================================= -->
            <!-- TAB 1: ADVANCED SALARY LIST & MANAGEMENT -->
            <!-- ============================================================= -->
            <div role="tabpanel" class="tab-pane active" id="tab_list">
                <!-- Filter Bar -->
                <div class="adv-filter-toolbar">
                    <div class="adv-filter-row">
                        <div class="adv-filter-item" style="flex: 2 1 240px;">
                            <label><i class="fa fa-search"></i> Search Employee / Advance ID</label>
                            <input type="text" id="filter_search" class="form-control" placeholder="Search by ID, Name, or Advance ID..." onkeyup="debounceSearch()">
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-building-o"></i> Department</label>
                            <select id="filter_dept" class="form-control" onchange="loadAdvanceList(1)">
                                <option value="">All Departments</option>
                                <?php if (!empty($departments)): foreach ($departments as $d): ?>
                                    <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-calendar"></i> Effective Month</label>
                            <input type="month" id="filter_month" class="form-control" onchange="loadAdvanceList(1)">
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-tag"></i> Status</label>
                            <select id="filter_status" class="form-control" onchange="loadAdvanceList(1)">
                                <option value="all">All Statuses</option>
                                <option value="Approved">Approved</option>
                                <option value="Partially Deducted">Partially Deducted</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="adv-filter-actions">
                            <button type="button" class="btn btn-adv-default" onclick="resetFilters()" title="Reset Filters">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                            <button type="button" class="btn btn-adv-primary" onclick="loadAdvanceList(1)" title="Apply Filters">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Advances DataTable -->
                <div class="adv-table-responsive">
                    <table class="adv-table">
                        <thead>
                            <tr>
                                <th class="sortable" onclick="sortTable('a.advance_id')">Advance ID <i class="fa fa-sort"></i></th>
                                <th class="sortable" onclick="sortTable('a.emp_id')">Employee ID <i class="fa fa-sort"></i></th>
                                <th class="sortable" onclick="sortTable('p.name_en')">Employee Name <i class="fa fa-sort"></i></th>
                                <th>Department</th>
                                <th class="sortable" onclick="sortTable('a.advance_date')">Advance Date <i class="fa fa-sort"></i></th>
                                <th class="sortable text-right" onclick="sortTable('a.advance_amount')">Advance Amount <i class="fa fa-sort"></i></th>
                                <th>Effective Month</th>
                                <th class="text-right">Monthly Deduct</th>
                                <th class="text-right">Total Deducted</th>
                                <th class="text-right">Outstanding</th>
                                <th style="text-align: center;">Status</th>
                                <th style="text-align: center; width: 130px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="adv_table_body">
                            <tr>
                                <td colspan="12" class="text-center" style="padding: 40px; color: #94a3b8;">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading records...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Bar -->
                <div style="padding: 12px 20px; background: #fafbfc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div id="adv_pagination_info" style="font-size: 13px; color: #64748b;">
                        Showing 0 to 0 of 0 entries
                    </div>
                    <div id="adv_pagination_controls" style="display: flex; gap: 4px;">
                        <!-- Generated by JS -->
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 2: ADVANCED SALARY ENTRY FORM -->
            <!-- ============================================================= -->
            <div role="tabpanel" class="tab-pane" id="tab_entry">
                <div class="adv-form-wrapper">
                    <form id="adv_entry_form" onsubmit="submitAdvanceForm(event)">
                        <input type="hidden" id="entry_form_mode" value="create">
                        <input type="hidden" id="entry_record_id" value="">

                        <div class="row">
                            <!-- Left Column: Employee Selection & Information -->
                            <div class="col-md-5">
                                <div class="adv-form-section-title">
                                    <i class="fa fa-user" style="color: #006ba3;"></i> 1. Select Employee
                                </div>

                                <div class="adv-form-group" style="position: relative;">
                                    <label>Search Employee (ID or Name) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="emp_search_input" class="form-control" placeholder="Type Employee ID or Name..." autocomplete="off" onkeyup="debounceEmpSearch()">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button" onclick="triggerEmpSearch()"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <input type="hidden" id="selected_emp_id" name="emp_id">

                                    <!-- Dropdown Autocomplete Results -->
                                    <div class="autocomplete-dropdown" id="emp_autocomplete_list"></div>
                                </div>

                                <!-- Live Selected Employee Profile Card -->
                                <div class="emp-preview-card" id="emp_preview_box">
                                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: #e0f2fe; color: #0284c7; display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div>
                                            <div id="prev_emp_name" style="font-size: 14px; font-weight: 700; color: #0f172a;"></div>
                                            <div id="prev_emp_id" style="font-size: 12px; color: #64748b;"></div>
                                        </div>
                                    </div>
                                    <div class="emp-preview-grid">
                                        <div>
                                            <div class="item-label">Department</div>
                                            <div class="item-val" id="prev_emp_dept">-</div>
                                        </div>
                                        <div>
                                            <div class="item-label">Designation</div>
                                            <div class="item-val" id="prev_emp_desig">-</div>
                                        </div>
                                        <div>
                                            <div class="item-label">Gross Salary</div>
                                            <div class="item-val" id="prev_emp_gross">-</div>
                                        </div>
                                        <div>
                                            <div class="item-label">Joining Date</div>
                                            <div class="item-val" id="prev_emp_join">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Advance Details & Deduction Rules -->
                            <div class="col-md-7">
                                <div class="adv-form-section-title">
                                    <i class="fa fa-calculator" style="color: #006ba3;"></i> 2. Advance & Deduction Details
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="adv-form-group">
                                            <label>Advance Salary Amount (৳) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">৳</span>
                                                <input type="number" step="0.01" min="1" id="f_advance_amount" class="form-control" placeholder="e.g. 15000" required oninput="recalculateInstallments()">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="adv-form-group">
                                            <label>Advance Issue Date <span class="text-danger">*</span></label>
                                            <input type="date" id="f_advance_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="adv-form-group">
                                            <label>Effective Month (Deduction Starts) <span class="text-danger">*</span></label>
                                            <input type="month" id="f_effective_month" class="form-control" value="<?= date('Y-m') ?>" required onchange="recalculateInstallments()">
                                            <small class="text-muted">Salary month from which deduction begins</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="adv-form-group">
                                            <label>Deduction Method <span class="text-danger">*</span></label>
                                            <select id="f_deduction_method" class="form-control" onchange="onDeductionMethodChange()">
                                                <option value="installment">Installments (Monthly)</option>
                                                <option value="one_time">Full Deduction (One-time)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Installment Breakdown Parameters -->
                                <div id="installment_params_section">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="adv-form-group">
                                                <label>Monthly Deduction Amount (৳) <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-addon">৳</span>
                                                    <input type="number" step="0.01" min="1" id="f_monthly_deduction" class="form-control" placeholder="e.g. 5000" oninput="onMonthlyAmountChanged()">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="adv-form-group">
                                                <label>Number of Installments (Months)</label>
                                                <input type="number" min="1" max="60" id="f_installment_count" class="form-control" placeholder="e.g. 3" oninput="onInstallmentCountChanged()">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Live Calculation Feedback Alert -->
                                    <div id="installment_calc_feedback" style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px; font-size: 13px; color: #15803d; display: none;">
                                        <i class="fa fa-info-circle"></i> <span id="feedback_calc_text"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="adv-form-group">
                                            <label>Remarks / Notes (Optional)</label>
                                            <textarea id="f_remarks" class="form-control" rows="2" placeholder="State reason or notes (e.g. Festival advance, medical support)..."></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div style="display: flex; gap: 10px; margin-top: 10px;">
                                    <button type="submit" class="btn btn-adv-success" id="btn_save_advance">
                                        <i class="fa fa-check"></i> Save & Approve Advance
                                    </button>
                                    <button type="button" class="btn btn-adv-default" onclick="resetAdvanceForm()">
                                        <i class="fa fa-times"></i> Clear Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 3: ADVANCED SALARY REPORT & ANALYTICS -->
            <!-- ============================================================= -->
            <div role="tabpanel" class="tab-pane" id="tab_report">
                <!-- Report Filters Toolbar -->
                <div class="adv-filter-toolbar">
                    <div class="adv-filter-row">
                        <div class="adv-filter-item">
                            <label><i class="fa fa-calendar"></i> From Date</label>
                            <input type="date" id="rep_start_date" class="form-control" onchange="loadReportData()">
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-calendar"></i> To Date</label>
                            <input type="date" id="rep_end_date" class="form-control" onchange="loadReportData()">
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-calendar-check-o"></i> Effective Month</label>
                            <input type="month" id="rep_effective_month" class="form-control" onchange="loadReportData()">
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-building-o"></i> Department</label>
                            <select id="rep_dept" class="form-control" onchange="loadReportData()">
                                <option value="">All Departments</option>
                                <?php if (!empty($departments)): foreach ($departments as $d): ?>
                                    <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div class="adv-filter-item">
                            <label><i class="fa fa-tag"></i> Status</label>
                            <select id="rep_status" class="form-control" onchange="loadReportData()">
                                <option value="all">All Statuses</option>
                                <option value="Approved">Approved</option>
                                <option value="Partially Deducted">Partially Deducted</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="adv-filter-actions">
                            <button type="button" class="btn btn-adv-default" onclick="resetReportFilters()" title="Reset Filters">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                            <button type="button" class="btn btn-adv-primary" onclick="loadReportData()" title="Apply Filters">
                                <i class="fa fa-filter"></i> Apply
                            </button>
                            <button type="button" class="btn btn-adv-success" onclick="exportReportExcel()" title="Export to Excel">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </button>
                            <button type="button" class="btn btn-adv-default" onclick="exportReportCsv()" title="Export to CSV">
                                <i class="fa fa-file-text-o"></i> CSV
                            </button>
                            <button type="button" class="btn btn-adv-default" onclick="printReport()" title="Print Report">
                                <i class="fa fa-print"></i> Print
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Report Summary Stats Box -->
                <div style="background: #ffffff; padding: 14px 20px; border-bottom: 1px solid #e2e8f0; display: flex; gap: 24px; flex-wrap: wrap;">
                    <div><span style="color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 700;">Total Advances:</span> <strong id="rep_sum_adv" style="color: #0284c7; font-size: 15px;">৳ 0.00</strong></div>
                    <div><span style="color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 700;">Total Deducted:</span> <strong id="rep_sum_ded" style="color: #16a34a; font-size: 15px;">৳ 0.00</strong></div>
                    <div><span style="color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 700;">Total Outstanding:</span> <strong id="rep_sum_out" style="color: #d97706; font-size: 15px;">৳ 0.00</strong></div>
                    <div><span style="color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 700;">Total Records:</span> <strong id="rep_sum_count" style="color: #0f172a; font-size: 15px;">0</strong></div>
                </div>

                <!-- Printable Report Content -->
                <div id="printable_report_area" class="adv-table-responsive" style="padding: 10px 0;">
                    <div class="visible-print-block" style="display: none; padding: 10px 20px 20px 20px; text-align: center;">
                        <h3 style="margin: 0; font-weight: 700;">Islam Oxygen Limited</h3>
                        <h4 style="margin: 4px 0;">Advanced Salary Statement & Deduction Report</h4>
                        <div style="font-size: 12px; color: #64748b;">Generated on: <?= date('d M Y, h:i A') ?></div>
                    </div>

                    <table class="adv-table" id="report_data_table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Advance ID</th>
                                <th>Emp ID</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th class="text-right">Advance Amount</th>
                                <th>Effective Month</th>
                                <th class="text-right">Monthly Deduct</th>
                                <th class="text-right">Total Deducted</th>
                                <th class="text-right">Outstanding</th>
                                <th>Last Deduction</th>
                                <th style="text-align: center;">Status</th>
                            </tr>
                        </thead>
                        <tbody id="report_table_body">
                            <tr>
                                <td colspan="13" class="text-center" style="padding: 30px; color: #94a3b8;">
                                    Click Apply or select filters to load report data.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: VIEW ADVANCE DETAILS & DEDUCTION HISTORY -->
<!-- ========================================================================= -->
<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #006ba3; color: #ffffff; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700;">
                    <i class="fa fa-info-circle"></i> Advance Details & Deduction History (<span id="det_adv_id"></span>)
                </h4>
            </div>
            <div class="modal-body" style="padding: 20px;">
                <!-- Employee Summary Header -->
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px;">
                    <div class="row">
                        <div class="col-md-6">
                            <strong id="det_emp_name" style="font-size: 16px; color: #0f172a;"></strong>
                            <div style="font-size: 13px; color: #64748b;">
                                <span id="det_emp_id" style="font-weight: 700;"></span> &bull; 
                                <span id="det_dept_name"></span> &bull; 
                                <span id="det_desig_name"></span>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <div id="det_status_badge"></div>
                            <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                Issued Date: <strong id="det_adv_date" style="color: #0f172a;"></strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Balance Overview Cards -->
                <div class="row" style="margin-bottom: 16px;">
                    <div class="col-md-4">
                        <div style="background: #e0f2fe; border: 1px solid #bae6fd; border-radius: 6px; padding: 12px 14px;">
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #0369a1;">Original Advance</span>
                            <div id="det_amount" style="font-size: 18px; font-weight: 700; color: #0284c7;">৳ 0.00</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #dcfce7; border: 1px solid #bbf7d0; border-radius: 6px; padding: 12px 14px;">
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #15803d;">Total Deducted</span>
                            <div id="det_deducted" style="font-size: 18px; font-weight: 700; color: #16a34a;">৳ 0.00</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div style="background: #fef3c7; border: 1px solid #fde68a; border-radius: 6px; padding: 12px 14px;">
                            <span style="font-size: 11px; text-transform: uppercase; font-weight: 700; color: #b45309;">Outstanding Balance</span>
                            <div id="det_outstanding" style="font-size: 18px; font-weight: 700; color: #d97706;">৳ 0.00</div>
                        </div>
                    </div>
                </div>

                <!-- Visual Progress Bar -->
                <div style="margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; color: #475569;">
                        <span>Deduction Progress</span>
                        <span id="det_progress_pct">0%</span>
                    </div>
                    <div class="adv-progress-container">
                        <div class="adv-progress-bar" id="det_progress_bar" style="width: 0%;"></div>
                    </div>
                </div>

                <!-- Advance Settings Table -->
                <div style="margin-bottom: 20px;">
                    <h5 style="margin: 0 0 10px 0; font-weight: 700; color: #0f172a;"><i class="fa fa-cogs"></i> Advance Configuration</h5>
                    <table style="width: 100%; font-size: 13px;">
                        <tr>
                            <td style="width: 160px; color: #64748b; padding: 4px 0;">Effective Month:</td>
                            <td style="font-weight: 700;" id="det_effective_month">-</td>
                            <td style="width: 160px; color: #64748b; padding: 4px 0;">Deduction Method:</td>
                            <td style="font-weight: 700;" id="det_method">-</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b; padding: 4px 0;">Monthly Deduction:</td>
                            <td style="font-weight: 700; color: #0284c7;" id="det_monthly_deduct">-</td>
                            <td style="color: #64748b; padding: 4px 0;">Approved By:</td>
                            <td id="det_approved_by">-</td>
                        </tr>
                        <tr>
                            <td style="color: #64748b; padding: 4px 0;">Remarks / Notes:</td>
                            <td colspan="3" id="det_remarks">-</td>
                        </tr>
                    </table>
                </div>

                <!-- Complete Deduction History Table -->
                <h5 style="margin: 0 0 10px 0; font-weight: 700; color: #0f172a;">
                    <i class="fa fa-history"></i> Automatic Salary Deduction History (<span id="det_ded_count">0</span> installments)
                </h5>
                <div class="table-responsive">
                    <table class="ded-history-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Salary Month</th>
                                <th class="text-right">Advance Amount</th>
                                <th class="text-right">Deducted Amount</th>
                                <th class="text-right">Remaining Balance</th>
                                <th>Reference</th>
                                <th>Deduction Date</th>
                                <th>Processed By</th>
                            </tr>
                        </thead>
                        <tbody id="det_deductions_tbody">
                            <!-- Populated by JS -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="background: #fafbfc; border-radius: 0 0 8px 8px;">
                <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: EDIT ADVANCE RECORD -->
<!-- ========================================================================= -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-radius: 8px;">
            <div class="modal-header" style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 8px 8px 0 0;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color: #0f172a; font-weight: 700;">
                    <i class="fa fa-pencil-square-o"></i> Edit Advance Salary (<span id="edit_modal_adv_id"></span>)
                </h4>
            </div>
            <form id="adv_edit_form" onsubmit="submitEditForm(event)">
                <input type="hidden" id="edit_record_id" name="id">
                <div class="modal-body" style="padding: 20px;">
                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 10px 14px; margin-bottom: 16px;">
                        <strong id="edit_emp_info" style="color: #0f172a; font-size: 14px;"></strong>
                        <div style="font-size: 12px; color: #64748b;" id="edit_dept_info"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="adv-form-group">
                                <label>Advance Amount (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="1" id="edit_advance_amount" class="form-control" required>
                                <small class="text-muted" id="edit_deducted_help"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="adv-form-group">
                                <label>Effective Month <span class="text-danger">*</span></label>
                                <input type="month" id="edit_effective_month" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="adv-form-group">
                                <label>Deduction Method</label>
                                <select id="edit_deduction_method" class="form-control" onchange="onEditMethodChange()">
                                    <option value="installment">Installments (Monthly)</option>
                                    <option value="one_time">Full Deduction (One-time)</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="adv-form-group">
                                <label>Monthly Deduction (৳) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="1" id="edit_monthly_deduction" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="adv-form-group">
                                <label>Remarks</label>
                                <input type="text" id="edit_remarks" class="form-control">
                                <input type="hidden" id="edit_status" value="Approved">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background: #fafbfc; border-radius: 0 0 8px 8px;">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-adv-primary btn-sm">Update Advance</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- JAVASCRIPT LOGIC -->
<!-- ========================================================================= -->
<script>
var currentSortCol = 'a.id';
var currentSortDir = 'DESC';
var currentPage = 1;
var searchTimer = null;
var empSearchTimer = null;

$(document).ready(function() {
    loadAdvanceList(1);

    // Close autocomplete on clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#emp_search_input, #emp_autocomplete_list').length) {
            $('#emp_autocomplete_list').hide();
        }
    });
});

// Refresh all components
function refreshAll() {
    loadAdvanceList(currentPage);
}

// Switch between tabs
function switchToTab(tabId) {
    $('.adv-nav-tabs a[href="#' + tabId + '"]').tab('show');
    onTabChanged(tabId.replace('tab_', ''));
}

function onTabChanged(tab) {
    if (tab === 'list') {
        loadAdvanceList(currentPage);
    } else if (tab === 'report') {
        loadReportData();
    }
}

// Format numbers as currency
function formatCurrency(val) {
    var n = parseFloat(val) || 0;
    return '৳ ' + n.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

// Escape HTML
function escapeHtml(text) {
    if (!text) return '';
    return $('<div>').text(text).html();
}

// Top KPI click to filter
function filterByKpi(type) {
    $('.adv-stat-card').removeClass('active-filter');
    switchToTab('tab_list');

    if (type === 'all') {
        $('#kpi_card_total').addClass('active-filter');
        $('#filter_status').val('all');
    } else if (type === 'deducted') {
        $('#kpi_card_deducted').addClass('active-filter');
        $('#filter_status').val('all');
    } else if (type === 'outstanding') {
        $('#kpi_card_outstanding').addClass('active-filter');
        $('#filter_status').val('Approved');
    } else if (type === 'active') {
        $('#kpi_card_active').addClass('active-filter');
        $('#filter_status').val('Partially Deducted');
    }
    loadAdvanceList(1);
}

function resetFilters() {
    $('#filter_search').val('');
    $('#filter_dept').val('');
    $('#filter_month').val('');
    $('#filter_status').val('all');
    $('.adv-stat-card').removeClass('active-filter');
    loadAdvanceList(1);
}

function debounceSearch() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() {
        loadAdvanceList(1);
    }, 350);
}

function sortTable(col) {
    if (currentSortCol === col) {
        currentSortDir = (currentSortDir === 'ASC') ? 'DESC' : 'ASC';
    } else {
        currentSortCol = col;
        currentSortDir = 'DESC';
    }
    loadAdvanceList(currentPage);
}

// =========================================================================
// TAB 1: LIST LOGIC
// =========================================================================
function loadAdvanceList(page) {
    currentPage = page || 1;

    var params = {
        page: currentPage,
        limit: 20,
        search: $('#filter_search').val(),
        dept_id: $('#filter_dept').val(),
        effective_month: $('#filter_month').val(),
        status: $('#filter_status').val(),
        sort_col: currentSortCol,
        sort_dir: currentSortDir
    };

    $('#adv_table_body').html('<tr><td colspan="12" class="text-center" style="padding: 40px; color: #94a3b8;"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading records...</td></tr>');

    $.ajax({
        url: "<?= base_url('advanced_salary/list_ajax') ?>",
        type: "POST",
        data: params,
        dataType: "json",
        success: function(res) {
            if (res.status !== 'success') {
                Swal.fire('Error', 'Failed to load advance records.', 'error');
                return;
            }

            // Update Top Summary Cards
            if (res.summary) {
                $('#stat_total_advanced').text(formatCurrency(res.summary.total_advanced));
                $('#stat_total_deducted').text(formatCurrency(res.summary.total_deducted));
                $('#stat_total_outstanding').text(formatCurrency(res.summary.total_outstanding));
                $('#stat_active_count').text(res.summary.active_count);
            }

            renderAdvanceTable(res.records);
            renderPagination(res.page, res.total_pages, res.total_rows, res.limit);
        },
        error: function() {
            $('#adv_table_body').html('<tr><td colspan="12" class="text-center text-danger" style="padding: 30px;"><i class="fa fa-exclamation-triangle"></i> Error loading advance records.</td></tr>');
        }
    });
}

function renderAdvanceTable(records) {
    if (!records || records.length === 0) {
        $('#adv_table_body').html('<tr><td colspan="12" class="text-center" style="padding: 40px; color: #94a3b8;"><i class="fa fa-folder-open-o fa-2x"></i><br>No advance salary records found matching filters.</td></tr>');
        return;
    }

    var html = '';
    records.forEach(function(r) {
        var statusBadge = '';
        if (r.status === 'Approved') statusBadge = '<span class="badge-adv badge-adv-approved">Approved</span>';
        else if (r.status === 'Partially Deducted') statusBadge = '<span class="badge-adv badge-adv-partially">Partial</span>';
        else if (r.status === 'Completed') statusBadge = '<span class="badge-adv badge-adv-completed">Completed</span>';
        else if (r.status === 'Cancelled') statusBadge = '<span class="badge-adv badge-adv-cancelled">Cancelled</span>';
        else if (r.status === 'Pending') statusBadge = '<span class="badge-adv badge-adv-pending">Pending</span>';
        else if (r.status === 'Disbursed') statusBadge = '<span class="badge-adv badge-adv-disbursed">Disbursed</span>';

        html += '<tr>';
        html += '<td><strong style="color: #006ba3;">' + escapeHtml(r.advance_id) + '</strong></td>';
        html += '<td>' + escapeHtml(r.emp_id) + '</td>';
        html += '<td><strong>' + escapeHtml(r.emp_name || '-') + '</strong></td>';
        html += '<td>' + escapeHtml(r.dept_name || '-') + '</td>';
        html += '<td>' + escapeHtml(r.advance_date) + '</td>';
        html += '<td class="text-right" style="font-weight: 700; color: #0284c7;">' + formatCurrency(r.advance_amount) + '</td>';
        html += '<td><span class="label label-default" style="font-size: 11px;">' + escapeHtml(r.effective_month) + '</span></td>';
        html += '<td class="text-right">' + formatCurrency(r.monthly_deduction_amount) + '</td>';
        html += '<td class="text-right" style="color: #16a34a; font-weight: 600;">' + formatCurrency(r.total_deducted) + '</td>';
        html += '<td class="text-right" style="color: #d97706; font-weight: 700;">' + formatCurrency(r.outstanding_balance) + '</td>';
        html += '<td style="text-align: center;">' + statusBadge + '</td>';

        // Action buttons
        html += '<td style="text-align: center; white-space: nowrap;">';
        html += '<button type="button" class="btn-action-icon btn-view" onclick="openDetailsModal(' + r.id + ')" title="View Details & Deduction History"><i class="fa fa-eye"></i></button>';

        if (r.status !== 'Completed' && r.status !== 'Cancelled') {
            html += '<button type="button" class="btn-action-icon btn-edit" onclick="openEditModal(' + r.id + ')" title="Edit Advance"><i class="fa fa-pencil"></i></button>';
            html += '<button type="button" class="btn-action-icon btn-cancel" onclick="cancelAdvancePrompt(' + r.id + ', \'' + r.advance_id + '\')" title="Cancel Advance"><i class="fa fa-ban"></i></button>';
        }

        if (parseFloat(r.total_deducted) === 0) {
            html += '<button type="button" class="btn-action-icon btn-delete" onclick="deleteAdvancePrompt(' + r.id + ', \'' + r.advance_id + '\')" title="Delete Advance"><i class="fa fa-trash"></i></button>';
        }
        html += '</td>';

        html += '</tr>';
    });

    $('#adv_table_body').html(html);
}

function renderPagination(page, totalPages, totalRows, limit) {
    var start = (page - 1) * limit + 1;
    var end = Math.min(page * limit, totalRows);
    if (totalRows === 0) {
        $('#adv_pagination_info').text('Showing 0 to 0 of 0 entries');
        $('#adv_pagination_controls').html('');
        return;
    }
    $('#adv_pagination_info').text('Showing ' + start + ' to ' + end + ' of ' + totalRows + ' entries');

    var html = '';
    html += '<button class="btn btn-sm btn-default" ' + (page <= 1 ? 'disabled' : '') + ' onclick="loadAdvanceList(' + (page - 1) + ')"><i class="fa fa-chevron-left"></i></button>';

    var pStart = Math.max(1, page - 2);
    var pEnd = Math.min(totalPages, page + 2);
    for (var i = pStart; i <= pEnd; i++) {
        html += '<button class="btn btn-sm ' + (i === page ? 'btn-primary' : 'btn-default') + '" onclick="loadAdvanceList(' + i + ')">' + i + '</button>';
    }

    html += '<button class="btn btn-sm btn-default" ' + (page >= totalPages ? 'disabled' : '') + ' onclick="loadAdvanceList(' + (page + 1) + ')"><i class="fa fa-chevron-right"></i></button>';
    $('#adv_pagination_controls').html(html);
}

// =========================================================================
// TAB 2: ADVANCE ENTRY LOGIC
// =========================================================================
function debounceEmpSearch() {
    clearTimeout(empSearchTimer);
    empSearchTimer = setTimeout(function() {
        triggerEmpSearch();
    }, 300);
}

function triggerEmpSearch() {
    var q = $.trim($('#emp_search_input').val());
    if (q.length < 1) {
        $('#emp_autocomplete_list').hide();
        return;
    }

    $.ajax({
        url: "<?= base_url('advanced_salary/employee_search_ajax') ?>",
        type: "POST",
        data: { q: q },
        dataType: "json",
        success: function(res) {
            if (res.status === 'success' && res.data && res.data.length > 0) {
                var html = '';
                res.data.forEach(function(emp) {
                    html += '<div class="autocomplete-item" onclick="selectEmployee(\'' + emp.emp_id + '\')">';
                    html += '<strong>' + escapeHtml(emp.emp_id) + '</strong> - ' + escapeHtml(emp.name_en);
                    html += ' <span style="font-size: 11px; color: #64748b;">(' + escapeHtml(emp.dept_name || '') + ' - ' + escapeHtml(emp.desig_name || '') + ')</span>';
                    html += '</div>';
                });
                $('#emp_autocomplete_list').html(html).show();
            } else {
                $('#emp_autocomplete_list').html('<div style="padding: 10px; color: #94a3b8; font-size: 12px;">No matching employees found.</div>').show();
            }
        }
    });
}

function selectEmployee(empId) {
    $('#emp_autocomplete_list').hide();
    $('#selected_emp_id').val(empId);

    $.ajax({
        url: "<?= base_url('advanced_salary/get_employee_ajax') ?>",
        type: "POST",
        data: { emp_id: empId },
        dataType: "json",
        success: function(res) {
            if (res.status && res.data) {
                var emp = res.data;
                $('#emp_search_input').val(emp.emp_id + ' - ' + emp.name_en);
                $('#prev_emp_name').text(emp.name_en);
                $('#prev_emp_id').text('ID: ' + emp.emp_id);
                $('#prev_emp_dept').text(emp.dept_name || '-');
                $('#prev_emp_desig').text(emp.desig_name || '-');
                $('#prev_emp_gross').text(formatCurrency(emp.gross_sal || 0));
                $('#prev_emp_join').text(emp.emp_join_date || '-');
                $('#emp_preview_box').fadeIn();
            }
        }
    });
}

function onDeductionMethodChange() {
    var method = $('#f_deduction_method').val();
    if (method === 'one_time') {
        $('#installment_params_section').hide();
        var adv = parseFloat($('#f_advance_amount').val()) || 0;
        $('#f_monthly_deduction').val(adv);
    } else {
        $('#installment_params_section').show();
        recalculateInstallments();
    }
}

function recalculateInstallments() {
    var method = $('#f_deduction_method').val();
    var adv = parseFloat($('#f_advance_amount').val()) || 0;
    if (method === 'one_time') {
        $('#f_monthly_deduction').val(adv);
        return;
    }

    var monthly = parseFloat($('#f_monthly_deduction').val()) || 0;
    var count = parseInt($('#f_installment_count').val()) || 0;

    if (count > 0 && adv > 0) {
        var calcMonthly = Math.ceil(adv / count);
        $('#f_monthly_deduction').val(calcMonthly);
        updateCalculationFeedback(adv, calcMonthly, count);
    } else if (monthly > 0 && adv > 0) {
        var calcCount = Math.ceil(adv / monthly);
        $('#f_installment_count').val(calcCount);
        updateCalculationFeedback(adv, monthly, calcCount);
    }
}

function onInstallmentCountChanged() {
    var adv = parseFloat($('#f_advance_amount').val()) || 0;
    var count = parseInt($('#f_installment_count').val()) || 0;
    if (adv > 0 && count > 0) {
        var monthly = Math.ceil(adv / count);
        $('#f_monthly_deduction').val(monthly);
        updateCalculationFeedback(adv, monthly, count);
    }
}

function onMonthlyAmountChanged() {
    var adv = parseFloat($('#f_advance_amount').val()) || 0;
    var monthly = parseFloat($('#f_monthly_deduction').val()) || 0;
    if (adv > 0 && monthly > 0) {
        var count = Math.ceil(adv / monthly);
        $('#f_installment_count').val(count);
        updateCalculationFeedback(adv, monthly, count);
    }
}

function updateCalculationFeedback(adv, monthly, count) {
    if (adv <= 0 || monthly <= 0 || count <= 0) {
        $('#installment_calc_feedback').hide();
        return;
    }

    var effMonth = $('#f_effective_month').val() || '';
    var text = 'Deduction: ' + formatCurrency(monthly) + ' / month across ' + count + ' month(s).';

    if (effMonth) {
        var parts = effMonth.split('-');
        if (parts.length === 2) {
            var d = new Date(parseInt(parts[0]), parseInt(parts[1]) - 1 + count - 1, 1);
            var endMonthName = d.toLocaleString('default', { month: 'short', year: 'numeric' });
            text += ' Est. completion: ' + endMonthName + '.';
        }
    }
    $('#feedback_calc_text').text(text);
    $('#installment_calc_feedback').fadeIn();
}

function resetAdvanceForm() {
    $('#adv_entry_form')[0].reset();
    $('#selected_emp_id').val('');
    $('#emp_preview_box').hide();
    $('#installment_calc_feedback').hide();
    $('#f_advance_date').val(new Date().toISOString().substring(0, 10));
    var curMonth = new Date().toISOString().substring(0, 7);
    $('#f_effective_month').val(curMonth);
    $('#f_deduction_method').val('installment');
    $('#installment_params_section').show();
}

function submitAdvanceForm(e) {
    e.preventDefault();

    var empId = $('#selected_emp_id').val();
    var advAmt = parseFloat($('#f_advance_amount').val()) || 0;
    var effMonth = $('#f_effective_month').val();
    var method = $('#f_deduction_method').val();
    var monthly = parseFloat($('#f_monthly_deduction').val()) || 0;

    if (!empId) {
        Swal.fire('Employee Required', 'Please search and select an employee first.', 'warning');
        return;
    }
    if (advAmt <= 0) {
        Swal.fire('Invalid Amount', 'Advance salary amount must be greater than zero.', 'warning');
        return;
    }
    if (!effMonth) {
        Swal.fire('Effective Month Required', 'Please choose the month from which deduction starts.', 'warning');
        return;
    }
    if (method === 'installment' && monthly <= 0) {
        Swal.fire('Invalid Monthly Deduction', 'Monthly deduction must be greater than zero.', 'warning');
        return;
    }

    var payload = {
        emp_id: empId,
        advance_amount: advAmt,
        advance_date: $('#f_advance_date').val(),
        effective_month: effMonth,
        deduction_method: method,
        monthly_deduction_amount: (method === 'one_time') ? advAmt : monthly,
        remarks: $('#f_remarks').val(),
        status: 'Approved'
    };

    $('#btn_save_advance').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.ajax({
        url: "<?= base_url('advanced_salary/save') ?>",
        type: "POST",
        data: payload,
        dataType: "json",
        success: function(res) {
            $('#btn_save_advance').prop('disabled', false).html('<i class="fa fa-check"></i> Save & Approve Advance');
            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'Advance Created',
                    text: res.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                resetAdvanceForm();
                switchToTab('tab_list');
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function() {
            $('#btn_save_advance').prop('disabled', false).html('<i class="fa fa-check"></i> Save & Approve Advance');
            Swal.fire('Error', 'An error occurred while saving the advance.', 'error');
        }
    });
}

// =========================================================================
// DETAILS & DEDUCTION HISTORY MODAL
// =========================================================================
function openDetailsModal(id) {
    $.ajax({
        url: "<?= base_url('advanced_salary/get_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (!res.status || !res.record) {
                Swal.fire('Error', res.message || 'Record not found.', 'error');
                return;
            }

            var r = res.record;
            $('#det_adv_id').text(r.advance_id);
            $('#det_emp_name').text(r.emp_name || '-');
            $('#det_emp_id').text('ID: ' + r.emp_id);
            $('#det_dept_name').text(r.dept_name || '-');
            $('#det_desig_name').text(r.desig_name || '-');
            $('#det_adv_date').text(r.advance_date);

            var statusBadge = '';
            if (r.status === 'Approved') statusBadge = '<span class="badge-adv badge-adv-approved">Approved</span>';
            else if (r.status === 'Partially Deducted') statusBadge = '<span class="badge-adv badge-adv-partially">Partially Deducted</span>';
            else if (r.status === 'Completed') statusBadge = '<span class="badge-adv badge-adv-completed">Completed</span>';
            else if (r.status === 'Cancelled') statusBadge = '<span class="badge-adv badge-adv-cancelled">Cancelled</span>';
            else if (r.status === 'Pending') statusBadge = '<span class="badge-adv badge-adv-pending">Pending</span>';
            else if (r.status === 'Disbursed') statusBadge = '<span class="badge-adv badge-adv-disbursed">Disbursed</span>';
            $('#det_status_badge').html(statusBadge);

            $('#det_amount').text(formatCurrency(r.advance_amount));
            $('#det_deducted').text(formatCurrency(r.total_deducted));
            $('#det_outstanding').text(formatCurrency(r.outstanding_balance));

            // Progress bar
            var advAmt = parseFloat(r.advance_amount) || 0;
            var dedAmt = parseFloat(r.total_deducted) || 0;
            var pct = advAmt > 0 ? Math.min(100, Math.round((dedAmt / advAmt) * 100)) : 0;
            $('#det_progress_pct').text(pct + '%');
            $('#det_progress_bar').css('width', pct + '%');

            $('#det_effective_month').text(r.effective_month);
            $('#det_method').text(r.deduction_method === 'one_time' ? 'Full Deduction (One-time)' : 'Installments (Monthly)');
            $('#det_monthly_deduct').text(formatCurrency(r.monthly_deduction_amount));
            $('#det_approved_by').text(r.approved_by || 'Admin');
            $('#det_remarks').text(r.remarks || 'None');

            // Deductions list
            var deds = res.deductions || [];
            $('#det_ded_count').text(deds.length);
            if (deds.length === 0) {
                $('#det_deductions_tbody').html('<tr><td colspan="8" class="text-center" style="padding: 24px; color: #94a3b8;"><i class="fa fa-info-circle"></i> No salary deductions recorded yet. Deductions will commence from Effective Month (' + r.effective_month + ').</td></tr>');
            } else {
                var dHtml = '';
                var sl = 1;
                deds.forEach(function(d) {
                    dHtml += '<tr>';
                    dHtml += '<td>' + (sl++) + '</td>';
                    dHtml += '<td><strong style="color: #006ba3;">' + escapeHtml(d.salary_month) + '</strong></td>';
                    dHtml += '<td class="text-right">' + formatCurrency(d.advance_amount) + '</td>';
                    dHtml += '<td class="text-right" style="color: #16a34a; font-weight: 700;">' + formatCurrency(d.deduction_amount) + '</td>';
                    dHtml += '<td class="text-right" style="color: #d97706; font-weight: 600;">' + formatCurrency(d.remaining_balance) + '</td>';
                    dHtml += '<td><span class="label label-default">' + escapeHtml(d.salary_reference_id || 'SALARY_PROCESS') + '</span></td>';
                    dHtml += '<td>' + escapeHtml(d.deduction_date) + '</td>';
                    dHtml += '<td>' + escapeHtml(d.created_by || 'System') + '</td>';
                    dHtml += '</tr>';
                });
                $('#det_deductions_tbody').html(dHtml);
            }

            $('#detailsModal').modal('show');
        }
    });
}

// =========================================================================
// EDIT MODAL LOGIC
// =========================================================================
function openEditModal(id) {
    $.ajax({
        url: "<?= base_url('advanced_salary/get_details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (!res.status || !res.record) {
                Swal.fire('Error', res.message || 'Record not found.', 'error');
                return;
            }

            var r = res.record;
            $('#edit_record_id').val(r.id);
            $('#edit_modal_adv_id').text(r.advance_id);
            $('#edit_emp_info').text(r.emp_id + ' - ' + r.emp_name);
            $('#edit_dept_info').text(r.dept_name + ' &bull; ' + r.desig_name);

            $('#edit_advance_amount').val(r.advance_amount);
            $('#edit_deducted_help').text('Already deducted: ' + formatCurrency(r.total_deducted));
            $('#edit_effective_month').val(r.effective_month.substring(0, 7));
            $('#edit_deduction_method').val(r.deduction_method);
            $('#edit_monthly_deduction').val(r.monthly_deduction_amount);
            $('#edit_remarks').val(r.remarks || '');
            $('#edit_status').val(r.status);

            $('#editModal').modal('show');
        }
    });
}

function onEditMethodChange() {
    var method = $('#edit_deduction_method').val();
    if (method === 'one_time') {
        var adv = parseFloat($('#edit_advance_amount').val()) || 0;
        $('#edit_monthly_deduction').val(adv);
    }
}

function submitEditForm(e) {
    e.preventDefault();

    var id = $('#edit_record_id').val();
    var advAmt = parseFloat($('#edit_advance_amount').val()) || 0;
    var effMonth = $('#edit_effective_month').val();
    var method = $('#edit_deduction_method').val();
    var monthly = parseFloat($('#edit_monthly_deduction').val()) || 0;

    var payload = {
        id: id,
        advance_amount: advAmt,
        effective_month: effMonth,
        deduction_method: method,
        monthly_deduction_amount: monthly,
        remarks: $('#edit_remarks').val(),
        status: $('#edit_status').val()
    };

    $.ajax({
        url: "<?= base_url('advanced_salary/save') ?>",
        type: "POST",
        data: payload,
        dataType: "json",
        success: function(res) {
            if (res.status) {
                $('#editModal').modal('hide');
                Swal.fire('Updated', res.message, 'success');
                loadAdvanceList(currentPage);
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        }
    });
}

// =========================================================================
// CANCEL & DELETE ADVANCE
// =========================================================================
function cancelAdvancePrompt(id, advId) {
    Swal.fire({
        title: 'Cancel Advance?',
        text: 'Are you sure you want to cancel ' + advId + '? Outstanding balance will no longer be deducted in future payroll.',
        input: 'text',
        inputPlaceholder: 'Optional cancellation reason...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Cancel Advance'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('advanced_salary/cancel') ?>/" + id,
                type: "POST",
                data: { reason: result.value || '' },
                dataType: "json",
                success: function(res) {
                    if (res.status) {
                        Swal.fire('Cancelled', res.message, 'success');
                        loadAdvanceList(currentPage);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }
            });
        }
    });
}

function deleteAdvancePrompt(id, advId) {
    Swal.fire({
        title: 'Delete Advance Record?',
        text: 'Are you sure you want to permanently delete ' + advId + '?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#991b1b',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Delete Permanently'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?= base_url('advanced_salary/delete') ?>/" + id,
                type: "POST",
                dataType: "json",
                success: function(res) {
                    if (res.status) {
                        Swal.fire('Deleted', res.message, 'success');
                        loadAdvanceList(currentPage);
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }
            });
        }
    });
}

// =========================================================================
// TAB 3: REPORT & ANALYTICS
// =========================================================================
function loadReportData() {
    var params = {
        start_date: $('#rep_start_date').val(),
        end_date: $('#rep_end_date').val(),
        effective_month: $('#rep_effective_month').val(),
        dept_id: $('#rep_dept').val(),
        status: $('#rep_status').val()
    };

    $('#report_table_body').html('<tr><td colspan="13" class="text-center" style="padding: 30px; color: #94a3b8;"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Generating report...</td></tr>');

    $.ajax({
        url: "<?= base_url('advanced_salary/report_data_ajax') ?>",
        type: "POST",
        data: params,
        dataType: "json",
        success: function(res) {
            if (res.status !== 'success') {
                Swal.fire('Error', 'Failed to generate report data.', 'error');
                return;
            }

            var records = res.data || [];
            var totAdv = 0, totDed = 0, totOut = 0;

            if (records.length === 0) {
                $('#report_table_body').html('<tr><td colspan="13" class="text-center" style="padding: 30px; color: #94a3b8;">No records found matching report criteria.</td></tr>');
            } else {
                var html = '';
                var sl = 1;
                records.forEach(function(r) {
                    totAdv += parseFloat(r.advance_amount) || 0;
                    totDed += parseFloat(r.total_deducted) || 0;
                    totOut += parseFloat(r.outstanding_balance) || 0;

                    var statusBadge = '';
                    if (r.status === 'Approved') statusBadge = '<span class="badge-adv badge-adv-approved">Approved</span>';
                    else if (r.status === 'Partially Deducted') statusBadge = '<span class="badge-adv badge-adv-partially">Partial</span>';
                    else if (r.status === 'Completed') statusBadge = '<span class="badge-adv badge-adv-completed">Completed</span>';
                    else if (r.status === 'Cancelled') statusBadge = '<span class="badge-adv badge-adv-cancelled">Cancelled</span>';
                    else if (r.status === 'Pending') statusBadge = '<span class="badge-adv badge-adv-pending">Pending</span>';
                    else if (r.status === 'Disbursed') statusBadge = '<span class="badge-adv badge-adv-disbursed">Disbursed</span>';

                    html += '<tr>';
                    html += '<td>' + (sl++) + '</td>';
                    html += '<td><strong>' + escapeHtml(r.advance_id) + '</strong></td>';
                    html += '<td>' + escapeHtml(r.emp_id) + '</td>';
                    html += '<td>' + escapeHtml(r.emp_name || '-') + '</td>';
                    html += '<td>' + escapeHtml(r.dept_name || '-') + '</td>';
                    html += '<td>' + escapeHtml(r.desig_name || '-') + '</td>';
                    html += '<td class="text-right" style="color: #0284c7; font-weight: 700;">' + formatCurrency(r.advance_amount) + '</td>';
                    html += '<td>' + escapeHtml(r.effective_month) + '</td>';
                    html += '<td class="text-right">' + formatCurrency(r.monthly_deduction_amount) + '</td>';
                    html += '<td class="text-right" style="color: #16a34a; font-weight: 600;">' + formatCurrency(r.total_deducted) + '</td>';
                    html += '<td class="text-right" style="color: #d97706; font-weight: 700;">' + formatCurrency(r.outstanding_balance) + '</td>';
                    html += '<td>' + (r.last_deduction_month ? escapeHtml(r.last_deduction_month) : '<span class="text-muted">-</span>') + '</td>';
                    html += '<td style="text-align: center;">' + statusBadge + '</td>';
                    html += '</tr>';
                });

                // Summary footer row
                html += '<tr style="background: #f8fafc; font-weight: 700; border-top: 2px solid #e2e8f0;">';
                html += '<td colspan="6" class="text-right">Grand Total:</td>';
                html += '<td class="text-right" style="color: #0284c7;">' + formatCurrency(totAdv) + '</td>';
                html += '<td></td><td></td>';
                html += '<td class="text-right" style="color: #16a34a;">' + formatCurrency(totDed) + '</td>';
                html += '<td class="text-right" style="color: #d97706;">' + formatCurrency(totOut) + '</td>';
                html += '<td></td><td></td>';
                html += '</tr>';

                $('#report_table_body').html(html);
            }

            $('#rep_sum_adv').text(formatCurrency(totAdv));
            $('#rep_sum_ded').text(formatCurrency(totDed));
            $('#rep_sum_out').text(formatCurrency(totOut));
            $('#rep_sum_count').text(records.length);
        }
    });
}

function resetReportFilters() {
    $('#rep_start_date').val('');
    $('#rep_end_date').val('');
    $('#rep_effective_month').val('');
    $('#rep_dept').val('');
    $('#rep_status').val('all');
    loadReportData();
}

function exportReportExcel() {
    var qs = $.param({
        start_date: $('#rep_start_date').val(),
        end_date: $('#rep_end_date').val(),
        effective_month: $('#rep_effective_month').val(),
        dept_id: $('#rep_dept').val(),
        status: $('#rep_status').val()
    });
    window.location.href = "<?= base_url('advanced_salary/export_excel') ?>?" + qs;
}

function exportReportCsv() {
    var qs = $.param({
        start_date: $('#rep_start_date').val(),
        end_date: $('#rep_end_date').val(),
        effective_month: $('#rep_effective_month').val(),
        dept_id: $('#rep_dept').val(),
        status: $('#rep_status').val()
    });
    window.location.href = "<?= base_url('advanced_salary/export_csv') ?>?" + qs;
}

function printReport() {
    window.print();
}
</script>
