<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>OT Abstract</title>
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
input{
	border:0px;
}

table.sal{ border-collapse: collapse; }

table.sal th, table.sal td {
  border: 1px solid black;
}

</style>

</head>

<body>

<div style="width: 750px;margin:0 auto;">

<?php 
$per_page_id = 26;
$emp_id_arr = ($values['emp_id']);
$row_count = count($values["emp_full_name"]);
$max = $row_count;
if($row_count >$per_page_id)
{
$page=ceil($row_count/$per_page_id);
}
else
{
$page=1;
}

$k = 0;
for($counter = 1; $counter <= $page; $counter ++)
{
 ?>
<table class="heading" align="center" height="auto" style="font-size:12px; width:750px;border:0px;;">
	<tr height="70px">
		<td style="text-align:center;width: 70%;padding-left:200px;">
		<?php $this->load->view("head_english");?> <span style="font-size:13px; font-weight:bold; text-align: center;">OT Hour Wise Employee List </span><br>Report Date: <?php echo $date = date('d-m-Y',strtotime($grid_firstdate));?></td>
		<td style="text-align:right;width: 30%">
			<?php echo '<span style="font-family:SutonnyMJ">'."পাতা নং # $counter এর $page<br>".'</span>';?>
		</td>
	</tr>
</table>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;margin-bottom:40px;">
	<form action="<?php echo base_url();?>entry_system_con/ot_abstract" method="post" >
		<input type="hidden" name="grid_firstdate" id="grid_firstdate" value="<?php echo $grid_firstdate; ?>"/>
		<input type="hidden" name="grid_emp_id" id="grid_emp_id" value="<?php echo implode(",",$emp_id_arr); ?>"/>
		<input type="hidden" name="proxi" id="proxi"  value="<?php echo $values["proxi_id"]; ?>"/>
<?php if($counter==1){ ?>
		
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td style="width:93px;"><b>In Time:</b><input style="width:40px" type="text" id="in_time" name="in_time" placeholder="HH:MM:SS" value=""></td>
			<td style="width:100px;"><b>Out Time:</b><input style="width:40px" type="text" id="out_time" name="out_time" placeholder="HH:MM:SS" value=""></td>
			<td style="width:80px;"><b>OT Hour:</b><input style="width:20px" type="text" id="ot_hour" name="ot_hour" placeholder="..." value=""></td>
			<td style="width:100px;"><b>EOT Hour:</b><input style="width: 20px;" type="text" id="eot_hour" name="eot_hour" placeholder="..." value=""></td>
			<td></td>
		</tr>

  <?php } ?>
<th>SL</th>
<th>Emp ID</th>
<th>Name</th>
<th>DOJ</th>
<th>Desi.</th>
<th style="width: 93px">In Time</th>
<th style="width: 100px">Out Time</th>
<th style="width: 80px">OT Hour</th>
<th style="width: 100px">EOT Hour</th>
<th>Search OT Hour</th>

<?php	
	for($i=0; $i<=$per_page_id; $i++)
	{ ?>
	<tr>
		<td>
			<?php echo $s = $k+1;?>
		</td>
		
		<td  style=''>
			<?php echo $values["emp_id"][$k];?>
		</td>
		
		<td>
			<?php echo $values["emp_full_name"][$k];?>
		</td>
		<td >
			<?php echo $values["doj"][$k]; ?>
		</td>
		<td>
			<?php echo $values["desig_name"][$k]; ?>
		</td>
		<td>
			<input type='text' style="width:53px;" name='orginal_in_time' id='orginal_in_time' value="<?php echo $values['in_time'][$k];?>"/>
		</td>
		<td>
			<input type='text' style="width:53px;" name='orginal_out_time' id='orginal_out_time' value="<?php echo $values['out_time'][$k];?>"/>
		</td>

		<td>
			<input type='text' style="width:20px;" name='orginal_ot' id='orginal_ot' value="<?php echo $values['ot_hour'][$k];?>"/>
		</td>
		<td>
			<input type='text' style="width:20px;" name='orginal_eot_<?php echo $values["emp_id"][$k]?>' id='orginal_eot' value="<?php echo $values['extra_ot_hour'][$k];?>"/>
		</td>
		<td>
			<?php echo $search_ot_hour;?>
		</td>
	</tr>

	 <?php 
	$k++;
	if($max==$k){
		break;
	 }
	}

	echo "</table>";
	echo "<div style='page-break-after: always;''></div>";
	if($max==$k){
		break;
	 }
   
   } ?>
   <!-- </table> -->
   <div style="clear: both;height: 20px;width: 100%;"></div>
	<table>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		 	<td colspan="5"><input style="background: green;" type="submit" value="Submit"/></td>
		</tr>
	</table>	
  </form>

</div>
</body>
</html>