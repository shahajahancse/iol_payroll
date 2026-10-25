<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employee Leave Report - <?= date('Y-m-d') ?></title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    body {
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
      font-size: 11px;
      color: #1e293b;
      background-color: #f8fafc;
      padding: 0;
    }

    /* Top Action Bar (hidden when printing) */
    .top-toolbar {
      position: sticky;
      top: 0;
      z-index: 1000;
      background: #006ba3;
      color: #ffffff;
      padding: 10px 24px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .top-toolbar .title-area {
      display: flex;
      align-items: center;
      gap: 12px;
      font-size: 14px;
      font-weight: 600;
      letter-spacing: 0.3px;
    }
    .top-toolbar .badge {
      background: #2563eb;
      color: #fff;
      padding: 3px 8px;
      border-radius: 4px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
    }
    .top-toolbar .btn-group {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .top-toolbar .btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 14px;
      font-size: 12px;
      font-weight: 600;
      border-radius: 6px;
      cursor: pointer;
      border: 1px solid transparent;
      text-decoration: none;
      transition: all 0.15s ease-in-out;
    }
    .btn-print {
      background: #2563eb;
      color: #ffffff;
      border-color: #1d4ed8;
    }
    .btn-print:hover {
      background: #1d4ed8;
      color: #ffffff;
    }
    .btn-excel {
      background: #16a34a;
      color: #ffffff;
      border-color: #15803d;
    }
    .btn-excel:hover {
      background: #15803d;
      color: #ffffff;
    }
    .btn-close {
      background: #475569;
      color: #ffffff;
      border-color: #334155;
    }
    .btn-close:hover {
      background: #334155;
      color: #ffffff;
    }

    /* Printable Page Container */
    .report-container {
      max-width: 1100px;
      margin: 20px auto;
      background: #ffffff;
      padding: 24px 30px;
      border-radius: 8px;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    /* Company & Report Header */
    .company-header {
      text-align: center;
      padding-bottom: 14px;
      border-bottom: 2px solid #0f172a;
      margin-bottom: 14px;
    }
    .company-header h1 {
      font-size: 20px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin-bottom: 3px;
    }
    .company-header p.address {
      font-size: 11px;
      color: #475569;
      margin-bottom: 8px;
    }
    .report-title {
      display: inline-block;
      background: #f1f5f9;
      border: 1px solid #cbd5e1;
      color: #1e3a8a;
      font-size: 13px;
      font-weight: 700;
      padding: 4px 16px;
      border-radius: 4px;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }

    /* Metadata Bar */
    .meta-bar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #f8fafc;
      border: 1px solid #e2e8f0;
      border-radius: 6px;
      padding: 8px 12px;
      margin-bottom: 14px;
      font-size: 10.5px;
      color: #334155;
    }
    .meta-bar strong {
      color: #0f172a;
    }

    /* Report Data Table */
    table.leave-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 10.5px;
      margin-bottom: 16px;
    }
    table.leave-table th {
      background: #006ba3;
      color: #ffffff;
      font-weight: 600;
      padding: 7px 6px;
      text-align: left;
      border: 1px solid #006ba3;
      font-size: 10px;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      vertical-align: middle;
    }
    table.leave-table td {
      padding: 6px 6px;
      border: 1px solid #cbd5e1;
      vertical-align: middle;
      color: #1e293b;
    }
    table.leave-table tr:nth-child(even) td {
      background-color: #f8fafc;
    }
    .text-center { text-align: center !important; }
    .text-right { text-align: right !important; }
    .font-bold { font-weight: 700; }

    /* Badges */
    .badge-status {
      display: inline-block;
      padding: 2px 7px;
      border-radius: 10px;
      font-size: 9.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.3px;
      white-space: nowrap;
    }
    .badge-approved {
      background-color: #dcfce7;
      color: #15803d;
      border: 1px solid #86efac;
    }
    .badge-pending {
      background-color: #fef3c7;
      color: #b45309;
      border: 1px solid #fde68a;
    }
    .badge-rejected {
      background-color: #fee2e2;
      color: #b91c1c;
      border: 1px solid #fca5a5;
    }
    .badge-returned {
      background-color: #f3e8ff;
      color: #7e22ce;
      border: 1px solid #d8b4fe;
    }

    .badge-type {
      background-color: #e0f2fe;
      color: #0369a1;
      border: 1px solid #bae6fd;
      padding: 2px 6px;
      border-radius: 4px;
      font-weight: 700;
      font-size: 9.5px;
    }

    /* Signatures Section */
    .signatures-section {
      display: flex;
      justify-content: space-between;
      margin-top: 45px;
      padding-top: 10px;
      page-break-inside: avoid;
    }
    .sig-block {
      text-align: center;
      width: 28%;
    }
    .sig-line {
      border-top: 1px dashed #64748b;
      margin-bottom: 6px;
      padding-top: 4px;
      font-weight: 600;
      color: #0f172a;
      font-size: 10.5px;
    }
    .sig-role {
      font-size: 9.5px;
      color: #64748b;
    }

    /* Print Specific Styles */
    @media print {
      body {
        background-color: #ffffff !important;
        color: #000000 !important;
        font-size: 10px;
      }
      .no-print, .top-toolbar {
        display: none !important;
      }
      .report-container {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        border-radius: 0 !important;
      }
      @page {
        size: A4 landscape;
        margin: 8mm 10mm 10mm 10mm;
      }
      table.leave-table th {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
        border: 1px solid #94a3b8 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }
      table.leave-table td {
        border: 1px solid #94a3b8 !important;
      }
      table.leave-table tr {
        page-break-inside: avoid;
      }
      .signatures-section {
        margin-top: 40px;
        page-break-inside: avoid;
      }
    }
  </style>
</head>
<body>

  <!-- Top Toolbar (Non-Printable) -->
  <div class="top-toolbar no-print">
    <div class="title-area">
      <span>Leave Report Preview</span>
      <span class="badge"><?= count($records) ?> Records</span>
    </div>
    <div class="btn-group">
      <button type="button" class="btn btn-print" onclick="window.print()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="6 9 6 2 18 2 18 9"></polyline>
          <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
          <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Print / Save as PDF
      </button>

      <?php
        // Build Excel export URL with identical parameters
        $excel_url = base_url('entry_system_con/export_leave_excel?' . http_build_query($_GET));
      ?>
      <a href="<?= $excel_url ?>" class="btn btn-excel">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
          <polyline points="14 2 14 8 20 8"></polyline>
          <line x1="8" y1="13" x2="16" y2="13"></line>
          <line x1="8" y1="17" x2="16" y2="17"></line>
          <polyline points="10 9 9 9 8 9"></polyline>
        </svg>
        Export Excel (.xls)
      </a>

      <button type="button" class="btn btn-close" onclick="window.close()">
        Close
      </button>
    </div>
  </div>

  <!-- Printable Report Container -->
  <div class="report-container">
    <!-- Header -->
    <div class="company-header">
      <h1><?= htmlspecialchars(!empty($company_info->company_name_english) ? $company_info->company_name_english : 'Islam Oxygen Limited') ?></h1>
      <p class="address"><?= htmlspecialchars(!empty($company_info->company_add_english) ? $company_info->company_add_english : 'Corporate Office, Dhaka, Bangladesh') ?></p>
      <div class="report-title">EMPLOYEE LEAVE REPORT</div>
    </div>

    <!-- Metadata Bar -->
    <div class="meta-bar">
      <div>
        <strong>Filter Criteria:</strong> <?= htmlspecialchars($filter_summary) ?>
      </div>
      <div>
        <strong>Total Records:</strong> <?= count($records) ?> | 
        <strong>Printed On:</strong> <?= date('d-M-Y h:i A') ?>
      </div>
    </div>

    <!-- Data Table -->
    <table class="leave-table">
      <thead>
        <tr>
          <th style="width: 32px;" class="text-center">SL</th>
          <th style="width: 75px;" class="text-center">Emp ID</th>
          <th style="width: 140px;">Employee Name</th>
          <th style="width: 120px;">Department</th>
          <th style="width: 120px;">Designation</th>
          <th style="width: 55px;" class="text-center">Type</th>
          <th style="width: 80px;" class="text-center">Start Date</th>
          <th style="width: 80px;" class="text-center">End Date</th>
          <th style="width: 48px;" class="text-center">Days</th>
          <th style="width: 90px;" class="text-center">Status</th>
          <th>Reason / Description</th>
          <th style="width: 90px;">Unit</th>
        </tr>
      </thead>
      <tbody>
        <?php if (empty($records)): ?>
          <tr>
            <td colspan="12" class="text-center" style="padding: 25px; color: #64748b; font-size: 12px;">
              No leave records found matching the specified criteria.
            </td>
          </tr>
        <?php else: ?>
          <?php $i = 1; $total_days_sum = 0; ?>
          <?php foreach ($records as $r): ?>
            <?php
              $total_days_sum += floatval($r->total_leave);
              $st = !empty($r->status) ? strtolower($r->status) : 'approved';
              $badgeClass = 'badge-' . $st;
              $statusLabel = ucfirst($st);
              if ($st === 'pending') $statusLabel = 'Pending Admin';
            ?>
            <tr>
              <td class="text-center"><?= $i++ ?></td>
              <td class="text-center font-bold"><?= htmlspecialchars($r->emp_id) ?></td>
              <td class="font-bold"><?= htmlspecialchars(!empty($r->user_name) ? $r->user_name : $r->name_en) ?></td>
              <td><?= htmlspecialchars(!empty($r->dept_name) ? $r->dept_name : '-') ?></td>
              <td><?= htmlspecialchars(!empty($r->desig_name) ? $r->desig_name : '-') ?></td>
              <td class="text-center"><span class="badge-type"><?= strtoupper($r->leave_type) ?></span></td>
              <td class="text-center"><?= !empty($r->leave_start) ? date('d-M-Y', strtotime($r->leave_start)) : '-' ?></td>
              <td class="text-center"><?= !empty($r->leave_end) ? date('d-M-Y', strtotime($r->leave_end)) : '-' ?></td>
              <td class="text-center font-bold"><?= $r->total_leave ?></td>
              <td class="text-center">
                <span class="badge-status <?= $badgeClass ?>"><?= $statusLabel ?></span>
              </td>
              <td><?= htmlspecialchars(!empty($r->leave_descrip) ? $r->leave_descrip : '-') ?></td>
              <td><?= htmlspecialchars(!empty($r->unit_name) ? $r->unit_name : '-') ?></td>
            </tr>
          <?php endforeach; ?>
          <!-- Grand Total Summary Row -->
          <tr style="background-color: #f1f5f9; font-weight: bold;">
            <td colspan="8" class="text-right" style="padding: 8px;">Total Leave Days:</td>
            <td class="text-center" style="font-size: 11.5px;"><?= $total_days_sum ?></td>
            <td colspan="3"></td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <!-- Signatures -->
    <div class="signatures-section">
      <div class="sig-block">
        <div class="sig-line">Prepared By</div>
        <div class="sig-role">HR Department / Officer</div>
      </div>
      <div class="sig-block">
        <div class="sig-line">Checked By</div>
        <div class="sig-role">HR Manager / In-Charge</div>
      </div>
      <div class="sig-block">
        <div class="sig-line">Approved By</div>
        <div class="sig-role">Managing Director / Admin</div>
      </div>
    </div>
  </div>

  <?php if (!empty($_GET['autoprint']) && $_GET['autoprint'] == '1'): ?>
  <script>
    window.addEventListener('load', function() {
      setTimeout(function() {
        window.print();
      }, 500);
    });
  </script>
  <?php endif; ?>

</body>
</html>
