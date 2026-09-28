<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Pension Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	.container{
		height: 1300px;
		width: 800px;
		margin: 0 auto;
	}
	.heading{
		width: 300px;
		margin: 10px auto 30px;
		padding: 10px;
		text-transform: uppercase;
		border: 0px solid #000;
		text-align: center;
		font-size: 18px;
		font-weight: bolder;
	}
	table.salary_structure{
		border:1px solid #000;
		border-collapse: collapse;
		width: 100%;
		text-align: center;
		margin-top:30px;
	}

	table.salary_structure tr,table.salary_structure tr th,table.salary_structure tr td{
		border:1px solid #000;
		border-collapse: collapse;
	}

	.service_benefit{
		width: 100px;
		margin: 30px auto 0;
		padding: 8px;
		text-transform: uppercase;
		border-bottom: 1px solid #000;
		text-align: center;
		font-size: 18px;
		font-weight: bolder;
	}

	table.year_structure{
		border:1px solid #000;
		border-collapse: collapse;
		width: 100%;
		text-align: center;
		margin-top:30px;
	}

	table.year_structure tr,table.year_structure tr th,table.year_structure tr td{
		border:1px solid #000;
		border-collapse: collapse;
	}

	table.earn_leave{
		border:1px solid #000;
		border-collapse: collapse;
		width: 100%;
		text-align: center;
		margin-top:30px;
	}

	table.earn_leave tr,table.earn_leave tr th,table.earn_leave tr td{
		border:1px solid #000;
		border-collapse: collapse;
	}

</style>
</head>
<body>
<?php
		
foreach ($value->result() as $row)
	{ ?>

  <div class="container">
	<table style="text-align: center;width: 100%">
		<tr>
			<td style="width: 50px;">
 			   <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
 				<img width="55px" height="55px" src="<?php echo base_url(); ?>images/<?php echo $company_logo;?>">
 			</td>
			<td><?php $this->load->view("head_english"); ?></td>
		 </tr>
	</table>

<div class="heading">চূড়ান্ত দাবি নিষপ্ততি পত্র</div>

<p style="text-align: right;">তারিখঃ .............</p>
	<table>
		<tr>
			<td>Name</td>
			<td>-</td>
			<td><?php echo $row->emp_full_name;?></td>
		</tr>
		<tr>
			<td>Designation</td>
			<td>-</td>
			<td><?php echo $row->desig_name;?></td>
		</tr>
		<tr>
			<td>Card NO</td>
			<td>-</td>
			<td><?php echo $emp_id = $row->emp_id;?></td>
		</tr>
		<tr>
			<td>Joining Date</td>
			<td>-</td>
			<td>
				<?php 
					$join_date = $row->emp_join_date;
					echo $join_date = date("d-m-Y",strtotime($join_date));
				?>
			</td>
		</tr>
	</table>  
<div class="heading">চাকরী অবসান কালের মোট পাওনা </div>
	<table class="salary_structure" style="">
		<?php 
			$gross = $row->gross_sal;
			$salary_structure = $this->common_model->salary_structure($gross);
		?>
		<tr>
			<th>পাওনার বিসইয়াদি</th>
			<th>টাকার পরিমান</th>
			<th>প্রদানের উৎস</th>
		</tr>
		<tr>
			<td style="text-align: left;">বেতন ও ওটি বাবদ</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">অর্জিত ছুটি</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">সার্ভিস বেনিফট</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">অনন্যা (যদি থাকে)</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট প্রাপ্তি</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">কর্তন (যদি থাকে)</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td style="text-align: left;">প্রদেয় টাকা</td>
			<td></td>
			<td></td>
		</tr>
	</table>

	<table style="margin-top:25px;text-align: left;font-size:20px;">
		<tr>
		 <td>টাকার পরিমান(কথায় ):
				<?php 
					$num = $sub_tamount;
					$in_word =  numberTowords($num);
					echo '<span style="text-transform:capitalize;">'.$in_word.'</span>';
				?>.
			</td>
		</tr>
	</table>

	<div class="service_benefit">শ্রমিকের বিবৃত</div>
	<p>আমি এই মর্মে ঘোষণা করিতেছি যে, চাকরি অবসানোকালে আমি আমার সমুদয় পাওনা বাবদ............টাকা বুঝিয়া পাইয়া নিম্নে স্বাক্ষর করিলাম। অত্র প্রতিষ্ঠানের নিকট আমার আর কোন পাওনা নাই।</p>
	<p style="text-align: right;">শ্রমিকের স্বাক্ষর<br>তারিখ...........</p>

	<div class="service_benefit">কর্তৃপক্ষের বিবৃত</div>
	<p>...............কার্ড নাম্বার ..................অত্র প্রতিষ্ঠানে......... থেকে .............পর্যন্ত কর্মরত ছিল। চাকরি অবসানোকালে তার সকল দেনা পাওনা নিষ্পত্তি করা হয়। অত্র প্রতিষ্ঠানের সাথে তার কোন দেনা পাওনা নাই।</p>


	<!-- <table class="year_structure" style="">
	 <tr>
		<th>YEAR</th>
		<th>DAY'S</th>
		<th>AMOUNT</th>
	</tr>
	 <?php
	  $resign_date = $row->e_date;
	  $doj = date("Y-m-d",strtotime($join_date));
	  $dor = date("Y-m-d",strtotime($resign_date));
	
	  	  $diff = date_diff(date_create($dor), date_create($doj));
	
	    $year = $diff->format('%y');
		$month = $diff->format('%m');
		$day = $diff->format('%d');
		
	 	$resign_date = $row->e_date;
	 	$join_time = strtotime($join_date);
	 	$regign_time = strtotime($resign_date);
	
	 	
	 	$diff_time = $regign_time - $join_time;
	
	 	$first_check_day = 365*4 + 240 + 1; // 1 add for one leap year
	 	$first_check_time = $first_check_day*24*60*60;
	
	 	$second_check_day = 365*9 + 240 + 2; // 2 add for two leap year
	 	$second_check_time = $second_check_day*24*60*60;
	 	
	 	$per_year_Gtotal = 0;
	 	$Total_day 		 = 0;
	
	 	if($diff_time >= $first_check_time && $diff_time < $second_check_time){
	 		//echo "first";
	 		$per_year_total = ceil(14*($basic/30));
	 		$fixed_day = 14;
	 	}else if($diff_time >= $second_check_time){
	 		//echo "second";
	 		$per_year_total = ceil(30*($basic/30));
	 		$fixed_day = 30;
	 	}
	
	 	
		for($i=1;$i<=$year;$i++){
			$earn_join_date = strtotime(date("Y-m-d", strtotime($doj)) . " +".$i." year");
		    $render_year = date("d/m/Y",$earn_join_date);
	
		    $per_year_Gtotal = $per_year_Gtotal + $per_year_total;
	
		    $Total_day = $Total_day + $fixed_day;
		    
		    echo '<tr>';
				echo '<td>'.$render_year.'</td>';
				echo '<td>'.$fixed_day.'</td>';
				echo '<td>'.$per_year_total.'/='.'</td>';
			echo '</tr>';
		}
		if($month >= 8){
			$resign_date_ex = date("d/m/Y",strtotime($resign_date));
			$per_year_Gtotal = $per_year_Gtotal + $per_year_total;
			$Total_day = $Total_day + $fixed_day;
			
			echo '<tr>';
				echo '<td>'.$resign_date_ex.'</td>';
				echo '<td>'.$fixed_day.'</td>';
				echo '<td>'.$per_year_total.'/='.'</td>';
			echo '</tr>';
		}
	
	  	?>
	
		<tr>
			<td colspan="2" style="text-align: right;"><div style="margin-right: 125px;"> TOTAL: <?php echo $Total_day;?></div></td>
			<td><?php echo $per_year_Gtotal.'/='; ?></td>
		</tr>
	
	</table>
	<div class="service_benefit">Earn Leave Benefit:</div>
	<table class="earn_leave" style="">
		<?php 
		  //echo $render_year;
		  //echo $emp_id;
		 //$data = $this->Grid_model->grid_earn_leave_payment_for_pension($resign_date, $render_year, $emp_id);
		 $data = $this->Grid_model->grid_earn_leave_payment_buyer($resign_date, $render_year, $emp_id);
		  $tpresentday = $data['tAttDays'];
		  $tel = $data['el'];
		  //$gross = $data['gross_sal'];
		  $per_day_amount = round($gross_t/30,2);
	
		  $tpayableday = round($tpresentday/18,2);
		  $payableday = $tpayableday - $tel;
	
		  $t_amount = ceil($per_day_amount * $payableday);
	
		  $sub_tamount = ceil($per_year_Gtotal + $t_amount);
		 ?>
		<tr> 
			<th>Working Day's</th>
			<th>Total Payable Day's</th>
			<th>Leave Day's</th>
			<th>Payable Day's</th>
			<th>Per Day's Amount</th>
			<th>Amount</th>
		</tr>
		<tr>
			<td><?php echo $tpresentday; ?></td>
			<td><?php echo $tpayableday; ?></td>
			<td><?php echo $tel; ?></td>
			<td><?php echo $payableday; ?></td>
			<td><?php echo $per_day_amount;?>/=</td>
			<td><?php echo $t_amount;?>/=</td>
		</tr>
		<tr>
			<td colspan="4"></td>
	
			<td>Sub Total:</td>
			<td><?php echo $sub_tamount;?>/=</td>
		</tr>
	
	</table>
	
	
	
	<table style="margin:60px 0;text-align: left;">
		<tr>
			<td style="width: 300px;">SIGNATURE OF RECIPENT: </td>
			<td>STAMP</td>
		</tr>
	</table> -->
   

	<table style="width:100%;margin:50px 0;text-align: center;">
		<tr>
			<td style="text-align: left;">মানব সম্পদ বিভাগ</td>
			<td>হিসাব বিভাগ</td>
			<td>কমপ্লায়েন্স  বিভাগ</td>
			<td style="text-align: right;">কর্তৃপক্ষ</td>
		</tr>
	</table>
  
 </div>

 <?php } ?>

<?php

function numberTowords($num)
	{ 
	$ones = array( 
	1 => "one", 
	2 => "two", 
	3 => "three", 
	4 => "four", 
	5 => "five", 
	6 => "six", 
	7 => "seven", 
	8 => "eight", 
	9 => "nine", 
	10 => "ten", 
	11 => "eleven", 
	12 => "twelve", 
	13 => "thirteen", 
	14 => "fourteen", 
	15 => "fifteen", 
	16 => "sixteen", 
	17 => "seventeen", 
	18 => "eighteen", 
	19 => "nineteen" 
	); 
	$tens = array( 
	1 => "ten",
	2 => "twenty", 
	3 => "thirty", 
	4 => "forty", 
	5 => "fifty", 
	6 => "sixty", 
	7 => "seventy", 
	8 => "eighty", 
	9 => "ninety" 
	); 
	$hundreds = array( 
	"hundred", 
	"thousand", 
	"million", 
	"billion", 
	"trillion", 
	"quadrillion" 
	); //limit t quadrillion 
	$num = number_format($num,2,".",","); 
	$num_arr = explode(".",$num); 
	$wholenum = $num_arr[0]; 
	$decnum = $num_arr[1]; 
	$whole_arr = array_reverse(explode(",",$wholenum)); 
	krsort($whole_arr); 
	$rettxt = ""; 
	foreach($whole_arr as $key => $i){ 
	if($i < 20){ 
	$rettxt .= $ones[$i]; 
	}elseif($i < 100){ 
	$rettxt .= $tens[substr($i,0,1)]; 
	$rettxt .= " ".$ones[substr($i,1,1)]; 
	}else{ 
	$rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
	$rettxt .= " ".$tens[substr($i,1,1)]; 
	$rettxt .= " ".$ones[substr($i,2,1)]; 
	} 
	if($key > 0){ 
	$rettxt .= " ".$hundreds[$key]." "; 
	} 
	} 
	if($decnum > 0){ 
	$rettxt .= " and "; 
	if($decnum < 20){ 
	$rettxt .= $ones[$decnum]; 
	}elseif($decnum < 100){ 
	$rettxt .= $tens[substr($decnum,0,1)]; 
	$rettxt .= " ".$ones[substr($decnum,1,1)]; 
	} 
	} 
	return $rettxt; 
	}

 ?>


</body>
</html>