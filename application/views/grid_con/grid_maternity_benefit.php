
<?php
    function english_to_bangla_date_convert($date) {
        $date = date("d/m/Y",strtotime($date));

        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", ":", ",","/");

        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",","/");

        return str_replace($search_array, $replace_array, $date);
    }

    function eng2bn_month($date) {
        $date = date("F Y",strtotime($date));

        $search_array= array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", ":", ",","/");

        $replace_array= array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০", "জানুয়ারী", "ফেব্রুয়ারী", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগষ্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর", ":", ",","/");

        return str_replace($search_array, $replace_array, $date);
    }
?>

<?php
    class BanglaNumberToWord{
        var $eng_to_bn = array('1'=>'১', '2'=>'২', '3'=>'৩', '4'=>'৪', '5'=>'৫','6'=>'৬', '7'=>'৭', '8'=>'৮', '9'=>'৯', '0'=>'০');
        var $num_to_bd = array('1'=>'GK','2'=>'`yB','3'=>'wZb','4'=>'Pvi','5'=>'cvuP','6'=>'Qq','7'=>'mvZ','8'=>'AvU', '9'=>'bq','10'=>'`k','11'=>'GMvi','12'=>'evi','13'=>'‡Zi','14'=>'‡PŠÏ','15'=>'c‡bi','16'=>'‡lvj','17'=>'m‡Zi','18'=>'AvVvi','19'=>'Ewbk','20'=>'wek','21'=>'GKyk','22'=>'evBk','23'=>'‡ZBk','24'=>'PweŸk','25'=>'cuwPk','26'=>'QvweŸk','27'=>'mvZvk','28'=>'AvVvk','29'=>'EbwÎk','30'=>'wÎk','31'=>'GKwÎk','32'=>'ewÎk','33'=>'‡ZwÎk','34'=>'‡PŠwÎk','35'=>'cuqwÎk','36'=>'QwÎk','37'=>'mvuBwÎk','38'=>'AvUwÎk','39'=>'EbPwjøk','40'=>'Pwjøk','41'=>'GKPwjøk','42'=>'weqvwjøk','43'=>'‡ZZvwjøk','44'=>'Pyqvwjøk','45'=>'cuqZvwjøk','46'=>'‡QPwjøk','47'=>'mvZPwjøk','48'=>'AvUPwjøk','49'=>'EbcÂvk','50'=>'cÂvk','51'=>'GKvbœ','52'=>'evqvbœ','53'=>'wZàvbœ','54'=>'Pyqvbœ','55'=>'cÂvbœ','56'=>'Qvàvbœ','57'=>'mvZvbœ','58'=>'AvUvbœ','59'=>'EblvU','60'=>'lvU','61'=>'GKlwÆ','62'=>'evlwÆ','63'=>'‡ZlwÆ','64'=>'‡PŠlwÆ','65'=>'cuqlwÆ','66'=>'‡QlwÆ','67'=>'mvZlwÆ','68'=>'AvUlwÆ','69'=>'EbmËi','70'=>'mËi','71'=>'GKvËi','72'=>'evnvËi','73'=>'wZqvËi','74'=>'PyqvËi','75'=>'cuPvËi','76'=>'wQqvËi','77'=>'mvZvËi','78'=>'AvUvËi','79'=>'EbAvwk','80'=>'Avwk','81'=>'GKvwk','82'=>'weivwk','83'=>'wZivwk','84'=>'Pyivwk','85'=>'cuPvwk','86'=>'wQqvwk','87'=>'mvZvwk','88'=>'AvUvwk','89'=>'EbbeŸB','90'=>'beŸB','91'=>'GKvbeŸB','92'=>'weivbeŸB','93'=>'wZivbeŸB','94'=>'PyivbeŸB','95'=>'cuPvbeŸB','96'=>'wQqvbeŸB','97'=>'mvZvbeŸB','98'=>'AvUvbeŸB','99'=>'wbivbeŸB');
        var $num_to_bn_decimal = array('0'=>'k~b¨ ','1'=>'GK ','2'=>'`yB ','3'=>'wZb ','4'=>'Pvi ','5'=>'cvuP ','6'=>'Qq ','7'=>'mvZ ','8'=>'AvU ', '9'=>'bq ');
        var $hundred = 'kZ';
        var $thousand = 'nvRvi';
        var $lakh = 'j¶';
        var $crore = '‡KvwU';

        public function engToBn($number){
            $bn_number = strtr($number,$this->eng_to_bn);
            return $bn_number;
        }

        public function numToWord($number){
            if (!is_numeric($number) ) return 'bv¤^vi bv';

            if(is_float($number)){
                $dot = explode(".", $number);
                return $this->numberSelector($dot[0]).' `kwgK '.$this->numToBnDecimal($dot[1]);
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
?>

<?php
    function jod_duration_cal($first_date, $second_date) {
        $diff = date_diff(date_create($second_date), date_create($first_date));
        return $diff->format("%y eQi %m gvm %d w`b");
    }
?>

</html>
<!-- < ?php dd($values)?> -->
<!doctype html>
<html lang="en">

<head>
    <title>Increment Letter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: SutonnyMJ;
            font-size: 20px;
        }
        .unicode-to-bijoy{
            font-size: 20px !important;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #000000;
            padding: 2px;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
		if(empty($values))
		{
			echo '<span style="font-family: Arial, Helvetica, sans-serif;">Requested list is empty</span>';
			exit();
		}
		foreach($values as $row){  $unit_id=$row->unit_id ?>
		    <?php if ($unit_id == 1) { ?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 03.10.2020 </p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/009 </p>
                </div>
            <?php } else if ($unit_id == 2) { ?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 01-01-2020 </p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : LSAL/HR/03/091 </p>
                </div>
            <?php } else { ?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 15.01.2022 </p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/009 </p>
                </div>
            <?php } ?>

            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px;height: 45px;position: absolute;">
                    <h4 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h4>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h6"><?= $com_info->company_add_bangla ?></p>
            </div>
            <div class="d-flex flex-row justify-content-between" style="margin-top:15px;">
                <p class="unicode-to-bijoy" style="font-family: Arial, Helvetica, sans-serif;">তারিখ: <?= english_to_bangla_date_convert($row->first_pay)?></p>
                <p class="unicode-to-bijoy" style="font-family: Arial, Helvetica, sans-serif;">মাতৃত্বকালীন সুবিধা প্রদানের হিসাব</p>
                <p style="font-size: 14px;">প্রথম কিস্তি</p>
            </div>
            <div style="width:1000px; margin:0 auto; overflow:hidden; font-family: Arial, Helvetica, sans-serif; font-size:12px; clear: both;">
               <div style="width:50%;font-size:16px;">
                    <table width="700" border="0" cellpadding="0" cellspacing="0" style="font-size:16px;font-family:SutonnyMJ;">
                        <tr>
                            <td class="unicode-to-bijoy" width="310">নাম</td>
                            <td width="164">:</td>
                            <td  class="unicode-to-bijoy" width="226"><?php echo $row->name_bn; ?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">কার্ড নম্বর</td>
                            <td>:</td>
                            <td  class="unicode-to-bijoy" style='font-size: 19px !important;'><b><?php echo $row->emp_id;?></b></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">পদবী</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size:19px'><?php echo $designation = $row->desig_bangla;?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">সেকশন/লাইন</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size:19px'><?php echo $gr_name = $row->line_name_bn;?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">যোগদানের তারিখ</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size: 19px !important;x'><?php echo date('d/m/Y',strtotime($row->emp_join_date)); ?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">মোট চাকুরীর বয়স</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size: 19px !important;'><?php echo jod_duration_cal($row->emp_join_date, $row->first_pay) ?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">প্রসব পূর্ববর্তী নোটিশ এর তারিখ</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size: 19px !important;'><?php echo date('d/m/Y',strtotime($row->inform_date)); ?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">সম্ভাব্য প্রসবের তারিখ</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size: 19px !important;'><?php echo date('d/m/Y',strtotime($row->probability)); ?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">মাতৃত্বকালীন ছুটির সময়</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size: 19px !important;white-space:nowrap'><?php echo date('d/m/Y',strtotime($row->start_date)) .' ‡_‡K '. date('d/m/Y',strtotime($row->end_date)) .' w`b'; ?></td>
                        </tr>
                        <tr>
                            <td class="unicode-to-bijoy">ছুটির পরে সম্ভাব্য যোগদানের তারিখ</td>
                            <td>:</td>
                            <td class="unicode-to-bijoy" style='font-size: 19px !important;white-space:nowrap'><?php echo date('d/m/Y', strtotime($row->end_date .' +1 day')); ?></td>
                        </tr>
                    </table>
               </div>
                <br><br>
            </div>


            <div style="font-size:16px;  clear: both; padding:0px 10px;">
                <h4 class="unicode-to-bijoy" style="font-family:SutonnyMJ;"> <?= '<span style="font-size:18px">'.$row->name_bn.'</span>' ?> Gi gvZ…Z¡Kvjxb myweavi wnmvewU wbgœiƒc:-</h4>
                <table style="width: 100%; padding:0px 10px; font-size:16px;" border="1" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="font-family:SutonnyMJ; font-size:19px; text-align:center">
                            <th style="padding:5px">gvm</th>
                            <th style="padding:5px">UvKv cwi‡kv‡ai we¯ÍvwiZ</th>
                            <th style="padding:5px">‡gvU †eZb/gRyix</th>
                            <th style="padding:5px">nvwRiv †evbvm</th>
                            <th style="padding:5px">gv‡mi †gvU Avq</th>
                            <th style="padding:5px">Drme †evbvm</th>
                            <th style="padding:5px">Ab¨vb¨</th>
                            <th style="padding:5px">me©‡kl gv‡m cÖvß †gvU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $a1 =  date('Y-m-01', strtotime($row->start_date .' -1 month')); ?>
                        <?php $a2 =  date('Y-m-01', strtotime($a1 .' -2 month')); ?>
                        <?php
                            $this->db->where("salary_month BETWEEN '$a2' and '$a1'");
                            $this->db->where('emp_id', $row->emp_id)->order_by('salary_month', 'asc');
                            $sals = $this->db->get('pay_salary_sheet')->result();
                            $total_gross = 0;
                            $total_attn = 0;
                            $total_fb = 0;
                            $total_ab = 0;
                            $total = 0;
                        ?>
                        <?php foreach ($sals as $s) { ?>
                        <?php $a =  eng2bn_month($s->salary_month); ?>
                        <?php
                            $fbonus = 0;
                            if ($row->festival_month == $s->salary_month) {
                                $fbonus = $row->festival_bonus;
                            };
                            $abonus = 0;
                            if ($row->abenifit_month == $s->salary_month) {
                                $abonus = $row->ather_benifit;
                            };
                            $total_gross = $s->gross_sal + $total_gross;
                            $total_attn = $s->att_bonus + $total_attn;
                            $total_fb = $fbonus + $total_fb;
                            $total_ab = $abonus + $total_ab;
                            $sub_total = $s->gross_sal + $s->att_bonus + $fbonus + $abonus;
                            $total = $sub_total + $total;
                        ?>
                        <tr style="font-size:16px; text-align:center;font-family:SutonnyMJ;font-size:19px">
                            <td class="unicode-to-bijoy" style="padding:5px; width:15%;font-family:arial"><?= $a; ?>  </td>
                            <td><span>‡eZb</span></td>
                            <td><?= $s->gross_sal ?></td>
                            <td><?= $s->att_bonus ?></td>
                            <td><?= $s->att_bonus + $s->gross_sal ?></td>
                            <td><?= $fbonus ?></td>
                            <td><?= $abonus ?></td>
                            <td><?= $sub_total ?></td>
                        </tr>
                        <?php } ?>
                        <tr style="text-align:center;font-family:SutonnyMJ">
                            <td colspan="2" style="font-size:19px" ><span>‡gvU</span></td>
                            <td style="padding:5px; font-size:19px" ><?= $total_gross ?></td>
                            <td style="padding:5px; font-size:19px" ><?= $total_attn ?></td>
                            <td style="padding:5px; font-size:19px" ><?= $total_gross + $total_attn ?></td>
                            <td style="padding:5px; font-size:19px" ><?= $total_fb ?></td>
                            <td style="padding:5px; font-size:19px" ><?= $total_ab ?></td>
                            <td style="padding:5px; font-size:19px"><?= ($total) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div style="font-size:16px; font-family: Arial, Helvetica, sans-serif; clear: both; padding:20px 10px;">
                <table style="width: 100%; padding:0px 10px; font-size:16px;" border="1" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr style="font-family:SutonnyMJ; font-size:19px; text-align:center">
                            <th style="padding:5px">weeiY</th>
                            <th style="padding:5px">UvKv</th>
                            <th style="padding:5px">cÖ_g wKw¯Íi myweav</th>
                            <th style="padding:5px"><?= round((($total / $row->pay_day) * $row->total_day), 2) ?></th>
                        </tr>
                        <tr style="font-family:SutonnyMJ; font-size:19px; text-align:center">
                            <td style="padding:5px">c«wZw`‡bi Mo ‡eZb (‡gvU ‡eZb <?= $total ?> <span style="font-size: 12px;" >➗</span> <?= $row->pay_day ?> w`b)</td>
                            <td style="padding:5px"><?= round($total / $row->pay_day, 2) ?></td>
                            <td style="padding:5px">ivR¯ KZ©b</td>
                            <td style="padding:5px">10</td>
                        </tr>
                        <tr style="font-family:SutonnyMJ; font-size:19px; text-align:center">
                            <td style="padding:5px">‡gvU c«‡`q UvKvi cwigvY ( c«wZw`‡bi Mo ‡eZb <?= round($total / $row->pay_day, 2) ?> &#10005; <?= $row->total_day * 2 ?> w`b) </td>
                            <td style="padding:5px"><?= round((($total / $row->pay_day) * ($row->total_day * 2)), 2) ?></td>
                            <td style="padding:5px">‡gvU UvKv </td>
                            <td style="padding:5px"><?= round((($total / $row->pay_day) * $row->total_day), 2) - 10 ?></td>
                        </tr>
                        <tr style="font-family:SutonnyMJ; font-size:19px; text-align:center">
                            <td style="padding:5px">cÖ_g wKw¯Í ( c«wZw`‡bi Mo ‡eZb <?= round($total / $row->pay_day, 2) ?> &#10005; <?= $row->total_day ?> w`b) </td>
                            <td style="padding:5px"><?= round((($total / $row->pay_day) * $row->total_day), 2) ?></td>
                        </tr>
                    </thead>
                </table>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; font-size:16px; clear: both; padding:20px 10px;">
                <div style="width: 70%; font-family:; font-family:SutonnyMJ">
                    <p style="font-size:19px"><span>cÖvß UvKv </span> : <?= round((($total / $row->pay_day) * $row->total_day), 2) ?>  UvKv </p>
                    <?php $totall = round((($total / $row->pay_day) * $row->total_day), 2); ?>
                    <p style="font-size:19px"><span>K_vq </span> : <?=  $obj->numToWord($totall) ?>  UvKv </p>
                </div>
                <div style="width: 30%; display: flex; align-items: center;">
                    <p style="width: 29%;border: 1px solid #000;padding:38px 0px 30px 0px;text-align: center;">গ্রহণকারীর স্বাক্ষর</p>
                    <p style="border: 1px solid #000;padding:58px 80px;"></p>
                </div>
            </div>

        <?php } ?>
    </div>
    <br><br>
    <div class="container">
        <!-- Summary Section -->
        <div class="row approvals text-center">
            <div class="col-md-6">
                <p class="unicode-to-bijoy">প্রস্তুতকারী</p>
            </div>
        </div>
        <br><br>
        <!-- Approvals Section -->
        <div class="row approvals text-center">
            <div class="col-md-4">
                <p class="unicode-to-bijoy">ব্যবস্থাপক
                <br>এইচ.আর.ডি</p>
            </div>
            <div class="col-md-4">
                <p class="unicode-to-bijoy">মহাব্যবস্থাপক
                <br>প্রজেক্ট হেড</p>
            </div>
            <div class="col-md-3">
                <p class="unicode-to-bijoy">MÖæc মহাব্যবস্থাপক
                 <br> (GBP.Avi.wW) </p>
            </div>
        </div>
        <br><br>
        <div class="row approvals text-center">
            <div class="col-md-4">
                <p class="unicode-to-bijoy">প্রধান পরিচালনাকারী কর্মকর্তা</p>
            </div>
            <div class="col-md-4">
                <p class="unicode-to-bijoy">উপ-ব্যবস্থাপনা পরিচালক</p>
            </div>
            <div class="col-md-4">
                <p class="unicode-to-bijoy">ব্যবস্থাপনা পরিচালক</p>
            </div>
        </div>
    </div>
    <br><br><br>
    <style>
        .approvals p {
            margin: 0 30px !important;
            font-size: 12px;
            border-top: 1px solid #000;
            padding-top: 5px;
            width: fit-content
        }

        .text-right .signature-line {
            margin-left: auto;
            margin-right: 0;
        }
    </style>


    <script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
    <?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>

</html>
<br><br><br>
<?php exit(); ?>
