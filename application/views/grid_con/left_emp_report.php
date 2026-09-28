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
	 /* font-weight:bold; */
}
.bottom_txt_manager_design
{
	border-top:1px solid;
	width:170px;
}
table,th,tr,td{
	margin:0px;
	padding:0px;
}
table.main_table{
	border-collapse: collapse;
}

table.main_table tr,table.main_table tr td,table.main_table tr th{
 border: 1px solid #000000;

}
</style>

</head>

<body>

<?php
	$per_page_id = 40;
	$row_count=count($values["emp_name"]);
	$max = $row_count;
	if($row_count > $per_page_id){
	$page = ceil($row_count/$per_page_id);
	}else{
	$page=1;
	}
	$k = 0;
	for($counter = 1; $counter <= $page; $counter ++){
?>
<?php $this->load->view("head_english");?><span style="font-size:13px; text-align: center;">
		<p style="text-align: center;padding: 0px;margin: 0;">Left Employee  Information </br>
			<?php echo date('d M Y',strtotime($start_date))."  TO  ".date('d M Y',strtotime($end_date)); ?>
		</p>	
<table class="main_table" align="center" height="auto"  style="font-size:11px; width:750px;margin:0 auto;">
	<th>SL</th>
	<th>Emp ID</th>
	<th>Name</th>
	<th>Designation</th>
	<th>Line</th>
	<th>Section</th>
	<th>Date of Birth</th>
	<th>Joining Date</th>
	<th>Last Working Date</th>
	<th>Remarks</th>
	<?php
		$section=array();

		for($i=0; $i<=$per_page_id;$i++){
		if($section!=$values["sec_name_en"][$k]){
			$i=$i+1;
			$row_count = $row_count+1;
			if($row_count >$per_page_id){
				$page=ceil($row_count/$per_page_id);
			}else{
				$page=1;
			}
		}
		echo "<tr>";
		echo "<td style='padding: 5px 3px;'>";
		echo $k+1;
		echo "</td>";

		echo "<td  style='text-align:center; width:70px;'>";
		echo $values["emp_id"][$k];
		echo "</td>";

		echo "<td style='padding: 5px 3px;'>";
		echo $values["emp_name"][$k];
		echo "</td>";

		echo "<td style='padding: 5px 3px;'>";
		echo $values["desig_name"][$k];
		echo "</td>";

		echo "<td style='padding: 5px 3px;'>";
		echo $values["line_name"][$k];
		echo "</td>";

		echo "<td style='padding: 5px 3px;'>";
		$sections = array_merge(
			explode(' ', $values["line_name"][$k]),
			explode('-', $values["line_name"][$k])
		);
		$sections = preg_split('/[ -]/', $values["line_name"][$k]);
		echo $sections[0]=="Line" ? "Sewing" : $sections[0];

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

		echo "<td   style='text-align:center; width:70px;'>";
		$year= trim(substr($values["e_date"][$k],0,4));
		$month = trim(substr($values["e_date"][$k],5,2));
		$tarik = trim(substr($values["e_date"][$k],8,2));
		$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
		$date = strtotime($date_format);
		$date = date("d-M-Y", strtotime($date_format));
		echo $date;
		echo "</td>";

		echo "<td  style='text-align:center; width:70px;'>";
		echo "&nbsp";
		echo "</td>";

		echo "</tr>";
			$section=$values["sec_name_en"][$k];
			$k++;
			if($max==$k){
				break;
			}
		}
		?>
	</table>
	<br><br><br>
	<div style="page-break-after: always;"></div>
	<?php
		if($max==$k){
		break;
		}
	}?>
</body>
</html>
<?php exit(); ?>
