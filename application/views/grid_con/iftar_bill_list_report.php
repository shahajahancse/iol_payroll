<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> Unit Transfer List </title>
    <style>
		@media print {
			table {
				widht: 600px !important;
			}
		}
    </style>
</head>

<body style="margin: 0px;">
    <?php $this->load->view("head_english"); ?>
    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <span style="font-size:12px; font-weight:bold;">
            Iftar Bill List Report, Date
            <?php echo  $date1  ?> to  <?php  echo $date2  ?>
        </span>
        <br><br>
        <table border="1" cellpadding="0" cellspacing="0" style="font-size:12px; margin-bottom:20px;">
            <?php $this->load->model('Grid_model'); $i=1; ?>
			<tr>
				<th style="padding:2px 10px;">SL</th>
				<th style="padding:2px 10px;">Employee ID</th>
				<th style="padding:4px;">Emp Name</th>
				<!-- <th style="padding:4px">Department</th>
				<th style="padding:4px">Section</th> -->
				<th style="padding:4px">Line</th>
				<th style="padding:4px">Designation</th>
				<th style="padding:4px">Day</th>
				<th style="padding:4px">ifter Allowance</th>
				<th style="padding:4px">Total Amount</th>
				<th style="padding:4px;width:100px">Sign</th>
			</tr>

			<?php 
				foreach ($values as $key => $r) {?>
				<tr>
					<td style="text-align:center; padding:2px"><?php echo $key +1; ?></td>
					<td style="text-align:center; padding:2px"><?php echo $r->emp_id?></td>
					<td style="text-align:center;   padding:2px"><?php echo $r->name_en?></td>
					<!-- <td style="text-align:left;   padding:2px"><?php echo $r->dept_bangla?></td>
					<td style="text-align:center;   padding:2px"><?php echo $r->sec_name_en?></td> -->
					<td style="text-align:center;   padding:2px"><?php echo $r->line_name_en?></td>
					<td style="text-align:center;   padding:2px"><?php echo $r->desig_name?></td>
					<td style="text-align:center;   padding:2px"><?php echo $r->ifter_day?></td>
					<td style="text-align:center;   padding:2px"><?php echo $r->ifter_amount?></td>
					<td style="text-align:center;   padding:2px"><?php echo $r->ifter_day*$r->ifter_amount?></td>
					<td style="text-align:center;   padding:15px"></td>
				</tr>
			<?php } ?>
		</table>
	</div>
	<br><br>
</body>
</html>
<?php exit(); ?>


