<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Earn Leave Payment Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	.container{
		height: 800px;
		width: 800px;
		margin: 0 auto;
	}
	.title{
		width: 800px;
		margin: 10px auto 30px;
		padding: 10px;
		text-transform: uppercase;
		border: 0px solid #000;
		text-align: center;
		font-size: 18px;
		font-weight: bolder;
	}
	.heading{
		width: 300px;
		padding: 10px;
		margin-top: 30px;
		text-transform: uppercase;
		border: 0px solid #000;
		text-align: left;
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
		
foreach ($values->result() as $row)
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
<div align="center" style="width:800px; border-bottom:3px solid #000;margin-bottom:15px;"></div>

<p style="text-align: right;">তারিখঃ .............</p>
	<table>
		<tr>
			<td>নামঃ</td>
			<td>-</td>
			<td><?php echo $row->bangla_nam;?></td>
		</tr>
		<tr>
			<td>আই,ডিঃ</td>
			<td>-</td>
			<td><?php echo $row->emp_id;?></td>
		</tr>
		<tr>
			<td>পদবীঃ</td>
			<td>-</td>
			<td><?php echo $desig_bangla = $row->desig_bangla;?></td>
		</tr>
		<tr>
			<td>সেকশনঃ</td>
			<td>-</td>
			<td><?php echo $sec_bangla = $row->sec_bangla;?></td>
		</tr>
		<tr>
			<td>মূল বেতনঃ</td>
			<td>-</td>
			<td>
				<?php 
					//$join_date = $row->emp_join_date;
					//echo $join_date = date("d-m-Y",strtotime($join_date));
				?>
			</td>
		</tr>
	</table>  
<div class="title">সার্ভিস বেনিফিট হিসাব</div>
<p style="text-align: center;">(সুময় কালঃ..................................................)</p>
	<table class="salary_structure" style="">
		<?php 
			//$gross = $row->gross_sal;
			//$salary_structure = $this->common_model->salary_structure($gross);
		?>
		<tr>
			<th>সুময়কাল</th>
			<th>প্রতি বছর(দিন)</th>
			<th>মোট দিনের সংখ্যা</th>
			<th>মূল বেতনের প্রতি দিনের হার</th>
			<th>মোট টাকা</th>
		</tr>
		<tr>
			<td><br><br></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>

		</tr>
	</table>

	<table style="margin-top:12px;text-align: left;font-size:20px;">
		<tr>
		 <td>টাকার পরিমান(কথায় ):
				<?php 
					//$num = $sub_tamount;
					//$in_word =  numberTowords($num);
					//echo '<span style="text-transform:capitalize;">'.$in_word.'</span>';
				?>.
			</td>
		</tr>
	</table>

	<table style="width:100%;margin:70px 0px  30px 0px;text-align: center;">
		<tr>
			<td style="text-align: left;">মানব সম্পদ বিভাগ</td>
			<td>হিসাব বিভাগ</td>
			<td>কমপ্লায়েন্স  বিভাগ</td>
			<td style="text-align: right;">কর্তৃপক্ষ</td>
		</tr>
	</table>

	<div align="center" style="width:800px; border-bottom:3px solid #000;margin-bottom:15px;"></div>

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