<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manual Attendance Sheet</title>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script>
var check;
var j;
function time_validation(i)
{
	
	if(check == i)
	{
		j = parseInt(j) +  parseInt(1);
		//alert(j);
	}
	else{
		j = 0;
		j = parseInt(j) + parseInt(1);
		//alert(j);
	}
	check = i;
	
	manual_intime 			= "#manual_intime"+i;
	manual_intime_text 		= "manual_intime"+i;
	manual_intime_value			= $(manual_intime).val();

	
	if(j == '3' || j == '6')
	{
		//alert(j);
		var last1 = manual_intime_value.slice(-1);
		if(last1 != ":")
		{
			var newString = manual_intime_value.substr(0, manual_intime_value.length-1); 
			//alert(last1);
			document.getElementById(manual_intime_text).value = newString;
			j = parseInt(j) - parseInt(1);
		}
	}
	
	//alert(manual_intime_value);
	
}
</script>
</head>

<body>
<div align="center" style="height:100%; width:100%; overflow:hidden;" >

<?php
//print_r($values);
	echo "<div style='min-height:1100px; overflow:hidden;'>";


	$this->load->view('head_english');
	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Manual Attendance Sheet from  $grid_firstdate -TO- $grid_seconddate";
	echo "</span>";
	echo "<br /><br />";
	
	$emp_id = $values["emp_id"];
	echo "<table border='0' style='font-size:13px;' width='480'>";
	echo "<tr>";
	echo "<td width='70'>";
	echo "<strong>Emp ID:</strong>";
	echo "</td>";
	echo "<td width='200'>";
	echo $values["emp_id"];
	echo "</td>";
	
	echo "<td width='50'>";
	echo "<strong>Name :</strong>";
	echo "</td>";
	echo "<td width='150'>";
	echo $values["emp_full_name"];
	echo "</td>";
	echo "</tr>";
	
	echo "<tr>";
	echo "<td >";
	echo "<strong>Proxi NO. :</strong>";
	echo "</td>";
	echo "<td >";
	echo $values["proxi_id"];
	echo "</td>";
	
	echo "<td>";
	echo "<strong>Section :</strong>";
	echo "</td>";
	echo "<td >";
	echo $values["sec_name"];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>Line :</strong>";
	echo "</td>";
	echo "<td>";
	echo $values["line_name"];
	echo "</td>";
	echo "<td>";
	echo "<strong>Desig :</strong>";
	echo "</td>";
	echo "<td>";
	echo $values["desig_name"];
	echo "</td>";
	echo "</tr>";
	echo "<tr>";
	echo "<td>";
	echo "<strong>DOJ :</strong>";
	echo "</td>";
	echo "<td>";
	echo $values["emp_join_date"];
	echo "</td>";
	
	echo "<td >";
	echo "<strong>Dept :</strong>";
	echo "</td>";
	echo "<td >";
	echo $values["dept_name"];
	echo "</td>";
	echo "</tr>";
	echo "<table>";
	
	$count1 = count($values["shift_log_date"]);
		echo "<br />";
	echo "<table width='480' border='1' bordercolor='#000000' cellspacing='0' cellpadding='2' style='text-align:center; font-size:13px; '> <th>Date</th><th>In Time</th><th>Out Time</th><th>In Time [HH:MM:SS]</th><th>Out Time [HH:MM:SS]</th>";
	?>
	<form action="<?php echo base_url();?>entry_system_con/manual_attendance_sheet_entry" method="post" >
	<input type="hidden" name="count" id="count"  value="<?php 	echo $count1; ?>"/>
	<input type="hidden" name="emp_id" id="emp_id"  value="<?php echo $values["emp_id"]; ?>"/>
	<input type="hidden" name="proxi" id="proxi"  value="<?php echo $values["proxi_id"]; ?>"/>
	<?php
	
	for($k = 0; $k<$count1;$k++)
	{
	?>	
		
		<tr>
		<td style ='width:130px;'>
		<?php 
			echo date("d-M-Y", strtotime( $values["shift_log_date"][$k]));
			
			$manual_date = date("Y-m-d", strtotime( $values["shift_log_date"][$k]));
			?>
			<input type="hidden" name="manual_date<?php echo $k;?>" id="manual_date<?php echo $k;?>"  value="<?php echo $manual_date; ?>"/>
		</td>
		
		<td style ='width:130px;'>
		<?php 
		
		if($values["in_time"][$k] == "00:00:00"){
			echo "Null";		
		}
		else{
			echo $values["in_time"][$k];
		}
			?>
		</td>
		
		<td style ='width:130px;'>
		<?php 
		if($values["out_time"][$k] == "00:00:00"){
			echo "Null";		
		}
		else{
			echo $values["out_time"][$k];
		}
			?>
		</td>
		
		<td  style ='width:130px;'>
		<!--<input type="text" style="border:1px solid #6E7C8B; font-weight:bold;" name="manual_intime<?php echo $k;?>" id="manual_intime<?php echo $k;?>" onkeyup="time_validation(<?php echo $k; ?>)" /> -->
		<input type="text" style="border:1px solid #6E7C8B; font-weight:bold;" name="manual_intime<?php echo $k;?>" id="manual_intime<?php echo $k;?>" />
		</td>
				
		<td  style ='width:130px;'><input type="text" style="border:1px solid #6E7C8B;font-weight:bold;" name="manual_outtime<?php echo $k;?>" id="manual_outtime<?php echo $k;?>" /></td>
		</tr>
	<?php	
	}
	?>		
		<tr><td colspan="5"><input type="submit" value="Submit"  /></td></tr>

	</table>
	
</form>
	</div>

</div>
</body>
</html>
