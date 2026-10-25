<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) DASHBOARD - EXECUTIVE MODERN STYLES                     */
/* ========================================================================= */
.page-content .content.od-dashboard-wrapper {
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
    margin-bottom: 22px;
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
}
.btn-action-primary {
    background: #2563eb;
    color: #ffffff;
    border: 1px solid #2563eb;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.2s;
}
.btn-action-primary:hover {
    background: #1d4ed8;
    color: #ffffff;
    text-decoration: none;
}
.btn-header-refresh {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s;
}
.btn-header-refresh:hover {
    background: #f8fafc;
    color: #0f172a;
}

/* Stat Cards Grid */
.od-stat-grid {
    display: flex;
    flex-wrap: wrap;
    margin-left: -7px;
    margin-right: -7px;
    margin-bottom: 8px;
}
.od-stat-col {
    flex: 1 1 0;
    min-width: 170px;
    padding: 0 7px;
    margin-bottom: 14px;
}
@media (max-width: 991px) {
    .od-stat-col { flex: 0 0 33.333%; max-width: 33.333%; }
}
@media (max-width: 767px) {
    .od-stat-col { flex: 0 0 50%; max-width: 50%; }
}

.od-stat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 16px;
    height: 100%;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    text-decoration: none;
    color: inherit;
}
.od-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 22px -5px rgba(0, 0, 0, 0.08);
    text-decoration: none;
}
.od-stat-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.od-stat-info {
    flex-grow: 1;
    min-width: 0;
}
.od-stat-info h3 {
    margin: 0 0 2px 0;
    font-size: 25px;
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.5px;
}
.od-stat-info span {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Card Themes */
.card-today .od-stat-icon { background: #e0f2fe; color: #0284c7; }
.card-today h3 { color: #0284c7; }
.card-pending .od-stat-icon { background: #fef3c7; color: #d97706; }
.card-pending h3 { color: #d97706; }
.card-approved .od-stat-icon { background: #dcfce7; color: #16a34a; }
.card-approved h3 { color: #16a34a; }
.card-rejected .od-stat-icon { background: #fee2e2; color: #dc2626; }
.card-rejected h3 { color: #dc2626; }
.card-upcoming .od-stat-icon { background: #f3e8ff; color: #9333ea; }
.card-upcoming h3 { color: #9333ea; }

/* Table Container Card */
.od-content-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(15, 23, 42, 0.03);
    overflow: hidden;
    margin-top: 10px;
}
.od-card-header {
    padding: 16px 20px;
    background: #ffffff;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
}
.od-card-header h3 {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
}
.badge-count {
    background: #0284c7;
    color: #ffffff;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
}

/* Modern Table */
.od-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: collapse;
}
.od-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    padding: 12px 16px;
    border-bottom: 1px solid #e2e8f0;
    border-top: none;
    white-space: nowrap;
}
.od-table tbody td {
    padding: 12px 16px;
    font-size: 13px;
    vertical-align: middle;
    border-top: 1px solid #f1f5f9;
    color: #1e293b;
    white-space: nowrap;
}
.od-table tbody tr:hover {
    background-color: #f8fafc;
}
.pill-status {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
    display: inline-block;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.pill-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.pill-pending { background: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
.pill-rejected { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
.pill-od-att { background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; font-weight: 800; }
</style>

<div class="content od-dashboard-wrapper">
    <!-- Header Card -->
    <div class="od-header-card">
        <div class="od-header-left">
            <div class="od-header-icon">
                <i class="fa fa-briefcase"></i>
            </div>
            <div class="od-header-text">
                <h2>Outside Duty (OD) Management Dashboard</h2>
                <p>Manage, assign, and track employee outside official duties with real-time attendance integration.</p>
            </div>
        </div>
        <div class="od-header-actions">
            <?php if (empty($unit_id)): ?>
            <select class="form-control" id="filter_unit" onchange="refreshDashboardStats()" style="width: 180px; height: 36px; border-radius: 8px; font-size: 13px;">
                <option value="">All Branches</option>
                <?php foreach ($units as $u): ?>
                    <option value="<?= $u->unit_id ?>"><?= htmlspecialchars($u->unit_name) ?></option>
                <?php endforeach; ?>
            </select>
            <?php endif; ?>
            <a href="<?= base_url('od/create') ?>" class="btn-action-primary">
                <i class="fa fa-plus"></i> Assign OD
            </a>
            <button type="button" class="btn-header-refresh" onclick="refreshDashboardStats()" title="Refresh Dashboard">
                <i class="fa fa-refresh" id="refresh_icon"></i> Refresh
            </button>
        </div>
    </div>

    <!-- 5 Real-Time Summary Cards -->
    <div class="od-stat-grid">
        <!-- Card 1: Today's Total OD -->
        <div class="od-stat-col">
            <a href="<?= base_url('od/list?from_date=' . date('Y-m-d') . '&to_date=' . date('Y-m-d') . '&status=approved') ?>" class="od-stat-card card-today">
                <div class="od-stat-icon"><i class="fa fa-users"></i></div>
                <div class="od-stat-info">
                    <h3 id="stat_today_total"><?= $stats['today_total'] ?></h3>
                    <span>Today's Total OD</span>
                </div>
            </a>
        </div>
        <!-- Card 2: Pending Applications -->
        <div class="od-stat-col">
            <a href="<?= base_url('od/approval') ?>" class="od-stat-card card-pending">
                <div class="od-stat-icon"><i class="fa fa-clock-o"></i></div>
                <div class="od-stat-info">
                    <h3 id="stat_pending_count"><?= $stats['pending_count'] ?></h3>
                    <span>Pending Approval</span>
                </div>
            </a>
        </div>
        <!-- Card 3: Approved Applications -->
        <div class="od-stat-col">
            <a href="<?= base_url('od/list?status=approved') ?>" class="od-stat-card card-approved">
                <div class="od-stat-icon"><i class="fa fa-check-circle-o"></i></div>
                <div class="od-stat-info">
                    <h3 id="stat_approved_count"><?= $stats['approved_count'] ?></h3>
                    <span>Approved OD</span>
                </div>
            </a>
        </div>
        <!-- Card 4: Rejected Applications -->
        <div class="od-stat-col">
            <a href="<?= base_url('od/list?status=rejected') ?>" class="od-stat-card card-rejected">
                <div class="od-stat-icon"><i class="fa fa-times-circle-o"></i></div>
                <div class="od-stat-info">
                    <h3 id="stat_rejected_count"><?= $stats['rejected_count'] ?></h3>
                    <span>Rejected OD</span>
                </div>
            </a>
        </div>
        <!-- Card 5: Upcoming OD -->
        <div class="od-stat-col">
            <a href="<?= base_url('od/list?from_date=' . date('Y-m-d', strtotime('+1 day')) . '&status=approved') ?>" class="od-stat-card card-upcoming">
                <div class="od-stat-icon"><i class="fa fa-calendar"></i></div>
                <div class="od-stat-info">
                    <h3 id="stat_upcoming_count"><?= $stats['upcoming_count'] ?></h3>
                    <span>Upcoming Assignments</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Active OD Employees Today Table Card -->
    <div class="od-content-card">
        <div class="od-card-header">
            <h3>
                <i class="fa fa-calendar-check-o text-primary"></i> 
                Employees on Outside Duty (OD) Today - <?= date('d M, Y') ?>
                <span class="badge-count" id="badge_today_count"><?= count($stats['today_list']) ?></span>
            </h3>
            <div style="display: flex; gap: 8px;">
                <a href="<?= base_url('od/reports') ?>" class="btn btn-default btn-sm" style="border-radius: 6px; font-weight: 600;">
                    <i class="fa fa-bar-chart"></i> View Reports
                </a>
                <a href="<?= base_url('od/list') ?>" class="btn btn-default btn-sm" style="border-radius: 6px; font-weight: 600;">
                    <i class="fa fa-list"></i> View All OD List
                </a>
            </div>
        </div>

        <div class="table-responsive" style="border: none;">
            <table class="table od-table" id="today_od_table">
                <thead>
                    <tr>
                        <th width="40">SL</th>
                        <th>Emp ID</th>
                        <th>Employee Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>OD Purpose</th>
                        <th>Duty Location</th>
                        <th>Expected Departure</th>
                        <th>Expected Return</th>
                        <th>Attn Status</th>
                        <th class="text-right">Action</th>
                    </tr>
                </thead>
                <tbody id="today_od_tbody">
                    <?php if (empty($stats['today_list'])): ?>
                        <tr>
                            <td colspan="11" class="text-center" style="padding: 40px; color: #94a3b8;">
                                <i class="fa fa-folder-open-o fa-3x" style="opacity: 0.5;"></i><br>
                                <strong style="font-size: 14px; margin-top: 8px; display: inline-block;">No employees are assigned to Outside Duty today.</strong><br>
                                <small>Click "Assign OD" to schedule official outside duty assignments.</small>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $sl = 1; foreach ($stats['today_list'] as $row): ?>
                            <tr>
                                <td><?= $sl++ ?></td>
                                <td><strong><?= htmlspecialchars($row->emp_id) ?></strong></td>
                                <td>
                                    <span style="font-weight: 600; color: #0f172a;"><?= htmlspecialchars($row->name_en) ?></span>
                                </td>
                                <td><?= htmlspecialchars($row->dept_name ?: '-') ?></td>
                                <td><?= htmlspecialchars($row->desig_name ?: '-') ?></td>
                                <td>
                                    <span class="label label-info" style="font-size: 11px;"><?= htmlspecialchars($row->purpose) ?></span>
                                </td>
                                <td><i class="fa fa-map-marker text-danger"></i> <?= htmlspecialchars($row->location) ?></td>
                                <td><?= !empty($row->departure_time) ? date('h:i A', strtotime($row->departure_time)) : '-' ?></td>
                                <td><?= !empty($row->return_time) ? date('h:i A', strtotime($row->return_time)) : '-' ?></td>
                                <td>
                                    <span class="pill-status pill-od-att">OD</span>
                                    <?php if (!empty($row->in_time) && $row->in_time != '00:00:00'): ?>
                                        <small style="color: #64748b; display: block; font-size: 10px;">In: <?= date('h:i A', strtotime($row->in_time)) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn btn-default btn-xs" onclick="viewOdDetails(<?= $row->od_id ?>)" title="View Details">
                                        <i class="fa fa-eye"></i> View
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Details Modal -->
<div class="modal fade" id="od_details_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
            <div class="modal-header" style="background: #0f172a; color: #ffffff; padding: 14px 20px;">
                <button type="button" class="close" data-dismiss="modal" style="color: #ffffff; opacity: 0.8;">&times;</button>
                <h4 class="modal-title" style="font-weight: 700; font-size: 16px;">
                    <i class="fa fa-info-circle text-info"></i> Outside Duty Assignment Details
                </h4>
            </div>
            <div class="modal-body" id="od_details_body" style="padding: 20px; font-size: 13px;">
                <div class="text-center" style="padding: 30px;"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading...</div>
            </div>
            <div class="modal-footer" style="background: #f8fafc;">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function refreshDashboardStats() {
    var $icon = $('#refresh_icon');
    $icon.addClass('fa-spin');
    var unitId = $('#filter_unit').val() || '';

    $.ajax({
        url: "<?= base_url('od_management_con/dashboard_stats_ajax') ?>",
        type: "GET",
        data: { unit_id: unitId },
        dataType: "json",
        success: function(res) {
            $icon.removeClass('fa-spin');
            if (res.status === 'success') {
                $('#stat_today_total').text(res.data.today_total);
                $('#stat_pending_count').text(res.data.pending_count);
                $('#stat_approved_count').text(res.data.approved_count);
                $('#stat_rejected_count').text(res.data.rejected_count);
                $('#stat_upcoming_count').text(res.data.upcoming_count);
                $('#badge_today_count').text(res.data.today_list.length);

                renderTodayTable(res.data.today_list);
            }
        },
        error: function() {
            $icon.removeClass('fa-spin');
        }
    });
}

function renderTodayTable(list) {
    var html = '';
    if (!list || list.length === 0) {
        html = '<tr><td colspan="11" class="text-center" style="padding: 40px; color: #94a3b8;"><i class="fa fa-folder-open-o fa-3x" style="opacity: 0.5;"></i><br><strong style="font-size: 14px; margin-top: 8px; display: inline-block;">No employees are assigned to Outside Duty today.</strong><br><small>Click "Assign OD" to schedule official outside duty assignments.</small></td></tr>';
    } else {
        $.each(list, function(idx, row) {
            var inInfo = (row.in_time && row.in_time !== '00:00:00') ? '<small style="color: #64748b; display: block; font-size: 10px;">In: ' + row.in_time + '</small>' : '';
            html += '<tr>' +
                '<td>' + (idx + 1) + '</td>' +
                '<td><strong>' + (row.emp_id || '') + '</strong></td>' +
                '<td><span style="font-weight: 600; color: #0f172a;">' + (row.name_en || '') + '</span></td>' +
                '<td>' + (row.dept_name || '-') + '</td>' +
                '<td>' + (row.desig_name || '-') + '</td>' +
                '<td><span class="label label-info" style="font-size: 11px;">' + (row.purpose || '') + '</span></td>' +
                '<td><i class="fa fa-map-marker text-danger"></i> ' + (row.location || '') + '</td>' +
                '<td>' + (row.departure_time || '-') + '</td>' +
                '<td>' + (row.return_time || '-') + '</td>' +
                '<td><span class="pill-status pill-od-att">OD</span>' + inInfo + '</td>' +
                '<td class="text-right"><button type="button" class="btn btn-default btn-xs" onclick="viewOdDetails(' + row.od_id + ')" title="View Details"><i class="fa fa-eye"></i> View</button></td>' +
            '</tr>';
        });
    }
    $('#today_od_tbody').html(html);
}

function viewOdDetails(id) {
    $('#od_details_body').html('<div class="text-center" style="padding: 30px;"><i class="fa fa-spinner fa-spin fa-2x"></i> Loading details...</div>');
    $('#od_details_modal').modal('show');

    $.ajax({
        url: "<?= base_url('od_management_con/details_ajax') ?>/" + id,
        type: "GET",
        dataType: "json",
        success: function(res) {
            if (res.status === 'success') {
                var d = res.data;
                var datesHtml = '';
                if (d.dates_list && d.dates_list.length > 0) {
                    $.each(d.dates_list, function(_, dt) {
                        datesHtml += '<span class="badge" style="background: #e2e8f0; color: #1e293b; margin-right: 4px; font-weight: 600;">' + dt + '</span>';
                    });
                } else {
                    datesHtml = d.start_date + ' to ' + d.end_date;
                }

                var statusBadge = '';
                if (d.status === 'approved') statusBadge = '<span class="pill-status pill-approved">Approved</span>';
                else if (d.status === 'pending') statusBadge = '<span class="pill-status pill-pending">Pending</span>';
                else statusBadge = '<span class="pill-status pill-rejected">' + d.status + '</span>';

                var auditHtml = '<ul class="list-unstyled" style="margin: 0;">';
                if (d.audit_list && d.audit_list.length > 0) {
                    $.each(d.audit_list, function(_, a) {
                        auditHtml += '<li style="margin-bottom: 6px;"><small style="color: #64748b;">' + a.timestamp + ' by <strong>' + a.user + '</strong>: ' + (a.details || a.action) + '</small></li>';
                    });
                }
                auditHtml += '</ul>';

                var html = '<div class="row">' +
                    '<div class="col-sm-6">' +
                        '<table class="table table-bordered table-striped" style="margin-bottom: 15px;">' +
                            '<tr><th width="35%">Assignment ID</th><td>#' + d.id + '</td></tr>' +
                            '<tr><th>Employee</th><td><strong>' + d.emp_id + '</strong> - ' + (d.name_en || '') + '</td></tr>' +
                            '<tr><th>Department</th><td>' + (d.dept_name || '-') + '</td></tr>' +
                            '<tr><th>Designation</th><td>' + (d.desig_name || '-') + '</td></tr>' +
                            '<tr><th>Branch / Unit</th><td>' + (d.unit_name || '-') + '</td></tr>' +
                            '<tr><th>Status</th><td>' + statusBadge + '</td></tr>' +
                        '</table>' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                        '<table class="table table-bordered table-striped" style="margin-bottom: 15px;">' +
                            '<tr><th width="35%">Purpose</th><td><strong>' + d.purpose + '</strong></td></tr>' +
                            '<tr><th>Location</th><td><i class="fa fa-map-marker text-danger"></i> ' + d.location + '</td></tr>' +
                            '<tr><th>Total Days</th><td><strong>' + d.total_days + ' Day(s)</strong></td></tr>' +
                            '<tr><th>Departure Time</th><td>' + (d.departure_time || 'N/A') + '</td></tr>' +
                            '<tr><th>Return Time</th><td>' + (d.return_time || 'N/A') + '</td></tr>' +
                            '<tr><th>Assigned By</th><td>' + d.assigned_by + ' (' + d.created_at + ')</td></tr>' +
                        '</table>' +
                    '</div>' +
                '</div>' +
                '<div class="panel panel-default" style="margin-bottom: 15px;">' +
                    '<div class="panel-heading" style="font-weight: 700; font-size: 12px;">Assigned OD Dates (' + d.total_days + ' Day(s))</div>' +
                    '<div class="panel-body" style="padding: 10px;">' + datesHtml + '</div>' +
                '</div>' +
                '<div class="panel panel-default" style="margin-bottom: 15px;">' +
                    '<div class="panel-heading" style="font-weight: 700; font-size: 12px;">Official Work Description</div>' +
                    '<div class="panel-body" style="padding: 10px; background: #fafafa;">' + (d.work_description ? d.work_description.replace(/\n/g, '<br>') : '-') + '</div>' +
                '</div>';

                if (d.rejection_reason) {
                    html += '<div class="alert alert-danger" style="margin-bottom: 15px;"><strong>Rejection Reason:</strong> ' + d.rejection_reason + '</div>';
                }

                html += '<div class="panel panel-default" style="margin-bottom: 0;">' +
                    '<div class="panel-heading" style="font-weight: 700; font-size: 12px;"><i class="fa fa-history"></i> Audit Trail</div>' +
                    '<div class="panel-body" style="padding: 10px;">' + auditHtml + '</div>' +
                '</div>';

                $('#od_details_body').html(html);
            } else {
                $('#od_details_body').html('<div class="alert alert-danger">' + res.message + '</div>');
            }
        },
        error: function() {
            $('#od_details_body').html('<div class="alert alert-danger">Error loading assignment details.</div>');
        }
    });
}
</script>
