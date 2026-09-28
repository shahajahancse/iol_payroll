<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Earn Leave Summery Sheet of <?php echo $year;?></title>
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
td { padding:10px;}
</style>

<body>
<div style=" margin:0 auto;  width:800px;">

<?php 
$this->load->view("head_english"); 
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
Earn Leave Summery Sheet of <?php echo $year;?></span>
<br />
<br />


<table class="bordered" border="1"  style="font-size:12px; width:700px; text-align:center;">
<th>SL</th>
<th>Line</th>
<th>Man Power</th>
<th>Gross Salary</th>
<th>Basic Salary</th>
<th>Earn Leave Days</th>
<th>Payable Amount</th>
<th>Remarks</th>
<?php
$total_manpower 	=0;
$total_gross    	=0;
$total_basic    	=0;
$total_el_days  	=0;
$total_payable_days	=0;

$count = count($values["line_name"]);
for($i=0; $i<$count; $i++ )
{
	echo "<tr>";
	
	echo "<td>";
	echo $k = $i+1;
	echo "</td>";

	echo "<td style='text-align:left;'>";
	echo $values["line_name"][$i];
	echo "</td>";
	
	echo "<td style='text-align:center;'>";
	echo $values["total_emp"][$i];
	echo "</td>";
	$total_manpower = $total_manpower + $values["total_emp"][$i];

	echo "<td style='text-align:right;'>";
	echo number_format($values["gross_sal"][$i]);
	echo "</td>";
	$total_gross = $total_gross + $values["gross_sal"][$i];
	
	echo "<td style='text-align:right;'>";
	echo number_format($values["basic_sal"][$i]);
	echo "</td>";
	$total_basic = $total_basic + $values["basic_sal"][$i];

	echo "<td style='text-align:center;'>";
	echo $values["earn_leave"][$i];
	echo "</td>";
	$total_el_days = $total_el_days + $values["earn_leave"][$i];

	echo "<td style='text-align:right;'>";
	echo number_format($values["net_pay"][$i]);
	echo "</td>";
	$total_payable_days = $total_payable_days + $values["net_pay"][$i];

	echo "<td >";
	echo "";
	echo "</td>";
	
	echo "</tr>";
}
		echo "<tr style='font-weight:bold; background-color:#CCC;'>";

		echo "<td colspan='2' align='center'>";
		echo "Grand Total";
		echo "</td>";
		
		echo "<td align='center'>";
		echo $total_manpower;
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_gross);
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_basic);
		echo "</td>";
		
		echo "<td align='center' style='padding-right:5px;'>";
		echo $total_el_days;
		echo "</td>";
		
		echo "<td align='right' style='padding-right:5px;'>";
		echo number_format($total_payable_days);
		echo "</td>";
		
		echo "<td >";
		echo "";
		echo "</td>";		
		
		echo "</tr>";

?>

</table>
</div>
</div>
</body>
</html>
