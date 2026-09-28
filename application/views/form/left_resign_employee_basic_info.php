<style>
.table_class
{
	color: #333;
	font-family: Helvetica, Arial, sans-serif;
	width: 390px;
	border-collapse: collapse;
	border-spacing: 1px;
}

.table_class td, th {
	border: 1px solid transparent; /* No more visible border */
	height: 10px;
	transition: all 0.3s;  /* Simple transition for hover effect */
}
.table_class th {
	background: #3B3B3B;  /* Darken header a bit */
	font-weight: bold;
	color: #FFF;
}
.table_class td {
	background: #FAFAFA;
	text-align: left;
}
/* Cells in even rows (2,4,6...) are one color */ 
.table_class tr:nth-child(even) td {
	background: #F1F1F1;
}
/* Cells in odd rows (1,3,5...) are another (excludes header cells)  */ 
.table_class tr:nth-child(odd) td {
	background: #FEFEFE;
}
.table_class tr td:hover {
	background: #3B3B3B;
	color: #FFF;
} /* Hover cell effect! */
.table_class .label_show {
	color: green;
	font-weight: bold;
	text-align:right;
	background: #FFD;
	font-size:10px;
}
</style>
<?php
$this->db->select('pr_emp_com_info.emp_id, pr_emp_per_info.emp_full_name,pr_emp_per_info.img_source,pr_dept.dept_name, pr_section.sec_name, pr_line_num.line_name, pr_designation.desig_name,  pr_emp_com_info.emp_join_date,pr_grade.gr_name, pr_emp_com_info.gross_sal,pr_emp_per_info.emp_dob,pr_emp_status.stat_type');
		$this->db->from('pr_emp_per_info');
		$this->db->from('pr_emp_com_info');
		$this->db->from('pr_grade');
		$this->db->from('pr_dept');
		$this->db->from('pr_section');
		$this->db->from('pr_line_num');
		$this->db->from('pr_designation');
		$this->db->from('pr_emp_status');
		
		$this->db->where('pr_emp_com_info.emp_id', $emp_id);
		$this->db->where('pr_emp_com_info.emp_desi_id = pr_designation.desig_id');
		$this->db->where('pr_emp_com_info.emp_dept_id = pr_dept.dept_id');
		$this->db->where('pr_emp_com_info.emp_sec_id = pr_section.sec_id');
		$this->db->where('pr_emp_com_info.emp_line_id = pr_line_num.line_id');
		$this->db->where('pr_emp_per_info.emp_id = pr_emp_com_info.emp_id');
		$this->db->where('pr_emp_com_info.emp_sal_gra_id = pr_grade.gr_id');
		$this->db->where('pr_emp_com_info.emp_cat_id = pr_emp_status.stat_id');

		$this->db->order_by("pr_emp_com_info.emp_id");
		$query = $this->db->get();	
		foreach($query->result() as $rows)
		{
			
			$emp_name 	= $rows->emp_full_name;
			$dept_name 	= $rows->dept_name;
			$sec_name 	= $rows->sec_name;
			$line_name 	= $rows->line_name;
			$desig_name	= $rows->desig_name;
			$doj 		= $rows->emp_join_date;
			$doj = date("d-M-Y",strtotime($doj));
			$emp_dob 	= $rows->emp_dob;
			
			$gross_sal 	= $rows->gross_sal;
			$gr_name	= $rows->gr_name;
			$status		= $rows->stat_type;
			$images		= $rows->img_source;
		}
		
		
		$this->db->select('shift_log_date');
		$this->db->from('pr_emp_shift_log');
		$this->db->where('emp_id', $emp_id);
		$this->db->where('in_time !=', "00:00:00");
		$this->db->order_by('shift_log_date','desc');
		$this->db->limit(1);
		$query_1 = $this->db->get();
		foreach($query_1->result() as $rows)
		{
			$lpd		= $rows->shift_log_date;
			$lpd = date("d-M-Y",strtotime($lpd));
		}
		
?>

<table class="table_class" cellpadding="7">
      <tr>
       	<th colspan="5">Basic Information</th>
      </tr>
      
      
	<tr>
		<td width="20%">Name</td><td width="10%">:</td>
		<td width="20%"><?php echo $emp_name; ?></td>
		<td width='18%' rowspan="4"><img style="margin-left: 15px;"  id='img'  name='image' alt='Image' width="70" height="80px" src="<?php echo base_url(); ?>uploads/photo/<?php echo $images; ?>"></td>
	</tr>
      
      <tr>
		<td> Designation </td><td>:</td>
		<td><?php echo $desig_name; ?></td>
		
	 </tr>

	<tr>
		<td> Section </td><td>:</td>
		<td><?php echo $sec_name; ?></td>
	</tr>

	<tr>
		<td> Date of Join </td><td>:</td>
		<td><?php echo $doj; ?></td>
	</tr>
	
	<tr>
		<td> LPD </td><td>:</td>
		<td><?php echo $lpd; ?></td>
		<td style="color: #ac0000;text-align: center;"><?php echo $status; ?></td>
	</tr>
	
         
        
</table>
    
      


