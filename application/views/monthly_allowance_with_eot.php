<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Monthly Allowance Report With EOT</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
.bottom_txt_design
{
	 border-top:1px solid;
	 width:120px;
}
.bottom_txt_manager_design
{
	border-top:1px solid;
	 width:150px;
}
</style>

</head>

<body>

<?php 
$row_count=count($value);
if($row_count >7)
{
$page=ceil($row_count/7);
}
else
{
$page=1;
}

$k = 0;

			
			$gross_sal = 0;
			$grand_total_net_pay_amount = 0;
		
			?>
			<table >
			
			<?php
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table height="auto"  class="sal" border="1" cellspacing="0" cellpadding="0" style="font-size:13px; width:auto;">

<tr height="85px">

<td colspan="26" align="center">

<div style="text-align:left; position:relative; top:20px; padding-left:10px;">
<?php 
$date = date('d-m-Y');
//echo "Payment Date : $date"; 
echo "Page No # $counter of $page";
?>
</div>
 
<?php $emp_id = $value[0]->emp_id;
$data['unit_id'] = $this->db->where("emp_id",$emp_id)->get('pr_emp_com_info')->row()->unit_id;
$this->load->view("head_english",$data);?>
<?php if($grid_status == 4){ echo 'Resign '; }?>Monthly Allowance Report With EOT
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;

?>

</td>
</tr>


  <tr height="20px">
    <td rowspan="2"  width="15" height="20px"><div align="center"><strong>SI. No</strong></div></td>
    <td rowspan="2" width="30" height="20px"><div align="center"><strong>Name of Employee</strong></div></td>
	<td rowspan="2" width="14" height="20px"><div align="center"><strong>Card No</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Designation</strong></div></td>
	 <td rowspan="2" width="25" height="20px"><div align="center"><strong>Section</strong></div></td>
    <td rowspan="2" width="25" height="20px"><div align="center"><strong>Joining Date</strong></div></td>
	<td rowspan="2" width="25" height="20px"><div align="center"><strong>Grade</strong></div></td>
    <td rowspan="2" width="20" height="20px"> <div align="center"><strong>Basic</strong></div></td>
    <td rowspan="2" width="17" height="20px"><div align="center"><strong>H/Rent</strong></div></td>
    <td rowspan="2" width="15" height="20px"><div align="center"><strong>Medical</strong></div></td>
    <td rowspan="2" width="35" height="20px"><div align="center"><strong>Gross Salary</strong></div></td>
    
	<td colspan="9" height="20px"><div align="center"><strong>Allowance</strong></div></td>
    
    <td colspan="3" height="20px"><div align="center"><strong>EOT</strong></div></td>
    <td rowspan="2" width="22" height="20px"><div align="center"><strong>Net Pay Amount</strong></div></td>
	<td rowspan="2"  width="180"><div align="center"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></div></td>
  </tr>
  <tr height="10px">
  	
  	<td width="38"><div align="center"><strong>Total Tifin</strong></div></td>
	<td width="38"><div align="center"><strong>Tifin Rate</strong></div></td>
    <td width="38"><div align="center"><strong>Tifin Amount</strong></div></td>
	<td width="38"><div align="center"><strong>Total Night</strong></div></td>
	<td width="38"><div align="center"><strong>Night Rate</strong></div></td>
    <td width="38"><div align="center"><strong>Night Amount</strong></div></td>
    <td width="38"><div align="center"><strong>Total Holiday</strong></div></td>
	<td width="38"><div align="center"><strong>Holiday Rate</strong></div></td>
    <td width="38"><div align="center"><strong>Holiday Amount</strong></div></td>
    
    
    <td width="45"><div align="center"><strong>Hour</strong></div></td>
	<td width="45"><div align="center"><strong>Rate</strong></div></td>
    <td width="45"><div align="center"><strong>Amount</strong></div></td>

    
   </tr>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 7;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=6;
   	}

	$total_net_pay_amount = 0;

	
	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr height='77' style='text-align:center;' >";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		echo "<td>";
		print_r($value[$k]->emp_full_name);
		echo '<br>';
		if($grid_status == 4)
		{
			$resign_date = $this->Grid_model->get_resign_date_by_empid($value[$k]->emp_id);
			if($resign_date != false){
			echo $resign_date = date('d-M-y', strtotime($resign_date));}
		}
		echo "</td>"; 
				
		echo "<td>";
		print_r($value[$k]->emp_id);
		//echo $row->emp_id;
		echo "</td>";
				
		echo "<td>";
		print_r($value[$k]->desig_name);
		//echo $row->desig_name;
		echo "</td>";
		
		echo "<td>";
		print_r($value[$k]->sec_name);
		//echo $row->desig_name;
		echo "</td>";
				
				
		echo "<td>";
		$date = $value[$k]->emp_join_date;
		//print_r($value[$k]->emp_join_date);
		$year=trim(substr($date,0,4));
		$month=trim(substr($date,5,2));
		$day=trim(substr($date,8,2));
		$date_format = date("d-M-y", mktime(0, 0, 0, $month, $day, $year));
		echo $date_format;
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->gr_name);
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->basic_sal);
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->house_r);
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->medical_a);
		echo "</td>";
				 
		echo "<td style='font-weight:bold;'>";
		print_r ($value[$k]->gross_sal);
		$gross_sal = $gross_sal + $value[$k]->gross_sal;
		echo "</td>";
				
		
				
		echo "<td>";
		print_r ($value[$k]->tiffin_allowance_count);
		echo "</td>";
			
		echo "<td>";
		print_r ($value[$k]->tiffin_allowance_rate);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->tiffin_allow);
		echo "</td>"; 
				
		echo "<td>";
		print_r ($value[$k]->night_allowance_count);
		echo "</td>";
				
		echo "<td>";
		print_r ($value[$k]->night_allowance_rate);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->night_allow);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->working_weekend);
		echo "</td>";
		
		echo "<td>";
		print_r ($value[$k]->week_allowance_rate);
		echo "</td>";
		
		
		echo "<td>";
		print_r ($value[$k]->week_allow);
		echo "</td>";
		
		
		echo "<td>";
		print_r ($value[$k]->eot_hour);
		echo "</td>";
		
		
		echo "<td>";
		print_r ($value[$k]->ot_rate);
		echo "</td>";
		$eot_hour = $value[$k]->eot_hour;
		$eot_amount = round($eot_hour * $value[$k]->ot_rate);
		
		echo "<td>";
		echo $eot_amount;
		echo "</td>";
		
		$net_payable = $value[$k]->tiffin_allow + $value[$k]->night_allow + $value[$k]->week_allow + $eot_amount;
		$total_net_pay_amount = $total_net_pay_amount  + $net_payable;
		$grand_total_net_pay_amount = $grand_total_net_pay_amount  + $net_payable;
		echo "<td>";
		echo $net_payable;
		echo "</td>";
		
		echo "<td>";
		echo "&nbsp;";
		echo "</td>";
			
		echo "</tr>"; 
		$k++;
	}
	?>
	<tr>
		<td align="center" colspan="10"><strong>Total Per Page</strong></td>
		<td align="right"><strong><?php echo $english_format_number = number_format($gross_sal);?></strong></td>
        <td align="right" colspan="12"></td>
        <td align="right"><strong><?php echo $english_format_number = number_format($total_net_pay_amount);?></strong></td>
		
	</tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
			<td colspan="23" align="center">
			<strong>Grand Total Amount Tk</strong></td>
			<td align="right"><strong><?php echo $english_format_number = number_format($grand_total_net_pay_amount);?></strong></td>
			
			</tr>
			<?php } ?>
			
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:300px;"><dt class="bottom_txt_design" >Prepared By </dt></td>
            <td  align="center" style="width:150px"><dt class="bottom_txt_design" >IT </dt></td>
			<td align="center"style="width:300px" ><dt class="bottom_txt_design" >Checked BY </dt></td>
			<td  align="center" style="width:200px"><dt<dt class="bottom_txt_manager_design" >Manager(Admin & HRM)</dt></td>
			<td  align="center"><dt class="bottom_txt_design" >ED</dt></td>
			<td  align="center"><dt class="bottom_txt_design" >MD</dt></td>
			</tr>
			
			</table>
			</table>
			  
			<?php

		}

?>
</table>

</body>
</html>