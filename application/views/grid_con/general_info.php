<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
	<style>
		@media print {
				@page {
					size : A4 landscape;
				}
		}
	</style>
<title>General Employee Report</title>
</head>
<body>
	<div class="container-fluid">
	<!-- < ?php $this->load->view("head_bangla");?> -->
	 <br>
	 <h3 style="text-align: center;" class='unicode-to-bijoy'><?php echo $unit_name_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_name_bangla;?></h3>
<h5 style="text-align: center;" class='unicode-to-bijoy'><?php echo $unit_add_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_add_bangla;?></h5>

<?php
	$user_id = $this->session->userdata('data')->id;
	$acl = check_acl_list($user_id);
?>
	<table align="center" height="auto" border="1" cellspacing="0" cellpadding="2" style="font-size:15px; width:1050px;">
		<th class="text-center unicode-to-bijoy">ক্রমিক নং</th>
		<th class="text-center unicode-to-bijoy">আইডি নং</th>
		<th class="text-center unicode-to-bijoy">নাম</th>
		<th class="text-center unicode-to-bijoy">বিভাগ</th>
		<th class="text-center unicode-to-bijoy">পদবী</th>
		<th class="text-center unicode-to-bijoy">লাইন</th>
		<th class="text-center unicode-to-bijoy">সেকশন</th>
		<th class="text-center unicode-to-bijoy">যোগদানের তারিখ</th>
		<th class="text-center unicode-to-bijoy">গ্রেড</th>
		<th class="text-center unicode-to-bijoy" <?php  if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>মোট বেতন</th>
		<th class="text-center unicode-to-bijoy">বেতন</th>
		<th class="text-center unicode-to-bijoy">এন আইডি/জন্মনিবন্ধন</th>
		<th class="text-center unicode-to-bijoy">জন্ম তারিখ</th>
		<th class="text-center unicode-to-bijoy">পিতার নাম</th>
		<th class="text-center unicode-to-bijoy">মাতার নাম</th>
		<th class="text-center unicode-to-bijoy">স্বামী/স্ত্রীর নাম</th>
		<th class="text-center unicode-to-bijoy">ফোন নং</th>
		<th class="text-center unicode-to-bijoy">বর্তমান ঠিকানা</th>
		<th class="text-center unicode-to-bijoy">স্থায়ী ঠিকানা</th>
		<th class="text-center unicode-to-bijoy">লিঙ্গ</th>
		<th class="text-center unicode-to-bijoy">রক্তের গ্রুপ</th>
		<th class="text-center unicode-to-bijoy" >স্বাক্ষর</th>

		<?php $i= 1;foreach($values as $row){?>
		<tr>
			<td class="text-center unicode-to-bijoy"><?php echo $i++?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->emp_id?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->name_bn?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->dept_bangla?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->desig_bangla?></td>
			<td class="text-center unicode-to-bijoy" style="white-space:nowrap"><?php echo $row->line_name_bn?></td>
			<td class="text-center unicode-to-bijoy">
				<?php
					$sections = array_merge(
						explode(' ', $row->line_name_en),
						explode('-', $row->line_name_en)
					);
					$sections = preg_split('/[ -]/', $row->line_name_en);
					echo $sections[0]=="Line" ? "সুইং" : ($sections[0]=="Cutting" ? "কাটিং" :($sections[0]=="Finishing"? "ফিনিসিং" : $row->line_name_bn));

				?>
			</td>
			<td class="text-center unicode-to-bijoy"><?php echo date('d/m/Y',strtotime($row->emp_join_date))?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->gr_name =='None'? 'প্রযোজ্য নয়':$row->gr_name?></td>
			<td class="text-center unicode-to-bijoy" <?php  if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>><?php echo $row->gross_sal?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->com_gross_sal?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->nid_dob_id?></td>
			<td class="text-center unicode-to-bijoy"><?php echo date('d/m/Y',strtotime($row->emp_dob))?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->father_name?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->mother_name?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->spouse_name?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->personal_mobile?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->pre_village_bn.",".$row->pre_post_name_bn.",".$row->pre_upa_name_bn.",".$row->pre_dis_name_bn?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->per_village_bn.",".$row->per_post_name_bn.",".$row->per_upa_name_bn.",".$row->per_dis_name_bn?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->gender=="Male" ? "cyiæl" : "নারী"?></td>
			<td class="text-center "><?php echo $row->blood == 'None'?'-' : $row->blood ?></td>
			<td class="" style="height:35px; width:80px">
				<img src="<?php echo base_url('uploads/emp_signature/'.$row->signature) ?>" alt="Signature"  style="height:35px; width:80px">
			</td>
		</tr>

		<?php }?>



		<!-- <tr style="width: 100%">
			<!- <table width="1050px" height="80px" border="0" align="center" style="margin-bottom:0px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
				<tr height="80%" >
				<td></td>
				</tr>
				<<tr height="20%">
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">Prepare By</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">HR Manager</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">Admin Manager</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">GM</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">MD</dt></td>
				</tr> -->
			<!-- </table> -->
		<!-- </tr> -->
	</table>
	</div>
	<div style="page-break-after: always;"></div>
</body>
<script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
<?php echo "<script>applyUnicodeToBijoy()</script>"?>
<br><br>
</html>
<?php exit(); ?>
