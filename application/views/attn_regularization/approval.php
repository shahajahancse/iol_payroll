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
</style>

<div class="content reg-wrapper">
    <div class="reg-header-card">
        <div style="display:flex; align-items:center; gap:16px;">
            <div style="width:48px; height:48px; border-radius:12px; background:linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color:#fff; display:flex; align-items:center; justify-content:center; font-size:22px; box-shadow:0 4px 12px rgba(245,158,11,0.25);">
                <i class="fa fa-check-square-o"></i>
            </div>
            <div>
                <h2 style="margin:0 0 4px 0; font-size:20px; font-weight:700; color:#0f172a;">Attendance Regularization Approval</h2>
                <p style="margin:0; color:#64748b; font-size:13px;">Review and approve attendance remarks and salary deduction waivers</p>
            </div>
        </div>
        <div>
            <a href="<?= base_url('attn_regularization/dashboard') ?>" class="btn btn-default" style="font-weight:600;">
                <i class="fa fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <div class="reg-card">
        <div class="table-responsive">
            <table class="table table-hover" style="margin-bottom:0; font-size:13px;">
                <thead style="background:#f8fafc; color:#475569; font-size:12px; text-transform:uppercase;">
                    <tr>
                        <th style="padding:12px 16px;">Date</th>
                        <th style="padding:12px 16px;">Employee</th>
                        <th style="padding:12px 16px;">Department / Desig</th>
                        <th style="padding:12px 16px;">Issue Type</th>
                        <th style="padding:12px 16px;">Reason & Remark</th>
                        <th style="padding:12px 16px;">Waiver Status</th>
                        <th style="padding:12px 16px;">Submitted By</th>
                        <th style="padding:12px 16px; text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($list)) { foreach ($list as $row) { ?>
                        <tr id="row-<?= $row->id ?>">
                            <td style="padding:12px 16px; font-weight:600;">
                                <?= date('d-m-Y', strtotime($row->att_date)) ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <strong><?= $row->emp_id ?></strong> - <?= $row->name_en ?>
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
                                    <div style="color:#64748b; font-size:12px; margin-top:2px;"><?= $row->remarks ?></div>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px;">
                                <?php if ($row->waive_deduction == 1) { ?>
                                    <span class="badge-issue badge-waived"><i class="fa fa-check"></i> Waive Penalty</span>
                                <?php } else { ?>
                                    <span class="badge-issue" style="background:#f1f5f9; color:#64748b;">Keep Penalty</span>
                                <?php } ?>
                            </td>
                            <td style="padding:12px 16px; color:#64748b; font-size:12px;">
                                <?= $row->created_by ?><br>
                                <small style="color:#94a3b8;"><?= date('d-m-Y H:i', strtotime($row->created_at)) ?></small>
                            </td>
                            <td style="padding:12px 16px; text-align:right;">
                                <div style="display:flex; justify-content:flex-end; gap:6px;">
                                    <button type="button" onclick="takeAction(<?= $row->id ?>, 'Approved')" class="btn btn-success btn-xs" style="font-weight:600; padding:4px 10px;">
                                        <i class="fa fa-check"></i> Approve
                                    </button>
                                    <button type="button" onclick="takeAction(<?= $row->id ?>, 'Rejected')" class="btn btn-danger btn-xs" style="font-weight:600; padding:4px 10px;">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php }} else { ?>
                        <tr>
                            <td colspan="8" style="text-align:center; padding:40px; color:#94a3b8;">
                                <i class="fa fa-check-circle" style="font-size:32px; color:#10b981; display:block; margin-bottom:8px;"></i>
                                All regularizations have been reviewed! No pending requests at this time.
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
function takeAction(id, status) {
    var title = status === 'Approved' ? 'Approve Regularization?' : 'Reject Regularization?';
    var text = status === 'Approved' ? 'This will apply the remark to the Job Card and exempt salary penalty.' : 'This will mark the regularization as rejected.';

    Swal.fire({
        title: title,
        text: text,
        icon: status === 'Approved' ? 'question' : 'warning',
        showCancelButton: true,
        confirmButtonColor: status === 'Approved' ? '#16a34a' : '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Yes, ' + status
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('attn_regularization/action') ?>',
                type: 'POST',
                data: { id: id, status: status },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        Swal.fire({
                            title: 'Done!',
                            text: res.message,
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#row-' + id).fadeOut(300, function() { $(this).remove(); });
                    } else {
                        Swal.fire('Error', res.message, 'error');
                    }
                }
            });
        }
    });
}
</script>
