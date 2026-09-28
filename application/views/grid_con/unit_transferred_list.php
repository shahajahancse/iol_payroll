<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> Unit Transferred List </title>
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
	// dd($array);
		if($array == null){
			exit('No Data Found');
		}
		$this->load->view("head_english"); ?>
    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <span style="font-size:12px; font-weight:bold;">
            Unit Transfer  Report, Date
            <?php echo date("d/m/Y"); ?>
        </span>
        <br><br>
        <table border="1" cellpadding="0" cellspacing="0" style="font-size:12px; width:1200px; margin-bottom:20px;">
            <?php $this->load->model('Grid_model'); $i=1; ?>
			<tr>
				<th style="padding:2px 10px;">SL</th>
				<th style="padding:2px 10px;">Old Employee ID</th>
				<th style="padding:2px 10px;">New Employee ID</th>
				<th style="padding:4px;">Emp Name</th>
				<th style="padding:4px">Last Working Date</th>
				<th style="padding:4px">Department</th>
				<th style="padding:4px">Section</th>
				<th style="padding:4px">Line</th>
				<th style="padding:4px">Designation</th>
				<th style="padding:4px">Remarks</th>
			</tr>

			<?php 
				foreach ($array as $key => $r) {?>
				<tr>
					<td style="text-align:center; padding:2px"><?php echo $key +1; ?></td>
					<td style="text-align:center; padding:2px"><?php echo $r->old_emp_id?></td>
					<td style="text-align:center; padding:2px"><?php echo $r->new_emp_id?></td>
					<td style="text-align:left;   padding:2px"><?php echo $r->name_bn?></td>
					<td style="text-align:left;   padding:2px"><?php echo date('d-m-Y', strtotime($r->last_working_day)) ?></td>
					<td style="text-align:left;   padding:2px"><?php echo $r->dept_bangla?></td>
					<td style="text-align:left;   padding:2px"><?php echo $r->sec_name_bn?></td>
					<td style="text-align:left;   padding:2px"><?php echo $r->line_name_bn?></td>
					<td style="text-align:left;   padding:2px"><?php echo $r->desig_bangla?></td>
					<td></td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<br><br>
</body>
</html>
<?php exit(); ?>


