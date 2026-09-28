<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Less 1 Month SettelMent</title>
<link rel="stylesheet" type="text/css" href="../../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	.container{
		height: 900px;
		width: 700px;
		margin: 0 auto;
	}
	.heading{
		width: 700px;
		margin: 0 auto;
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

	p{
		margin:4px;
	}

</style>
</head>
<body>
<?php
		
foreach($values as $row)
	{ ?>
<div class="container">
<table style="text-align: center;width: 100%">
	<tr>
		<td style="width: 50px;">
			   <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
				<img width="55px" height="55px" src="<?php echo base_url(); ?>images/<?php echo $company_logo;?>">
			</td>
		<td style="font-size: 25px;"><?php $this->load->view("head_english"); ?></td>
	 </tr>
</table>
<div align="center" style="width:700px; border-bottom:3px solid #000;margin-bottom:15px;"></div>
<div class="heading" style="font-size: 25px;">বেতন ও ওটি হিসাব</div>
<?php
	$first= $row["salary_month"];
	$first_y=trim(substr($first,0,4));
	$first_m=trim(substr($first,5,2));
	$first_d=trim(substr($first,8,2));
	$month_format = date("F", mktime(0, 0, 0, $first_m, 1, $first_y));
   ?>

<p style="text-align: right;">তারিখঃ .............</p>
	<table>
		<tr>
			<td>নামঃ</td>
			<td>-</td>
			<td><?php echo $row["bangla_nam"];?></td>
		</tr>
		<tr>
			<td>আই,ডিঃ</td>
			<td>-</td>
			<td><?php echo $row["emp_id"];?></td>
		</tr>
		<tr>
			<td>পদবীঃ</td>
			<td>-</td>
			<td><?php echo $desig_name = $row["desig_bangla"];?></td>
		</tr>
		<tr>
			<td>মোট মজুরীঃ</td>
			<td>-</td>
			<td>
				<?php echo $row["gross_sal"];?>
			</td>
		</tr>
	</table>  
	<div class="heading">মাসের নামঃ <strong style="font-size: 14px;"><?php echo "$month_format, $first_y";?></strong> </div>
	<table class="salary_structure" style="">
		<tr>
			<th>বিবরণ</th>
			<th>পরিমান</th>
		</tr>
		<tr>
			<td style="text-align: left;">মূল বেতন</td>
			<td><?php echo $row["basic_sal"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">বাড়ী ভাড়া</td>
			<td><?php echo $row["house_r"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">চিকিৎসা ভাতা</td>
			<td><?php echo $row["medical_a"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">খাদ্য ভাতা</td>
			<td><?php echo $row["food_allow"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">যাতায়াত ভাতা</td>
			<td><?php echo $row["trans_allow"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট</td>
			<td><?php echo $row[""];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট দিন</td>
			<td><?php echo $row["total_days"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট প্রাপ্ত বেতন</td>
			<td><?php echo $row["gross_sal"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">ওভারটাইম (ঘণ্টা)</td>
			<td><?php echo $row["ot_hour"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">ওভারটাইম হার</td>
			<td><?php echo $row["ot_rate"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট ওভার টাইম</td>
			<td><?php echo $row["ot_hour"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট প্রদেয়</td>
			<td><?php echo $row["net_pay"];?></td>
		</tr>
		<tr>
			<td style="text-align: left;">ষ্ট্যাম্প </td>
			<td><?php echo "10";?></td>
		</tr>
		<tr>
			<td style="text-align: left;">মোট প্রাপ্তি</td>
			<td><?php echo $row["net_pay"];?></td>
		</tr>
	</table>

	<table style="margin-top:25px;text-align: left;font-size:20px;">
		<tr>
		 <td>টাকার পরিমান(কথায় ):
				<?php 
					$num = $row["net_pay"];
					$in_word =  numberTowords($num);
					echo '<span style="text-transform:capitalize;">'.$in_word.'</span>';
				?>.
			</td>
		</tr>
	</table>

	<table style="width:100%;margin:20px 0;text-align: center;">
		<tr>
			<td style="text-align: left;">মানব সম্পদ বিভাগ</td>
			<td>হিসাব বিভাগ</td>
			<td>কমপ্লায়েন্স  বিভাগ</td>
			<td style="text-align: right;">কর্তৃপক্ষ</td>
		</tr>
	</table>

	<div align="center" style="width:700px; border-bottom:3px solid #000;margin-bottom:5px;"></div>

	<div class="footer">
		<p style="text-align: center;text-transform: uppercase;font-weight: bolder;">A Member of Creative Group</p>
		<p style="text-align: center;">Head Office: House No.25(4th floor),Rabindra Swarani, Sector No.3, Uttara, Dhaka-1230.Bangladesh.</p>
		<p style="text-align: center;">Tel:8802-8957870,8958783,8958805, Fax:880-2-8957987, E-mail: info@creativegroupbd.net</p>
		<p style="text-align: center;">Web: www.creativegroupbd.net</p>
	</div>
  
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