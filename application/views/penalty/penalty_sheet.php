<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Penalty Sheet - <?php echo htmlspecialchars($salary_month); ?></title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #000;
            background: #fff;
            margin: 15px;
        }
        .header-wrap {
            text-align: center;
            margin-bottom: 20px;
        }
        .company-name {
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .company-address {
            font-size: 12px;
            margin-top: 3px;
        }
        .report-title {
            display: inline-block;
            font-size: 15px;
            font-weight: bold;
            margin-top: 10px;
            padding: 4px 18px;
            border-bottom: 2px solid #000;
            letter-spacing: 0.5px;
        }
        .meta-bar {
            display: flex;
            justify-content: space-between;
            margin: 15px 0 8px 0;
            font-size: 12px;
            font-weight: 600;
        }
        table.sheet-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        table.sheet-table th, table.sheet-table td {
            border: 1px solid #333;
            padding: 6px 6px;
        }
        table.sheet-table th {
            background-color: #f2f2f2;
            text-align: center;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row {
            font-weight: bold;
            background-color: #fafafa;
        }
        .signature-table {
            width: 100%;
            margin-top: 60px;
            border-collapse: collapse;
        }
        .signature-table td {
            border: none;
            padding-top: 40px;
            text-align: center;
            font-weight: bold;
            font-size: 11px;
        }
        .signature-line {
            display: inline-block;
            border-top: 1px dashed #000;
            width: 140px;
            padding-top: 5px;
        }
        @media print {
            .no-print { display: none !important; }
            body { margin: 0; }
        }
    </style>
</head>
<body>

<div class="no-print" style="margin-bottom: 15px; text-align: right;">
    <button onclick="window.print()" style="background:#0284c7;color:#fff;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;font-weight:600;">
        🖨️ Print Sheet
    </button>
    <button onclick="window.close()" style="background:#64748b;color:#fff;border:none;padding:8px 16px;border-radius:4px;cursor:pointer;font-weight:600;margin-left:6px;">
        Close
    </button>
</div>

<div class="header-wrap">
    <div class="company-name"><?php echo !empty($unit->unit_name) ? htmlspecialchars($unit->unit_name) : 'Islam Oxygen Limited'; ?></div>
    <div class="company-address"><?php echo !empty($unit->unit_add) ? htmlspecialchars($unit->unit_add) : '11/1 Tarabo, Rupgonj, Narayanganj'; ?></div>
    <div class="report-title">PENALTY DEDUCTION SHEET</div>
</div>

<div class="meta-bar">
    <div><strong>Salary Month:</strong> <?php echo date('F, Y', strtotime($salary_month . '-01')); ?> (<?php echo htmlspecialchars($salary_month); ?>)</div>
    <div><strong>Print Date:</strong> <?php echo date('d-M-Y h:i A'); ?></div>
</div>

<table class="sheet-table">
    <thead>
        <tr>
            <th width="35">SL</th>
            <th width="75">Emp ID</th>
            <th width="150">Employee Name</th>
            <th width="110">Department</th>
            <th width="110">Section</th>
            <th width="120">Designation</th>
            <th width="80">Month</th>
            <th width="85">Penalty Amount</th>
            <th>Remarks / Reason</th>
            <th width="90">Status</th>
            <th width="110">Signature</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $sl = 0;
        $total_amount = 0;
        if (!empty($records)) {
            foreach ($records as $row) {
                $sl++;
                $total_amount += (float)$row->amount;
                ?>
                <tr>
                    <td class="text-center"><?php echo $sl; ?></td>
                    <td class="text-center"><strong><?php echo htmlspecialchars($row->emp_id); ?></strong></td>
                    <td><?php echo htmlspecialchars($row->name_en); ?></td>
                    <td><?php echo htmlspecialchars($row->dept_name); ?></td>
                    <td><?php echo htmlspecialchars($row->sec_name_en); ?></td>
                    <td><?php echo htmlspecialchars($row->desig_name); ?></td>
                    <td class="text-center"><?php echo htmlspecialchars($row->salary_month); ?></td>
                    <td class="text-right"><strong><?php echo number_format($row->amount, 2); ?></strong></td>
                    <td><?php echo htmlspecialchars($row->remarks); ?></td>
                    <td class="text-center">
                        <span style="font-weight:600; color:<?php echo ($row->status == 'Approved') ? '#16a34a' : '#d97706'; ?>;">
                            <?php echo htmlspecialchars($row->status); ?>
                        </span>
                    </td>
                    <td></td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="11" class="text-center" style="padding: 20px; color: #888;">No penalty records found for this period.</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
    <?php if (!empty($records)) { ?>
    <tfoot>
        <tr class="total-row">
            <td colspan="7" class="text-right"><strong>Total Penalty Deduction:</strong></td>
            <td class="text-right"><strong><?php echo number_format($total_amount, 2); ?></strong></td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
    <?php } ?>
</table>

<table class="signature-table">
    <tr>
        <td><span class="signature-line">Prepared By</span></td>
        <td><span class="signature-line">Checked By</span></td>
        <td><span class="signature-line">Verified By (HR & Admin)</span></td>
        <td><span class="signature-line">Approved By (Director / GM)</span></td>
    </tr>
</table>

</body>
</html>
