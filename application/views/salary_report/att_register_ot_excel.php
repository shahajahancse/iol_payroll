<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head> </head>

<body>
	<?php
		$filename = "otreg.xls";
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
	?>

	<style type="text/css">
		.priview-body{font-size: 16px;color:#000;margin: 25px;}
		.priview-header{margin-bottom: 10px;text-align:center;}
		.priview-header div{font-size: 18px;}
		.priview-memorandum{padding-bottom: 20px;}
		.headding{border-top:1px solid #000;border-bottom:1px solid #000;text-align:center;}
		.table{width:100%;border-collapse: collapse;}
		.table td, .table th{border:0px solid #ddd;}
	</style>

	<?php
		if (is_string($value)) {
			echo $value;
			exit();
		}

		foreach($value as $row){
			$att_month = $year_month;
		}
		$att_month = $att_month;
		$per_page_id = 11;
		$row_count=count($value);
		if($row_count > $per_page_id){
			$page=ceil($row_count/$per_page_id);
		}
		else{
			$page=1;
		}
		$i = 0;
	?>
	<div class="head-container" style="padding:20px 0px;width: 100%;display: inline-block;">
		<div style="text-align:center; position:relative;padding-left:269px;width:50%; overflow:hidden; float:left; display:block;">
			<?php $this->load->view("head_bangla"); ?>
			<span style="font-size:13px; font-weight:bold;">Attendance Register of <?php echo  $year_month ?> </span>
		</div>
	</div>
	<table class="sal" border='1' cellpadding='0' cellspacing='0' style=" font-size:16px;">
		<th>SL #</th>
		<th>Emp Id </th>
		<th>Name</th>
		<th>Designation</th>
		<th>Line</th>
		<?php $first_y=date("Y", strtotime("$att_month"));
		$first_m=date("m", strtotime("$att_month"));
		$last_date = date("t", strtotime("$att_month"));

		for ($k=1 ; $k <= $last_date ; $k++ ){
			echo "<th style='width:20px;'>$k</th>";
		}
		echo "<th>Pre.</th>";
		echo "<th>Abs.</th>";
		echo "<th>Week.</th>";
		echo "<th>Holi.</th>";
		echo "<th>Leave</th>";
		echo "<th>T. Day</th>";
		echo "<th>OT/EOT Hour</th>";

		for($j=0; $j < $row_count; $j++){
			echo "<tr><td>";
			echo $i + 1;
			echo "</td><td>";
			echo (isset($value[$i]) && isset($value[$i]['emp_id'])) ? $value[$i]['emp_id'] : '';
			echo "</td><td>";
			echo (isset($value[$i]) && isset($value[$i]['name_en'])) ? $value[$i]['name_en'] : '';
			echo "</td><td>";
			echo (isset($value[$i]) && isset($value[$i]['desig_name'])) ? $value[$i]['desig_name'] : '';				echo "</td><td>";
			echo (isset($value[$i]) && isset($value[$i]['line_name_en'])) ? $value[$i]['line_name_en'] : '';
			echo "</td>";

			$p = 0 ;
			$a = 0 ;
			$l = 0 ;
			$w = 0 ;
			$h = 0 ;
			$total_ot = 0;

			for ($k=0 ; $k < $last_date ; $k++ ){
				$idate =$k;
				$date = $idate;
				echo "<td style='text-align:center;'>";
				if(!isset($value[$i][$date])){
					echo "&nbsp;";
				}else{
					if($value[$i][$date] == "A"){
						echo "<span style='background:#CCCCCC;'> ";
						echo $value[$i][$date];
						echo "</span>";
					}else{
						echo $value[$i][$date];
						$ot_date = date("Y-m-d", mktime(0, 0, 0, $first_m, (int)$k, (int)$first_y));
						echo "<br>";
						$daily_total_ot = $this->Grid_model->get_daily_total_ot_hour($value[$i]['emp_id'], $ot_date);
						echo $daily_total_ot;
						$total_ot = $total_ot + $daily_total_ot;
					}
					if($value[$i][$date] == "P"){ $p++;}
					if($value[$i][$date] == "A"){ $a++; }
					if($value[$i][$date] == "L"){ $l++; }
					if($value[$i][$date] == "W"){ $w++; }
					if($value[$i][$date] == "H"){ $h++; }
				}
				echo "</td>";
			}
			echo "<td style='text-align: center;'> $p </td>";
			echo "<td style='text-align: center;'> $a </td>";
			echo "<td style='text-align: center;'> $w </td>";
			echo "<td style='text-align: center;'> $h </td>";
			echo "<td style='text-align: center;'> $l </td>";
			$t_day = $p+ $a+  $w + $h +$l;
			echo "<td style='text-align: center;'> $t_day </td>";
			echo "<td style='text-align: center;'>";
			echo $total_ot;
			echo "</td>";
			echo "</tr>";
			$i++;
		} ?>
	</table>
</body>
</html>
<?php exit(); ?>
