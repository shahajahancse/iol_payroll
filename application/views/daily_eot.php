<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily EOT</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	table.main_table{
	border-collapse: collapse;
}

table.main_table tr,table.main_table tr td,table.main_table tr th{
 border: 1px solid #000000;
 
}
</style>
</head>

<body>
<?php 
// echo count($section);
$per_page_id = 22;
$row_count = count($values["emp_id"]);
$max = $row_count;
if($row_count >$per_page_id)
{
$page=ceil($row_count/$per_page_id);
}
else
{
$page=1;
}

$k = 0;
$total_otEot_amount = 0;
$total_otEot_hour = 0;
$total_deduction_hour = 0;

for($counter = 1; $counter <= $page; $counter ++)
{
$sec_otEot_amount = 0;
$sec_otEot_hour = 0;
$sec_deduction_hour = 0;
 ?>
<div style=" margin:0 auto;  width:750px;">
<table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:150px;">
		<?php $this->load->view("head_english");?> <span style="font-size:13px; font-weight:bold; text-align: center;">
			Daily EOT Report of <?php echo "$start_date"; ?>
			</span>
		</td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ;font-size:15px;">'."পাতা নং # $counter <br>".'</span>';?>
		</td>
	</tr>
</table>


<table class="main_table" align="center" style="font-size:12px; width:750px;">
<th>SL</th><th>Emp ID</th><th>Employee Name</th> <!--<th>DOJ</th>--> <th>Department</th>  <th>Line No. </th> <th>Designation</th><th>Gross</th> <th>EOT Rate</th> <th>IN Time</th> <th>Out Time</th> <th>OT/EOT Hour</th><th>OT/EOT Amt</th>


<?php
	
	$section=array();
	for($i=0; $i<=$per_page_id; $i++)
	{
		if($section!=$values["sec_name"][$k]){
			$i=$i+1;
			$row_count = $row_count+1;
			if($row_count >$per_page_id)
			{
			$page=ceil($row_count/$per_page_id);
			}
			else
			{
			$page=1;
			}	
			echo "<tr bgcolor='#CCCCCC'>";
			echo "<td colspan='12' style='font-size:14px'>Section :&nbsp".$values["sec_name"][$k]."</td>";
			echo "</tr>";

			}
			echo "<tr>";
			
			echo "<td style='text-align:center; width:70px;'>";
			echo $s = $k+1;
			echo "</td>";

			echo "<td style='text-align:center; width:70px;'>";
			echo $values["emp_id"][$k];
			echo "</td>";
			
			echo "<td   style='text-align:left;' >";
			echo $values["emp_name"][$k];
			echo "</td>";
			
			echo "<td style='text-align:left;'>";
			echo $values["dept_name"][$k];
			echo "</td>";
					
			echo "<td  style='text-align:left;'>";
			echo $values["line_name"][$k];
			echo "</td>";
			
			echo "<td  style='text-align:left;'>";
			echo $values["desig_name"][$k];
			echo "</td>";
					
			echo "<td  width='40'  style='text-align:right;' >";
			echo $values["gross_sal"][$k];
			echo "</td>";
			
			echo "<td  style='text-align:right;' >";
			echo $values["ot_rate"][$k];
			echo "</td>";
			
			echo "<td width='80'  style='text-align:center;' >";
			$hour = trim(substr($values["in_time"][$k],0,2));
			$minute = trim(substr($values["in_time"][$k],3,2));
			$sec = trim(substr($values["in_time"][$k],6,2));
			$time_format = date("h:i:s A", mktime($hour, $minute, $sec, 0, 0, 0));
			echo $time_format;
			echo "</td>";
			
			echo "<td width='80' style='text-align:center;' >";
			$hour = trim(substr($values["out_time"][$k],0,2));
			$minute = trim(substr($values["out_time"][$k],3,2));
			$sec = trim(substr($values["out_time"][$k],6,2));
			$time_format = date("h:i:s A", mktime($hour, $minute, $sec, 0, 0, 0));
			echo $time_format;
			echo "</td>";
			
			$otEot_hour = $values["ot_hour"][$k]+$values["extra_ot_hour"][$k];	
			$sec_otEot_hour = $sec_otEot_hour + $otEot_hour;
			$total_otEot_hour = $total_otEot_hour + $otEot_hour;
			echo "<td  style='text-align:center;' >";
			echo $otEot_hour;
			echo "</td>";
			
			$otEot_amount = $values["ot_amount"][$k]+$values["eot_amount"][$k];	
			$sec_otEot_amount = $sec_otEot_amount + $otEot_amount;
			$total_otEot_amount = $total_otEot_amount + $otEot_amount;
			echo "<td  style='text-align:right;' >";
			echo $otEot_amount;
			echo "</td></tr>";

			$section=$values["sec_name"][$k];
			$k++;
			if($max==$k){
				break;
			}
		}

		echo "<tr><th colspan='10'> Per Page Total </th><th style='text-align:right; width:70px; font-weight:bold;'>";
		echo $sec_otEot_hour;
		echo "</th><th style='text-align:right; width:70px; font-weight:bold;'>";
		echo $sec_otEot_amount;
		echo "</th></tr>";
		/*echo "<tr><th colspan='10'> Sub Total </th><th style='text-align:right; width:70px; font-weight:bold;'>";
		echo $sec_otEot_hour;
		echo "</th><th style='text-align:right; width:70px; font-weight:bold;'>";
		echo $sec_otEot_amount;
		echo "</th></tr>";*/
	  if($counter == $page){
	  	 echo "<tr><th colspan='10'> Grand Total </th><th style='text-align:right; width:70px; font-weight:bold;'>";
		echo $total_otEot_hour;
		echo "</th><th style='text-align:right; width:70px; font-weight:bold;'>";
		echo $total_otEot_amount;
		echo "</th></tr>";
	  } ?>

  		<table width="750" height="65px" border="0" align="center" style="margin-bottom:120px; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:bold;">
		<tr height="40%" >
			<td colspan="29"></td>
		</tr>
		<tr height="15%">
		<td  align="left" style="width:16%;"><dt class="bottom_txt_design" >মানবসম্পদ বিভাগ</dt></td>
        <td align="left"  style="width:16%" ><dt class="bottom_txt_design" >হিসাব বিভাগ</dt></td>
        <!-- <td  align="center" style="width:15%" ><dt class="bottom_txt_design" >পরিচালক</dt></td> -->
        <td  align="left" style="width:16%" ><dt class="bottom_txt_design" >ব্যবস্থাপনা পরিচালক</dt></td>
		</tr>
	
		</table>
</table>
  <?php 
  	if($max==$k){
		break;
	}
   } 
  ?>
</div>
</div>
</body>
</html>
