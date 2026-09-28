<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Continuous <?php echo $status; ?> Report</title>
    <link rel="stylesheet" type="text/css" href="../../../../../../css/SingleRow.css" />
</head>

	<style>
		@media print{
			.page_break_t{
				display: block;
				border: none;
			}
			.page_break{
				page-break-before: always;
			}
		}
	</style>
<body>
    <div style="margin:0 auto; width:800px;">
        <?php $this->load->view("head_english");?>
        <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
            <span style="font-size:13px; font-weight:bold;">
		<?php echo $status; ?> Report from
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

		?></span>
		<br />
		<br />
		<table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:13px;">
			<tr>
				<th style="padding:5px">SL</th>
				<th style="padding:5px">Emp ID</th>
				<th style="padding:5px">Name</th>
				<th style="padding:5px">Designation</th>
				<th style="padding:5px"> Line</th>
				<th style="padding:5px"> Emp Join Date</th>
				<th style="padding:5px">Total <?php echo $status; ?></th>
			</tr>
			<?php $i=1; foreach ($values as $key => $row) {
				if ($row["total"] == 0){
					continue;
				}else{ ?>
					<tr>
						<td style="padding:2px 5px"> <?= $i++ ?> </td>
						<td style="padding:2px 5px"> <?= $row["emp_id"] ?> </td>
						<td style="padding:2px 5px"> <?= $row["name_en"] ?> </td>
						<td style="padding:2px 5px"> <?= $row["desig_name"] ?> </td>
						<td style="padding:2px 5px"> <?= $row["line_name_en"] ?> </td>
						<td style="padding:2px 5px"> <?= date('d M Y',strtotime($row["emp_join_date"])) ?> </td>
						<td style="padding:2px 5px"> <?= $row["total"] ?> </td>
					<tr>
				<?php }?>
			<?php } ?>
		</table>
	</div>
	<br><br>
</body>

</html>
<?php exit(); ?>
