<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Job Card Modify</title>
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
<style type="text/css">
	input{width: 80px;}
</style>
</head>

<body>
<div align="center" style="height:100%; width:100%; overflow:hidden;" >

<?php
//print_r($values);
	echo "<div style='min-height:1100px; overflow:hidden;'>";


	$this->load->view('head_english');
	echo "<span style='font-size:13px; font-weight:bold;'>";
	echo "Job Card Modification Sheet from  $grid_firstdate -TO- $grid_seconddate";
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
	echo "<table width='480' border='1' bordercolor='#000000' cellspacing='0' cellpadding='2' style='text-align:center; font-size:13px; '> <th>Date</th><th>In Time</th><th>Out Time</th><th>Status</th><th>OT</th><th>EOT</th>";
	?>
	<form action="<?php echo base_url();?>entry_system_con/manual_eot_modify_entry" method="post" id="ot_modify" name="ot_modify">
	<input type="hidden" name="count" id="count"  value="<?php 	echo $count1; ?>"/>
	<input type="hidden" name="emp_id" id="emp_id"  value="<?php echo $values["emp_id"]; ?>"/>
	<input type="hidden" name="proxi" id="proxi"  value="<?php echo $values["proxi_id"]; ?>"/>
	<?php
	
	for($k = 0; $k<$count1;$k++)
	{
	?>	
		
		<tr>
		<td style ='width:120px;'>
		<?php 
			echo date("d-M-Y", strtotime( $values["shift_log_date"][$k]));
			
			$manual_date = date("Y-m-d", strtotime( $values["shift_log_date"][$k]));
			?>
			<input type="hidden" name="manual_date<?php echo $k;?>" id="manual_date<?php echo $k;?>"  value="<?php echo $manual_date; ?>"/>
		</td>
		
		<td  style ='width:120px;'>

			<input type="text" style="border:1px solid #6E7C8B;font-weight:bold;" name="modify_in_time<?php echo $k;?>" id="modify_in_time<?php echo $k;?>" value="<?php echo $values["in_time"][$k] ?>" onchange="check_out_time_value(<?php echo $k;?>)"/>
		</td>
				
		<td  style ='width:120px;'>

			<input type="text" style="border:1px solid #6E7C8B;font-weight:bold;" name="modify_out_time<?php echo $k;?>" id="modify_out_time<?php echo $k;?>" value="<?php echo $values["out_time"][$k] ?>" onchange="check_out_time_value(<?php echo $k;?>)"/>
		</td>
		<td  style ='width:120px;'>
			<input type="text" style="border:1px solid #6E7C8B;font-weight:bold;" name="present_status<?php echo $k;?>" id="present_status<?php echo $k;?>" value="<?php echo $values["present_status"][$k] ?>" />
		</td>	
		<td  style ='width:120px;'>
			<input type="text" style="border:1px solid #6E7C8B;font-weight:bold;" name="modify_ot_hour<?php echo $k;?>" id="modify_ot_hour<?php echo $k;?>" value="<?php echo $values["ot_hour"][$k] ?>" readonly/>
		</td>	
		<td  style ='width:120px;'>
			<input type="text" style="border:1px solid #6E7C8B;font-weight:bold;" name="modify_eot_hour<?php echo $k;?>" id="modify_eot_hour<?php echo $k;?>" value="<?php echo $values["extra_ot_hour"][$k] ?>" readonly/>
		</td>
		
		</tr>
	<?php	
	}
	?>		
		<tr><td colspan="5"><input style="background: green;color:#000" type="submit" value="Submit" disabled/></td></tr>

	</table>
	
</form>
	</div>

</div>
<script type="text/javascript">

  	 var count_for_ot_update = $('#count').val();
		// alert('emp_id');exit;

    function check_out_time_value(k)
      {
      	// alert("here");exit;
		var i;
		var counter = 0;

		var manual_d = '#manual_date'+k; 
		var in_t = '#modify_in_time'+k; 
		var out_t = '#modify_out_time'+k; 
		var ot_hour_id = '#modify_ot_hour'+k;
		var eot_hour_id = '#modify_eot_hour'+k;
		var present_status = '#present_status'+k;
		// alert(present_status);
		var emp_id = $('#emp_id').val();
		var manual_date = $(manual_d).val();
		var in_time = $(in_t).val();
		var out_time = $(out_t).val();
		// var ot_hour_val = $(ot_hour_val).val();
		var present_sts = $(present_status).val();
		// alert(present_sts);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>/entry_system_con/check_out_time_value",
            data:{
            	emp_id : emp_id,
                manual_date: manual_date,
                in_time: in_time,
                out_time: out_time,
                ot_hour_id: ot_hour_id,
                eot_hour_id: eot_hour_id,
                present_status: present_sts
            },
            success: function(data)
            {
                console.log(data);

                var jsonData = $.parseJSON(data);

                console.log(jsonData);

        		// alert(jsonData.manual_date+'=='+jsonData.ot_hour);
                $(jsonData.ot_hour_id).val(jsonData.ot_hour);
                $(jsonData.eot_hour_id).val(jsonData.eot_hour);
                // $('#modify_ot_hour'+k).val(jsonData.eot_hour);

            }
        });
	} 
	
</script>
</body>
</html>
