<?php
class BanglaNumberToWord{
    var $eng_to_bn = array('1'=>'১', '2'=>'২', '3'=>'৩', '4'=>'৪', '5'=>'৫','6'=>'৬', '7'=>'৭', '8'=>'৮', '9'=>'৯', '0'=>'০');
    var $num_to_bd = array('1'=>'এক','2'=>'দুই','3'=>'তিন','4'=>'চার','5'=>'পাঁচ','6'=>'ছয়','7'=>'সাত','8'=>'আট', '9'=>'নয়','10'=>'দশ','11'=>'এগার','12'=>'বার','13'=>'তের','14'=>'চৌদ্দ','15'=>'পনের','16'=>'ষোল','17'=>'সতের','18'=>'আঠার','19'=>'ঊনিশ','20'=>'বিশ','21'=>'একুশ','22'=>'বাইশ','23'=>'তেইশ','24'=>'চব্বিশ','25'=>'পঁচিশ','26'=>'ছাব্বিশ','27'=>'সাতাশ','28'=>'আঠাশ','29'=>'ঊনত্রিশ','30'=>'ত্রিশ','31'=>'একত্রিশ','32'=>'বত্রিশ','33'=>'তেত্রিশ','34'=>'চৌত্রিশ','35'=>'পঁয়ত্রিশ','36'=>'ছত্রিশ','37'=>'সাঁইত্রিশ','38'=>'আটত্রিশ','39'=>'ঊনচল্লিশ','40'=>'চল্লিশ','41'=>'একচল্লিশ','42'=>'বিয়াল্লিশ','43'=>'তেতাল্লিশ','44'=>'চুয়াল্লিশ','45'=>'পঁয়তাল্লিশ','46'=>'ছেচল্লিশ','47'=>'সাতচল্লিশ','48'=>'আটচল্লিশ','49'=>'ঊনপঞ্চাশ','50'=>'পঞ্চাশ','51'=>'একান্ন','52'=>'বায়ান্ন','53'=>'তিপ্পান্ন','54'=>'চুয়ান্ন','55'=>'পঞ্চান্ন','56'=>'ছাপ্পান্ন','57'=>'সাতান্ন','58'=>'আটান্ন','59'=>'ঊনষাট','60'=>'ষাট','61'=>'একষট্টি','62'=>'বাষট্টি','63'=>'তেষট্টি','64'=>'চৌষট্টি','65'=>'পঁয়ষট্টি','66'=>'ছেষট্টি','67'=>'সাতষট্টি','68'=>'আটষট্টি','69'=>'ঊনসত্তর','70'=>'সত্তর','71'=>'একাত্তর','72'=>'বাহাত্তর','73'=>'তিয়াত্তর','74'=>'চুয়াত্তর','75'=>'পঁচাত্তর','76'=>'ছিয়াত্তর','77'=>'সাতাত্তর','78'=>'আটাত্তর','79'=>'ঊনআশি','80'=>'আশি','81'=>'একাশি','82'=>'বিরাশি','83'=>'তিরাশি','84'=>'চুরাশি','85'=>'পঁচাশি','86'=>'ছিয়াশি','87'=>'সাতাশি','88'=>'আটাশি','89'=>'ঊননব্বই','90'=>'নব্বই','91'=>'একানব্বই','92'=>'বিরানব্বই','93'=>'তিরানব্বই','94'=>'চুরানব্বই','95'=>'পঁচানব্বই','96'=>'ছিয়ানব্বই','97'=>'সাতানব্বই','98'=>'আটানব্বই','99'=>'নিরানব্বই');
    var $num_to_bn_decimal = array('0'=>'শূন্য ','1'=>'এক ','2'=>'দুই ','3'=>'তিন ','4'=>'চার ','5'=>'পাঁচ ','6'=>'ছয় ','7'=>'সাত ','8'=>'আট ', '9'=>'নয় ');
    var $hundred = 'শত';
    var $thousand = 'হাজার';
    var $lakh = 'লক্ষ';
    var $crore = 'কোটি';

    public function engToBn($number){
        $bn_number = strtr($number,$this->eng_to_bn);
        return $bn_number;
    }

    public function numToWord($number){
        if (!is_numeric($number) ) return 'Not a Number';

        if(is_float($number)){
            $dot = explode(".", $number);
            if(isset($dot[1])){
                return $this->numberSelector($dot[0]).' দশমিক '.$this->numToBnDecimal($dot[1]);
            }else{
                return $this->numberSelector($dot[0]);
            }
        }else{
            return $this->numberSelector($number);
        }

    }
    public function numToBn($number){
        $word = strtr($number,$this->num_to_bd);
        return $word;
    }
    public function numToBnDecimal($number){
        $word = strtr($number,$this->num_to_bn_decimal);
        return $word;
    }

    public function numberSelector($number){
        if($number > 9999999){
            return $this->crore($number);
        }elseif($number > 99999){
            return $this->lakh($number);
        }elseif($number > 999){
            return $this->thousand($number);
        }elseif($number > 99){
            return $this->hundred($number);
        }else{
            return $this->underHundred($number);
        }
    }

    public function underHundred($number){
        $number = ($number == 0)?'': $this->numToBn($number);
        return $number;
    }

    public function hundred($number){
        $a = (int)($number/100);
        $b = $number%100;
        $hundred = ($a == 0)?'': $this->numToBn($a).' '.$this->hundred;
        return $hundred.' '.$this->underHundred($b);
    }

    public function thousand($number){
        $a = (int)($number/1000);
        $b = $number%1000;
        $thousand = ($a == 0)?'': $this->numToBn($a).' '.$this->thousand;
        return $thousand.' '.$this->hundred($b);
    }

    public function lakh($number){
        $a = (int)($number/100000);
        $b = $number%100000;
        $lakh = ($a == 0)?'': $this->numToBn($a).' '.$this->lakh;
        return $lakh.' '.$this->thousand($b);
    }

    public function crore($number){
        $a = (int)($number/10000000);
        $b = $number%10000000;
        $more_than_core = ($a>99)?$this->lakh($a):$this->numToBn($a);
        return $more_than_core.' '.$this->crore.' '.$this->lakh($b);
    }
}

$obj = new BanglaNumberToWord();



function englishToBengaliMonth($englishMonth) {
    // Array mapping English months to Bengali months
    $months = array(
        "Jan" => "জানুয়ারি",
        "Feb" => "ফেব্রুয়ারি",
        "Mar" => "মার্চ",
        "Apr" => "এপ্রিল",
        "May" => "মে",
        "Jun" => "জুন",
        "Jul" => "জুলাই",
        "Aug" => "আগস্ট",
        "Sep" => "সেপ্টেম্বর",
        "Oct" => "অক্টোবর",
        "Nov" => "নভেম্বর",
        "Dec" => "ডিসেম্বর"
    );

    // Convert the input English month to Bengali month
    return $months[$englishMonth] ?? "Invalid Month";
}

// Example usage

?>


<!doctype html>
<html lang="en">
<head>
    <title>Final Satalment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: SutonnyMJ; */
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
            padding:2px;
        }
        .new_table tr td {
            font-family:sutonnyMJ;
        }
        .new_table tr td:nth-child(2),.new_table tr td:nth-child(3),.new_table tr td:nth-child(4) {
           text-align: center;
        }
        @media print {
            body{
                margin: 0px 0px 0px 0px;
                size: A4 portrait;
            }
        }
        /* p{
            font-size:19px;
        } */
    </style>

    <style>
        .voucher-container {
            border: 1px solid black;
            padding: 20px;
            width: 1000px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
        }
        .header img {
            width: 100px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
        }
        .voucher-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid black;
            padding: 5px;
            /* text-decoration: underline; */
        }
        .details, .footer {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }
        .details th, .details td, .footer td {
            border: 1px solid black;
            padding: 5px;
            text-align: left;
            font-size: 14px;
        }
        .details th {
            background-color: #f2f2f2;
        }
        .details td {
            vertical-align: top;
        }
        .in-word {
            font-weight: bold;
        }
        .signature {
            margin-top: 20px;
        }
        .signature td {
            border: none;
            text-align: center;
        }
    </style>
</head>

<body>
        <!-- < ?php dd($values)?> -->
    <div class="container w-75">

    <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/008</p>
        </div>
        <?php } else if($unit_id == 2){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;"> Document Code : LSAL/HR/03/084</p>
        </div>
        <?php }else if($unit_id == 4){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :15.01.2022</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/052</p>
        </div>
    <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px; height: 45px; position: absolute;">
                    <h1 class="text-center  unicode-to-bijoy" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h4 unicode-to-bijoy" ><?= $com_info->company_add_bangla ?></p>
            </div>
        <div class="d-flex">
        </div>
        <!-- <br> -->
        <div class='d-flex' style="margin-top: 10px">
            <h4 class="text-center unicode-to-bijoy" style="border-bottom: 2px solid black;width: 300px;margin: 0 auto;">চুড়ান্ত (হিসাব) নিস্পত্তি প্রতিবেদন </h4>
               <span style="position:absolute;margin-left:800px">তারিখঃ</span>
        </div>
        <?php  foreach($values as $row){ ?>
            <br>
            <div class="ml-3">
                <table class="table table-bordered" style="font-size:19px">
                    <tr>
                        <td class="unicode-to-bijoy">নাম</td>
                        <td class="unicode-to-bijoy"><?php echo $row->name_bn?></td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">কার্ড</td>
                        <td class="unicode-to-bijoy"><?php echo $row->emp_id?></td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">পদবী</td>
                        <td class="unicode-to-bijoy"><?php echo $row->desig_bangla?></td>
                    </tr>

                    <tr>
                        <td class="unicode-to-bijoy">সেকশন</td>
                        <td class="unicode-to-bijoy"><?php echo $row->sec_name_bn?></td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">লাইন</td>
                        <td class="unicode-to-bijoy"><?php echo $row->line_name_bn?></td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">গ্রেড</td>
                        <td class="unicode-to-bijoy" style=" font-size:20px;font-family:SutonnyMJ"> <?php echo $row->gr_str_basic?> </td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">যোগদানের তারিখ</td>
                        <td class="unicode-to-bijoy" style="font-size:19px;font-family:SutonnyMJ"> <?php echo $join_date = date('d-m-Y', strtotime($row->emp_join_date))?> Bs</td>
                    </tr>
                    <tr>

                    <td class="unicode-to-bijoy">শেষ কর্মদিবস</td>
                     <td class="unicode-to-bijoy" style=" font-size:19px;font-family:SutonnyMJ">
                    <?php echo $last_day = $row->resign_date==null ? '':date('d-m-Y', strtotime($row->resign_date))?> Bs</td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">চাকুরীকাল</td>
                        <td class="unicode-to-bijoy">
                        <?php
                            $date1 = new DateTime($join_date);
                            $date2 = new DateTime($last_day);
                            $interval = $date1->diff($date2);
                            echo $interval->format('<span style="font-size:19px;font-family:SutonnyMJ"> %y eQi %m gvm %d w`b</span>');
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy">মোট বেতন</td>
                        <td style=" font-size:19px;font-family:SutonnyMJ" class="unicode-to-bijoy"> <?php echo $row->gross_sal?> UvKv</td>
                    </tr>
                    <tr>
                        <td class='unicode-to-bijoy'>মূল বেতন</td>
                        <td style="font-size:19px;font-family:SutonnyMJ" class="unicode-to-bijoy"> <?php echo round(($row->gross_sal - 2450)/1.5)?> UvKv</td>
                    </tr>
                    <tr>
                        <td class='unicode-to-bijoy'>প্রতি ঘন্টার ওভার টাইম হার</td>
                        <?php if(isset($total_value->ot_rate)) : ?>
                            <td class="unicode-to-bijoy" style="font-size:19px;font-family:SutonnyMJ"> <?php echo $total_value->ot_rate; ?> UvKv </td>
                        <?php else : ?>
                            <td class="unicode-to-bijoy" style="font-size:19px;font-family:SutonnyMJ"> 0 UvKv </td>
                        <?php endif; ?>
                    </tr>
                </table>
            </div>
            <!-- <br>    -->
            <h4 class="text-center unicode-to-bijoy" ><b>প্রাপ্য বিষয়াদির হিসাব</b></h4>
            <table class="table table-bordered ml-3 new_table" style="font-size:19px">
                <tr>
                    <th class='unicode-to-bijoy'>বিষয় </th>
                    <th class='unicode-to-bijoy'>দিন/ ঘন্টা </th>
                    <th class='unicode-to-bijoy'>হার </th>
                    <th class='unicode-to-bijoy'>টাকা</th>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy" style='font-family:arial'><?php $month = $row->resign_date==null ? '': date('M', strtotime($row->resign_date));
                    echo englishToBengaliMonth($month)." <span style='font-family:SutonnyMJ;font-size:21px'>".date('Y', strtotime($row->resign_date))."</span>";
                    ?> </td>
                   <td class="unicode-to-bijoy"> <?php echo isset($total_value->working_days) ? $total_value->working_days : 0 ?> </td>
                    <td class="unicode-to-bijoy"><?php echo $rptt =  $row->resign_date == null ? 0 : bcdiv($row->gross_sal ,date('t',strtotime($row->resign_date)),2) ?></td>
                   <td class="unicode-to-bijoy"><?php echo isset($total_value->ot_rate) ? $ptt =  $rptt * $total_value->working_days : 0 ?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">চলতি মাসের ওভার টাইম </td>
                    <?php $eot = 0; if ($type == 1) {
                        $eot = $total_value->ot_eot;
                    } elseif ($type == 2) {
                        $eot = $total_value->ot_2pm;
                    } elseif ($type == 3) {
                        $eot = $total_value->ot_eot_4pm;
                    } elseif ($type == 4) {
                        $eot = $total_value->ot_eot_12am;
                    }  elseif ($type == 5) {
                        $eot =   $total_value->all_eot_woh;
                    }  ?>
                    <td><?php echo $eot; ?></td>

                    <td class="unicode-to-bijoy"><?php echo cc($total_value->ot_rate) ?> </td>
                    <td class="unicode-to-bijoy"><?php echo $eot_amt = $eot * cc($total_value->ot_rate,0) ?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">হাজিরা বোনাস </td>
                    <td class="unicode-to-bijoy"><?php echo 0 ?></td>
                    <td class="unicode-to-bijoy"><?php echo 0 ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->attn_bonus ?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">চাকুরী হইতে অবসান এর নোটিশ পে বাংলাদেশ শ্রম আইন ২০০৬ এর ধারা ২৬ (১)</td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->resign_pay_day ?> </td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->per_day_rate ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->resign_pay_day * $total_value->per_day_rate ?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">অতিরিক্ত ক্ষতিপূরণ </td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->extra_payoff ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->per_day_rate ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->extra_payoff * $total_value->per_day_rate ?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">জমাকৃত অর্জিত ছুটির দিন ( <?php echo $total_value->earn_leave?>) উপস্থিতি</td>
                    <td class="unicode-to-bijoy"><?php echo round($total_value->earn_leave/18,2)?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->service_benifit_rate?></td>
                    <td class="unicode-to-bijoy"><?php echo round($total_value->service_benifit_rate*($total_value->earn_leave/18),2)?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">সার্ভিস বেনিফিট </td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->service_benifit?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->per_day_rate?></td>
                    <td class="unicode-to-bijoy"><?php echo $service_benifit = round(($total_value->service_benifit * $total_value->per_day_rate),2) ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="unicode-to-bijoy">অন্যান্য পাওনাদি</td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->another_deposit ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="unicode-to-bijoy"><b>মোট প্রাপ্য টাকা</b></td>
                    <td class="unicode-to-bijoy"><?php echo $net_pay = $total_value->net_pay + $total_value->attn_bonus + $eot_amt + $ptt + $service_benifit; ?></td>
                </tr>
                <tr>
                    <td colspan="4" class="unicode-to-bijoy"><b>কর্তন</b></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">নোটিশ পিরিয়ড কম বা না দেয়ার কারনে কোম্পানীর প্রাপ্য বাবদ কর্তন (মোট মজুরি থেকে)</td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->notice_deduct ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->per_day_rate ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->notice_deduct*$total_value->per_day_rate ?></td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">ষ্ট্যাম্প বাবদ কর্তন</td>
                    <td class="unicode-to-bijoy">০</td>
                    <td class="unicode-to-bijoy">10</td>
                    <td class="unicode-to-bijoy">10</td>
                </tr>
                <tr>
                    <td class="unicode-to-bijoy">অনুপস্থিত বাবদ কর্তন (মূল মজুরি থেকে)</td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->absent ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->per_day_rate ?></td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->absent*$total_value->per_day_rate ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="unicode-to-bijoy">অগ্রীম বেতন</td>
                    <td><?php echo $total_value->advanced_salary ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="unicode-to-bijoy">মোট কর্তন</td>
                    <td class="unicode-to-bijoy"><?php echo $total_value->total_deduct ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="unicode-to-bijoy"><b>নিট প্রাপ্য / প্রদেয় টাকা</b></td>
                    <td class="unicode-to-bijoy"><?php $total_taka =  $net_pay - 10 - $total_value->total_deduct; echo ceil($total_taka) ?></td>
                </tr>

            </table>
            <table style="margin-left: 15px;font-size:19px">
                <tr>
                    <td class="unicode-to-bijoy">মোট প্রাপ্যঃ</td>
                    <td class="unicode-to-bijoy"><?php $a = ceil($total_taka); echo $obj->numToWord($a)?> টাকা</td>
                </tr>
            </table>


            <div style="margin-top: 20px;font-size:19px" class="mt-5 ml-3 d-flex justify-content-between">
                <p style='border-top:1px solid black;' class="unicode-to-bijoy">প্রস্তুতকারী</p>
                <p style='border-top:1px solid black;' class="unicode-to-bijoy">নিরিক্ষক</p>
                <p style='border-top:1px solid black;' class="unicode-to-bijoy">মানব সম্পদ বিভাগ</p>
                <p style='border-top:1px solid black;' class="unicode-to-bijoy">অনুমোদনকারী</p>
            </div>
            <h6 class="text-center unicode-to-bijoy" style="border:2px solid black;width: fit-content;margin: 0 auto;padding: 4px;font-size:19px">প্রাপ্তি স্বীকার</h6>

            <p style="font-size:19px" class="text-justify ml-3 unicode-to-bijoy">আমি  <?php echo $row->name_bn?>, পদবীঃ <?php echo $row->desig_bangla?>, র্কাড নম্বরঃ <?php echo $row->emp_id?>, সেকশন এন্ড লাইনঃ <?php $row->sec_name_bn.' ,'.$row->line_name_bn?>, চুড়ান্ত  নিষ্পত্তকিরন বাবদঃ <?php echo ceil($total_taka); ?> টাকা এর প্রাপ্তি স্বীকার করছি এবং এই প্রতিষ্ঠানে আমার আর কোন আর্থিক পাওনা কিংবা দাবী-দাওয়া নাই। </p>
            <p class="text-right unicode-to-bijoy" style="font-size:19px;margin-right:200px"> স্বাক্ষরঃ</p>

    </div>
    <br>
    <br>


    <div class="voucher-container">

        <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/008</p>
        </div>
        <?php } else if($unit_id == 2){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;"> Document Code : LSAL/HR/03/084</p>
        </div>
        <?php }else if($unit_id == 4){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :15.01.2022</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/052</p>
        </div>
    <?php }?>
    <div class="mt-3">
        <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
        <div class="d-flex">
            <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px;height: 45px;position: absolute;">
            <h1 class="text-center  unicode-to-bijoy" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
        </div>
    </div>
    <div class="col-md-12" >
        <p class="text-center h4 unicode-to-bijoy" ><?= $com_info->company_add_bangla ?></p>
    </div>
    <div class="d-flex justify-content-between">
        <p>Voucher No:</p>
        <p class="voucher-title">Payment Voucher</p>
        <p style="margin-left: 20px;">Date:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </div>


        <table class="details">
            <tr>
                <td>Name:</td>
                <td><?php echo $row->name_bn?></td>
                <td>Card No:</td>
                <td><?php echo $row->emp_id?></td>
            </tr>
            <tr>
                <td>Designation:</td>
                <td><?php echo $row->desig_bangla?></td>
                <td>Section & Line:</td>
                <td><?php echo $row->sec_name_bn?></td>
            </tr>
        </table>
        <table class="details" style="margin-top: 10px;">
            <tr>
                <th>Description</th>
                <th>Net Amount</th>
            </tr>
            <tr>
                <td>জানুয়ারি - 2024 মাসের<br>ছুটাভিত্তি কাজ বাবদ পাওনাাদি</td>
                <td><?php echo ceil($total_taka); ?></td>
            </tr>
            <tr>
                <td class="in-word" colspan="1">In Word:</td>
                <td><?php $a = ceil($total_taka); echo $obj->numToWord($a)?> টাকা।</td>
            </tr>
            <tr>
                <td>Payable Amount:</td>
                <td><?php echo ceil($total_taka); ?></td>
            </tr>
        </table>
        <div class="d-flex justify-content-between mt-5" style="margin-top: 70px !important">
            <p>Prepared by</p>
            <p>Accounts Ex.</p>
            <p>Manager (HR & Comp.)</p>
            <p>A.G.M (Ad. & Finance)</p>
        </div>
    </div>
<?php }?>

<script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
<?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>
</html>

