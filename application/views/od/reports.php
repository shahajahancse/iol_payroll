<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) REPORTS CENTER - EXECUTIVE THEME                        */
/* ========================================================================= */
.page-content .content.od-reports-wrapper {
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
    background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
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
    gap: 10px;
    align-items: center;
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

/* Nav Tabs */
.nav-tabs-custom {
    display: flex;
    gap: 6px;
    margin-bottom: 18px;
    border-bottom: 2px solid #e2e8f0;
    overflow-x: auto;
}
.tab-link-custom {
    padding: 10px 18px;
    font-size: 13px;
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
    gap: 7px;
    white-space: nowrap;
}
.tab-link-custom:hover {
    color: #0f172a;
}
.tab-link-custom.active {
    color: #4f46e5;
    border-bottom-color: #4f46e5;
}

/* Filter Bar */
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
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
}
.btn-filter-apply {
    background: #4f46e5;
    color: #ffffff;
    border: none;
    padding: 8px 18px;
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
    background: #4338ca;
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
.table-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 20px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    font-size: 13px;
    color: #64748b;
}
</style>

<div class="content od-reports-wrapper">

        <!-- Top Header Card -->
        <div class="od-header-card">
            <div class="od-header-left">
                <div class="od-header-icon">
                    <i class="fa fa-bar-chart"></i>
                </div>
                <div class="od-header-text">
                    <h2>Outside Duty (OD) Reports Center</h2>
                    <p>Daily, Monthly, Employee-wise, and Departmental Outside Duty analytics and print/export tools</p>
                </div>
            </div>
            <div class="od-header-actions">
                <button type="button" class="btn-action-outline" onclick="exportReport('excel')">
                    <i class="fa fa-file-excel-o" style="color:#16a34a;"></i> Export to Excel / CSV
                </button>
                <button type="button" class="btn-action-outline" onclick="exportReport('print')">
                    <i class="fa fa-print" style="color:#0284c7;"></i> Print / PDF Report
                </button>
            </div>
        </div>

        <!-- Navigation Tabs -->
        <div class="nav-tabs-custom">
            <button type="button" class="tab-link-custom active" id="tab_daily" onclick="switchReportTab('daily')">
                <i class="fa fa-calendar-check-o"></i> Daily OD Report
            </button>
            <button type="button" class="tab-link-custom" id="tab_monthly" onclick="switchReportTab('monthly')">
                <i class="fa fa-calendar"></i> Monthly OD Report
            </button>
            <button type="button" class="tab-link-custom" id="tab_employee" onclick="switchReportTab('employee')">
                <i class="fa fa-user"></i> Employee-wise History
            </button>
            <button type="button" class="tab-link-custom" id="tab_department" onclick="switchReportTab('department')">
                <i class="fa fa-sitemap"></i> Department-wise Summary
            </button>
            <button type="button" class="tab-link-custom" id="tab_branch" onclick="switchReportTab('branch')">
                <i class="fa fa-building-o"></i> Branch-wise Summary
            </button>
        </div>

        <!-- Dynamic Filter Controls -->
        <div class="filter-card">
            <div class="filter-grid" id="filter_grid_container">
                <!-- Filter fields dynamically tailored by active tab -->
            </div>
        </div>

        <!-- Report Table Card -->
        <div class="table-card">
            <div class="table-responsive-custom">
                <table class="table-od" id="reportTable">
                    <thead id="reportTableHead"></thead>
                    <tbody id="reportTableBody">
                        <tr>
                            <td style="text-align:center; padding:30px; color:#64748b;">
                                <i class="fa fa-spinner fa-spin"></i> Loading report data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <div>Total Records: <strong id="lbl_report_total">0</strong></div>
                <div>Outside Duty (OD) Management System</div>
            </div>
        </div>

    </div>

<script>
var activeTab = 'daily';

function switchReportTab(tab) {
    activeTab = tab;
    $('.tab-link-custom').removeClass('active');
    $('#tab_' + tab).addClass('active');
    renderFilterInputs();
    fetchReportData();
}

function renderFilterInputs() {
    var html = '';
    var unitOptions = '<?= !empty($units) ? addslashes(implode('', array_map(function($u){ return "<option value='{$u->unit_id}'>".htmlspecialchars($u->unit_name)."</option>"; }, $units))) : "" ?>';
    var deptOptions = '<?= !empty($departments) ? addslashes(implode('', array_map(function($d){ return "<option value='{$d->dept_id}'>".htmlspecialchars($d->dept_name)."</option>"; }, $departments))) : "" ?>';

    if (activeTab === 'daily') {
        html += '<div class="filter-group"><label>Report Date</label><input type="date" class="filter-input" id="rpt_date" value="<?= date('Y-m-d') ?>"></div>';
        <?php if (empty($unit_id) || $unit_id === 'All'): ?>
        html += '<div class="filter-group"><label>Branch / Unit</label><select class="filter-input" id="rpt_unit"><option value="">-- All Units --</option>' + unitOptions + '</select></div>';
        <?php endif; ?>
        html += '<div class="filter-group"><label>Department</label><select class="filter-input" id="rpt_dept"><option value="">-- All Departments --</option>' + deptOptions + '</select></div>';
    } else if (activeTab === 'monthly') {
        html += '<div class="filter-group"><label>Report Month</label><input type="month" class="filter-input" id="rpt_month" value="<?= date('Y-m') ?>"></div>';
        <?php if (empty($unit_id) || $unit_id === 'All'): ?>
        html += '<div class="filter-group"><label>Branch / Unit</label><select class="filter-input" id="rpt_unit"><option value="">-- All Units --</option>' + unitOptions + '</select></div>';
        <?php endif; ?>
        html += '<div class="filter-group"><label>Department</label><select class="filter-input" id="rpt_dept"><option value="">-- All Departments --</option>' + deptOptions + '</select></div>';
    } else if (activeTab === 'employee') {
        html += '<div class="filter-group"><label>Employee ID <span style="color:#ef4444;">*</span></label><input type="text" class="filter-input" id="rpt_emp_id" placeholder="Enter Emp ID (e.g. 2001)"></div>';
        html += '<div class="filter-group"><label>From Date</label><input type="date" class="filter-input" id="rpt_from_date"></div>';
        html += '<div class="filter-group"><label>To Date</label><input type="date" class="filter-input" id="rpt_to_date"></div>';
    } else {
        html += '<div class="filter-group"><label>From Date</label><input type="date" class="filter-input" id="rpt_from_date" value="<?= date('Y-m-01') ?>"></div>';
        html += '<div class="filter-group"><label>To Date</label><input type="date" class="filter-input" id="rpt_to_date" value="<?= date('Y-m-t') ?>"></div>';
    }

    html += '<div class="filter-group"><button type="button" class="btn-filter-apply" onclick="fetchReportData()"><i class="fa fa-filter"></i> Generate Report</button></div>';

    $('#filter_grid_container').html(html);
}

function getFilterParams() {
    return {
        report_type: activeTab,
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
    var params = getFilterParams();

    $('#reportTableBody').html('<tr><td colspan="10" style="text-align:center; padding:30px; color:#64748b;"><i class="fa fa-spinner fa-spin"></i> Generating report...</td></tr>');

    $.ajax({
        url: '<?= base_url("od_management_con/report_data_ajax") ?>',
        type: 'POST',
        data: params,
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success') {
                renderReportTable(res.data);
            }
        }
    });
}

function renderReportTable(data) {
    data = data || [];
    $('#lbl_report_total').text(data.length);

    if (activeTab === 'daily') {
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
                    '<td><strong>' + r.od_date + '</strong></td>' +
                    '<td><span style="font-weight:700; color:#4f46e5;">' + r.emp_id + '</span></td>' +
                    '<td><span style="font-weight:600;">' + (r.name_en || '-') + '</span></td>' +
                    '<td>' + (r.dept_name || '-') + '</td>' +
                    '<td>' + (r.desig_name || '-') + '</td>' +
                    '<td>' + r.purpose + '</td>' +
                    '<td><i class="fa fa-map-marker" style="color:#ef4444;"></i> ' + r.location + '</td>' +
                    '<td>' + (r.departure_time ? r.departure_time + ' - ' + (r.return_time || '-') : 'Full Day') + '</td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#e0f2fe; color:#0369a1; font-weight:700;">OD</span></td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeTab === 'monthly') {
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
                    '<td><span style="font-weight:700; color:#4f46e5;">' + r.emp_id + '</span></td>' +
                    '<td><span style="font-weight:600;">' + (r.name_en || '-') + '</span></td>' +
                    '<td>' + (r.dept_name || '-') + '</td>' +
                    '<td>' + (r.desig_name || '-') + '</td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#dcfce7; color:#15803d; font-size:13px; font-weight:700;">' + r.total_od_days + ' Days</span></td>' +
                    '<td><small style="color:#475569;">' + (r.od_dates || '-') + '</small></td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeTab === 'employee') {
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
                    '<td><strong>' + r.od_date + '</strong></td>' +
                    '<td>' + r.emp_id + '</td>' +
                    '<td>' + (r.name_en || '-') + '</td>' +
                    '<td>' + r.purpose + '</td>' +
                    '<td>' + r.location + '</td>' +
                    '<td><span class="badge" style="background:#e0f2fe; color:#0369a1;">' + (r.date_status || 'approved') + '</span></td>' +
                    '<td>' + (r.departure_time || '-') + ' / ' + (r.return_time || '-') + '</td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeTab === 'department') {
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
                    '<td><strong style="color:#0f172a;">' + (r.dept_name || 'Unassigned') + '</strong></td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:12px;">' + r.total_od_days + ' Days</span></td>' +
                    '<td style="text-align:center;">' + r.emp_count + ' Employees</td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    } else if (activeTab === 'branch') {
        $('#reportTableHead').html('<tr><th style="width:45px;">SL</th><th>Branch / Unit Name</th><th style="text-align:center;">Total OD Days</th><th style="text-align:center;">Total Employees Count</th></tr>');
        if (data.length === 0) {
            $('#reportTableBody').html('<tr><td colspan="4" style="text-align:center; padding:30px; color:#64748b;">No branch records.</td></tr>');
            return;
        }
        var html = '';
        var sl = 1;
        data.forEach(function(r) {
            html += '<tr>' +
                    '<td>' + (sl++) + '</td>' +
                    '<td><strong style="color:#0f172a;">' + (r.unit_name || 'Main Unit') + '</strong></td>' +
                    '<td style="text-align:center;"><span class="badge" style="background:#e0f2fe; color:#0369a1; font-size:12px;">' + r.total_od_days + ' Days</span></td>' +
                    '<td style="text-align:center;">' + r.emp_count + ' Employees</td>' +
                    '</tr>';
        });
        $('#reportTableBody').html(html);
    }
}

function exportReport(format) {
    var p = getFilterParams();
    p.type = activeTab;
    var q = $.param(p);
    if (format === 'excel') {
        window.location.href = '<?= base_url("od_management_con/export_excel") ?>?' + q;
    } else {
        window.open('<?= base_url("od_management_con/export_pdf") ?>?' + q, '_blank');
    }
}

$(document).ready(function() {
    renderFilterInputs();
    fetchReportData();
});
</script>
