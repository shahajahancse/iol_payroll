<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Short Employee Summary</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/table.css" />
</head>

<body>
<div style="width:auto; ">
<div style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif; width:60%; ">

<table class="bordered_salary" border="1" cellspacing="0" cellpadding="0" style="font-size:12px; margin:0 auto; width:68%;">
<tr>
<td colspan="4">
<?php 
$this->load->view("head_english"); 
?>
	<div  style="font-size:13px; font-weight:bold; text-align:center; width:100%;">

	Short Employee Summary
</div>
	</td>
</tr>	
    <tbody>
    	<?php
		$total_staff = 0;
		$total_male = 0;
		$total_female = 0;
		$count = count($values["total_emp"]);
		for($i=0; $i < $count; $i++)
		{  ?> 
        <tr>
            <td colspan="2" valign="top" width="213">
                <p align="center">
                    <strong>Total Staff</strong>
                </p>
            </td>
            <td valign="top" width="213">
                <p align="center">
                    <strong>Male</strong>
                </p>
            </td>
            <td valign="top" width="213">
                <p align="center">
                    <strong>Female</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td valign="top" width="106" style="padding-left:10px;">
                <p>
                    <strong><?php echo $values['stuff']; ?></strong>
                </p>
            </td>
            <td valign="top" width="106" align="center"><p><?php echo $values['total_emp']; ?></p></td>
            <td valign="top" width="213" align="center"><p><?php echo $values['male']; ?></p></td>
            <td valign="top" width="213" align="center"><p><?php echo $values['female']; ?></p></td>
        </tr>
        <tr>
            <td valign="top" width="106" style="padding-left:10px;">
                <p>
                    <strong><?php echo $values['worker']; ?></strong>
                </p>
            </td>
            <td valign="top" width="106" align="center"><p><?php echo $values['total_emp1']; ?></p></td>
            <td valign="top" width="213" align="center"><p><?php echo $values['male1']; ?></p></td>
            <td valign="top" width="213" align="center"><p><?php echo $values['female1']; ?></p></td>
        </tr>

        <tr>
            <td valign="top" width="106" style="padding-left:10px;">
                <p>
                    <strong><?php echo $values['cleaning']; ?></strong>
                </p>
            </td>
            <td valign="top" width="106" align="center"><p><?php echo $values['total_emp2']; ?></p></td>
            <td valign="top" width="213" align="center"><p><?php echo $values['male2']; ?></p></td>
            <td valign="top" width="213" align="center"><p><?php echo $values['female2']; ?></p></td>
        </tr>

        <?php $total_staff = $total_staff+$values['total_emp'] + $values['total_emp1'] + $values['total_emp2'];?>
		<?php $total_male = $total_male+$values['male'] + $values['male1'] + $values['male2'];?>
        <?php $total_female = $total_female+$values['female'] + $values['female1'] + $values['female2'];?>
        <tr>
            <td valign="top" width="106" style="padding-left:10px;">
                <p>
                    <strong>Total Employee</strong>
                </p>
            </td>
            <td valign="top" width="106" align="center"><p><strong><?php echo $english_format_number = number_format($total_staff);?></strong></p></td>
            <td valign="top" width="213" align="center"><p><strong><?php echo $english_format_number = number_format($total_male);?></strong></p></td>
            <td valign="top" width="213" align="center"><p><strong><?php echo $english_format_number = number_format($total_female);?></strong></p></td>
        </tr>
        <?php
}
?>
    </tbody>
</table>
 
</div>
</div>
</body>
</html>