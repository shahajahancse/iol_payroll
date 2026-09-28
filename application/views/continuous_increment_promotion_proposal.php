<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
 
Increment Promotion Proposal

</title>

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
	.emp_info{
		background:#DFDFFF;
	}
	


.bottom_txt_design
{
	 border-top:1px solid;
	 width:160px;
	 font-weight:bold;
}
.bottom_txt_manager_design
{
	border-top:1px solid;
	width:170px;
}
</style>

</head>

<body style="width:1100px;">

<?php 
$row_count=count($values["emp_name"]);
if($row_count > 11)
{
$page = ceil($row_count/11);
}
else
{
$page=1;
}

$k = 0;
 	 $gt_increment_amount 	= 0;
	 $gt_gross_sal 				= 0;
	 //$increment_amount 			= 0;
	 $gt_five_percent				= 0;
	 $gt_new_basic					= 0;
	 $gt_new_gross					= 0;
	 $gt_increment					= 0;
	 ?>
     <?php 
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table class="bordered" align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="7" style="font-size:12px; width:auto; border-collapse: collapse;">

<tr height="70px">

<td colspan="17" align="center">
<div style="text-align:left; position:relative; top:20px; padding-left:10px;">
<?php 
$date = date('d-m-Y');
//echo "Payment Date : $date"; ?>
</div>
 
<?php
$this->load->view("head_english");?>

<span style="font-size:13px; font-weight:bold; text-align: center;">
Increment/Promotion Proposal Report upto 
<?php echo $first_date = date("d-M-Y",strtotime($start_date));?>
</span>

</td>
</tr>


<th rowspan="2" width="15" height="20px"><div align="center"><strong>SI. No</strong></div></th>
<th rowspan="2" width="14" ><div align="center"><strong>Emp ID</strong></div></th>
<th rowspan="2" width="180" ><div align="center"><strong>Name & Designation</strong></div></th>
<th rowspan="2" width="100" ><div align="center"><strong>Section & Line</strong></div></th>
<th rowspan="2" width="25" ><div align="center"><strong>Joining</strong></div></th>
<th rowspan="2" width="15" ><div align="center"><strong>Dur. Mon.</strong></div></th>
<th colspan="2"  width="20" ><div align="center"><strong>Last Incr.</strong></div></th>
<th rowspan="2" width="35" ><div align="center"><strong>Present Salary</strong></div></th>
<th rowspan="2" width="25" ><div align="center"><strong>Incr. 5%</strong></div></th>
<th rowspan="2" width="30" ><div align="center"><strong>B. Sal.  After  5% Incr. </strong></div></th>
<th rowspan="2" width="30" ><div align="center"><strong>Total Sal. (After Incr.)</strong></div></th>
<th rowspan="2" width="30" ><div align="center"><strong>Total Incr. Amount</strong></div></th>
<th colspan="2" width="150" ><div align="center"><strong>Proposed By</strong></div></th>
<th rowspan="2" width="80" ><div align="center"><strong>Approved (M.D Sir)</strong></div></th>
<!--<th rowspan="2" width="100" ><div align="center"><strong>Total Salary <span style="font-size: 10px;">(After Increment)</span>	</strong></div></th>-->
<th rowspan="2" width="100" ><div align="center"><strong>Remarks</strong></div></th>
<tr>
	
	<td><strong>Month</strong></td>
	<td><strong>Amount</strong></td>
	
	<td width="50" ><strong>Manager</strong></td>
	<td width="70" ><strong>GM</strong></td>
	
</tr>

<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 11;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=10;
   	}
  	
   	 $total_increment_amount   			= 0;
	 $total_gross_sal 					= 0;
	 //$total_increment_amount 			= 0;
	 $total_five_percent				= 0;
	 $total_new_basic					= 0;
	 $total_new_gross					= 0;
	 $total_increment					= 0;
	 $total_increment_amount_per_page	= 0;
	 $total_gross_sal_per_page			= 0;
	 //$total_increment_amount_per_page 	= 0;
	 $total_five_percent_per_page		= 0;
	 $total_new_basic_per_page			= 0;
	 $total_new_gross_per_page			= 0;
	 $total_increment_per_page			= 0;
	 
	 
	 	for($p=0; $p<=$per_page_row;$p++)
	{
		echo "<tr style='text-align: center;'>";
	
	echo "<td >";
	echo $k+1;
	echo "</td>";
	
	
	echo "<td  style='text-align:center; width:70px;'>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	
	echo "<td style='text-align:left;'>";
	echo "<span style='font-weight:bold'>".$values["emp_name"][$k]."</span>";
	
	echo "<br>".$values["desig_name"][$k];
	echo "</td>";
	
	
	echo "<td style='text-align:left;'>";
	echo $values["sec_name"][$k];
	
	echo "<br>".$values["line_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["join_date"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["service_month"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["last_increment_date"][$k];
	echo "</td>";

	echo "<td >";
	echo $values["increment_amount"][$k];
	$total_increment_amount_per_page = $total_increment_amount_per_page + $values["increment_amount"][$k];
	$gt_increment_amount = $gt_increment_amount + $values["increment_amount"][$k];
	
	echo "</td>";
	
	echo "<td >";
	echo $values["gross_sal"][$k];
	$total_gross_sal_per_page = $total_gross_sal_per_page + $values["gross_sal"][$k];
	$gt_gross_sal =$gt_gross_sal + $values["gross_sal"][$k];
	echo "</td>";


	echo "<td >";
	$salary_structure = $this->common_model->salary_structure($values["gross_sal"][$k]);
	echo $five_percent = round(($salary_structure['basic_sal']*5)/100,0);
	$total_five_percent_per_page = $total_five_percent_per_page + round(($salary_structure['basic_sal']*5)/100,0);
	$gt_five_percent = $gt_five_percent + round(($salary_structure['basic_sal']*5)/100,0);
	echo "</td>";
	
	echo "<td >";
	echo $new_basic = $salary_structure['basic_sal'] + $five_percent;
	$total_new_basic_per_page = $total_new_basic_per_page + $salary_structure['basic_sal'] + $five_percent;
	$gt_new_basic = $gt_new_basic + $salary_structure['basic_sal'] + $five_percent;
	echo "</td>";
	
	
	echo "<td >";
	echo $new_gross = round(((($new_basic*40)/100) + $new_basic + 1100),0);
	$total_new_gross_per_page = $total_new_gross_per_page + round(((($new_basic*40)/100) + $new_basic + 1100),0);
	$gt_new_gross = $gt_new_gross +	round(((($new_basic*40)/100) + $new_basic + 1100),0);
	echo "</td>";
	
	echo "<td >";
	echo $increment = $new_gross - $values["gross_sal"][$k];
	$total_increment_per_page = $total_increment_per_page + $new_gross - $values["gross_sal"][$k];
	$gt_increment = $gt_increment + $new_gross - $values["gross_sal"][$k];
	echo "</td>";
	
	echo "<td >";
	echo "";
	echo "</td>";
	
	echo "<td >";
	echo "";
	echo "</td>";
	
	echo "<td >";
	echo "";
	echo "</td>";
	
	echo "<td >";
	echo "";
	echo "</td>";
	
	
		$k++;
	}
	?>
		<tr>
		<td align="center" colspan="7"><strong>Per Page Total</strong></td>
		<!--<?php if($deduct_status == "Yes"){?>
		<td colspan="4"></td>
		 <?php }else{ ?>
		 <td colspan="3"></td>
		 <?php } ?>-->
         <td align="right"><strong><?php echo $english_format_number = number_format($total_increment_amount_per_page);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_gross_sal_per_page);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_five_percent_per_page);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_new_basic_per_page);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_new_gross_per_page);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($total_increment_per_page);?></strong></td>
    </tr>
	<?php
	if($counter == $page)
   		{?>
			<tr height="10">
            <?php //echo $deduct_status;?>
			<?php //if($deduct_status == "Yes")
			{ ?>
			 <td colspan="7" align="center">
			 <?php } ?>
			<strong>Grand Total</strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($gt_increment_amount);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($gt_gross_sal);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($gt_five_percent);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($gt_new_basic);?></strong></td>
         <td align="right"><strong><?php echo $english_format_number = number_format($gt_new_gross);?></strong></td>
          <td align="right"><strong><?php echo $english_format_number = number_format($gt_increment);?></strong></td>
            
            </tr>

	<?php } ?>
			
			<table width="100%" height="40px" border="0" align="center" style="margin-bottom:80px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="40" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Prepared By</dt></td>
            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >HR Manager</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Sr.Manager (Admin & Fin.)</td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >G.M</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Group (GM)</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
			</tr>
			
			</table>
			</table>
			  
			<?php

		}

?>

</body>
</html>