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
.reg-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 24px;
    overflow: hidden;
}
.badge-issue {
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
}
.badge-late { background: #fee2e2; color: #dc2626; }
.badge-early { background: #ffedd5; color: #ea580c; }
.badge-punch { background: #fef3c7; color: #d97706; }
.badge-waived { background: #dcfce7; color: #16a34a; }

@media print {
    body * {
        visibility: hidden;
    }
    #printableArea, #printableArea * {
        visibility: visible;
    }
    #printableArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .no-print {
        display: none !important;
    }
}
</style>

<div class="reg-wrapper">
    <div class="reg-header-card no-print">
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px; box-shadow:0 4px 12px rgba(239,68,68,0.25);">
                <i class="fa fa-file-text-o"></i>
            </div>
            <div>
                <h2 style="margin:0 0 4px 0; font-size:20px; font-weight:700; color:#0f172a;">Attendance Regularization & Waiver Report</h2>
                <p style="margin:0; color:#64748b; font-size:13px;">Generate and print comprehensive reports of approved remarks and deduction waivers</p>
            </div>
        </div>
        <div style="display:flex; gap:10px;">
            <button onclick="window.print()" class="btn btn-primary" style="font-weight:600; padding:8px 18px; border-radius:6px;">
                <i class="fa fa-print"></i> Print Report
            </button>
            <a href="<?= base_url('attn_regularization/list') ?>" class="btn btn-default" style="font-weight:600; padding:8px 18px; border-radius:6px;">
                <i class="fa fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="reg-card no-print">
        <div style="padding:16px 20px; background:#f8fafc; border-bottom:1px solid #e2e8f0;">
            <form method="get" action="<?= base_url('attn_regularization/reports') ?>" class="row" style="margin:0;">
                <div class="col-md-3" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">Unit</label>
                    <select name="unit_id" class="form-control input-sm" style="border-radius:6px;">
                        <option value="">All Units</option>
                        <?php if (!empty($units)) { foreach ($units as $u) { ?>
                            <option value="<?= $u->unit_id ?>" <?= (isset($filters['unit_id']) && $filters['unit_id'] == $u->unit_id) ? 'selected' : '' ?>><?= $u->unit_name ?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="col-md-3" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">Department</label>
                    <select name="dept_id" class="form-control input-sm" style="border-radius:6px;">
                        <option value="">All Departments</option>
                        <?php if (!empty($departments)) { foreach ($departments as $d) { ?>
                            <option value="<?= $d->dept_id ?>" <?= (isset($filters['dept_id']) && $filters['dept_id'] == $d->dept_id) ? 'selected' : '' ?>><?= $d->dept_name ?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">From Date</label>
                    <input type="date" name="start_date" class="form-control input-sm" value="<?= $filters['start_date'] ?>" style="border-radius:6px;">
                </div>
                <div class="col-md-2" style="padding:4px;">
                    <label style="font-size:11px; font-weight:600; text-transform:uppercase; color:#64748b; margin-bottom:4px; display:block;">To Date</label>
                    <input type="date" name="end_date" class="form-control input-sm" value="<?= $filters['end_date'] ?>" style="border-radius:6px;">
                </div>
                <div class="col-md-2" style="padding:4px; display:flex; align-items:flex-end;">
                    <button type="submit" class="btn btn-primary btn-sm btn-block" style="border-radius:6px; font-weight:600; height:30px;">
                        <i class="fa fa-filter"></i> Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Printable Area -->
    <div id="printableArea" class="reg-card">
        <div style="padding:24px 28px; text-align:center; border-bottom:1px solid #e2e8f0;">
            <h3 style="margin:0 0 4px 0; font-size:20px; font-weight:800; color:#0f172a;">Attendance Regularization & Waiver Report</h3>
            <p style="margin:0; font-size:13px; color:#64748b;">
                Report Period: <strong><?= date('d-m-Y', strtotime($filters['start_date'])) ?></strong> to <strong><?= date('d-m-Y', strtotime($filters['end_date'])) ?></strong>
                &nbsp;|&nbsp; Total Records: <strong><?= count($list) ?></strong>
            </p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" style="margin-bottom:0; font-size:12px;">
                <thead style="background:#f8fafc; color:#334155; font-size:11px; text-transform:uppercase;">
                    <tr>
                        <th style="padding:8px 10px; width:40px; text-align:center;">#</th>
                        <th style="padding:8px 10px; width:90px;">Date</th>
                        <th style="padding:8px 10px;">Emp ID & Name</th>
                        <th style="padding:8px 10px;">Department</th>
                        <th style="padding:8px 10px;">Designation</th>
                        <th style="padding:8px 10px;">Issue Type</th>
                        <th style="padding:8px 10px;">Reason Category</th>
                        <th style="padding:8px 10px;">Remark Details</th>
                        <th style="padding:8px 10px; text-align:center;">Waiver Status</th>
                        <th style="padding:8px 10px;">Approved By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list)) { $i = 1; foreach ($list as $row) { ?>
                        <tr>
                            <td style="padding:8px 10px; text-align:center;"><?= $i++ ?></td>
                            <td style="padding:8px 10px; font-weight:600;"><?= date('d-m-Y', strtotime($row->att_date)) ?></td>
                            <td style="padding:8px 10px;"><strong><?= $row->emp_id ?></strong> - <?= $row->name_en ?></td>
                            <td style="padding:8px 10px;"><?= $row->dept_name ?></td>
                            <td style="padding:8px 10px;"><?= $row->desig_name ?></td>
                            <td style="padding:8px 10px;">
                                <?php if ($row->issue_type === 'late') { ?>
                                    <span class="badge-issue badge-late">Late Entry</span>
                                <?php } elseif ($row->issue_type === 'early_out') { ?>
                                    <span class="badge-issue badge-early">Early Out</span>
                                <?php } elseif ($row->issue_type === 'punch_error') { ?>
                                    <span class="badge-issue badge-punch">Punch Error</span>
                                <?php } else { ?>
                                    <span class="badge-issue" style="background:#e2e8f0; color:#334155;">General</span>
                                <?php } ?>
                            </td>
                            <td style="padding:8px 10px;"><strong><?= $row->reason_type ?></strong></td>
                            <td style="padding:8px 10px;"><?= !empty($row->remarks) ? $row->remarks : '-' ?></td>
                            <td style="padding:8px 10px; text-align:center;">
                                <?php if ($row->waive_deduction == 1) { ?>
                                    <span class="badge-issue badge-waived">Waived (No Cut)</span>
                                <?php } else { ?>
                                    <span class="badge-issue" style="background:#f1f5f9; color:#64748b;">Deductible</span>
                                <?php } ?>
                            </td>
                            <td style="padding:8px 10px; color:#64748b;"><?= !empty($row->approved_by) ? $row->approved_by : $row->created_by ?></td>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td colspan="10" style="text-align:center; padding:30px; color:#94a3b8;">
                                No records found for the selected criteria.
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
