<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily OT Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
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
$per_page_id = 20;
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

$total_tiffin_allo_amount = 0;
$total_holiday_allo_amount = 0;
$all_total = 0;

$k = 0;

for($counter = 1; $counter <= $page; $counter ++)
{

 ?>
<table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:150px;">
		<?php $this->load->view("head_english");?><span style="font-size:13px; font-weight:bold; text-align: center;">
			Daily Allowance Report of <?php echo "$start_date"; ?>
			</span>
		</td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ;font-size:15px;">'."পাতা নং # $counter <br>".'</span>';?>
		</td>
	</tr>
</table>
<table class="main_table" align="center" style="font-size:12px;width: 750px;">
<th>SL</th>
<th>Emp ID</th>
<th>Punch Card No.</th>
<th>Employee Name</th>
<th>Department</th> 
<th>Section</th> 
<th>Line No. </th> 
<th>Designation</th> 
<th>Shift</th> 

<th>Out Time</th> 
<th>Holiday Bill</th> 
 

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
		echo "<td colspan='16' style='font-size:14px'>Section :&nbsp".$values["sec_name"][$k]."</td>";
		echo "</tr>";
	}
	echo "<tr>";
	
	echo "<td>";
	echo $ks = $k+1;
	echo "</td>";
	
	echo "<td>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	echo "<td>";
	echo "&nbsp;";
	echo $values["proxi_id"][$k];
	echo "</td>";
	
	echo "<td  style='text-align:left;' >";
	echo $values["emp_name"][$k];
	echo "</td>";
	
	
	echo "<td    style='text-align:left;'>";
	echo $values["dept_name"][$k];
	echo "</td>";
	
	echo "<td   style='text-align:left;'>";
	echo $values["sec_name"][$k];
	echo "</td>";
	
	echo "<td   style='text-align:left;'>";
	echo $values["line_name"][$k];
	echo "</td>";
	
	echo "<td  style='text-align:left;'>";
	echo $values["desig_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_shift"][$k];
	echo "</td>";

	echo "<td width='80' style='text-align:center;' >";
	echo $values["out_time"][$k];
	echo "</td>";

	echo "<td  style='text-align:center;' >";
	echo $values["holiday_allowance_amount"][$k];
	echo "</td>";
	$total_holiday_allo_amount = $total_holiday_allo_amount + $values["holiday_allowance_amount"][$k];
	echo "</tr>";
	$section=$values["sec_name"][$k];

	$k++;
	if($max==$k){
		break;
	}
}

?>
<?php if($counter == $page){ ?>
	<tr>
		<td  colspan="10" style="text-align:center; font-weight:bold;" >Grand Total</td>
		<td style="text-align:right; font-weight:bold;" ><?php echo number_format($total_holiday_allo_amount); ?>/=</td>
	</tr>
<?php } ?>

	<table width="750" height="65px" border="0" align="center" style="margin-bottom:70px; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
		<tr height="20%" >
			<td colspan="29"></td>
		</tr>
		<tr height="15%">
		<td  align="left" style="width:12%;"><dt class="bottom_txt_design" >মানবসম্পদ বিভাগ</dt></td>
        <td align="left"  style="width:12%" ><dt class="bottom_txt_design" >হিসাব বিভাগ</dt></td>
        <!-- <td  align="center" style="width:15%" ><dt class="bottom_txt_design" >পরিচালক</dt></td> -->
        <td  align="left" style="width:12%" ><dt class="bottom_txt_design" >ব্যবস্থাপনা পরিচালক</dt></td>
		</tr>
	</table>
</table>
<div style="page-break-after: always;"></div>
<?php 
	if($max==$k){
		break;
	}
} ?>
</body>
</html>
