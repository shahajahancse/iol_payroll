<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> <?= ($status == "2" ? "Promotion" : "Increment") ?> Report </title>
    <style>
		@media print {
			table {
				widht: 600px !important;
			}
		}
    </style>
</head>

<body style="margin: 0px;">

    <?php 	
		if($values == null){
			exit('No Data Found');
		}
		$this->load->view("head_english"); 
	?>
    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <span style="font-size:12px; font-weight:bold;">
            <?= ($status == "2" ? "Employee" : "Staff") ?> Probation list, Date
            <?php echo date("d/m/Y"); ?>
        </span>
        <br><br>
        <table border="1" cellpadding="0" cellspacing="0" style="font-size:12px; width:1200px; margin-bottom:20px;">
            <?php $this->load->model('Grid_model'); $i=1; ?>
			<tr>
				<th style="padding:2px 10px;">SL</th>
				<th style="padding:2px 10px;">ID</th>
				<th style="padding:4px;">Emp Name</th>
				<th style="padding:4px">Designation</th>
				<th style="padding:4px">Line</th>
				<th style="padding:4px">Section</th>
				<th style="padding:4px">Department</th>
				<th style="padding:4px">Joining Date</th>
				<th style="padding:4px">Gross Salary</th>
				<th style="padding:4px">Mom. Gross Salary </th>
				<th style="padding:4px; width: 10%;">Remark</th>
			</tr>

			<?php $emp_sec = '';
				foreach ($values as $key => $row) { ?>
				<tr>
					<td style="text-align:center; padding:10px"><?php echo $key +1; ?></td>
					<td style="text-align:center; padding:10px"><?php echo $row->emp_id?></td>
					<td style="text-align:left;   padding:10px"><?php echo $row->name_en?></td>
					<td style="text-align:left;   padding:10px"><?php echo $row->desig_name?></td>
					<td style="text-align:left;   padding:10px"><?php echo $row->line_name_en?></td>
					<td style="text-align:left;   padding:10px"><?php echo $row->sec_name_en?></td>
					<td style="text-align:left;   padding:10px"><?php echo $row->dept_name?></td>
					<td style="text-align:left;   padding:10px"><?php echo date('d-m-Y', strtotime($row->emp_join_date)) ?></td>

					<td style="text-align:left;   padding:10px"><?php echo $row->gross_sal?></td>
					<td style="text-align:left;   padding:10px"><?php echo $row->com_gross_sal?></td>
					<td></td>
				</tr>

			<?php } ?>
		</table>
	</div>
	<br><br>
</body>
</html>
<?php exit(); ?>


