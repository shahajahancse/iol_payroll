<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo 'Daily OT Summary'; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
        <script src="<?php echo base_url(); ?>js/jquery-1.8.0.min.js" type="text/javascript"></script>
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
                    <?php echo 'Daily OT Summary'; ?> of <?php echo $report_date; ?></span>
                <br />
                <br />
                <table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:10px; text-align-last: center;">
                    <tr>
                        <th rowspan="3">Section</th>
                        <th rowspan="3">Line</th>
                        <th rowspan="3">Total</th>
                    </tr>
                    <tr>
                        <td colspan="10" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">OT Hour</div></td>
                    </tr>
                    <tr>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">1 </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">2 </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">3 </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">4 </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">5 </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">6 </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">7 </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">8 </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">9 </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">10 </div></td>

                       <td rowspan="2" style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">G.Total Hour </div></td>
                       
                       <td rowspan="2" style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">ACT OT AMT </div></td>
                    </tr>

                    <?php
                    $t_tEmp = 0;
                    $t_one = 0;
                    $t_two = 0;
                    $t_three = 0;
                    $t_four = 0;
                    $t_five = 0;
                    $t_six = 0;
                    $t_seven = 0;
                    $t_eight = 0;
                    $t_nine   = 0;
                    $t_ten   = 0;
                    $t_others = 0;
                    $t_others_man = 0;
                    $Gtot_hour = 0;
                    $Gtot_amt = 0;
                    $t_others_amt = 0;



                    $t_Pstaff_P   = 0;
                    $t_Pstaff_A   = 0;
                    $t_Opr_P      = 0;
                    $t_Opr_A      = 0;
                    $t_Aopr_P     = 0;
                    $t_Aopr_A     = 0;
                    $t_LIrn_P     = 0;
                    $t_LIrn_A     = 0;
                    $t_FAsst_P    = 0;
                    $t_FAsst_A    = 0;
                    $t_JrIrn_P    = 0;
                    $t_JrIrn_A    = 0;
                    $t_Irn_P      = 0;
                    $t_Irn_A      = 0;
                    $t_Pman_P     = 0;
                    $t_Pman_A     = 0;
                    $t_Sman_P     = 0;
                    $t_Sman_A     = 0;
                    $t_Fman_P     = 0;
                    $t_Fman_A     = 0;
                    $t_Pkr_P      = 0;
                    $t_Pkr_A      = 0;
                    $t_Admin_4th_P = 0;
                    $t_Admin_4th_A = 0;
                    $t_Cman_P = 0;
                    $t_Cman_A = 0;
                    $t_Fusing_P = 0;
                    $t_Fusing_A = 0;
                    $t_Clener_P = 0;
                    $t_Clener_A = 0;
                    $t_Others_P = 0;
                    $t_Others_A = 0;

                    foreach($values as $floor_arr){
                        $u_tEmp = 0;
                        $u_one = 0;
                        $u_two = 0;
                        $u_three = 0;
                        $u_four = 0;
                        $u_five = 0;
                        $u_six = 0;
                        $u_seven = 0;
                        $u_eight = 0;
                        $u_nine   = 0;
                        $u_ten   = 0;
                        $u_others = 0;
                        $u_others_man = 0;
                        $u_Gtot_hour = 0;
                        $u_Gtot_amt = 0;
                        $u_t_others_amt = 0;
                        $u_preEmp = 0;
                        $u_absEmp = 0;
                        $u_wEmp = 0;
                        $u_lEmp = 0;
                        $u_tNew = 0;
                        $u_all_male = 0;
                        $u_all_female = 0;
                        $u_all_late = 0;
                        $t_Ostaff_P   = 0;
                        $u_Ostaff_A   = 0;
                        $u_Pstaff_P   = 0;
                        $u_Pstaff_A   = 0;
                        $u_Opr_P      = 0;
                        $u_Opr_A      = 0;
                        $u_Aopr_P     = 0;
                        $u_Aopr_A     = 0;
                        $u_LIrn_P     = 0;
                        $u_LIrn_A     = 0;
                        $u_FAsst_P    = 0;
                        $u_FAsst_A    = 0;
                        $u_JrIrn_P    = 0;
                        $u_JrIrn_A    = 0;
                        $u_Irn_P      = 0;
                        $u_Irn_A      = 0;
                        $u_Pman_P     = 0;
                        $u_Pman_A     = 0;
                        $u_Sman_P     = 0;
                        $u_Sman_A     = 0;
                        $u_Fman_P     = 0;
                        $u_Fman_A     = 0;
                        $u_Pkr_P      = 0;
                        $u_Pkr_A      = 0;
                        $u_Admin_4th_P = 0;
                        $u_Admin_4th_A = 0;
                        $u_Cman_P = 0;
                        $u_Cman_A = 0;
                        $u_Fusing_P = 0;
                        $u_Fusing_A = 0;
                        $u_Clener_P = 0;
                        $u_Clener_A = 0;
                        $u_Others_P = 0;
                        $u_Others_A = 0;
                        ?>
                        <?php 
                        foreach ($floor_arr['floor_info'] as $value) {
                            // print_r($value); exit;
                            $s_tEmp = 0;
                            $s_preEmp = 0;
                            $s_absEmp = 0;
                            $s_wEmp = 0;
                            $s_lEmp = 0;
                            $s_tNew = 0;
                            $s_all_male = 0;
                            $s_all_female = 0;
                            $s_all_late = 0;
                            
                            $s_Ostaff_P   = 0;
                            $s_Ostaff_A   = 0;
                            $s_Pstaff_P   = 0;
                            $s_Pstaff_A   = 0;
                            $s_Opr_P      = 0;
                            $s_Opr_A      = 0;
                            $s_Aopr_P     = 0;
                            $s_Aopr_A     = 0;
                            $s_LIrn_P     = 0;
                            $s_LIrn_A     = 0;
                            $s_FAsst_P    = 0;
                            $s_FAsst_A    = 0;
                            $s_JrIrn_P    = 0;
                            $s_JrIrn_A    = 0;
                            $s_Irn_P      = 0;
                            $s_Irn_A      = 0;
                            $s_Pman_P     = 0;
                            $s_Pman_A     = 0;
                            $s_Sman_P     = 0;
                            $s_Sman_A     = 0;
                            $s_Fman_P     = 0;
                            $s_Fman_A     = 0;
                            $s_Pkr_P      = 0;
                            $s_Pkr_A      = 0;
                            $s_Admin_4th_P = 0;
                            $s_Admin_4th_A = 0;
                            $s_Cman_P = 0;
                            $s_Cman_A = 0;
                            $s_Fusing_P = 0;
                            $s_Fusing_A = 0;
                            $s_Clener_P = 0;
                            $s_Clener_A = 0;
                            $s_Others_P = 0;
                            $s_Others_A = 0;
                        ?>
                        <tr class="sec_<?=$value['sec_id']?>">
                            <!-- <td></td> -->
                            <!-- <td></td> -->
                            <td rowspan="<?=count($value['sec_info'])+1;?>" style="text-align-last: left;">
                                <?php echo $value['sec_name'];
                                ?>
                            </td>
                        </tr>
                            <?php
                            // echo $rowCount = count($value['sec_info'][]['line_info']['tEmp']);
                            foreach($value['sec_info'] as $val){
                            if ($val['line_info']['tEmp'] !=0){

                                $one = $val['line_info']['one'] * 1;
                                $two = $val['line_info']['two'] * 2;
                                $three = $val['line_info']['three'] * 3;
                                $four = $val['line_info']['four'] * 4;
                                $five = $val['line_info']['five'] * 5;
                                $six = $val['line_info']['six'] * 6;
                                $seven = $val['line_info']['seven'] * 7;
                                $eight = $val['line_info']['eight'] * 8;
                                $nine = $val['line_info']['nine'] * 9;
                                $ten = $val['line_info']['ten'] * 10;

                                $tot_hour = $one + $two + $three + $four + $five + $six + $seven + $eight + $nine + $ten;

                                $line_total = $val['line_info']['one'] + $val['line_info']['two'] + $val['line_info']['three'] + $val['line_info']['four'] + $val['line_info']['five'] + $val['line_info']['six'] + $val['line_info']['seven'] + $val['line_info']['eight'] + $val['line_info']['nine'] + $val['line_info']['ten'];
                                
                                //$t_tEmp         = $t_tEmp + $val['line_info']['tEmp'];
                                $t_tEmp         = $t_tEmp + $line_total;
                                $t_preEmp       = $t_preEmp + $val['line_info']['preEmp'];
                                $t_absEmp       = $t_absEmp + $val['line_info']['absEmp'];
                                $t_lEmp         = $t_lEmp + $val['line_info']['lEmp'];
                                $t_tNew         = $t_tNew + $val['line_info']['tNew'];
                                $t_all_late     = $t_all_late + $val['line_info']['all_late'];
                                $t_all_male     = $t_all_male + $val['line_info']['all_male'];
                                $t_all_female   = $t_all_female + $val['line_info']['all_female'];

                                //$u_tEmp         = $u_tEmp + $val['line_info']['tEmp'];
                                $u_preEmp       = $u_preEmp + $val['line_info']['preEmp'];
                                $u_absEmp       = $u_absEmp + $val['line_info']['absEmp'];
                                $u_lEmp         = $u_lEmp + $val['line_info']['lEmp'];
                                $u_tNew         = $u_tNew + $val['line_info']['tNew'];
                                $u_all_late     = $u_all_late + $val['line_info']['all_late'];
                                $u_all_male     = $u_all_male + $val['line_info']['all_male'];
                                $u_all_female   = $u_all_female + $val['line_info']['all_female'];

                                $s_tEmp         = $s_tEmp + $val['line_info']['tEmp'];
                                $s_preEmp       = $s_preEmp + $val['line_info']['preEmp'];
                                $s_absEmp       = $s_absEmp + $val['line_info']['absEmp'];
                                $s_lEmp         = $s_lEmp + $val['line_info']['lEmp'];
                                $s_tNew         = $s_tNew + $val['line_info']['tNew'];
                                $s_all_late     = $s_all_late + $val['line_info']['all_late'];
                                $s_all_male     = $s_all_male + $val['line_info']['all_male'];
                                $s_all_female   = $s_all_female + $val['line_info']['all_female'];
                                // print_r($val);exit;
                                $t_one = $t_one + $val['line_info']['one'];
                                $t_two = $t_two + $val['line_info']['two'];
                                $t_three = $t_three + $val['line_info']['three'];
                                $t_four = $t_four + $val['line_info']['four'];
                                $t_five = $t_five + $val['line_info']['five'];
                                $t_six = $t_six + $val['line_info']['six'];
                                $t_seven = $t_seven + $val['line_info']['seven'];

                                $t_eight  = $t_eight + $val['line_info']['eight'];
                                $t_nine   = $t_nine + $val['line_info']['nine'];
                                $t_ten    = $t_ten + $val['line_info']['ten'];

                                $t_others_man = $t_others_man + $val['line_info']['others'];
                                $t_others = $t_others + $val['line_info']['other_ot_hour'];
                                $t_others_amt = $t_others_amt + $val['line_info']['other_amt'];
                                $Gtot_hour = $Gtot_hour + $tot_hour;
                                $Gtot_amt = $Gtot_amt + round($val['line_info']['ot_amt'],0);

                                $u_tEmp = $u_tEmp + $line_total;
                                $u_one = $u_one + $val['line_info']['one'];
                                $u_two = $u_two + $val['line_info']['two'];
                                $u_three = $u_three + $val['line_info']['three'];
                                $u_four = $u_four + $val['line_info']['four'];
                                $u_five = $u_five + $val['line_info']['five'];
                                $u_six = $u_six + $val['line_info']['six'];
                                $u_seven = $u_seven + $val['line_info']['seven'];

                                $u_eight  = $u_eight + $val['line_info']['eight'];
                                $u_nine   = $u_nine + $val['line_info']['nine'];
                                $u_ten    = $u_ten + $val['line_info']['ten'];

                                $u_Gtot_hour = $u_Gtot_hour + $tot_hour;
                                $u_Gtot_amt = $u_Gtot_amt + round($val['line_info']['ot_amt'],0);
                                
                                ?>
                        <tr>

                        <?php 
                            

                        ?>
                            <td>
                                <?php 
                                    echo $val['line_name']=='None' || $val['line_name']=='none'?'':$val['line_name'];
                                ?>
                                
                            </td>
                            <!-- <td><?php echo $val['line_info']['tEmp'];?></td> -->
                            <td><?php echo  $line_total; ?></td>
                            <td><?php echo $val['line_info']['one'];?></td>
                            <td><?php echo $val['line_info']['two'];?></td>
                            <td><?php echo $val['line_info']['three'];?></td>
                            <td><?php echo $val['line_info']['four'];?></td>
                            <td><?php echo $val['line_info']['five'];?></td>
                            <td><?php echo $val['line_info']['six'];?></td>
                            <td><?php echo $val['line_info']['seven'];?></td>
                            <td><?php echo $val['line_info']['eight'];?></td>
                            <td><?php echo $val['line_info']['nine'];?></td>
                            <td><?php echo $val['line_info']['ten'];?></td>

                            <td><?php echo $tot_hour;?></td>
                            <td><?php echo round($val['line_info']['ot_amt'],0);?></td>

                        </tr>
                    <?php } }
                        if($s_tEmp > 0) {
                            if($value['sec_name']=='Sewing')
                            {
                         ?>
                    <?php } }else{ ?>
                        <script type="text/javascript">
                            $(".sec_<?=$value['sec_id']?>").hide();
                        </script>

                    <?php }
                } ?>

               <tr style="background-color:#C0C0C0;font-weight: bolder;">
                       <td colspan="2"> Unit SubTotal For <?php echo $floor_arr['floor_name'];?></td>
                       <td><?php echo $u_tEmp;?></td>
                       <td><?php echo $u_one; ?></td>
                       <td><?php echo $u_two; ?></td>
                       <td><?php echo $u_three; ?></td>
                       <td><?php echo $u_four; ?></td>
                       <td><?php echo $u_five; ?></td>
                       <td><?php echo $u_six; ?></td>
                       <td><?php echo $u_seven; ?></td>
                       <td><?php echo $u_eight; ?></td>
                       <td><?php echo $u_nine; ?></td>
                       <td><?php echo $u_ten; ?></td>
                       <td><?php echo $u_Gtot_hour;?></td>
                       <td><?php echo round($u_Gtot_amt,0); ?></td>
               </tr>

            <?php } ?>
                    <tr style="background-color:#C0C0C0;font-weight: bolder;">
                        <td colspan="2"> Grand Total</td>
                        <td><?php echo $t_tEmp;?></td>
                        <td><?php echo $t_one; ?></td>
                        <td><?php echo $t_two; ?></td>
                        <td><?php echo $t_three; ?></td>
                        <td><?php echo $t_four; ?></td>
                        <td><?php echo $t_five; ?></td>
                        <td><?php echo $t_six; ?></td>
                        <td><?php echo $t_seven; ?></td>
                        <td><?php echo $t_eight; ?></td>
                        <td><?php echo $t_nine; ?></td>
                        <td><?php echo $t_ten; ?></td>
                        <td><?php echo $Gtot_hour;?></td>
                        <td><?php echo round($Gtot_amt,0); ?></td>
                    </tr>
                    <!-- <tr style="background-color:#808080;font-weight: bolder;">
                        <td colspan="2">Others</td>
                        <td><?php echo $t_others_man + $t_tEmp; ?></td>
                        <td><?php echo $t_others + $t_one; ?></td>
                        <td><?php echo $t_others + $t_two; ?></td>
                        <td><?php echo $t_others + $t_three; ?></td>
                        <td><?php echo $t_others + $t_four; ?></td>
                        <td><?php echo $t_others + $t_five; ?></td>
                        <td><?php echo $t_others + $t_six; ?></td>
                        <td><?php echo $t_others + $t_seven; ?></td>
                        <td><?php echo $t_others + $t_eight; ?></td>
                        <td><?php echo $t_others + $t_nine; ?></td>
                        <td><?php echo $t_others + $t_ten; ?></td>
                        <td><?php echo $t_others + $Gtot_hour; ?></td>
                        <td><?php echo $t_others_amt + round($Gtot_amt,0); ?></td>
                    </tr> -->
                </table>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    function show_hide(argument){

    }
</script>
