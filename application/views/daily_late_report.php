<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Late Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
</head>
<body>
<?php 
// echo count($section);
$per_page_id = 42;
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

$k = 0;
for($counter = 1; $counter <= $page; $counter ++)
{
 ?>
 
<div style=" margin:0 auto;">

<table style="width: 750px;margin:20px auto;">
<td style="text-align: center;">
<?php $this->load->view("head_english");?>
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
Daily Late
 Report of <?php echo "&nbsp;$date/$month/$year"; ?></span>

</div>
</td>
<!-- <td style="width: 30%;text-align: center;">
	<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:inline; font-weight:bold">
	<?php echo '<span style="font-family:SutonnyMJ">'."পাতা নং # $counter এর $page<br>".'</span>';?>

	</div>
</td> -->
</table>

<table class="sal" border="1" cellpadding="2" cellspacing="0" align="center" style="font-size:12px;width:750px">
<th>SL</th><th>Emp ID</th><th>Employee Name</th><th>Dept.</th><th>Line No. </th> <th>Designation</th> <th>Shift</th> <th>In Time</th><th>Sign.</th> 

<?php
$section=array();

for($i=0; $i<$per_page_id; $i++ )
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
	echo "<td colspan='10' style='font-size:16px;font-weight:bold'>Section :&nbsp".$values["sec_name"][$k]."</td>";
	echo "</tr>";
	
	
	}

	echo "<tr>";
	
	echo "<td>";
	echo $s = $k+1;
	echo "</td>";
	
	echo "<td style='font-weight:bold;'>";
	echo $values["emp_id"][$k];
	echo "</td>";

	
	echo "<td >";
	echo $values["emp_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["dept_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["line_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["desig_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["shift_name"][$k];
	echo "</td>";
	
	echo "<td width='80' align='center'>";
	echo $in_time =  $values["in_time"][$k];
	echo "</td>";

		
	echo "<td width='80' align='center'>";
	echo "";
	echo "</td>";	
	
	echo "</tr>";
	$section=$values["sec_name"][$k];

	$k++;
	if($max==$k){
		break;
	}
}

?>

</table>
<div style="page-break-after: always;"></div>
 </div>
<?php
	if($max==$k){
		break;
	}
 } ?>

</body>
</html>
