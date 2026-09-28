<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Promotion Report</title>
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
  // print_r($values["new_emp_id"]);exit;
	$per_page_id = 20;
	$row_count = count($values["new_emp_id"]);
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

	$grand_total_prev_salary = 0;
	$grand_total_inc_amount = 0;
	$grand_total_new_salary = 0;

for($counter = 1; $counter <= $page; $counter ++)
{
	$sub_total_prev_salary = 0;
	$sub_total_inc_amount = 0;
	$sub_total_new_salary = 0;

 ?>
 <table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:150px;">
		<?php $this->load->view("head_english");?><span style="font-size:13px; font-weight:bold; text-align: center;">
			Promotion Report from 
			<?php 
				$year= trim(substr($start_date,0,4));
				$month = trim(substr($start_date,5,2));
				$tarik = trim(substr($start_date,8,2));
				$date_format = date("d-M-Y", mktime(0, 0, 0, $month, $tarik, $year));
				echo $date_format;
				
				echo " - TO - ";
				
				$year= trim(substr($end_date,0,4));
				$month = trim(substr($end_date,5,2));
				$tarik = trim(substr($end_date,8,2));
				$date_format = date("d-M-Y", mktime(0, 0, 0, $month, $tarik, $year));
				echo $date_format;
				  
			?>
			</span>
		</td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ;font-size:15px;">'."পাতা নং # $counter <br>".'</span>';?>
		</td>
	</tr>
</table>

<table class="main_table" align="center" style="font-size:12px;width: 750px;">
	<th>SL</th>
    <th style="background:#DDDDDD;">Prev. Emp ID</th>
    <th>Name</th>
    <th>DOJ</th>
    <th>Prev. Line</th>
    <th>Prev. Desig.</th>
    <th>Prev. Salary</th> 
    
    <th style="background:#DDDDDD;">New Emp ID</th>
    <th>New Line</th>
    <th>New Desig.</th>
    <th>New Salary</th> 
    
    
    <th>Total Increment</th>
    <th>Effective Date</th>

<?php
	$section=array();

	for($i=0; $i<=$per_page_id; $i++)
	{
	
	if($section!=$values["new_section"][$k]){

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
		echo "<td colspan='13' style='font-size:16px'>Section :&nbsp".$values["new_section"][$k]."</td>";
		echo "</tr>";
	}

	echo "<tr>";
	
	echo "<td style='padding:2px;'>";
	echo $s = $k+1;
	echo "</td>";
	
	echo "<td style='background:#DDDDDD; padding:2px;font-weight:bold;'> ";
	echo $emp_id = $values["prev_emp_id"][$k];
	echo "</td>";
	
	$emp_name = $this->db->where('emp_id', $emp_id)->get('pr_emp_per_info')->row()->name_en;
	echo "<td style='padding:2px; width:150px;'> ";
	echo $emp_name;
	echo "</td>";
	
	$doj = $this->db->where('emp_id', $emp_id)->get('pr_emp_com_info')->row()->emp_join_date;
	$doj = date("Y-M-d", strtotime($doj));
	echo "<td style='padding:2px;'> ";
	echo $doj;
	echo "</td>";
	
	echo "<td style='text-align:left; padding:2px;'>";
	echo $values["prev_line"][$k];
	echo "</td>";
	
	echo "<td style='text-align:left; padding:2px; width:150px;'>";
	echo $values["prev_desig"][$k];
	echo "</td>";
	
	echo "<td style='text-align:left; padding:2px;'>";
	echo $values["prev_salary"][$k];
	echo "</td>";
	
	
	
	echo "<td style='background:#DDDDDD; padding:2px;font-weight:bold;'> ";
	echo $values["new_emp_id"][$k];
	echo "</td>";

	
	echo "<td style='text-align:left; padding:2px;'>";
	echo $values["new_line"][$k];
	echo "</td>";
	
	echo "<td style='text-align:left; padding:2px; width:150px;'>";
	echo $values["new_desig"][$k];
	echo "</td>";
	
	echo "<td style='text-align:left; padding:2px;'>";
	echo $values["new_salary"][$k];
	echo "</td>";
	
	
	
	$inc_amount = $values["new_salary"][$k] - $values["prev_salary"][$k];
	echo "<td style='text-align:right; padding:2px;' >";
	echo $inc_amount;
	echo "</td>";

	
	$sub_total_prev_salary = $sub_total_prev_salary + $values["prev_salary"][$k];
	$sub_total_inc_amount = $sub_total_inc_amount + $inc_amount;
	$sub_total_new_salary = $sub_total_new_salary + $values["new_salary"][$k];
	
	$grand_total_prev_salary = $grand_total_prev_salary + $values["prev_salary"][$k];
	$grand_total_inc_amount = $grand_total_inc_amount + $inc_amount;
	$grand_total_new_salary = $grand_total_new_salary + $values["new_salary"][$k];
	
	
	$sStartDate = date("d-M-Y", strtotime($values["effective_month"][$k])); 
	
	echo "<td  style='text-align:center;' >";
	echo $sStartDate;
	echo "</td>";
	echo "</tr>";
	
	$section = $values["new_section"][$k];

	$line = $values["new_line"][$k];
	
	$k++;
	if($max==$k){
		break;
	}
	
 }

 echo "<tr bgcolor='#CCCCCC' style='font-weight:bold;text-align:center; padding:2px;' >";
	echo "<td colspan='6' >";
	echo "Subtotal";
	echo "</td>";
	
	echo "<td>";
	echo $sub_total_prev_salary;
	echo "</td>";
	
	echo "<td colspan='3' >";
	echo "";
	echo "</td>";
	
	echo "<td>";
	echo $sub_total_new_salary;
	echo "</td>";
	
	echo "<td>";
	echo $sub_total_inc_amount;
	echo "</td>";
	
	echo "<td>";
	echo "";
	echo "</td></tr>";

 if($counter==$page){
		echo "<tr bgcolor='#CCCCCC' style='font-weight:bold;text-align:center; padding:2px;' >";
		echo "<td colspan='6' >";
		echo "Grand Total";
		echo "</td>";
		
		echo "<td>";
		echo $grand_total_prev_salary;
		echo "</td>";
		
		echo "<td colspan='3' >";
		echo "";
		echo "</td>";
		
		echo "<td>";
		echo $grand_total_new_salary;
		echo "</td>";
		
		echo "<td>";
		echo $grand_total_inc_amount;
		echo "</td>";
		
		echo "<td>";
		echo "";
		echo "</td>";
	} ?>

	<table width="750" height="65px" border="0" align="center" style="margin-bottom:70px; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
		<tr height="20%" >
			<td colspan="29"></td>
		</tr>
		<tr height="15%">
			<td  align="center" style="width:12%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
	        <td align="center"  style="width:12%" ><dt class="bottom_txt_design" >Manager(HR)</dt></td>
			<td  align="center" style="width:12%" ><dt class="bottom_txt_design" >Manager(Admin)</dt></td>
	        <td  align="left" style="width:20%;"><dt class="bottom_txt_design" >GM(Admin, HRD & Compliance)</dt></td>
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
<br><br><br>
<?php exit(); ?>

