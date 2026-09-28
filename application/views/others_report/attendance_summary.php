<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
    </head>
    <body>
        <?php // print_r($values); ?>
        <div style=" margin:0 auto;  width:auto;">
            <div id="no_print" style="float:right;">
            </div>
            <?php
            $data['unit_id'] = $unit_id;
            $this->load->view("head_english", $data);
            ?>
            <!--Report title goes here-->
            <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;"><span style="font-size:13px; font-weight:bold;">
                    <?php echo $title; ?> of <?php echo $report_date; ?></span>
                <br />
                <br />
                <table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:10px;">
                    <tr>
                        <th rowspan="3">SL</th>
                        <th rowspan="3"><?php echo $category; ?> Name</th>
                        <!--<th rowspan="3">Required</th>-->
                        <th rowspan="3">Total</th>
                        <th rowspan="3">Present</th>
                        <th rowspan="3">Absent</th>
                        <th rowspan="3">Male</th>
                        <th rowspan="3">Female</th>
                       <!--< <th rowspan="3">Leave</th>
                        <th rowspan="3">Late</th>-->
                    </tr>
                    <tr>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Office Staff</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#D5D5D5;"><div align="center">PD Staff</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Operator</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#D5D5D5;"><div align="center">Asst.Operator</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Line Iron Man</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Finishing Assistant</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Jr. Iron Man</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Iron Man</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Poly Man</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Spot Man</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Folding Man</div></td>
                        <td colspan="3" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Packer</div></td>
                        <td rowspan="2">Leave</td>
                        <td rowspan="2">Late</td>
                        <td rowspan="2" colspan="2">Remarks</td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td> 
                        
                         <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                        
                         <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                    </tr>

                    <?php
                    $all_emp = 0;
                    $all_present = 0;
                    $all_absent = 0;
                    $all_leave = 0;
                    $all_late = 0;
                    $all_male = 0;
                    $all_female = 0;

                    $all_emp_lc = 0;
                    $all_present_lc = 0;
                    $all_absent_lc = 0;

                    $all_emp_s = 0;
                    $all_present_s = 0;
                    $all_absent_s = 0;

                    $all_emp_op = 0;
                    $all_present_op = 0;
                    $all_absent_op = 0;

                    $all_emp_hl = 0;
                    $all_present_hl = 0;
                    $all_absent_hl = 0;

                    $all_emp_im = 0;
                    $all_present_im = 0;
                    $all_absent_im = 0;

                    $all_emp_fqi = 0;
                    $all_present_fqi = 0;
                    $all_absent_fqi = 0;

                    $all_emp_jim = 0;
                    $all_present_jim = 0;
                    $all_absent_jim = 0;

                    $all_emp_imn = 0;
                    $all_present_imn = 0;
                    $all_absent_imn = 0;

                    $all_emp_pm = 0;
                    $all_present_pm = 0;
                    $all_absent_pm = 0;

                    $all_emp_sm = 0;
                    $all_present_sm = 0;
                    $all_absent_sm = 0;
					
					$all_emp_fjf = 0;
                    $all_present_fjf = 0;
                    $all_absent_fjf = 0;
					
					$all_emp_jp = 0;
                    $all_present_jp = 0;
                    $all_absent_jp = 0;

                    $count = count($values["cat_name"]);

                    for ($i = 0; $i < $count; $i++) {
                        if ($i % 2 == 0)
                            echo "<tr>";
                        else
                            echo "<tr style='background-color:#E5E5E5;'>";

                        echo "<td>";
                        echo $k = $i + 1;
                        echo "</td>";

                        echo "<td style='padding:5px;'>";
                        echo $values["cat_name"][$i];
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_emp'];
                            $all_emp = $all_emp + $values["daily_att_sum"][$i]['all_emp'];
                        } else {
                            echo '--';
                        }
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_present'];
                            $all_present = $all_present + $values["daily_att_sum"][$i]['all_present'];
                        } else {
                            echo '--';
                        }
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_absent'];
                            $all_absent = $all_absent + $values["daily_att_sum"][$i]['all_absent'];
                        } else {
                            echo '--';
                        }
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_male'];
                            $all_male = $all_male + $values["daily_att_sum"][$i]['all_male'];
                        } else {
                            echo '--';
                        }
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_female'];
                            $all_female = $all_female + $values["daily_att_sum"][$i]['all_female'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][0][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][0][$i]['all_emp'];
                            $all_emp_lc = $all_emp_lc + $values["remarks_daily_att_sum"][0][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][0][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][0][$i]['all_present'];
                            $all_present_lc = $all_present_lc + $values["remarks_daily_att_sum"][0][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][0][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][0][$i]['all_absent'];
                            $all_absent_lc = $all_absent_lc + $values["remarks_daily_att_sum"][0][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][1][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][1][$i]['all_emp'];
                            $all_emp_s = $all_emp_s + $values["remarks_daily_att_sum"][1][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][1][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][1][$i]['all_present'];
                            $all_present_s = $all_present_s + $values["remarks_daily_att_sum"][1][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][1][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][1][$i]['all_absent'];
                            $all_absent_s = $all_absent_s + $values["remarks_daily_att_sum"][1][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][2][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][2][$i]['all_emp'];
                            $all_emp_op = $all_emp_op + $values["remarks_daily_att_sum"][2][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][2][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][2][$i]['all_present'];
                            $all_present_op = $all_present_op + $values["remarks_daily_att_sum"][2][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][2][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][2][$i]['all_absent'];
                            $all_absent_op = $all_absent_op + $values["remarks_daily_att_sum"][2][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][3][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][3][$i]['all_emp'];
                            $all_emp_hl = $all_emp_hl + $values["remarks_daily_att_sum"][3][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][3][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][3][$i]['all_present'];
                            $all_present_hl = $all_present_hl + $values["remarks_daily_att_sum"][3][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][3][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][3][$i]['all_absent'];
                            $all_absent_hl = $all_absent_hl + $values["remarks_daily_att_sum"][3][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][4][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][4][$i]['all_emp'];
                            $all_emp_im = $all_emp_im + $values["remarks_daily_att_sum"][4][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][4][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][4][$i]['all_present'];
                            $all_present_im = $all_present_im + $values["remarks_daily_att_sum"][4][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#E5E5E5;'>";
                        if ($values["remarks_daily_att_sum"][4][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][4][$i]['all_absent'];
                            $all_absent_im = $all_absent_im + $values["remarks_daily_att_sum"][4][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][5][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][5][$i]['all_emp'];
                            $all_emp_fqi = $all_emp_fqi + $values["remarks_daily_att_sum"][5][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][5][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][5][$i]['all_present'];
                            $all_present_fqi = $all_present_fqi + $values["remarks_daily_att_sum"][5][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][5][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][5][$i]['all_absent'];
                            $all_absent_fqi = $all_absent_fqi + $values["remarks_daily_att_sum"][5][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][6][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][6][$i]['all_emp'];
                            $all_emp_jim = $all_emp_jim + $values["remarks_daily_att_sum"][6][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][6][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][6][$i]['all_present'];
                            $all_present_jim = $all_present_jim + $values["remarks_daily_att_sum"][6][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][6][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][6][$i]['all_absent'];
                            $all_absent_jim = $all_absent_jim + $values["remarks_daily_att_sum"][6][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][7][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][7][$i]['all_emp'];
                            $all_emp_imn = $all_emp_imn + $values["remarks_daily_att_sum"][7][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][7][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][7][$i]['all_present'];
                            $all_present_imn = $all_present_imn + $values["remarks_daily_att_sum"][7][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][7][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][7][$i]['all_absent'];
                            $all_absent_imn = $all_absent_imn + $values["remarks_daily_att_sum"][7][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][8][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][8][$i]['all_emp'];
                            $all_emp_pm = $all_emp_pm + $values["remarks_daily_att_sum"][8][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][8][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][8][$i]['all_present'];
                            $all_present_pm = $all_present_pm + $values["remarks_daily_att_sum"][8][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][8][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][8][$i]['all_absent'];
                            $all_absent_pm = $all_absent_pm + $values["remarks_daily_att_sum"][8][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][9][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][9][$i]['all_emp'];
                            $all_emp_sm = $all_emp_sm + $values["remarks_daily_att_sum"][9][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][9][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][9][$i]['all_present'];
                            $all_present_sm = $all_present_sm + $values["remarks_daily_att_sum"][9][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][9][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][9][$i]['all_absent'];
                            $all_absent_sm = $all_absent_sm + $values["remarks_daily_att_sum"][9][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][10][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][10][$i]['all_emp'];
                            $all_emp_fjf = $all_emp_fjf + $values["remarks_daily_att_sum"][10][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][10][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][10][$i]['all_present'];
                            $all_present_fjf = $all_present_fjf + $values["remarks_daily_att_sum"][10][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][10][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][10][$i]['all_absent'];
                            $all_absent_fjf = $all_absent_fjf + $values["remarks_daily_att_sum"][10][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][11][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][11][$i]['all_emp'];
                            $all_emp_jp = $all_emp_jp + $values["remarks_daily_att_sum"][11][$i]['all_emp'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][11][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][11][$i]['all_present'];
                            $all_present_jp = $all_present_jp + $values["remarks_daily_att_sum"][11][$i]['all_present'];
                            ;
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;background-color:#D5D5D5;'>";
                        if ($values["remarks_daily_att_sum"][11][$i] != "null") {
                            echo $values["remarks_daily_att_sum"][11][$i]['all_absent'];
                            $all_absent_jp = $all_absent_jp + $values["remarks_daily_att_sum"][11][$i]['all_absent'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_leave'];
                            $all_leave = $all_leave + $values["daily_att_sum"][$i]['all_leave'];
                        } else {
                            echo '--';
                        }
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        if ($values["daily_att_sum"][$i]) {
                            echo $values["daily_att_sum"][$i]['all_late'];
                            $all_late = $all_late + $values["daily_att_sum"][$i]['all_late'];
                        } else
                            echo '--';
                        echo "</td>";

                        echo "<td style='text-align:center;'>";
                        //echo '--';
                        echo "</td>";


                        echo "</tr>";
                    }
                    ?>
                    <tr style="font-weight:bold; text-align:center;">
                        <td colspan="2">Total</td>
                        <td><?php echo $all_emp; ?></td>
                        <td>
                            <?php
                            echo $all_present;
                            if ($all_present == 0) {
                                echo "<br> (0 %)";
                            } else {
                                $p_percent = round((($all_present * 100) / $all_emp), 2);
                                echo "<br> ($p_percent%)";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $all_absent;
                            if ($all_absent == 0) {
                                echo "<br> (0 %)";
                            } else {
                                $p_absent = round((($all_absent * 100) / $all_emp), 2);
                                echo "<br> ($p_absent%)";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $all_male;
                            if ($all_male == 0) {
                                echo "<br> (0 %)";
                            } else {
                                $p_male = round((($all_male * 100) / $all_emp), 2);
                                echo "<br> ($p_male%)";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $all_female;
                            if ($all_female == 0) {
                                echo "<br> (0 %)";
                            } else {
                                $p_female = round((($all_female * 100) / $all_emp), 2);
                                echo "<br> ($p_female%)";
                            }
                            ?>
                        </td>
                        <td style="background-color:#E5E5E5"><?php echo $all_emp_lc; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_lc; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_lc; ?></td>

                        <td style="background-color:#D5D5D5"><?php echo $all_emp_s; ?></td>
                        <td style="background-color:#D5D5D5"><?php echo $all_present_s; ?></td>
                        <td style="background-color:#D5D5D5"><?php echo $all_absent_s; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_op; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_op; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_op; ?></td>

                        <td style="background-color:#D5D5D5"><?php echo $all_emp_hl; ?></td>
                        <td style="background-color:#D5D5D5"><?php echo $all_present_hl; ?></td>
                        <td style="background-color:#D5D5D5"><?php echo $all_absent_hl; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_im; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_im; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_im; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_fqi; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_fqi; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_fqi; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_jim; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_jim; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_jim; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_imn; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_imn; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_imn; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_pm; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_pm; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_pm; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_sm; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_sm; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_sm; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_fjf; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_fjf; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_fjf; ?></td>

                        <td style="background-color:#E5E5E5"><?php echo $all_emp_jp; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_present_jp; ?></td>
                        <td style="background-color:#E5E5E5"><?php echo $all_absent_jp; ?></td>

                        <td>
                            <?php
                            echo $all_leave;
                            if ($all_leave == 0) {
                                echo "<br> (0 %)";
                            } else {
                                $p_leave = round((($all_leave * 100) / $all_emp), 2);
                                echo "<br> ($p_leave%)";
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $all_late;
                            if ($all_late == 0) {
                                echo "<br> (0 %)";
                            } else {
                                $p_late = round((($all_late * 100) / $all_emp), 2);
                                echo "<br> ($p_late%)";
                            }
                            ?>

                        </td>
                        <td> </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
