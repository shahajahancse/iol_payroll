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
      

</style>		 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($value as $row){ ?>
	<div id="wrapper">
		<div align="center" id="header">
			 <!-- <b style="font-size: 18px">কিমবার্লী  ডিজাইন </b>
			 <br>
			 বাসাইল, হাজির বাজার, ভালুকা, ময়মনসিংহ  -->
			 <?php $this->load->view("head_english"); ?>
		</div>
		<div  id="nav" align="center" >
			<div style="width: 390px;" id="nav_inner">
				শ্রমিক,কর্মচারীর পশ্চাৎ/চাকুরী যাচাই প্রতিবেদন রিপোর্ট 
			</div>
		</div>
		<div id="nav_bottom" style="line-height:20px; font-size:13px;">
        
			<br>
			<b>যাচাইকৃত ব্যক্তির নাম :</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $row->bangla_nam;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>পদবী :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $row->desig_bangla;?> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b> সেকশন :</b> 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<?php echo $row->sec_bangla;?>
 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>কার্ড নং : </b><span style="font-family: SutonnyMJ"><?= $row->proxi_id;?></span><br /><b> যোগদানের তারিখ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-family: SutonnyMJ"><?= $row->emp_join_date;?> </span> </b><br />
</div> <br/><br/>
<table >
	<tr >
		<th >যাচাইকৃত ব্যক্তির বর্তমান ঠিকানা</th>
		
		<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

		<th >যাচাইকৃত ব্যক্তির স্থায়ী  ঠিকানা</th>
	</tr>
	<tr>
		<td>প্রযত্নেঃ</td>
		<td></td>
		<td>প্রযত্নেঃ</td>
	</tr>
	<tr >
		<td> ঠিকানা: &nbsp;<?= $row->emp_pre_add_ban;?></td>.
		<td></td>
		<td> ঠিকানা: &nbsp;<?= $row->emp_par_add_ban;?></td>
	</tr>
	<tr >
		<td style="font-family: SutonnyMJ">ফোন নং:&nbsp;<?= $row->emp_pass_yr;?> </td>	
		<td></td>
		<td style="font-family: SutonnyMJ">ফোন নং: &nbsp;<?= $row->emp_pass_yr;?></td>		
	</tr>
	
</table>
<br />
<div style="line-height:19px; font-size:16px;"><br />
<u style="font-size:18px;"><b>সুপারিশকারী (কিমবার্লী গ্রুপে যদি কেউ থাকে):</b></u><br /><br />
নাম : .................... &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	পদবী : ....................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	আই ডি  নং : ....................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	সেকশন :....................

<br /><br />

গত....................তারিখে অএ প্রতিষ্ঠানে যোগদান করে । উক্ত ব্যক্তির পূর্বোক্ত চাকুরীর সত্যতা যাচাইয়ের লক্ষ্যে 
গত.................... তারিখে আমার নিম্ন স্বাক্ষরকৃত ব্যক্তিগন তার প্রদেয় বর্তমান ঠিকানা / স্থায়ী ঠিকানা / পূবের প্রতিষ্ঠনে, স্বশরীওে উপস্থিত হয়ে / টেলিফোনের মাধ্যমে / সুপারিশকারীর মাধ্যমে / চিঠির মাধ্যমে / অন্যান্য জমাকৃত সার্টিফিকেট যাচাইয়ের মাধ্যমে প্রয়োজনীয় তথ্য সংগহ করি । <br />
প্রাপ্ত তথ্য বিবেচনায়/যাচাইকৃত ব্যক্তির সকল ধরনের তথ্য সঠিক বলে প্রতীয়মান / প্রমানিত হয়েছে । 
	
<br /><br />

<u style="font-size:18px;"><b>যাচইকৃত ব্যক্তিবর্গেও বিবরণ:</b></u><br /><br />
১. নাম : ....................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	পদবী : ....................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	স্বাক্ষর: ....................<br />
২. নাম : ....................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	পদবী : ....................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	স্বাক্ষর: ....................	<br />

	<br />
<table>

<tr style="width: 100px">
<td width="10"></td>

<td width="300">তারিখ :....................</td><td width="200">&nbsp;</td><td width="200"> কর্তৃপক্ষের স্বাক্ষর: ....................</td></tr>


</table>
</div>
</div>
<?php } ?>
</body>
</html>