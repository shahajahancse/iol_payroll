<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Costing Summary</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
@media print {

}
</style>
</head>

<body  id="report-data">
  <div style=" margin:0 auto;  width:850px;">
    <?php
      $data1['unit_id'] = $unit_id;
      $this->load->view("head_english",$data1);
    ?>
    <!--Report title goes here-->
    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:12px;  font-weight:bold;">
      Daily Costing Summary <?php echo "$grid_date"; ?></span>
      <br />
      <br />
      <?php  $num_of_days 	= date("t",strtotime($grid_date)); ?>
      <table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:14px;">
        <thead>
          <tr>
            <th style="padding:5px">SL</th>
            <th style="padding:5px">Line</th>
            <th style="padding:5px">Emp</th>
            <th style="padding:5px">Gross Sal</th>
            <th style="padding:5px">Per Day Salary</th>
            <th style="padding:5px">OT Hour</th>
            <th style="padding:5px">EOT Hour</th>
            <th style="padding:5px">OT Amount</th>
            <th style="padding:5px">EOT Amount</th>
            <th style="padding:5px">Night Allowence</th>
            <th style="padding:5px">Holiday Allowence</th>
            <th style="padding:5px">Ifter Allowence</th>
            <th style="padding:5px">Total Salary</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sl = 1;
          $grand_total=0;
          foreach ($values as $item) {
            // dd($item);

          if($item->line_name_en == "Security"){
            continue;
          }else{
            $total_salary = $item->present_gross_salary - $item->absent_gross_salary + ($item->ot) + ($item->eot );
            $grand_total += $total_salary;
          ?>
            <tr>
              <td style="padding:5px;text-align:center"><?php echo $sl++; ?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->line_name_en; ?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->present_emp;@$total_emp +=$item->present_emp ?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->present_gross_salary; @$total_gross_salary +=$item->present_gross_salary?></td>
              <td style="padding:5px;text-align:center"><?php echo round($item->present_gross_salary / $num_of_days); @$perday_salary += round($item->present_gross_salary / $num_of_days)?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->ot;@$total_ot +=$item->ot ?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->eot; @$total_eot +=$item->eot?></td>
              <td style="padding:5px;text-align:center"><?php echo (($item->present_emp != 0) ? round(($item->present_gross_salary/104)*$item->ot/$item->present_emp,2) : 0); @$total_ot_amount += (($item->present_emp != 0) ? round($item->present_gross_salary/104,2)*$item->ot : 0)?></td>
              <td style="padding:5px;text-align:center"><?php echo (($item->present_emp != 0) ? round(($item->present_gross_salary/104)*$item->eot/$item->present_emp,2) : 0); @$total_eot_amount += (($item->present_emp != 0) ? round($item->present_gross_salary/104,2)*$item->eot : 0)?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->night_allowence; @$total_night_amount += $item->night_allowence?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->holiday_allowence; @$total_holiday_amount += $item->holiday_allowence?></td>
              <td style="padding:5px;text-align:center"><?php echo $item->ifter_allowence; @$total_ifter_amount += $item->ifter_allowence?></td>
              <td style="padding:5px;text-align:center"><?php echo $total_salary;?></td>
            </tr>
          <?php
            } }
          ?>
        </tbody>
        <tfoot>
          <tr>
              <td colspan="2" style="text-align:center">Grand Total</td>
              <td colspan="1" style="text-align:center"><?php echo @$total_emp?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_gross_salary?></td>
              <td colspan="1" style="text-align:center"><?php echo @$perday_salary?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_ot?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_eot?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_ot_amount?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_eot_amount?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_night_amount?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_holiday_amount?></td>
              <td colspan="1" style="text-align:center"><?php echo @$total_ifter_amount?></td>
              <td colspan="1" style="text-align:center"><?php echo @$grand_total?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <br><br>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
	<script>
		function convert_excel(type, fn, dl) {
			var elt = document.getElementById('report-data');
			var wb = XLSX.utils.table_to_book(elt, {sheet:"Sheet JS"});
			return dl ?
				XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
				XLSX.writeFile(wb, fn || ('Reports.' + (type || 'xlsx')));
		}
		$("#btnExport").click(function(event) {
		convert_excel('xlsx');
		});
	</script>
</body>
</html>
<?php exit(); ?>
