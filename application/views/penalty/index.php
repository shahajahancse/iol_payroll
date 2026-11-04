<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
.pen-container {
    padding: 15px 20px 40px 20px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
}

/* Header Card (Exact match with img 2 / Advanced Salary) */
.pen-header-card {
    background: #ffffff;
    border-radius: 8px;
    padding: 16px 22px;
    margin-top: 80px;
    margin-bottom: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
}
.pen-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.pen-header-icon {
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
.pen-header-text h2 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
}
.pen-header-text p {
    margin: 2px 0 0 0;
    font-size: 13px;
    color: #64748b;
}
.pen-header-actions {
    display: flex;
    gap: 10px;
}

/* 4 Summary Cards (Exact match with Advanced Salary) */
.pen-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.2s ease-in-out;
}
.pen-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.pen-stat-info {
    flex-grow: 1;
    min-width: 0;
}
.pen-stat-info h3 {
    margin: 0;
    font-size: 19px;
    font-weight: 700;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pen-stat-info span {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.stat-blue .pen-stat-icon   { background: #e0f2fe; color: #0284c7; }
.stat-green .pen-stat-icon  { background: #dcfce7; color: #16a34a; }
.stat-amber .pen-stat-icon  { background: #fef3c7; color: #d97706; }
.stat-purple .pen-stat-icon { background: #f3e8ff; color: #9333ea; }

/* Main Card & Navigation Tabs */
.pen-main-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}
.pen-nav-tabs {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 0 16px;
    margin: 0;
    list-style: none;
    display: flex;
    gap: 4px;
}
.pen-nav-tabs > li > a {
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
    cursor: pointer;
}
.pen-nav-tabs > li > a:hover {
    color: #0f172a;
    background: #f1f5f9;
}
.pen-nav-tabs > li.active > a {
    color: #006ba3;
    border-bottom-color: #006ba3;
    background: #ffffff;
    font-weight: 700;
}

/* Filter Toolbar */
.pen-filter-toolbar {
    padding: 16px 20px;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}
.pen-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: flex-end;
}
.pen-filter-item {
    flex: 1 1 170px;
    min-width: 150px;
}
.pen-filter-item label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 4px;
}
.pen-filter-item .form-control {
    height: 36px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    box-shadow: none;
}
.pen-filter-item .form-control:focus {
    border-color: #006ba3;
    outline: none;
}
.pen-filter-actions {
    display: flex;
    gap: 8px;
    align-items: flex-end;
}

/* Action Buttons (Exact styling from Advanced Salary) */
.btn-pen-primary {
    background: #006ba3;
    color: #ffffff !important;
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
    cursor: pointer;
}
.btn-pen-primary:hover {
    background: #005a8a;
    color: #ffffff !important;
}
.btn-pen-default {
    background: #ffffff;
    color: #475569 !important;
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
    cursor: pointer;
}
.btn-pen-default:hover {
    background: #f1f5f9;
    color: #0f172a !important;
}
.btn-pen-success {
    background: #16a34a;
    color: #ffffff !important;
    border: 1px solid #15803d;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    height: 36px;
    padding: 0 16px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}
.btn-pen-success:hover {
    background: #15803d;
    color: #ffffff !important;
}

/* Data Table */
.pen-table-responsive {
    overflow-x: auto;
    min-height: 250px;
}
.pen-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 13px;
    margin: 0;
}
.pen-table th {
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
.pen-table td {
    padding: 12px 14px;
    border-bottom: 1px solid #f1f5f9;
    color: #1e293b;
    vertical-align: middle;
}
.pen-table tbody tr:hover {
    background: #f8fafc;
}

/* Badges */
.badge-pen {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.badge-pen-approved  { background: #dcfce7; color: #15803d; }
.badge-pen-pending   { background: #fef3c7; color: #b45309; }
.badge-pen-cancelled { background: #f1f5f9; color: #64748b; }

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
.btn-action-icon.btn-edit:hover   { background: #fef3c7; color: #d97706; border-color: #fde68a; }
.btn-action-icon.btn-cancel:hover { background: #fee2e2; color: #dc2626; border-color: #fecaca; }
.btn-action-icon.btn-delete:hover { background: #fef2f2; color: #991b1b; border-color: #fecaca; }

/* Form Styles */
.pen-form-wrapper {
    padding: 24px;
}
.pen-form-section-title {
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
.pen-form-group {
    margin-bottom: 16px;
}
.pen-form-group label {
    font-size: 12px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 6px;
    display: block;
}
.pen-form-group .form-control {
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    box-shadow: none;
}
.pen-form-group .form-control:focus {
    border-color: #006ba3;
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

/* Employee Preview Card */
.emp-preview-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 14px 18px;
    display: none;
}
.emp-preview-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
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
</style>

<div class="content pen-container">

    <!-- Top Executive Header Card -->
    <div class="pen-header-card">
        <div class="pen-header-left">
            <div class="pen-header-icon">
                <i class="fa fa-gavel"></i>
            </div>
            <div class="pen-header-text">
                <h2>Penalty Management</h2>
                <p>Track employee penalties, manage deductions, and generate penalty sheets</p>
            </div>
        </div>
        <div class="pen-header-actions">
            <button type="button" class="btn btn-pen-default" onclick="openPenaltySheet()" title="Print Penalty Sheet">
                <i class="fa fa-print"></i> Penalty Sheet
            </button>
            <button type="button" class="btn btn-pen-default" onclick="loadPenaltyList(1)" title="Refresh live statistics">
                <i class="fa fa-refresh"></i> Refresh
            </button>
            <button type="button" class="btn btn-pen-primary" onclick="switchToTab('tab_entry')" title="Create New Penalty">
                <i class="fa fa-plus-circle"></i> New Penalty Entry
            </button>
        </div>
    </div>

    <!-- 4 Real-Time Summary Cards (Identical layout to Advanced Salary) -->
    <div class="row">
        <!-- Card 1: Total Records -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pen-stat-card stat-blue" title="Total Penalty Records">
                <div class="pen-stat-icon">
                    <i class="fa fa-list"></i>
                </div>
                <div class="pen-stat-info">
                    <h3 id="statTotalCount"><?php echo number_format(!empty($summary->total_count) ? $summary->total_count : 0); ?></h3>
                    <span>Total Records</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Approved Penalties -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pen-stat-card stat-green" title="Approved Penalties">
                <div class="pen-stat-icon">
                    <i class="fa fa-check-circle-o"></i>
                </div>
                <div class="pen-stat-info">
                    <h3 id="statApprovedCount"><?php echo number_format(!empty($summary->approved_count) ? $summary->approved_count : 0); ?></h3>
                    <span>Approved Penalties</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Approved Amount -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pen-stat-card stat-amber" title="Total Approved Penalty Amount">
                <div class="pen-stat-icon">
                    <i class="fa fa-money"></i>
                </div>
                <div class="pen-stat-info">
                    <h3 id="statApprovedAmount">৳ <?php echo number_format(!empty($summary->approved_amount) ? $summary->approved_amount : 0, 2); ?></h3>
                    <span>Approved Amount</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Pending Penalties -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="pen-stat-card stat-purple" title="Pending Approvals">
                <div class="pen-stat-icon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <div class="pen-stat-info">
                    <h3 id="statPendingCount"><?php echo number_format(!empty($summary->pending_count) ? $summary->pending_count : 0); ?></h3>
                    <span>Pending Penalties</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation & Tabs -->
    <div class="pen-main-card">
        <ul class="pen-nav-tabs" role="tablist">
            <li role="presentation" class="active" id="tab_btn_list">
                <a href="#tab_list" aria-controls="tab_list" role="tab" data-toggle="tab" onclick="onTabChanged('list')">
                    <i class="fa fa-list"></i> Penalty List & History
                </a>
            </li>
            <li role="presentation" id="tab_btn_entry">
                <a href="#tab_entry" aria-controls="tab_entry" role="tab" data-toggle="tab" onclick="onTabChanged('entry')">
                    <i class="fa fa-plus-circle"></i> New Penalty Entry
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- ============================================================= -->
            <!-- TAB 1: PENALTY LIST & MANAGEMENT -->
            <!-- ============================================================= -->
            <div role="tabpanel" class="tab-pane active" id="tab_list">
                <!-- Filter Bar -->
                <div class="pen-filter-toolbar">
                    <div class="pen-filter-row">
                        <div class="pen-filter-item" style="flex: 2 1 240px;">
                            <label><i class="fa fa-search"></i> Search Employee / ID</label>
                            <input type="text" id="filterSearch" class="form-control" placeholder="Search by ID or Name..." onkeyup="debounceSearch()">
                        </div>

                        <div class="pen-filter-item">
                            <label><i class="fa fa-building-o"></i> Department</label>
                            <select id="filterDept" class="form-control" onchange="loadPenaltyList(1)">
                                <option value="">All Departments</option>
                                <?php if (!empty($departments)): foreach ($departments as $d): ?>
                                    <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>

                        <div class="pen-filter-item">
                            <label><i class="fa fa-calendar"></i> Salary Month</label>
                            <input type="month" id="filterMonth" class="form-control" value="<?php echo date('Y-m'); ?>" onchange="loadPenaltyList(1)">
                        </div>

                        <div class="pen-filter-item">
                            <label><i class="fa fa-tag"></i> Status</label>
                            <select id="filterStatus" class="form-control" onchange="loadPenaltyList(1)">
                                <option value="">All Statuses</option>
                                <option value="Approved">Approved</option>
                                <option value="Pending">Pending</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>

                        <div class="pen-filter-actions">
                            <button type="button" class="btn btn-pen-default" onclick="resetFilters()" title="Reset Filters">
                                <i class="fa fa-undo"></i> Reset
                            </button>
                            <button type="button" class="btn btn-pen-primary" onclick="loadPenaltyList(1)" title="Apply Filters">
                                <i class="fa fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>

                <!-- DataTable -->
                <div class="pen-table-responsive">
                    <table class="pen-table">
                        <thead>
                            <tr>
                                <th width="40">SL</th>
                                <th>Emp ID</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th>Salary Month</th>
                                <th class="text-right">Penalty Amount</th>
                                <th>Remarks / Reason</th>
                                <th style="text-align: center;">Status</th>
                                <th>Created At</th>
                                <th style="text-align: center; width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="penTableBody">
                            <tr>
                                <td colspan="11" class="text-center" style="padding: 40px; color: #94a3b8;">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading records...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Bar -->
                <div style="padding: 12px 20px; background: #fafbfc; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div id="penTableInfo" style="font-size: 13px; color: #64748b;">
                        Showing 0 to 0 of 0 entries
                    </div>
                    <div id="penPagination" style="display: flex; gap: 4px;">
                        <!-- Generated by JS -->
                    </div>
                </div>
            </div>

            <!-- ============================================================= -->
            <!-- TAB 2: IN-PAGE PENALTY ENTRY FORM -->
            <!-- ============================================================= -->
            <div role="tabpanel" class="tab-pane" id="tab_entry">
                <div class="pen-form-wrapper">
                    <form id="penEntryForm">
                        <input type="hidden" id="entryRecordId" name="id" value="">

                        <div class="row">
                            <!-- Left Column: Employee Selection -->
                            <div class="col-md-5">
                                <div class="pen-form-section-title">
                                    <i class="fa fa-user" style="color: #006ba3;"></i> 1. Select Employee
                                </div>

                                <div class="pen-form-group" style="position: relative;">
                                    <label>Search Employee (ID or Name) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="entryEmpSearch" class="form-control" placeholder="Type Employee ID or Name..." autocomplete="off">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                    <input type="hidden" id="entryEmpId" name="emp_id" required>
                                    <div class="autocomplete-dropdown" id="entryEmpSuggestBox"></div>
                                </div>

                                <!-- Live Selected Employee Profile Card -->
                                <div class="emp-preview-card" id="entryEmpPreviewBox">
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

                            <!-- Right Column: Penalty Details -->
                            <div class="col-md-7">
                                <div class="pen-form-section-title">
                                    <i class="fa fa-calculator" style="color: #006ba3;"></i> 2. Penalty & Deduction Details
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="pen-form-group">
                                            <label>Salary Month (Deduction Month) <span class="text-danger">*</span></label>
                                            <input type="month" id="entrySalaryMonth" name="salary_month" class="form-control" value="<?php echo date('Y-m'); ?>" required>
                                            <small class="text-muted">The payroll month this penalty will be deducted from</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="pen-form-group">
                                            <label>Penalty Amount (৳) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-addon">৳</span>
                                                <input type="number" step="0.01" min="1" id="entryAmount" name="amount" class="form-control" placeholder="e.g. 500" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="pen-form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <select id="entryStatus" name="status" class="form-control">
                                                <option value="Approved">Approved (Ready for Salary Deduction)</option>
                                                <option value="Pending">Pending Approval</option>
                                                <option value="Cancelled">Cancelled</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="pen-form-group">
                                    <label>Remarks / Reason for Penalty <span class="text-danger">*</span></label>
                                    <textarea id="entryRemarks" name="remarks" rows="3" class="form-control" placeholder="Enter specific reason for penalty deduction (e.g. Lost ID card, attendance violation, company policy breach)..." required></textarea>
                                </div>

                                <div style="display: flex; gap: 10px; margin-top: 15px;">
                                    <button type="submit" class="btn btn-pen-success" id="btnSavePenalty">
                                        <i class="fa fa-check"></i> <span id="btnSaveText">Save Penalty</span>
                                    </button>
                                    <button type="button" class="btn btn-pen-default" onclick="resetEntryForm()">
                                        <i class="fa fa-times"></i> Clear Form
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

</div>

<script>
var currentPage = 1;
var limit = 20;
var searchTimer = null;

$(document).ready(function() {
    loadPenaltyList(1);

    // Employee Search Autocomplete in Entry Form
    var empTimer = null;
    $('#entryEmpSearch').on('keyup input', function() {
        var term = $(this).val().trim();
        clearTimeout(empTimer);
        if (term.length < 1) {
            $('#entryEmpSuggestBox').hide().html('');
            return;
        }
        empTimer = setTimeout(function() {
            $.ajax({
                url: '<?php echo base_url("penalty/employee_search_ajax"); ?>',
                type: 'POST',
                data: { query: term },
                dataType: 'json',
                success: function(list) {
                    if (list && list.length > 0) {
                        var h = '';
                        $.each(list, function(i, emp) {
                            h += '<div class="autocomplete-item" onclick="selectEmployee(\'' + emp.emp_id + '\')">' +
                                 '<strong>' + emp.emp_id + '</strong> - ' + (emp.name_en || '') +
                                 ' <span style="color:#64748b;">(' + (emp.dept_name || '') + ')</span>' +
                                 '</div>';
                        });
                        $('#entryEmpSuggestBox').html(h).show();
                    } else {
                        $('#entryEmpSuggestBox').html('<div style="padding:8px 12px; color:#888;">No employees found</div>').show();
                    }
                }
            });
        }, 250);
    });

    // Form Submit
    $('#penEntryForm').submit(function(e) {
        e.preventDefault();
        var empId = $('#entryEmpId').val();
        if (!empId) {
            Swal.fire({ icon: 'warning', title: 'Employee Required', text: 'Please select an employee first.' });
            return;
        }

        var btn = $('#btnSavePenalty');
        btn.prop('disabled', true);
        $('#btnSaveText').text('Saving...');

        $.ajax({
            url: '<?php echo base_url("penalty/save"); ?>',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false);
                $('#btnSaveText').text('Save Penalty');

                if (res.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message || 'Penalty record saved successfully.',
                        timer: 1600,
                        showConfirmButton: false
                    });
                    resetEntryForm();
                    switchToTab('tab_list');
                    loadPenaltyList(1);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to save penalty.' });
                }
            },
            error: function() {
                btn.prop('disabled', false);
                $('#btnSaveText').text('Save Penalty');
                Swal.fire({ icon: 'error', title: 'Server Error', text: 'An unexpected error occurred.' });
            }
        });
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#entryEmpSearch, #entryEmpSuggestBox').length) {
            $('#entryEmpSuggestBox').hide();
        }
    });
});

function debounceSearch() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() {
        loadPenaltyList(1);
    }, 300);
}

function switchToTab(tabId) {
    $('.pen-nav-tabs a[href="#' + tabId + '"]').tab('show');
}

function onTabChanged(tab) {
    if (tab === 'list') {
        loadPenaltyList(currentPage);
    }
}

function selectEmployee(empId) {
    $('#entryEmpSuggestBox').hide();
    $.ajax({
        url: '<?php echo base_url("penalty/get_employee_ajax"); ?>',
        type: 'POST',
        data: { emp_id: empId },
        dataType: 'json',
        success: function(res) {
            if (res.status && res.employee) {
                var emp = res.employee;
                $('#entryEmpId').val(emp.emp_id);
                $('#entryEmpSearch').val(emp.emp_id + ' - ' + emp.name_en);
                $('#prev_emp_id').text('ID: ' + emp.emp_id);
                $('#prev_emp_name').text(emp.name_en);
                $('#prev_emp_dept').text(emp.dept_name || '-');
                $('#prev_emp_desig').text(emp.desig_name || '-');
                $('#prev_emp_gross').text('৳ ' + Number(emp.gross_sal || 0).toLocaleString());
                $('#prev_emp_join').text(emp.emp_join_date || '-');
                $('#entryEmpPreviewBox').slideDown();
            }
        }
    });
}

function resetEntryForm() {
    $('#penEntryForm')[0].reset();
    $('#entryRecordId').val('');
    $('#entryEmpId').val('');
    $('#entryEmpSearch').val('');
    $('#entrySalaryMonth').val('<?php echo date("Y-m"); ?>');
    $('#entryStatus').val('Approved');
    $('#entryEmpPreviewBox').hide();
    $('#btnSaveText').text('Save Penalty');
}

function resetFilters() {
    $('#filterSearch').val('');
    $('#filterMonth').val('<?php echo date("Y-m"); ?>');
    $('#filterDept').val('');
    $('#filterStatus').val('');
    loadPenaltyList(1);
}

function loadPenaltyList(page) {
    currentPage = page || 1;
    var data = {
        page: currentPage,
        limit: limit,
        search: $('#filterSearch').val(),
        salary_month: $('#filterMonth').val(),
        dept_id: $('#filterDept').val(),
        status: $('#filterStatus').val()
    };

    $('#penTableBody').html('<tr><td colspan="11" class="text-center" style="padding: 40px; color: #94a3b8;"><i class="fa fa-spinner fa-spin fa-2x"></i><br>Loading records...</td></tr>');

    $.ajax({
        url: '<?php echo base_url("penalty/list_ajax"); ?>',
        type: 'POST',
        data: data,
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                renderTable(res.records, res.page, res.limit, res.total_rows);
                renderPagination(res.total_pages, res.page);
                if (res.summary) {
                    $('#statTotalCount').text(Number(res.summary.total_count || 0).toLocaleString());
                    $('#statApprovedCount').text(Number(res.summary.approved_count || 0).toLocaleString());
                    $('#statApprovedAmount').text('৳ ' + Number(res.summary.approved_amount || 0).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                    $('#statPendingCount').text(Number(res.summary.pending_count || 0).toLocaleString());
                }
            } else {
                $('#penTableBody').html('<tr><td colspan="11" class="text-danger text-center">Failed to load data.</td></tr>');
            }
        },
        error: function() {
            $('#penTableBody').html('<tr><td colspan="11" class="text-danger text-center">An error occurred while fetching data.</td></tr>');
        }
    });
}

function renderTable(records, page, limit, total) {
    if (!records || records.length === 0) {
        $('#penTableBody').html('<tr><td colspan="11" class="text-center" style="padding: 40px; color: #94a3b8;">No penalty records found matching filters.</td></tr>');
        $('#penTableInfo').text('Showing 0 to 0 of 0 entries');
        return;
    }

    var start = (page - 1) * limit + 1;
    var end = Math.min(page * limit, total);
    $('#penTableInfo').text('Showing ' + start + ' to ' + end + ' of ' + total + ' entries');

    var html = '';
    var sl = start;
    $.each(records, function(idx, row) {
        var badgeClass = 'badge-pen-pending';
        if (row.status === 'Approved') badgeClass = 'badge-pen-approved';
        else if (row.status === 'Cancelled') badgeClass = 'badge-pen-cancelled';

        var createdDate = row.created_at ? row.created_at.substring(0, 10) : '-';

        html += '<tr>' +
            '<td>' + (sl++) + '</td>' +
            '<td><strong>' + (row.emp_id || '') + '</strong></td>' +
            '<td><strong>' + (row.name_en || '') + '</strong></td>' +
            '<td>' + (row.dept_name || '-') + '</td>' +
            '<td>' + (row.desig_name || '-') + '</td>' +
            '<td><strong>' + (row.salary_month || '') + '</strong></td>' +
            '<td class="text-right"><strong style="color: #0f172a;">৳ ' + Number(row.amount || 0).toFixed(2) + '</strong></td>' +
            '<td>' + (row.remarks ? row.remarks : '<em style="color:#94a3b8;">None</em>') + '</td>' +
            '<td style="text-align: center;"><span class="badge-pen ' + badgeClass + '">' + (row.status || 'Pending') + '</span></td>' +
            '<td style="font-size:12px; color:#64748b;">' + createdDate + '</td>' +
            '<td style="text-align: center; white-space: nowrap;">' +
                '<button type="button" class="btn-action-icon btn-edit" onclick="editPenalty(' + row.id + ')" title="Edit"><i class="fa fa-pencil"></i></button>';

        if (row.status !== 'Cancelled') {
            html += '<button type="button" class="btn-action-icon btn-cancel" onclick="cancelPenalty(' + row.id + ')" title="Cancel"><i class="fa fa-ban"></i></button>';
        }
        html += '<button type="button" class="btn-action-icon btn-delete" onclick="deletePenalty(' + row.id + ')" title="Delete"><i class="fa fa-trash"></i></button>' +
            '</td>' +
        '</tr>';
    });

    $('#penTableBody').html(html);
}

function renderPagination(totalPages, page) {
    if (totalPages <= 1) {
        $('#penPagination').html('');
        return;
    }
    var pHtml = '';
    if (page > 1) {
        pHtml += '<button type="button" class="btn btn-pen-default btn-xs" onclick="loadPenaltyList(' + (page - 1) + ')">&laquo; Prev</button>';
    }
    for (var p = 1; p <= totalPages; p++) {
        if (p === 1 || p === totalPages || (p >= page - 2 && p <= page + 2)) {
            var activeClass = (p === page) ? 'btn-pen-primary' : 'btn-pen-default';
            pHtml += '<button type="button" class="btn ' + activeClass + ' btn-xs" onclick="loadPenaltyList(' + p + ')">' + p + '</button>';
        } else if (p === page - 3 || p === page + 3) {
            pHtml += '<span style="padding:0 4px; color:#94a3b8;">...</span>';
        }
    }
    if (page < totalPages) {
        pHtml += '<button type="button" class="btn btn-pen-default btn-xs" onclick="loadPenaltyList(' + (page + 1) + ')">Next &raquo;</button>';
    }
    $('#penPagination').html(pHtml);
}

function editPenalty(id) {
    $.ajax({
        url: '<?php echo base_url("penalty/get_details_ajax"); ?>/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(res) {
            if (res.status && res.record) {
                var rec = res.record;
                selectEmployee(rec.emp_id);
                $('#entryRecordId').val(rec.id);
                $('#entrySalaryMonth').val(rec.salary_month);
                $('#entryAmount').val(rec.amount);
                $('#entryRemarks').val(rec.remarks);
                $('#entryStatus').val(rec.status);
                $('#btnSaveText').text('Update Penalty');
                switchToTab('tab_entry');
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Error loading details.' });
            }
        }
    });
}

function cancelPenalty(id) {
    Swal.fire({
        title: 'Cancel Penalty?',
        text: 'This penalty will not be deducted during salary processing.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, cancel it!'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url("penalty/cancel"); ?>/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        Swal.fire({ icon: 'success', title: 'Cancelled', text: 'Penalty cancelled successfully.', timer: 1400, showConfirmButton: false });
                        loadPenaltyList(currentPage);
                    }
                }
            });
        }
    });
}

function deletePenalty(id) {
    Swal.fire({
        title: 'Delete Penalty Record?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, delete permanently!'
    }).then(function(result) {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?php echo base_url("penalty/delete"); ?>/' + id,
                type: 'POST',
                dataType: 'json',
                success: function(res) {
                    if (res.status) {
                        Swal.fire({ icon: 'success', title: 'Deleted', text: 'Record deleted successfully.', timer: 1400, showConfirmButton: false });
                        loadPenaltyList(currentPage);
                    }
                }
            });
        }
    });
}

function openPenaltySheet() {
    var month = $('#filterMonth').val() || '<?php echo date("Y-m"); ?>';
    var url = '<?php echo base_url("penalty/penalty_sheet"); ?>?salary_month=' + encodeURIComponent(month);
    window.open(url, '_blank');
}
</script>
