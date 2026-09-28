<?php error_reporting(0);?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
 h1,h2,h3,h4,h5,h6{
 	margin: 0;
 	padding: 0;
 font-weight: normal;
 }

 .colon{
    display: inline;
    margin-right:5px;
    font-weight: bolder;
  }
  .border_div{
    border-bottom: 1px dotted #000;
    display: inline;
  }

  .details table{
  border-collapse: collapse;
  width: 700px;
  font-size: 14px;
}
.details table tr,.details table tr td,.details table tr th{
 border: 1px solid #dddddd;
}

</style>
</head>
<body>

<?php 
//print_r($data);
foreach($value as $row)
			{

	  $emp_add_par = explode(';',$row->emp_par_add_ban);
      $vill = $emp_add_par[0];
      $post = $emp_add_par[1];
      $thana = $emp_add_par[2];
      $dist = $emp_add_par[3];

?>
	
<div style="height:auto; width:710px; padding:25px; border:1px solid;margin:0 auto;">
	<div align="center" style="width:700px; border-bottom:3px solid #000;">
    <table width="700" cellpadding="3" style="font-family:SolaimanLipi;">
        <tr>
        <?php $company_logo = $this->common_model->company_info()->company_logo; ?>
        <td width="105"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_info()->company_logo; ?>" /></td>
        <td width="491" style="font-size:15px;text-align:center;padding-right: 109px;">
        		<span style="text-align:center"><span style="font-size:18px; font-weight:bold;"><?php echo $company_logo = $this->common_model->company_info()->company_name_bangla; ?></span><br>
        	<?php echo $company_logo = $this->common_model->company_info()->company_add_bangla; ?>
		</span></td>
    </tr>
    </table>
    </div>

	<table width="700px" cellpadding="3" style="text-align: center;">
	    <tr>
	    	<td>[দ্বারা ১৯,১৩১(১)(ক), ১৫৫(২),২৩৪,২৬৫, ও ২৭৩ এবং বিধি ১১৮(১),১৩৬,২৩২(২),২৬২(১),২৮৯(১) ও ৩২১(১) দ্রষ্টব্য]</td>
	    </tr>
	</table>
	<table width="700px" cellpadding="3" style="text-align: center;border:0px solid #000;">
	    <tr>
	    	<td><h3 style="width:488px;font-weight: bold;border-bottom:1px solid #000;;margin:0 auto;">জমা ও বিভিন্নখাতে প্রাপ্য অর্থ পরিশোধের ঘোষনা ও মনোনয়নের ফরম</h3></td>
	    </tr>
	</table>

	<!-- <table width="700px" cellpadding="3" style="text-align: center;line-height: 10px;margin-top:5px;">
	    <tr>
	    	<td><h3><?php echo $company_add_english = $this->common_model->company_information("company_name_bangla");?></h3></td>
	    </tr>
	    <tr>
	    	<td><h5><?php echo $company_add_english = $this->common_model->company_information("company_add_bangla");?></h5></td>
	    </tr>
	</table> -->

	<table style="width: 700px;margin: 0 auto">
		<tr style="">
			<td style="width: 40px;"><li></li></td>
      		<td width=150px>নাম </td>
      		<td><span class="colon">:</span><div class="border_div"><?php echo $row->bangla_nam;?></div></td>
    	</tr>
    	<tr style="">
			<td style="width: 40px;"><li></li></td>
      		<td width=150px>পিতা/স্বামী/ স্ত্রীর নাম</td>
      		<td><span class="colon">:</span><div class="border_div"><?php echo $row->emp_fname_bn;?></div></td>
    	</tr>
    	<tr style="">
			<td style="width: 40px;"><li></li></td>
      		<td width=150px>সনাক্তকরণ চিহ্ন</td>
      		<td><span class="colon">:</span><div class="border_div"><?php echo " "?></div></td>
    	</tr>
    	<tr style="">
			<td style="width: 40px;"><li></li></td>
      		<td width=150px>ঠিকানা </td>
      		<td><span class="colon">:</span><div class="border_div"><?php echo $vill; ?></div></td>
    	</tr>
	</table>
	<div style="height: 100px;"></div>
	<div class="center_text" style="text-align: center;font-size: 15px;">
		<p>আমি এতদদ্বারা ঘোষনা করিতেছি যে, আমার মৃত্যু হইলে বা আমার অবর্তমানে, আমার অনুকুলে জমা ও বিভিন্নখাতে প্রাপ্য টাকা গ্রহনের জন্য আমি নিম্নবর্ণিত ব্যাক্তিকে/ব্যক্তিগণ কে দান করিতেছি এবং নির্দেশ দিচ্ছি যে, উক্ত টাকা নিম্নবর্ণিত পদ্ধতিতে মনোনীত ব্যক্তিদের মধ্যে বন্টন করিতে হইবে।</p>
	</div>
	<div class="details">
		<table width=720px cellpadding="3" style="font-family:SutonnyMJ;font-size: 14px;text-align: center;">
			<tr>
				<td>মনোনীত ব্যক্তি বা ব্যক্তিদের নাম, ঠিকানা ও ছবি (নমিনির ছবি ও স্বাক্ষর শ্রমিক কতৃক সত্যায়িত) এন আই ডি নং</td>
				<td>সদস্যদের সহিত মনোনীত ব্যক্তিদের সম্পর্ক</td>
				<td width="50px">বয়স</td>
				<td width="350px" colspan="2">প্রত্যেক মনোনীত ব্যক্তিকে দেয়  অংশ</td>
				<!-- <td rowspan="9" colspan="1" width="85px;"></td> -->
				<td width="80px">নমিনির ছবি </td>
			</tr>
			<tr>
				<td>(১)</td>
				<td>(২)</td>
				<td>(৩)</td>
				<td colspan="2">(৪)</td>
				<td rowspan="8"></td>
			</tr>
			<tr>
				<td rowspan="7" style="text-align: left;font-family:Arial, Helvetica, sans-serif;">
				নাম: &nbsp;&nbsp;&nbsp;<b><?php echo $row->emp_ins; ?></b><br>
				<!--এন আইডি নং:<b><?php echo $row->emp_id; ?></b><br>
				ঠিকানা:
				</b>-->
				</td>
				<td></td>
				<td></td>
				<td style="font-weight: bolder;">জমাখাত</td>
				<td width="70px" style="font-weight: bolder;">অংশ</td>
				<!-- <td rowspan="7"></td> -->
			</tr>
			<tr>
				<!-- <td style="text-align: left;">এন আইডি নং:</td> -->
				<td></td>
				<td></td>
				<td>বকেয়া মজুরি</td>
				<td></td>
				<!-- <td></td> -->
				
			</tr>
			<tr>
				<!-- <td style="text-align: left;">ঠিকানা:</td> -->
				<td></td>
				<td></td>
				<td>প্রভিডেন্ট ফান্ড</td>
				<td></td>
				<!-- <td></td> -->
				
			</tr>
			<tr>
				<!-- <td></td> -->
				<td><?php echo $row->emp_skill; ?></td>
				<td></td>
				<td>বীমা</td>
				<td></td>
				<!-- <td></td> -->
				
			</tr>
			<tr>
				<!-- <td></td> -->
				<td></td>
				<td></td>
				<td>দুর্ঘটনায় ক্ষতিপুরণ</td>
				<td></td>
				<!-- <td></td> -->
				
			</tr>
			<tr>
				<!-- <td></td> -->
				<td></td>
				<td></td>
				<td>লভ্যাংশ</td>
				<td></td>
				<!-- <td></td> -->
				
			</tr>
			<tr>
				<!-- <td></td> -->
				<td></td>
				<td></td>
				<td>অন্যান্য</td>
				<td></td>
				<!-- <td></td> -->
				
			</tr>
		</table>
	</div>
	<div style="clear:both;width: 100%;height: 20px;"></div>
	<div class="bottom_top" style="font-size: 13px">
		<p>প্রত্যয়ন করিতেছি যে, আমার উপস্থিতিতে  জনাব..............................................লিপিবদ্ধ বিবরনসমূহ পাঠ করিবার পর উক্ত ঘোষণা স্বাক্ষর করিয়াছেন।</p>
	</div>
	<div style="clear:both;width: 100%;height: 50px;"></div>
	<table>
		<tr>
			<td style="width: 50%">
				<h4>তারিখসহ মনোনীত  ব্যাক্তিগণের</h4>
				<h4>স্বাক্ষর অথবা টিপসহি	</h4>
				<h4>(শ্রমিক কতৃক সত্যায়িত ছবি</h4>
			</td>
			<td style="width: 50%">
				<p>মনোনয়ন প্রদানকারী শ্রমিকের স্বাক্ষর, টিপসহি ও তারিখ........................................</p>
			</td>
		</tr>
	</table>

	<div style="float: right;width: 180px;">কতৃপক্ষের স্বাক্ষর ......................</div>
  
  <div style="clear:both;width: 100%;height: 20px;"></div>	          
</div>
 <div style="clear:both;width: 100%;height: 50px;"></div>		
	
	
	<?php }
?>
</body>
</html>