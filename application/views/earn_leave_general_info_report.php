<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Earn Leave Payment Sheet of <?php echo $year;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/table.css" />

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
.bottom_txt_design
{
	 border-top:1px solid;
	 width:150px;
	 font-weight:bold;
	 font-size:12px;
}
.bottom_txt_manager_design
{
	 border-top:1px solid;
	 width:170px;
	 font-size:12px;
}
td { padding:3px; height:30px;}
</style>
<body>
<?php 
if(empty($values)){
	echo "No data found"; exit;
}
$row_count = count($values["emp_id"]);
//print_r($values);
if($row_count >6)
{
$page=ceil($row_count/6);
}
else
{
$page=1;
}

$k = 0;

	  $grand_total_gross    		=0;
	  $grand_total_basic    		=0;
	  $grand_total_working_day  	=0;
	  $grand_total_payable_day		=0;
	  $grand_total_el_days  		=0;
	  $grand_total_cl_days  		=0;
	  $grand_total_ml_days  		=0;
	  $grand_total_sl_days  		=0;
	  $grand_total_absent_day   	=0;
	  $grand_total_net_el  			=0;
	  $grand_total_net_amount  		=0;
	  $grand_total_stamp			=0;
	  $grand_total_net_amount_b_d	=0;
	 
for ( $counter = 1; $counter <= $page; $counter ++)
{
 ?>
<div style=" margin:0 auto;">
<?php 
$this->load->view("head_english"); 
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:1000px; margin-bottom:80px;"><span style="font-size:13px; font-weight:bold;">
Earn Leave Payment Sheet of <?php echo $year;?></span>
<br />
<div style="width:950px;">
<div style="text-align:right; right:120px; position:relative;">Disbursement Date:</div></div>

<table class="bordered" border="1"  style="font-size:12px; text-align:center;">
<?php

$total_gross    	=0;
$total_basic    	=0;
$total_working_day  =0;
$total_payable_day	=0;
$total_el_days  	=0;
$total_cl_days  	=0;
$total_ml_days  	=0;
$total_sl_days  	=0;
$total_absent_day   =0;
$total_net_el  		=0;
$total_net_amount  	=0;
$total_net_amount_b_d=0;
$stamp 				=0;
$total_stamp 		=0;


$section=array();
if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 6;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row = 5;
   	}

	for($i=0; $i<=$per_page_row; $i++)
	{
	
	if($section!=$values["sec_name"][$k]){
	echo "<tr bgcolor='#CCCCCC'>";
	echo "<td colspan='16' align='left' style='font-size:14px;height:10px'>Section :&nbsp".$values["sec_name"][$k]."</td>";
	echo "</tr>";
	
	 ?>
<tr style="height:30px;padding:3px;">
<th width="30">SL</th>
<th width="80">Emp ID</th>
<th width="150">Name and Designation</th>
<th width="150">Line</th>
<th width="80">DOJ</th>
<th width="50">Gross</th>
<th width="50">Basic</th>
<th width="70">Total Days</th>
<th width="90">Working Days</th>
<th width="30">EL</th>
<th width="30">CL</th>
<th width="30">ML</th>
<th width="30">SL</th>
<th width="30">Absent</th>
<th width="50">Net EL</th>
<th width="80">Net Amount</th>
<th width="50">Stamp</th>
<th width="80">Payable Amount</th>
<th width="120">Signature</th>
</tr>
<?php
	}
	echo "<tr>";
	
	echo "<td>";
	echo $s = $k+1;
	echo "</td>";
	
	echo "<td style='font-weight:bold;'>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	echo "<td align='left'>";
	echo "<span style='font-family:Arial, Helvetica, sans-serif;font-weight:bold;'>";
	print_r($values["emp_name"][$k]);
	echo "</span>";
	echo "<br>";
	echo "<span style='font-family:Arial, Helvetica, sans-serif;'>";
	print_r( $values["desig_name"][$k]);
	echo "</span>";
	echo "</td>";
	
	echo "<td style='font-weight:bold;'>";
	echo $values["line_name"][$k];
	echo "</td>";
	
	$doj = date("d-M-Y",strtotime($values["emp_join_date"][$k]));
	echo "<td >";
	echo $doj;
	echo "</td>";

	echo "<td >";
	echo $values["gross_sal"][$k];
	//echo $values["new_salary"][$k];
	echo "</td>";
	$total_gross = $total_gross + $values["gross_sal"][$k];
	//$total_gross = $total_gross + $values["new_salary"][$k];
	$grand_total_gross = $grand_total_gross + $values["gross_sal"][$k];

	//$basic_sal = (($values["new_salary"][$k])*68.154)/100;
	echo "<td >";
	echo $values["basic_sal"][$k];
	//echo $english_format_number = number_format($basic_sal);
	echo "</td>";
	$total_basic = $total_basic + $values["basic_sal"][$k];
	//$total_basic = $total_basic + $basic_sal;
	$grand_total_basic = $grand_total_basic + $values["basic_sal"][$k];
	//Tarek Code
	$tot_wor_day=$values["ttl_wk_days"][$k];
	$el=$values["el"][$k];
	$cl=$values["cl"][$k];
	$ml=$values["ml"][$k];
	$sl=$values["sl"][$k];
	$ads_day=$values["A"][$k];
	$h=$values["H"][$k];
	$w=$values["W"][$k];
	
	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["ttl_wk_days"][$k];
	echo "</td>";
	$total_working_day = $total_working_day + $values["ttl_wk_days"][$k];
	$grand_total_working_day = $grand_total_working_day + $values["ttl_wk_days"][$k];

	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["P"][$k];
	echo "</td>";
	$total_payable_day = $total_payable_day + $values["P"][$k];
	$grand_total_payable_day = $grand_total_payable_day + $values["P"][$k];

	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["el"][$k];
	echo "</td>";
	$total_el_days = $total_el_days + $values["el"][$k];
	$grand_total_el_days = $grand_total_el_days + $values["el"][$k];
	
	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["cl"][$k];
	echo "</td>";
	$total_cl_days = $total_cl_days + $values["cl"][$k];
	$grand_total_cl_days = $grand_total_cl_days + $values["cl"][$k];
	
	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["ml"][$k];
	echo "</td>";
	$total_ml_days = $total_ml_days + $values["ml"][$k];
	$grand_total_ml_days = $grand_total_ml_days + $values["ml"][$k];
	
	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["sl"][$k];
	echo "</td>";
	$total_sl_days = $total_sl_days + $values["sl"][$k];
	$grand_total_sl_days = $grand_total_sl_days + $values["sl"][$k];

	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["A"][$k];
	echo "</td>";
	$total_absent_day = $total_absent_day + $values["A"][$k];
	$grand_total_absent_day = $grand_total_absent_day + $values["A"][$k];

	$net_el = ($values["P"][$k]/18)-$el;
	
	echo "<td align='right' style='padding-right:5px;'>";
	echo number_format($net_el, 2);
	echo "</td>";
	$total_net_el = $total_net_el + number_format($net_el, 2);
	$grand_total_net_el = $grand_total_net_el + number_format($net_el, 2);

	$net_amount = ($values["gross_sal"][$k]/30)*number_format($net_el, 2);
	
	
	echo "<td align='right' style='padding-right:5px; font-weight:bold;'>";
	echo number_format($net_amount,0);
	echo "</td>";
	$total_net_amount_b_d = $total_net_amount_b_d + $net_amount;
	$grand_total_net_amount_b_d = $grand_total_net_amount_b_d + $net_amount;
	
	echo "<td align='right' style='padding-right:5px;'>";
	if($net_amount >= 510)
	{
		echo $stamp = 10;
	}
	else 
	{
		echo $stamp = 0;
	}
	echo "</td>";
	$total_stamp = $total_stamp + $stamp;
	$grand_total_stamp = $grand_total_stamp + $stamp;
	
	echo "<td align='right' style='padding-right:5px; font-weight:bold;'>";
	$net_amount = $net_amount - $stamp;
	echo number_format($net_amount,0);
	echo "</td>";
	
	$total_net_amount = $total_net_amount + $net_amount;
	$grand_total_net_amount = $grand_total_net_amount + $net_amount;
	
	
	echo "<td style='height:77px'>";
	echo "";
	echo "</td>";
	
	echo "</tr>";
	$section=$values["sec_name"][$k];
	$k++;
}
		echo "<tr style='font-weight:bold; background-color:#CCC;'>";

		echo "<td style='height:10px' colspan='5' align='center' >";
		echo "Page Total";
		echo "</td>";
		
		echo "<td align='center'>";
		echo number_format($total_gross);
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_basic);
		echo "</td>";
		
		echo "<td align='right'>";
		echo $total_working_day;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_payable_day;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_el_days;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_cl_days;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_ml_days;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_sl_days;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_absent_day;
		echo "</td>";
				
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_net_el;
		echo "</td>";		
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo round($total_net_amount_b_d);
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo $total_stamp;
		echo "</td>";	
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo round($total_net_amount) ;
		echo "</td>";		
	
		echo "</tr>";
		
		
?>
<?php
	if($counter == $page)
   		{?>
			<tr height="10">
			<td align="center" colspan="5"><strong style="font-size:13px;">Grand Total</strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_gross);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_basic);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_working_day);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_payable_day);?></strong></td>
              <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_el_days);?></strong></td>
              <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_cl_days);?></strong></td>
              <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_ml_days);?></strong></td>
              <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_sl_days);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_absent_day);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_el);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_amount_b_d);?></strong></td>
             <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_stamp);?></strong></td>
         	 <td align="right" style="font-size:14px;"><strong><?php echo $english_format_number = number_format($grand_total_net_amount);?></strong></td>
         </tr>
			<?php
			
			 } 
			 
			 ?>
            
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:85px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
				<tr height="80%" >
				<td colspan="29"></td>
				</tr>
				<tr height="20%">
				<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Prepared By</dt></td>
	            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Accounts Exe.</dt></td>
				<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR/Sr Manager</dt></td>
	            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM (HR,Admin&Compl.)</dt></td>
				<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM</dt></td>
	            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
				</tr>
			</table>
</table>
</div>
</div>
<?php } ?>
</body>
</html>