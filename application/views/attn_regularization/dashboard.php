<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
body,
.page-container,
.page-content,
.reg-wrapper,
.page-content .reg-wrapper,
.page-content .content.reg-wrapper {
    background: #ffffff !important;
    background-color: #ffffff !important;
}
.reg-wrapper,
.page-content .reg-wrapper,
.page-content .content.reg-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 50px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    min-height: calc(100vh - 100px);
}
.reg-header-card {
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
.reg-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.reg-header-icon {
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
.reg-header-text h2 {
    margin: 0 0 4px 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
}
.reg-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}

/* Filter Card */
.reg-filter-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 18px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
}
.filter-row {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    width: 100%;
}
.filter-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    flex: 1;
    min-width: 0;
}
.filter-group.filter-actions {
    flex: 0 0 auto;
    flex-direction: row;
    gap: 5px;
}
.filter-group label {
    font-size: 10.5px;
    font-weight: 700;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin: 0;
    white-space: nowrap;
}
.filter-group .form-control {
    height: 36px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    font-size: 12.5px;
    padding: 6px 8px;
    width: 100%;
}
.quick-date-btn {
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 4px;
    border: 1px solid #cbd5e1;
    background: #f8fafc;
    color: #475569;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.15s;
}
.quick-date-btn:hover {
    background: #e2e8f0;
    color: #0f172a;
}

/* Stat Grid - Exactly One Single Line */
.reg-stat-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 10px;
    margin-bottom: 20px;
}
@media (max-width: 1200px) {
    .filter-row {
        flex-wrap: wrap;
    }
}
@media (max-width: 992px) {
    .reg-stat-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 576px) {
    .reg-stat-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
.reg-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 10px 12px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.02);
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    min-width: 0;
    transition: transform 0.15s, box-shadow 0.15s, border-color 0.15s;
}
.reg-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.06);
    border-color: #0284c7;
}
.reg-stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.reg-stat-info {
    min-width: 0;
    overflow: hidden;
}
.reg-stat-info h4 {
    margin: 0 0 1px 0;
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1.1;
}
.reg-stat-info p {
    margin: 0;
    font-size: 10px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}


/* Card & Table */
.reg-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
    overflow: hidden;
}
.reg-card-header {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafbfc;
    flex-wrap: wrap;
    gap: 10px;
}
.reg-card-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.table-issue-head th {
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 12px 14px !important;
    border-bottom: 2px solid #e2e8f0 !important;
    cursor: pointer;
    user-select: none;
    white-space: nowrap;
}
.table-issue-head th:hover {
    background: #f1f5f9;
    color: #0f172a;
}
.table-issue-head th .sort-icon {
    font-size: 10px;
    margin-left: 4px;
    color: #94a3b8;
}
.table-issues-body td {
    padding: 12px 14px !important;
    vertical-align: middle !important;
    font-size: 13px;
    border-bottom: 1px solid #f1f5f9;
}
.table-issues-body tr:hover td {
    background-color: #f8fafc;
}

/* Badges */
.badge-issue {
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
    white-space: nowrap;
}
.badge-late { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
.badge-early { background: #ffedd5; color: #ea580c; border: 1px solid #fed7aa; }
.badge-punch { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.badge-waived { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-weight: 700; }
.badge-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }

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
.punch-pill {
    display: inline-block;
    padding: 2px 6px;
    border-radius: 4px;
    font-family: monospace;
    font-size: 11.5px;
    font-weight: 600;
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
}
.punch-pill.punch-zero {
    color: #dc2626;
    background: #fff1f2;
    border-color: #ffe4e6;
}
.btn-reg-edit {
    height: 32px;
    padding: 5px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
    color: #ffffff !important;
    border: 1px solid #0284c7 !important;
    box-shadow: 0 2px 6px rgba(2, 132, 199, 0.3) !important;
    cursor: pointer;
    white-space: nowrap;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.btn-reg-edit i {
    font-size: 13px;
    color: #ffffff !important;
}
.btn-reg-edit:hover,
.btn-reg-edit:focus {
    background: linear-gradient(135deg, #0369a1 0%, #075985 100%) !important;
    border-color: #0369a1 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.45) !important;
    transform: translateY(-1px);
}
.btn-reg-edit.btn-reg-saved {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
    border-color: #059669 !important;
    box-shadow: 0 2px 6px rgba(16, 185, 129, 0.3) !important;
}
.btn-reg-edit.btn-reg-saved:hover,
.btn-reg-edit.btn-reg-saved:focus {
    background: linear-gradient(135deg, #047857 0%, #059669 100%) !important;
    border-color: #047857 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.45) !important;
}

/* Modal Styling */
.modal-reg .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 16px 22px;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}
.modal-reg .modal-content {
    border-radius: 12px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.modal-emp-info {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 16px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px;
    font-size: 12.5px;
}
.modal-emp-info div strong {
    color: #475569;
    font-size: 11px;
    text-transform: uppercase;
    display: block;
    margin-bottom: 2px;
}
.detected-punch-banner {
    background: #fffbeb;
    border: 1px solid #fef3c7;
    border-left: 4px solid #f59e0b;
    border-radius: 6px;
    padding: 10px 14px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    font-size: 12.5px;
    color: #92400e;
}
</style>

<div class="content reg-wrapper">
    <!-- Header -->
    <div class="reg-header-card">
        <div class="reg-header-left">
            <div class="reg-header-icon">
                <i class="fa fa-calendar-check-o"></i>
            </div>
            <div class="reg-header-text">
                <h2>Attendance Regularization</h2>
            </div>
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
            <a href="<?= base_url('attn_regularization/reports') ?>" class="btn btn-default" style="height:36px; padding:6px 14px; border-radius:6px; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa fa-file-text-o text-info"></i> Regularization Report
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="reg-filter-card">
        <form id="filter_form" method="post" action="<?= base_url('attn_regularization/dashboard') ?>" class="filter-row">
            <?php if (isset($this->security)) { ?>
                <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <?php } ?>
            <div class="filter-group">
                <label>From Date</label>
                <input type="date" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($filters['start_date']) ?>">
            </div>

            <div class="filter-group">
                <label>To Date</label>
                <input type="date" id="end_date" name="end_date" class="form-control" value="<?= htmlspecialchars($filters['end_date']) ?>">
            </div>

            <div class="filter-group">
                <label>Unit</label>
                <select name="unit_id" id="unit_id" class="form-control">
                    <option value="">All Units</option>
                    <?php if (!empty($units)) { foreach ($units as $u) { ?>
                        <option value="<?= $u->unit_id ?>" <?= ($filters['unit_id'] == $u->unit_id) ? 'selected' : '' ?>><?= $u->unit_name ?></option>
                    <?php }} ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Department</label>
                <select name="dept_id" id="dept_id" class="form-control">
                    <option value="">All Departments</option>
                    <?php if (!empty($departments)) { foreach ($departments as $d) { ?>
                        <option value="<?= $d->dept_id ?>" <?= ($filters['dept_id'] == $d->dept_id) ? 'selected' : '' ?>><?= $d->dept_name ?></option>
                    <?php }} ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Issue Type</label>
                <select name="issue_type" id="issue_type" class="form-control">
                    <option value="all" <?= ($filters['issue_type'] === 'all') ? 'selected' : '' ?>>All Exceptions</option>
                    <option value="late" <?= ($filters['issue_type'] === 'late') ? 'selected' : '' ?>>Late Entries</option>
                    <option value="early_out" <?= ($filters['issue_type'] === 'early_out') ? 'selected' : '' ?>>Early Outs</option>
                    <option value="missing_out" <?= ($filters['issue_type'] === 'missing_out') ? 'selected' : '' ?>>Missing Out</option>
                    <option value="pending" <?= ($filters['issue_type'] === 'pending') ? 'selected' : '' ?>>Pending Action</option>
                    <option value="regularized" <?= ($filters['issue_type'] === 'regularized') ? 'selected' : '' ?>>Waived / Saved</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Search Employee</label>
                <input type="text" name="search" id="search_emp" class="form-control" placeholder="Emp ID or Name..." value="<?= htmlspecialchars($filters['emp_id']) ?>">
            </div>

            <div class="filter-group filter-actions">
                <button type="submit" class="btn btn-primary" style="height:36px; padding:6px 14px; border-radius:6px; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:5px;">
                    <i class="fa fa-filter"></i> Filter
                </button>
                <a href="<?= base_url('attn_regularization/dashboard?reset=1') ?>" class="btn btn-default" style="height:36px; padding:6px 12px; border-radius:6px; font-size:13px; display:inline-flex; align-items:center;" title="Reset Filter">
                    <i class="fa fa-refresh"></i>
                </a>
            </div>
        </form>

        <!-- Quick Date Range Presets -->
        <div style="display:flex; align-items:center; gap:8px; margin-top:12px; flex-wrap:wrap;">
            <span style="font-size:11px; font-weight:700; color:#64748b; text-transform:uppercase;">Quick Presets:</span>
            <button type="button" class="quick-date-btn" onclick="setDatePreset('<?= $latest_date ?>', '<?= $latest_date ?>')">
                <i class="fa fa-calendar-check-o text-primary"></i> Latest Date (<?= date('d M Y', strtotime($latest_date)) ?>)
            </button>
            <button type="button" class="quick-date-btn" onclick="setDatePreset('<?= date('Y-m-d') ?>', '<?= date('Y-m-d') ?>')">
                Today
            </button>
            <button type="button" class="quick-date-btn" onclick="setDatePreset('<?= date('Y-m-d', strtotime('-1 day')) ?>', '<?= date('Y-m-d', strtotime('-1 day')) ?>')">
                Yesterday
            </button>
            <button type="button" class="quick-date-btn" onclick="setDatePreset('<?= date('Y-m-d', strtotime('-7 days')) ?>', '<?= date('Y-m-d') ?>')">
                Last 7 Days
            </button>
            <button type="button" class="quick-date-btn" onclick="setDatePreset('<?= date('Y-m-01') ?>', '<?= date('Y-m-d') ?>')">
                This Month
            </button>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="reg-stat-grid">
        <div class="reg-stat-card" onclick="filterByIssue('all')">
            <div class="reg-stat-icon" style="background:#e0f2fe; color:#0284c7;">
                <i class="fa fa-exclamation-circle"></i>
            </div>
            <div class="reg-stat-info">
                <h4 id="stat_total"><?= number_format($stats['total_issues']) ?></h4>
                <p>Total Issues</p>
            </div>
        </div>

        <div class="reg-stat-card" onclick="filterByIssue('late')">
            <div class="reg-stat-icon" style="background:#fee2e2; color:#dc2626;">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="reg-stat-info">
                <h4 id="stat_late"><?= number_format($stats['total_late']) ?></h4>
                <p>Late Entries</p>
            </div>
        </div>

        <div class="reg-stat-card" onclick="filterByIssue('early_out')">
            <div class="reg-stat-icon" style="background:#ffedd5; color:#ea580c;">
                <i class="fa fa-sign-out"></i>
            </div>
            <div class="reg-stat-info">
                <h4 id="stat_early"><?= number_format($stats['total_early_out']) ?></h4>
                <p>Early Outs</p>
            </div>
        </div>

        <div class="reg-stat-card" onclick="filterByIssue('missing_out')">
            <div class="reg-stat-icon" style="background:#fef3c7; color:#d97706;">
                <i class="fa fa-question-circle"></i>
            </div>
            <div class="reg-stat-info">
                <h4 id="stat_missing"><?= number_format($stats['total_missing_out']) ?></h4>
                <p>Missing Out / Punch</p>
            </div>
        </div>

        <div class="reg-stat-card" onclick="filterByIssue('regularized')">
            <div class="reg-stat-icon" style="background:#dcfce7; color:#16a34a;">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="reg-stat-info">
                <h4 id="stat_waived"><?= number_format($stats['total_regularized']) ?></h4>
                <p>Waived / Saved</p>
            </div>
        </div>

        <div class="reg-stat-card" onclick="filterByIssue('pending')">
            <div class="reg-stat-icon" style="background:#f1f5f9; color:#475569;">
                <i class="fa fa-hourglass-half"></i>
            </div>
            <div class="reg-stat-info">
                <h4 id="stat_pending"><?= number_format($stats['total_pending']) ?></h4>
                <p>Pending Action</p>
            </div>
        </div>
    </div>

    <!-- Exceptions & Issues Table Card -->
    <div class="reg-card">
        <div class="reg-card-header">
            <h3>
                <i class="fa fa-list text-primary"></i> Daily Attendance Exceptions & Issues 
                <span class="badge" style="background:#0284c7 !important; color:#ffffff !important; font-size:13px !important; font-weight:800 !important; padding:4px 11px !important; border-radius:14px !important; margin-left:8px; display:inline-block !important; vertical-align:middle !important; line-height:1.2 !important; text-shadow:none !important; box-shadow:0 2px 5px rgba(2, 132, 199, 0.35) !important;" id="table_badge_count"><?= count($issues_list) ?></span>
            </h3>
            <div style="display:flex; align-items:center; gap:10px;">
                <input type="text" id="table_search_input" class="form-control" placeholder="Quick filter in table..." style="width:200px; height:32px; font-size:12px; border-radius:6px;">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table" id="issues_table" style="margin-bottom:0;">
                <thead class="table-issue-head">
                    <tr>
                        <th style="width:50px;" onclick="sortTable(0, 'num')">SL <i class="fa fa-sort sort-icon"></i></th>
                        <th style="width:105px;" onclick="sortTable(1, 'date')">Date <i class="fa fa-sort sort-icon"></i></th>
                        <th style="min-width:180px;" onclick="sortTable(2, 'str')">Employee <i class="fa fa-sort sort-icon"></i></th>
                        <th style="min-width:150px;" onclick="sortTable(3, 'str')">Dept / Designation <i class="fa fa-sort sort-icon"></i></th>
                        <th style="min-width:150px;">Shift Schedule</th>
                        <th style="min-width:140px;" onclick="sortTable(5, 'str')">Punch (In / Out) <i class="fa fa-sort sort-icon"></i></th>
                        <th style="min-width:160px;" onclick="sortTable(6, 'str')">Detected Issue <i class="fa fa-sort sort-icon"></i></th>
                        <th style="min-width:170px;" onclick="sortTable(7, 'str')">Remark & Waiver <i class="fa fa-sort sort-icon"></i></th>
                        <th style="width:130px; text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody class="table-issues-body" id="issues_tbody">
                    <?php if (!empty($issues_list)) { 
                        $sl = 1;
                        foreach ($issues_list as $row) { 
                            $is_waived = ($row->is_waived == 1 || $row->reg_waived == 1);
                            $has_reg = (!empty($row->reg_id) || !empty($row->log_remarks) || $row->is_waived == 1);
                    ?>
                        <tr id="row_<?= $row->emp_id ?>_<?= $row->shift_log_date ?>" data-emp-id="<?= $row->emp_id ?>" data-date="<?= $row->shift_log_date ?>">
                            <td style="font-weight:600; color:#64748b;"><?= $sl++ ?></td>
                            <td style="font-weight:600;">
                                <?= date('d-m-Y', strtotime($row->shift_log_date)) ?>
                            </td>
                            <td>
                                <div><span class="emp-badge"><?= $row->emp_id ?></span> <strong style="color:#0f172a; margin-left:4px;"><?= htmlspecialchars($row->name_en) ?></strong></div>
                                <?php if (!empty($row->unit_name)) { ?>
                                    <small style="color:#64748b;"><?= htmlspecialchars($row->unit_name) ?></small>
                                <?php } ?>
                            </td>
                            <td style="color:#475569;">
                                <strong><?= htmlspecialchars($row->dept_name ?: 'N/A') ?></strong>
                                <br><small style="color:#64748b;"><?= htmlspecialchars($row->desig_name ?: '') ?></small>
                            </td>
                            <td>
                                <strong style="font-size:12px;"><?= htmlspecialchars($row->shift_name ?: 'General') ?></strong>
                                <br><small style="color:#64748b; font-family:monospace;">
                                    In: <?= $row->sch_in_time ?: '--:--' ?> | Out: <?= $row->out_start ?: '--:--' ?>
                                </small>
                            </td>
                            <td>
                                <div style="display:flex; flex-direction:column; gap:3px;">
                                    <span>In: <span class="punch-pill <?= ($row->in_time == '00:00:00' || empty($row->in_time)) ? 'punch-zero' : '' ?>"><?= $row->in_time ?: '--:--:--' ?></span></span>
                                    <span>Out: <span class="punch-pill <?= ($row->out_time == '00:00:00' || empty($row->out_time)) ? 'punch-zero' : '' ?>" id="out_pill_<?= $row->emp_id ?>_<?= $row->shift_log_date ?>"><?= $row->out_time ?: '--:--:--' ?></span></span>
                                </div>
                            </td>
                            <td>
                                <?php if ($row->detected_issue === 'punch_error' || !empty($row->detected_raw_punch)) { ?>
                                    <span class="badge-issue badge-punch">
                                        <i class="fa fa-exclamation-triangle"></i> <?= htmlspecialchars($row->detected_issue_label) ?>
                                    </span>
                                    <br><small style="color:#b45309; font-weight:600;">Punch: <?= $row->detected_raw_punch ?></small>
                                <?php } elseif ($row->detected_issue === 'late') { ?>
                                    <span class="badge-issue badge-late">
                                        <i class="fa fa-clock-o"></i> <?= htmlspecialchars($row->detected_issue_label) ?>
                                    </span>
                                <?php } elseif ($row->detected_issue === 'early_out') { ?>
                                    <span class="badge-issue badge-early">
                                        <i class="fa fa-sign-out"></i> <?= htmlspecialchars($row->detected_issue_label) ?>
                                    </span>
                                <?php } elseif ($row->detected_issue === 'missing_out') { ?>
                                    <span class="badge-issue badge-punch">
                                        <i class="fa fa-question-circle"></i> Missing Out Time
                                    </span>
                                <?php } else { ?>
                                    <span class="badge-issue" style="background:#f1f5f9; color:#475569;">General</span>
                                <?php } ?>
                                <br><small style="color:#64748b; font-size:11px;"><?= htmlspecialchars($row->detected_issue_details) ?></small>
                            </td>
                            <td id="status_cell_<?= $row->emp_id ?>_<?= $row->shift_log_date ?>">
                                <?php if ($is_waived) { ?>
                                    <span class="badge-issue badge-waived"><i class="fa fa-check"></i> Waived (No Cut)</span>
                                <?php } elseif ($has_reg) { ?>
                                    <span class="badge-issue" style="background:#e0f2fe; color:#0284c7;"><i class="fa fa-info-circle"></i> Regularized</span>
                                <?php } else { ?>
                                    <span class="badge-issue badge-pending"><i class="fa fa-clock-o"></i> Pending</span>
                                <?php } ?>

                                <?php 
                                    $remark_text = !empty($row->reg_remarks) ? $row->reg_remarks : (!empty($row->log_remarks) ? $row->log_remarks : '');
                                    if (!empty($row->reg_reason)) {
                                        $remark_text = $row->reg_reason . (!empty($remark_text) ? ': ' . $remark_text : '');
                                    }
                                    if (!empty($remark_text)) {
                                ?>
                                    <div style="color:#334155; font-size:12px; margin-top:3px; word-break:break-word;">
                                        <strong>Remark:</strong> <?= htmlspecialchars($remark_text) ?>
                                    </div>
                                <?php } ?>
                            </td>
                            <td style="text-align:center;">
                                <button type="button" class="btn-reg-edit <?= ($is_waived || $has_reg) ? 'btn-reg-saved' : '' ?>" id="btn_edit_<?= $row->emp_id ?>_<?= $row->shift_log_date ?>" onclick="openRegularizeModal('<?= $row->emp_id ?>', '<?= $row->shift_log_date ?>')">
                                    <i class="fa <?= ($is_waived || $has_reg) ? 'fa-check-circle' : 'fa-pencil-square-o' ?>"></i> Edit / Remark
                                </button>
                            </td>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td colspan="9" style="text-align:center; padding:40px; color:#94a3b8;">
                                <i class="fa fa-check-circle-o" style="font-size:32px; color:#10b981; margin-bottom:8px; display:block;"></i>
                                <strong>No attendance issues found for this selection!</strong>
                                <p style="font-size:12px; margin-top:4px;">Try changing the date range or filters above.</p>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal: Quick Regularization & Remark -->
<div class="modal fade modal-reg" id="modal_regularize" tabindex="-1" role="dialog" aria-labelledby="modal_regularize_label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <form id="form_quick_regularize">
                <input type="hidden" id="modal_emp_id" name="emp_id">
                <input type="hidden" id="modal_att_date" name="att_date">
                <input type="hidden" id="modal_unit_id" name="unit_id" value="1">
                <input type="hidden" id="modal_issue_type" name="issue_type" value="late">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size:24px; color:#64748b;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modal_regularize_label" style="font-weight:700; color:#0f172a; display:flex; align-items:center; gap:8px;">
                        <i class="fa fa-pencil-square-o text-primary"></i> Attendance Regularization & Remark
                    </h4>
                </div>

                <div class="modal-body" style="padding:20px 24px;">
                    <!-- Employee Info Card -->
                    <div class="modal-emp-info">
                        <div>
                            <strong>Employee</strong>
                            <span id="m_emp_name">--</span> (<span id="m_emp_id">--</span>)
                        </div>
                        <div>
                            <strong>Department & Shift</strong>
                            <span id="m_emp_dept">--</span> | <span id="m_shift_name">--</span>
                        </div>
                        <div>
                            <strong>Date</strong>
                            <span id="m_att_date">--</span>
                        </div>
                        <div>
                            <strong>Schedule In / Out-Start</strong>
                            <span id="m_sch_times" style="font-family:monospace;">--</span>
                        </div>
                    </div>

                    <!-- Detected Punch Alert (if punched before schedule out_start) -->
                    <div id="m_detected_punch_box" class="detected-punch-banner" style="display:none;">
                        <div>
                            <i class="fa fa-magic"></i> 
                            <strong>Biometric Punch Detected: <span id="m_detected_punch_time"></span></strong>
                            <div style="font-size:11.5px; opacity:0.9;">Employee punched machine before schedule out-start time.</div>
                        </div>
                        <button type="button" class="btn btn-warning btn-xs" style="font-weight:700; white-space:nowrap;" onclick="applyDetectedPunch()">
                            <i class="fa fa-arrow-down"></i> Set as Out Time
                        </button>
                    </div>

                    <!-- Punch Time Adjustments -->
                    <div class="row" style="margin-bottom:14px;">
                        <div class="col-xs-6">
                            <label style="font-size:12px; font-weight:700; color:#334155;">Punch In Time</label>
                            <input type="time" step="1" id="m_in_time" name="adjusted_in_time" class="form-control" style="border-radius:6px; font-family:monospace;">
                        </div>
                        <div class="col-xs-6">
                            <label style="font-size:12px; font-weight:700; color:#334155;">Punch Out Time</label>
                            <input type="time" step="1" id="m_out_time" name="adjusted_out_time" class="form-control" style="border-radius:6px; font-family:monospace;">
                        </div>
                    </div>

                    <!-- Reason Category -->
                    <div class="form-group" style="margin-bottom:14px;">
                        <label style="font-size:12px; font-weight:700; color:#334155;">Reason / Category <span class="text-danger">*</span></label>
                        <select id="m_reason_type" name="reason_type" class="form-control" style="border-radius:6px; font-size:13px;" required>
                            <option value="Official Duty / Field Work">Official Duty / Field Work</option>
                            <option value="Machine / Biometric Punch Error">Machine / Biometric Punch Error</option>
                            <option value="Early Departure with Permission">Early Departure with Permission</option>
                            <option value="Late Arrival with Permission">Late Arrival with Permission</option>
                            <option value="Transport / Traffic Delay">Transport / Traffic Delay</option>
                            <option value="Medical / Emergency">Medical / Emergency</option>
                            <option value="Management Approval">Management Approval</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <!-- Remark Text -->
                    <div class="form-group" style="margin-bottom:16px;">
                        <label style="font-size:12px; font-weight:700; color:#334155;">Remark / Note <span class="text-danger">*</span></label>
                        <textarea id="m_remarks" name="remarks" class="form-control" rows="3" placeholder="Provide remark / justification here (e.g. Left early with HOD permission, punch machine failed, etc.)..." style="border-radius:6px; font-size:13px;" required></textarea>
                        <small style="color:#64748b; font-size:11px;">This remark will be permanently displayed on Job Card and Attendance reports.</small>
                    </div>

                    <input type="hidden" id="m_waive_deduction" name="waive_deduction" value="1">
                </div>

                <div class="modal-footer" style="background:#f8fafc; border-top:1px solid #e2e8f0; padding:14px 22px; border-bottom-left-radius:12px; border-bottom-right-radius:12px; display:flex; justify-content:flex-end; gap:8px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius:6px; font-weight:600; padding:6px 16px;">Cancel</button>
                    <button type="submit" id="btn_save_reg" class="btn btn-primary" style="border-radius:6px; font-weight:700; padding:6px 20px; display:inline-flex; align-items:center; gap:6px;">
                        <i class="fa fa-check"></i> Save Remark
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var detectedPunchTime = '';

// Quick Date Range Presets
function setDatePreset(start, end) {
    document.getElementById('start_date').value = start;
    document.getElementById('end_date').value = end;
    document.getElementById('filter_form').submit();
}

// Filter by Issue clicking KPI cards
function filterByIssue(type) {
    document.getElementById('issue_type').value = type;
    document.getElementById('filter_form').submit();
}

// Table live search filter
document.getElementById('table_search_input').addEventListener('input', function() {
    var val = this.value.toLowerCase().trim();
    var rows = document.querySelectorAll('#issues_tbody tr');
    var visibleCount = 0;
    rows.forEach(function(row) {
        var text = row.innerText.toLowerCase();
        if (text.indexOf(val) > -1) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    var badge = document.getElementById('table_badge_count');
    if (badge) badge.innerText = visibleCount;
});

// Interactive Table Sorting
var sortDirections = {};
function sortTable(columnIndex, type) {
    var table = document.getElementById('issues_table');
    var tbody = document.getElementById('issues_tbody');
    var rows = Array.from(tbody.querySelectorAll('tr'));
    if (rows.length <= 1) return;

    var dir = sortDirections[columnIndex] === 'asc' ? 'desc' : 'asc';
    sortDirections[columnIndex] = dir;

    rows.sort(function(a, b) {
        var aCol = a.children[columnIndex] ? a.children[columnIndex].innerText.trim() : '';
        var bCol = b.children[columnIndex] ? b.children[columnIndex].innerText.trim() : '';

        if (type === 'num') {
            var aNum = parseFloat(aCol.replace(/[^0-9.-]+/g, '')) || 0;
            var bNum = parseFloat(bCol.replace(/[^0-9.-]+/g, '')) || 0;
            return dir === 'asc' ? aNum - bNum : bNum - aNum;
        } else if (type === 'date') {
            var parseDate = function(dStr) {
                var p = dStr.split('-');
                return p.length === 3 ? new Date(p[2], p[1] - 1, p[0]).getTime() : 0;
            };
            return dir === 'asc' ? parseDate(aCol) - parseDate(bCol) : parseDate(bCol) - parseDate(aCol);
        } else {
            return dir === 'asc' ? aCol.localeCompare(bCol) : bCol.localeCompare(aCol);
        }
    });

    rows.forEach(function(r) { tbody.appendChild(r); });

    // Update icons
    var headers = table.querySelectorAll('thead th i.sort-icon');
    headers.forEach(function(icon) { icon.className = 'fa fa-sort sort-icon'; });
    var clickedIcon = table.querySelectorAll('thead th')[columnIndex].querySelector('i.sort-icon');
    if (clickedIcon) {
        clickedIcon.className = dir === 'asc' ? 'fa fa-sort-asc sort-icon text-primary' : 'fa fa-sort-desc sort-icon text-primary';
    }
}

// Open Regularization & Remark Modal
function openRegularizeModal(empId, date) {
    // Show loading
    Swal.fire({
        title: 'Loading Issue Details...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    $.ajax({
        url: '<?= base_url("attn_regularization/get_issue_detail_ajax") ?>',
        type: 'GET',
        data: { emp_id: empId, date: date },
        dataType: 'json',
        success: function(resp) {
            Swal.close();
            if (resp.status !== 'success' || !resp.data) {
                Swal.fire('Error', resp.message || 'Unable to load details.', 'error');
                return;
            }

            var d = resp.data;
            var log = d.log || {};
            var reg = d.existing || null;

            document.getElementById('modal_emp_id').value = empId;
            document.getElementById('modal_att_date').value = date;
            document.getElementById('modal_unit_id').value = log.unit_id || 1;

            document.getElementById('m_emp_name').innerText = log.name_en || empId;
            document.getElementById('m_emp_id').innerText = empId;
            document.getElementById('m_emp_dept').innerText = log.dept_name || 'N/A';
            document.getElementById('m_shift_name').innerText = log.shift_name || 'General';
            document.getElementById('m_att_date').innerText = date;
            document.getElementById('m_sch_times').innerText = (log.sch_in_time || '--:--') + ' / ' + (log.out_start || '--:--');

            // Times
            document.getElementById('m_in_time').value = (log.in_time && log.in_time !== '00:00:00') ? log.in_time : '';
            document.getElementById('m_out_time').value = (log.out_time && log.out_time !== '00:00:00') ? log.out_time : '';

            // Check if detected uncaptured biometric punch exists
            detectedPunchTime = d.suggested_out_punch || '';
            var punchBox = document.getElementById('m_detected_punch_box');
            if (detectedPunchTime && (log.out_time === '00:00:00' || !log.out_time)) {
                document.getElementById('m_detected_punch_time').innerText = detectedPunchTime;
                punchBox.style.display = 'flex';
            } else {
                punchBox.style.display = 'none';
            }

            // Determine issue type
            var issueType = 'late';
            if (log.early_exit == 1) {
                issueType = 'early_out';
            } else if (log.in_time && log.in_time !== '00:00:00' && (!log.out_time || log.out_time === '00:00:00')) {
                issueType = 'punch_error';
            }
            if (reg && reg.issue_type) {
                issueType = reg.issue_type;
            }
            document.getElementById('modal_issue_type').value = issueType;

            // Pre-fill existing remarks if any
            var waiveEl = document.getElementById('m_waive_deduction');
            if (reg) {
                if (reg.reason_type) document.getElementById('m_reason_type').value = reg.reason_type;
                document.getElementById('m_remarks').value = reg.remarks || '';
                if (waiveEl) waiveEl.value = (reg.waive_deduction !== undefined && reg.waive_deduction !== null) ? reg.waive_deduction : '1';
                if (reg.adjusted_in_time) document.getElementById('m_in_time').value = reg.adjusted_in_time;
                if (reg.adjusted_out_time) document.getElementById('m_out_time').value = reg.adjusted_out_time;
            } else if (log.remarks) {
                document.getElementById('m_remarks').value = log.remarks;
                if (waiveEl) waiveEl.value = '1';
            } else {
                document.getElementById('m_remarks').value = '';
                if (waiveEl) waiveEl.value = '1';
                // Sensible default reason based on issue
                if (issueType === 'punch_error') {
                    document.getElementById('m_reason_type').value = 'Machine / Biometric Punch Error';
                } else if (issueType === 'early_out') {
                    document.getElementById('m_reason_type').value = 'Early Departure with Permission';
                } else {
                    document.getElementById('m_reason_type').value = 'Official Duty / Field Work';
                }
            }

            $('#modal_regularize').modal('show');
        },
        error: function() {
            Swal.fire('Error', 'Failed to communicate with server.', 'error');
        }
    });
}

// 1-Click Set detected raw punch as Out Time
function applyDetectedPunch() {
    if (detectedPunchTime) {
        document.getElementById('m_out_time').value = detectedPunchTime;
        document.getElementById('m_reason_type').value = 'Machine / Biometric Punch Error';
        if (!document.getElementById('m_remarks').value) {
            document.getElementById('m_remarks').value = 'Punch before schedule out-start accepted as out time (' + detectedPunchTime + ')';
        }
    }
}

// Submit Remark Form via AJAX
$('#form_quick_regularize').on('submit', function(e) {
    e.preventDefault();

    var btn = $('#btn_save_reg');
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    var formData = $(this).serialize();
    var empId = $('#modal_emp_id').value || $('#modal_emp_id').val();
    var attDate = $('#modal_att_date').value || $('#modal_att_date').val();

    $.ajax({
        url: '<?= base_url("attn_regularization/save_quick_remark_ajax") ?>',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(resp) {
            btn.prop('disabled', false).html('<i class="fa fa-check"></i> Save Remark');
            if (resp.status === 'success') {
                $('#modal_regularize').modal('hide');

                Swal.fire({
                    icon: 'success',
                    title: 'Remark Saved!',
                    text: resp.message || 'Penalty waived and shift log updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });

                // Real-time Row Update without full reload!
                var cellStatus = document.getElementById('status_cell_' + empId + '_' + attDate);
                if (cellStatus) {
                    var remarkStr = resp.data && resp.data.full_remark ? resp.data.full_remark : $('#m_remarks').val();
                    var isWaived = (resp.data && resp.data.is_waived !== undefined) ? (resp.data.is_waived == 1) : ($('#m_waive_deduction').val() == '1');

                    var badgeHtml = isWaived 
                        ? '<span class="badge-issue badge-waived"><i class="fa fa-check"></i> Waived (No Cut)</span>'
                        : '<span class="badge-issue" style="background:#e0f2fe; color:#0284c7;"><i class="fa fa-info-circle"></i> Regularized</span>';

                    badgeHtml += '<div style="color:#334155; font-size:12px; margin-top:3px; word-break:break-word;"><strong>Remark:</strong> ' + escapeHtml(remarkStr) + '</div>';
                    cellStatus.innerHTML = badgeHtml;
                }

                // Update the Edit / Remark button to saved state
                var btnEdit = document.getElementById('btn_edit_' + empId + '_' + attDate);
                if (btnEdit) {
                    btnEdit.className = 'btn-reg-edit btn-reg-saved';
                    btnEdit.innerHTML = '<i class="fa fa-check-circle"></i> Edit / Remark';
                }

                // If out time was updated, update the table out pill
                var outPill = document.getElementById('out_pill_' + empId + '_' + attDate);
                var newOut = $('#m_out_time').val();
                if (outPill && newOut) {
                    outPill.innerText = newOut;
                    outPill.classList.remove('punch-zero');
                }

                // Update KPI pending and waived counters
                var waivedStat = document.getElementById('stat_waived');
                var pendingStat = document.getElementById('stat_pending');
                if (waivedStat && pendingStat) {
                    var w = parseInt(waivedStat.innerText.replace(/,/g, '')) || 0;
                    var p = parseInt(pendingStat.innerText.replace(/,/g, '')) || 0;
                    waivedStat.innerText = (w + 1).toLocaleString();
                    if (p > 0) pendingStat.innerText = (p - 1).toLocaleString();
                }

            } else {
                Swal.fire('Error', resp.message || 'Failed to save remark.', 'error');
            }
        },
        error: function() {
            btn.prop('disabled', false).html('<i class="fa fa-check"></i> Save Remark');
            Swal.fire('Error', 'Server error occurred while saving remark.', 'error');
        }
    });
});

function escapeHtml(text) {
    if (!text) return '';
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

// Prevent browser "Confirm Form Resubmission" alert on reload (F5) and keep URL clean
if (window.history && window.history.replaceState) {
    window.history.replaceState(null, null, window.location.pathname);
}
</script>
