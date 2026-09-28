<!DOCTYPE html>
<html>
<head>
	<title>Join Letter</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/appointment_letter.css">
	<style type="text/css">
		table td{
			margin:5px;
		}
	</style> 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($value as $row){ 
		?>
	<div id="wrapper" style="margin-bottom:180px; width:700px; min-height:600px;">
    <table width="800" cellpadding="3" style="font-family:SolaimanLipi;">
        <tr>
        <?php $company_logo = $this->common_model->company_info()->company_logo; ?>
        <td width="105"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_info()->company_logo; ?>" /></td>
        <td width="491" style="font-size:15px;">
        		<span style="font-size:18px; font-weight:bold;margin-left: 114px;"><?php echo $company_logo = $this->common_model->company_info()->company_name_bangla; ?></span><br>
        	<span style="margin-left: 114px;"><?php echo $company_logo = $this->common_model->company_info()->company_add_bangla; ?></span>
		</td>
    </tr>
    </table>
    <div align="center" style="width:700px; border-bottom:3px solid #000;"></div>
	<div class="header">
		<div class="header-top" style="width: 217px;margin:0 auto 15px;border-bottom:1px solid #000;text-align: center;font-size: 20px">বয়স ও সক্ষমতার প্রত্যয়ন পত্র</div>
		<div class="header-middle" style="width: 70px;margin: 0 auto 15px;border-bottom:1px solid #000;text-align: center;font-size: 19px">ফরম-১৫</div>
		<div class="header-bottom" style="width: 700px;margin: 0 auto 15px;text-align: center;font-size: 19px">[ধারা ৩৪,৩৬,৩৭ও ২৭৭ এবং বিধি৩৪(১) ও ৩৩৬(৪) দ্রষ্টব্য ]</div>
    </div>
	<table style="width: 700px;margin:0 auto;vertical-align: top">
		<tr>
			<?php
	      		$this->load->helper('date');
	 	        $today = date('Y-m-d');
		        $birthdate = date('Y-m-d',strtotime($row->emp_dob));
		        $diff = $today - $birthdate;
          	 ?>
			<td style="width: 350px;vertical-align: top;">
				<table>
					<tr><th style="text-align: left;background: gray;">বয়স ও সক্ষমতার প্রত্যয়ন পত্র</th></tr>
					<tr><td style="font-family:sutonnymj; ">১। আইডি নংঃ <?php echo $row->emp_id;?></td></tr>
					<tr><td>২। নামঃ <?php echo $row->bangla_nam;?></td></tr>
					<tr><td>৩। পিতার নামঃ <?php echo $row->emp_fname;?></td></tr>
					<tr><td>৪। মাতার নামঃ <?php echo $row->emp_mname;?></td></tr>
					<tr><td>৫। লিঙ্গঃ 
					<?php if($row->emp_sex==1){
			           	echo "পুরুষ";
			           }else{
			           	echo "মহিলা";
			           }?>
           			</td></tr>
					<tr><td>৬। স্থায়ী ঠিকানাঃ <?php echo $row->emp_par_add;?></td></tr>
					<tr><td>৭। অস্থায়ী ঠিকানাঃ <?php echo $row->emp_pre_add;?></td></tr>
					<tr><td style="font-family:sutonnymj; ">৮। জন্ম তারিখঃ <?php echo $dob = date('d-m-Y',strtotime($row->emp_dob));?></td></tr>
					<tr><td>৯। বাহ্যিক সক্ষমতাঃ</td></tr>
					<tr><td>১০। সনাক্তকরন চিহ্নঃ</td></tr>
				</table>
			</td>
			<td style="vertical-align: top;">
				<table style="width: 350px;">
					<tr><th style="text-align: left;background: gray;">বয়স ও সক্ষমতার প্রত্যয়ন পত্র</th></tr>
					<tr><td style="font-family:sutonnymj; ">তারিখঃ <?php echo $doj = date('d-m-Y',strtotime($row->emp_join_date));?></td></tr>
					<tr><td>আমি এই মর্মে প্রত্যয়ন করিতেছে যে নামঃ <?php echo $row->bangla_nam;?></td></tr>
					<tr><td>পিতার নামঃ <?php echo $row->emp_fname;?></td></tr>
					<tr><td>মাতার নামঃ <?php echo $row->emp_mname;?></td></tr>
					<tr><td>ঠিকানাঃ <?php echo $row->emp_par_add;?></td></tr>
					<tr><td>কে আমি পরীক্ষা করিয়াছি।</td></tr>
					<tr><td>তিনি প্রতিষ্ঠানে নিযুক্ত হইতে ইচ্ছুক এবং আমার পরীক্ষা হইতে এইরুপ পাওয়া গিয়াছে যে তাহার বয়স <span style="color:green;font-weight: bolder;"><?php echo $diff;?></span> বৎসর এবং তিনি প্রতিষ্ঠানে প্রাপ্ত বয়স্ক/কিশোর হিসাবে নিযুক্ত হইবার যোগ্য

					</td></tr>
					<tr><td>তাহার সনাক্তকরনের চিহ্নঃ</td></tr>
					<tr><td></td></tr>
					<tr><td></td></tr>
				</table>
			</td>
		</tr>
	</table>
	<div class="footer" style="margin-top:80px;">
		<div class="f_left" style="float:left;width: 144px;border-top:1px solid #000;padding:5px;">সংশ্লিষ্ঠ ব্যক্তির স্বাক্ষর/টিপসহি</div>
		<div class="r_left" style="float:right;width: 139px;border-top:1px solid #000;padding:5px;">রেজিস্টার্ড চিকিৎসকের স্বাক্ষর</div>
    </div>
</div>
<?php } ?>
</body>
</html>