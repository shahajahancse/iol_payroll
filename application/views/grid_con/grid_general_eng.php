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
	 <h3 style="text-align: center;"><?php echo $unit_name_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_name_english;?></h3>
<h5 style="text-align: center;"><?php echo $unit_add_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_add_english;?></h5>

<?php
	$user_id = $this->session->userdata('data')->id; 
	$acl = check_acl_list($user_id); 
?>
	<table align="center" height="auto" border="1" cellspacing="0" cellpadding="2" style="font-size:15px; width:1050px;">
		<th class="text-center unicode-to-bijoy">Sl. No.</th>
		<th class="text-center unicode-to-bijoy">Emp ID</th>
		<th class="text-center unicode-to-bijoy">Name</th>
		<th class="text-center unicode-to-bijoy">Department</th>
		<th class="text-center unicode-to-bijoy">Designation</th>
		<th class="text-center unicode-to-bijoy">Line</th>
		<th class="text-center unicode-to-bijoy">Section</th>
		<th class="text-center unicode-to-bijoy">Join Date</th>
		<th class="text-center unicode-to-bijoy">Grade</th>
		<th class="text-center unicode-to-bijoy">Ot Entitle</th>
		<th class="text-center unicode-to-bijoy">Com Ot Entitle</th>
		<th class="text-center unicode-to-bijoy">Attn Bonus</th>
		<th class="text-center unicode-to-bijoy" <?php  if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>Gross Salary</th>
		<th class="text-center unicode-to-bijoy">Salary</th>
		<th class="text-center unicode-to-bijoy">NID/Birth Ceertificate</th>
		<th class="text-center unicode-to-bijoy">Date of Birth</th>
		<th class="text-center unicode-to-bijoy">Mobile</th>
		<th class="text-center unicode-to-bijoy">Present Address</th>
		<th class="text-center unicode-to-bijoy">Permanent Address</th>
		<th class="text-center unicode-to-bijoy">Gender</th>
		<th class="text-center unicode-to-bijoy">Blood</th>
		<th class="text-center unicode-to-bijoy" >Signature</th>

		<?php $i= 1;foreach($values as $row){?>
		<tr>
			<td class="text-center unicode-to-bijoy"><?php echo $i++?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->emp_id?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->name_en?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->dept_name?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->desig_name?></td>
			<td class="text-center unicode-to-bijoy" style="white-space:nowrap"><?php echo $row->line_name_en?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->sec_name_en;?></td>
			<td class="text-center unicode-to-bijoy"><?php echo date('d/m/Y',strtotime($row->emp_join_date))?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->gr_name =='None'? 'None':$row->gr_name?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->ot_entitle==0?'Yes':'No'?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->com_ot_entitle==0?'Yes':'No'?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->rule ?></td>
			<td class="text-center unicode-to-bijoy" <?php  if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?>><?php echo $row->gross_sal?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->com_gross_sal?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->nid_dob_id?></td>
			<td class="text-center unicode-to-bijoy"><?php echo date('d/m/Y',strtotime($row->emp_dob))?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->personal_mobile?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->pre_village.",".$row->pre_post_name_en.",".$row->pre_upa_name_en.",".$row->pre_dis_name_en?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->per_village.",".$row->per_post_name_en.",".$row->per_upa_name_en.",".$row->per_dis_name_en?></td>
			<td class="text-center unicode-to-bijoy"><?php echo $row->gender?></td>
			<td class="text-center"><?php echo $row->blood?></td>
			<td class="text-center unicode-to-bijoy" style="height:35px;width:77px"></td>
		</tr>

		<?php }?>



		<!-- <tr style="width: 100%"> -->
			<!-- <table width="1050px" height="80px" border="0" align="center" style="margin-bottom:0px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
				<tr height="80%" >
				<td></td>
				</tr>
				<tr height="20%">
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">Prepare By</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">HR Manager</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">Admin Manager</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">GM</dt></td>
					<td  align="center" style="width:20%"><dt class="border-top w-50" style="border-top:1px solid black !important">MD</dt></td>
				</tr>
			</table> -->
		<!-- </tr> -->
	</table>
	</div>
	<div style="page-break-after: always;"></div>
</body>
<!-- <script src="< ?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
< ?php echo "<script>applyUnicodeToBijoy()</script>"?> -->
<br><br>
</html>
<?php exit(); ?>
