<!DOCTYPE html>
<html>
<head>
<title>Job Application</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<!--<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/appointment_letter.css">-->

<style type="text/css">
	span.unit_name{
		border-bottom: 1px dotted;
		font-size:14px;
		width: 160px;
	}
	ul{
		padding-left:0px;
	}
	ul li{
		list-style: none;
	}
</style> 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($values->result() as $row){ ?>
	<div id="wrapper" style="margin:0px auto; width:900px;">
		<div class="topbar">
			<div style=" float: left;">
				<?php $company_logo = $this->common_model->company_information("company_logo");?>
				<img src="<?php echo base_url(); ?>images/<?php echo $company_logo; ?>" />
			</div>
			<span style="text-align:center"><?php $this->load->view("head_english");?></span>
		</div>
		<br>
		<div class="borabor">
			<span>
				বরাবর
			</span>
			<br>
			<span>
				জেনারেল ম্যানেজার
			</span>
			<br>
			<span>প্রশাসন,</span>
			<br>
			<span>
				লুপ ডট ফ্যাশন
			</span>
			<br>
			<span>
				বাসাইল, হাজির বাজার, ভালুকা ময়মনসিংহ।
			</span>
		</div>

        <div style="clear:both;"></div>
		<div style="border:0px solid; line-height:20px; font-size:13px;">
			<div style="clear:both;height: 30px;"></div>
			<div style="; font-size:15px; border:0; width:800px; margin-bottom:30px; font-family:SolaimanLipi;">
				বিষয় : মাতৃত্বকালীন ছুটির জন্য আবেদন।
			</div>
			<div style="; font-size:15px;border:0; width:800px; margin-bottom:18px;font-family:SolaimanLipi;">
				জনাব/জনাবা,
			</div>
			<div style="clear:both;height: 0px;"></div>
			<div style="; font-size:15px; border:0; width:730px; margin-bottom:30px;font-family:SolaimanLipi; text-align:justify;">
				বিনীত নিবেদন এই যে আমি, <span style="font-weight: bolder;"><?php echo $row->bangla_nam; ?></span> কার্ড নং <span style="font-weight: bolder;"><?php echo $row->emp_id; ?></span> পদবী <span style="font-weight: bolder;"><?php echo $row->desig_bangla; ?></span> সেকশন <span style="font-weight: bolder;"><?php echo $row->sec_bangla; ?></span>
				আপনার প্রতিষ্টানের একজন কর্মী। বর্তমানে আমি মাতৃত্ব কল্যাণ আইনের আওতায় থাকার কারণে আমরা ১৬ সপ্তাহ ছুটির বা ১১২ দিনের ছুটির প্রয়োজন। 
			</div>

			<div style="; font-size:15px; border:0; width:730px; margin-bottom:30px;font-family:SolaimanLipi; text-align:justify;">
				অতএব, মহোদয়ের নিকট বিনীত প্রার্থনা এই যে, অনুগ্রহপূর্বক আমাকে উক্ত ১৬ সপ্তাহ বা ১১২ দিনের ছুটি মঞ্জুর করে বাধিত করবেন।
			</div>
			
			<div style="clear:both;height: 35px;"></div>
			<p style="text-align: right;width: 615px;">বিনীত নিবেদকা</p>
			<table width="35%" style="display: inline-block;">
				<tr>
					<td>
						<p>তারিখঃ............................</p>
					</td>
				</tr>
			</table>
			<table width="40%" style="float: right;vertical-align: top;text-align: left;">
				<tr>
					<td width="10px">নাম</td>
					<td>:</td>
					<td>....................</td>
				</tr>
				<tr>
					<td width="10px">কার্ড নং</td>
					<td>:</td>
					<td>................</td>
				</tr>
				<tr>
					<td width="10px">সেকশন</td>
					<td>:</td>
					<td>...................</td>
				</tr>
			</table>
		</div>

    </div>
 <?php } ?>
 </body>
</html>