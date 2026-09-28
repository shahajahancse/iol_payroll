<html>
<head>
<title>Monthly Attendance Register</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
</head>
<body>


<div align="center" style=" margin:5px auto 0;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">

<?php 
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
	for($counter = 1; $counter <= $page; $counter++){ ?>
	<div class="head-container" style="padding:20px 0px;width: 100%;display: inline-block;">
		<div style="text-align:center; position:relative;padding-left:269px;width:50%; overflow:hidden; float:left; display:block;">
		<?php 
			$this->load->view("head_bangla");
		?>
		<span style="font-size:14px; font-weight:bold;font-family: SutonnyMj;margin-top: 10px;">
			<?php 
				$report_date = date('m-Y',strtotime($year_month)); 
				echo $report_date.' মাসের উপস্থিতি নিবন্ধন';
			?> 
		</span>
		</div>
		<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:inline; font-weight:bold">
			<?php
			echo '<span style="font-family:SutonnyMJ">'."পাতা নং # $counter এর $page<br>".'</span>';?>

		</div>
	</div>
	<table class="sal" border='1' cellpadding='0' cellspacing='0' style=" font-size:16px;">
		<th>SL #</th>
		<th>Emp Id </th>
		<th>Name</th>
		<th>Dsignation</th>
		<?php
			$first_y=trim(substr($att_month,0,4));
			$first_m=trim(substr($att_month,5,2));
			$last_date = date("t", mktime(0, 0, 0, $first_m, 1, (int)$first_y));
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
			if($counter == $page){
				$modulus = ($row_count-1) % $per_page_id;
				$per_page_row = $modulus;
			}
			else{
				$per_page_row = $per_page_id - 1;
			}
			
			for($j=0; $j<=$per_page_row; $j++){ 
				echo "<tr><td>";
				echo $i + 1;
				echo "</td><td>";
				echo $value[$i]['emp_id'];
				echo "</td><td>";
				echo $value[$i]['name_en'];
				echo "</td><td>";
				echo $value[$i]['desig_name'];
				echo "</td>";

				$p = 0 ;
				$a = 0 ;
				$l = 0 ;
				$w = 0 ;
				$h = 0 ;
				$total_ot_eot = 0;
				
				for ($k=1 ; $k <= $last_date ; $k++ ){
				$idate = date("d", mktime(0, 0, 0, 0, $k, 0));
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
						$ot_date = date("Y-m-d", mktime(0, 0, 0, $first_m, $k, (int)$first_y));
						echo "<br>";
						$daily_total_ot = $this->Grid_model->get_daily_total_ot_hour($value[$i]['emp_id'], $ot_date);
						$daily_total_eot = $this->Grid_model->get_daily_total_eot_hour($value[$i]['emp_id'], $ot_date);
					
						// $user_id = $CI->acl_model->get_user_id($CI->session->userdata('username'));
						// $acl     = $this->acl_model->get_acl_list($user_id);
						$ot_eot = $daily_total_ot + $daily_total_eot;
						echo $ot_eot;
						$total_ot_eot = $total_ot_eot + $ot_eot;
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
				echo "<td style='text-align: center;'>  $w </td>";
				echo "<td style='text-align: center;'> $h </td>";
				echo "<td style='text-align: center;'> $l </td>";
				$t_day = $p+ $a+  $w + $h +$l;
				echo "<td style='text-align: center;'> $t_day </td>";
				echo "<td style='text-align: center;'>";
				echo $total_ot_eot; 
				echo "</td>";
				echo "</tr>";
				$i++;
			}
		?>
	</table>
<div style="page-break-after: always;"></div>
<?php } ?>
</body>
</html>