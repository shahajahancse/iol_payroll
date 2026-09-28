<!DOCTYPE html>
<html>
<head>
	<title>Job Application</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/appointment_letter.css">-->
	<style type="text/css">
		table{
			border: none;
		}
		p{
			margin:4px;
		}
		#nav_inner{
			width: 137px;
			border-bottom: 1px solid #000;
		}
	</style>	 
</head>
		   
<body style="font-family:SolaimanLipi; font-size: 12px;">
	<?php  foreach($values->result() as $row){ ?>
<div id="wrapper" style="margin:0 auto; min-height:1000px;width: 730px;">
<img style="float: left;" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_information("company_logo"); ?>" height="70" alt="LOGO" />
<div style="margin-left: 73px;" id="com_nam"> 
	<?php $this->load->view('head_bangla'); ?>
</div>
<div style="width: 100%;height: 10px;clear:both;"></div>
<div align="center" style="width:700px; border-bottom:3px solid #000;margin-bottom:15px;"></div>
<div id="nav" align="center" style="margin-top:20px; font-size: 18px;font-weight: bold;">
	<div id="nav_inner">
		চাকুরীর আবেদনপত্র 
	</div>
</div>
<div class="app_letter_container">
<div class="app_letter" style="width: 550px;float: left;">
	<p>বরাবর</p>
	<p>ব্যবস্থাপনা পরিচালক</p>
	<p>লুপ ডট ফ্যাশন</p>
	<p>বাসাইল, হাজির বাজার, ভালুকা</p>
	<p>ময়মনসিংহ</p>
	<p>বিষয়ঃ <strong><?php echo $row->desig_bangla; ?></strong> পদে চাকুরীর জন্য আবেদন পত্র</p>
	<p>জনাব/জনাবা</p>
</div>
<div class="photo" style="float:right; border:1px solid black; width:110px; height:120px; text-align:center;">
	<img style="border:1px dashed black;" src="<?php echo base_url();?>uploads/photo/<?php echo $row->img_source; ?>" height="120" width="110"/>
</div>
</div>
<div style="clear:both;"></div>
<p>যথা বিহীত সন্মান প্রদর্শন পূর্বক বিনীত নিবেদন এই যে, আমি বিশ্বস্ত সূত্রে জানতে পারলাম আপনার প্রতিষ্ঠানে উপরোক্ত পদে কিছু সংখ্যক লোক নিয়োগ করা হবে। আমি উক্ত পদে একজন পার্থী হিসাবে নিম্নে আমার জীবন বৃত্তান্ত প্রদান করলাম</p>

	<div style="clear:both;"></div>

	<div style="border:0px solid; line-height:20px; font-size:12px;">
		<table width="100%">
			<tr>
			  <td width="80">নাম</td>
			  <td width="20">:</td>
			  <td width="300" align="left"><?php echo $row->bangla_nam; ?></td><td> লিঙ্গঃ &nbsp;&nbsp;<?php echo $row->sex_name; ?>
			</tr>
			<tr>
				<td>পিতার/ স্বামীর নাম</td>
				<td>:</td>
				<td><?php echo $row->emp_fname; ?></td><td>পেশাঃ&nbsp;&nbsp;</td>
			</tr>

			<tr>
				<td>মাতার নাম
				</td>
				<td>:</td>
				<td><?php echo $row->emp_mname; ?></td>
			</tr>

			<tr>
				<td>বর্তমান ঠিকানা
				</td>
				<td>:</td>
				<td><?php echo $row->emp_pre_add; ?></td>
			</tr>

			<tr>
				<td>স্থায়ী ঠিকানা</td>
				<td>:</td>
				<td><?php echo $row->emp_par_add; ?></td>
			</tr>
			<tr>
				<td>ফোন/মোবাইলঃ </td>
				<td>:</td>
				<td style="font-family: SutonnyMJ"><?= $row->mobile;?></td>
			</tr>

			<tr>
				<td>জন্ম তারিখ
				</td>
				<td>:</td>
				<td><span style="font-family:SutonnyMJ"><?php $dob = $row->emp_dob;echo date("d-m-Y", strtotime($dob));?></span></td>
			</tr>

			<tr>
				<td>জাতীয়তা
				</td>
				<td>:</td>
				<td>বাংলাদেশী।</td>
				<!-- <td>জন্মস্থান :&nbsp;&nbsp;<?php echo $row->emp_par_add_ban; ?></td> -->
			</tr>

			<tr>
				<td>সনাক্তকরণ চিহ্ন
				</td>
				<td>:</td>
				<td></td><td style="font-family: SutonnyMJ"> উচ্চতা:&nbsp;&nbsp; <?=$row->posi_name;?></td><td>রক্তের গ্রুপ:&nbsp;&nbsp;<?=$row->blood_name;?> </td>
			</tr>

			<tr>
				<td>বৈবাহিক অবস্থা
				</td>
				<td>:</td>
				<td> 	বিবাহিত / অবিবাহিত / বিধবা / তালাক প্রাপ্ত / বিচ্ছিন্ন  </td>
			</tr>

			<tr>
				<td>শিক্ষাগত যোগ্যতা
				</td>
				<td>:</td>
				<td><?php echo $row->emp_degree; ?></td>
			</tr>

			<tr>
				<td>বিবাহের তারিখ
				</td>
				<td>:</td>
				<td style="font-family: SutonnyMJ"></td><td style="font-family: SutonnyMJ"> সন্তান সংখ্যা:&nbsp;&nbsp; <?= $row->no_child;?></td>
			</tr>

			<tr>
				<td>ধর্ম
				</td>
				<td>:</td>
				<td><?php echo $row->religion_name; ?></td><td></td>
			</tr>
		</table>

		<div style="inline-box-align: 1px">
			<div style="margin-top: 8px;border:0px solid; float:left; width:385px;">
				<span style="font-family:SutonnyMJ; font-size:12px;">  আপনি কি পূর্বে কখনো এই প্রতিষ্ঠানে চাকুরীর আবেদন করেছিলেন ?<br />      
				চাকুরী ছেড়েছিলেন কেন? </span> 
			</div>
			<div style="margin-top: 8px;border:0px solid; float:left; width:300px;">
				&nbsp;&nbsp;<span style="height: 10px;width: 10px; border: 1px solid;">&nbsp;&nbsp;&nbsp; </span> &nbsp;&nbsp; হাঁ &nbsp;&nbsp;<span style="height: 10px;width: 10px; border: 1px solid;"> &nbsp; &nbsp; &nbsp;</span>&nbsp;&nbsp;&nbsp;না.........................................<br />
				&nbsp;&nbsp;..........................................................................
			</div>
		</div>

		<div style="inline-box-align: 1px">
			<div style="margin-top: 8px;border:0px solid; float:left; width:385px;">
				<span style="font-family:SutonnyMJ; font-size:12px;"> এ প্রতিষ্ঠানে কি আপনার কোন আত্মীয় চাকুরি করেন ? সম্পর্কসহ তার নাম ও পদবী উল্লেখ করুন । </span> 
		    </div>
			<div style="margin-top: 8px;border:1px solid; float:left; width:300px;">
				<br/>
				<br/>
			</div>
		</div>    
	</div>
<br /><br />

	<div style="margin-top: 8px;border:0px solid; float:left; width:685px;">
		<span style="font-size:12px;"> জরুরি পরিস্থিতি বা অবস্থায় কার সঙ্গে যোগাযোগ করা প্রয়োজন ?<br />
		নাম :&nbsp;&nbsp;<?= $row->emp_ins;?>&nbsp;&nbsp; সর্ম্পক :&nbsp;&nbsp;<?= $row->emp_skill;?><br />
		ঠিকানা : <?= $row->emp_yr_skill;?>    <br />   
		<!--ফোন : &nbsp; &nbsp;.............................. </span> -->
	</div>

	<div style="margin-top: 8px;border:1px solid; float:left; width:685px;">
		<span style="font-family:SutonnyMJ; font-size:12px;">	<p style="text-align-last: center; margin: 0; padding: 0;"><b>ঘোষনা</b> </p> 
		আমি&nbsp; <?php echo $row->bangla_nam; ?>&nbsp;এই মর্মে ঘোষনা করিতেছি যে,<br />
		১.	আমার জানা ও বিশ্বাসমতে এই আবেদন পএে প্রদও তথ্যসমূহ এবং আমি জ্ঞানত কোন তথ্য গোপন করি নাই ।<br />
		২.	উপরে প্রদও আমার কোন তথ্য ভবিষ্যতে যদি মিথ্যা বলিয়া প্রমানিত হয় তবে আমি অসদাচারণের  অভিযোগে অভিযুক্ত বলিয়া পরিগনিত হইবে ।<br />
		৩.	আমি এই প্রতিষ্ঠানের চাকুরীর জন্য নির্বাচিত হইলে প্রতিষ্ঠানের সকল নিয়ম কানুন মানিয়া চলিব ।<br />
		<br />
		&nbsp; &nbsp; তারিখ ..................................&nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp; &nbsp; &nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;আবেদনকারীর স্বাক্ষর 
		 </span> 
	 </div>
	</div>
	<br>
	<div style="page-break-after: always;"></div>

<?php } ?>
</body>
</html>