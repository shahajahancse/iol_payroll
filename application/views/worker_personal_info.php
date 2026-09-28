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

 //দুই লক্ষ পনের হাজার দুই শত পঁয়তাল্লিশ

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Your New Title</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <style>
            .table td{
                padding: 0px;

            }
            p{
                margin-bottom: 4px;
            }
            @page{
                margin-bottom: 0px !important;
            }
            @media print{
                .break_page{
                    page-break-before: always;
                }
                body{
                    text-align: justify;
                    /* margin: 0px; */
                }
                .vl {
                    margin-left: 100px;
                }

                img{
                    width: 20%;
                }

                .container {
                    size: A4;
                    margin-top:1px !important;
                    margin-right: 10px !important;
                    padding-left:10px !important;
                    padding:0px !important;
                }
            }

            .title_box{
                display: flex;
                flex-direction: column;
                border: 2px solid black;
                width: 260px;
                align-items: center;
                margin: 0 auto;
             }
             .table th {
                border-top: 1px solid #000000;
            }
            p{
                font-size:21px
            }
            table th,td {
                font-size:21px;
            }
            .potovumi{
                font-size: 20px;
            }
            .vl {
                border-left: 1px solid gray;
                height: 175px;
                position: absolute;
                left: 77%;
                margin-top: 190px;
                transform: rotate(13deg);
            }
        </style>
    </head>

    <body style="">
        <!-- niog -->
        <?php
            // dd($values);
            $company_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row();
            $image = $company_info->company_logo;
            $company_name_bangla = $company_info->company_name_bangla;
            $company_add_bangla = $company_info->company_add_bangla;
            foreach($values as $value){
                // dd($value);
        ?>
        <div class="container break_page" style=" font-family: sutonnymj;">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/008</p>
            </div>
            <?php } else if($unit_id == 2){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;"> Document Code : LSAL/HR/03/084</p>
            </div>
            <?php }else if($unit_id == 4){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/008</p>
            </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5"><?= $com_info->company_add_bangla ?></p>
            </div>
            <div class="d-flex mt-2">
                <div class="col-md-4">
                <p>ZvwiLt <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</p>
                    <!-- <p style="font-size:21px !important;line-height:22px !important;">myÎt <?php echo $unit_id == 1 ? "G‡R.Gd.Gj":($unit_id ==2?"Gj.Gm.G.Gj":"GBP.wR.Gj")?>/GBP.Avi.wW/G.Gj/5523 <br><span>ZvwiLt <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</span></p> -->
                </div>
                <div class="col-md-4">
                    <h2 class="text-center"><b style="border: 2px solid black;padding-left:4px;padding-right:6px;">wb‡qvM cÎ</b></h2>
                </div>
                <div class="col-md-4">
                    <p style="float:right; font-size:21px !important;line-height:1 !important;">kªwgK Kwc</p>
                </div>
            </div>
            <div style="margin-left: 2px;">
                <div class="col-md-10">
                    <p style="font-size:21px !important;line-height:1 !important;">cÖwZ,</p>
                    <table style="line-height:1 !important;">
                        <!-- <tr>
                            <td>ZvwiL</td>
                            <td>t</td>
                            <td></td>
                        </tr> -->
                        <tr>
                            <!-- <td><?php echo $value->gender == 'Male' ? 'Rbve' : ' Rbvev' ?></td> -->
                            <th>bvg</th>
                            <td>t</td>
                            <td><span class='unicode-to-bijoy' style="font-size:21px;margin-left:2px"> <?php echo $value->name_bn?> </span></td>
                        </tr>
                        <!-- <tr>
                            <th >bvg </th>
                            <td> t </td>
                            <td> <span style="font-size:15px;margin-left:2px"> < ?php echo $ value-> name_bn?> </span></td>
                        </tr> -->
                        <tr>
                            <th style='white-space:nowrap'>wcZvi bvg</th>
                            <td>t</td>
                            <td  class='unicode-to-bijoy' style='white-space:nowrap'><?php echo '<span style="font-size:15px;">'.$value->father_name.', </span>'.' <b>gvZvi bvgt</b> '.'<span style="font-size:15px;">'.$value->mother_name.'</span>'.', <b>¯^vgx/¯¿xi bvgt</b> '.'<span style="font-size:15px;">'.$value->spouse_name.'</span>'?>     </td>
                        </tr>


                        <tr>
                            <th style='white-space:nowrap'>eZ©gvb wVKvbv </th>
                            <td> t </td>
                            <td class='unicode-to-bijoy'> <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->pre_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->pre_post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->pre_upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->pre_dis_name_bn.'</span>'?></span></td>
                        </tr>
                        <tr>
                            <th style='white-space:nowrap'>¯’vqx wVKvbv </th>
                            <td> t </td>
                            <td class='unicode-to-bijoy'> <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->per_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->dis_name_bn.'</span>'?></span> </td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="col-md-12">
                    <p style="font-size:21px !important;line-height:21px !important;">
                        <span class='unicode-to-bijoy'><?php echo $value->gender == 'Male' ? 'Rbve': 'Rbvev'?>,</span><br>
                        <p style="text-align: justify;line-height:1" class='unicode-to-bijoy'>
                            A`¨ <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs Zvwi‡Li Av‡e`bc‡Îi cwi‡cÖwÿ‡Z, cieZ©x‡Z ‡Kv¤úvbx KZ©…c‡¶i mv‡_ Avcbvi mv¶vrKv‡i Df‡qi m¤§wZ µ‡g Avcbv‡K  AÎ KviLvbvq wb‡qvM ‡`Iqv n‡jv Ges eZ©gv‡b Avcbvi <b>c`ex</b> n‡e <?php echo "<span style='font-size:15px'>".$value->desig_bangla."</span>"?>, <b>‡MÖWt</b> <?php echo "<span style='font-size:15px'>".$value->grade.'</span>'?>, <b>AvBwW bs t</b> <?php echo $value->per_emp_id?>, <b>‡mKkb/jvBbt</b>  <span style='font-size:15px'><?php echo $value->line_name_bn?> </span>, ‡Kv¤úvbx KZ©…c¶ ‡h ‡Kvb mgq Avcbvi Kv‡Ri cÖK„wZ cwieZ©b Ki‡Z cvi‡eb| GgbwK AÎ MÖæ‡ci ‡h ‡Kvb KviLvbvq A_ev ‡h ‡Kvb  ‡mKk‡b e`jx Ki‡Z cvi‡eb|
                        </p>
                    </p>
                    <p style="font-size:1 !important;"><b>kZv©ejxt</b></p>
                    <p style="line-height:1 !important">1.
                        Avcbvi PvKyixi cÖ_g wZb (03) gvm gvm wkÿvbwek wn‡m‡e _vK‡eb| D³ wkÿvbwek †gqv`v‡šÍ hw` Kg© †hvM¨Zv gvb m¤úbœ bv nq Zvn‡j wkÿvbwek mgq AwZwi³ wZb (03) gvm e„w× Kiv †h‡Z cv‡i Ges wkÿvbwek mgqKv‡j †Kv¤úvbx KZ…©cÿ Ges Avcwb †h †Kvb mgq †Kvb c~e© †bvwUk Qvov Avcbvi PvKyixi Aemvb Ki‡Z cvi‡eb| wkÿvbwek mgq AwZevwnZ nIqvi ci Avcbv‡K ¯’vqx kÖwgK wn‡m‡e MY¨ Kiv n‡e Ges Gi Rb¨ †Kvb wPwV †`Iqv n‡e bv|
                    <p style="font-size:21px !important;line-height:1 !important;">
                        2. Avcbvi gRyix / †eZb KvVv‡gv wb¤œiæct
                        <div class='d-flex align-items-end'>
                            <table style="line-height: 1;">
                                <tr>
                                    <th>K) g~j gRyix</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px" class='unicode-to-bijoy'> <?php $basic = round(($value->salary -(1250+450+750)) / 1.5); echo $basic;?></td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>L) evox fvov (g~j gRyixi 50%)</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px" class='unicode-to-bijoy'> <?php echo round($basic/2)?> </td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>M) wPwKrmv fvZv</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px"> 750 </td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>N) hvZvqvZ fvZv</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px"> 450</td>
                                    <td>UvKv</td>
                                </tr>
                                <tr style="border-bottom:1px solid black">
                                    <th>O) Lv`¨ fvZv</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px"> 1250</td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>gvwmK me©‡gvUt</th>
                                    <th>t</td>
                                    <th></td>
                                    <th style="margin-left:2px" class='unicode-to-bijoy'> <span><?php echo $value->salary?></span></th>
                                    <th> UvKv  </th>
                                </tr>
                            </table>


                            <table style="font-size:21px;line-height: 1;margin-left:100px">
                                <tr style='vertical-align:baseline'>
                                    <td><b>K_vq t </b></td>
                                    <td style="padding-left:5px;font-size:21px;" class='unicode-to-bijoy'><?php echo $obj->numToWord( $value->salary);?> </td>
                                    <td style="padding-left:5px;"> UvKv </td>
                                </tr>
                            </table>


                        </div>

                    </p>
                    <p style='line-height:1'>3. cÖ‡Z¨K kÖwg‡Ki cvIbvw` cieZ©x gv‡mi 7g Kg© w`e‡mi g‡a¨ cÖ`vb Kiv n‡e| Ab¨vb¨ cvIbvw` evsjv‡`k kÖg AvBb Abyhvqx cÖ`vb Kiv n‡e|</p>
                    <p style='line-height:1'>4. Avcbvi Kg©N›Uv n‡e mKvj 8:00 NwUKv n‡Z weKvj 5:00 NwUKv chšÍ©| KviLvbv KZ…©cÿ Riæix cÖ‡qvR‡b AvBbvbyhvqx AwZwi³ mgq KvR Kiv‡Z cvi‡eb|</p>

                    <p style='line-height:1'>5. mvßvwnK QzwU wn‡m‡e kÖwgK‡`i †K 1 (&GK) w`b c~Y© w`em QzwU cÖ`vb Kiv n‡e| hv miKvix wb‡`©kbv Abyhvqx GjvKv‡f‡` wewfbœ w`b n‡Z cv‡i|</p>

                    <p style='line-height:1'>6. kÖwgKMY evsjv‡`k kÖg AvBb Abyhvqx mKj QzwU †fvM Ki‡Z cvi‡eb|</p>

                    <p style='line-height:1'>7. cÖwZ Kg©w`e‡m wekÖvg, Avnvi, bvgvR I Ab¨vb¨ Kv‡Ri Rb¨ 01 (GK) N›Uv weiwZ cÖ`vb Kiv nq|</p>

                    <p style='line-height:1'>8. Avcwb 1 (GK) eQi Kg©iZ _vKvi ci gyj gRyixi 5% nv‡i µgvš^‡q evrmwiK gRyix e„w× cvB‡e|</p>

                    <p style='line-height:1'>9. PvKzix n‡Z B¯Ídv/c`Z¨vM t cÖ‡Z¨K ¯’vqx kÖwgK 60 w`‡bi wjwLZ †bvwUk cÖ`vb K‡i PvKyix n‡Z B¯Ídv w`‡Z cvi‡eb| webv †bvwU‡k PvKzix n‡Z B¯Ídv w`‡Z PvB‡j †bvwU‡ki cwie‡Z© 60 w`‡bi g~j gRyixi mgcwigvb A_© gvwjK‡K cÖ`vb Ki‡Z n‡e| gvwjK KZ…©K webv †bvwU‡k †Kvb kÖwg‡Ki PvKwiP‚¨wZ ev PvKzixi Aemvb n‡j gvwjK evsjv‡`k kÖg AvBb Abyhvqx D³ kÖwgK‡K Zvi hveZxq cvIbvw` cÖ`vb Ki‡eb|</p>

                    <p style='line-height:1'>10. Avcbv‡K GKwU Qwe m¤^wjZ Awdm AvBwW KvW© cÖ`vb Kiv n‡e hv Avcbvi cwiPqcÎ wn‡m‡e Mb¨ n‡e Ges Kg©‡ÿ‡Î Bnv Mjvq Szwj‡q cÖ`k©b Kwi‡Z n‡e|</p>

                    <p style='line-height:1'>11. AÎ cÖwZôv‡bi Kg©iZ Ae¯’vq †Kv_vI cÖZ¨ÿ ev c‡ivÿfv‡e PvKzix GgbwK e¨emv msµvšÍ †Mvcbxq Z_¨vw` †Kvb e¨w³, e¨emv cÖwZôvb A_ev Ab¨ Kv‡iv wbKU cÖKvk Ki‡Z cvi‡eb bv|</p>

                    <p style='line-height:1'>12. m¤úwË Pzwi, Af¨vmMZ wej‡¤^ Dcw¯’wZ, webv QzwU‡Z Af¨vmMZ Abycw¯’wZ, cÖwZôv‡b Dk„•Lj ev `vsMv-nv½vgvg~jK AvPiY, k„•Ljv nvwbi †Kvb KvR †Kvb AvBb ev wewai Af¨vmMZ jsNb, Kv‡R K‡g© Af¨vmMZ MvwdjwZ Ges DaŸ©Zb Kg©KZ©vi AvBbmsMZ ev hyw³msMZ Av‡`k cvjb bv Kivmn Ab¨vb¨ †h †Kvb Am`vPib cÖgvwbZ n‡j evsjv‡`k kÖg AvBb, 2006 ms‡kvabxmg~n AbymiY K‡i †h †Kvb kÖwg‡Ki weiæ‡× eiLv¯Í/kvw¯ÍgyjK e¨e¯’v MÖnb Ki‡Z cv‡i|</p>

                    <p style='line-height:1'>13. wb‡qv‡Mi †ÿ‡Î Ges Kg©‡ÿ‡Î KLbI RvwZ, eY©, ag© Ges wj½ †f‡` cÿcvZg~jK ev nqivbxg~jK AvPivY Kiv nq bv Ges KviI B”Qvi weiæ‡× †Rvi c~e©K †Kvb KvR Kiv‡bv nq bv| Kg©‡ÿ‡Î †Kvb kªwg‡Ki ‡ÿvf n‡j Zv mywbw`©ó cš’vq cÖKvk Kivi ¯^vaxbZv i‡q‡Q Ges KZ…©cÿ †ÿvf wbim‡b Dchy³ cš’v Aej¤^b K‡i _v‡K|</p>

                    <p style='line-height:1'>14. Avcbvi PvKzixi cwimgvwß NU‡j Avcwb GB †Kv¤úvYxi mg¯Í KvMRcÎ, `wjjvw` A_ev Ab¨ †Kvb e¯‘ hvnv Avcbvi †ndvR‡Z _vKyK bv †Kb †m mKj `ªe¨vw` Avcwb †diZ w`‡eb Ges †Kv¤úvYxi e¨emv msµvšÍ †Kvb KvMR c‡Îi bKj A_ev Dnvi Ask we‡kl Avcbvi wbKU ivL‡Z cvi‡eb bv|</p>

                    <p style='line-height:1'>15. Avcbvi PvKzixi Ab¨vb¨ kZ©vejx cÖwZôv‡bi wbqg I evsjv‡`k kÖg AvBb Abyhvqx cwiPvwjZ n‡e|</p>
                    <p>
                        Avwg wb‡qvMcÎ c‡o Ges ewb©Z kZ©vw` m¤ú‡K© m¤ú~b©i~‡c AeMZ n‡q GB wb‡qvMc‡Îi Kwc MÖnb K‡i ¯^vÿi KiwQ
                    </p>

                </div>
            </div><br>
            <div class="d-flex">
                <div class="col-md-6" style='line-height:1'>
                    <p style="font-size:21px !important;">KZ©…c¶</p><br>
                    <p>........................</p>
                    <p>wefvMxq cÖavb (gvbem¤ú`)</p>
                    <p style='font-size:21px'><?php echo $com_info->company_name_bangla?></p>
                </div><br><br>
                <div class="col-md-6 justify-content-end" style='margin-top:34px'>
                   <table style="margin-left:206px">
                    <tr>
                        <td> <p style="font-size:21px !important;line-height:18px;white-space:nowrap">¯^vÿit ................ √.......................</p>
                   </td>
                    </tr>
                    <tr>
                        <td class='unicode-to-bijoy'> <p style="font-size:21px !important;line-height:18px;">bvgt <span style="font-size:15px"><?php echo $value->name_bn?></span></p>
                  </td>
                    </tr>
                    <tr><td class='unicode-to-bijoy'>  <p style="font-size:21px !important;line-height:18px;">c`ext <span style="font-size:15px"><?php echo $value->desig_bangla?></span></p></td></tr>
                   </table>
                </div>
            </div>
        </div>


        <div class="container break_page" style=" font-family: sutonnymj;">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/008</p>
            </div>
            <?php } else if($unit_id == 2){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;"> Document Code : LSAL/HR/03/084</p>
            </div>
            <?php }else if($unit_id == 4){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/008</p>
            </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5"><?= $com_info->company_add_bangla ?></p>
            </div>
            <div class="d-flex mt-2">
                <div class="col-md-4">
                <p>ZvwiLt <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</p>
                    <!-- <p style="font-size:21px !important;line-height:22px !important;">myÎt <?php echo $unit_id == 1 ? "G‡R.Gd.Gj":($unit_id ==2?"Gj.Gm.G.Gj":"GBP.wR.Gj")?>/GBP.Avi.wW/G.Gj/5523 <br><span>ZvwiLt <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</span></p> -->
                </div>
                <div class="col-md-4">
                    <h2 class="text-center"><b style="border: 2px solid black;padding-left:4px;padding-right:6px;">wb‡qvM cÎ</b></h2>
                </div>
                <div class="col-md-4">
                    <p style="float:right; font-size:21px !important;line-height:1 !important;">Awdm Kwc</p>
                </div>
            </div>
            <div style="margin-left: 2px;">
                <div class="col-md-10">

                    <p style="font-size:21px !important;line-height:1 !important;">cÖwZ,</p>
                    <table style="line-height:1 !important;">
                        <!-- <tr>
                            <td>ZvwiL</td>
                            <td>t</td>
                            <td><?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</td>
                        </tr> -->
                        <tr>
                            <!-- <td><?php echo $value->gender == 'Male' ? 'Rbve' : ' Rbvev' ?></td> -->
                            <th>bvg</th>
                            <td>t</td>
                            <td class='unicode-to-bijoy'><span style="font-size:21px;margin-left:2px"> <?php echo $value->name_bn?> </span></td>
                        </tr>
                        <!-- <tr>
                            <th >bvg </th>
                            <td> t </td>
                            <td> <span style="font-size:15px;margin-left:2px"> <?php echo $value->name_bn?> </span></td>
                        </tr> -->
                        <tr>
                            <th style='white-space:nowrap'>wcZvi bvg</th>
                            <td>t</td>
                            <td class='unicode-to-bijoy' style='white-space:nowrap'><?php echo '<span style="font-size:15px;">'.$value->father_name.', </span>'.' <b>gvZvi bvgt</b> '.'<span style="font-size:15px;">'.$value->mother_name.'</span>'.', <b>¯^vgx/¯¿xi bvgt</b> '.'<span style="font-size:15px;">'.$value->spouse_name.'</span>'?>     </td>
                        </tr>

                        <tr>
                            <th style='white-space:nowrap'>eZ©gvb wVKvbv </th>
                            <td> t </td>
                            <td class='unicode-to-bijoy'>  <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->pre_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->pre_post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->pre_upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->pre_dis_name_bn.'</span>'?></span></td>
                        </tr>
                        <tr>
                            <th style='white-space:nowrap'>¯’vqx wVKvbv </th>
                            <td> t </td>
                            <td class='unicode-to-bijoy'> <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->per_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->dis_name_bn.'</span>'?></span> </td>
                        </tr>
                    </table>
                </div><br>
                <div class="col-md-12">
                    <p style="font-size:21px !important;line-height:21px !important;">
                        <span class='unicode-to-bijoy'><?php echo $value->gender == 'Male' ? 'Rbve': 'Rbvev'?>,</span><br>
                        <p style="text-align: justify;line-height:1" class='unicode-to-bijoy'>
                            A`¨ <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs Zvwi‡Li Av‡e`bc‡Îi cwi‡cÖwÿ‡Z, cieZ©x‡Z ‡Kv¤úvbx KZ©…c‡¶i mv‡_ Avcbvi mv¶vrKv‡i Df‡qi m¤§wZ µ‡g Avcbv‡K  AÎ KviLvbvq wb‡qvM ‡`Iqv n‡jv Ges eZ©gv‡b Avcbvi <b>c`ex</b> n‡e <?php echo "<span style='font-size:15px'>".$value->desig_bangla."</span>"?>, <b>‡MÖWt</b> <?php echo "<span style='font-size:15px'>".$value->grade.'</span>'?>, <b>AvBwW bs t</b> <?php echo $value->per_emp_id?>, <b>‡mKkb/jvBbt</b>  <span style='font-size:15px'><?php echo $value->line_name_bn?> </span>, ‡Kv¤úvbx KZ©…c¶ ‡h ‡Kvb mgq Avcbvi Kv‡Ri cÖK„wZ cwieZ©b Ki‡Z cvi‡eb| GgbwK AÎ MÖæ‡ci ‡h ‡Kvb KviLvbvq A_ev ‡h ‡Kvb  ‡mKk‡b e`jx Ki‡Z cvi‡eb|
                        </p>
                    </p>
                    <p style="font-size:1 !important;"><b>kZv©ejxt</b></p>
                    <p style="line-height:1 !important">1.
                        Avcbvi PvKyixi cÖ_g wZb (03) gvm gvm wkÿvbwek wn‡m‡e _vK‡eb| D³ wkÿvbwek †gqv`v‡šÍ hw` Kg© †hvM¨Zv gvb m¤úbœ bv nq Zvn‡j wkÿvbwek mgq AwZwi³ wZb (03) gvm e„w× Kiv †h‡Z cv‡i Ges wkÿvbwek mgqKv‡j †Kv¤úvbx KZ…©cÿ Ges Avcwb †h †Kvb mgq †Kvb c~e© †bvwUk Qvov Avcbvi PvKyixi Aemvb Ki‡Z cvi‡eb| wkÿvbwek mgq AwZevwnZ nIqvi ci Avcbv‡K ¯’vqx kÖwgK wn‡m‡e MY¨ Kiv n‡e Ges Gi Rb¨ †Kvb wPwV †`Iqv n‡e bv|
                    <p style="font-size:21px !important;line-height:1 !important;">
                        2. Avcbvi gRyix / †eZb KvVv‡gv wb¤œiæct
                        <div class='d-flex align-items-end'>
                            <table style="line-height: 1;">
                                <tr>
                                    <th>K) g~j gRyix</th>
                                    <td>t</td>
                                    <td></td>
                                    <td class='unicode-to-bijoy' style="margin-left:2px"> <?php $basic = round(($value->salary -(1250+450+750)) / 1.5); echo $basic;?></td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                     <th>L) evox fvov (g~j gRyixi 50%)</th>
                                    <td>t</td>
                                    <td></td>
                                    <td class='unicode-to-bijoy' style="margin-left:2px"> <?php echo round($basic/2)?> </td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>M) wPwKrmv fvZv</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px"> 750 </td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>N) hvZvqvZ fvZv</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px"> 450</td>
                                    <td>UvKv</td>
                                </tr>
                                <tr style="border-bottom:1px solid black">
                                    <th>O) Lv`¨ fvZv</th>
                                    <td>t</td>
                                    <td></td>
                                    <td style="margin-left:2px"> 1250</td>
                                    <td>UvKv</td>
                                </tr>
                                <tr>
                                    <th>gvwmK me©‡gvUt</th>
                                    <th>t</td>
                                    <th></td>
                                    <th class='unicode-to-bijoy' style="margin-left:2px"> <span><?php echo $value->salary?></span></th>
                                    <th> UvKv  </th>
                                </tr>
                            </table>


                            <table style="font-size:21px;line-height: 1;margin-left:100px">
                                <tr style='vertical-align:baseline'>
                                    <td><b>K_vq t </b></td>
                                    <td class='unicode-to-bijoy' style="padding-left:5px;font-size:21px;"><?php echo $obj->numToWord( $value->salary);?> </td>
                                    <td style="padding-left:5px;"> UvKv </td>
                                </tr>
                            </table>


                        </div>
                    </p>
                    <p style='line-height:1'>3. cÖ‡Z¨K kÖwg‡Ki cvIbvw` cieZ©x gv‡mi 7g Kg© w`e‡mi g‡a¨ cÖ`vb Kiv n‡e| Ab¨vb¨ cvIbvw` evsjv‡`k kÖg AvBb Abyhvqx cÖ`vb Kiv n‡e|</p>
                    <p style='line-height:1'>4. Avcbvi Kg©N›Uv n‡e mKvj 8:00 NwUKv n‡Z weKvj 5:00 NwUKv chšÍ©| KviLvbv KZ…©cÿ Riæix cÖ‡qvR‡b AvBbvbyhvqx AwZwi³ mgq KvR Kiv‡Z cvi‡eb|</p>

                    <p style='line-height:1'>5. mvßvwnK QzwU wn‡m‡e kÖwgK‡`i †K 1 (&GK) w`b c~Y© w`em QzwU cÖ`vb Kiv n‡e| hv miKvix wb‡`©kbv Abyhvqx GjvKv‡f‡` wewfbœ w`b n‡Z cv‡i|</p>

                    <p style='line-height:1'>6. kÖwgKMY evsjv‡`k kÖg AvBb Abyhvqx mKj QzwU †fvM Ki‡Z cvi‡eb|</p>

                    <p style='line-height:1'>7. cÖwZ Kg©w`e‡m wekÖvg, Avnvi, bvgvR I Ab¨vb¨ Kv‡Ri Rb¨ 01 (GK) N›Uv weiwZ cÖ`vb Kiv nq|</p>

                    <p style='line-height:1'>8. Avcwb 1 (GK) eQi Kg©iZ _vKvi ci gyj gRyixi 5% nv‡i µgvš^‡q evrmwiK gRyix e„w× cvB‡e|</p>

                    <p style='line-height:1'>9. PvKzix n‡Z B¯Ídv/c`Z¨vM t cÖ‡Z¨K ¯’vqx kÖwgK 60 w`‡bi wjwLZ †bvwUk cÖ`vb K‡i PvKyix n‡Z B¯Ídv w`‡Z cvi‡eb| webv †bvwU‡k PvKzix n‡Z B¯Ídv w`‡Z PvB‡j †bvwU‡ki cwie‡Z© 60 w`‡bi g~j gRyixi mgcwigvb A_© gvwjK‡K cÖ`vb Ki‡Z n‡e| gvwjK KZ…©K webv †bvwU‡k †Kvb kÖwg‡Ki PvKwiP‚¨wZ ev PvKzixi Aemvb n‡j gvwjK evsjv‡`k kÖg AvBb Abyhvqx D³ kÖwgK‡K Zvi hveZxq cvIbvw` cÖ`vb Ki‡eb|</p>

                    <p style='line-height:1'>10. Avcbv‡K GKwU Qwe m¤^wjZ Awdm AvBwW KvW© cÖ`vb Kiv n‡e hv Avcbvi cwiPqcÎ wn‡m‡e Mb¨ n‡e Ges Kg©‡ÿ‡Î Bnv Mjvq Szwj‡q cÖ`k©b Kwi‡Z n‡e|</p>

                    <p style='line-height:1'>11. AÎ cÖwZôv‡bi Kg©iZ Ae¯’vq †Kv_vI cÖZ¨ÿ ev c‡ivÿfv‡e PvKzix GgbwK e¨emv msµvšÍ †Mvcbxq Z_¨vw` †Kvb e¨w³, e¨emv cÖwZôvb A_ev Ab¨ Kv‡iv wbKU cÖKvk Ki‡Z cvi‡eb bv|</p>

                    <p style='line-height:1'>12. m¤úwËPzwi, Af¨vmMZ wej‡¤^ Dcw¯’wZ, webv QzwU‡Z Af¨vmMZ Abycw¯’wZ, cÖwZôv‡b Dk„•Ljev `vsMv-nv½vgvg~jK AvPiY, k„•Ljvnvwbi †Kvb KvR †Kvb AvBb evwewai Af¨vm MZ jsNb, Kv‡R K‡g© Af¨vm MZ MvwdjwZ Ges DaŸ©Zb Kg©KZ©vi AvBb msMZ ev hyw³ msMZ Av‡`k cvjb bv Kiv mn Ab¨vb¨ †h †Kvb Am`vPib cÖgvwbZ n‡j evsjv‡`k kÖg AvBb, 2006 ms‡kvabx mg~n AbymiY K‡i †h †Kvb kÖwg‡Ki weiæ‡× eiLv¯Í/kvw¯ÍgyjK e¨e¯’v MÖnb Ki‡Z cv‡i|</p>

                    <p style='line-height:1'>13. wb‡qv‡Mi †ÿ‡Î Ges Kg©‡ÿ‡Î KLbI RvwZ, eY©, ag© Ges wj½ †f‡` cÿcvZg~jK ev nqivbxg~jK AvPivY Kiv nq bv Ges KviI B”Qvi weiæ‡× †Rvi c~e©K †Kvb KvR Kiv‡bv nq bv| Kg©‡ÿ‡Î †Kvb kªwg‡Ki ‡ÿvf n‡j Zv mywbw`©ó cš’vq cÖKvk Kivi ¯^vaxbZv i‡q‡Q Ges KZ…©cÿ †ÿvf wbim‡b Dchy³ cš’v Aej¤^b K‡i _v‡K|</p>

                    <p style='line-height:1'>14. Avcbvi PvKzixi cwimgvwß NU‡j Avcwb GB †Kv¤úvYxi mg¯Í KvMRcÎ, `wjjvw` A_ev Ab¨ †Kvb e¯‘ hvnv Avcbvi †ndvR‡Z _vKyK bv †Kb †m mKj `ªe¨vw` Avcwb †diZ w`‡eb Ges †Kv¤úvYxi e¨emv msµvšÍ †Kvb KvMR c‡Îi bKj A_ev Dnvi Ask we‡kl Avcbvi wbKU ivL‡Z cvi‡eb bv|</p>

                    <p style='line-height:1'>15. Avcbvi PvKzixi Ab¨vb¨ kZ©vejx cÖwZôv‡bi wbqg I evsjv‡`k kÖg AvBb Abyhvqx cwiPvwjZ n‡e|</p>
                    <p>
                        Avwg wb‡qvMcÎ c‡o Ges ewb©Z kZ©vw` m¤ú‡K© m¤ú~b©i~‡c AeMZ n‡q GB wb‡qvMc‡Îi Kwc MÖnb K‡i ¯^vÿi KiwQ
                    </p>

                </div>
            </div><br>
            <div class="d-flex">
                <div class="col-md-6" style='line-height:1'>
                    <p style="font-size:21px !important;">KZ©…c¶</p><br>
                    <p>........................</p>
                    <p>wefvMxq cÖavb (gvbem¤ú`)</p>
                    <p class='unicode-to-bijoy' style='font-size:21px'><?php echo $com_info->company_name_bangla?></p>
                </div><br><br>
                <div class="col-md-6 justify-content-end" style='margin-top:34px'>
                   <table style="margin-left:206px">
                    <tr>
                        <td> <p style="font-size:21px !important;line-height:18px;white-space:nowrap">¯^vÿit ................ √.......................</p>
                   </td>
                    </tr>
                    <tr>
                        <td class='unicode-to-bijoy'> <p style="font-size:21px !important;line-height:18px;">bvgt <span style="font-size:15px"><?php echo $value->name_bn?></span></p>
                  </td>
                    </tr>
                    <tr><td class='unicode-to-bijoy'>  <p style="font-size:21px !important;line-height:18px;">c`ext <span style="font-size:15px"><?php echo $value->desig_bangla?></span></p></td></tr>
                   </table>
                </div>
            </div>
        </div>


        <!-- jogdan -->
        <div class="container break_page" style="font-family:sutonnymj;">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/008</p>
            </div>
            <?php } else if($unit_id == 2){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : LSAL/HR/03/084</p>
            </div>
            <?php }else if($unit_id == 4){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/008</p>
            </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center unicode-to-bijoy" style="margin:0 auto" ><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5 unicode-to-bijoy"><?= $com_info->company_add_bangla ?></p>
            </div>
            <!-- <div class="row"> -->
            <br>

            <h2 class="text-center mt-2"><b style="border: 2px solid black;padding-left:6px;padding-right:6px;">Kv‡R †hvM`vb cÎ</b></h2>
            <!-- </div> -->
            <div class="row mt-4">
                <div class="col-md-6 mt-4">
                    <table>
                        <!-- <tr>
                            <th>AvBwWt </th>
                            <td>  </td>
                            <td>< ?php echo $value->per_emp_id ?></td>
                        </tr> -->
                        <tr>
                            <th>ZvwiLt </th>
                            <td> </td>
                            <td class='unicode-to-bijoy'><?php echo date("d-m-Y",strtotime($value->emp_join_date))?> Bs</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-12 mt-3">

                    <p style="font-size:21px;">eivei,</p>
                    <p style="font-size:21px;">gvbem¤ú` wefvM</p>
                    <!-- <p style="font-size:21px;">cwiPvjK/wbev©nx cwiPvjK/gnve¨e¯’vcK/KviLvbv e¨e¯’vcK</p> -->
                    <p style="font-size:21px;" class='unicode-to-bijoy'><b><?= "<span style='font-size:21px'>".$company_name_bangla."</span>" ; ?> </b></p>
                    <!-- <p style="font-size:21px;">KviLvbvi bvgt  <b>< ?= "<span style='font-size:15px'>".$company_name_bangla."</span>" ; ?> </b></p> -->
                    <p style="font-size:21px;" class='unicode-to-bijoy'>wVKvbvt <?php echo '<span style="font-size:15px">'.$company_add_bangla.'</span>'?>|</p>
                    <p style="font-size:24px;" class="mt-4 unicode-to-bijoy"><b>welqt Kv‡R †hvM`vb cÎ</b></p>

                    <p style="font-size:21px;" class="mt-4 unicode-to-bijoy"><?php echo $value->gender == 'Male' ? 'Rbve': 'Rbvev'?>,</p>
                    <p style="font-size:21px;"> Avcbvi wbKU †_‡K cªvß wb‡qvM c‡Îi AvBwW bs <?php echo $value->per_emp_id?> ZvwiL <?php echo date("d-m-Y",strtotime($value->emp_join_date))?> Bs Gi ‡cªwÿ‡Z Rvbv‡bv
                        hv‡”Q †h Avwg A`¨ <?php echo date("d-m-Y",strtotime($value->emp_join_date))?> Bs Avcbvi mybvgab¨ ‰Zwi ‡cvkvK wkí cÖwZôv‡b Dc‡i D‡jøwLZ wb‡qvM c‡Îi kZ© †gvZv‡eK  <span style="font-size:21px" class='unicode-to-bijoy'><?php echo $value->desig_bangla?></span> c‡` †hvM`vb KiwQ|</p>

                    <p style="font-size:21px;" class="mt-4"> AZGe, Avcbvi wbKU Av‡e`b GB †h, Avgvi `vwLjK„Z Kv‡R †hvM`vb cÎwU MÖnY Ki‡Z Avcbvi gwR© nq|</p>


                    <p style="font-size:21px;" class="mt-4">ab¨ev`v‡šÍ</p>
                                        <br>
                    <br>
                    <br>
                    <p style="font-size:21px;" class="mt-4">Avcbvi wek¦¯Í</p>
                </div>

                <div class="col-md-6">
                    <p style="font-size:21px;">¯^vÿit ................ √.......................</p>
                    <p style="font-size:21px;" class='unicode-to-bijoy'>bvgt <span style="font-size:15px"><?php echo $value->name_bn?></span></p>
                    <p style="font-size:21px;" class='unicode-to-bijoy'>c`ext <span style="font-size:15px"><?php echo $value->desig_bangla?></span></p>
                    <p style="font-size:21px;" class='unicode-to-bijoy'>AvBwW bst <span><?php echo $value->per_emp_id?></span></p>
                    <p style="">jvBbt <span class="unicode-to-bijoy"><?php echo '<span style="font-size:21px;">'.$value->line_name_bn."</span>" ?></span></p>
                </div>
            </div>
        </div>
        <br>

        <!-- potovumi -->
        <div class="container break_page" style=" font-family: sutonnymj;">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/005</p>
                </div>
                <?php } else if($unit_id == 2){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/086</p>
                </div>
                <?php }else if($unit_id == 4){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/005</p>
                </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center unicode-to-bijoy" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5 unicode-to-bijoy"><?= $com_info->company_add_bangla ?></p>
            </div>
            <br>
            <div class="title_box mt-2">
                <h3 style="font-family:Arial;border-bottom:1px solid black;padding-left:2px;padding-right:2px">Background Check</h3>
                <h3>cUf~wg wbixÿb</h3>
            </div>

            <div class="row">
                <div class="col-md-6 mt-4">
                    <table>
                        <!-- <tr>
                            <th>ZvwiLt </th>
                            <td>  </td>
                            <td><?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</td>
                        </tr> -->
                    </table>
                </div>
                <div class="col-md-12">

                    <p  class='unicode-to-bijoy' style="font-size:21px">1| bvgt <span style="font-size:15px"> <?php echo $value->name_bn?></span></p>
                    <p  class='unicode-to-bijoy' style="font-size:21px">2| c`ex t <span style="font-size:15px"> <?php echo $value->desig_bangla?></span>, KvW© bs t- <?php echo $value->per_emp_id?>, wefvM/†mKkb t <span style="font-size:15px"> <?php echo $value->line_name_bn?></span></p>
                    <p  class='unicode-to-bijoy' style="font-size:21px">3| wcZvi bvgt <span style="font-size:15px"> <?php echo $value->father_name?></span></p>
                    <p  class='unicode-to-bijoy' style="font-size:21px">4| gvZvi bvgt <span style="font-size:15px"> <?php echo $value->mother_name?></span></p>
                    <p  class='unicode-to-bijoy' style="font-size:21px">5| স্থায়ী wVKvbvt  <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->per_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->dis_name_bn.'</span>'?></span>  |</p>
                    <p class='unicode-to-bijoy' style="font-size:21px;margin-left:27px" >     wbR †gvevBj bs <span><?php echo $value->personal_mobile?></span>  AwfeveK †gvevBj bs <span><?php echo $value->refer_mobile?></span>  bwgwb †gvevBj bs <span><?php echo $value->nomi_mobile?></span></p>
                    <p class='unicode-to-bijoy' style="font-size:21px">6| eZ©gvb wVKvbvt <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->pre_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->pre_post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->pre_upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->pre_dis_name_bn.'</span>'?></span></span>|</p>








                    <p style="font-size:21px" class='unicode-to-bijoy'>7| wj½t <span style="font-size:15px"><?php echo $value->gender == 'Male' ? 'cyiæl':'নারী'?></span></p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>8| ‰eevwnK অবস্থাt <span><?php
                                                if($value->marital_status == 'Unmarried'){
                                                    echo 'AweevwnZ' ;
                                                }else{
                                                   echo 'weevwnZ ,' ;
                                                   echo $value->gender == 'Male' ? '  ¯¿xt '." <span style='font-size:15px'>".$value->spouse_name."</span>":' ¯^vgxt '." <span style='font-size:15px'>".$value->spouse_name."</span>";
                                                   echo ', mšÍv‡bi weeiYt ';
                                                   echo ' ‡Q‡jt '.$value->m_child;
                                                   echo ', ‡g‡qt '.$value->f_child;
                                                   echo ', ‡gvU mšÍvbt '.$value->f_child + $value->m_child;
                                                }
                                              ?>
                                        </span>
                    </p>

                    <p style="font-size:21px">10| fvovwUqv n‡j - </p>
                    <p class='unicode-to-bijoy' style="font-size:21px;margin-left:35px"> evwoi gvwj‡Ki bvgt  <span style="font-size:15px"><?php echo $value->pre_home_owner?></span>, †dvb/†gvevBj bs (hw` _v‡K)t <span><?php echo $value->home_own_mobile?></span></p>

                    <p class='unicode-to-bijoy' style="font-size:21px;  ">11| ‡idv‡iÝKvixi/Awfeve‡Ki bvgt <span style="font-size:15px"> <?php echo $value->refer_name.' </span>, m¤úK©t <span  style="font-size:15px">'.$value->refer_relation.'</span>'?></span>
                        <!-- <p>‡ckv t ............«Referees_job»|</p> -->
                    <p class='unicode-to-bijoy' style="font-size:21px;margin-left:35px"> wVKvbvt <span style="font-size:15px"><?php echo $value->refer_village?>,<?php echo $value->ref_post_name_bn?>, <?php echo $value->ref_upa_name_bn?>, <?php echo $value->ref_dis_name_bn?></span>|</p>
                    <p class='unicode-to-bijoy' style="font-size:21px;margin-left:35px""> †gvevBjt <span><?php echo $value->refer_mobile?></span></p>
                    <br>
                    <p style="width:160px;border-bottom: 1px solid black;font-size:21px"><b>wbixÿbKvixi gšÍe¨t</b></p>
                    <p style="font-size:21px">Avwg m‡iRwg‡b/†gvevBj †dv‡bi gva¨‡g †idv‡iÝKvix e¨w³i mv‡_ †hvMv‡hvM K‡i wb‡¤œv³ Z_¨w` mwVK †cjvg:</p>
                    <p style="font-size:21px">1| Dc‡iv³ bvg wVKvbv mwVK|</p>
                    <p style="font-size:21px">2| Av‡e`bKvix Av`vj‡Z `ÛcÖvß bq e‡j Rvbv hvq|</p>
                    <p style="font-size:21px">3| †m gv`Kvm³ bq e‡j †idv‡iÝKvix Rvbvq|</p>
                    <br>

                    <p style="font-size:21px">wbixÿbKvixi ¯^vÿit ............................................................</p>

                    <p style="font-size:21px">bvgt ..........................................................................</p>
                    <p style="font-size:21px">c`ext .........................................................................</p>
                    <p style="font-size:21px"> ZvwiLt........................................................................</p>


                </div>
            </div>
        </div>
        <br>
        <br>
        <br>
        <!-- abedon -->

        <div class='container'>
                    <div class="container break_page" style=" font-family: sutonnymj;margin-left:-15px">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/003</p>
                </div>
                <?php } else if($unit_id == 2){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/087</p>
                </div>
                <?php }else if($unit_id == 4){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/003</p>
                </div>
            <?php }?>
            <div>
                <div class="mt-3">
                    <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                    <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                        <h1 class="text-center unicode-to-bijoy" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                    </div>
                </div>
                <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                    <p class="text-center h5 unicode-to-bijoy"><?= $com_info->company_add_bangla ?></p>
                </div>
            <div>
            <br>
            <!-- <div class="row"> -->

            <h2 class="text-center mt-2"><b style="border: 2px solid black;padding-left:4px;padding-right:4px;">PvKzixi Av‡e`b cÎ</b></h2>
            <!-- </div> -->
            <div class="row" style="margin-left:14px;">
                <div class="col-md-6 mt-4" style='    margin-top: -45px !important;'>
                    <table>
                        <tr>
                            <th>ZvwiLt </th>
                            <td>  </td>
                            <td class='unicode-to-bijoy'><?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</td>
                        </tr>
                    </table>
                </div>
                <br><br>
                <div class="col-md-12">

                    <p style="font-size:21px">eivei,</p>
                    <p style="font-size:21px">gvbem¤ú` wefvM</p>
                    <p style="font-size:21px" class='unicode-to-bijoy'><?= "<span style='font-size:21px'>".$company_name_bangla."</span>" ; ?></p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>wVKvbvt <?php echo '<span style="font-size:15px">'.$company_add_bangla.'</span>' ?></p>
                    <p style="font-size:21px" class="mt-3 unicode-to-bijoy"> welqt <b><?= "<span style='font-size:15px'>".$value->desig_bangla."</span>" ; ?> </b> c‡` PvKzixi Rb¨ Av‡e`b |</p>

                    <p style="font-size:21px" class="mt-3 unicode-to-bijoy"><?php echo $value->gender == 'Male' ? 'Rbve': 'Rbvev'?>,</p>
                    <p style="font-size:21px" class='unicode-to-bijoy'> h_vwenxZ m¤§vb cÖ`k©b c~e©K weYxZ wb‡e`b GB †h, Avwg Avcbvi mybvgab¨ wkí cÖwZôv‡b <span style='font-size:15px'><?php echo $value->desig_bangla?></span> c‡`
                        †hvM`vb Ki‡Z
                         ইচ্ছুক| D³ c‡`i GKRb cÖv_x© wnmv‡e Avgvi Rxeb e„ËvšÍ Avcbvi my-we‡ePbvi Rb¨ `vwLj KiwQ|</p>

                    <p style="font-size:21px" class="mt-3">AZGe, wb¤œ cÖ`Ë Z_¨vejx hvPvB K‡i Avgv‡K D³ c‡` wb‡qvM `vb Ki‡j Avwg Avcbvi wbKU K…ZÁ _vKe|</p>

                    <p style="font-size:21px" class='unicode-to-bijoy'>1| bvgt <span style='font-size:15px'><?php echo $value->name_bn?></p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>2| wcZvt <span style='font-size:15px'><?php echo $value->father_name?></span>
                    <span style='margin-left:50px' class='unicode-to-bijoy'><?php echo $value->gender=='Male'? ' ¯¿xi ':' ¯^vgxi'?> bvgt <?php echo '<span style="font-size:15px">'.$value->spouse_name.'</span>'?></span></p>
                    </p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>3| eZ©gvb wVKvbvt <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->pre_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->pre_post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->pre_upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->pre_dis_name_bn.'</span>'?></span>| </p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>4| স্থায়ী wVKvbvt <span style="margin-left:2px"> <?php echo '<b> MÖvg/gnjøvt </b> <span style="font-size:15px;">'.$value->per_village_bn.'</span>'?>, <?php echo ' <b> WvKNit </b> <span style="font-size:15px;">'.$value->post_name_bn.'</span>'?>, <?php echo ' <b> _vbvt </b> <span style="font-size:15px;">'.$value->upa_name_bn.'</span>'?>, <?php echo ' <b> †Rjvt</b> <span style="font-size:15px;">'.$value->dis_name_bn.'</span>'?></span> | </p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>5| wkÿvMZ †hvM¨Zvt
                        <span style="font-size:15px;font-family:arial" class='unicode-to-bijoy'>
                            <?php
                                if (isset($value->education)) {
                                    echo $value->education;
                                }else{
                                    echo '';
                                }

                            ?>
                        </span>
                    </p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>6| R¤œ ZvwiLt <?php echo date('d-m-Y',strtotime($value->emp_dob))?> Bs </p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>7| ag©t <span style="font-size:21px"><?php echo $value->religion == 'Islam' ?'Bmjvg':($value->religion == 'Hindu' ? 'wn›`y':($value->religion=='Christian' ?'wLª÷vb':'‡eŠ×')) ?></span> </p>
                    <p style="font-size:21px" class='unicode-to-bijoy'>8| RvZxqZvt evsjv‡`kx ,Kg©xi †gvevBj bs <span><?php echo $value->personal_mobile?></span></p>
                    <p style="font-size:21px;" class=''>9| i‡³i MÖæct <?php echo '<span style="font-family:arial;font-size:15px">'.$value->blood.'</span>'?> </p>
                    <p style="font-size:21px">10| AwfÁZvt </p>

                    <table class="table" style="border:1px solid black"  border="1">
                        <tr>
                            <th style="padding:0px !important;border:1px solid black" class="text-center">µwgK bs</th>
                            <th style="padding:0px !important;border:1px solid black" class="text-center">AwfÁZvi c~b© weeib</th>
                            <th style="padding:0px !important;border:1px solid black" class="text-center">cÖwZôv‡bi bvg</th>
                            <th style="padding:0px !important;border:1px solid black" class="text-center">PvKzixi mgqKvj</th>
                        </tr>
                        <tr>
                            <td class="text-center">1.</td>
                            <td class="text-center"class='unicode-to-bijoy'><span style="font-size:15px"><?php echo $value->exp_dasignation?></span></td>
                            <td class="text-center"class='unicode-to-bijoy'><span style="font-size:15px"><?php echo $value->exp_factory_name?></span></td>
                            <td class="text-center"class='unicode-to-bijoy'><span style="font-size:15px"><?php echo $value->exp_duration?></span></td>
                        </tr>
                    </table>




                    <!-- <p style="font-size:21px">10| †idv‡iÝt (1) bvgt <span style="font-size:15px">< ?php echo $value->refer_name?></span></p>
                    <p style="font-size:21px">wVKvbvt <span style="font-size:15px">< ?php echo $value->refer_village?>, < ?php echo $value->ref_post_name_bn.', '.$value->ref_upa_name_bn.', '.$value->ref_dis_name_bn?></span></p>
                    <p style="font-size:21px"> †dvbt < ?php echo $value->refer_mobile?></p> -->
                    <br><br><br><br>
                    <br><br><br><br>

                    <div style="float: left;display: block; width: 100%;" class='d-flex'>
                        <div class="col-md-6" style='line-height:1'>
                            <p style="font-size:21px !important;">KZ©…c¶</p><br>
                            <p>........................</p>
                            <p>wefvMxq cÖavb (gvbem¤ú`)</p>
                            <p style='font-size:21px' class='unicode-to-bijoy'><?php echo $com_info->company_name_bangla?></p>
                        </div>

                        <div class="col-md-6" style="margin-left: 252px;">
                            <p style="font-size:21px">¯^vÿit ................ √.......................</p>
                            <p style="font-size:21px" class='unicode-to-bijoy'>bvgt <span style="font-size:15px"><?php echo $value->name_bn?></span></p>
                            <p style="font-size:21px" class='unicode-to-bijoy'>c`ext <span style="font-size:15px"><?php echo $value->desig_bangla?></span></p>

                            <p style="font-size:21px" class='unicode-to-bijoy'>AvBwW bst <span style="font-size:"><?php echo $value->per_emp_id?></span></p>
                            <p style="font-size:21px" class='unicode-to-bijoy'>‡mKkb/jvBbt <span style="font-size:15px"><?php echo $value->line_name_bn?></span></p>
                            <br><br>
                        </div>
                        <!-- <p style="margin-top: -25px;font-size:21px">Awdm KZ…©K c~iYxqt</p>
                        <div class="d-flex">
                            <div class="col-md-6">
                                <p style="font-size:21px">gšÍe¨t </p>
                            </div>
                            <div class="col-md-6" style="float: right;">
                                <p style="font-size:21px">Kg©KZv©i ¯^vÿit</p>
                                <p style="font-size:21px"> bvgt ..............................................</p>
                                <p style="font-size:21px">c`ext ..............................................</p>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        </div>

        <br>
        <br>
        <!-- nominee -->
        <div class="container-fluid break_page" style="margin-left:-10px">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/007</p>
                </div>
                <?php } else if($unit_id == 2){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/080</p>
                </div>
                <?php }else if($unit_id == 4){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/007</p>
                </div>
            <?php }?>
             <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center unicode-to-bijoy" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5 unicode-to-bijoy"><?= $com_info->company_add_bangla ?></p>
            </div>
            <br>
            <div class="d-flex flex-column align-items-center">
                <h2 class="mt-2" style="border: 2px solid black;padding-left:4px;padding-right:4px;">Av‡e`bKvix KZ„©K g‡bvbqb dig bs-41</h2>
                <p>[ aviv 19, 131 (1) (K), 155 (2), 234, 264, 265 I 273 Ges wewa 118 (1) 136, 232 (2), 262 (1), 289 (1) I 321
                    (1) `ªóe¨ ]</p>
                <p><b>Rgv I wewfbœ Lv‡Z cÖvc¨ A_© cwi‡kv‡ai †Nvlbv I g‡bvq‡bi dig|</b></p>
            </div>
            <br>
            <div>
                <p>
                    1| KviLvbv / cÖwZôv‡bi bvg t  <?= "<span style='font-size:21px'>".$company_name_bangla."</span>" ; ?>
                </p>
                <p class='unicode-to-bijoy'> 2| KviLvbv / cÖwZôv‡bi wVKvbv t <?= "<span style='font-size:15px'>".$company_add_bangla."</span>" ; ?> |</p>

                    <p class='unicode-to-bijoy'> 3| kÖwg‡Ki bvg I wVKvbvt  bvgt <span style='font-size:15px'><?php echo $value->name_bn?></span>
                    , MÖvgt <span style="font-size:15px"><?php echo $value->pre_village_bn?></span>
                    , WvKNit <span style="font-size:15px"><?php echo $value->pre_post_name_bn?></span>
                    , _vbvt <span style="font-size:15px"><?php echo $value->pre_upa_name_bn?></span>
                    , ‡Rjvt <span style="font-size:15px"><?php echo $value->pre_dis_name_bn?></span>
                    , wj½t <span style="font-size:15px"><?php echo $value->gender == "Male" ? "পুরুষ" : "নারী"?></span></p>

                <p class='unicode-to-bijoy'>4| wcZv/gvZvt <span style="font-size:15px"><?php echo $value->father_name?></span>, <span style='margin-left:50px'><?php echo $value->gender=='Male'? ' ¯¿xi ':' ¯^vgxi'?> bvgt <?php echo '<span style="font-size:15px">'.$value->spouse_name.'</span>'?></span></p>
                <p class='unicode-to-bijoy'>5| Rb¥ ZvwiLt <?php echo date("d-m-Y",strtotime($value->emp_dob))?> Bs</span></p>
                <p class='unicode-to-bijoy'>6| mbv³ KiY wPý (hw` _v‡K)t <?php echo '<span style="font-size:15px">'.$value->identificatiion_marks.'</span>'?> |</p>
                <div class="d-flex">
                    <p class='unicode-to-bijoy'>7| স্থায়ী wVKvbvt  MÖvgt <span style="font-size:15px"><?php echo $value->per_village_bn?></span></p>
                    <p class='unicode-to-bijoy'>,  WvKNit  <span style="font-size:15px"><?php echo $value->post_name_bn?></span></p>
                    <p class='unicode-to-bijoy'>,  _vbvt  <span style="font-size:15px"><?php echo $value->upa_name_bn?></span></p>
                    <p class='unicode-to-bijoy'>, ‡Rjvt <span style="font-size:15px"><?php echo $value->dis_name_bn?></span></p>


                </div>
                <p class='unicode-to-bijoy'>8| PvKwi‡Z wbhyw³i ZvwiLt <span><?php echo date("d-m-Y",strtotime($value->emp_join_date))?> Bs</span> </p>
                <p class='unicode-to-bijoy'>9| c‡`i bvgt <span style="font-size:15px"><?php echo $value->desig_bangla?></span></p>
            </div>
            <div>
                <p style="line-height:20px">Avwg GZØviv †Nvlbv Kwi‡ZwQ †h, Avgvi g„Zy¨ nB‡j ev Avgvi AeZ©gv‡b, Avgvi AbyK~‡j Rgv I wewfbœLv‡Z cÖvc¨ UvKv
                    MÖn‡bi Rb¨
                    Avwg wb¤œewb©Z e¨w³‡K/e¨w³Mb‡K g‡bvbqb `vb Kwi‡ZwQ Ges wb‡`©k w`w”Q ‡hb, D³ UvKv wb¤œewb©Z c×wZ‡Z g‡bvbxZ
                    e¨w³‡`i g‡a¨
                    e›Ub Kwi‡Z nB‡e|
                </p> <br>

                <div class="vl"></div>
                <table class="table" border="1">
                    <tr>
                        <th class="text-center" style="width: 20%;">g‡bvbxZ e¨w³ ev e¨w³‡`i bvg, wVKvbv I Qwe (bwgbxi Qwe I
                            ¯^vÿi kÖwgK KZ…©K mZ¨vwqZ) Gb AvB wW/Rb¥ wbeÜb bst </th>
                        <th class="text-center" style="width: 6%;">m`m¨‡`i mwnZ g‡bvbxZ e¨w³‡`i m¤úK©</th>
                        <th class="text-center" style="width: 6%;vertical-align: middle;"> eqm</th>
                        <th class="text-center" style="width: 26%;vertical-align: middle;" colspan="2">cÖ‡Z¨K g‡bvbxZ e¨w³‡K †`q Ask</th>
                    </tr>
                    <tr>
                        <td class="text-center">(1)</td>
                        <td class="text-center">(2)</td>
                        <td class="text-center">(3)</td>
                        <td class="text-center" colspan="2">(4)</td>
                    </tr>
                    <tr>
                        <td class="unicode-to-bijoy" > <span style="margin-left: 6px;"> bvgt </span> <span style="font-size:15px"> <?php echo $value->nominee_name?></span></td>
                        <td class="text-center" style="font-size:15px;vertical-align:middle">
                            <?php echo  $value->nomi_relation?>
                        </td>
                        <td class="text-center unicode-to-bijoy">
                            <?php
                                $nomi_age = $value->nomi_age;
                                $timestamp_nomi_age = strtotime($nomi_age);
                                $current_year = date('Y');
                                echo $age = date('Y') - date('Y', $timestamp_nomi_age);
                            ?>
                        eQi</td>
                        <td class="text-center" style="width:10%">RgvLvZ</td>
                        <td style="width:10%;text-align:center">100% Ask</td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px;" class='unicode-to-bijoy'> MÖvgt <span style="font-size:15px !important"><?php echo $value->nominee_vill ?></span></td>
                        <td></td>
                        <td></td>
                        <td class="text-center" style="width:10%">e‡Kqvg Ryix</td>
                        <td style="width:10%"></td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px;" class='unicode-to-bijoy'> WvKNit <span style="font-size:15px !important"> <?php echo $value->nomi_post_name_bn ?></span></td>
                        <td></td>
                        <td></td>
                        <td class="text-center" style="width:10%">cÖwf‡W›U dvÛ</td>
                        <td style="width:10%"></td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px;" class='unicode-to-bijoy'> _vbvt <span style="font-size:15px !important"><?php echo $value->nomi_upa_name_bn ?></span></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">exgv</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td style="padding-left:5px;" > ‡Rjvt <span style="font-size:15px !important"><?php echo $value->nomi_dis_name_bn ?></span></td>
                        <td></td>
                        <td></td>
                        <td class="text-center" style="width:10%"> `~N©Ubvi ÿwZc~iY</td>
                        <td style="width:10%"></td>
                    </tr>
                    <tr>
                        <td><span style="padding-left:5px;" class='unicode-to-bijoy'><?php echo $value->nomi_nid_bc_check==1 ? "Gb AvB wW":"Rb¥ wbeÜb bs"?>t  <span style="font-size:19px !important" class='unicode-to-bijoy'> <?php echo ' '.$value->nomi_nid?></span></td>
                        <td></td>
                        <td></td>
                        <td class="text-center">jf¨vsk</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-center" style="width:10%">Ab¨vb¨</td>
                        <td style="width:10%"></td>
                    </tr>
                </table>
                <br><br>
                <div>
                    <p>cÖZ¨qb Kwi‡ZwQ †h, Avgvi Dcw¯’wZ‡Z Rbve  -----------------------------------------------  wjwce× weeiY mgyn cvV Kwievi ci D³ †Nvlbv ¯^vÿi Kwiqv‡Qb|</p>
                </div>
                <br>

                <div>
                    <p>g‡bvbqb cÖ`vbKvix kÖwg‡Ki ¯^vÿi, wUcmwn I ZvwiLt -----------------------√-----------------------------
                    </p>
                </div>
                <br>
                <br><br>
                <div class="d-flex justify-content-between">
                    <div class="flex-column align-items-start">
                        <p>................................................. </p>

                        <p>ZvwiLmn g‡bvbxZ e¨w³MY‡K </p>
                        <p> ¯^vÿi A_ev wUcmwn </p>
                        <p> (kÖwgK KZ…©K mZ¨vwqZ Qwe) </p>
                    </div>

                    <div class="flex-column align-items-end">
                        <p>................................................. </p>
                        <p>wefvMxq cÖavb (gvbem¤ú`)</p>
                        <p>cÖvwaKvi cÖvß  Kg©KZv©i ¯^vÿi</p>
                        <p class='unicode-to-bijoy'>ZvwiLt <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- account  -->

        <div class="container break_page w-100" style="margin-left:-10px">
            <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;"></p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/002</p>
                </div>
                <?php } else if($unit_id == 2){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;"></p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/122</p>
                </div>
                <?php }else if($unit_id == 4){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;"></p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/028</p>
                </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center unicode-to-bijoy" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5 unicode-to-bijoy"><?= $com_info->company_add_bangla ?></p>
            </div>
            <div>
                <br>
                <p class='unicode-to-bijoy'>ZvwiL : <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</p><br><br>
                <p>eivei,</p>
                <p>gvbem¤ú` wefvM</p>
                <p class='unicode-to-bijoy'>KviLvbvi bvgt <v> <?= "<span style='font-size:15px'>".$company_name_bangla."</span>" ; ?> .</b></p>
                <p class='unicode-to-bijoy'>wVKvbvt <?= "<span style='font-size:15px'>".$company_add_bangla."</span>" ; ?> </p>
                <br>
                <p class='unicode-to-bijoy'><?php echo $value->gender == 'Male' ? 'Rbve': 'Rbvev'?>,</p>

                <p class='unicode-to-bijoy'>Avwg <span style='font-size:15px'><?php echo $value->name_bn?></span>,c`ext <span style='font-size:15px'><?php echo $value->desig_bangla?></span>,KvW© bst <span><?php echo $value->per_emp_id?></span>, ‡mKkbt <span style='font-size:15px'><?php echo $value->sec_name_bn?></span>,<span style='font-size:15px'>লাইনt <?php echo $value->line_name_bn?> </span></p>
                <p>Avwg Avgvi hveZxq ‡eZbvw` wb‡gœv³ weKvk bv¤^v‡i cÖ`v‡bi Rb¨ Aby‡iva KiwQ|</p>
                <p>weKvk b¤^it <b><span style='font-size:21px'><?php echo $value->bank_bkash_no?></span></b></p>
                <br><br><br><br><br><br><br><br>
                <div class="d-flex" style="margin-left: -15px;">
                    <div class="col-md-6">
                        <p>¯^vÿi Ges wUcmBt...................√.............</p>
                        <p class='unicode-to-bijoy'>bvgt <span style='font-size:15px'><?php echo $value->name_bn?></p>
                        <p class='unicode-to-bijoy'>c`ext <span style='font-size:15px'><?php echo $value->desig_bangla?></span></p>
                    </div>
                    <div class="col-md-6" style="text-align:right">
                        <p style="margin-right: 140px;">KZ©…c¶</p><br>
                        <p>....................................</p>
                        <p style="margin-right: 5px;">wefvMxq cÖavb (gvbem¤ú`)</p>
                        <p class='unicode-to-bijoy' style="font-size:21px"><?php echo $com_info->company_name_bangla?></p>
                   </div>
                </div>
            </div>
        </div>

        <!-- job description -->
        <div class="container break_page" >
           <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/003</p>
                </div>
                <?php } else if($unit_id == 2){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code :  LSAL/HR/03/090</p>
                </div>
                <?php }else if($unit_id == 4){?>
                <div class="d-flex flex-row justify-content-between">
                    <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-08-2024</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Revision: 01</p>
                    <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/002</p>
                </div>
            <?php }?>

            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <?php if($unit_id ==4){?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute;">
                    <?php }else{?>
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="margin-top: 5px;width: 120px; height: 40px; position: absolute; margin-left: 230px;">
                    <?php }?>
                    <h1 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h5 unicode-to-bijoy"><?= $com_info->company_add_bangla ?></p>
            </div>

            <div>
                <br><br>
                <p class='unicode-to-bijoy' style>ZvwiL : <?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</p><br>
                <h3 style="text-align:center;" class="unicode-to-bijoy"> <?= $value->desig_bangla; ?> এর দায়িত্ব ও কর্তব্য  </h3><br>
                <p style=" font-family:;"> <?= $value->desig_description; ?></p>


                <br><br><br><br>
                <br><br><br><br>
                <br><br><br><br>
                <div class="d-flex" style="margin-left: -15px;">
                    <div class="col-md-6">
                        <p>¯^vÿi Ges wUcmBt...................√.............</p>
                        <p class='unicode-to-bijoy'>bvgt <span style='font-size:15px'><?php echo $value->name_bn?></p>
                        <p class='unicode-to-bijoy'>c`ext <span style='font-size:15px'><?php echo $value->desig_bangla?></span></p>
                    </div>
                    <div class="col-md-6" style="text-align:right">
                        <p style="margin-right: 140px;">KZ©…c¶</p><br>
                        <p>....................................</p>
                        <p style="margin-right: 5px;">wefvMxq cÖavb (gvbem¤ú`)</p>
                        <p class='unicode-to-bijoy' style="font-size:21px;margin-right:3px;"><?php echo $com_info->company_name_bangla?></p>
                   </div>
                </div>

            </div>
        </div>
    <?php }?>

        <script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
        <?php echo "<script>applyUnicodeToBijoy()</script>"?>
    </body>
</html>




