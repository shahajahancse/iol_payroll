<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily
<?php 
if($daily_status == "A")
{
	echo "Absent";
}
?> 
 Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
</head>
<body>
<?php 
// echo count($section);
$per_page_id = 43;
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

 <table class="heading" align="center" height="auto" style="font-size:12px; width:700px;border:0px;;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:150px;">
		<?php $this->load->view("head_english");?> <span style="font-size:13px; font-weight:bold; text-align: center;">
			Daily 
			<?php 
				if ($daily_status == "A")
				{
					echo "Absent";
				}
				elseif($daily_status == "P")
				{
					echo "Present";
				}
				elseif($daily_status == "L")
				{
					echo "Leave";
				}
				  
				?> Report of <?php echo "&nbsp $date/$month/$year"; ?>
			</span>
		</td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ;font-size:15px;">'."পাতা নং # $counter <br>".'</span>';?>
		</td>
	</tr>
</table>
 
<!--Report title goes here-->
<div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:850px; margin-bottom:200px; min-height:1000px;">

	<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:13px; border-collapse:collapse;width:850px;">

		<th>SL</th>
		<th>Emp ID</th>
		<th>Punch Card No.</th>
		<th style="width:230px;">Employee Name</th> 
		<th style="width:100px">Line No. </th> 
		<th style="width:130px;">Department </th> 
		<th style="width:110px;">Designation</th>
		<th>Status</th> 

		<?php if($daily_status == "A") {
			echo "<th>Mobile</th> ";
			echo "<th>Remarks</th> ";
			echo "<th>Sign.</th> ";
		} ?>

		<?php
		$section=array();
		 //    if($counter == $page)
		 //  	{
		 //   		$modulus = ($row_count-1) % $per_page_id;
		 //    	$per_page_row = $modulus;
			// }
		 //   	else
		 //   	{
		 //    	$per_page_row = $per_page_id - 1;
		 //   	}
		 //   	echo $per_page_row;
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
				if ($daily_status == "A") {
					echo "<td colspan='11' style='font-size:14px'>Section :&nbsp".$values["sec_name"][$k]."</td>";
				} else {
					echo "<td colspan='10' style='font-size:14px'>Section :&nbsp".$values["sec_name"][$k]."</td>";
				}
				echo "</tr>";

			}

			echo "<tr>";
			
			echo "<td style='text-align:center'>";
			echo $s = $k+1;
			echo "</td>";
			
			echo "<td style='padding:0px 5px 0px 5px; font-weight:bold; height:20px;'>";
			echo $values["emp_id"][$k];
			echo "</td>";
			
			echo "<td style='padding:0px 5px 0px 5px;'>";
			echo $values["proxi_id"][$k];
			echo "</td>";
			
			echo "<td style='padding:0px 5px 0px 5px;'>";
			echo $values["emp_name"][$k];
			echo "</td>";
			
			echo "<td style='padding:0px 5px 0px 5px;'>";
			echo $values["line_name"][$k];
			echo "</td>";
			
			echo "<td style='padding:0px 5px 0px 5px;'>";
			echo $values["dept_name"][$k];
			echo "</td>";
			
			echo "<td style='padding:0px 5px 0px 5px;'>";
			echo $values["desig_name"][$k];
			echo "</td>";
			
			echo "<td style='text-align:center'>";
			// echo $values["cont_absent"][$k];//$values["status"][$i];
			echo $values["status"][$k];
			echo "</td>";

			if($daily_status == "A")
			{
				echo "<td style='text-align:center' width='80' >";
				echo $values["mobile"][$k];
				echo "</td>";
			}

			echo "<td style='text-align:center' >";
			echo "";
			echo "</td>";
			
			echo "<td style='text-align:center' width='80'>";
			echo "";
			echo "</td>";

			echo "</tr>";
			$section=$values["sec_name"][$k];
			$k++;
			if($max==$k){
				break;
			}
		} ?>

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