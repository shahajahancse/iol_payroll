<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>File</title>
<link  rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/id_card_style.css" />
</head>

<body>

<?php
//print_r($values);
$i = 0;
$k = 0;
//for($k=0; $k<=100; $k++)
$count = $values->num_rows();
$div_loop = ceil($count/6);
$data = $values->result_array();

for($j=1; $j<= $div_loop; $j++){
?>
<div style="overflow:hidden;">
	<table align="left" border="0" cellpadding="0" cellspacing="0" style="line-height: 15px;">
	<tr>
	<?php
	$end = $k + 7;
	$l = 0;
	if($j == $div_loop){
		$end = $count - $div_loop;
	}
	
	for($i=$k; $i <= $end; $i++){
		if ($i>=8 and $i%8==0) {
			echo '<div style="page-break-after: always;"></div>';
		}
		if($l % 2 == 0){
	?>
			</tr><tr>
<?php } ?>
	<td style="width:360px; height: 210px; padding: 15px 1px; float: left;" valign='top' align='center'>
		<div class="id_card_front" style="width:350px;  vertical-align: top; border-radius: 5px; border:1px solid black; float: left;">
			<div style="width: 100%; margin-top: 5px; float: left;">
				<div class="e_front_col_6" style=" padding:1px 0px 15px 0px; margin: 0 auto;">
					<spam style="font-size: 26px; font-family: kalpurush;"><u><b>PERSONAL FILE</b></u></spam>
				</div>
			  	<div class="front_top" style="width: 100%; margin: 10px auto;">
					<div class="front_top_left" style=" float:left;">
						<img src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_information("company_logo"); ?>" height="30px" width="30px" />
					</div>
				   	<div class="e_front_col_6" style="padding:1px 0px 0px 0px;">
						<spam style="font-size: 24px; font-family: kalpurush;"><i><?php echo $company_logo = $this->common_model->company_information("company_name_english"); ?></i></spam>
						<p style="margin: 0px; font-size: 18px; margin-top: 5px;font-family: kalpurush;"><?php echo $company_logo = $this->common_model->company_information("company_add_english"); ?></p>
					</div>
				</div>
			</div>
			<div class="front_top_left" style="width:100%; vertical-align:top; font-size: 20px; padding-top: 10px; text-align-last: left;">
				<div style="width: 70%; float: left;">
					<div class="front_row_left_3">
						<div class="e_front_col_6" style="font-size: 13px; margin: 5px;font-family: kalpurush;"> Department: <b><?php echo $data[$i]["dept_name"]; ?></b></div>
					</div>
					<div class="front_row_left_1">
						<div class="e_front_col_1" style="font-size: 13px; margin: 5px;font-family: kalpurush;"> Name: <b><span style="font-size: 15px;"><?php echo $data[$i]["emp_full_name"] ?></span></b></div>
					</div>
					<div class="front_row_left_1">
						<div class="e_front_col_1" style="font-size: 13px; margin: 5px;font-family: kalpurush;"> Designation: <b><span style="font-size: 15px;"><?php echo $data[$i]["desig_name"] ?></span></b></div>
					</div>
					<div class="front_row_left_1">
						<div class="e_front_col_1" style="font-size: 13px; margin: 5px;font-family: kalpurush;"> ID No: <b><span style="font-size: 15px;"><?php echo $data[$i]["emp_id"] ?></span></b></div>
					</div>
					<div class="front_row_left_1">
						<div class="e_front_col_1" style="font-size: 13px; margin: 5px;font-family: kalpurush;"> Joining Date: <b><span style="font-size: 15px;"><?php echo date('d/m/Y',strtotime($data[$i]["emp_join_date"])) ; ?></span></b></div>
					</div>
					<div class="front_row_left_1">
						<div class="e_front_col_1" style="font-size: 13px; margin: 5px;font-family: kalpurush;"> Line No: <b><span style=" font-size: 15px;"><?php echo $data[$i]["line_name"] ?></span></b></div>
					</div>
				</div>
				<div  style="width: 30%; float: left;" >
					<img style="border:1px solid black;" src="<?php echo base_url();?>uploads/photo/<?php echo $data[$i]["img_source"];?>" height="90" width="70" />
				</div>
			</div>
		</div>
	</td>
	<?php
	$k =$i+1;
	$l++;
	}
	?>
	</tr>
</table>

</div>
<br />
<?php
}
?>

</body>
</html>
