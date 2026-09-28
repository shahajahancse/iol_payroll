<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
	Employee Information
</title>

<style>
		.bordered {
    border: 2px solid black;
    border-collapse: collapse;
	font-size:12px;
	border-radius:3px;
	
}
.bordered td, .bordered th {
    border: 1px solid #ffff;
	
}
.bordered th {
   background: #C9C9C9;
}
.bordered tr:nth-of-type(odd) {
    background-color: #F7F7F7;
}
 
.bordered tr:hover {
    background: #C9C9C9;
    -o-transition: all 0.1s ease-in-out;
    -webkit-transition: all 0.1s ease-in-out;
    -moz-transition: all 0.1s ease-in-out;
    -ms-transition: all 0.1s ease-in-out;
    transition: all 0.1s ease-in-out;     
}
	.emp_info{
		background:#DFDFFF;
	}
	


</style>

</head>

<body style="width:750px;">
<?php 
// dd($values);
foreach($values as $i => $value){

?>
<div style="height: 1050px;margin-bottom: 75px;">
<table align="left" border='0' bordercolor='#000000' cellspacing='0' cellpadding='0' style="text-align:center; width: 100%; margin-bottom: 40px; margin-top:20px;">
<tr style=" font-size:22px; font-weight: bold;">
	<td width="600px;">
		<?php echo $unit_name = $this->db->where("unit_id",$unit_id)->get('pr_units')->row()->unit_name;?>
	</td>
	
	
	<td  rowspan="4" width="55px;">
		<img border="1" src="<?php echo base_url();?>uploads/photo/<?php echo $value->img_source;?>" height="120px;" />
	</td>
	
</tr>
<tr>
	<td style=" font-size:18px; text-decoration: underline; font-style: italic;letter-spacing: 2px; font-weight: bold;">Employee Information</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
<tr>
	<td>&nbsp;</td>
</tr>
</table>


<table  align="left" border='0' cellspacing='2' cellpadding='4' style="text-align:left; border-collapse:collapse;border: 1px solid;width: 100%; padding: 10px;">
<tr style=" font-size:15px; font-weight: bold; margin: 3px;">
	<td colspan="4" >
	
	</td>
	</tr>
<tr style=" font-size:15px; font-weight: bold; margin: 3px;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		ID NO.:
	</td>
	
	<td width="7px;">
		
	</td>
	
	<td style="background: #DFDFFF">
		<?php echo $value->emp_id;?>
	</td>
	<td width="7px;">
		
	</td>
</tr>
<tr height="12px"></tr>

<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Employee Name
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->name_en;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Father Name
	</td>
		<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->father_name;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Mother Name
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->mother_name;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Date of Birth
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php 
		
		$dob = $value->emp_dob;
		$date_of_birth = date("d-M-Y", strtotime($value->emp_dob));
		
		$curent_date = date("Y-m-d");
		
		$date_diff 		= abs(strtotime($curent_date)-strtotime($dob));
		//DATE TO DATE RULE
		//return $month 	= floor(($date_diff)/2592000);
		
		//MONTH TO MONTH RULE
		$age_of_month 	= ceil(($date_diff)/2628000);
		
		$year = floor($age_of_month/12);
		$month = $age_of_month - ($year*12);
		echo $date_of_birth;
		
		?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Age
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php 
		$years = floor($date_diff / (365*60*60*24));
		$months = floor(($date_diff - $years * 365*60*60*24) / (30*60*60*24));
		$days = floor(($date_diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		echo $years.' years '.$months.' months and '.$days.' days';
		?>
	</td>
</tr>
<tr height="12px"></tr>

<tr style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Religion
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->religion;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Sex
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF;">
		<?php echo $value->emp_sex == 1 ? "Male": 'Female';?>
		<!-- < ?php echo $value->emp_sex == 1 ? "cyiæl": 'bvix';?> -->
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Marital Status
	</td>
	<td>
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->marital_status;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr style=" font-size:15px; font-weight: bold;">
<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Blood Group
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->blood;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Permanent Address
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
		<?php echo $value->per_village.', '.$value->per_post_name_en.', '.$value->per_upa_name_en.', '.$value->per_dis_name_en;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBFFF">
		Present Address
	</td>
	<td >
		
	</td>
	<td style="background: #DFDFFF">
				<?php echo $value->pre_village.', '.$value->pre_post_name_en.', '.$value->pre_upa_name_en.', '.$value->pre_dis_name_en;?>
	</td>
</tr>
<tr height="50px;">
	<td colspan="3"></td>
</tr>


<tr  style="font-size:15px; font-weight: bold; text-align: center;">
<td width="7px;">
		
	</td>
	<td colspan="3" style="background: #FF7F7F">
		Employee Information
	</td>
	
	
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBF7F">
		Designation
	</td>
	<td >
	</td>
	<td style="background: #BFDF7F">
		<?php echo $value->desig_name;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBF7F">
		Department
	</td>
	<td >
	
	</td>
	<td style="background: #BFDF7F">
		<?php echo $value->dept_name;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBF7F">
		Section
	</td>
	<td >
		
	</td>
	<td style="background: #BFDF7F">
		<?php echo $value->sec_name_en;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBF7F">
		Employee Type
	</td>
	<td >
	
	</td>
	<td style="background: #BFDF7F">
		<?php echo $value->stat_type;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr  style=" font-size:15px; font-weight: bold;">
	<td width="7px;">
		
	</td>
	<td width="170px;" style="background: #BFBF7F">
		Joining Date
	</td>
	<td >
		
	</td>
	<td style="background: #BFDF7F">
		<?php 
		
		
		$doj = date("d-M-Y", strtotime($value->emp_join_date));
		echo $doj;?>
	</td>
</tr>
<tr height="12px"></tr>
<tr height="50px;">
	<td colspan="3"></td>
</tr>




</table>

</div>

<?php } ?>
</body>
</html>