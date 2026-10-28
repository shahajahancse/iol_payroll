<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
.reg-wrapper,
.page-content .reg-wrapper,
.page-content .content.reg-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 50px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    background-color: transparent;
    min-height: calc(100vh - 100px);
}
.reg-header-card {
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
.reg-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
    overflow: hidden;
}
.reg-filter-bar {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 18px 20px;
}
.badge-issue {
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}
.badge-late { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; }
.badge-early { background: #ffedd5; color: #ea580c; border: 1px solid #fed7aa; }
.badge-punch { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
.badge-waived { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; font-weight: 700; }
.badge-not-waived { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
</style>

<div class="content reg-wrapper">
    <!-- Header -->
    <div class="reg-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px; box-shadow:0 4px 12px rgba(2,132,199,0.25);">
                <i class="fa fa-list"></i>
            </div>
            <div>
                <h2 style="margin:0 0 4px 0; font-size:20px; font-weight:700; color:#0f172a;">Attendance Regularization & Remark List</h2>
                <p style="margin:0; color:#64748b; font-size:13px;">View and audit all recorded attendance exceptions, remarks, and waiver statuses</p>
            </div>
        </div>
        <div style="display:flex; gap:10px;">
            <a href="<?= base_url('attn_regularization/dashboard') ?>" class="btn btn-primary" style="font-weight:600; padding:8px 18px; border-radius:6px;">
                <i class="fa fa-tachometer"></i> Dashboard
            </a>
            <a href="<?= base_url('attn_regularization/reports') ?>" class="btn btn-default" style="font-weight:600; padding:8px 18px; border-radius:6px;">
                <i class="fa fa-file-text-o"></i> View Reports
            </a>
        </div>
    </div>

    <!-- Main Card with Filters and Table -->
    <div class="reg-card">
        <!-- Filter Bar -->
        <div class="reg-filter-bar">
            <form method="get" action="<?= base_url('attn_regularization/list') ?>" class="row" style="margin:0; gap:0;">
                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">Unit</label>
                    <select name="unit_id" class="form-control input-sm" style="border-radius:6px;">
                        <option value="">All Units</option>
                        <?php if (!empty($units)) { foreach ($units as $u) { ?>
                            <option value="<?= $u->unit_id ?>" <?= (isset($filters['unit_id']) && $filters['unit_id'] == $u->unit_id) ? 'selected' : '' ?>><?= $u->unit_name ?></option>
                        <?php }} ?>
                    </select>
                </div>

                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">Issue Type</label>
                    <select name="issue_type" class="form-control input-sm" style="border-radius:6px;">
                        <option value="">All Issues</option>
                        <option value="late" <?= (isset($filters['issue_type']) && $filters['issue_type'] == 'late') ? 'selected' : '' ?>>Late Entry</option>
                        <option value="early_out" <?= (isset($filters['issue_type']) && $filters['issue_type'] == 'early_out') ? 'selected' : '' ?>>Early Out</option>
                        <option value="punch_error" <?= (isset($filters['issue_type']) && $filters['issue_type'] == 'punch_error') ? 'selected' : '' ?>>Punch Error</option>
                        <option value="general" <?= (isset($filters['issue_type']) && $filters['issue_type'] == 'general') ? 'selected' : '' ?>>General</option>
                    </select>
                </div>

                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">Waiver Status</label>
                    <select name="waive_deduction" class="form-control input-sm" style="border-radius:6px;">
                        <option value="">All Records</option>
                        <option value="1" <?= (isset($filters['waive_deduction']) && $filters['waive_deduction'] === '1') ? 'selected' : '' ?>>Waived (No Cut)</option>
                        <option value="0" <?= (isset($filters['waive_deduction']) && $filters['waive_deduction'] === '0') ? 'selected' : '' ?>>Deductible</option>
                    </select>
                </div>

                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">Emp ID</label>
                    <input type="text" name="emp_id" class="form-control input-sm" placeholder="e.g. 2001" value="<?= isset($filters['emp_id']) ? $filters['emp_id'] : '' ?>" style="border-radius:6px;">
                </div>

                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">From Date</label>
                    <input type="date" name="start_date" class="form-control input-sm" value="<?= isset($filters['start_date']) ? $filters['start_date'] : '' ?>" style="border-radius:6px;">
                </div>

                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">To Date</label>
                    <div style="display:flex; gap:6px;">
                        <input type="date" name="end_date" class="form-control input-sm" value="<?= isset($filters['end_date']) ? $filters['end_date'] : '' ?>" style="border-radius:6px;">
                        <button type="submit" class="btn btn-primary btn-sm" style="border-radius:6px;" title="Filter"><i class="fa fa-filter"></i></button>
                        <a href="<?= base_url('attn_regularization/list') ?>" class="btn btn-default btn-sm" style="border-radius:6px;" title="Reset"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom:0; font-size:13px;">
                <thead style="background:#f8fafc; color:#475569; font-size:12px; text-transform:uppercase;">
                    <tr>
                        <th style="padding:12px 16px;">#</th>
                        <th style="padding:12px 16px;">Date</th>
                        <th style="padding:12px 16px;">Employee</th>
                        <th style="padding:12px 16px;">Department / Desig</th>
                        <th style="padding:12px 16px;">Issue Type</th>
                        <th style="padding:12px 16px;">Reason & Remark</th>
                        <th style="padding:12px 16px;">Punch Times</th>
                        <th style="padding:12px 16px;">Waiver Status</th>
                        <th style="padding:12px 16px;">Created By</th>
                        <th style="padding:12px 16px; text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list)) { $i = 1; foreach ($list as $row) { ?>
                        <tr>
                            <td style="padding:12px 16px; color:#94a3b8;"><?= $i++ ?></td>
                            <td style="padding:12px 16px; font-weight:600;">
                                <?= date('d-m-Y', strtotime($row->att_date)) ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <strong style="color:#0284c7;"><?= $row->emp_id ?></strong><br>
                                <?= $row->name_en ?>
                            </td>
                            <td style="padding:12px 16px; color:#64748b;">
                                <?= $row->dept_name ?><br><small><?= $row->desig_name ?></small>
                            </td>
                            <td style="padding:12px 16px;">
                                <?php if ($row->issue_type === 'late') { ?>
                                    <span class="badge-issue badge-late"><i class="fa fa-clock-o"></i> Late Entry</span>
                                <?php } elseif ($row->issue_type === 'early_out') { ?>
                                    <span class="badge-issue badge-early"><i class="fa fa-sign-out"></i> Early Out</span>
                                <?php } elseif ($row->issue_type === 'punch_error') { ?>
                                    <span class="badge-issue badge-punch"><i class="fa fa-exclamation-circle"></i> Punch Error</span>
                                <?php } else { ?>
                                    <span class="badge-issue" style="background:#e2e8f0; color:#334155;">General</span>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <strong><?= $row->reason_type ?></strong>
                                <?php if (!empty($row->remarks)) { ?>
                                    <div style="color:#64748b; font-size:12px; margin-top:2px; max-width:260px;"><?= $row->remarks ?></div>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px; font-family:monospace; font-size:12px;">
                                In: <strong><?= !empty($row->adjusted_in_time) ? $row->adjusted_in_time : (!empty($row->log_in_time) ? $row->log_in_time : '--:--') ?></strong><br>
                                Out: <strong><?= !empty($row->adjusted_out_time) ? $row->adjusted_out_time : (!empty($row->log_out_time) ? $row->log_out_time : '--:--') ?></strong>
                            </td>
                            <td style="padding:12px 16px;">
                                <?php if ($row->waive_deduction == 1) { ?>
                                    <span class="badge-issue badge-waived"><i class="fa fa-check"></i> Waived (No Cut)</span>
                                <?php } else { ?>
                                    <span class="badge-issue badge-not-waived">Deductible</span>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px; color:#64748b; font-size:12px;">
                                <?= $row->created_by ?><br>
                                <small style="color:#94a3b8;"><?= date('d-m-Y H:i', strtotime($row->created_at)) ?></small>
                            </td>
                            <td style="padding:12px 16px; text-align:right;">
                                <button type="button" onclick="confirmDelete(<?= $row->id ?>)" class="btn btn-default btn-xs text-danger" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td colspan="10" style="text-align:center; padding:36px; color:#94a3b8;">
                                <i class="fa fa-search" style="font-size:26px; display:block; margin-bottom:8px;"></i>
                                No regularization records found matching the filter criteria.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete Regularization?',
        text: 'This will remove the remark and revert shift log waiver status.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '<?= base_url('attn_regularization/delete/') ?>' + id;
        }
    });
}
</script>
