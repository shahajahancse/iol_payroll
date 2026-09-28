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
		.wrapper{
			margin:3px auto 0;
			width:1097px; 
			min-height:600px;
			border:2px solid #000;
		}
		.container_1{
			width:985px; 
			min-height:595px;
			border:2px solid #000;
			margin:3px;

		}
		.container_2{
			width:975px; 
			min-height:591px;
			border:2px dotted #000;
			margin:3px;
		}
		.container_3{
			width:945px; 
			min-height:587px;
			border:2px solid #000;
			margin:3px;
			padding:10px;
		}
	</style> 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($value as $row){ 
		?>
	<div style="height: 30px;"></div>
	<div class="wrapper" style="width: 995px;">
		<div class="container_1">
			<div class="container_2">
				<div class="container_3">
					<div class="header">
						<p class="header-top" style="font-size: 18px;margin:20px 0px 0px 60px">From No.-4, Rule 10(2)</p>
						<p class="header-bottom" style="margin:20px 0px 50px 300px"><span style="font-size: 36px;font-family: Old English Text MT;vertical-align: top;">Certificate of Fitness</span><span style="margin-left:200px;"><img style="border:1px dashed black;" src="<?php echo base_url();?>uploads/photo/<?php echo $row->img_source; ?>" height="120" width="110"/></span></p>
					</div>
					<?php
		                $this->load->helper('date');
		                $today = date('Y-m-d');
		                $birthdate = date('Y-m-d',strtotime($row->emp_dob));
		                $diff = $today - $birthdate;
		             ?>
 					<p style="font-size:20px;font-style: italic;">Serial No <strong><?php echo $row->emp_id;?></strong> Token No.....................Date <strong><?php echo $row->emp_join_date;?></strong> I Certify that I Have personally Examined(Name) <strong><?php echo $row->emp_full_name; ?></strong> Son/daughter/wife <strong><?php echo $row->emp_fname;?></strong> Residing at <strong><?php echo $row->emp_par_add;?></strong> </p>
 					<p style="font-size:20px;font-style: italic;">Who is desirous of being employed in apparel factory, that his/her age as can be ascertaned from my examination is <strong><?php echo $diff; ?></strong> years and that he/she is fit for employment in a apparls factory as and adult/children.<br>
 						Hi/Her descriptive marks are.......................
 					</p>
				    <p style="text-align:right;margin:40px 150px 45px 0px;"><span style="border:1px solid #000;padding:3px;">Thumb impression</span></p>
				    <p style="text-align:right;margin:40px 150px 0px 0px;">Certifying Surgeon</p>
			</div>
		</div>
	 </div>
</div>
<div style="page-break-after: always;"></div>
<?php } ?>
</body>
</html>