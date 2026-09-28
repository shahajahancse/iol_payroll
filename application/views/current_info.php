<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
	Current Employee Report

</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style>
.bottom_txt_design
{
	 border-top:1px solid;
	 width:160px;
	 font-weight:bold;
}
.bottom_txt_manager_design
{
	border-top:1px solid;
	width:170px;
}
</style>

</head>

<body style="width:800px;margin:0 auto;">

<?php 
$row_count=count($values["emp_name"]);
if($row_count > 45)
{
$page = ceil($row_count/45);
}
else
{
$page=1;
}

$k = 0;
		
			
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:800px;margin:0 auto;">

<tr height="85px">

<td colspan="7" style="text-align:center;">
 
<?php
$this->load->view("head_english");?>
<span style="font-size:13px; font-weight:bold; text-align: center;">
DETAILS INFORMATION AND TOTAL EMPLOYEES LIST OF THE FACTORY FOR GROUP INSURANCE
</span>

</td>
</tr>


<th>SL</th>
<th>Emp ID</th>
<th>Name</th>
<th>Designation</th>
<th>Date of Birth</th>
<th>Joining Date</th>
<th>Process Name</th>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) %45;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=44;
   	}
  	
   //	$k = 1;
   	$g=0;
	for($i=0; $i<=$per_page_row;$i++)
	{
		echo "<tr>";
	$g = $g + 1;
	echo "<td>";
	echo $k + 1;
	echo "</td>";
	
	echo "<td  style='text-align:center; width:70px;'>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	
	echo "<td >";
	echo $values["emp_name"][$k];
	echo "</td>";
	
	
	echo "<td >";
	echo $values["desig_name"][$k];
	echo "</td>";
	
	
	echo "<td   style='text-align:center; width:70px;'>";
	$year= trim(substr($values["emp_dob"][$k],0,4));
	$month = trim(substr($values["emp_dob"][$k],5,2));
	$tarik = trim(substr($values["emp_dob"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";
	
	echo "<td  style='text-align:center; width:70px;'>";
	$year= trim(substr($values["doj"][$k],0,4));
	$month = trim(substr($values["doj"][$k],5,2));
	$tarik = trim(substr($values["doj"][$k],8,2));
	$date_format = date("d-M-y", mktime(0, 0, 0, $month, $tarik, $year));
	echo $date_format;
	echo "</td>";
	
	echo "<td  style='text-align:center;'>";
	echo $values["process_name"][$k];
	echo "</td>";
	$desi_id[] = $values["desig_id"][$k];
	echo "</tr>";
		$k++;
		$g++;
		//echo $counter;
	}
	echo "<table style='width:800px;text-align:center'>";
		$this->db->select('desig_id,desig_name');
		$query = $this->db->get('pr_designation');
		foreach($query->result() as $row){
			$desig_id = $row->desig_id;
			$this->db->select('emp_id');
			$this->db->from('pr_emp_com_info');
			$this->db->where('emp_desi_id', $desig_id);
			$this->db->where_in('emp_id', $grid_emp_id);
			$this->db->where('emp_cat_id != 4');
			$query2 = $this->db->get();
			$sum_id = $query2->num_rows();
			if($counter == $page){
				if($sum_id !=0){
				echo "<p style='font-weight:bold;background:gray;text-align:center;margin:2px 0px 0px 0px;padding:0px;'><tr><td>".$row->desig_name.'('.$sum_id.')'.'</p>';
			}
		}
			
		echo "</table>";
	}
		
	?>
		<table width="100%" height="80px" border="0" align="center" style="margin-bottom:50px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="80%" >
			<td colspan="28"></td>
			</tr>
			<tr height="20%">
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
            <td align="center"  style="width:20%" ><dt class="bottom_txt_design" >Check By(Admin & HR Dept.)</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Approved By(General Manager)</dt></td>
			</tr>
		</table>
	</table>	  
	<?php
 }
?>

</body>
</html>