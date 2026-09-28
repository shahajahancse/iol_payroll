<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>New Join Report</title>
	<style>
		@media screen {
			table{
				width: 100%;
			}
		}
	</style>
</head>

<body >
	<br>
    <?php	
		$this->load->view("head_english");?>
    <div style="font-size:13px; font-weight:bold; text-align: center;">
        NEW JOINING EMPLOYEES LIST</br>
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
			$row_count=count($values["emp_name"]);
			$per_page=51;
		?>
    </div>

	<br>

   <table align="center" height="auto" style="font-size:12px; width:70%; border-collapse: collapse;" border="1">
        <tr>
            <th>SL</th>
            <th>Emp ID</th>
            <th>Emp Name</th>
            <th>Date of Birth</th>
            <th>Joining Date</th>
            <th>Designation</th>
            <th>Line</th>
            <th>Grade</th>
            <th>OT Entitle</th>
            <th>Att.Bonus</th>
            <th>Salary</th>
            <th>Remarks</th>
        </tr>
        <?php
	$j=1;
	for($k=0; $k < $row_count; $k++){
	$j=$j+1;
	echo "<tr>";

		echo "<td>";
		echo $k +1;
		echo "</td>";
		echo "<td  style='text-align:center;'>";
		echo $values["emp_id"][$k];
		echo "</td>";

		echo "<td style='white-space:nowrap'>";
		echo $values["emp_name"][$k];
		echo "</td>";
		
		echo "<td  style='text-align:center; white-space:nowrap'>";
		echo date('d M Y',strtotime($values["emp_dob"][$k]));
		echo "</td>";
		
		echo "<td  style='text-align:center; white-space:nowrap'>";
		echo date('d M Y',strtotime($values["doj"][$k]));
		echo "</td>";
		$prev_sec = $values["sec_name_en"][$k];
		echo "<td style='text-align:center;white-space:nowrap'>";
		echo $values["desig_name"][$k];
		echo "</td>";

		echo "<td style='white-space:nowrap'>";
		echo $values["line_name"][$k];
		echo "</td>";

		echo "<td  style='text-align:center'>";
		echo $values["gr_name"][$k];
		echo "</td>";

		echo "<td  style='text-align:center;'>";
		if($values["com_ot_entitle"][$k] == 0){
			echo "Yes";
		}else{
			echo "No";
		}
		echo "</td>";

		echo "<td  style='text-align:center;'>";
		if($values["att_bonus"][$k] == 2){
			echo "No";
		}else{
			echo $values["rule"][$k];
		}
		echo "</td>";

		echo "<td   style='text-align:center;'>";
		echo $values["gross_sal"][$k];
		echo "</td>";

		echo "<td  style='text-align:center; '>";
		echo "&nbsp";
		echo "</td>";

	echo "</tr>";

	if ($per_page==$j) {
		$j=1;
	?>
    </table>
    <div style="page-break-after: always;"></div>
	<br>

    <?php	
		$this->load->view("head_english");?>
    <div style="font-size:13px; font-weight:bold; text-align: center;">
        NEW JOINING EMPLOYEES LIST</br>
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
				$row_count=count($values["emp_name"]);
			 ?>
    </div>
    <table align="center" height="auto" style="font-size:12px; width:70%; border-collapse: collapse;" border="1">

        <tr>
            <th>SL</th>
            <th>Emp ID</th>
            <th>Emp Name</th>
            <th>Date of Date</th>
            <th>Joining Date</th>
            <th>Designation</th>
            <th>Line</th>
            <th>Grade</th>
            <th>OT Entitle</th>
            <th>Att.Bonus</th>
            <th>Salary</th>
            <th>Remarks</th>
        </tr>
        <?php 
	}
	?>
        <?php }?>

</body>

</html>
<?php exit(); ?>