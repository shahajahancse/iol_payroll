<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Increment Report</title>
<link rel="stylesheet" type="text/css" href="../../../../../css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
<style type="text/css">
	table.main_table{
	border-collapse: collapse;
}

table.main_table tr,table.main_table tr td,table.main_table tr th{
 border: 1px solid #000000;
 
}
</style>
</head>

<body>
	<?php 
		$per_page_id = 25;
		$row_count = count($values["new_emp_id"]);
		$max = $row_count;
		if($row_count >$per_page_id)
		{
			$page=ceil($row_count/$per_page_id);
			$page2=ceil($row_count/$per_page_id);
		}
		else
		{
			$page=1;
			$page2=1;
		}

		$k = 0;

		$grand_total_prev_salary = 0;
		$grand_total_inc_amount = 0;
		$grand_total_new_salary = 0;
		$section_id = $values["new_section_id"][0]; 
		$section = $values["new_section"][0]; 
		// dd($section_id .' = ' .$section);
	?>
	<?php for($counter = 1; $counter <= $page,$counter <= $page2; $counter ++)
	{
		$sub_total_prev_salary = 0;
		$sub_total_inc_amount = 0;
		$sub_total_new_salary = 0; 
	?>

		<table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;">
			<tr height="70px">
				<td style="text-align:center;width: 70%;padding-left:150px;">
				<?php $this->load->view("head_english");?><span style="font-size:13px; font-weight:bold; text-align: center;">
					Increment Report from 
					<?php 
						$year= trim(substr($start_date,0,4));
						$month = trim(substr($start_date,5,2));
						$tarik = trim(substr($start_date,8,2));
						$date_format = date("d-M-Y", mktime(0, 0, 0, $month, $tarik, $year));
						echo $date_format;
						
						echo " - TO - ";
						
						$year= trim(substr($end_date,0,4));
						$month = trim(substr($end_date,5,2));
						$tarik = trim(substr($end_date,8,2));
						$date_format = date("d-M-Y", mktime(0, 0, 0, $month, $tarik, $year));
						echo $date_format;
					?>
					</span>
				</td>
				<td style="text-align:right;width: 30%">
					<?php echo '<span style="font-family:;font-size:15px;">'."Page No. # $counter <br>".'</span>';?>
				</td>
			</tr>
		</table>

		<table class="main_table" align="center" style="font-size:12px;width: 750px">
			<?php 
				for($i=0; $i<=$per_page_id; $i++)
				{
					if ($k == 0){						
						echo "<tr bgcolor='#CCCCCC'>";
						echo "<td colspan='10' style='font-size:16px'>Section :&nbsp".$values["new_section"][$k]."</td>";
						echo "</tr>"; ?>

						<tr>
							<th>SL</th>
							<th style="background:;">Emp ID</th>
							<th>Name</th>
							<th>Designation</th> 
							<th>Line</th> 
							<th>Grade</th> 
							<th>Pre. Sal.</th>
							<th>Increment</th>
							<th>Cur. Sal.</th>
							<th>Effective Date</th>
						</tr> 
					<?php } else if(isset($values["new_section_id"][$k]) && $section_id != $values["new_section_id"][$k]){
						$i=$i+1;
						$row_count = $row_count+1;
						if($row_count > $per_page_id)
						{
							$page=ceil($row_count/$per_page_id);
							$page2=ceil($row_count/$per_page_id);
						}
						else
						{
							$page=1;
							$page2=1;
						}
						echo "<tr bgcolor='#CCCCCC'>";
						echo "<td colspan='10' style='font-size:16px'>Section :&nbsp".$values["new_section"][$k]."</td>";
						echo "</tr>"; ?>

						<tr>
							<th>SL</th>
							<th style="background:;">Emp ID</th>
							<th>Name</th>
							<th>Designation</th> 
							<th>Line</th> 
							<th>Grade</th> 
							<th>Pre. Sal.</th>
							<th>Increment</th>
							<th>Cur. Sal.</th>
							<th>Effective Date</th>
						</tr>
					<?php } 

					// dd($values);

					echo "<tr>";
						echo "<td style='padding:5px;'>";
						echo $s = $k+1;
						echo "</td>";
						
						echo "<td style='background:; padding:5px;font-weight:bold;'> ";
						$emp_id = isset($values["ref_id"][$k]) ? $values["ref_id"][$k] : '';
						echo $emp_id;
						echo "</td>";
						
						$emp_info = $this->db->where('emp_id', $emp_id)->get('pr_emp_per_info')->row();
						$emp_name = (isset($emp_info->name_en)) ? $emp_info->name_en : '';
						echo "<td style='padding:5px; width:170px;'> ";
						echo $emp_name;
						echo "</td>";
						
						echo "<td style='text-align:left; padding:5px;'>";
						echo (isset($values["new_desig"][$k])) ? $values["new_desig"][$k] : '';
						echo "</td>";
						
						echo "<td style='text-align:left; padding:5px;'>";
						echo (isset($values["new_line"][$k])) ? $values["new_line"][$k] : '';
						echo "</td>";
						$grade_id = (isset($values["new_grade"][$k])) ? $values["new_grade"][$k] : '';
						$grade_row = $this->db->where('gr_id',$grade_id)->get('pr_grade')->row();
						$grade_name = (isset($grade_row->gr_name)) ? $grade_row->gr_name : '';
						echo "<td style='text-align:center; padding:5px;'>";
						echo $grade_name;
						echo "</td>";
						
						echo "<td style='text-align:right; padding:5px;' >";
						echo (isset($values["prev_salary"][$k])) ? $values["prev_salary"][$k] : '';
						echo "</td>";
						
						$inc_amount = (isset($values["new_salary"][$k]) && isset($values["prev_salary"][$k])) ? $values["new_salary"][$k] - $values["prev_salary"][$k] : 0;
						echo "<td style='text-align:right; padding:5px;' >";
						echo $inc_amount;
						echo "</td>";
						
						echo "<td style='text-align:right; padding:5px;' >";
						echo (isset($values["new_salary"][$k])) ? $values["new_salary"][$k] : '';
						echo "</td>";
						
						$sub_total_prev_salary += isset($values["prev_salary"][$k]) ? $values["prev_salary"][$k] : 0;
						$sub_total_inc_amount = $sub_total_inc_amount + $inc_amount;
						$sub_total_new_salary += isset($values["new_salary"][$k]) ? $values["new_salary"][$k] : 0;
						
						$grand_total_prev_salary += isset($values["prev_salary"][$k]) ? $values["prev_salary"][$k] : 0;
						$grand_total_inc_amount = $grand_total_inc_amount + $inc_amount;
						$grand_total_new_salary += isset($values["new_salary"][$k]) ? $values["new_salary"][$k] : 0;
						$grand_total_new_salary += (isset($values["new_salary"][$k]) ? $values["new_salary"][$k] : 0);
						
					    $sStartDate = isset($values["effective_month"][$k]) ? date("d-M-Y", strtotime($values["effective_month"][$k])) : '';
						
						echo "<td  style='text-align:center;' >";
						echo $sStartDate;
						echo "</td>";
					echo "</tr>";
					$section_id = isset($values["new_section_id"][$k]) ? $values["new_section_id"][$k] : null;
					$line 	= isset($values["new_line"][$k]) ? $values["new_line"][$k] : null;

					if($max==$k){
						break;
					}
					$k++;
				}

				echo "<tr bgcolor='#CCCCCC' style='font-weight:bold; padding:2px;' >";
				echo "<td colspan='6' >";
				echo "Subtotal";
				echo "</td>";
				
				echo "<td>";
				echo $sub_total_prev_salary;
				echo "</td>";
				
				echo "<td>";
				echo $sub_total_inc_amount;
				
				echo "</td>";
				
				echo "<td>";
				echo $sub_total_new_salary;
				echo "</td>";
				
				echo "<td>";
				echo "";
				echo "</td></tr>";

				if($counter==$page2){
					echo "<tr bgcolor='#CCCCCC' style='font-weight:bold;text-align:center; padding:2px;' >";
					echo "<td colspan='6' >";
					echo "Grand Total";
					echo "</td>";
					
					echo "<td>";
					echo $grand_total_prev_salary;
					echo "</td>";
					
					echo "<td>";
					echo $grand_total_inc_amount;
					echo "</td>";
					
					echo "<td>";
					echo $grand_total_new_salary;
					echo "</td>";
					
					echo "<td>";
					echo "";
					echo "</td>";
				}
			?>

			<table width="750" height="65px" border="0" align="center" style="margin-bottom:70px; font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:bold;">
				<tr height="20%" >
					<td colspan="29"></td>
				</tr>
				<tr height="15%">
					<td  align="center" style="width:12%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
					<td align="center"  style="width:12%" ><dt class="bottom_txt_design" >Manager(HR)</dt></td>
					<td  align="center" style="width:12%" ><dt class="bottom_txt_design" >Manager(Admin)</dt></td>
					<td  align="left" style="width:20%;"><dt class="bottom_txt_design" >GM(Admin, HRD & Compliance)</dt></td>
				</tr>
			</table>
		</table>

		<div style="page-break-after: always;"></div>
		<?php if($max==$k){ break; } ?> 
	<?php  } ?>
</body>
</html>
<br><br><br>
<?php exit(); ?>