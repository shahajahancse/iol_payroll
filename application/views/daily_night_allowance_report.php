<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
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
	 width:170px;
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
$row_count = count($values["emp_id"]);
//print_r($values);
if($row_count >22)
{
$page=ceil($row_count/22);
}
else
{
$page=1;
}
$k = 0;
	
	$grand_total = 0;

for ( $counter = 1; $counter <= $page; $counter ++)
{
 ?>
<div style=" margin:0 auto;">
<?php 
$this->load->view("head_english"); 
?>
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:700px; margin-bottom:50px; min-height:900px; margin-top:0px;"><span style="font-size:12px; font-weight:bold;">
Daily Night Allowance Report of <?php echo "$start_date"; ?></span>
<br />
<div style="width:700px;">

<table class="bordered" border="1"  style="font-size:12px; text-align:center;">

<tr style="height:30px;padding:3px;">
<th>SL</th>
<th>Emp ID</th>
<th>Employee Name</th>
<th>Department</th> 
<th>Section</th> 
<th>Designation</th> 
<th>Line</th> 
<th>Out Time</th> 
<th>Night Bill</th> 
<th width="120">Signature</th> 
</tr>
<?php
$total_night_allo_amount = 0;
//$section=array();
if($counter == $page)
  	{
   		$modulus = ($row_count-1) % 22;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=21;
   	}

	for($i=0; $i<=$per_page_row; $i++)
	{
	
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
	echo "</td>";
	
	echo "<td >";
	echo $values["dept_name"][$k];
	echo "</td>";

	echo "<td >";
	echo $values["sec_name"][$k];
	echo "</td>";

	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["desig_name"][$k];
	echo "</td>";

	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["line_name"][$k];
	echo "</td>";

	$out_time = date('h:i:s A', strtotime($values["out_time"][$k]));
	echo "<td width='80' style='text-align:center;' >";
	echo $out_time;
	echo "</td>";

	echo "<td align='right' style='padding-right:5px;'>";
	echo $values["night_allowance"][$k];
	echo "</td>";
	$total_night_allo_amount = $total_night_allo_amount + $values["night_allowance"][$k];
	$grand_total = $grand_total + $values["night_allowance"][$k];
	echo "<td >";
	echo "";
	echo "</td>";
	
	echo "</tr>";
	//$section=$values["sec_name"][$k];
	$k++;
}
		echo "<tr style='font-weight:bold; background-color:#CCC;'>";

		echo "<td colspan='8' align='center'>";
		echo "Page Total";
		echo "</td>";
		
		echo "<td align='right'>";
		echo number_format($total_night_allo_amount);
		echo "</td>";
		
		echo "</tr>";
?>
<?php
	if($counter == $page)
   		{?>
			<tr height="10">

<td  colspan="8" style="text-align:center; font-weight:bold;" >
Grand Total
</td>
<td style="text-align:right; font-weight:bold;" ><?php echo number_format($grand_total); ?>/=</td>
            </tr>

			<?php } ?>
            
<table width="100%" height="100px" border="0" align="center" style="margin-bottom: 40px; font-family:Arial, Helvetica, sans-serif; font-size:10px; font-weight:bold;">
			<tr height="80%" >
			<td colspan="29"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:15%;"><dt class="bottom_txt_design" >Prepared By</dt></td>
            <td align="center"  style="width:25%" ><dt class="bottom_txt_design" >Account Office / Executive</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR Manager</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >General Manager (GM)</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Director</dt></td>
			</tr>
			</table>
</table>
</div>
</div>
<?php } ?>
</body>
</html>