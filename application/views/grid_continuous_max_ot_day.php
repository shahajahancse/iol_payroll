<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>MAX OT Day Report</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
</head>
<body>
    <div style=" margin:0 auto;  width:fit-content;">
        <?php
			$data['unit_id'] = $unit_id;
			$this->load->view("head_english",$data);
		?>
        <!--Report title goes here-->
        <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
            <span style="font-size:12px; font-weight:bold;">
                Continious OT / EOT Report of <?php echo "$start_date"; ?> To <?php echo $end_date; ?></span>
            <br />
            <br />


            <table class="sal" border="1" cellpadding="3" cellspacing="0" align="center" style="font-size:12px;">
                <th>SL</th>
                <th>Emp ID</th>
                <th>Employee Name</th>
                <th>Department</th>
                <th>Section</th>
                <th>Designation</th>
                <th>Line No. </th>
                <th>Gross Sal</th>
                <th>OT Rate</th>
                <th>Max Day</th>
                <th>Total OT / EOT</th>
                <th>OT / EOT Amount</th>


                <?php
					$ot_day = 0;
					$total_ot_amount = 0;
					$max_ot = 0;
					$tot_hour = 0;
					$ot_amount = 0;


					$count = count($values);
					for($i=0; $i<$count; $i++ )
					{
						echo "<tr>";

						echo "<td>";
						echo $k = $i+1;
						echo "</td>";

						echo "<td>";
						echo $values[$i]["emp_id"];
						echo "</td>";

						echo "<td width='150'  style='text-align:left;' >";
						echo $values[$i]["emp_name"];
						echo "</td>";

						echo "<td  width='140'  style='text-align:left;'>";
						echo $values[$i]["dept_name"];
						echo "</td>";

						echo "<td  width='140'  style='text-align:left;'>";
						echo $values[$i]["sec_name"];
						echo "</td>";

						echo "<td  width='140'  style='text-align:left;'>";
						echo $values[$i]["desig_name"];
						echo "</td>";

						echo "<td  width='140'  style='text-align:left;'>";
						echo $values[$i]["line_name"];
						echo "</td>";

						echo "<td  width='40'  style='text-align:right;' >";
						echo $gross_salary = $values[$i]["gross_sal"];
						echo "</td>";

						$allow 	= 600 + 350 + 900;
						$ot_rate = round(((($gross_salary - $allow) / 1.5) * 2  / 208),2);

						echo "<td  style='text-align:right;' >";
						echo $ot_rate;
						echo "</td>";

						echo "<td style='text-align:center;'>";
						echo $values[$i]["ot_day"];
						echo "</td>";
						$ot_day = $ot_day + $values[$i]["ot_day"];

						echo "<td  style='text-align:center;' >";
						echo ($values[$i]["tot_hour"]);
						echo "</td>";
						$tot_hour = $tot_hour + $values[$i]["tot_hour"];

						echo "<td  style='text-align:right;' >";
						echo $values[$i]["tot_hour"] * $ot_rate;
						echo "</td>";
						$ot_amount = $ot_amount + ($values[$i]["tot_hour"] * $ot_rate);
						echo "</tr>";
					}
					?>
                <tr>
                    <td colspan="9" style="text-align:center; font-weight:bold;"> Grand Total </td>
                    <td style="text-align:center; font-weight:bold;"><?php echo $ot_day; ?></td>
                    <td style="text-align:center; font-weight:bold;"><?php echo $tot_hour; ?></td>
                    <td style="text-align:right; font-weight:bold;"><?php echo number_format($ot_amount); ?>/=
                    </td>
            </table>
        </div>
    </div>
</body>
<br><br><br>
</html>
<?php exit(); ?>
