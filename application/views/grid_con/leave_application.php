<!-- < ?php dd($values)?> -->
<!doctype html>
<html lang="en">
<head>
    <title>Leave Application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:SutonnyMJ;
            font-size:23px;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
            padding:2px;
        }
    </style>
</head>
<body>
    <div class="container w-75">
        <?php if ($unit_id == 1) { ?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Effective Date : 03.10.2020 </p>
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Document Code : AJFL/HRAC(HR)/03/009 </p>
        </div>
        <?php } else if ($unit_id == 2) { ?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Effective Date : 01-01-2020 </p>
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Document Code : LSAL/HR/03/091 </p>
        </div>
        <?php } else { ?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Effective Date : 15.01.2022 </p>
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;font-size:15px">Document Code : HGL/HRD/HR/03/009</p>
        </div>
        <?php } ?>
        <div class="mt-3">
            <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
            <div class="d-flex">
                <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px;height: 45px;position: absolute;">
                <h3 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h3>
            </div>
        </div>
        <div class="col-md-12" style="border-bottom: 1px solid black!important;">
            <p class="text-center h6"><?= $com_info->company_add_bangla ?></p>
        </div>

        <div>
            <h2 class="text-center mt-2" style="border-radius:4px;border: 1px solid #57cf77;width: 200px;margin: 0 auto;">QywUi Av‡e`b dig</h2>
            <p class="ml-3">ZvwiLt <?php echo "<span style='font-family:SutonnyMJ;font-size:20px'> <strong> ".$apply_date." </strong></span>"?></p>
        </div>
        <?php
           $data =  $this->db->select('leave_type,leave_start,leave_end,total_leave')->where('leave_start',date('Y-m-d',strtotime($first_date)))->where('emp_id',$values['emp_info']->emp_id)->order_by('leave_end','DESC')->get('pr_leave_trans')->row();
        ?>
        <div class="ml-3">
            <p>Rbve/Rbvev,</p>
            <p>webxZ wb‡e`b GB ‡h,
            Avwg <span style="font-family:SutonnyMJ;font-size:17px"><?php echo $values['emp_info']->name_bn?></span>
            <?php echo date('d-m-Y',strtotime($first_date)) < date('d-m-Y')?"MZ":"AvMvgx"?> <?php echo "<span style='font-family:SutonnyMJ;font-size:20px'>".date('d/m/Y',strtotime($first_date))."</span>"?>  Bs ZvwiL n‡Z <?php echo "<span style='font-family:SutonnyMJ;font-size:20px'>".date('d/m/Y',strtotime($second_date))."</span>"?> ZvwiL  <span style='font-family:sutonnyMJ;font-size:18px'>পর্যন্ত</span> ‡gvU
                <?php $f_date = $first_date;$s_date = $second_date; ?>  <?php  $date1 = new DateTime($first_date);
                $date2 = new DateTime($second_date);
                $interval = $date2->diff($date1);
                            echo  "<span style='font-family:SutonnyMJ;font-size:20px'>".($interval->format('%a ') + 1)."</span>";
                    ?> w`‡bi <?php
                    if($type == 'cl'){
                        echo '‰bwgwËK';
                    }elseif($type == 'el') {
                        echo 'AwR©Z';
                    }elseif($type == 'sl') {
                        echo 'Amy¯’Zvi';
                    }elseif($type == 'sp') {
                        echo '‡¯úwkqvj';
                    }elseif($type == 'ml') {
                        echo 'cªmywZKvjxb';
                    }else{
                        echo 'webv ‡eZ‡b';
                    }
                    ?>
                    QywUi Rb¨ Av‡e`b KiwQ|
            </p><br>
            <div style="line-height:10px">
                <span style='display: flex'>Av‡e`bKvixi bvg t
                    <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 17px;border-bottom: 1px dotted black;width:75%;">
                        <?php echo $values['emp_info']->name_bn?>
                    </p>
                </span>

                <span style="display:flex">
                    <span style='display: flex;width: 50%;'>c`ex t
                        <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 17px;border-bottom: 1px dotted black;width:85%;">
                            <?php echo $values['emp_info']->desig_bangla?>
                        </p>
                    </span>
                    <span style='display: flex;width: 50%;'>KvW© bs t
                        <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 21px;border-bottom: 1px dotted black;width: 66%;">
                            <?php echo $values['emp_info']->emp_id?>
                        </p>
                    </span>
                </span>

                <span style="display:flex">
                    <span style='display: flex;width: 30%;'>‡mKkb t
                        <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 21px;border-bottom: 1px dotted black;width:50%;">
                            <?php echo $values['emp_info']->line_name_bn?>
                        </p>
                    </span>
                    <span style='display: flex;width: 30%;'>wefvM t
                        <p class='unicode-to-bijoy' style="margin-left:10px;font-family: SutonnyMJ;font-size: 21px;border-bottom: 1px dotted black;width: 50%;">
                            <?php echo $values['emp_info']->dept_bangla?>
                        </p>
                    </span>

                    <span style='display: flex;width: 50%;'>PvKyixiZ Ae¯’vb t
                        <p class='unicode-to-bijoy' style="margin-left:10px;font-family: SutonnyMJ;font-size: 21px;border-bottom: 1px dotted black;width: 60%;">
                            <?php echo $values['emp_info']->posi_name_bn?>
                        </p>
                    </span>
                </span>

                <span style='display: flex'>QzwUi KviY t
                    <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 15px;border-bottom: 1px dotted black;width: 80%;">
                        <?php echo $reason?>
                    </p>
                </span>
                <span style='display: flex'>QzwU‡Z Ae¯’vbiZ wVKvbv t
                    <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 15px;border-bottom: 1px dotted black;width: 70%;">
                        <?php echo $add_on_vacation?>
                    </p>
                </span>
                <span style='display: flex'>Av‡e`bKvixi Kv‡R †hvM`v‡bi/ wb‡qv‡Mi ZvwiL t
                    <p style="margin-left:10px;font-family: SutonnyMJ;font-size: 21px;border-bottom: 1px dotted black;width: 52%;">
                        <?php echo $values['emp_info']->emp_join_date?>
                    </p>
                </span>
            </div>
            <?php
                $year = date('Y', strtotime($first_date));
                if ($this->db->table_exists('pr_earn_'.$year)) {
                    $this->db->where('emp_id', $_POST['emp_id']);
                    $earn_l=$this->db->get('pr_earn_'.$year)->row();
                    if (!empty($earn_l)) {
                        $earn_leave = $earn_l->earn_leave;
                    }else{
                        $earn_leave = 0;
                    }
                }else{
                    $earn_leave = 0;
                }

                $first_date = $year . "-01-01";
                $last_date = $year . "-12-31";
                $this->db->where('emp_id', $_POST['emp_id']);
                $this->db->where('leave_start >=', $first_date);
                $this->db->where('leave_end <=', $last_date);
                $leavei = $this->db->get('pr_leave_trans')->result();

                $leave_taken_earn =0;

                foreach ($leavei as $key => $value) {
                if($value->leave_type == 'el'){
                        $leave_taken_earn += $value->total_leave;
                    }
                }
                $leave_ba_earn = $earn_leave - $leave_taken_earn;
            ?>
             <h2 class="text-center mt-2" style="border-radius:4px;border: 1px solid #57cf77;width: 250px;margin: 0 auto;">Awdm KZ…©K c~iYxq</h2> <br>
            <table   border="1" collupse="collapse" style="width:100%">
            <tr class="text-center">
                <td>QzwUi aiY</td>
                <td>†gvU cÖvc¨  QzwU </td>
                <td>†fvMK…Z </td>
                <td>Aewkó </td>
                <td>gšÍe¨</td>
            </tr>
            <tr class="text-center">
                <td>‰bwgwËK QzwU</td>
                <td>10</td>
                <td><?php echo $values['leave_taken_casual']?></td>
                <td><?php echo $values['leave_balance_casual']?></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td>Amy¯’Zv QzwU</td>
                <td>14</td>
                <td><?php echo $values['leave_taken_sick']?></td>
                <td><?php echo $values['leave_balance_sick']?></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td>AwR©Z QzwU</td>
                <td><?php echo $earn_leave?></td>
                <td><?= $leave_taken_earn ?></td>
                <td><?= $leave_ba_earn ?></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td>gvZ…Z¡Kvjxb QzwU</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr class="text-center">
                <td>Ab¨vb¨ QzwU</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <br>
            <div style='float:right' style="margin-top: -30px !important;">
                <span> <img src="<?= base_url('uploads/emp_signature/'.$values['emp_info']->signature)?>" width="100px" height="30px"> </span>
                <p style="border-top:1px solid black;width:fit-content">Av‡e`b Kvixi ¯^v¶i </p>
            </div>
            <br>
            <br>
            <p class="text-justify">Av‡e`bKvix‡K
                <?php echo date('d-m-Y',strtotime($f_date)) < date('d-m-Y')?"MZ":"AvMvgx"?>
                <?php echo "<span style='font-family:SutonnyMJ;font-size:20px'>".date('d/m/Y',strtotime($f_date))."</span>"?> ZvwiL n‡Z
                <?php echo "<span style='font-family:SutonnyMJ;font-size:20px'>".date('d/m/Y',strtotime($s_date))."</span>"?> <span style="font-family:SutonnyMJ;font-size:17px">পর্যন্ত</span> ‡gvU
                <?php  $date1 = new DateTime($f_date);
                            $date2 = new DateTime($s_date);
                            $interval = $date2->diff($date1);
                            $interval->d += 1;
                              echo  "<span style='font-family:SutonnyMJ;font-size:20px'>".($interval->format('%a ') + 1)."</span>";
                    ?>   w`b Gi <?= $type == 'cl' ? '‰bwgwËK' : ($type == 'el' ? 'AwR©Z' : ($type == 'sl' ? 'Amy¯’Zvi' : ($type == 'ml' ? 'cªmywZKvjxb' : ($type == 'sp' ? '‡¯úwkqvj' : '........................................')))) ?> QzwU gÄyi Kiv †h‡Z cv‡i|</p>
        </div>


        <br>
        <br>
        <div class="ml-3 d-flex justify-content-between">
            <p style="border-top:1px dashed black">mycvwikKvix</p>
            <p style="border-top:1px dashed black">‡mKkb/wefvMxq cÖavb</p>
            <p style="border-top:1px dashed black">gvbe m¤ú` wefvM</p>
            <p style="border-top:1px dashed black">gnve¨e¯’vcK/Aby‡gv`bKvi</p>
        </div>
    </div>

    <hr>

    <div class="container w-75">
    <h2 class="text-center mt-2" style="border-radius:4px;border: 1px solid #57cf77;width: 250px;margin: 0 auto;">Av‡e`bKvixi Ask</h2> <br>
        <p>Av‡e`bKvixi bvg t <?php echo "<span style='font-size:17px'>".$values['emp_info']->name_bn.'</span>' ?>, c`ex t <?php echo "<span style='font-size:18px'>".$values['emp_info']->desig_bangla.'</span>'?>,
KvW© bs t <?php echo $values['emp_info']->emp_id?>, ‡mKkb t <?php echo "<span style='font-size:20px'>".$values['emp_info']->sec_name_bn.'</span>'?>, wefvMt <?php echo "<span style='font-size:22px'>". $values['emp_info']->dept_bangla . '</span>'?>
 Avcbv‡K <?php echo date('d/m/Y',strtotime($f_date))?> Bs n‡Z <?php echo date('d/m/Y',strtotime($s_date))?> ch©šÍ †gvU <?php echo $interval->format('%a ') + 1?> w`b <?= $type == 'cl' ? '‰bwgwËK' : ($type == 'el' ? 'AwR©Z' : ($type == 'sl' ? 'Amy¯’Zvi' : ($type == 'ml' ? 'cªmywZKvjxb' : ($type == 'sp' ? '‡¯úwkqvj' : '........................................')))) ?> QzwU gÄyi Kiv nj|  D‡jøL¨ †h, KZ…©cÿ Riæix Ae¯’vi †cÖwÿ‡Z gÄyiK…Z QzwU ¯’wMZ wKsev
evwZj Ki‡Z cvi‡eb|</p>
    <div style='float: right; text-align: center;border-top:2px dashed black;'>
        <p>MÖnbKvix Kg©KZv©i ¯^vÿi</p>
        <p style="line-height:0px">(gvbe m¤ú` wefvM)</p>
        <p  class="unicode-to-bijoy"><?php echo $com_info->company_name_bangla?></p>
    </div>
</div>



    <script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
    <?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>
</html>
<?php exit(); ?>
