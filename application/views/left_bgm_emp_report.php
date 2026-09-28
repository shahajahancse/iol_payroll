<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
	Separation Report

</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
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

<body style="width:800px;">

<?php 
$row_count=count($values["emp_name"]);
if($row_count > 44)
{
$page = ceil($row_count/44);
}
else
{
$page=1;
}

$k = 0;

			
			
			
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">

<tr height="85px">

<td colspan="7" style="text-align:center;">
 
<?php
$this->load->view("head_english");?>
<span style="font-size:13px; font-weight:bold; text-align: center;">
DETAILS INFORMATION AND LEFTY EMPLOYEES LIST OF THE FACTORY FOR GROUP INSURANCE</br>
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
	
?></span>

</td>
</tr>


<th>SL</th>
<th>Emp ID</th>
<th>Name</th>
<th>Designation</th>
<th>Date of Birth</th>
<th>Joining Date</th>
<th>Remarks</th>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) %44;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=43;
   	}
  	
   	
	
	for($i=0; $i<=$per_page_row;$i++)
	{
		echo "<tr>";
	
	echo "<td>";
	echo $k+1;
	echo "</td>";
	
	echo "<td  style='text-align:center; width:70px;'>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_name"][$k];
	echo "</td>";
	
	
	echo "<td >";
	echo $values["desig_name"][$k];
	echo "</td>";
	
	
	echo "<td   style='text-align:center; width:70px;'>";
	$year= trim(substr($values["emp_dob"][$k],0,4));
	$month = trim(substr($values["emp_dob"][$k],5,2));
	$tarik = trim(substr($values["emp_dob"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";
	
	echo "<td  style='text-align:center; width:70px;'>";
	$year= trim(substr($values["doj"][$k],0,4));
	$month = trim(substr($values["doj"][$k],5,2));
	$tarik = trim(substr($values["doj"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";
	
	echo "<td  style='text-align:center; width:70px;'>";
	echo "&nbsp";
	echo "</td>";
	
	echo "</tr>";
		$k++;
	}
	?>
	
	
			
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:60px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
            <td align="center"  style="width:20%" ><dt class="bottom_txt_design" >Check By(Admin & HR Dept.)</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Approved By(Managing Director)</dt></td>
			</tr>
			
			</table>
			</table>
			  
			<?php

		}

?>

</body>
</html>