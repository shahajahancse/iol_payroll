<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head> </head>

<body>
	<?php
		$filename = "otreg.xls";
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
	?>

	<style type="text/css">
		.priview-body{font-size: 16px;color:#000;margin: 25px;}
		.priview-header{margin-bottom: 10px;text-align:center;}
		.priview-header div{font-size: 18px;}
		.priview-memorandum{padding-bottom: 20px;}
		.headding{border-top:1px solid #000;border-bottom:1px solid #000;text-align:center;}
		.table{width:100%;border-collapse: collapse;}
		.table td, .table th{border:0px solid #ddd;}
	</style>

	<?php
		if (is_string($value)) {
			echo $value;
			exit();
		}
	?>

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
			echo $date_format; ?></span>

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
			<?php $i=1; foreach ($value as $key => $row) { ?>
				<?php if ($row["total"] == 0){
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
					</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div><div style="page-break-after:always;"></div>
</body>
</html>
<?php exit(); ?>
