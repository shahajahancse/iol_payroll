<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily out punch miss Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="../../../../css/SingleRow.css" />
</head>

<body style="margin: 0px;">

<?php 
$per_page_id = 56;
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
<div id="no_print" style="float:right;">
</div>
<table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:150px;">
		<?php $this->load->view("head_english");?> <span style="font-size:13px; font-weight:bold; text-align: center;">
		 	Daily out punch miss Report of <?php echo "&nbsp $date/$month/$year"; ?>
			</span>
		</td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ;font-size:15px;">'."পাতা নং # $counter <br>".'</span>';?>
		</td>
	</tr>
</table>
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:12px; width:750px; margin-bottom:20px;">
<div style="clear:both;width: 100%;height: 20px;"></div>
<th>SL</th><th>Emp ID</th><th>Punch Card No.</th><th>Employee Name</th><th>Line No. </th> <th>Designation</th><th>IN Time</th><th>OUT Time</th><th>Remarks</th><th>Sign.</th>

<?php
$section=array();

	for($i=0; $i<=$per_page_id; $i++)
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
	echo "<td colspan='10' style='font-size:16px'>Section :&nbsp;".$values["sec_name"][$k]."</td>";
	echo "</tr>";
	?>

	<?php }

	echo "<tr>";
	
	echo "<td>";
	echo $s = $k+1;
	echo "</td>";
	
	echo "<td>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	echo "<td>";
	echo "&nbsp;";
	echo $values["proxi_id"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_name"][$k];
	echo "</td>";

	echo "<td >";
	echo $values["line_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["desig_name"][$k];
	echo "</td>";

	echo "<td >";
	echo $values["in_time"][$k];
	echo "</td>";


	// echo "<td width='80' style='text-align:center'>";
	// $values["in_time"][$i];
	// $hour = trim(substr($values["in_time"][$i],0,2));
	// $minute = trim(substr($values["in_time"][$i],3,2));
	// $sec = trim(substr($values["in_time"][$i],6,2));
	// $time_format = date("h:i:s A", mktime($hour, $minute, $sec, 0, 0, 0));
	// echo $time_format;
	// echo "</td>";
	
	echo "<td align='center' >";
	echo "";
	echo "</td>";
	
	echo "<td style='text-align:center' >";
	echo "&nbsp;";
	echo "</td>";
	  
	echo "<td style='text-align:center' width='80'>";
	echo "&nbsp;";
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