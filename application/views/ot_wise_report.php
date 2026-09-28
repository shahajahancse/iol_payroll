<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OT Wise EOT Employee Report</title>
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

<!-- <body style="width:800px;"> -->
<body style="width:800px;">

<?php 
$row_count=count($values["emp_full_name"]);
if($row_count > 26)
{
$page = ceil($row_count/26);
}
else
{
$page=1;
}

$k = 0;

			
			
			
for($counter = 1; $counter <= $page; $counter ++)
{
?>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:400px;">

<tr height="85px">
	<td colspan="22" style="text-align:center;">
	<?php
	$this->load->view("head_english");?>
	<span style="font-size:13px; font-weight:bold; text-align: center;">
	 OT Hour Wise Employee List 
	</span>

	</td>
</tr>
<th>SL</th>
<th>Emp ID</th>
<th>Name</th>
<th>Desi.</th>
<th>OT + EOT</th>

<?php		
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) %26;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=25;
   	}
	
	for($i=0; $i<=$per_page_row;$i++)
	{
	echo "<tr>";
	
	echo "<td>";
	echo $k +1;
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

	echo "<td >";
	echo $search_ot_hour;
	echo "</td>";
	
	echo "</tr>";
		$k++;
	}

	?>
		<tr>
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:90px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="80%" >
			<td></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR Manager</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Admin Manager</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >MD</dt></td>
			</tr>
			
			</table>
		</tr>
	 </table>
			  
	<?php

	}

?>

</body>
</html>