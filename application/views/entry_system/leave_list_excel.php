<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$filename = "Leave_Report_" . date('Ymd_His') . ".xls";
if (!headers_sent()) {
    header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Cache-Control: max-age=0");
    header("Pragma: public");
}
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--[if gte mso 9]>
<xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>Leave Report</x:Name>
    <x:WorksheetOptions>
     <x:DisplayGridlines/>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
 </x:ExcelWorkbook>
</xml>
<![endif]-->
<style>
  body { font-family: 'Segoe UI', Arial, sans-serif; font-size: 11pt; color: #1e293b; }
  table { border-collapse: collapse; width: 100%; }
  th { background-color: #006ba3; color: #ffffff; font-weight: bold; padding: 10px 8px; border: 1px solid #94a3b8; text-align: center; vertical-align: middle; }
  td { padding: 8px; border: 1px solid #cbd5e1; vertical-align: middle; }
  .text-center { text-align: center; }
  .text-right { text-align: right; }
  .company-title { font-size: 16pt; font-weight: bold; text-align: center; color: #006ba3; }
  .company-sub { font-size: 10pt; text-align: center; color: #64748b; }
  .report-title { font-size: 13pt; font-weight: bold; text-align: center; color: #006ba3; padding: 10px 0; }
  .filter-info { font-size: 9pt; color: #475569; text-align: center; margin-bottom: 15px; }
  .status-approved { background-color: #dcfce7; color: #15803d; font-weight: bold; text-align: center; }
  .status-pending { background-color: #fef3c7; color: #b45309; font-weight: bold; text-align: center; }
  .status-rejected { background-color: #fee2e2; color: #b91c1c; font-weight: bold; text-align: center; }
  .status-returned { background-color: #f3e8ff; color: #7e22ce; font-weight: bold; text-align: center; }
</style>
</head>
<body>
<table>
  <tr>
    <td colspan="12" class="company-title"><?= htmlspecialchars(!empty($company_info->company_name_english) ? $company_info->company_name_english : 'Islam Oxygen Limited') ?></td>
  </tr>
  <tr>
    <td colspan="12" class="company-sub"><?= htmlspecialchars(!empty($company_info->company_add_english) ? $company_info->company_add_english : '') ?></td>
  </tr>
  <tr>
    <td colspan="12" class="report-title">EMPLOYEE LEAVE REPORT</td>
  </tr>
  <tr>
    <td colspan="12" class="filter-info">
      <strong>Generated:</strong> <?= date('d-M-Y h:i A') ?> | 
      <strong>Filter Criteria:</strong> <?= htmlspecialchars($filter_summary) ?> | 
      <strong>Total Records:</strong> <?= count($records) ?>
    </td>
  </tr>
  <tr><td colspan="12"></td></tr>
  <thead>
    <tr>
      <th style="width: 45px;">SL</th>
      <th style="width: 85px;">Emp ID</th>
      <th style="width: 180px;">Employee Name</th>
      <th style="width: 140px;">Department</th>
      <th style="width: 140px;">Designation</th>
      <th style="width: 75px;">Type</th>
      <th style="width: 100px;">Start Date</th>
      <th style="width: 100px;">End Date</th>
      <th style="width: 75px;">Days</th>
      <th style="width: 100px;">Status</th>
      <th style="width: 200px;">Reason / Description</th>
      <th style="width: 140px;">Unit Name</th>
    </tr>
  </thead>
  <tbody>
    <?php if (empty($records)): ?>
    <tr>
      <td colspan="12" class="text-center" style="padding: 20px; color: #64748b;">No leave records found matching criteria.</td>
    </tr>
    <?php else: ?>
      <?php $i = 1; $total_days_sum = 0; ?>
      <?php foreach ($records as $r): ?>
        <?php 
          $total_days_sum += floatval($r->total_leave); 
          $st = !empty($r->status) ? strtolower($r->status) : 'approved';
          $stClass = 'status-' . $st;
          $stLabel = ucfirst($st);
          if ($st === 'pending') $stLabel = 'Pending Admin';
        ?>
        <tr>
          <td class="text-center"><?= $i++ ?></td>
          <td class="text-center" style="mso-number-format:'\@';"><?= htmlspecialchars($r->emp_id) ?></td>
          <td><?= htmlspecialchars(!empty($r->user_name) ? $r->user_name : $r->name_en) ?></td>
          <td><?= htmlspecialchars(!empty($r->dept_name) ? $r->dept_name : '-') ?></td>
          <td><?= htmlspecialchars(!empty($r->desig_name) ? $r->desig_name : '-') ?></td>
          <td class="text-center" style="font-weight: bold;"><?= strtoupper($r->leave_type) ?></td>
          <td class="text-center"><?= !empty($r->leave_start) ? date('d-M-Y', strtotime($r->leave_start)) : '-' ?></td>
          <td class="text-center"><?= !empty($r->leave_end) ? date('d-M-Y', strtotime($r->leave_end)) : '-' ?></td>
          <td class="text-center" style="font-weight: bold;"><?= $r->total_leave ?></td>
          <td class="<?= $stClass ?>"><?= $stLabel ?></td>
          <td><?= htmlspecialchars(!empty($r->leave_descrip) ? $r->leave_descrip : '-') ?></td>
          <td><?= htmlspecialchars(!empty($r->unit_name) ? $r->unit_name : '-') ?></td>
        </tr>
      <?php endforeach; ?>
      <tr style="font-weight: bold; background-color: #f1f5f9;">
        <td colspan="8" class="text-right">Total Leave Days:</td>
        <td class="text-center"><?= $total_days_sum ?></td>
        <td colspan="3"></td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>
</body>
</html>
