<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$report_type = isset($report_type) ? $report_type : 'list';
$records = isset($records) ? $records : array();
$title = isset($title) ? $title : 'Outside Duty (OD) Report';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?> | Islam Oxygen Limited</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            color: #1e293b;
            background: #ffffff;
            margin: 0;
            padding: 24px;
            font-size: 12px;
        }
        .no-print-bar {
            background: #0f172a;
            color: #ffffff;
            padding: 10px 24px;
            margin: -24px -24px 24px -24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: #0284c7;
            color: #ffffff;
            border: none;
            padding: 6px 16px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }
        .btn-close {
            background: #475569;
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }
        .company-header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }
        .company-header h1 {
            margin: 0 0 4px 0;
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .company-header p {
            margin: 0 0 4px 0;
            color: #64748b;
            font-size: 11px;
        }
        .report-title-badge {
            display: inline-block;
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
        }
        .report-meta {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: #64748b;
            margin-bottom: 14px;
        }
        table.print-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        table.print-table th, table.print-table td {
            border: 1px solid #cbd5e1;
            padding: 7px 9px;
            font-size: 11px;
        }
        table.print-table th {
            background: #f8fafc;
            color: #1e293b;
            font-weight: 700;
            text-transform: uppercase;
        }
        table.print-table tr:nth-child(even) td {
            background: #fcfcfd;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            padding: 0 20px;
        }
        .sign-block {
            text-align: center;
            width: 180px;
            border-top: 1px solid #475569;
            padding-top: 6px;
            font-weight: 600;
            font-size: 11px;
            color: #334155;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <div class="no-print-bar no-print">
        <div><strong>Print Preview:</strong> <?= htmlspecialchars($title) ?></div>
        <div>
            <button type="button" class="btn-print" onclick="window.print()">Print Document</button>
            <button type="button" class="btn-close" onclick="window.close()">Close</button>
        </div>
    </div>

    <div class="company-header">
        <h1>Islam Oxygen Limited</h1>
        <p>Corporate Head Office: G-1, Block-E, Banani, Dhaka-1213 | Hotline: +880 9613-222333</p>
        <div class="report-title-badge"><?= strtoupper(htmlspecialchars($title)) ?></div>
    </div>

    <div class="report-meta">
        <div>Report Type: <strong><?= ucfirst($report_type) ?></strong></div>
        <div>Generated On: <strong><?= date('d M Y, h:i A') ?></strong></div>
    </div>

    <table class="print-table">
        <?php if ($report_type === 'daily'): ?>
            <thead>
                <tr>
                    <th style="width:30px;">SL</th>
                    <th>Date</th>
                    <th>Emp ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Purpose</th>
                    <th>Location</th>
                    <th>Departure / Return</th>
                    <th style="text-align:center;">Attn Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): $sl = 1; foreach ($records as $r): ?>
                    <tr>
                        <td><?= $sl++ ?></td>
                        <td><?= $r->od_date ?></td>
                        <td><strong><?= $r->emp_id ?></strong></td>
                        <td><?= htmlspecialchars($r->name_en) ?></td>
                        <td><?= htmlspecialchars($r->dept_name) ?></td>
                        <td><?= htmlspecialchars($r->desig_name) ?></td>
                        <td><?= htmlspecialchars($r->purpose) ?></td>
                        <td><?= htmlspecialchars($r->location) ?></td>
                        <td><?= ($r->departure_time ?: '-') . ' / ' . ($r->return_time ?: '-') ?></td>
                        <td style="text-align:center;"><strong>OD</strong></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="10" style="text-align:center; padding:15px;">No records found.</td></tr>
                <?php endif; ?>
            </tbody>
        <?php elseif ($report_type === 'monthly'): ?>
            <thead>
                <tr>
                    <th style="width:30px;">SL</th>
                    <th>Emp ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th style="text-align:center;">Total OD Days</th>
                    <th>Assigned Dates</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): $sl = 1; foreach ($records as $r): ?>
                    <tr>
                        <td><?= $sl++ ?></td>
                        <td><strong><?= $r->emp_id ?></strong></td>
                        <td><?= htmlspecialchars($r->name_en) ?></td>
                        <td><?= htmlspecialchars($r->dept_name) ?></td>
                        <td><?= htmlspecialchars($r->desig_name) ?></td>
                        <td style="text-align:center; font-weight:bold;"><?= $r->total_od_days ?> Days</td>
                        <td><?= htmlspecialchars($r->od_dates) ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="7" style="text-align:center; padding:15px;">No records found.</td></tr>
                <?php endif; ?>
            </tbody>
        <?php else: ?>
            <thead>
                <tr>
                    <th style="width:30px;">SL</th>
                    <th>Emp ID</th>
                    <th>Employee Name</th>
                    <th>Department & Designation</th>
                    <th>OD Dates</th>
                    <th style="text-align:center;">Days</th>
                    <th>Purpose</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Assigned By</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($records)): $sl = 1; foreach ($records as $r): ?>
                    <tr>
                        <td><?= $sl++ ?></td>
                        <td><strong><?= $r->emp_id ?></strong></td>
                        <td><?= htmlspecialchars(isset($r->name_en) ? $r->name_en : '-') ?></td>
                        <td><?= htmlspecialchars(isset($r->dept_name) ? $r->dept_name : '-') ?> / <?= htmlspecialchars(isset($r->desig_name) ? $r->desig_name : '-') ?></td>
                        <td><?= $r->start_date ?> <?= ($r->start_date !== $r->end_date) ? 'to ' . $r->end_date : '' ?></td>
                        <td style="text-align:center; font-weight:bold;"><?= isset($r->total_days) ? $r->total_days : '1' ?></td>
                        <td><?= htmlspecialchars(isset($r->purpose) ? $r->purpose : '-') ?></td>
                        <td><?= htmlspecialchars(isset($r->location) ? $r->location : '-') ?></td>
                        <td style="text-transform:capitalize;"><?= isset($r->status) ? $r->status : '-' ?></td>
                        <td><?= htmlspecialchars(isset($r->assigned_by) ? $r->assigned_by : '-') ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="10" style="text-align:center; padding:15px;">No records found.</td></tr>
                <?php endif; ?>
            </tbody>
        <?php endif; ?>
    </table>

    <div class="signature-section">
        <div class="sign-block">Prepared By</div>
        <div class="sign-block">Verified By (HR)</div>
        <div class="sign-block">Department Head</div>
        <div class="sign-block">Authorized Signature</div>
    </div>

</body>
</html>
