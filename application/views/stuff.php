<?php
class NumberToWord{
    var $num_to_word = array(
        '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', '5' => 'Five',
        '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', '10' => 'Ten',
        '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen', '15' => 'Fifteen',
        '16' => 'Sixteen', '17' => 'Seventeen', '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty',
        '30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy',
        '80' => 'Eighty', '90' => 'Ninety'
    );

    var $hundred = 'Hundred';
    var $thousand = 'Thousand';
    var $million = 'Million';
    var $billion = 'Billion';
    var $trillion = 'Trillion';

    public function numToWord($number){
        if (!is_numeric($number)) return 'Not A Number';

        if (is_float($number)) {
            $parts = explode('.', $number);
            return ucwords($this->numberSelector($parts[0]) . ' Point ' . $this->decimalToWord($parts[1]));
        } else {
            return ucwords($this->numberSelector($number));
        }
    }

    public function decimalToWord($number){
        $digits = str_split($number);
        $words = array_map(function($digit) {
            return $this->num_to_word[$digit];
        }, $digits);
        return implode(' ', $words);
    }

    public function numberSelector($number){
        if ($number >= 1000000000000) {
            return $this->trillion($number);
        } elseif ($number >= 1000000000) {
            return $this->billion($number);
        } elseif ($number >= 1000000) {
            return $this->million($number);
        } elseif ($number >= 1000) {
            return $this->thousand($number);
        } elseif ($number >= 100) {
            return $this->hundred($number);
        } else {
            return $this->underHundred($number);
        }
    }

    public function underHundred($number){
        if ($number <= 20) {
            return $this->num_to_word[$number];
        } else {
            $tens = (int)($number / 10) * 10;
            $units = $number % 10;
            return $this->num_to_word[$tens] . (($units > 0) ? ' ' . $this->num_to_word[$units] : '');
        }
    }

    public function hundred($number){
        $hundreds = (int)($number / 100);
        $remainder = $number % 100;
        return $this->num_to_word[$hundreds] . ' ' . $this->hundred . ($remainder > 0 ? ' And ' . $this->underHundred($remainder) : '');
    }

    public function thousand($number){
        $thousands = (int)($number / 1000);
        $remainder = $number % 1000;
        return $this->numberSelector($thousands) . ' ' . $this->thousand . ($remainder > 0 ? ' ' . $this->numberSelector($remainder) : '');
    }

    public function million($number){
        $millions = (int)($number / 1000000);
        $remainder = $number % 1000000;
        return $this->numberSelector($millions) . ' ' . $this->million . ($remainder > 0 ? ' ' . $this->numberSelector($remainder) : '');
    }

    public function billion($number){
        $billions = (int)($number / 1000000000);
        $remainder = $number % 1000000000;
        return $this->numberSelector($billions) . ' ' . $this->billion . ($remainder > 0 ? ' ' . $this->numberSelector($remainder) : '');
    }

    public function trillion($number){
        $trillions = (int)($number / 1000000000000);
        $remainder = $number % 1000000000000;
        return $this->numberSelector($trillions) . ' ' . $this->trillion . ($remainder > 0 ? ' ' . $this->numberSelector($remainder) : '');
    }
}

$obj = new NumberToWord();
 // Outputs: Two Hundred And Fifteen Thousand, Two Hundred And Forty-Five
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <title>Your New Title</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        @media print{
        .break_page{
            page-break-before: always;
            }

        }
        p{
            margin-bottom: 5px !important;
        }
        h3{
            font-size: 1.5rem;
        }
        body {
            font-family: "The Times Roman";
        }
        p{
            font-size: 18px !important;
        }
    </style>
</head>

<body style="margin: 0px auto">
    <?php
            // dd($values);
    foreach($values as $value){?>
    <!-- niog -->
       <div class="container break_page">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/006</p>
            </div>
            <?php } else if($unit_id == 2){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/083</p>
            </div>
            <?php }else if($unit_id == 4){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 15.01.2022</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/006</p>
            </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row();
                //dd($com_info);?>
                <div class="d-flex">
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px; height: 40px; position: absolute;margin-left:185px;margin-top:-10px">
                    <h2 class="text-center" style="margin:0 auto"><b><?= $com_info->company_name_english ?></b></h2>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h6 mt-1"><?= $com_info->company_add_english ?></p>
            </div>
            <div>

            <div class="d-flex mt-2">
                <div class="col-md-4 ">
                    <!-- <p>Ref: <?php echo $unit_id == 1? 'AJFL': ($unit_id == 2?'LSAL': ($unit_id == 4? 'HGL':'') ) ?>/HRD/AL/10069</p> -->
                    <p>Date : <?php echo date('d/m/Y',strtotime($value->emp_join_date))?></p>
                </div>

                <div class="col-md-8">
                    <p  style="float:right">Office Copy</p>
                </div>
            </div>
            <br>

            <div style="margin-left:15px ;">
                <p>To,</p>
                <p><b> <?php echo $value->gender == 'Male' ? 'Mr.':'Mrs.'?>  <?php echo $value->name_en?></b></p>
                <p>Present Address: Vill: <?php echo $value->pre_village?>, Post: <?php echo $value->pre_post_name_en?>, Thana: <?php echo $value->pre_upa_name_en?>, Dist: <?php echo $value->pre_dis_name_en?></p>
                <p>Permanent Address: Vill: <?php echo $value->per_village?>, Post: <?php echo $value->post_name_en?>, Thana: <?php echo $value->upa_name_en?>, Dist: <?php echo $value->dis_name_en?> </p>
                <p>Mobile Number: <?php echo $value->personal_mobile?></p>
                <br>
                <p><b>Subject: Appointment Letter</b></p>
                <br>
                <p><b>Dear <?php echo $value->gender == 'Male' ? 'Mr.':'Mrs.'?> <?php echo $value->name_en?></b></p>

                <p>
                    With reference to your interest about our company and subsequent interview with us, the
                    Management of <b> <?php echo $com_info->company_name_english?></b> is pleased to appoint you as
                    <b><?php echo $value->desig_name?> </b>  Office ID no:- <b> <?php echo $value->per_emp_id?> </b> in <b> <?php echo $value->dept_name?> Department</b>   from the date of <b> <?php echo date('d-m-Y',strtotime($value->emp_join_date))?></b> underthe following terms and conditions.
                </p>

            <ol style="line-height:1.3;font-size:17px;margin-left:-25px">
                <li>Your position name is <b>"<?php echo $value->desig_name?>"</b> in <b><?php echo $value->line_name_en?></b> section for <?php echo $com_info->company_name_english?>,  <?php echo $com_info->company_add_english?> </li>

                <li>Your probationary period will be 06 (Six) month. </li>
                <li>After successfully completion of probation period you shall be deemed to be permanent in accordance with the provision Bangladesh labor law if not been issued any confirmation letter. </li>
                <li>Your appraisal will be made at the end of calendar year of the service. </li>
                <li>Your office hour will be from 08:00 am to 05:00 pm & Friday will be weekly holiday. </li>
                <li>Your leaves and holidays entitlement will be as per company’s “Leave Policy”. </li>
                <li>Your salary deduction of tax well be as per government rules.</li>

                <li>Your consolidated salary shall be as follow:</li>
                <li style="list-style-type: none;"><div class='d-flex align-items-end'>
                <table style="line-height: 1;">
                    <tr>
                        <th> i. Basic</th>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <td>&nbsp;&nbsp;<?php $basic = round(($value->salary -(1250+450+750)) / 1.5); echo $basic;?></td>
                        <td>&nbsp;&nbsp;TK</td>
                    </tr>
                    <tr>
                        <th> ii. House Rent </th>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                        <td>&nbsp;&nbsp;<?php echo round($basic/2)?> </td>
                        <td>&nbsp;&nbsp;TK</td>

                    </tr>
                    <tr>
                            <th> iii. Medical </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;750 </td>
                            <td>&nbsp;&nbsp;TK</td>

                        </tr>
                        <tr>
                            <th> iv. Transport </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;450 </td>
                            <td>&nbsp;&nbsp;TK</td>
                        </tr>
                        <tr style="border-bottom: 1px solid black;">
                            <th> v. Food </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;1250 </td>
                            <td>&nbsp;&nbsp;TK </td>
                        </tr>
                        <tr>
                            <th>Total  Salary </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;<b><?php echo $value->salary?></b></td>
                            <td>&nbsp;&nbsp; TK </td>
                        </tr>
                    </table>
                    <table style="line-height: 1;margin-left:100px">
                        <tr style='vertical-align:baseline'>
                            <td><b>In Word:  </b></td>
                            <td style="padding-left:5px;"><?php echo $obj->numToWord( $value->salary);?> </td>
                            <td style="padding-left:5px;"> Taka Only </td>
                        </tr>
                    </table>
                </div>
                </li>
            </ol>
            <ol start='9'  style="line-height:1.3;font-size:17px;margin-left:-25px">
                <li >You need to follow the company Rules Regulations and policies. Breaking of any such may cause the Termination of your service at AJ Group. </li>
                <li>Permanent employees may resign from employment with 60 days written notice. If you choose to resign without notice, you must have to pay 60 days basic wages to the employer. In case of terminate of any  worker without notice by the owner, the owner will follow Bangladesh Labor Law.</li>
            </ol>





                <p style="margin-left:-10px;">Thank you to be a member of AJ Group family.</p>
                <br>
                <p style="margin-left:-10px;">Thanking You </p>
                <br><br>
                <br><br>
                <div style="display: flex; justify-content: space-between;margin-left:-10px;">

                    <div>
                        <p style='border-top: 1px solid black;width:fit-content'><b>Department Head</b></p>
                        <p>(HR, Admin Compliance)</p>
                        <p><?= $com_info->company_name_english?></p>
                        <!-- <span style="float:right">Signature...................√.............</span> -->
                        <p style="line-height:1.3">Cc: 1)  Group GM (HR, Admin & Compliance).</p>
                        <p style="line-height:1.3;margin-left: 35px;">2) GM (Project Head)</p>
                        <p style="line-height:1.3;margin-left: 35px;">3) HR Department</p>
                        <p style="line-height:1.3;margin-left: 35px;">4) Accounts Department</p>
                        <p style="line-height:1.3;margin-left: 35px;">5) Personal File</p>
                    </div>
                    <div>
                        <p style="text-align:center;">Recived By</p>
                        <p style="text-align:center"><?= $value->name_en?></p>
                    </div>
                </div>

            </div>
        </div>
    <?php }?>
    <br>
        <?php
            // dd($values);
    foreach($values as $value){?>
    <!-- niog -->
            <div class="container break_page">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/006</p>
            </div>
            <?php } else if($unit_id == 2){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/083</p>
            </div>
            <?php }else if($unit_id == 4){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 15.01.2022</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/006</p>
            </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row();
                //dd($com_info);?>
                <div class="d-flex">
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px; height: 40px; position: absolute;margin-left:185px;margin-top:-10px">
                    <h2 class="text-center" style="margin:0 auto"><b><?= $com_info->company_name_english ?></b></h2>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h6 mt-1"><?= $com_info->company_add_english ?></p>
            </div>
            <div>

            <div class="d-flex mt-2">
                <div class="col-md-4 ">
                    <!-- <p>Ref: <?php echo $unit_id == 1? 'AJFL': ($unit_id == 2?'LSAL': ($unit_id == 4? 'HGL':'') ) ?>/HRD/AL/10069</p> -->
                    <p>Date : <?php echo date('d/m/Y',strtotime($value->emp_join_date))?></p>
                </div>

                <div class="col-md-8">
                    <p  style="float:right">Employee Copy</p>
                </div>
            </div>
            <br>

            <div style="margin-left:15px ;">
                <p>To,</p>
                <p><b> <?php echo $value->gender == 'Male' ? 'Mr.':'Mrs.'?>  <?php echo $value->name_en?></b></p>
                <p>Present Address: Vill: <?php echo $value->pre_village?>, Post: <?php echo $value->pre_post_name_en?>, Thana: <?php echo $value->pre_upa_name_en?>, Dist: <?php echo $value->pre_dis_name_en?></p>
                <p>Permanent Address: Vill: <?php echo $value->per_village?>, Post: <?php echo $value->post_name_en?>, Thana: <?php echo $value->upa_name_en?>, Dist: <?php echo $value->dis_name_en?> </p>
                <p>Mobile Number: <?php echo $value->personal_mobile?></p>
                <br>
                <p><b>Subject: Appointment Letter</b></p>
                <br>
                <p><b>Dear <?php echo $value->gender == 'Male' ? 'Mr.':'Mrs.'?> <?php echo $value->name_en?></b></p>

                <p>
                    With reference to your interest about our company and subsequent interview with us, the
                    Management of <b> <?php echo $com_info->company_name_english?></b> is pleased to appoint you as
                    <b><?php echo $value->desig_name?> </b>  Office ID no:- <b> <?php echo $value->per_emp_id?> </b> in <b> <?php echo $value->dept_name?> Department</b>   from the date of <b> <?php echo date('d-m-Y',strtotime($value->emp_join_date))?></b> underthe following terms and conditions.
                </p>

                <ol style="line-height:1.3;font-size:17px;margin-left:-25px">
                <li>Your position name is <b>"<?php echo $value->desig_name?>"</b> in <b><?php echo $value->line_name_en?></b> section for <?php echo $com_info->company_name_english?>,  <?php echo $com_info->company_add_english?> </li>

                <li>Your probationary period will be 06 (Six) month. </li>
                <li>After successfully completion of probation period you shall be deemed to be permanent in accordance with the provision Bangladesh labor law if not been issued any confirmation letter. </li>
                <li>Your appraisal will be made at the end of calendar year of the service. </li>
                <li>Your office hour will be from 08:00 am to 05:00 pm & Friday will be weekly holiday. </li>
                <li>Your leaves and holidays entitlement will be as per company’s “Leave Policy”. </li>
                <li>Your salary deduction of tax well be as per government rules.</li>

                <li>Your consolidated salary shall be as follow:</li>
                <li style="list-style-type: none;"><div class='d-flex align-items-end'>
                <table style="line-height: 1;">
                    <tr>
                        <th> i. Basic</th>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;:</td>
                        <td>&nbsp;&nbsp;<?php $basic = round(($value->salary -(1250+450+750)) / 1.5); echo $basic;?></td>
                        <td>&nbsp;&nbsp;TK</td>
                    </tr>
                    <tr>
                        <th> ii. House Rent </th>
                        <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                        <td>&nbsp;&nbsp;<?php echo round($basic/2)?> </td>
                        <td>&nbsp;&nbsp;TK</td>

                    </tr>
                    <tr>
                            <th> iii. Medical </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;750 </td>
                            <td>&nbsp;&nbsp;TK</td>

                        </tr>
                        <tr>
                            <th> iv. Transport </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;450 </td>
                            <td>&nbsp;&nbsp;TK</td>
                        </tr>
                        <tr style="border-bottom: 1px solid black;">
                            <th> v. Food </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;1250 </td>
                            <td>&nbsp;&nbsp;TK </td>
                        </tr>
                        <tr>
                            <th>Total  Salary </th>
                            <td>&nbsp;&nbsp;&nbsp;&nbsp;: </td>
                            <td>&nbsp;&nbsp;<b><?php echo $value->salary?></b></td>
                            <td>&nbsp;&nbsp; TK </td>
                        </tr>
                    </table>
                    <table style="line-height: 1;margin-left:100px">
                        <tr style='vertical-align:baseline'>
                            <td><b>In Word:  </b></td>
                            <td style="padding-left:5px;"><?php echo $obj->numToWord( $value->salary);?> </td>
                            <td style="padding-left:5px;"> Taka Only </td>
                        </tr>
                    </table>
                </div>
            </li>
            </ol>
            <ol start='9'  style="line-height:1.3;font-size:17px;margin-left:-25px">
                <li >You need to follow the company Rules Regulations and policies. Breaking of any such may cause the Termination of your service at AJ Group. </li>
                <li>Permanent employees may resign from employment with 60 days written notice. If you choose to resign without notice, you must have to pay 60 days basic wages to the employer. In case of terminate of any  worker without notice by the owner, the owner will follow Bangladesh Labor Law.</li>
            </ol>





                <p style="margin-left:-10px;">Thank you to be a member of AJ Group family.</p>
                <br>
                <p style="margin-left:-10px;">Thanking You </p>
                <br><br>
                <br><br>
                <div style="display: flex; justify-content: space-between;margin-left:-10px;">

                    <div>
                        <p style='border-top: 1px solid black;width:fit-content'><b>Department Head</b></p>
                        <p>(HR, Admin Compliance)</p>
                        <p><?= $com_info->company_name_english?></p>
                        <!-- <span style="float:right">Signature...................√.............</span> -->
                        <p style="line-height:1.3">Cc: 1)  Group GM (HR, Admin & Compliance).</p>
                        <p style="line-height:1.3;margin-left: 35px;">2) GM (Project Head)</p>
                        <p style="line-height:1.3;margin-left: 35px;">3) HR Department</p>
                        <p style="line-height:1.3;margin-left: 35px;">4) Accounts Department</p>
                        <p style="line-height:1.3;margin-left: 35px;">5) Personal File</p>
                    </div>
                    <div>
                        <p style="text-align:center;">Recived By</p>
                        <p style="text-align:center"><?= $value->name_en?></p>
                    </div>
                </div>

            </div>
        </div>
    <?php }?>

</body>
</html>
