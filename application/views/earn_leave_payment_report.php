<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Earn Leave Payment Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/table.css" />
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.js"></script>
<script>
/*$(document).ready(function(){
	i_count	= $("#i_count").val();
	alert(i_count);
	earn_pay = "#earn_pay"+i_count,
  $(earn_pay).keypress(function(){
	 alert(earn_pay);
  });
});*/
function get_earn_amount(i)
{
	
	earn_pay 			= "#earn_pay"+i;
	earn_pay_text 			= "earn_pay"+i;
	earn_leave_salary 	= "#earn_leave_salary"+i;
	earn_balance 		= "#earn_balance"+i;
	paid_amount_text 	= "paid_amount_text"+i;
	paid_amount_id 		= "paid_amount"+i;
	
	earn_pay_value			= $(earn_pay).val();
	earn_leave_salary_value	= $(earn_leave_salary).val();
	earn_balance_value		= $(earn_balance).val();
	
	earn_pay_valueforif 	= parseInt(earn_pay_value);
	earn_balance_valueforif = parseInt(earn_balance_value);
	//alert(earn_pay_valueforif);
	//alert(earn_balance_valueforif);
	if(earn_pay_valueforif > earn_balance_valueforif)
	{	
		document.getElementById(earn_pay_text).value	 	= "";
		document.getElementById(paid_amount_id).value	 	= "";
		document.getElementById(paid_amount_text).innerHTML = "";
		alert("Earn Pay Must Be Less Then Earn Balance");
		return false;
	}
	
	
	paid_amount = Math.round((earn_leave_salary_value/30)* earn_pay_value);
	document.getElementById(paid_amount_id).value 			= paid_amount;
	document.getElementById(paid_amount_text).innerHTML 	= paid_amount;
	//alert(paid_amount_id);
	
}
</script>
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
<div style=" margin:0 auto;  width:800px;">

<?php 
$this->load->view("head_english"); 
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
Earn Leave Payment Report of <?php echo $year	= date("Y",strtotime($year_month));?></span>
<br />
<br />


<table class="bordered" border="1"  style="font-size:12px; width:700px; text-align:center;">
<th>SL</th><th>Emp ID</th><th>Name</th><th>Desig.</th><th>DOJ</th><th>Salary</th><th>Totat Earn</th> <th>Entitle</th> <th>Paid</th> <th>Balance</th><th>Leave Pay</th><th>Paid Amount</th>
<form action="<?php echo base_url();?>earn_leave_con/earn_leave_payment" method="post" >
<?php
$count = count($values["emp_id"]);
?>
	<input type="hidden" name="count" id="count"  value="<?php 	echo $count; ?>"/>
    <input type="hidden" name="year" id="year"  value="<?php 	echo $year; ?>"/>
    <input type="hidden" name="unit_id" id="unit_id"  value="<?php echo $unit_id; ?>"/>

<?php
for($i=0; $i<$count; $i++ )
{
?>

<tr>
	<input type="hidden" name="i_count" id="i_count"  value="<?php echo $i; ?>"/>
    <td><?php 	echo $k = $i+1; ?> </td>
    <td><?php 	echo $values["emp_id"][$i]; ?> </td>
    <input type="hidden" name="emp_id<?php echo $i;?>" id="emp_id"  value="<?php 	echo $values["emp_id"][$i]; ?>"/>
    
    <td><?php 	echo $values["emp_name"][$i]; ?> </td>
    <td><?php 	echo $values["desig_name"][$i]; ?> </td>
    <?php $doj	= date("d-M-Y",strtotime($values["emp_join_date"][$i])); ?>
    <td><?php 	echo $doj; ?> </td>
    
    <td><?php 	echo $values["earn_leave_salary"][$i]; ?> </td>
    <input type="hidden" name="earn_leave_salary<?php echo $i;?>" id="earn_leave_salary<?php echo $i;?>"  value="<?php 	echo $values["earn_leave_salary"][$i]; ?>"/>
    
    <td><?php 	echo $values["yearly_earn"][$i]; ?> </td>
    <input type="hidden" name="yearly_earn<?php echo $i;?>" id="yearly_earn"  value="<?php 	echo $values["yearly_earn"][$i]; ?>"/>
    
    <td><?php 	echo $values["earn_entitle"][$i]; ?> </td>
    <input type="hidden" name="earn_entitle<?php echo $i;?>" id="earn_entitle"  value="<?php 	echo $values["earn_entitle"][$i]; ?>"/>
    
    <td><?php 	echo $values["earn_paid"][$i]; ?> </td>
    <input type="hidden" name="earn_paid<?php echo $i;?>" id="earn_paid"  value="<?php 	echo $values["earn_paid"][$i]; ?>"/>

    <td><?php 	echo $values["earn_balance"][$i]; ?> </td>
     <input type="hidden" name="earn_balance<?php echo $i;?>" id="earn_balance<?php echo $i;?>"  value="<?php 	echo $values["earn_balance"][$i]; ?>"/>
    
    <td><input type="text" style="border:1px solid #000; font-weight:bold; " name="earn_pay<?php echo $i;?>" id="earn_pay<?php echo $i;?>" onkeyup="get_earn_amount(<?php echo $i; ?>)"/></td>
    
    <td><span  style="font-weight:bold; color:#063" name="paid_amount_text<?php echo $i;?>" id="paid_amount_text<?php echo $i;?>" /> </span></td>
    <input type="hidden" style="font-weight:bold; color:#063" name="paid_amount<?php echo $i;?>" id="paid_amount<?php echo $i;?>" />
  </tr>
<?php	
	
}

?>
<tr><td colspan="12"><input type="submit" value="Submit"  /></td></tr>
</form>
</table>
</div>
</div>
</body>
</html>
