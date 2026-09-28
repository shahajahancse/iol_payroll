<!DOCTYPE html>
<html>
<head>
	<title>Verification Report</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style>
	#wrapper {
          margin:0 auto;		  
		  width:700px;
		  overflow:hidden;
  		  margin-bottom:225px;
  		  font-size: 18px;
  		  
		 }
#header {
          width:700px;
		  height:42px;
		  background-color: #CCCCCC;

        } 
#h_left {
         width:500px;
		 height:auto;
		 float:left;
		 }
#h_right {
         width:200px;
		 height:auto;
		 float:right;
		 }
#nav {
         float:left;
		 width:700px;
		 height:auto;
		 padding:10px;
     }
#nav_inner {
         width:190px;
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
#nav_bottom {
         float:left;
         width:700px;
		 height:auto;
		 text-align:justify;
		 } 
.body {
         float:left;
         width:700px;
		 height:auto;
		 text-align:justify;
		}
#body_inner_left {
         float:left;
		 width:200px;
		 height:auto;
		 text-align:left;
		 } 
#body_inner_center {
         float:left;
		 width:100px;
		 height:auto;
		 }
#body_inner_right {
         float:left;
		 width:200px;
		 height:auto;
		 text-align:left;
		 } 
#body_inner_left_ep {
         float:left;
		 width:200px;
		 height:auto;
		 text-align:right;
		 } 
#break { 
         float:left;
		 width:700px;
		 height:auto;
       } 
#footer {
         float:left;
		 width:700px;
		 height:auto;
		 background:red;   
         }  
#footer_left {
         float:left;
		 width:300px;
		 height:auto;   
         } 
#footer_right {
         float:right;
		 width:300px;
		 height:auto;   
         }       
      .header_top{
			width: 300px;
			margin:0 auto 15px;
			border-bottom:1px solid #000;
			text-align: center;
			font-size: 20px
		}
		.information_heading{
			font-size:18px;
			font-weight: bold; 
		}
		#information_detail{
			line-height:14px;
			font-size:16px;
			margin-left: 15px;
		}
		table.check_table{
			border-collapse: collapse;
		}

		 table.check_table tr,table.check_table td,table.check_table th{
			border:1px solid #000;
		}

</style>		 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($value as $row){ ?>
	<div id="wrapper">
		<div class="header-top">
    		<table style="width:700px">
    			<tr>
			       <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
			       <td width="105" style="vertical-align: top;"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_information("company_logo"); ?>" />
			        </td>
			        <td style="font-size:15px;padding-left:150px;">
			        		<span style="font-size: 25px;text-transform: uppercase;"><?php echo $company_logo = $this->common_model->company_information("company_name_bangla"); ?></span>
			        		<br>
			        		<span style="text-align:center"><span style="font-size:16px; font-weight:bold;">
			        	<?php echo $company_logo = $this->common_model->company_information("company_add_bangla"); ?></span>
			        </td>
			  	 </tr>
				</table>
    		</div>
    	<div align="center" style="width:700px; border-bottom:3px solid #000;"></div>
		<div  id="nav" align="center" >
			<div style="width: 390px;" id="nav_inner">
				কর্মীদের ব্যক্তিগত তথ্য যাচাই প্রতিবেদন 
			</div>
		</div>
		<p class="information_heading">কর্মস্থলের তথ্যঃ</p>
		<div id="information_detail">
			<p>১. নামঃ <?= $row->bangla_nam;?></p>
			<p>২. পদবীঃ <?= $row->desig_bangla;?> </p>
			<p>৩. সেকশনঃ <?php echo $row->sec_bangla;?></p> 
 			<p style="font-family:sutonnymj;">৪. কার্ড নংঃ <?= $row->proxi_id;?></p>
 			<p>৫. যোগদানের তারিখঃ <span style="font-family: SutonnyMJ"><?php echo $doj = date('d-m-Y',strtotime($row->emp_join_date));?> </span></p>
		</div>
		<p class="information_heading">ব্যত্তিগত তথ্যঃ</p>
		<div id="information_detail">
			<p>১. বাবার নামঃ <?= $row->emp_fname;?></p>
			<p>২. মায়ের নামঃ <?= $row->emp_mname;?> </p>
			<p>৩. মোবাইল নংঃ <?= $row->emp_pass_yr;?></p> 
 			<p>৪. স্বামীর নামঃ <?php //= $row->proxi_id;?></p>
		</div>

		<p class="information_heading">বর্তমান ঠিকানাঃ</p>
		<div id="information_detail">
			<p>ঠিকানাঃ <?= $row->emp_pre_add_ban;?> </p>
			<p>সম্পর্কঃ বাড়ীওয়ালা</p>
		</div>

		<p class="information_heading">স্থায়ী  ঠিকানাঃ</p>
		<div id="information_detail">
			<p>ঠিকানাঃ <?= $row->emp_par_add_ban;?> </p>
			<p>সম্পর্কঃ পিতা</p> 
		</div>
		<p class="information_heading">প্রত্যয়ন প্রদানকারী চেয়ারম্যান/মেম্বার/কাউন্সিলরের নামঃ</p>
		<div id="information_detail">
			<p>মোবাইল নাম্বারঃ</p> 
		</div>

		<table class="check_table">
			<tr>
				<th style="">প্রত্যয়নকারী ব্যক্তির বিবরনী</th>
				<th style="width: 42px;"><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">হ্যাঁ</th>
				<th style="width: 40px;"><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">না</th>
			</tr>
			<tr>
				<td style="">আপনি প্রত্যয়ন পত্র প্রদানকারী সিটি কর্পোরেশন / পৌরসভা/ ইউনিয়নের চেয়ারম্যান/মেম্বার/কাউন্সিলর কিনা?</td>
				<td style="width: 40px;"><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">হ্যাঁ</td>
				<td style="width: 40px;"><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">না</td>
			</tr>
			<tr>
				<td style="">প্রত্যয়নকৃত ব্যক্তিকে আপনি চেনেন কি?</td>
				<td><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">হ্যাঁ</td>
				<td><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">না</td>
			</tr>
			<tr>
				<td style="">প্রত্যয়নকৃত ব্যক্তির পিতা/স্বামীকে আপনি চেনেন কি?</td>
				<td><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">হ্যাঁ</td>
				<td><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">না</td>
			</tr>
			<tr>
				<td style="">প্রত্যয়নকৃত ব্যক্তি কোন রাষ্ট্রবিরোধী কাজে জড়িত কিনা?</td>
				<td><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">হ্যাঁ</td>
				<td><input type="checkbox" style="width: 7px;height: 7px;border:1px solid #000;">না</td>
			</tr>
			<tr>
				<td style="">প্রত্যয়নকৃত ব্যক্তি সম্পর্কে যাচাইকৃত ব্যক্তির মন্তব্যঃ</td>
				<td></td>
				<td></td>
			</tr>
		</table>

		<p style="font-size: 13px;">
			<strong>A sister concern of CREATIVE GROUP</strong><br>
			HEAD OFFICE: House# 25(4th Floor),Rabindra Swarani, Sector#3,Uttara, Dhaka-1230, Bangladesh<br>
			Tel: 880-2-55093870,55093783,48958805,Fax:880-2-48957987, www.creativegroupbd.net

		</p>

	</div>
<?php } ?>
</body>
</html>