<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title><?php echo $title; ?></title>
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
                    <?php echo $title; ?> of <?php echo $report_date; ?></span>
                <br />
                <br />
                <table class="sal" border="1" cellpadding="0" cellspacing="0" align="center" style="font-size:10px; text-align-last: center;">
                    <tr>
                        <!-- <th>SL</th> -->
                        <!-- <th rowspan="3">Unit</th> -->
                        <th rowspan="3">Section</th>
                        <th rowspan="3">Line</th>
                        <th rowspan="3">str.</th>
                        <th rowspan="3">Total</th>
                        <th rowspan="3">Bal.</th>
                        <th rowspan="3">Present</th>
                        <th rowspan="3">Absent</th>
                        <th rowspan="3">Leave</th>
                        <th rowspan="3">New</th>
                        <!-- <th>Late</th> -->
                        <th rowspan="3">Male</th>
                        <th rowspan="3">Female</th>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Office Staff</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#D5D5D5;"><div align="center">PD Staff</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Operator</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#D5D5D5;"><div align="center">Asst.Operator</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Line Iron Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Finishing Assistant</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Jr. Iron Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Iron Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Poly Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Spot Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Folding Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Packer</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Quality.Insp</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Admin 4th Class</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Cutting</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Fusing</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Clener</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Input Man</div></td>
                        <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Others</div></td>

                    </tr>
                    <tr>
                        <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                        <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                        <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td> 
                        
                         <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                        
                         <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                        <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                    </tr>
                    <?php
                    $t_tEmp = 0;
                    $t_str = 0;
                    $t_str_bal = 0; 
                    $t_preEmp = 0;
                    $t_absEmp = 0;
                    $t_wEmp = 0;
                    $t_lEmp = 0;
                    $t_tNew = 0;
                    $t_all_male = 0;
                    $t_all_female = 0;
                    $t_all_late = 0;

                    $t_Ostaff_P   = 0;
                    $t_Ostaff_A   = 0;
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
                    $t_Quinsp_P   = 0;
                    $t_Quinsp_A    = 0;
                    $t_Admin_4th_P = 0;
                    $t_Admin_4th_A = 0;
                    $t_Cman_P = 0;
                    $t_Cman_A = 0;
                    $t_Fusing_P = 0;
                    $t_Fusing_A = 0;
                    $t_Clener_P = 0;
                    $t_Clener_A = 0;
                    $t_input_man_P = 0;
                    $t_input_man_A = 0;
                    $t_Others_P = 0;
                    $t_Others_A = 0;

                    foreach ($values as $floor_arr){
                        $u_tEmp = 0;
                        $u_str = 0;
                        $u_str_bal = 0; 
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
                        $u_Quinsp_P   = 0;
                    	$u_Quinsp_A    = 0;
                        $u_Admin_4th_P = 0;
                        $u_Admin_4th_A = 0;
                        $u_Cman_P = 0;
                        $u_Cman_A = 0;
                        $u_Fusing_P = 0;
                        $u_Fusing_A = 0;
                        $u_Clener_P = 0;
                        $u_Clener_A = 0;
                        $u_input_man_P = 0;
                        $u_input_man_A = 0;
                        $u_Others_P = 0;
                        $u_Others_A = 0;
                        ?>
                        <tr style="background-color: #cccfff;font-weight: bolder;">
                            <?php if($floor_arr['floor_name']=='none') { ?>
                            <td colspan="49" style="text-align: center; font-weight: bold;background-color: #fff;height: 70px;font-size: 13px;">
                            </td>
                            <?php } ?>
                        </tr>
                            
                            <?php if($floor_arr['floor_name']=='none') {?>

                            <tr style="background-color: #cccfff;font-weight: bolder;margin-top: 100px;">
                            <?php //if($floor_arr['floor_name']=='none') { ?>
                            <td colspan="49" style="text-align: center; font-weight: bold;background-color: #fff;height: 100px;font-size: 13px;">
                            <?php $this->load->view("head_english", $data);?>
                            <?php echo $title; ?> of <?php echo $report_date; ?>
                            </td>
                            </tr>

                            <tr>
                            <!-- <th>SL</th> -->
                            <!-- <th rowspan="3">Unit</th> -->
                            <th rowspan="3">Section</th>
                            <th rowspan="3" style="width: 35px;">Line</th>
                            <th rowspan="3">str.</th>
                            <th rowspan="3">Total</th>
                            <th rowspan="3">Bal.</th>
                            <th rowspan="3">Present</th>
                            <th rowspan="3">Absent</th>
                            <th rowspan="3">Leave</th>
                            <th rowspan="3">New</th>
                            <!-- <th>Late</th> -->
                            <th rowspan="3">Male</th>
                            <th rowspan="3">Female</th>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Office Staff</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#D5D5D5;"><div align="center">PD Staff</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Operator</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#D5D5D5;"><div align="center">Asst.Operator</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Line Iron Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Finishing Assistant</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Jr. Iron Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Iron Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Poly Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Spot Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Folding Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Packer</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Quality.Insp</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Admin 4th Class</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Cutting</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Fusing</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Clener</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Input Man</div></td>
                            <td colspan="2" style="font-weight:bold; background-color:#E5E5E5;"><div align="center">Others</div></td>

                        </tr>
                        <tr>
                            <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                            <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#E5E5E5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td> 
                            
                             <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                            
                             <!-- <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">TT </div></td> -->
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>

                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">PR </div></td>
                            <td style="font-weight:bold; background-color:#D5D5D5; padding:5px;"><div align="center">AB </div></td>
                        </tr>

                            <?php } ?>


                        <tr style="background-color: #cccfff;font-weight: bolder;">
                            <td colspan="49" style="text-align-last: left; font-weight: bold;background-color: #cccfff;">
                               Worker For <?php echo $floor_arr['floor_name'];?>
                            </td>
                        </tr>
                        
                        <?php 
                        foreach ($floor_arr['floor_info'] as $value) {
                            // print_r($value); exit;
                            $s_tEmp = 0;
                            $s_str = 0;
                            $s_str_bal = 0; 
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
                            $s_Quinsp_P   = 0;
                            $s_Quinsp_A    = 0;
                            $s_Admin_4th_P = 0;
                            $s_Admin_4th_A = 0;
                            $s_Cman_P = 0;
                            $s_Cman_A = 0;
                            $s_Fusing_P = 0;
                            $s_Fusing_A = 0;
                            $s_Clener_P = 0;
                            $s_Clener_A = 0;
                            $s_input_man_P = 0;
                            $s_input_man_A = 0;
                            $s_Others_P = 0;
                            $s_Others_A = 0;
                        ?>
                        <tr class="sec_<?=$value['sec_id']?>">
                            <!-- <td></td> -->
                            <!-- <td></td> -->
                            <td rowspan="<?=count($value['sec_info'])+1;?>" style="text-align-last: left;">
                                <?php 
                                    echo $value['sec_name'];
                                ?>
                            </td>
                        </tr>
                            <?php
                            // echo $rowCount = count($value['sec_info'][]['line_info']['tEmp']);
                            foreach($value['sec_info'] as $val){
                            if ($val['line_info']['tEmp'] !=0){

                                if($floor_arr['floor_name']=='none'){
                                       $tstrng = $value['str_staff'] + $val['strength'];
                                        //echo $tstrng = $s_tstrng + $val['strength'];
                                        $bal = $tstrng - $val['line_info']['tEmp'];
                                    }else{
                                        $tstrng = $value['strength'] + $val['strength'];
                                        //echo $tstrng = $s_tstrng + $val['strength'];
                                        $bal = $tstrng - $val['line_info']['tEmp'];
                                    }
                                
                                $t_tEmp         = $t_tEmp + $val['line_info']['tEmp'];
                                $t_str         = $t_str + $tstrng;
                                $t_str_bal     = $t_str_bal + $bal;
                                $t_preEmp       = $t_preEmp + $val['line_info']['preEmp'];
                                $t_absEmp       = $t_absEmp + $val['line_info']['absEmp'];
                                $t_lEmp         = $t_lEmp + $val['line_info']['lEmp'];
                                $t_tNew         = $t_tNew + $val['line_info']['tNew'];
                                $t_all_late     = $t_all_late + $val['line_info']['all_late'];
                                $t_all_male     = $t_all_male + $val['line_info']['all_male'];
                                $t_all_female   = $t_all_female + $val['line_info']['all_female'];

                                $u_tEmp         = $u_tEmp + $val['line_info']['tEmp'];
                                $u_str         = $u_str + $tstrng;
                                $u_str_bal     = $u_str_bal + $bal;
                                $u_preEmp       = $u_preEmp + $val['line_info']['preEmp'];
                                $u_absEmp       = $u_absEmp + $val['line_info']['absEmp'];
                                $u_lEmp         = $u_lEmp + $val['line_info']['lEmp'];
                                $u_tNew         = $u_tNew + $val['line_info']['tNew'];
                                $u_all_late     = $u_all_late + $val['line_info']['all_late'];
                                $u_all_male     = $u_all_male + $val['line_info']['all_male'];
                                $u_all_female   = $u_all_female + $val['line_info']['all_female'];

                                $s_tEmp         = $s_tEmp + $val['line_info']['tEmp'];
                                $s_str          = $s_str + $tstrng;
                                $s_str_bal     = $s_str_bal + $bal;
                                $s_preEmp       = $s_preEmp + $val['line_info']['preEmp'];
                                $s_absEmp       = $s_absEmp + $val['line_info']['absEmp'];
                                $s_lEmp         = $s_lEmp + $val['line_info']['lEmp'];
                                $s_tNew         = $s_tNew + $val['line_info']['tNew'];
                                $s_all_late     = $s_all_late + $val['line_info']['all_late'];
                                $s_all_male     = $s_all_male + $val['line_info']['all_male'];
                                $s_all_female   = $s_all_female + $val['line_info']['all_female'];
                                // print_r($val);exit;
                                ?>
                        <tr>
                            <td>
                                <?php 
                                    echo $val['line_name']=='None' || $val['line_name']=='none'?'':$val['line_name'];
                                ?>
                                
                            </td>
                            <td>
                                <?php 
                                  if($floor_arr['floor_name']=='none'){
                                        echo $tstrng;
                                    }else{
                                        echo $tstrng;
                                    }
                                ?>
                            </td>
                            <td style="height: 20px;"><?php echo $val['line_info']['tEmp'];?></td>
                            <td><?php echo $bal;?></td>
                            <td><?php echo $val['line_info']['preEmp'];?></td>
                            <td><?php echo $val['line_info']['absEmp'];?></td>
                            <td><?php echo $val['line_info']['lEmp'];?></td>
                            <td><?php echo $val['line_info']['tNew'];?></td>
                            <!-- <td><?php echo $val['line_info']['all_late'];?></td> -->
                            <td><?php echo $val['line_info']['all_male'];?></td>
                            <td><?php echo $val['line_info']['all_female'];?></td>

                            <td><?php echo ($val['line_info_detil'][0] == 'null') ? '--' : $val['line_info_detil'][0]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][0] == 'null') ? '--' : $val['line_info_detil'][0]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][1] == 'null') ? '--' : $val['line_info_detil'][1]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][1] == 'null') ? '--' : $val['line_info_detil'][1]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][2] == 'null') ? '--' : $val['line_info_detil'][2]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][2] == 'null') ? '--' : $val['line_info_detil'][2]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][3] == 'null') ? '--' : $val['line_info_detil'][3]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][3] == 'null') ? '--' : $val['line_info_detil'][3]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][4] == 'null') ? '--' : $val['line_info_detil'][4]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][4] == 'null') ? '--' : $val['line_info_detil'][4]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][5] == 'null') ? '--' : $val['line_info_detil'][5]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][5] == 'null') ? '--' : $val['line_info_detil'][5]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][6] == 'null') ? '--' : $val['line_info_detil'][6]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][6] == 'null') ? '--' : $val['line_info_detil'][6]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][7] == 'null') ? '--' : $val['line_info_detil'][7]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][7] == 'null') ? '--' : $val['line_info_detil'][7]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][8] == 'null') ? '--' : $val['line_info_detil'][8]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][8] == 'null') ? '--' : $val['line_info_detil'][8]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][9] == 'null') ? '--' : $val['line_info_detil'][9]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][9] == 'null') ? '--' : $val['line_info_detil'][9]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][10] == 'null') ? '--' : $val['line_info_detil'][10]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][10] == 'null') ? '--' : $val['line_info_detil'][10]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][11] == 'null') ? '--' : $val['line_info_detil'][11]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][11] == 'null') ? '--' : $val['line_info_detil'][11]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][12] == 'null') ? '--' : $val['line_info_detil'][12]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][12] == 'null') ? '--' : $val['line_info_detil'][12]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][13] == 'null') ? '--' : $val['line_info_detil'][13]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][13] == 'null') ? '--' : $val['line_info_detil'][13]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][14] == 'null') ? '--' : $val['line_info_detil'][14]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][14] == 'null') ? '--' : $val['line_info_detil'][14]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][15] == 'null') ? '--' : $val['line_info_detil'][15]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][15] == 'null') ? '--' : $val['line_info_detil'][15]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][16] == 'null') ? '--' : $val['line_info_detil'][16]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][16] == 'null') ? '--' : $val['line_info_detil'][16]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][17] == 'null') ? '--' : $val['line_info_detil'][17]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][17] == 'null') ? '--' : $val['line_info_detil'][17]['absEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][18] == 'null') ? '--' : $val['line_info_detil'][18]['preEmp'];?></td>
                            <td><?php echo ($val['line_info_detil'][18] == 'null') ? '--' : $val['line_info_detil'][18]['absEmp'];?></td>


            <?php
            $val['line_info_detil'][0] == 'null' ? '' : $s_Ostaff_P   = $s_Ostaff_P   + $val['line_info_detil'][0]['preEmp'];
            $val['line_info_detil'][0] == 'null' ? '' : $s_Ostaff_A   = $s_Ostaff_A   + $val['line_info_detil'][0]['absEmp'];
            $val['line_info_detil'][1] == 'null' ? '' : $s_Pstaff_P   = $s_Pstaff_P   + $val['line_info_detil'][1]['preEmp'];
            $val['line_info_detil'][1] == 'null' ? '' : $s_Pstaff_A   = $s_Pstaff_A   + $val['line_info_detil'][1]['absEmp'];
            $val['line_info_detil'][2] == 'null' ? '' : $s_Opr_P      = $s_Opr_P      + $val['line_info_detil'][2]['preEmp'];
            $val['line_info_detil'][2] == 'null' ? '' : $s_Opr_A      = $s_Opr_A      + $val['line_info_detil'][2]['absEmp'];
            $val['line_info_detil'][3] == 'null' ? '' : $s_Aopr_P     = $s_Aopr_P     + $val['line_info_detil'][3]['preEmp'];
            $val['line_info_detil'][3] == 'null' ? '' : $s_Aopr_A     = $s_Aopr_A     + $val['line_info_detil'][3]['absEmp'];
            $val['line_info_detil'][4] == 'null' ? '' : $s_LIrn_P     = $s_LIrn_P     + $val['line_info_detil'][4]['preEmp'];
            $val['line_info_detil'][4] == 'null' ? '' : $s_LIrn_A     = $s_LIrn_A     + $val['line_info_detil'][4]['absEmp'];
            $val['line_info_detil'][5] == 'null' ? '' : $s_FAsst_P    = $s_FAsst_P    + $val['line_info_detil'][5]['preEmp'];
            $val['line_info_detil'][5] == 'null' ? '' : $s_FAsst_A    = $s_FAsst_A    + $val['line_info_detil'][5]['absEmp'];
            $val['line_info_detil'][6] == 'null' ? '' : $s_JrIrn_P    = $s_JrIrn_P    + $val['line_info_detil'][8]['preEmp'];
            $val['line_info_detil'][6] == 'null' ? '' : $s_JrIrn_A    = $s_JrIrn_A    + $val['line_info_detil'][8]['absEmp'];
            $val['line_info_detil'][7] == 'null' ? '' : $s_Irn_P      = $s_Irn_P      + $val['line_info_detil'][7]['preEmp'];
            $val['line_info_detil'][7] == 'null' ? '' : $s_Irn_A      = $s_Irn_A      + $val['line_info_detil'][7]['absEmp'];
            $val['line_info_detil'][8] == 'null' ? '' : $s_Pman_P     = $s_Pman_P     + $val['line_info_detil'][8]['preEmp'];
            $val['line_info_detil'][8] == 'null' ? '' : $s_Pman_A     = $s_Pman_A     + $val['line_info_detil'][8]['absEmp'];
            $val['line_info_detil'][9] == 'null' ? '' : $s_Sman_P     = $s_Sman_P     + $val['line_info_detil'][9]['preEmp'];
            $val['line_info_detil'][9] == 'null' ? '' : $s_Sman_A     = $s_Sman_A     + $val['line_info_detil'][9]['absEmp'];
            $val['line_info_detil'][10] == 'null' ? '' : $s_Fman_P    = $s_Fman_P     + $val['line_info_detil'][10]['preEmp'];
            $val['line_info_detil'][10] == 'null' ? '' : $s_Fman_A    = $s_Fman_A     + $val['line_info_detil'][10]['absEmp'];
            $val['line_info_detil'][11] == 'null' ? '' : $s_Pkr_P     = $s_Pkr_P      + $val['line_info_detil'][11]['preEmp'];
            $val['line_info_detil'][11] == 'null' ? '' : $s_Pkr_A     = $s_Pkr_A      + $val['line_info_detil'][11]['absEmp'];

            $val['line_info_detil'][12] == 'null' ? '' : $s_Quinsp_P     = $s_Quinsp_P + $val['line_info_detil'][12]['preEmp'];
            $val['line_info_detil'][12] == 'null' ? '' : $s_Quinsp_A     = $s_Quinsp_A + $val['line_info_detil'][12]['absEmp'];

            $val['line_info_detil'][13] == 'null' ? '' : $s_Admin_4th_P     = $s_Admin_4th_P + $val['line_info_detil'][13]['preEmp'];
            $val['line_info_detil'][13] == 'null' ? '' : $s_Admin_4th_A     = $s_Admin_4th_A + $val['line_info_detil'][13]['absEmp'];

            $val['line_info_detil'][14] == 'null' ? '' : $s_Cman_P     = $s_Cman_P + $val['line_info_detil'][14]['preEmp'];
            $val['line_info_detil'][14] == 'null' ? '' : $s_Cman_A     = $s_Cman_A + $val['line_info_detil'][14]['absEmp'];

            $val['line_info_detil'][15] == 'null' ? '' : $s_Fusing_P     = $s_Fusing_P + $val['line_info_detil'][15]['preEmp'];
            $val['line_info_detil'][15] == 'null' ? '' : $s_Fusing_A     = $s_Fusing_A + $val['line_info_detil'][15]['absEmp'];

            $val['line_info_detil'][16] == 'null' ? '' : $s_Clener_P     = $s_Clener_P + $val['line_info_detil'][16]['preEmp'];
            $val['line_info_detil'][16] == 'null' ? '' : $s_Clener_A     = $s_Clener_A + $val['line_info_detil'][16]['absEmp'];

            $val['line_info_detil'][17] == 'null' ? '' : $s_input_man_P     = $s_input_man_P + $val['line_info_detil'][17]['preEmp'];
            $val['line_info_detil'][17] == 'null' ? '' : $s_input_man_A     = $s_input_man_A + $val['line_info_detil'][17]['absEmp'];

            $val['line_info_detil'][18] == 'null' ? '' : $s_Others_P     = $s_Others_P + $val['line_info_detil'][18]['preEmp'];
            $val['line_info_detil'][18] == 'null' ? '' : $s_Others_A     = $s_Others_A + $val['line_info_detil'][18]['absEmp'];

            $val['line_info_detil'][0] == 'null' ? '' : $u_Ostaff_P   = $u_Ostaff_P   + $val['line_info_detil'][0]['preEmp'];
            $val['line_info_detil'][0] == 'null' ? '' : $u_Ostaff_A   = $u_Ostaff_A   + $val['line_info_detil'][0]['absEmp'];
            $val['line_info_detil'][1] == 'null' ? '' : $u_Pstaff_P   = $u_Pstaff_P   + $val['line_info_detil'][1]['preEmp'];
            $val['line_info_detil'][1] == 'null' ? '' : $u_Pstaff_A   = $u_Pstaff_A   + $val['line_info_detil'][1]['absEmp'];
            $val['line_info_detil'][2] == 'null' ? '' : $u_Opr_P      = $u_Opr_P      + $val['line_info_detil'][2]['preEmp'];
            $val['line_info_detil'][2] == 'null' ? '' : $u_Opr_A      = $u_Opr_A      + $val['line_info_detil'][2]['absEmp'];
            $val['line_info_detil'][3] == 'null' ? '' : $u_Aopr_P     = $u_Aopr_P     + $val['line_info_detil'][3]['preEmp'];
            $val['line_info_detil'][3] == 'null' ? '' : $u_Aopr_A     = $u_Aopr_A     + $val['line_info_detil'][3]['absEmp'];
            $val['line_info_detil'][4] == 'null' ? '' : $u_LIrn_P     = $u_LIrn_P     + $val['line_info_detil'][4]['preEmp'];
            $val['line_info_detil'][4] == 'null' ? '' : $u_LIrn_A     = $u_LIrn_A     + $val['line_info_detil'][4]['absEmp'];
            $val['line_info_detil'][5] == 'null' ? '' : $u_FAsst_P    = $u_FAsst_P    + $val['line_info_detil'][5]['preEmp'];
            $val['line_info_detil'][5] == 'null' ? '' : $u_FAsst_A    = $u_FAsst_A    + $val['line_info_detil'][5]['absEmp'];
            $val['line_info_detil'][6] == 'null' ? '' : $u_JrIrn_P    = $u_JrIrn_P    + $val['line_info_detil'][8]['preEmp'];
            $val['line_info_detil'][6] == 'null' ? '' : $u_JrIrn_A    = $u_JrIrn_A    + $val['line_info_detil'][8]['absEmp'];
            $val['line_info_detil'][7] == 'null' ? '' : $u_Irn_P      = $u_Irn_P      + $val['line_info_detil'][7]['preEmp'];
            $val['line_info_detil'][7] == 'null' ? '' : $u_Irn_A      = $u_Irn_A      + $val['line_info_detil'][7]['absEmp'];
            $val['line_info_detil'][8] == 'null' ? '' : $u_Pman_P     = $u_Pman_P     + $val['line_info_detil'][8]['preEmp'];
            $val['line_info_detil'][8] == 'null' ? '' : $u_Pman_A     = $u_Pman_A     + $val['line_info_detil'][8]['absEmp'];
            $val['line_info_detil'][9] == 'null' ? '' : $u_Sman_P     = $u_Sman_P     + $val['line_info_detil'][9]['preEmp'];
            $val['line_info_detil'][9] == 'null' ? '' : $u_Sman_A     = $u_Sman_A     + $val['line_info_detil'][9]['absEmp'];
            $val['line_info_detil'][10] == 'null' ? '' : $u_Fman_P    = $u_Fman_P     + $val['line_info_detil'][10]['preEmp'];
            $val['line_info_detil'][10] == 'null' ? '' : $u_Fman_A    = $u_Fman_A     + $val['line_info_detil'][10]['absEmp'];
            $val['line_info_detil'][11] == 'null' ? '' : $u_Pkr_P     = $u_Pkr_P      + $val['line_info_detil'][11]['preEmp'];
            $val['line_info_detil'][11] == 'null' ? '' : $u_Pkr_A     = $u_Pkr_A      + $val['line_info_detil'][11]['absEmp'];

            $val['line_info_detil'][12] == 'null' ? '' : $u_Quinsp_P     = $u_Quinsp_P + $val['line_info_detil'][12]['preEmp'];
            $val['line_info_detil'][12] == 'null' ? '' : $u_Quinsp_A     = $u_Quinsp_A + $val['line_info_detil'][12]['absEmp'];

            $val['line_info_detil'][13] == 'null' ? '' : $u_Admin_4th_P     = $u_Admin_4th_P + $val['line_info_detil'][13]['preEmp'];
            $val['line_info_detil'][13] == 'null' ? '' : $u_Admin_4th_A     = $u_Admin_4th_A + $val['line_info_detil'][13]['absEmp'];

            $val['line_info_detil'][14] == 'null' ? '' : $u_Cman_P     = $u_Cman_P + $val['line_info_detil'][14]['preEmp'];
            $val['line_info_detil'][14] == 'null' ? '' : $u_Cman_A     = $u_Cman_A + $val['line_info_detil'][14]['absEmp'];

            $val['line_info_detil'][15] == 'null' ? '' : $u_Fusing_P     = $u_Fusing_P + $val['line_info_detil'][15]['preEmp'];
            $val['line_info_detil'][15] == 'null' ? '' : $u_Fusing_A     = $u_Fusing_A + $val['line_info_detil'][15]['absEmp'];

            $val['line_info_detil'][16] == 'null' ? '' : $u_Clener_P     = $u_Clener_P + $val['line_info_detil'][16]['preEmp'];
            $val['line_info_detil'][16] == 'null' ? '' : $u_Clener_A     = $u_Clener_A + $val['line_info_detil'][16]['absEmp'];

            $val['line_info_detil'][17] == 'null' ? '' : $u_input_man_P     = $u_input_man_P + $val['line_info_detil'][17]['preEmp'];
            $val['line_info_detil'][17] == 'null' ? '' : $u_input_man_A     = $u_input_man_A + $val['line_info_detil'][17]['absEmp'];

            $val['line_info_detil'][18] == 'null' ? '' : $u_Others_P     = $u_Others_P + $val['line_info_detil'][18]['preEmp'];
            $val['line_info_detil'][18] == 'null' ? '' : $u_Others_A     = $u_Others_A + $val['line_info_detil'][18]['absEmp'];
            
            $val['line_info_detil'][0] == 'null' ? '' : $t_Ostaff_P   = $t_Ostaff_P   + $val['line_info_detil'][0]['preEmp'];
            $val['line_info_detil'][0] == 'null' ? '' : $t_Ostaff_A   = $t_Ostaff_A   + $val['line_info_detil'][0]['absEmp'];
            $val['line_info_detil'][1] == 'null' ? '' : $t_Pstaff_P   = $t_Pstaff_P   + $val['line_info_detil'][1]['preEmp'];
            $val['line_info_detil'][1] == 'null' ? '' : $t_Pstaff_A   = $t_Pstaff_A   + $val['line_info_detil'][1]['absEmp'];
            $val['line_info_detil'][2] == 'null' ? '' : $t_Opr_P      = $t_Opr_P      + $val['line_info_detil'][2]['preEmp'];
            $val['line_info_detil'][2] == 'null' ? '' : $t_Opr_A      = $t_Opr_A      + $val['line_info_detil'][2]['absEmp'];
            $val['line_info_detil'][3] == 'null' ? '' : $t_Aopr_P     = $t_Aopr_P     + $val['line_info_detil'][3]['preEmp'];
            $val['line_info_detil'][3] == 'null' ? '' : $t_Aopr_A     = $t_Aopr_A     + $val['line_info_detil'][3]['absEmp'];
            $val['line_info_detil'][4] == 'null' ? '' : $t_LIrn_P     = $t_LIrn_P     + $val['line_info_detil'][4]['preEmp'];
            $val['line_info_detil'][4] == 'null' ? '' : $t_LIrn_A     = $t_LIrn_A     + $val['line_info_detil'][4]['absEmp'];
            $val['line_info_detil'][5] == 'null' ? '' : $t_FAsst_P    = $t_FAsst_P    + $val['line_info_detil'][5]['preEmp'];
            $val['line_info_detil'][5] == 'null' ? '' : $t_FAsst_A    = $t_FAsst_A    + $val['line_info_detil'][5]['absEmp'];
            $val['line_info_detil'][6] == 'null' ? '' : $t_JrIrn_P    = $t_JrIrn_P    + $val['line_info_detil'][8]['preEmp'];
            $val['line_info_detil'][6] == 'null' ? '' : $t_JrIrn_A    = $t_JrIrn_A    + $val['line_info_detil'][8]['absEmp'];
            $val['line_info_detil'][7] == 'null' ? '' : $t_Irn_P      = $t_Irn_P      + $val['line_info_detil'][7]['preEmp'];
            $val['line_info_detil'][7] == 'null' ? '' : $t_Irn_A      = $t_Irn_A      + $val['line_info_detil'][7]['absEmp'];
            $val['line_info_detil'][8] == 'null' ? '' : $t_Pman_P     = $t_Pman_P     + $val['line_info_detil'][8]['preEmp'];
            $val['line_info_detil'][8] == 'null' ? '' : $t_Pman_A     = $t_Pman_A     + $val['line_info_detil'][8]['absEmp'];
            $val['line_info_detil'][9] == 'null' ? '' : $t_Sman_P     = $t_Sman_P     + $val['line_info_detil'][9]['preEmp'];
            $val['line_info_detil'][9] == 'null' ? '' : $t_Sman_A     = $t_Sman_A     + $val['line_info_detil'][9]['absEmp'];
            $val['line_info_detil'][10] == 'null' ? '' : $t_Fman_P    = $t_Fman_P     + $val['line_info_detil'][10]['preEmp'];
            $val['line_info_detil'][10] == 'null' ? '' : $t_Fman_A    = $t_Fman_A     + $val['line_info_detil'][10]['absEmp'];
            $val['line_info_detil'][11] == 'null' ? '' : $t_Pkr_P     = $t_Pkr_P      + $val['line_info_detil'][11]['preEmp'];
            $val['line_info_detil'][11] == 'null' ? '' : $t_Pkr_A     = $t_Pkr_A      + $val['line_info_detil'][11]['absEmp'];

            $val['line_info_detil'][12] == 'null' ? '' : $t_Quinsp_P     = $t_Quinsp_P + $val['line_info_detil'][12]['preEmp'];
            $val['line_info_detil'][12] == 'null' ? '' : $t_Quinsp_A     = $t_Quinsp_A + $val['line_info_detil'][12]['absEmp'];

            $val['line_info_detil'][13] == 'null' ? '' : $t_Admin_4th_P     = $t_Admin_4th_P + $val['line_info_detil'][13]['preEmp'];
            $val['line_info_detil'][13] == 'null' ? '' : $t_Admin_4th_A     = $t_Admin_4th_A + $val['line_info_detil'][13]['absEmp'];

            $val['line_info_detil'][14] == 'null' ? '' : $t_Cman_P     = $t_Cman_P + $val['line_info_detil'][14]['preEmp'];
            $val['line_info_detil'][14] == 'null' ? '' : $t_Cman_A     = $t_Cman_A + $val['line_info_detil'][14]['absEmp'];

            $val['line_info_detil'][15] == 'null' ? '' : $t_Fusing_P     = $t_Fusing_P + $val['line_info_detil'][15]['preEmp'];
            $val['line_info_detil'][15] == 'null' ? '' : $t_Fusing_A     = $t_Fusing_A + $val['line_info_detil'][15]['absEmp'];

            $val['line_info_detil'][16] == 'null' ? '' : $t_Clener_P     = $t_Clener_P + $val['line_info_detil'][16]['preEmp'];
            $val['line_info_detil'][16] == 'null' ? '' : $t_Clener_A     = $t_Clener_A + $val['line_info_detil'][16]['absEmp'];

            $val['line_info_detil'][17] == 'null' ? '' : $t_input_man_P     = $t_input_man_P + $val['line_info_detil'][17]['preEmp'];
            $val['line_info_detil'][17] == 'null' ? '' : $t_input_man_A     = $t_input_man_A + $val['line_info_detil'][17]['absEmp'];

            $val['line_info_detil'][18] == 'null' ? '' : $t_Others_P     = $t_Others_P + $val['line_info_detil'][18]['preEmp'];
            $val['line_info_detil'][18] == 'null' ? '' : $t_Others_A     = $t_Others_A + $val['line_info_detil'][18]['absEmp'];

            ?>

                            <?php
                            /*
                            $u_Ostaff_P   = $u_Ostaff_P + $val['line_info_detil'][0]['preEmp'];
                            $u_Ostaff_A   = $u_Ostaff_A + $val['line_info_detil'][0]['absEmp'];
                            $u_Pstaff_P   = $u_Pstaff_P + $val['line_info_detil'][1]['preEmp'];
                            $u_Pstaff_A   = $u_Pstaff_A + $val['line_info_detil'][1]['absEmp'];
                            $u_Opr_P      = $u_Opr_P    + $val['line_info_detil'][2]['preEmp'];
                            $u_Opr_A      = $u_Opr_A    + $val['line_info_detil'][2]['absEmp'];
                            $u_Aopr_P     = $u_Aopr_P   + $val['line_info_detil'][3]['preEmp'];
                            $u_Aopr_A     = $u_Aopr_A   + $val['line_info_detil'][3]['absEmp'];
                            $u_LIrn_P     = $u_LIrn_P   + $val['line_info_detil'][4]['preEmp'];
                            $u_LIrn_A     = $u_LIrn_A   + $val['line_info_detil'][4]['absEmp'];
                            $u_FAsst_P    = $u_FAsst_P  + $val['line_info_detil'][5]['preEmp'];
                            $u_FAsst_A    = $u_FAsst_A  + $val['line_info_detil'][5]['absEmp'];
                            $u_JrIrn_P    = $u_JrIrn_P  + $val['line_info_detil'][6]['preEmp'];
                            $u_JrIrn_A    = $u_JrIrn_A  + $val['line_info_detil'][6]['absEmp'];
                            $u_Irn_P      = $u_Irn_P    + $val['line_info_detil'][7]['preEmp'];
                            $u_Irn_A      = $u_Irn_A    + $val['line_info_detil'][7]['absEmp'];
                            $u_Pman_P     = $u_Pman_P   + $val['line_info_detil'][8]['preEmp'];
                            $u_Pman_A     = $u_Pman_A   + $val['line_info_detil'][8]['absEmp'];
                            $u_Sman_P     = $u_Sman_P   + $val['line_info_detil'][9]['preEmp'];
                            $u_Sman_A     = $u_Sman_A   + $val['line_info_detil'][9]['absEmp'];
                            $u_Fman_P     = $u_Fman_P   + $val['line_info_detil'][10]['preEmp'];
                            $u_Fman_A     = $u_Fman_A   + $val['line_info_detil'][10]['absEmp'];
                            $u_Pkr_P      = $u_Pkr_P    + $val['line_info_detil'][11]['preEmp'];
                            $u_Pkr_A      = $u_Pkr_A    + $val['line_info_detil'][11]['absEmp'];
                            
                            $t_Ostaff_P   = $t_Ostaff_P + $val['line_info_detil'][0]['preEmp'];
                            $t_Ostaff_A   = $t_Ostaff_A + $val['line_info_detil'][0]['absEmp'];
                            $t_Pstaff_P   = $t_Pstaff_P + $val['line_info_detil'][1]['preEmp'];
                            $t_Pstaff_A   = $t_Pstaff_A + $val['line_info_detil'][1]['absEmp'];
                            $t_Opr_P      = $t_Opr_P    + $val['line_info_detil'][2]['preEmp'];
                            $t_Opr_A      = $t_Opr_A    + $val['line_info_detil'][2]['absEmp'];
                            $t_Aopr_P     = $t_Aopr_P   + $val['line_info_detil'][3]['preEmp'];
                            $t_Aopr_A     = $t_Aopr_A   + $val['line_info_detil'][3]['absEmp'];
                            $t_LIrn_P     = $t_LIrn_P   + $val['line_info_detil'][4]['preEmp'];
                            $t_LIrn_A     = $t_LIrn_A   + $val['line_info_detil'][4]['absEmp'];
                            $t_FAsst_P    = $t_FAsst_P  + $val['line_info_detil'][5]['preEmp'];
                            $t_FAsst_A    = $t_FAsst_A  + $val['line_info_detil'][5]['absEmp'];
                            $t_JrIrn_P    = $t_JrIrn_P  + $val['line_info_detil'][6]['preEmp'];
                            $t_JrIrn_A    = $t_JrIrn_A  + $val['line_info_detil'][6]['absEmp'];
                            $t_Irn_P      = $t_Irn_P    + $val['line_info_detil'][7]['preEmp'];
                            $t_Irn_A      = $t_Irn_A    + $val['line_info_detil'][7]['absEmp'];
                            $t_Pman_P     = $t_Pman_P   + $val['line_info_detil'][8]['preEmp'];
                            $t_Pman_A     = $t_Pman_A   + $val['line_info_detil'][8]['absEmp'];
                            $t_Sman_P     = $t_Sman_P   + $val['line_info_detil'][9]['preEmp'];
                            $t_Sman_A     = $t_Sman_A   + $val['line_info_detil'][9]['absEmp'];
                            $t_Fman_P     = $t_Fman_P   + $val['line_info_detil'][10]['preEmp'];
                            $t_Fman_A     = $t_Fman_A   + $val['line_info_detil'][10]['absEmp'];
                            $t_Pkr_P      = $t_Pkr_P    + $val['line_info_detil'][11]['preEmp'];
                            $t_Pkr_A      = $t_Pkr_A    + $val['line_info_detil'][11]['absEmp'];
*/
                            ?>
                        </tr>
                    <?php } }
                        if($s_tEmp > 0) {
                            if($value['sec_name']=='Sewing')
                            {
                         ?>
                        <tr style="background-color: #fffccc;font-weight: bolder;">
                          <td colspan="2" style="background-color: #fffccc;"> Sec. Sub Total</td>
                            <td><?php echo $s_str;?></td>
                            <td><?php echo $s_tEmp;?></td>
                            <td><?php echo $s_str_bal;?></td>
                            <td><?php echo $s_preEmp; ?></td>
                            <td><?php echo $s_absEmp; ?></td>
                            <td><?php echo $s_lEmp; ?></td>
                            <td><?php echo $s_tNew; ?></td>
                            <!-- <td><?php echo $s_all_late; ?></td> -->
                            <td><?php echo $s_all_male; ?></td>
                            <td><?php echo $s_all_female; ?></td>

                            <td><?php echo $s_Ostaff_P; ?></td>
                            <td><?php echo $s_Ostaff_A; ?></td>
                            <td><?php echo $s_Pstaff_P; ?></td>
                            <td><?php echo $s_Pstaff_A; ?></td>
                            <td><?php echo $s_Opr_P; ?></td>
                            <td><?php echo $s_Opr_A; ?></td>
                            <td><?php echo $s_Aopr_P; ?></td>
                            <td><?php echo $s_Aopr_A; ?></td>
                            <td><?php echo $s_LIrn_P; ?></td>
                            <td><?php echo $s_LIrn_A; ?></td>
                            <td><?php echo $s_FAsst_P; ?></td>
                            <td><?php echo $s_FAsst_A; ?></td>
                            <td><?php echo $s_JrIrn_P; ?></td>
                            <td><?php echo $s_JrIrn_A; ?></td>
                            <td><?php echo $s_Irn_P; ?></td>
                            <td><?php echo $s_Irn_A; ?></td>
                            <td><?php echo $s_Pman_P; ?></td>
                            <td><?php echo $s_Pman_A; ?></td>
                            <td><?php echo $s_Sman_P; ?></td>
                            <td><?php echo $s_Sman_A; ?></td>
                            <td><?php echo $s_Fman_P; ?></td>
                            <td><?php echo $s_Fman_A; ?></td>
                            <td><?php echo $s_Pkr_P; ?></td>
                            <td><?php echo $s_Pkr_A; ?></td>
                            <td><?php echo $s_Quinsp_P; ?></td>
                            <td><?php echo $s_Quinsp_A; ?></td>
                            <td><?php echo $s_Admin_4th_P; ?></td>
                            <td><?php echo $s_Admin_4th_A; ?></td>
                            <td><?php echo $s_Cman_P; ?></td>
                            <td><?php echo $s_Cman_A; ?></td>
                            <td><?php echo $s_Fusing_P; ?></td>
                            <td><?php echo $s_Fusing_A; ?></td>
                            <td><?php echo $s_Clener_P; ?></td>
                            <td><?php echo $s_Clener_A; ?></td>
                            <td><?php echo $s_input_man_P; ?></td>
                            <td><?php echo $s_input_man_A; ?></td>
                            <td><?php echo $s_Others_P; ?></td>
                            <td><?php echo $s_Others_A; ?></td>
                        </tr>
                    <?php } }else{ ?>
                        <script type="text/javascript">
                            $(".sec_<?=$value['sec_id']?>").hide();
                        </script>

                    <?php }
                        } ?>
                        <tr style="background-color: #fffccc;font-weight: bolder;">
                            <td colspan="2" style="background-color: #fffccc;"> Unit Sub Total</td>
                            <td><?php echo $u_str;?></td>
                            <td><?php echo $u_tEmp;?></td>
                            <td><?php echo $u_str_bal;?></td>
                            <td><?php echo $u_preEmp; ?></td>
                            <td><?php echo $u_absEmp; ?></td>
                            <td><?php echo $u_lEmp; ?></td>
                            <td><?php echo $u_tNew; ?></td>
                            <!-- <td><?php echo $u_all_late; ?></td> -->
                            <td><?php echo $u_all_male; ?></td>
                            <td><?php echo $u_all_female; ?></td>

                            
                            <td><?php echo $u_Ostaff_P; ?></td>
                            <td><?php echo $u_Ostaff_A; ?></td>
                            <td><?php echo $u_Pstaff_P; ?></td>
                            <td><?php echo $u_Pstaff_A; ?></td>
                            <td><?php echo $u_Opr_P; ?></td>
                            <td><?php echo $u_Opr_A; ?></td>
                            <td><?php echo $u_Aopr_P; ?></td>
                            <td><?php echo $u_Aopr_A; ?></td>
                            <td><?php echo $u_LIrn_P; ?></td>
                            <td><?php echo $u_LIrn_A; ?></td>
                            <td><?php echo $u_FAsst_P; ?></td>
                            <td><?php echo $u_FAsst_A; ?></td>
                            <td><?php echo $u_JrIrn_P; ?></td>
                            <td><?php echo $u_JrIrn_A; ?></td>
                            <td><?php echo $u_Irn_P; ?></td>
                            <td><?php echo $u_Irn_A; ?></td>
                            <td><?php echo $u_Pman_P; ?></td>
                            <td><?php echo $u_Pman_A; ?></td>
                            <td><?php echo $u_Sman_P; ?></td>
                            <td><?php echo $u_Sman_A; ?></td>
                            <td><?php echo $u_Fman_P; ?></td>
                            <td><?php echo $u_Fman_A; ?></td>
                            <td><?php echo $u_Pkr_P; ?></td>
                            <td><?php echo $u_Pkr_A; ?></td>
                            <td><?php echo $u_Quinsp_P; ?></td>
                            <td><?php echo $u_Quinsp_A; ?></td>
                            <td><?php echo $u_Admin_4th_P; ?></td>
                            <td><?php echo $u_Admin_4th_A; ?></td>
                            <td><?php echo $u_Cman_P; ?></td>
                            <td><?php echo $u_Cman_A; ?></td>
                            <td><?php echo $u_Fusing_P; ?></td>
                            <td><?php echo $u_Fusing_A; ?></td>
                            <td><?php echo $u_Clener_P; ?></td>
                            <td><?php echo $u_Clener_A; ?></td>
                            <td><?php echo $u_input_man_P; ?></td>
                            <td><?php echo $u_input_man_A; ?></td>
                            <td><?php echo $u_Others_P; ?></td>
                            <td><?php echo $u_Others_A; ?></td>
                        </tr>

                        
            <?php   } ?>
                    <tr style="background-color: #cccfff;font-weight: bolder;">
                        <td colspan="2"> Grand Total</td>
                        <td><?php echo $t_str;?></td>
                        <td><?php echo $t_tEmp;?></td>
                        <td><?php echo $t_str_bal;?></td>
                        <td><?php echo $t_preEmp; ?></td>
                        <td><?php echo $t_absEmp; ?></td>
                        <td><?php echo $t_lEmp; ?></td>
                        <td><?php echo $t_tNew; ?></td>
                        <!-- <td><?php echo $t_all_late; ?></td> -->
                        <td><?php echo $t_all_male; ?></td>
                        <td><?php echo $t_all_female; ?></td>


                        <td><?php echo $t_Ostaff_P; ?></td>
                        <td><?php echo $t_Ostaff_A; ?></td>
                        <td><?php echo $t_Pstaff_P; ?></td>
                        <td><?php echo $t_Pstaff_A; ?></td>
                        <td><?php echo $t_Opr_P; ?></td>
                        <td><?php echo $t_Opr_A; ?></td>
                        <td><?php echo $t_Aopr_P; ?></td>
                        <td><?php echo $t_Aopr_A; ?></td>
                        <td><?php echo $t_LIrn_P; ?></td>
                        <td><?php echo $t_LIrn_A; ?></td>
                        <td><?php echo $t_FAsst_P; ?></td>
                        <td><?php echo $t_FAsst_A; ?></td>
                        <td><?php echo $t_JrIrn_P; ?></td>
                        <td><?php echo $t_JrIrn_A; ?></td>
                        <td><?php echo $t_Irn_P; ?></td>
                        <td><?php echo $t_Irn_A; ?></td>
                        <td><?php echo $t_Pman_P; ?></td>
                        <td><?php echo $t_Pman_A; ?></td>
                        <td><?php echo $t_Sman_P; ?></td>
                        <td><?php echo $t_Sman_A; ?></td>
                        <td><?php echo $t_Fman_P; ?></td>
                        <td><?php echo $t_Fman_A; ?></td>
                        <td><?php echo $t_Pkr_P; ?></td>
                        <td><?php echo $t_Pkr_A; ?></td>
                        <td><?php echo $t_Quinsp_P; ?></td>
                        <td><?php echo $t_Quinsp_A; ?></td>
                        <td><?php echo $t_Admin_4th_P; ?></td>
                        <td><?php echo $t_Admin_4th_A; ?></td>
                        <td><?php echo $t_Cman_P; ?></td>
                        <td><?php echo $t_Cman_A; ?></td>
                        <td><?php echo $t_Fusing_P; ?></td>
                        <td><?php echo $t_Fusing_A; ?></td>
                        <td><?php echo $t_Clener_P; ?></td>
                        <td><?php echo $t_Clener_A; ?></td>
                        <td><?php echo $t_input_man_P; ?></td>
                        <td><?php echo $t_input_man_A; ?></td>
                        <td><?php echo $t_Others_P; ?></td>
                        <td><?php echo $t_Others_A; ?></td>
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
