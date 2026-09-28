<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Increment/ Promotion Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
table td{ padding:0px 10px 0px 10px;}
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
<div id="wrapper" class="pagebreak" style=" min-height:1000px;font-family:SolaimanLipi; margin:0 auto; width:750px;">

<div style="width:730px; border-bottom:3px solid #000;">
    <table width="730" cellpadding="3" style="font-family:SolaimanLipi;">
            <tr>
            <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
            <td width="105"><img width="55" height="55" src="<?php echo base_url(); ?>images/<?php echo $company_logo; ?>" /></td>
            <td width="491" style="font-size:15px;text-align:center">
            <span style="text-align:center"><?php $this->load->view("head_english");?></span></td>
    </tr>
    </table>
    </div>

<table  border="0" cellpadding="0" cellspacing="10" style="font-size:15px; width:730px; border:0px;font-family:SolaimanLipi;">
<tr>

<tr width="500px;">
<td>তারিখ  </td>
<td>:</td>

</tr>

<td>নাম</td>
<td>:</td>
<?php $name = $this->db->where("emp_id",$values["new_emp_id"][$i])->get('pr_emp_per_info')->row()->emp_full_name; ?>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $name; ?></span></td>
</tr>

<tr>
<td>কার্ড নং</td>
<td>:</td>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["new_emp_id"][$i]; ?></span></td>
<!-- <td>পরিবর্তিত কার্ড নং</td>
<td>:</td>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["new_emp_id"][$i]; ?></span></td> -->
</tr>

<tr>
<td>লাইন নং </td>
<td>:</td>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["prev_line"][$i]; ?></span></td>
</tr>


<tr>
<td>সেকশন</td>
<td>:</td>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["prev_section"][$i]; ?></span></td>
</tr>

<tr>
<td>পদবী</td>
<td>:</td>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["prev_desig"][$i]; ?></span></td>
</tr>

<tr>
<td>যোগদানের তারিখ </td>
<td>:</td><span style="font-family:'Times New Roman', Times, serif;">
<?php $join_date = $this->db->where("emp_id",$values["new_emp_id"][$i])->get('pr_emp_com_info')->row()->emp_join_date; ?></span>
<td><span style="font-family:'Times New Roman', Times, serif;"><?php echo date('d-m-Y', strtotime($join_date)); ?></span></td>
</tr>
</table>
</br>
<div style="; font-size:15px; border:0; width:800px; margin-bottom:30px; font-family:SolaimanLipi;">বিষয় : পদোন্নতিসহ মজুরী বৃদ্ধি/পদোন্নতি ব্যাতিত মজুরী বৃদ্ধি সংক্রান্ত  পত্র  ।</div>
<div style="; font-size:15px;border:0; width:800px; margin-bottom:30px;font-family:SolaimanLipi;">জনাব/জনাবা,</div>

<div style="; font-size:15px; border:0; width:730px; margin-bottom:30px;font-family:SolaimanLipi; text-align:justify;">

অতি  আনন্দের সাথে জানাচ্ছি যে, কর্তৃপক্ষ আপনার বর্তমান মজুরী <span style="font-family:'sutonnyMJ'"><?php echo $values["prev_salary"][$i]; ?> </span> টাকার সাথে <span style="font-family:'sutonnyMJ'; font-weight:bold;"><?php echo $increment = $values["new_salary"][$i] - $values["prev_salary"][$i]; ?> </span>টাকা বৃদ্ধি করে সর্বমোট <span style="font-family:'sutonnyMJ'"><?php echo $values["new_salary"][$i]; ?> </span> টাকায় উন্নীত করেছেন । যা <span style="font-family:'sutonnyMJ'"><?php $a= $values["effective_month"][$i]; echo date('d-n-Y',strtotime($a));  ?> </span> ইং তারিখ থেকে কার্যকর হবে । সাথে সাথে বর্তমান পদ <span style="font-family:'Times New Roman', Times, serif;"><?php echo $values["prev_desig"][$i]; ?></span> হতে <span style="font-family:'Times New Roman', Times, serif;"><?php if($values["status"][$i]==2){ echo $values["new_desig"][$i];}else{echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";} ?> </span>পদে পদোন্নতি প্রদান করেছেন । 

<br/>
<br/>
কর্তৃপক্ষ আপনার ভবিষ্যৎ পেশার উত্তরোত্তর উন্নতি কামনা করছেন ।
</div>
আপনার পূর্ববতী ও বর্তমান বেতনের তুলনামূলক চিত্র নিম্নে দেয়া হলঃ
<br>
<span style="font-family:SutonnyMJ;"><?php $salary_structure_pre 		= $this->common_model->salary_structure($values["prev_salary"][$i]); ?></span>
<span style="font-family:SutonnyMJ;"><?php $salary_structure_new = $this->common_model->salary_structure($values["new_salary"][$i]); ?></span>

<table  border="1" cellpadding="0" cellspacing="10" style="font-size:15px; width:730px; border:0px;font-family:SolaimanLipi;">
<!--<td>টাকা(মাসিক)</td>-->
<tr>
<th colspan="2" align="center">পূর্ববতী বেতন</th><th colspan="2" align="center">বর্ধিত বর্তমান বেতন</th>
</tr>
<tr>
<td>মূল বেতন</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['basic_sal']; ?></span></td>
<td>মূল বেতন</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['basic_sal']; ?></span></td>
</tr>

<tr>
<td>বাড়ী ভাড়া</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['house_rent']; ?></span></td>
<td>বাড়ী ভাড়া</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['house_rent']; ?></span></td>
</tr>

<tr>
<td>চিকিৎসা ভাতা	</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['medical_allow']; ?></span></td>
<td>চিকিৎসা ভাতা	</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['medical_allow']; ?></span></td>
</tr>

<tr>
<td>যাতায়াত ভাতা	</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['trans_allow']; ?></span></td>
<td>যাতায়াত ভাতা	</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['trans_allow']; ?></span></td>
</tr>

<tr>
<td>খাদ্য ভাতা</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_pre['food_allow']; ?></span></td>
<td>খাদ্য ভাতা</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $salary_structure_new['food_allow']; ?></span></td>
</tr>

<tr>
<td>মোট</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $values["prev_salary"][$i]; ?></span></td>
<td>মোট</td>
<td class="numeric"><span style="font-family:SutonnyMJ;"><?php echo $values["new_salary"][$i]; ?></span></td>
</tr>
</table><br />
<!-- আপনার ওভারটাইম হার (প্রতি ঘন্টা)<span style="font-family:SutonnyMJ; font-weight:bold; "> <?php 	echo $salary_structure_new['ot_rate'];?></span>&nbsp;&nbsp;টাকা। -->

<div style="border:0; width:800px; margin-top:50px;font-family:SolaimanLipi;">
<div  style="width:200px; margin-bottom:20px;font-size:15px; text-decoration: overline; float: left;">
<!-- সেকশন হেড -->
বিভাগীয় প্রধান(HR)  
</div>
<div  style="width:200px; margin-bottom:20px;font-size:15px; text-decoration: overline; float: left;">
<!-- বিভাগীয় প্রধান(HR)    -->
<!-- পত্র গ্রহণকারীর স্বাক্ষর                                       -->
</div>

<div  style="width:150px; margin-bottom:15px;font-size:15px; text-decoration: overline; float: left;">
<!-- পরিচালক  -->
</div>
<div  style="width:200px; margin-bottom:20px;font-size:15px; text-decoration: overline; float: left;">
পত্র গ্রহণকারীর স্বাক্ষর 
</div>
</div>

 <div style="width:150px; margin-top: -95px;font-size:15px; text-decoration: overline; float: left; margin-left: 398px;">
<span></span> 
</div>
<div style="width:150px; margin-top: -95px;font-size:15px; text-decoration: overline; float: left; margin-left: 220px;">
<span></span> 
</div>
</div>
<?php } ?>
</body>
</html>
