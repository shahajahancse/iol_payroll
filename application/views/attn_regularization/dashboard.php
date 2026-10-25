<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
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
.reg-stat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 18px;
    margin-bottom: 24px;
}
.reg-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.reg-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
}
.reg-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.reg-stat-info h4 {
    margin: 0 0 2px 0;
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}
.reg-stat-info p {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}
.reg-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
    overflow: hidden;
}
.reg-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafbfc;
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

<div class="reg-wrapper">
    <!-- Header -->
    <div class="reg-header-card">
        <div class="reg-header-left">
            <div class="reg-header-icon">
                <i class="fa fa-calendar-check-o"></i>
            </div>
            <div class="reg-header-text">
                <h2>Attendance Regularization & Remark Dashboard</h2>
                <p>Manage Late Entries, Early Outs, Punch Errors, and Salary Deduction Waivers</p>
            </div>
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
            <form method="get" action="<?= base_url('attn_regularization/dashboard') ?>" style="display:flex; gap:8px; margin:0;">
                <select name="unit_id" class="form-control" style="width:160px; height:36px; border-radius:6px; font-size:13px;" onchange="this.form.submit()">
                    <option value="">-- All Units --</option>
                    <?php if (!empty($units)) { foreach ($units as $u) { ?>
                        <option value="<?= $u->unit_id ?>" <?= ($selected_unit == $u->unit_id) ? 'selected' : '' ?>><?= $u->unit_name ?></option>
                    <?php }} ?>
                </select>
                <input type="month" name="month" class="form-control" style="width:150px; height:36px; border-radius:6px; font-size:13px;" value="<?= $selected_month ?>" onchange="this.form.submit()">
            </form>
            <a href="<?= base_url('attn_regularization/create') ?>" class="btn btn-primary" style="height:36px; padding:6px 16px; border-radius:6px; font-weight:600; font-size:13px; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa fa-plus-circle"></i> Add Regularization
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="reg-stat-grid">
        <div class="reg-stat-card">
            <div class="reg-stat-icon" style="background:#e0f2fe; color:#0284c7;">
                <i class="fa fa-list-alt"></i>
            </div>
            <div class="reg-stat-info">
                <h4><?= number_format($stats['total_records']) ?></h4>
                <p>Total Regularizations</p>
            </div>
        </div>

        <div class="reg-stat-card">
            <div class="reg-stat-icon" style="background:#dcfce7; color:#16a34a;">
                <i class="fa fa-check-circle"></i>
            </div>
            <div class="reg-stat-info">
                <h4><?= number_format($stats['total_waived']) ?></h4>
                <p>Waived / Deduction-Free</p>
            </div>
        </div>

        <div class="reg-stat-card">
            <div class="reg-stat-icon" style="background:#fee2e2; color:#dc2626;">
                <i class="fa fa-clock-o"></i>
            </div>
            <div class="reg-stat-info">
                <h4><?= number_format($stats['total_late']) ?></h4>
                <p>Late Regularized</p>
            </div>
        </div>

        <div class="reg-stat-card">
            <div class="reg-stat-icon" style="background:#ffedd5; color:#ea580c;">
                <i class="fa fa-sign-out"></i>
            </div>
            <div class="reg-stat-info">
                <h4><?= number_format($stats['total_early_out']) ?></h4>
                <p>Early Out Covered</p>
            </div>
        </div>

        <div class="reg-stat-card">
            <div class="reg-stat-icon" style="background:#fef3c7; color:#d97706;">
                <i class="fa fa-exclamation-triangle"></i>
            </div>
            <div class="reg-stat-info">
                <h4><?= number_format($stats['total_punch_error']) ?></h4>
                <p>Punch Errors Fixed</p>
            </div>
        </div>
    </div>

    <!-- Quick Info Banner -->
    <div style="background:#f0f9ff; border:1px solid #bae6fd; border-radius:10px; padding:14px 18px; margin-bottom:24px; display:flex; align-items:center; gap:12px; color:#0369a1; font-size:13px;">
        <i class="fa fa-info-circle" style="font-size:18px;"></i>
        <div>
            <strong>Salary & Job Card Automation:</strong>
            Whenever an attendance issue (Late, Early Out, Punch Miss) has an approved remark and <strong>"Waived"</strong> is checked, it appears normally on the Job Card with the remark text and is <strong>strictly excluded</strong> from the 3-day-late = 1-day-salary deduction penalty.
        </div>
    </div>

    <!-- Recent Regularizations -->
    <div class="reg-card">
        <div class="reg-card-header">
            <h3><i class="fa fa-history text-primary"></i> Recent Regularizations & Remarks</h3>
            <a href="<?= base_url('attn_regularization/list') ?>" class="btn btn-default btn-xs" style="font-weight:600;">
                View All <i class="fa fa-arrow-right"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom:0; font-size:13px;">
                <thead style="background:#f8fafc; color:#475569; font-size:12px; text-transform:uppercase;">
                    <tr>
                        <th style="padding:12px 16px;">Date</th>
                        <th style="padding:12px 16px;">Emp ID & Name</th>
                        <th style="padding:12px 16px;">Dept / Designation</th>
                        <th style="padding:12px 16px;">Issue Type</th>
                        <th style="padding:12px 16px;">Reason & Remark</th>
                        <th style="padding:12px 16px;">Punch (In / Out)</th>
                        <th style="padding:12px 16px;">Waiver Status</th>
                        <th style="padding:12px 16px;">Status</th>
                        <th style="padding:12px 16px; text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recent_list)) { foreach ($recent_list as $row) { ?>
                        <tr>
                            <td style="padding:12px 16px; font-weight:600;">
                                <?= date('d-m-Y', strtotime($row->att_date)) ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <strong><?= $row->emp_id ?></strong> - <?= $row->name_en ?>
                            </td>
                            <td style="padding:12px 16px; color:#64748b;">
                                <?= $row->dept_name ?> <br><small><?= $row->desig_name ?></small>
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
                                    <br><small style="color:#64748b;"><?= $row->remarks ?></small>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px; font-family:monospace; font-size:12px;">
                                <?= !empty($row->adjusted_in_time) ? $row->adjusted_in_time : (!empty($row->log_in_time) ? $row->log_in_time : '--:--') ?> /
                                <?= !empty($row->adjusted_out_time) ? $row->adjusted_out_time : (!empty($row->log_out_time) ? $row->log_out_time : '--:--') ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <?php if ($row->waive_deduction == 1) { ?>
                                    <span class="badge-issue badge-waived"><i class="fa fa-check"></i> Waived (No Cut)</span>
                                <?php } else { ?>
                                    <span class="badge-issue badge-not-waived">Deductible</span>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <?php if ($row->status === 'Approved') { ?>
                                    <span class="label label-success" style="border-radius:4px; padding:3px 8px;">Approved</span>
                                <?php } elseif ($row->status === 'Pending') { ?>
                                    <span class="label label-warning" style="border-radius:4px; padding:3px 8px;">Pending</span>
                                <?php } else { ?>
                                    <span class="label label-danger" style="border-radius:4px; padding:3px 8px;">Rejected</span>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px; text-align:right;">
                                <a href="javascript:void(0)" onclick="confirmDelete(<?= $row->id ?>)" class="btn btn-default btn-xs text-danger" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td colspan="9" style="text-align:center; padding:30px; color:#94a3b8;">
                                <i class="fa fa-folder-open-o" style="font-size:28px; margin-bottom:8px; display:block;"></i>
                                No regularization records found for this period. Click <strong>"Add Regularization"</strong> to create one.
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
