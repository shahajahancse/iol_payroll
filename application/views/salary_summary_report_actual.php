<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Actual Salary Summery Report</title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
        
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
        <script src="<?php echo base_url(); ?>js/jquery-1.8.0.min.js" type="text/javascript"></script>
    </head>
    <body>
        <?php //print_r($values); ?>
        <div style=" margin:0 auto;  width:auto;">
            <div id="no_print" style="float:right;"></div>
            <?php
            $data['unit_id'] = $unit_id;
            $this->load->view("head_english", $data);
            ?>
            <!--Report title goes here-->
            <div align="center" style=" margin:0 auto; overflow:hidden; font-family: 'Times New Roman', Times, serif;">
                    <div  style="font-size:13px; font-weight:bold; text-align:center; width:100%;">
                        <?php 
                            if($grid_status == 1)
                            { echo 'Reguler Employee '; }
                            elseif($grid_status == 2)
                            { echo 'New Employee '; }
                            elseif($grid_status == 3)
                            { echo 'Left Employee '; }
                            elseif($grid_status == 4)
                            { echo 'Resign Employee '; }
                            elseif($grid_status == 6)
                            { echo 'Promoted Employee '; }
                            ?>
                            Salary & wages Summary of  
                            <?php 
                            $date = $salary_month;
                            $year=trim(substr($date,0,4));
                            $month=trim(substr($date,5,2));
                            $date_format = date("F-Y", mktime(0, 0, 0, $month, 1, $year));
                            echo $date_format;
                    
                         ?>
                        
                    </div>
                    <br/>
                <table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:10px; text-align-last: center;">
                    <tr>
                        <th>Section</th>
                        <th>Line</th>
                        <th>Total MP</th>
                        <th>Cash MP</th>
                        <th>Bank MP</th>
                        <th>Gross  Salary</th>
                        <th>Payable Salary Amount</th>
                        <th>OT Hour</th>
                        <th>OT Amount</th>
                        <th>Attn Bonus</th>
                        <th>Due Pay Add</th>
                        <!-- <th style="width:40px;">Deduct_wout_stmp(Ad.De+Abs.De+Tax.De+Other.De)</th> -->
                        <th style="width:40px;">Salary Deduction</th>
                        <th>Stamp Deduct</th>
                        <th>Total Deduction</th>
                        <th>Bank TTl Amount</th>
                        <th>TTl Payable Amount (Without Stamp)</th>
                    </tr>

                    <?php

                    $gt_mp         = 0;
                    $gtcash_mp     = 0;
                    $gtbank_mp     = 0;
                    $gtgross       = 0;
                    $gtbasic       = 0;
                    $gthouse_r     = 0;
                    $gtmedical     = 0;
                    $gtfood        = 0;
                    $gttransport   = 0;
                    $gtsalary_amt  = 0;
                    $gtot_hour     = 0;
                    $gtot_amount   = 0;
                    $gteot_hour    = 0;
                    $gteot_amount  = 0;
                    $gtattn_bonus  = 0;
                    $gtattn_bonus_man  = 0;
                    $gtdeduct_without_stm = 0;
                    $gtstm_deduct = 0;
                    $gtcash_salary = 0;
                    $gtbank_salary = 0;
                    $gtdue_pay_amt = 0;
                    $gtall_deduct = 0;
                    $gtnet_salary  = 0;

                    foreach($values as $floor_arr){

                    $u_t_mp         = 0;
                    $u_tcash_mp     = 0;
                    $u_tbank_mp     = 0;
                    $u_tgross       = 0;
                    $u_tbasic       = 0;
                    $u_thouse_r     = 0;
                    $u_tmedical     = 0;
                    $u_tfood        = 0;
                    $u_ttransport   = 0;
                    $u_tsalary_amt  = 0;
                    $u_tot_hour     = 0;
                    $u_tot_amount   = 0;
                    $u_teot_hour    = 0;
                    $u_teot_amount  = 0;
                    $u_tattn_bonus  = 0;
                    $u_tattn_bonus_man = 0;
                    $u_tdeduct_without_stm = 0;
                    $u_tstm_deduct = 0;
                    $u_tcash_salary = 0;
                    $u_tbank_salary = 0;
                    $u_tdue_pay_amt = 0;
                    $u_tall_deduct = 0;
                    $u_tnet_salary  = 0;

                    ?>
                        <tr style="background-color: #cccfff;font-weight: bolder;">
                            <?php if($floor_arr['floor_name']=='none') { ?>
                            <td colspan="21" style="text-align: center; font-weight: bold;background-color: #fff;height: 70px;font-size: 13px;">
                            </td>
                            <?php } ?>
                        </tr>
                            
                            <?php if($floor_arr['floor_name']=='none') {?>

                            <tr style="background-color: #cccfff;font-weight: bolder;margin-top: 100px;">
                            <?php //if($floor_arr['floor_name']=='none') { ?>
                            <td colspan="21" style="text-align: center; font-weight: bold;background-color: #fff;height: 100px;font-size: 13px;">
                            <?php $this->load->view("head_english", $data);?>
                            <div  style="font-size:13px; font-weight:bold; text-align:center; width:100%;">
                                <?php 
                                    if($grid_status == 1)
                                    { echo 'Reguler Employee '; }
                                    elseif($grid_status == 2)
                                    { echo 'New Employee '; }
                                    elseif($grid_status == 3)
                                    { echo 'Left Employee '; }
                                    elseif($grid_status == 4)
                                    { echo 'Resign Employee '; }
                                    elseif($grid_status == 6)
                                    { echo 'Promoted Employee '; }
                                    ?>
                                    Salary & wages Summary of 
                                    <?php 
                                    $date = $salary_month;
                                    $year=trim(substr($date,0,4));
                                    $month=trim(substr($date,5,2));
                                    $date_format = date("F-Y", mktime(0, 0, 0, $month, 1, $year));
                                    echo $date_format;
                            
                                 ?>
                                
                            </div>
                            </td>
                            </tr>

                            <tr>
                                <th>Section</th>
                                <th>Line</th>
                                <th>Total MP</th>
                                <th>Cash MP</th>
                                <th>Bank MP</th>
                                <th>Gross  Salary</th>
                                <th>Payable Salary Amount</th>
                                <th>OT Hour</th>
                                <th>OT Amount</th>
                                <th>Attn Bonus</th>
                                <th>Due Pay Add</th>
                                <!-- <th style="width:40px;">Deduct_wout_stmp(Ad.De+Abs.De+Tax.De+Other.De)</th> -->
                                <th style="width:40px;">Salary Deduction</th>
                                <th>Smpt Deduct</th>
                                <th>Total Deduction</th>
                                <th>Bank TTl Amount</th>
                                <th>TTl Payable Amount (Without Stamp)</th>
                            </tr>

                    <?php } ?>


                    <tr style="background-color: #cccfff;font-weight: bolder;">
                        <td colspan="21" style="text-align-last: left; font-weight: bold;background-color: #cccfff;">
                           Worker For <?php echo $floor_arr['floor_name'];?>
                        </td>
                    </tr>
                        
                        <?php 
                        foreach($floor_arr['floor_info'] as $value) {
                            // print_r($value);
                            $s_t_mp         = 0;
                            $s_tcash_mp     = 0;
                            $s_tbank_mp     = 0;
                            $s_tgross       = 0;
                            $s_tbasic       = 0;
                            $s_thouse_r     = 0;
                            $s_tmedical     = 0;
                            $s_tfood        = 0;
                            $s_ttransport   = 0;
                            $s_tsalary_amt  = 0;
                            $s_tot_hour     = 0;
                            $s_tot_amount   = 0;
                            $s_teot_hour    = 0;
                            $s_teot_amount  = 0;
                            $s_tattn_bonus  = 0;
                            $s_tattn_bonus_man  = 0;
                            $s_tdeduct_without_stm = 0;
                            $s_tstm_deduct = 0;
                            $s_tcash_salary = 0;
                            $s_tbank_salary = 0;
                            $s_tdue_pay_amt = 0;
                            $s_tall_deduct = 0;
                            $s_tnet_salary  = 0;

                        ?>
                        <tr class="sec_<?=$value['sec_id']?>">
                            <!-- <td></td> -->
                            <!-- <td></td> -->
                            <td rowspan="<?=count($value['sec_info'])+1;?>" style="text-align-last: left;">
                                <?php 
                                    //echo "hi";
                                    echo $value['sec_name'];
                                ?>
                            </td>

                        </tr>
                            <?php
                            // echo $rowCount = count($value['sec_info'][]['line_info']['tEmp']);
                            foreach($value['sec_info'] as $val){
                            if ($val['line_info']['emp_cash_bank'] !=0){

                                
                                $gt_mp         = $gt_mp + $val['line_info']['emp_cash_bank'];
                                $gtcash_mp       = $gtcash_mp + $val['line_info']['emp_cash'];
                                $gtbank_mp       = $gtbank_mp + $val['line_info']['emp_bank'];
                                $gtgross         = $gtgross + $val['line_info']['tgross'];
                                /*$gtbasic         = $gtbasic + $val['line_info']['tbasic'];
                                $gthouse_r     = $gthouse_r + $val['line_info']['thouse_r'];
                                $gtmedical     = $gtmedical + $val['line_info']['tmedical_a'];
                                $gtfood   = $gtfood + $val['line_info']['tfood_a'];
                                $gttransport   = $gttransport + $val['line_info']['ttrans_a'];*/
                                $gtsalary_amt   = $gtsalary_amt + $val['line_info']['t_payable_amt'];
                                $gtot_hour   = $gtot_hour + $val['line_info']['tot_hour'];
                                $gtot_amount   = $gtot_amount + $val['line_info']['tot_amt'];
                                $gtattn_bonus   = $gtattn_bonus + $val['line_info']['t_bonus'];
                                $gtcash_salary   = $gtcash_salary + $val['line_info']['t_payable_amt_without_stm'];
                                $gtdeduct_without_stm = $gtdeduct_without_stm + $val['line_info']['tdeduct_without_stm'];
                                $gtstm_deduct = $gtstm_deduct + $val['line_info']['tstamp_deduct'];
                                $gtbank_salary   = $gtbank_salary + $val['line_info']['bank_sum_net_pay'];
                                $gtdue_pay_amt   = $gtdue_pay_amt + $val['line_info']['due_pay_add_bank'];
                                $gtall_deduct   = $gtall_deduct + $val['line_info']['total_deduct'];
                                $gtnet_salary   = $gtnet_salary + $val['line_info']['total_net_pay_with_stamp'];

                                $u_t_mp         = $u_t_mp + $val['line_info']['emp_cash_bank'];
                                $u_tcash_mp       = $u_tcash_mp + $val['line_info']['emp_cash'];
                                $u_tbank_mp       = $u_tbank_mp + $val['line_info']['emp_bank'];
                                $u_tgross         = $u_tgross + $val['line_info']['tgross'];
                                /*$u_tbasic         = $u_tbasic + $val['line_info']['tbasic'];
                                $u_thouse_r     = $u_thouse_r + $val['line_info']['thouse_r'];
                                $u_tmedical     = $u_tmedical + $val['line_info']['tmedical_a'];
                                $u_tfood   = $u_tfood + $val['line_info']['tfood_a'];
                                $u_ttransport   = $u_ttransport + $val['line_info']['ttrans_a'];*/
                                $u_tsalary_amt   = $u_tsalary_amt + $val['line_info']['t_payable_amt'];
                                $u_tot_hour   = $u_tot_hour + $val['line_info']['tot_hour'];
                                $u_tot_amount   = $u_tot_amount + $val['line_info']['tot_amt'];
                                $u_tattn_bonus   = $u_tattn_bonus + $val['line_info']['t_bonus'];
                                $u_tcash_salary   = $u_tcash_salary + $val['line_info']['t_payable_amt_without_stm'];
                                $u_tdeduct_without_stm = $u_tdeduct_without_stm + $val['line_info']['tdeduct_without_stm'];
                                $u_tstm_deduct = $u_tstm_deduct + $val['line_info']['tstamp_deduct'];
                                $u_tbank_salary   = $u_tbank_salary + $val['line_info']['bank_sum_net_pay'];
                                $u_tdue_pay_amt   = $u_tdue_pay_amt + $val['line_info']['due_pay_add_bank'];
                                $u_tall_deduct   = $u_tall_deduct + $val['line_info']['total_deduct'];
                                $u_tnet_salary   = $u_tnet_salary + $val['line_info']['total_net_pay_with_stamp'];

                                $s_t_mp         = $s_t_mp + $val['line_info']['emp_cash_bank'];
                                $s_tcash_mp       = $s_tcash_mp + $val['line_info']['emp_cash'];
                                $s_tbank_mp       = $s_tbank_mp + $val['line_info']['emp_bank'];
                                $s_tgross         = $s_tgross + $val['line_info']['tgross'];
                                /*$s_tbasic         = $s_tbasic + $val['line_info']['tbasic'];
                                $s_thouse_r     = $s_thouse_r + $val['line_info']['thouse_r'];
                                $s_tmedical     = $s_tmedical + $val['line_info']['tmedical_a'];
                                $s_tfood   = $s_tfood + $val['line_info']['tfood_a'];
                                $s_ttransport   = $s_ttransport + $val['line_info']['ttrans_a'];*/
                                $s_tsalary_amt   = $s_tsalary_amt + $val['line_info']['t_payable_amt'];
                                $s_tot_hour   = $s_tot_hour + $val['line_info']['tot_hour'];
                                $s_tot_amount   = $s_tot_amount + $val['line_info']['tot_amt'];
                                $s_tattn_bonus   = $s_tattn_bonus + $val['line_info']['t_bonus'];
                                $s_tcash_salary   = $s_tcash_salary + $val['line_info']['t_payable_amt_without_stm'];
                                $s_tdeduct_without_stm = $s_tdeduct_without_stm + $val['line_info']['tdeduct_without_stm'];
                                $s_tstm_deduct = $s_tstm_deduct + $val['line_info']['tstamp_deduct'];
                                $s_tbank_salary   = $s_tbank_salary + $val['line_info']['bank_sum_net_pay'];
                                $s_tdue_pay_amt   = $s_tdue_pay_amt + $val['line_info']['due_pay_add_bank'];
                                $s_tall_deduct   = $s_tall_deduct + $val['line_info']['total_deduct'];
                                $s_tnet_salary   = $s_tnet_salary + $val['line_info']['total_net_pay_with_stamp'];

                                ?>
                        <tr>
                            <td>
                                <?php 
                                    echo $val['line_name']=='None' || $val['line_name']=='none'?'':$val['line_name'];
                                ?>
                                
                            </td>
                            <td><?php echo $val['line_info']['emp_cash_bank'];?></td>
                            <td><?php echo $val['line_info']['emp_cash'];?></td>
                            <td><?php echo $val['line_info']['emp_bank'];?></td>
                            <td><?php echo $val['line_info']['tgross'];?></td>
                            <!-- <td><?php echo $val['line_info']['tbasic'];?></td>
                            <td><?php echo $val['line_info']['thouse_r'];?></td>
                            <td><?php echo $val['line_info']['tmedical_a'];?></td>
                            <td><?php echo $val['line_info']['tfood_a'];?></td>
                            <td><?php echo $val['line_info']['ttrans_a'];?></td> -->
                            <td><?php echo $val['line_info']['t_payable_amt'];?></td>
                            <td><?php echo $val['line_info']['tot_hour'];?></td>
                            <td><?php echo $val['line_info']['tot_amt'];?></td>
                            <td><?php echo $val['line_info']['t_bonus'];?></td>
                            <td><?php echo $val['line_info']['due_pay_add_bank'];?></td>
                            <td><?php echo $val['line_info']['tdeduct_without_stm'];?></td>
                            <td><?php echo $val['line_info']['tstamp_deduct'];?></td>
                            <td><?php echo $val['line_info']['total_deduct'];?></td>
                            <td><?php echo $val['line_info']['bank_sum_net_pay'];?></td>
                            <td><?php echo $val['line_info']['t_payable_amt_without_stm'];?></td>

                        </tr>
                    <?php } }
                        if($s_t_mp > 0) {
                            if($value['sec_name']=='Sewing')
                            {
                         ?>
                        <tr style="background-color: #fffccc;font-weight: bolder;">
                          <td colspan="2" style="background-color: #fffccc;"> Sec. Sub Total</td>

                            <td><?php echo $s_t_mp;?></td>
                            <td><?php echo $s_tcash_mp;?></td>
                            <td><?php echo $s_tbank_mp;?></td>
                            <td><?php echo $s_tgross; ?></td>
                            <!--<td><?php echo $s_tbasic; ?></td>
                            <td><?php echo $s_thouse_r; ?></td>
                            <td><?php echo $s_tmedical; ?></td>
                            <td><?php echo $s_tfood; ?></td>
                            <td><?php echo $s_ttransport; ?></td> -->
                            <td><?php echo $s_tsalary_amt; ?></td>
                            <td><?php echo $s_tot_hour; ?></td>
                            <td><?php echo $s_tot_amount; ?></td>
                            <td><?php echo $s_tattn_bonus; ?></td>
                            <td><?php echo $s_tdue_pay_amt; ?></td>
                            <td><?php echo $s_tdeduct_without_stm; ?></td>
                            <td><?php echo $s_tstm_deduct; ?></td>
                            <td><?php echo $s_tall_deduct; ?></td>
                            <td><?php echo $s_tbank_salary; ?></td>
                            <td><?php echo $s_tcash_salary; ?></td>

                        </tr>
                    <?php } }
                      else{ ?>
                        <script type="text/javascript">
                            $(".sec_<?=$value['sec_id']?>").hide();
                        </script>

                    <?php 
                        } } ?>
                        <tr style="background-color: #fffccc;font-weight: bolder;">
                            <td colspan="2" style="background-color: #fffccc;"> Sub Total for <?php echo $floor_arr['floor_name'];?></td>
                            <td><?php echo $u_t_mp;?></td>
                            <td><?php echo $u_tcash_mp;?></td>
                            <td><?php echo $u_tbank_mp;?></td>
                            <td><?php echo $u_tgross; ?></td>
                            <!--<td><?php echo $u_tbasic; ?></td>
                            <td><?php echo $u_thouse_r; ?></td>
                            <td><?php echo $u_tmedical; ?></td>
                            <td><?php echo $u_tfood; ?></td>
                            <td><?php echo $u_ttransport; ?></td> -->
                            <td><?php echo $u_tsalary_amt; ?></td>
                            <td><?php echo $u_tot_hour; ?></td>
                            <td><?php echo $u_tot_amount; ?></td>
                            <td><?php echo $u_tattn_bonus; ?></td>
                            <td><?php echo $u_tdue_pay_amt; ?></td>
                            <td><?php echo $u_tdeduct_without_stm; ?></td>
                            <td><?php echo $u_tstm_deduct; ?></td>
                            <td><?php echo $u_tall_deduct; ?></td>
                            <td><?php echo $u_tbank_salary; ?></td>
                            <td><?php echo $u_tcash_salary; ?></td>
                      </tr>
                        
                    <?php   } ?>
                    <tr style="background-color: #cccfff;font-weight: bolder;">
                        <td colspan="2">Grand Total</td>
                        <td><?php echo $gt_mp;?></td>
                        <td><?php echo $gtcash_mp;?></td>
                        <td><?php echo $gtbank_mp;?></td>
                        <td><?php echo $gtgross; ?></td>
                        <!-- <td><?php echo $gtbasic; ?></td>
                        <td><?php echo $gthouse_r; ?></td>
                        <td><?php echo $gtmedical; ?></td>
                        <td><?php echo $gtfood; ?></td>
                        <td><?php echo $gttransport; ?></td> -->
                        <td><?php echo $gtsalary_amt; ?></td>
                        <td><?php echo $gtot_hour; ?></td>
                        <td><?php echo $gtot_amount; ?></td>
                        <td><?php echo $gtattn_bonus; ?></td>
                        <td><?php echo $gtdue_pay_amt; ?></td>
                        <td><?php echo $gtdeduct_without_stm; ?></td>
                        <td><?php echo $gtstm_deduct; ?></td>
                        <td><?php echo $gtall_deduct; ?></td>
                        <td><?php echo $gtbank_salary; ?></td>
                        <td><?php echo $gtcash_salary; ?></td>

                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    function show_hide(argument){

    }
</script>
