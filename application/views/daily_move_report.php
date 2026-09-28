<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Job Card</title>
</head>
<style>
		.bordered {
    border: 2px solid black;
    border-collapse: collapse;
	font-size:12px;
	border-radius:3px;
	
}
.bordered td, .bordered th {
    border: 1px solid #ffff;
	
}
.bordered th {
   background: #C9C9C9;
}
.bordered tr:nth-of-type(odd) {
    background-color: #F7F7F7;
}
 
.bordered tr:hover {
    background: #C9C9C9;
    -o-transition: all 0.1s ease-in-out;
    -webkit-transition: all 0.1s ease-in-out;
    -moz-transition: all 0.1s ease-in-out;
    -ms-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;     
}


</style>
<body>
<div align="center" style="height:100%; width:100%; overflow:hidden;" >

<?php
//print_r($values);


$count = count($values["emp_id"]);

for($i = 0; $i<$count;$i++)
{
	//echo $i;
	echo "<div style='min-height:650px; overflow:hidden;'>";


	$this->load->view('head_english');
	$date = date("d-M-Y", strtotime($grid_firstdate));
	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Daily Movement Report of &nbsp $date";
	echo "</span>";
	echo "<br /><br />";
	
	$emp_id = $values["emp_id"][$i];
	echo "<table border='0' style='font-size:13px;width:500px; margin-bottom:10px;'>";
	echo "<tr>";
	echo "<td width='70'>";
	echo "<strong>Emp ID:</strong>";
	echo "</td>";
	echo "<td width='200'>";
	echo $values["emp_id"][$i];
	echo "</td>";
	
	echo "<td width='50'>";
	echo "<strong>Name :</strong>";
	echo "</td>";
	echo "<td width='150'>";
	echo $values["emp_full_name"][$i];
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td >";
	echo "<strong>Proxi NO. :</strong>";
	echo "</td>";
	echo "<td >";
	echo $values["proxi_id"][$i];
	echo "</td>";
	
	echo "<td>";
	echo "<strong>Section :</strong>";
	echo "</td>";
	echo "<td >";
	echo $values["sec_name"][$i];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>Line :</strong>";
	echo "</td>";
	echo "<td>";
	echo $values["line_name"][$i];
	echo "</td>";
	echo "<td>";
	echo "<strong>Desig :</strong>";
	echo "</td>";
	echo "<td>";
	echo $values["desig_name"][$i];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>DOJ :</strong>";
	echo "</td>";
	echo "<td>";
	echo $values["emp_join_date"][$i];
	echo "</td>";
	
	echo "<td >";
	echo "<strong>Dept :</strong>";
	echo "</td>";
	
	echo "<td >";
	echo $values["dept_name"][$i];
	echo "</td>";
	echo "</tr>";
	echo "<table>";
	
	$count1 = count($values[$emp_id]["time"]);
	
	echo "<table class='bordered'  border='1' style='font-size:13px; width:500px;text-align: center;   border-collapse: collapse;'><th>Date</th> <th>Time</th><th>Remarks</th>";
	for($k = 0; $k<$count1;$k++)
	{
		//echo $values[$emp_id]["shift_log_date"][$k];
		//echo "<br>";
		
		echo "<tr>";
		
		echo "<td>";
		echo $values[$emp_id]["date"][$k];
		echo "</td>";
		
		echo "<td>";
		echo $values[$emp_id]["time"][$k];
		echo "</td>";
		
		
		echo "<td>";
		echo "&nbsp";
		echo "</td>";
		
		echo "</tr>";
	}
			
	echo "</table>";
	
	echo "<br>";
	
			
	
	echo "</table>";
	echo "<br /><br />";
	
	echo "</div>";
	echo "<br>";
}
?>

</div>
</body>
</html>
