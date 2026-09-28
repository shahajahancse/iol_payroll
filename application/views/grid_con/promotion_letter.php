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
            return $this->numberSelector($dot[0]).' দশমিক '.$this->numToBnDecimal($dot[1]);
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


<!doctype html>
<html lang="en">

<head>
    <title>Promotion Letter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:SutonnyMJ
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
            padding:2px;
        }
        p{
            font-size: 20px;
        }
    </style>
</head>

<body>
      <?php  foreach($values as $row){?>
    <div class="container w-75">
        <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/033</p>
        </div>
        <?php } else if($unit_id == 2){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : LSAL/HR/03/127</p>
        </div>
        <?php }else if($unit_id == 4){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 15.01.2022</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/008</p>
        </div>
        <?php }?>
        <div class="mt-3">
            <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
            <div class="d-flex">
                <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px;height: 45px;position: absolute;">
                <h1 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h4>
            </div>
        </div>
        <div class="col-md-12" style="border-bottom: 1px solid black!important;">
            <p class="text-center h4"><?= $com_info->company_add_bangla ?></p>
        </div>
        <div class="d-flex">
              <div class="col-md-6">
                  <p><?php echo ($unit_id == 1) ? 'G‡RGdGj' : (($unit_id == 2) ? 'GjGmGGj' : 'GBPwRGj') ?>/GBPAviwW/cÖ†j/<?php echo date('m/Y')?>/ <?php echo $row->letter_id?></p>
              </div>
            <div class="col-md-6" style="margin-left:240px"><p>ZvwiLt</p> </div>
            <!-- <div class="col-md-6 text-right">ZvwiLt < ?php echo date('d/m/Y')?> Bs</div> -->
        </div>

        <div>
            <h3 class="text-center" style="border-bottom: 2px solid black;width: 124px;margin: 0 auto;line-height: 18px;">AeMwZ cÎ</h3>
        </div>
            <!-- < ?php dd($row);?> -->
        <div class="ml-3" style="line-height: 10px;">
            <p class="mt-3">cÖwZ,</p>
            <p class='unicode-to-bijoy'>bvgt <?php echo '<span style="font-family:SutonnyMJ;font-size:19px">'.$row->name_bn.'</span>'?></p>
            <p class='unicode-to-bijoy'>c`ext <?php echo '<span style="font-family:Arial;font-size:19px">'.$row->new_desig_name.'</span>'?></p>
            <p class='unicode-to-bijoy'>KvWt <?php echo $row->emp_id?></p>
            <p class='unicode-to-bijoy'>‡mKkbt <?php echo '<span style="font-family:SutonnyMJ;font-size:19px">'.$row->new_sec_name.'</span>'?></p>
            <p class='unicode-to-bijoy'>jvBbt <?php echo '<span style="font-family:SutonnyMJ;font-size:19px">'.$row->new_line_name.'</span>'?></p>
            <p class='unicode-to-bijoy'>‡hvM`vbt <span style="font-family:SutonnyMJ;font-size:19px"><?php echo date('d/m/Y',strtotime($row->emp_join_date))?></span> Bs</p>
        </div>
        <br>
        <h5 class="ml-3"><b>welq t c‡`vbœwZ cÖm‡½|</b></h5>
        <br>
        <div class="ml-3">
            <p class="text-justify">
                <span>
                    <?php echo $row->gender == "Male"? 'Rbve':'Rbvev'?>,
                </span>
                <br>
                Avcbvi AeMwZi Rb¨ Rvbv‡bv hv‡”Q ‡h, ‡Kv¤úvbx KZ©…c¶ Avcbvi Kg©`¶Zvq mš‘ó n‡q Avcbv‡K
                <?php echo '<span style="font-size:14px">'.$row->prev_desig_name.'</span>'?> c`, ‡M«Wt
                <?php echo '<span font-size:19px;">'.($row->prev_grade_name =="None" ? '<span class="unicode-to-bijoy"> প্রযোজ্য নয় </span>' : $row->prev_grade_name).'</span>';?>  ‡_‡K
                <?php echo '<span style="font-size:14px">'.$row->new_desig_name.'</span>'?> c‡`, jvBbt
                <?php echo '<span style="font-size:18px">'.$row->new_line_name.'</span>'?> , ‡M«Wt
                <?php echo '<span font-size:19px">'.($row->new_grade_name =="None"? '<span class="unicode-to-bijoy">প্রযোজ্য নয় </span>': $row->new_grade_name).'</span>';?> G c‡`vbœwZ ‡`Iqvi wm×všÍ M…nxZ n‡q‡Q| Avcbvi c~‡e©i ‡eZb
                <?php echo $row->prev_salary?>
                UvKvi mv‡_ AviI
                <?php echo ($row->new_salary - $row->prev_salary)?> UvKv e…w× K‡i ‡gvU ‡eZb <?php echo $row->new_salary?> UvKv avh© Kiv nBj| hv A`¨  <?php echo date('d/m/Y',strtotime($row->effective_month))?> Bs ZvwiL n‡Z Kvh©Ki Kiv n‡e|
                Avcbvi ‡eZb e…w×i c~‡e©i I eZ©gvb gRyix KvVv‡gv Abyhvqx Zyjbvg~jK Z_¨ejx wbgœiæc|
            </p>

            <div>
               <table class="table table table-bordered text-center p-0" style="font-size: 19px">
                    <tr>
                        <th>weeib </th>
                        <th>‡eZb e„w×i c~‡e©i gRyix KvVv‡gv</th>
                        <th>eZ©gvb gRyix KvVv‡g</th>
                    </tr>
                    <tr>
                        <td>c`ex</td>
                        <td><?php echo '<span style="font-family:Arial;font-size:14px">'.$row->prev_desig_name.'</span>'?></td>
                        <td><?php echo '<span style="font-family:Arial;font-size:14px">'.$row->new_desig_name.'</span>'?></td>
                    </tr>
                    <tr>
                        <td>‡MÖW</td>
                        <td class="unicode-to-bijoy"><?php echo $row->prev_grade_name =="None"? '<span class="unicode-to-bijoy">প্রযোজ্য নয় </span>': $row->prev_grade_name?></td>
                        <td class="unicode-to-bijoy"><?php echo $row->new_grade_name =="None"? '<span class="unicode-to-bijoy">প্রযোজ্য নয় </span>': $row->new_grade_name?></td>
                    </tr>
                    <tr>
                        <td>g~j gRyix</td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><?php echo  $prev_basic =round(($row->prev_salary - (1250+750+450))/ 1.5) ; ?></td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><?php echo  $new_basic =round(($row->new_salary  - (1250+750+450))/ 1.5); ?></td>
                    </tr>
                    <tr>
                        <td>evox fvov (g~j gRyix 50%)</td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><?php echo round((($prev_basic/2)))?></td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><?php echo round((($new_basic/2)))?></td>
                    </tr>
                    <tr>
                        <td>wPwKrmv fvZv</td>
                        <td style="font-family:SutonnyMJ;font-size:19px">750</td>
                        <td style="font-family:SutonnyMJ;font-size:19px">750</td>
                    </tr>
                    <tr>
                        <td>hvZvqZ fvZv</td>
                        <td style="font-family:SutonnyMJ;font-size:19px">450</td>
                        <td style="font-family:SutonnyMJ;font-size:19px">450</td>
                    </tr>
                    <tr>
                        <td>Lv`¨ fvZv</td>
                        <td style="font-family:SutonnyMJ;font-size:19px">1250</td>
                        <td style="font-family:SutonnyMJ;font-size:19px">1250</td>
                    </tr>
                    <tr>
                        <td><b>me©‡gvU gRyix</b></td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><b><?php echo $row->prev_salary?></b></td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><b><?php echo $row->new_salary?></b></td>
                    </tr>
                    <tr>
                        <td>Ifvi UvBg fvZvi nvi / N›Uv cÖwZ</td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><?php echo round($prev_basic/104,2)?></td>
                        <td style="font-family:SutonnyMJ;font-size:19px"><?php echo round($new_basic/104,2)?></td>
                    </tr>
                    <!-- <tr>
                        <td colspan='2' style="text-align:right;margin-right:170px" ><b style="margin-right:170px" > gRyix e„w× <b></td>
                        <td style="font-family:SutonnyMJ;font-size:19px">< ?php echo round($new_basic/104,2)?></td>
                    </tr> -->
                </table>
                <span class='unicode-to-bijoy' style='font-size:19px'><b style="font-size:20px">K_vqt</b> <?php $a= ($row->new_salary - $row->prev_salary); echo $obj->numToWord($a);?></span>
                <p>Avkv Kwi fwel¨‡Z Avcwb Avcbvi AwaKZi Kg©`¶Zvi cwiPq w`‡eb Ges ‡Kv¤úvbxi DË‡ivËi mg…w×‡Z Avi mqvnK f~wgKv cvjb Ki‡eb|</p>
            </div>

            <div style="line-height: 10px;">
                <div style="line-height: 10px;">
                <p style="margin-bottom: 110px !important;">ab¨ev`v‡šÍ,</p>
                <!-- <hr style="border: 1px solid black; width: 340px;float:left;display: block;"><br>
                <br> -->
                <p style="border-top: 1px solid black; line-height: 1.5; width: 380px;" class="mt-2">wefvMxq cÖavb (GBPAvi, GWwgb GÛ Kgcøv‡qÝ)</p>
                <p><?= $com_info->company_name_bangla ?></p>
                <p class="mt-5">Abywjwct</p>
                <p>1| MÖæc ‡Rbv‡ij g¨v‡bRvi (GBPAvi, GWwgb GÛ Kgcøv‡qÝ)</p>
                <p>2| ‡Rbv‡ij g¨v‡bRvi (cÖ‡R± ‡nW)</p>
                <p>3| wefvMxq c«avb</p>
                <p>4| e¨w³MZ bw_</p>
                <p class="text-right mt-5">MÖnbKvixi ¯^vÿi............................................</p>
            </div>
            </div>
        </div>
    </div>
    <div style="page-break-after: always"></div>
    <?php }?>
    <script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
    <?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>
</html>
<?php exit(); ?>
