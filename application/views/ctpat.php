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
	#nav_inner {
		text-align: center;
		width:490px;
		height:30px;
		font-size:20px;
		font-weight:bold;
		padding-top:5px;
		border:1px solid #333333;
		border-collapse:collapse;
		border-radius:18px;
		-moz-border-radius:18px;
		-webkit-border-radius:18px;
		background-color:#999999;
	}
</style> 
</head>
		   
<body style="font-family:SolaimanLipi; margin: 0px; padding: 0px;">
	<?php  foreach($values->result() as $row){ ?>
	<div id="wrapper" style="margin:0px auto; width: 700px;">
	<div style="width: 800px; font-size: 10px; overflow: hidden;">
        <div class="header-top">
    		<table style="width:700px">
    			<tr>
		       <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
		       <td width="105" style="vertical-align: top;"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_information("company_logo"); ?>" />
		        </td>
		        <td style="font-size:15px;text-align:center">
		        		<span style="font-size: 25px;text-transform: uppercase;"><?php echo $company_logo = $this->common_model->company_information("company_name_bangla"); ?></span>
		        		<br>
		        		<span style="font-size:16px; font-weight:bold;">
		        	<?php echo $company_logo = $this->common_model->company_information("company_add_bangla"); ?></span>
		        </td>

			  </tr>
			</table>
    	</div>
    	<div align="center" style="width:900px; border-bottom:3px solid #000;"></div>
		<div  id="nav" align="center" >
			<div id="nav_inner">
				CTPAT সম্পর্কে শ্রমিক-কর্মচারীদের জানা ও করনীয় বিষয় সমূহ 
			</div>
		</div>
        <div style="clear:both;"></div>
		<div style="border:0px solid; line-height:20px; font-size:13px;">
			<table width="100%">
				<tr>
					<td width="40px">নাম</td>
					<td width="7">:</td>
					<td align="left"><?php echo $row->bangla_nam; ?></td>
				</tr>
				<tr>
					<td>কার্ড নং</td>
					<td>:</td>
					<td style="font-family:sutonnymj;"><?php echo $row->emp_id; ?></td>
				</tr>
				<tr>
					<td>সেকশন</td>
					<td>:</td>
					<td><?php echo $row->sec_name; ?></td>
				</tr>
			</table>
			<div style="clear:both;height: 30px;"></div>
			<div class="subject" style="border-bottom:1px solid;width: 50px;font-size: 14px;font-weight: bold;">বিষয়সমূহ</div>

			<div style="clear:both;height: 15px;"></div>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:160px;font-size: 14px;font-weight: bold;">সিটিপ্যাটের প্রাথমিক ধারণা</div>
			<ul>
				<li>#সিটি প্যাট কি?</li>
				<li>#সিটি প্যাট কেন প্রয়োজন?</li>
				<li>#সিটি প্যাটে কি কি বিষয়ের উপর গুরুত্ব আরোপ করা হয়?</li>
				<li>#সিটি প্যাটের নিয়মনীতি না মানলে কি অসুবিধা?</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:120px;font-size: 14px;font-weight: bold;">কার্যক্ষেত্রে কন্সপিরেসী</div>
			<ul>
				<li>#কন্সপিরেসী কি?</li>
				<li>#কোন কোন বিষয়গুলি কন্সপিরেসীর অন্তভুক্ত?</li>
				<li>#কন্সপিরেসী পরিনতি বা ক্ষতিকারক দিকগুলি কি কি?</li>
				<li>#কন্সপিরেসী প্রতিরোধে কি কি পদক্ষেপ নিতে হবে?</li>
				<li>#কন্সপিরেসী প্রতিরোধ ও মোকাবিলায় কর্মীদের করনীয়।</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:120px;font-size: 14px;font-weight: bold;">প্রোডাক্ট ইন্টিগ্রিটি</div>
			<ul>
				<li>#প্রোডাক্ট ইন্টিগ্রিটি বলতে কি বুঝি?</li>
				<li>#এর প্রয়োজনীয়তা বা গুরুত্ব কি?</li>
				<li>#এর ব্যর্থতায় কি সমস্যা হতে পারে?</li>
				<li>#প্রোডাক্ট ইন্টিগ্রিটির ক্ষেত্রে কর্মীদের  করনীয়।</li>
				<li>#ক্ষতিকারক বস্তু বা ডিভাইস</li>
				<li>#কোন কোন বস্তু বা ডিভাইসগুলি কোম্পানীর জন্য ক্ষতিকর?</li>
				<li>#এ সকল বস্তু চিহ্নিতকরনে কি কি পদক্ষেপ নেয়া উচিত?</li>
				<li>#এ বিষয়ে কর্মীদের কি করনীয়?</li>
				<li>#আইডি কার্ড সংরক্ষণ কেন গুরুত্বপূর্ণ?</li>
				<li>#আইডি কার্ডের যথেচ্ছা ব্যবহারে কি কি ক্ষতি হতে পারে?</li>
				<li>#আইডি কার্ড সংরক্ষণ ও ব্যবহারে কি কি সতর্কতা অবলম্বন করতে হবে?</li>
				<li>#আইডি কার্ড হারিয়ে গেলে/চুরি হলে/ছিনতাই হলে কি কি করতে হবে?</li>
				<li>#চুরি সংক্রান্ত সতর্কতা</li>
				<li>#কি কি উপায়ে ফ্যাক্টরীতে চুরি হতে পারে?</li>
				<li>#চুরি প্রতিরোধে কর্মীদের করণীয় বিষয়বস্তু</li>
				<li>#বাহ্যিক দাঙ্গাকারী কর্তৃক হুমকি</li>
				<li>#কি কি কারনে এই হুমকি হতে পারে?</li>
				<li>#এ ধরনের হুমকি হলে কি করবেন এবং কাকে কিভাবে অবহিত করবেন?</li>
				<li>#এ ধরনের হুমকি মোকাবেলায় কর্মীদের করনীয় কি?</li>
				<li>#অফিসিয়াল রেকর্ড ও তথ্য</li>
				<li>#কি কি তথ্য বা কাগজ অফিসিয়াল রেকর্ড হিসাবে বিবেচিত?</li>
				<li>#কোথায় কিভাবে এগুলি সংরক্ষণ করবেন?</li>
				<li>#এগুলি সংরক্ষণ এত গুরুত্বপূর্ণ কেন?</li>
				<li>#দূর্ঘটনাবশত: কোন কাগজ হারিয়ে গেলে বা খোয়া গেলে কি করবেন?</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:100px;font-size: 14px;font-weight: bold;">বাহ্যিক হুমকি</div>
			<ul>
				<li>#কি কি কারণে এ হুমকি হতে পারে?</li>
				<li>#বাহ্যিক হুমকি হলে কি করবেন এবং কাকে কিভাবে তা অবহিত করবেন?</li>
				<li>#বাহ্যিক হুমকি মোকাবেলায় কর্মীদের করনীয় কি?</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:160px;font-size: 14px;font-weight: bold;">টেমপার্ট গুডস বলতে কি বুঝি?</div>
			<ul>
				<li>#টেমপার্ট গুডস এর বিষয়টি কিভাবে অবহিত করবেন?</li>
				<li>#ফ্যাক্টরীর ভিতর অপরিচিত ব্যক্তির ক্ষেত্রে আপনার করনীয় কি?</li>
				<li>#অপরিচিত ব্যক্তি কারা?</li>
				<li>#তাদের চিহ্নিত করার উপায় কি?</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:220px;font-size: 14px;font-weight: bold;">অপরিচিত ব্যক্তি দেখলে আপনি কি করবেন?</div>
			<ul>
				<li>#গেইটে সিকিউরিটি চেক</li>
				<li>#গেইটে সিকিউরিটি চেকের গুরুত্ব</li>
				<li>#গেইটে সিকিউরিটি চেক না হলে বা ভুল হলে কি কি সমস্যা হতে পারে?</li>
				<li>#গেইটে সিকিউরিটি চেকের ব্যাপারে  কর্মীদের কি করনীয়?</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:140px;font-size: 14px;font-weight: bold;">ফরেন/অপ্রত্যাশিত বস্তু</div>
			<ul>
				<li>#কোন গুলি ফরেন ম্যাটেরিয়াল?</li>
				<li>#এসেম্বলি এরিয়া কি?</li>
				<li>#এসেম্বলি এরিয়াতে ফরেন ম্যাটেরিয়াল থাকলে কি সমস্যা হতে পারে?</li>
				<li>#এসেম্বলি এরিয়াতে ফরেন ম্যাটেরিয়াল চিহ্নিতকরুন এবং অবহিত করনে  কর্মীদের ভূমিকা</li>
			</ul>
			<div class="ctpatpriconcept" style="border-bottom:1px solid;width:140px;font-size: 14px;font-weight: bold;">ফ্যাক্টরী সেনসেটিভ এরিয়া</div>
			<ul>
				<li>#কোনগুলি ফ্যাক্টরী সেনসেটিভ এরিয়া</li>
				<li>#সেনসেটিভ এরিয়ায় প্রবেশাধিকার সংরক্ষনের গুরুত্ব</li>
				<li>#সেনসেটিভ এরিয়াতে প্রবেশাধিকার হলে কি কি সমস্যা হতে পারে?</li>
				<li>#এ ব্যাপারে কর্মীদের করনীয় কি?</li>
			</ul>

			<div class="footer" style="">
				<p>কারখানা কর্তৃপক্ষ আমাকে CTPAT সম্পর্কিত উপরোক্ত বিষয় গুলো প্রশিক্ষণ দিয়েছেন। আমি উপরোক্ত বিষয় গুলো বুঝেছি,জেনেছি ও মেনেছি।</p>
			</div>
			<div style="clear:both;height: 35px;"></div>
			<p>স্বাক্ষর:............................</p>
		</div>
	</div>
	<div style="page-break-after: always;"></div>
	</div>
<?php } ?>
</body>
</html>