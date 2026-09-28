<html>
<head>
<title>Monthly Attendance Register</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
</head>
<body>


<div align="center" style=" margin:5px auto 0;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">

<?php foreach($value as $row){
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
	// for($counter = 1; $counter <= $page; $counter++){ ?>
		<div class="head-container" style="padding:20px 0px;width: 100%;display: inline-block;">
			<div style="text-align:center; position:relative;padding-left:269px;width:50%; overflow:hidden; float:left; display:block;">
				<?php $this->load->view("head_bangla"); ?>
				<span style="font-size:13px; font-weight:bold;">Attendance Register of <?php echo  $year_month ?> </span> 
			</div>
			<!-- <div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:inline; font-weight:bold">
				<?php //echo '<span style="">'."Page No. # $counter of $page<br>".'</span>';?>
			</div> -->
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

			// if($counter == $page){
			// 	$modulus = ($row_count-1) % $per_page_id;
			// 	$per_page_row = $modulus;
			// }else{
			// 	$per_page_row = $per_page_id - 1;
			// }

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
		<div style="page-break-after:always;"></div>
	<?php //} ?>
</body>
</html>
<br><br><br>
<?php exit(); ?>
