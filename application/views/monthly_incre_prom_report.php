<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Increment/ Promotion Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
table td{ padding:8px 10px 8px 10px;font-size: 20px;}
.numeric{ text-align:right;}

.pagebreak:last-child {
            page-break-after: auto;
        }
        .pagebreak {
          clear: both;
          page-break-after: always;
        }
        html, body {
          page-break-after: avoid;
            page-break-before: avoid;
    }


</style>
</head>

<body style="margin-left:15px; margin-right:10px;font-size:17px;">
<?php
$count = count($values["new_emp_id"]);
for($i=0; $i<$count; $i++ )
{
$this->load->model("common_model");
?>
<div id="wrapper" class="pagebreak" style=" min-height:1100px;font-family:SolaimanLipi; margin:0 auto; width:750px;">
	<div style="width:730px; border-bottom:3px solid #000;">
	    <table width="730" cellpadding="3" style="font-family:SolaimanLipi;">
            <tr>
            	<?php $company_logo = $this->common_model->company_information("company_logo"); ?>
            	<td width="105">
            		<img width="55" height="55" src="<?php echo base_url(); ?>images/<?php echo $company_logo; ?>" />
            	</td>
            	<td width="491" style="font-size:15px;text-align:center">
            		<span style="font-size:18px; font-weight:bold;">
            			<?php echo $this->load->view('head_english'); ?>
            		</span>
            	</td>
    		</tr>
	    </table>
	</div>

<table border="0"cellpadding="0" cellspacing="10" style="font-size:15px; width:730px; border:0px;font-family:SolaimanLipi;margin-top: 20px;">
	<tr width="500px;">
		<td style="width:70px;">তারিখ</td>
		<td style="width:10px;">:</td>
		<td style="font-family:SutonnyMJ;"><?php echo $edate = date('d-m-Y',strtotime($values["effective_month"][$i])); ?></td>
	</tr>
	<tr>
		<?php
			$name = $this->db->where("emp_id",$values["new_emp_id"][$i])->get('pr_emp_per_info')->row()->bangla_nam;
		 ?>
		<td style="width:50px;">নাম</td>
		 <td style="width:10px;">:</td>
		<td>
			<span style="font-family:'Times New Roman', Times, serif;"><?php echo $name; ?></span>
		</td>
		<td style="width:50px;">পদবী</td>
		<td style="width:10px;">:</td>
		<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["prev_desig"][$i]; ?></span></td>
	</tr>
	<tr>
		<td style="width:50px;">কার্ড নং</td>
		<td style="width:10px;">:</td>
		<td><span style="font-family:SutonnyMJ;"><?php echo $values["new_emp_id"][$i]; ?></span></td>
		<td style="width:50px;">সেকশন</td>
		<td style="width:10px;">:</td>
		<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["prev_section"][$i]; ?></span></td>
	</tr>

</table>
</br>
<div style="; font-size:20px; border:0; width:800px; margin-bottom:30px; font-family:SolaimanLipi;">
	বিষয় : নিম্নতম মজুরি কাঠামো অনুযায়ী মূল বেতন বৃদ্ধির নোটিশ।
	<!--  ২০১৮ /২০১৯  ইং  -->
	
</div>
<div style="font-size:15px;border:0; width:800px; margin-bottom:20px;font-family:SolaimanLipi;">
	জনাব/জনাবা,
</div>

<div style="; font-size:20px;border:0; width:800px; margin-bottom:10px;font-family:SolaimanLipi;">
	<?php echo $name; ?>
</div>

<!-- <div style="; font-size:15px; border:0; width:730px; margin-bottom:30px;font-family:SolaimanLipi; text-align:justify;">
	এই মর্মে আপনাকে জানানো যাচ্ছে যে ৫ ডিসেম্বর ২০১৩ ইং তারিখে প্রকাশিত নিম্নতম মজুরী গেজেট মোতাবেক আপনার মূল বেতন ৫% বূদ্ধি করা হলো, যাহা <strong style="font-family:SutonnyMJ;"><?php echo $edate = date('d-m-Y',strtotime($values["effective_month"][$i])); ?></strong> ইং তারিখ থেকে কার্যকরী হইবে ।
 </div> -->

 <?php $increament =  (($values["new_salary"][$i] - $values["prev_salary"][$i]) * 100) / $values["prev_salary"][$i]; ?>
 <?php $incre =  ($values["new_salary"][$i] - $values["prev_salary"][$i]) ; ?>

 <div style="; font-size:20px; border:0; width:730px; margin-bottom:30px;font-family:SolaimanLipi; text-align:justify;">
	এই মর্মে আপনাকে জানানো যাচ্ছে যে, 
	<!-- ২৯ নভেম্বর ২০১৮ ইং ও ২৪ জানুয়ারী ২০১৯ ইং তারিখে সর্বশেষ সংশোধনী প্রকাশিত  -->
	নিম্নতম মজুরি গেজেট মোতাবেক আপনার মূল  বেতন <!-- ৫% --> 
	<?php echo "<span style='font-family:SutonnyMJ;'>".$incre."</span>"?> টাকা
	<!-- < ?php echo round($increament,1)."%"; ?>  -->
	বৃদ্ধি করা হল,যা <strong style="font-family:SutonnyMJ;"><?php echo $edate = date('d-m-Y',strtotime($values["effective_month"][$i])); ?></strong> ইং তারিখে থেকে কার্যকরী  হবে।
 </div>
   আপনার পূর্ববতী ও বর্তমান বেতনের তুলনামূলক চিত্র নিম্নে দেয়া হলঃ
<br>
<span style="font-family:SutonnyMJ;">
	<?php $salary_structure_pre = $this->common_model->salary_structure($values["prev_salary"][$i]); ?>
</span>
<span style="font-family:SutonnyMJ;">
	<?php $salary_structure_new = $this->common_model->salary_structure($values["new_salary"][$i]); ?>
</span>

<table  border="1" cellpadding="0" cellspacing="20" style="border-collapse: collapse; font-size:15px; width:730px; border:0px;font-family:SolaimanLipi;">
<!--<td>টাকা(মাসিক)</td>-->
	<tr>
		<th colspan="2" align="center">পূর্ববতী বেতন</th>
		<th colspan="2" align="center">বর্ধিত বর্তমান বেতন</th>
	</tr>
	<tr>
		<td>মূল বেতন</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['basic_sal']; ?></span>
		</td>
		<td>মূল বেতন</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['basic_sal']; ?></span>
		</td>
	</tr>

	<tr>
		<td>বাড়ী ভাড়া</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['house_rent']; ?></span>
		</td>
		<td>বাড়ী ভাড়া</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['house_rent']; ?></span>
		</td>
	</tr>

	<tr>
		<td>চিকিৎসা ভাতা	</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['medical_allow']; ?></span>
		</td>
		<td>চিকিৎসা ভাতা	</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['medical_allow']; ?></span>
		</td>
	</tr>

	<tr>
		<td>যাতায়াত ভাতা	</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['trans_allow']; ?></span>
		</td>
		<td>যাতায়াত ভাতা	</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['trans_allow']; ?></span>
		</td>
	</tr>

	<tr>
		<td>খাদ্য ভাতা</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['food_allow']; ?></span>
		</td>
		<td>খাদ্য ভাতা</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['food_allow']; ?></span>
		</td>
	</tr>

	<tr>
		<td>মোট</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $values["prev_salary"][$i]; ?></span>
		</td>
		<td>মোট</td>
		<td class="numeric">
			<span style="font-family:SutonnyMJ;"><?php echo $values["new_salary"][$i]; ?></span>
		</td>
	</tr>
</table>
 <table style="width:730px;margin-top:80px;">
	 <tr style="height: 150px;">
	 	<td><span>কর্তৃপক্ষ</span><td>
	 	<td><span></span><td>
	 </tr>
	 <tr>
	 	<td><span>লুপ ডট ফ্যাশন</span></td>
	 	<td style="text-align: right;"><span>শ্রমিকের স্বাক্ষর</span></td>
	 </tr>
  </table>


</div>
<?php } ?>
</body>
</html>
