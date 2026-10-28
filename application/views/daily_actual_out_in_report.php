<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily OUT and IN Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/SingleRow.css" />
<style>
@media print {
    #btnExport {
        display: none;
    }
}
</style>
</head>

<body>
<button style='position:absolute; margin-left:50px; cursor:pointer;' id="btnExport">Download as Excel</button>
<div style=" margin:0 auto;  width:950px;">
<div id="no_print" style="float:right;">
<!--<a href="<?php //echo $url ?>"><img height="30px" width="30px" src="<?php //echo $base_url.'images/xls.jpg'; ?>" align="" /></a>-->
</div>
<?php 
$this->load->view("head_english");
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
Daily OUT and IN Report of <?php echo "$date/$month/$year"; ?></span>
<br />
<br />


<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;" id="report-data">
<th>SL</th><th>Emp ID</th><th>Punch Card No.</th><th>Employee Name</th> <!--<th>DOJ</th>--> <th>Department</th> <th>Section</th> <th>Designation</th> <th>Per Shift</th><th>Shift</th><th>Previous Day OUT Time</th><th>IN Time</th><th>OUT Time</th><th>Status</th>

<?php

$first_date =  "$year-$month-$date";

$date = strtotime(date("Y-m-d", strtotime($first_date)) . " -1 day");
$day = date("Y-m-d", $date);
//echo $day = date('Y-m-d', $second_date);
$count = count($values["emp_id"]);
for($i=0; $i<$count; $i++ )
{
	echo "<tr>";
	
	echo "<td>";
	echo $k = $i+1;
	echo "</td>";
	
	echo "<td>";
	echo $values["emp_id"][$i];
	echo "</td>";
	
	echo "<td>";
	echo "&nbsp;";
	echo $values["proxi_id"][$i];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_name"][$i];
	echo "</td>";
	
	/*echo "<td>";
	$year= trim(substr($values["doj"][$i],0,4));
	$month = trim(substr($values["doj"][$i],5,2));
	$tarik = trim(substr($values["doj"][$i],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";*/
	
	echo "<td >";
	echo $values["dept_name"][$i];
	echo "</td>";
	
	echo "<td >";
	echo $values["sec_name"][$i];
	echo "</td>";
	
	
	
	echo "<td >";
	echo $values["desig_name"][$i];
	echo "</td>";
	
	echo "<td >";
	echo !empty($values["emp_per_shift"][$i]) ? $values["emp_per_shift"][$i] : '';
	echo "</td>";

	echo "<td >";
	echo $values["emp_shift"][$i];
	echo "</td>";
	
	echo "<td style='text-align:center'>";
	echo $values["p_out"][$i];
	echo "</td>";
		
	echo "<td width='80' align='center'>";
	if($values["in_time"][$i] == '00:00:00' || $values["status"][$i] == 'OD')
	{
		echo "";
	}
	else
	{
		echo $values["in_time"][$i];
	}
	echo "</td>";
		
	echo "<td width='80' align='center'>";
	if($values["out_time"][$i] == '' || $values["out_time"][$i] == '00:00:00' || $values["status"][$i] == 'OD')
	{
		echo "";
	}
	else
	{
		echo $values["out_time"][$i];
	}
	echo "</td>";
		
	echo "<td style='text-align:center'>";
	echo $values["status"][$i];
	echo "</td>";
	
	
	echo "</tr>";
}

?>

</table>
</div>
</div>
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
