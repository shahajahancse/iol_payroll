<html>
<head>
<title>Monthly Attendance Register</title>
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


<div align="center" style=" margin:5px auto 0;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">

<?php 
	foreach($value as $row){
		$att_month = $row->att_month;
	}

	$att_month = $att_month;

	/*echo "<pre>";
	print_r($value);
	exit;*/
	$per_page_id = 14;
	$row_count=count($value);
	if($row_count > $per_page_id)
	{
		$page=ceil($row_count/$per_page_id);
	}
	else
	{
		$page=1;
	}

	$i = 0;
	for($counter = 1; $counter <= $page; $counter++)
	{ ?>
	<div class="head-container" style="padding:20px 0px;width: 100%;display: inline-block;">
		<div style="text-align:center; position:relative;padding-left:269px;width:50%; overflow:hidden; float:left; display:block;">
		<?php 
			$this->load->view("head_bangla");
		?>
		<span style="font-size:14px; font-weight:bold;font-family: SutonnyMj;margin-top: 10px;">
			<?php 
				$report_date = date('m-Y',strtotime($year_month)); 
				echo $report_date.' মাসের উপস্থিতি নিবন্ধন';
			?> 
		</span>
		</div>
		<div style="text-align:left; position:relative;padding-left:10px;width:20%; overflow:hidden; float:right; display:inline; font-weight:bold">
			<?php
			echo '<span style="font-family:SutonnyMJ">'."পাতা নং # $counter এর $page<br>".'</span>';?>

		</div>
	</div>
	<table class="main_table" border='1' cellpadding='0' cellspacing='0' style=" font-size:16px;">

	<th>ক্রমিক</th><th>কার্ড নং</th><th style="width:120px;">নাম</th><th style="width:90px;">পদবী</th><th>যোগদানের তারিখ</th>

	<?php
		$first_y=trim(substr($att_month,0,4));
		$first_m=trim(substr($att_month,5,2));
		$last_date = date("t", mktime(0, 0, 0, $first_m, 1, $first_y));

		for ($k=1 ; $k <= $last_date ; $k++ )
		{
			echo "<th style='width:20px;font-family: SutonnyMj'>$k</th>";
		}
		echo "<th style='font-size:14px;'>মোট দিন</th>";
		echo "<th style='font-size:14px;'>ওভার ঘন্টা</th>";

		if($counter == $page)
	  	{
	   		$modulus = ($row_count-1) % $per_page_id;
	    	$per_page_row = $modulus;
		}
	   	else
	   	{
	    	$per_page_row = $per_page_id - 1;
	   	}
	   	
		for($j=0; $j<=$per_page_row; $j++)
		{ 
		
	    //foreach($value->result_array() as $rows => $row){
	   // $serial = $i + 1;
		echo "<tr><td style='font-family: SutonnyMj;'>";
		 echo $i + 1;
		echo "</td>";
		echo "<td style='font-family: SutonnyMj'>";
		echo $value[$i]->emp_id;
		echo "</td><td style='font-family: SutonnyMj;font-size:14px;'>";
		echo $value[$i]->bangla_nam;
		echo "</td><td style='font-family: SutonnyMj;font-size:14px;'>";
		echo $value[$i]->desig_bangla;
		echo "</td>";

		echo "<td style='font-family: SutonnyMj;font-size:14px;'>";
		$doj = date('d-m-Y',strtotime($value[$i]->emp_join_date));
		echo $doj;
		echo "</td>";

		
		for($k=1; $k <= $last_date ; $k++){
			echo "<td style='text-align:center;'>";
			echo "<input type='text' name='fname' style='width:20px;height:18px;border:1px solid #000;margin:1px;'>";
			echo "<input type='text' name='fname' style='width:20px;height:18px;border:1px solid #000;margin:1px;'>";
			echo "</td>";
		}

		echo "<td style='text-align: center;'> </td>";
		echo "<td style='text-align: center;'>";
		echo " ";
		echo "</td>";
		echo "</tr>";
		
		$i++;
  }
 ?>
</table>
<div style="page-break-after: always;"></div>
<?php } ?>
</body>
</html>