<!DOCTYPE html>
<html>
<head>
	<title>Join Letter</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/appointment_letter.css">		 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($values as $row){ 
		?>
	<div id="wrapper" style="margin-bottom:180px;height: auto;">
    <div align="center" style="width:700px; border-bottom:3px solid #000;">
    <table width="700" cellpadding="3" style="font-family:SolaimanLipi;">
        <tr>
        <?php $company_logo = $this->common_model->company_info()->company_logo; ?>
        <td width="105"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_info()->company_logo; ?>" /></td>
        <td width="491" style="font-size:15px;text-align:center">
        		<span style="text-align:center"><span style="font-size:18px; font-weight:bold;"><?php echo $company_logo = $this->common_model->company_info()->company_name_bangla; ?></span><br>
        	<?php echo $company_logo = $this->common_model->company_info()->company_add_bangla; ?>
		</span></td>
    </tr>
    </table>
    </div>
		<div id="nav" align="center">
			<div id="nav_inner" style="margin-top: 70px;">
				কাজে যোগদান পত্র 
			</div>
		</div>
        	<div style="float:left; width:400px;">
				বরাবর<br>
				বাবস্থাপনা পরিচালক<br>
				<?php echo $company_logo = $this->common_model->company_info()->company_name_bangla; ?><br>
				<?php echo $company_logo = $this->common_model->company_info()->company_add_bangla; ?><br>
				<br><br>
				বিষয়ঃ- <span style=" font-size:16px;">কাজে যোগদান পত্র।<br><br>
	        </div>
		<div id="nav_bottom" style="line-height:20px; font-size:16px;">
			মহোদয়,<br>
		আপনার <span style=" font-family:SutonnyMJ; font-size:16px;"><?php echo date('d/m/Y',strtotime($row['emp_join_date'])); ?></span> ইং তারিখের পত্র, সূত্র নং ............................. এর প্রেক্ষিতে আমি আপনার কারখানার অদ্য <span style=" font-family:SutonnyMJ; font-size:16px;"><?php echo date('d/m/Y',strtotime($row['emp_join_date'])); ?></span>ইং তারিখ হতে <?php echo $row['desig_bangla']; ?> পদে শর্ত মেনে যোগদান করছি।  <br>
		<br>
		অতএব, মহোদয় আমাকে কাজে যোগদানের অনুমতি দানে বাধিত করবেন।
		<br><br><br><br><br>
				
		<div>বিণীত নিবেদক<br><br>
		আপনার বিশ্বস্ত<br><br>
		স্বাক্ষর: ....................<br><br>
		পূর্ণনামঃ <?php echo $row['bangla_nam']; ?><br><br>
		তারিখঃ <span style=" font-family:SutonnyMJ; font-size:16px;"><?php echo date('d/m/Y',strtotime($row['emp_join_date'])); ?></span><br><br>
		</div>
			<?php $this->load->view("joining_condition_list");?>
		</div> 
</div>
<?php } ?>
</body>
</html>