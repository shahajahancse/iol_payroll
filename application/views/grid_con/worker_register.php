<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <style>
@media print {
    @page {
        size: legal landscape;
		margin:3px 0px;
    }
    table {
        width: 100%;
    }

}
    </style>
<title>General Employee Report</title>
</head>
<body>
	<div class="container-fluid">

		<div height="85px" style="margin-top: 20px;">
			<span  style="text-align:center;line-height:10px;margin-top:10px">
                <p class="unicode-to-bijoy">ফরম-৮</p>
                <p class="unicode-to-bijoy">[ধারা ৯ (১) (২) এবং বিধি ২৩ (১) দ্রষ্টব্য]</p>
                <p class="unicode-to-bijoy"><b>শ্রমিক রেজিষ্টার</b></p>
			</span>
		</div>
        <br><br>
		<?php 
        $unit_id =$this->session->userdata['data']->unit_name;
        $com_info = $this->db->select('*')->where('unit_id',$unit_id)->get('company_infos')->row();
        
        ?>
        <div>
            <span  colspan="22" style="text-align:left;line-height:10px;">
                <p class="unicode-to-bijoy">কারখানা বা প্রতিষ্ঠানের নামঃ <?php echo $com_info->company_name_bangla?></p>
                <p class="unicode-to-bijoy">কারখানা বা প্রতিষ্ঠানের ঠিকানাঃ <?php echo $com_info->company_add_bangla?></p>
                <p class="unicode-to-bijoy">শ্রমিকের শ্রেনী বিভাগঃ স্থায়ী</p>
            </span>
        </div>
	<table  border="1" cellspacing="0" cellpadding="2" style="font-size:18px;">
		<th class="text-center unicode-to-bijoy">ক্রমিক নং</th>
		<th class="text-center unicode-to-bijoy">শ্রমিকের রেজিস্টার নং</th>
		<th class="text-center unicode-to-bijoy">শ্রমিকের নাম   ও   এন আই ডি নং/জন্মনিবন্ধন নং</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>পিতার  নাম</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>মাতার  নাম </th>
		<th class="text-center unicode-to-bijoy">লিঙ্গ  জন্ম তারিখ ও বয়স</th>
		<th class="text-center unicode-to-bijoy">স্থায়ী   ঠিকানা </th>
		<th class="text-center unicode-to-bijoy">নিয়োগের  তারিখ</th>
		<th class="text-center unicode-to-bijoy">পদবী  ও  গ্রেড </th>
		<th class="text-center unicode-to-bijoy">কার্ড নং</th>
		<th class="text-center unicode-to-bijoy" style="font-family:SUtonnyMJ;font-size:17px">পাওনা ছুটি</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>কর্ম সময়</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'> বিরতির সময়</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>সাপ্তাহিক ছুটির দিন</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>গ্রুপের নাম</th>
		<!-- <th class="text-center unicode-to-bijoy">পালা ও রিলে</th> -->
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>গ্রুপ   বদলির   বিবরণ</th>
		<th class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'>gšÍe¨</th>
		<tr >
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">1</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">2</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">3</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">4</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">5</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">6</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">7</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">8</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">9</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">10</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">11</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">12</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">13</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">14</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">15</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">16</th>
			<th class='unicode-to-bijoy' style="font-size:14px;text-align:center">17</th>
		</tr>
		<?php ; $i= 1;foreach($values as $row){ ?>
		<tr>
			<td class="text-center" ><?php echo "<span style='font-family:SutonnyMJ;font-size:18px'>".$i++."</span>"?></td>
			<td class="text-center" ><?php echo "<span style='font-family:SutonnyMJ;font-size:18px'>".$row->id."</span>"?></td>
			<!-- <td class="text-center"><?php echo "<span style='font-family:SutonnyMJ;font-size:18px'>".$row->id."</span>"?></td> -->
			<td class="text-center" style="line-height:0px">
			<p class="unicode-to-bijoy" >
				<p style="font-size:19px" class="unicode-to-bijoy">
    			<?php echo $row->name_bn; ?>
			</p>
			<p class="unicode-to-bijoy" style="font-size:19px">
				<?php echo ($row->nid_dob_check == 1 ? 'এন আইডি নংঃ ' : 'জন্মনিবন্ধনঃ '); ?>
			</p>
			<p style="font-family:SutonnyMJ; font-size:19px">
				<?php echo $row->nid_dob_id; ?>
			</p>
		</p>
			</td>
			<td class="text-center unicode-to-bijoy"style='writing-mode: sideways-lr;'><?php echo $row->father_name?></td>
			<td class="text-center unicode-to-bijoy"style='writing-mode: sideways-lr;'><?php echo $row->mother_name?></td>
			<td class="text-center  " style="line-height:0px">
				<p class="unicode-to-bijoy"><?php
					echo $row->gender == 'Male' ? 'cyiæl' : 'নারী';
				?></p>
				<p style='font-family:SutonnyMJ;font-size:16px'><?= date('d/m/Y',strtotime($row->emp_dob)) ?></p>
				<p class="unicode-to-bijoy" style="line-height:0px">
				<?php
					$currentDate = new DateTime();
					$employeeDob = new DateTime($row->emp_dob);
					$diff = $currentDate->diff($employeeDob);
					echo $diff->format(' <span style = "font-size:16px">%y</span> বছর <span style = "font-size:16px">%m</span> মাস <span style = "font-size:16px">%d</span> দিন');
				?></p>
			</td>

			<td class="text-center unicode-to-bijoy" style="width: 150px;line-height:18px;">
				<?php echo $row->per_village_bn?>
				<?php echo $row->per_post_name_bn?>
				<?php echo $row->per_upa_name_bn?>
				<?php echo $row->per_dis_name_bn ?>
			</td>
			<td class="text-center" style="white-space:nowrap;"><?php echo "<span style='font-family:SutonnyMJ;font-size:16px'>".date('d/m/Y',strtotime($row->emp_join_date))."</span>"?></td>
			<td class="text-center unicode-to-bijoy" style="width: 80px;"><?php echo $row->desig_bangla.', '.$row->gr_name?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->emp_id?></td>
			<td>
				<ul style="position: relative;list-style-type: none;margin-left: -40px;">
					<li class="unicode-to-bijoy">বাৎসরিক = ১২</li>
					<li class="unicode-to-bijoy">নৈমিত্তিক = ১০</li>
					<li class="unicode-to-bijoy">পীড়া = ১৪</li>
					<li class="unicode-to-bijoy">অর্জিত ছুটি = ( প্রতি ১৮ </li>
					<li class="unicode-to-bijoy">কর্ম দিবসের জন্য ১ দিন ) </li>
				</ul>
			</td>
			<td class="text-center unicode-to-bijoy" style='writing-mode: sideways-lr;white-space: pre-wrap'>
				<p><?php echo 'সকাল ০৮ ঘটিকা'?> </p> 
				<p><?php echo 'হইতে বিকাল ০৫ ঘটিকা'?> </p>
			</td>
			<td class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;white-space: pre-wrap'>
				<p><?php echo 'দুপুর ০১ ঘটিকা '?></p>
				<p><?php echo ' হইতে ০২ ঘটিকা'?> </p>
			</td>
			<td class="text-center unicode-to-bijoy" style=' writing-mode: sideways-lr;'><?php echo 'শুক্রবার'?></td>
			<td class="text-center"><?php echo ''?></td>
			<td class="text-center"></td>
			<!-- <td class="text-center"></td> -->
			<td class="text-center"></td>
		</tr>
		<?php }?>
	</table>
	</div>
	<div style="page-break-after: always;"></div>
	<script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
<?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>
</html>
<?php exit(); ?>
