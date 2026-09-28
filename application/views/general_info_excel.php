<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
<head>
<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->
</head>

<!-- <body style="width:800px;"> -->
<body style="width:800px;">
<?php
	$filename = "araf.xls";
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
?>

<?php 
$row_count=count($values["emp_name"]);
if($row_count > 26)
{
$page = ceil($row_count/26);
}
else
{
$page=1;
}

$k = 0;

			
			
			
for ( $counter = 1; $counter <= $page; $counter ++)
{
?>

<table align="center" height="auto"  class="sal" border="1" cellspacing="0" cellpadding="2" style="font-size:12px; width:750px;">

<tr height="85px">

<td colspan="22" style="text-align:center;">
 
<?php
$this->load->view("head_english");?>
<span style="font-size:13px; font-weight:bold; text-align: center;">
Section Wise All Employee List 
</span>

</td>
</tr>


<th>SL</th>
<th>Emp ID</th>
<th>N.ID</th>
<th>Name</th>
<th>F.Name</th>
<th>M.Name</th>
<th>S.Name</th>
<th>Mobile</th>
<th>Pre.Address</th>
<th>Par.Address</th>
<th>Gender</th>
<th>Blood</th>
<th>Height</th>
<th>Dept.</th>
<th>Sec.</th>
<th>Desi.</th>
<th>Line.</th>
<th>Date of Birth</th>
<th>Joining Date</th>
<th>Sal. Grade</th>
<th>Gross Salary</th>
<th style="padding-left: 15px;padding-right: 15px;">Signature</th>
<?php
			
	if($counter == $page)
  	{
   		$modulus = ($row_count-1) %26;
    	$per_page_row=$modulus;
	}
   	else
   	{
    	$per_page_row=25;
   	}
  	
   //	$k = 1;
	
	for($i=0; $i<=$per_page_row;$i++)
	{
		echo "<tr>";
	
	echo "<td>";
	echo $k +1;
	echo "</td>";
	
	
	echo "<td  style='text-align:center; width:70px;'>";
	echo $values["emp_id"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["n_id"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_fname"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_mname"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["spouse_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["mobile"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_pre_add"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_par_add"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_sex"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["emp_blood"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["posi_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["dept_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["sec_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["desig_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["line_name"][$k];
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
	
	echo "<td >";
	echo $values["gr_name"][$k];
	echo "</td>";
	
	echo "<td >";
	echo $values["gross_sal"][$k];
	echo "</td>";
	
	echo "<td >";
	echo "&nbsp;";
	echo "</td>";
	
	echo "</tr>";
		$k++;
		
		
	}
	?>
	
	<tr>
			
			<table width="100%" height="80px" border="0" align="center" style="margin-bottom:90px; font-family:Arial, Helvetica, sans-serif; font-size:10px;">
			<tr height="80%" >
			<td></td>
			</tr>
			<tr height="20%">
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Prepare By</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >HR Manager</dt></td>
			<td  align="center" style="width:20%" ><dt class="bottom_txt_design" >Admin Manager</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >GM</dt></td>
            <td  align="center" style="width:20%" ><dt class="bottom_txt_design" >MD</dt></td>
			</tr>
			
			</table>
		</tr>
			</table>
			  
			<?php

		}

?>

</body>
</html>