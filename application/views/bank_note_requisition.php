<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
Monthly Bank Note Reqisition Sheet of
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;

?>

</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />


</head>

<body>

<?php 
// $emp_id = $value->emp_id;
$data['unit_id'] = $unit_id;
$this->load->view("head_english",$data);?>
<div align="center">
Monthly Bank Note Reqisition Sheet of 
<?php 
$date = $salary_month;
$year=trim(substr($date,0,4));
$month=trim(substr($date,5,2));
$day=trim(substr($date,8,2));
$date_format = date("F-Y", mktime(0, 0, 0, $month, $day, $year));
echo $date_format;
$total_salary = 0;
$total_notes = array();
?>
</div>
<table align="center" border="1" cellpadding="2" cellspacing="0" style="border-collapse:collapse; font-size:14px;">

  	<tr>
    <td ><div align="center"><strong>SL N0</strong></div></td>
    <td nowrap="nowrap"><div align="center"><strong>Card No</strong></div></td>
    <td  nowrap="nowrap"><div align="center"><strong>Name</strong></div></td>
	<td   nowrap="nowrap"><div align="center"><strong>Section</strong></div></td>
    <td nowrap="nowrap"><div align="center"><strong>DEG</strong></div></td>
    <td nowrap="nowrap"><div align="center"><strong>DOJ</strong></div></td>
    <td  ><div align="center"><strong>Salary</strong></div></td>
    <?php
	$bank_notes = array(1000,500,100,50,20,10,5,2,1);
	foreach($bank_notes as $bank_note)
	{
		echo "<td style='font-weight:bold; width:30px;text-align:center;'> $bank_note </td>";	
		$total_notes[$bank_note] = 0;
	}
	?>
	</tr>   
	<?php
    $row_count = count($value);

	for($k=0; $k<$row_count;$k++)
	{
		echo "<tr>";
		echo "<td >";
		echo $k+1;
		echo "</td>";
		
		echo "<td style='text-align:center; padding: 0 5px;'> ";
		print_r($value[$k]->emp_id);
		//echo $row->emp_id;
		echo "</td>";
		
		echo "<td style='padding-left:5px;'>";
		print_r($value[$k]->name_en);
		echo "</td>"; 
				
		echo "<td style='padding-left:5px;'>";
		print_r($value[$k]->sec_name_en);
		//echo $row->desig_name;
		echo "</td>";
				
		echo "<td style='padding-left:5px;'>";
		print_r($value[$k]->desig_name);
		//echo $row->desig_name;
		echo "</td>";
		
		echo "<td style='padding-left:5px;'>";
		$doj = date("d-M-Y", strtotime($value[$k]->emp_join_date)); 
		//print_r();
		echo $doj;
		echo "</td>";
		
		
		echo "<td  style='text-align:right; padding-right:5px;'>";
		print_r ($value[$k]->net_pay);
		echo "</td>";
		
		$total_salary = $total_salary + $value[$k]->net_pay;
		
		$data = $this->common_model->bank_note_requisition($value[$k]->net_pay, $bank_notes);
		
		foreach($data as $note => $bank_note)
		{
			echo "<td  style='text-align:center;'> $bank_note </td>";	
			$total_notes[$note] = $total_notes[$note] + $bank_note;
		}
					
		echo "</tr>"; 
	}
	?>
    <tr style="font-weight:bold; text-align:center;">
    <td colspan="6">Total</td>
    <td style="text-align:right;"><?php echo number_format($total_salary);?></td>
    <?php
    foreach($total_notes as  $bank_note)
		{
			echo "<td> $bank_note </td>";	
		}
		//print_r($total_notes);
    ?>
    </tr>
    </table>
</body>
</html>