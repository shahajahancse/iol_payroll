<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AckKnowledgement Letter</title>
<link rel="stylesheet" type="text/css" href="../../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	.container{
		height: 1200px;
		width: 800px;
		margin: 0 auto;
	}
	.title{
		width: 800px;
		margin: 10px auto 30px;
		padding: 10px;
		text-transform: uppercase;
		border: 0px solid #000;
		text-align: center;
		font-size: 18px;
		font-weight: bolder;
	}
	.heading{
		width: 300px;
		padding: 10px;
		margin-top: 30px;
		text-transform: uppercase;
		border: 0px solid #000;
		text-align: left;
		font-size: 18px;
		font-weight: bolder;
	}
	table.salary_structure{
		border:1px solid #000;
		border-collapse: collapse;
		width: 100%;
		text-align: center;
		margin-top:30px;
	}

	table.salary_structure tr,table.salary_structure tr th,table.salary_structure tr td{
		border:1px solid #000;
		border-collapse: collapse;
	}

	.service_benefit{
		width: 100px;
		margin: 30px auto 0;
		padding: 8px;
		text-transform: uppercase;
		border-bottom: 1px solid #000;
		text-align: center;
		font-size: 18px;
		font-weight: bolder;
	}

	table.year_structure{
		border:1px solid #000;
		border-collapse: collapse;
		width: 100%;
		text-align: center;
		margin-top:30px;
	}

	table.year_structure tr,table.year_structure tr th,table.year_structure tr td{
		border:1px solid #000;
		border-collapse: collapse;
	}

	table.earn_leave{
		border:1px solid #000;
		border-collapse: collapse;
		width: 100%;
		text-align: center;
		margin-top:30px;
	}

	table.earn_leave tr,table.earn_leave tr th,table.earn_leave tr td{
		border:1px solid #000;
		border-collapse: collapse;
	}
	p{
		margin:4px;
	}

</style>
</head>
<body>
<?php
		
foreach ($value->result() as $row)
	{ ?>

<div class="container">
<table style="text-align: center;width: 800px">
	<tr>
		<td style="width: 50px;">
			   <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
				<img width="55px" height="55px" src="<?php echo base_url(); ?>images/<?php echo $company_logo;?>">
			</td>
		<td style="font-size: 25px;"><?php $this->load->view("head_english"); ?></td>
	 </tr>
</table>
<div align="center" style="width:800px; border-bottom:3px solid #000;margin-bottom:15px;"></div>
<div class="title">!! প্রাপ্তি স্বীকার পত্র !!</div>

<p style="text-align: right;margin:35px;">তারিখঃ .............</p>

<p style="line-height: 30px;font-size: 18px;">আমি <strong><?php echo $row->bangla_nam;?></strong>,কার্ড নং <strong><?php echo $row->emp_id;?></strong>,পদবী <strong><?php echo $row->desig_bangla;?></strong>,এই মর্মে জানাচ্ছি যে, চাকুরী অবসানকালে আমার সার্ভিসবুকটি বুঝিয়া পাইলাম, যার নম্বর.........................................।</p>


<p style="text-align: right;margin:30px 0px;"><span style="border-top:1px dotted #000;width:100px;">স্বাক্ষর</span></p>

<div class="title">!! প্রাপ্তি স্বীকার পত্র !!</div>

<p style="text-align: right;margin:35px;">তারিখঃ .............</p>

<p style="line-height: 30px;font-size: 18px;">আমি <strong><?php echo $row->bangla_nam;?></strong>,কার্ড নং <strong><?php echo $row->emp_id;?></strong>,পদবী <strong><?php echo $row->desig_bangla;?></strong>,এই মর্মে জানাচ্ছি যে, চাকুরী অবসানকালে আমার সার্ভিসবুকটি বুঝিয়া পাইলাম, যার নম্বর.........................................।</p>


<p style="text-align: right;margin:30px 0px;"><span style="border-top:1px dotted #000;width:100px;">স্বাক্ষর</span></p>


	<div align="center" style="width:800px; border-bottom:3px solid #000;margin-bottom:15px;"></div>
	<div class="footer">
		<p style="text-align: center;text-transform: uppercase;font-weight: bolder;">A Member of Creative Group</p>
		<p style="text-align: center;">Head Office: House No.25(4th floor),Rabindra Swarani, Sector No.3, Uttara, Dhaka-1230.Bangladesh.</p>
		<p style="text-align: center;">Tel:8802-8957870,8958783,8958805, Fax:880-2-8957987, E-mail: info@creativegroupbd.net</p>
		<p style="text-align: center;">Web: www.creativegroupbd.net</p>
	</div>
  
 </div>

 <?php } ?>

</body>
</html>