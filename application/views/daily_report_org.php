<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily
<?php 
if ($daily_status == "A")
{
	echo "Absent";
}
elseif($daily_status == "P")
{
	echo "Present";
}
elseif($daily_status == "L")
{
	echo "Leave";
}
  
?> 
 Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />

</head>

<body>
<?php //print_r($values); 
//echo $daily_status;
$base_url = base_url();
$url = $base_url."payroll_con/daily_report_export/$year/$month/$date/$daily_status/$col_desig/$col_line/$col_section/$col_dept/$col_all/$unit_id";
?>
<div style=" margin:0 auto;  width:800px;">
<div id="no_print" style="float:right;">
<!--<a href="<?php //echo $url ?>"><img height="30px" width="30px" src="<?php //echo $base_url.'images/xls.jpg'; ?>" align="" /></a>-->
</div>
<?php 
//$emp_id = $values["emp_id"][1];
//$data['unit_id'] = $this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
$this->load->view("head_english");
//$this->load->view("head_english");
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
Daily 
<?php 
if ($daily_status == "A")
{
	echo "Absent";
}
elseif($daily_status == "P")
{
	echo "Present";
}
elseif($daily_status == "L")
{
	echo "Leave";
}
  
?> Report of <?php echo "$date/$month/$year"; ?></span>
<br />
<br />


<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px;">
<!--<th>SL</th><th>Emp ID</th><th>Punch Card No.</th><th>Employee Name</th> <!--<th>DOJ</th>--> <!--<th>Department</th> <th>Section</th> <th>Line No. </th> <th>Designation</th> <!--<th>Shift</th>-->

<?php
$section=array();
$i=0;
$count = count($values["emp_id"]);
for($i=0; $i<$count; $i++ )
{
	
	if($section!=$values["sec_name"][$i]){
	echo "<tr bgcolor='#CCCCCC'>";
	echo "<td colspan='10' style='font-size:16px'>Section :&nbsp".$values["sec_name"][$i]."</td>";
	echo "</tr>";
	
	 ?>
	<th>SL</th><th>Emp ID</th><th>Punch Card No.</th><th>Employee Name</th> <!--<th>DOJ</th>--> <!--<th>Department</th><th>Section</th>-->  <th>Line No. </th> <th>Designation</th> 
	<?php
	if($daily_status == "P")
	{
		echo "<th>IN Time</th> ";
		echo "<th>OUT Time</th> ";
	}
?>
<th>Status</th>
<?php
	if($daily_status == "A")
	{
		echo "<th>Remarks</th> ";
		echo "<th>Sign.</th> ";
	}


	
	}

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
	
	/*echo "<td >";
	echo $values["dept_name"][$i];
	echo "</td>";
	
	echo "<td >";
	echo $values["sec_name"][$i];
	echo "</td>";*/
	
	echo "<td >";
	echo $values["line_name"][$i];
	echo "</td>";
	
	echo "<td >";
	echo $values["desig_name"][$i];
	echo "</td>";
	
	//echo "<td >";
	//echo $values["emp_shift"][$i];
	//echo "</td>";
	
	if($daily_status == "P")
	{
		echo "<td width='80' align='center'>";
		echo $in_time =  $values["in_time"][$i];
		echo "</td>";
		
		echo "<td width='80' align='center'>";
		if($values["out_time"][$i]=='')
		{
			echo "";
		}
		elseif($values["out_time"][$i]== "12:00:00 AM")
		{
			echo "";
		}
		else
		{
			echo $values["out_time"][$i];
		}
		echo "</td>";
	}
	
	echo "<td style='text-align:center'>";
	echo $values["status"][$i];
	echo "</td>";
	
	if($daily_status == "A")
	{
		
	  echo "<td style='text-align:center' >";
	  echo "";
	  echo "</td>";
	  
	  echo "<td style='text-align:center' width='80'>";
	  echo "";
	  echo "</td>";
	
	}
	echo "</tr>";
		$section=$values["sec_name"][$i];
}

?>

</table>
</div>
</div>
</body>
</html>