<!doctype html>
<html lang="en">

<head>
    <title>Line Change Letter</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family:SutonnyMJ;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000000;
            padding:2px;
        }
        p{
            font-size:19px
        }
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            @page {
                size: A4;
            }
            .image {
                height: 500 !important;
                width: 400 !important;
                margin-top: 10px !important;
                position: absolute !important;
            }

        }
    </style>
</head>

<body>
   <?php foreach($values as $row){?>
    <div class="container w-75">
                   <?php $unit_id= $this->session->userdata('data')->unit_name; if($unit_id ==1){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/040</p>
            </div>
            <?php } else if($unit_id == 2){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : LSAL/HR/03/129</p>
            </div>
            <?php }else if($unit_id == 4){?>
            <div class="d-flex flex-row justify-content-between">
                <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :15.01.2022</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
                <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/047</p>
            </div>
            <?php }?>
            <div class="mt-3">
                <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
                <div class="d-flex">
                    <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo" style="width: 120px;height: 40px;position: absolute;">
                    <h4 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h4>
                </div>
            </div>
            <div class="col-md-12" style="border-bottom: 1px solid black!important;">
                <p class="text-center h6"><?= $com_info->company_add_bangla ?></p>
            </div>
        <div class="d-flex">
            <div class="col-md-6">m~Ît <?php echo ($unit_id == 1) ? 'G‡RGdGj' : (($unit_id == 2) ? 'GjGmGGj' : 'GBPwRGj') ?>/GBPAviwW/<?php echo date('m/Y')?>/ <?php echo $row->letter_id?></div>
            <div class="col-md-6 text-right">ZvwiLt  <?php echo date('d/m/Y')?> Bs</div>
        </div>
        <div>
            <h3 class="text-center" style="border-bottom: 2px solid black;width: 124px;margin: 0 auto;line-height: 18px;">AeMwZ cÎ</h3>
        </div>
        <div class="ml-3" style="line-height: 10px;">
            <p class="mt-3">cÖwZ,</p>
            <p> bvgt   <?php echo "<span style='font-family:SutonnyMJ;font-size:14px'>".$row->name_bn?>        </p>
            <p> c`ext  <?php echo "<span style='font-family:SutonnyMJ;font-size:14px'>".$row->new_desig_name?> </p>
            <p> KvWt   <?php echo $row->emp_id?>         </p>
            <p> ‡mKkbt <?php echo "<span style='font-family:arial;font-size:14px'>".$row->new_sec_name?>   </p>
            <p> jvBbt  <?php echo "<span style='font-family:arial;font-size:14px'>".$row->new_line_name?>  </p>
            <p> ‡hvM`vbt
                <span style="font-family:SutonnyMJ;font-size:19px">
                    <?php echo date('m/Y',strtotime($row->effective_month))?>
                </span>Bs
            </p>
        </div>
        <br>
        <h5 class="ml-3"><b>welq: jvBb cwieZ©b cªm‡½|</b></h5><br>
        <div class="ml-3">
            <p class="text-justify">
                <span><?php echo $row->gender == "Male"? 'Rbve':'Rbvev'?>,</span><br>
                Avcbvi AeMwZi Rb¨ Rvbv‡bv hv‡”Q ‡h, ‡Kv¤úvbx KZ©…c¶ KviLvbvi Kv‡Ri myweav‡_© Ges Avcbvi me© m¤§wZµ‡g Avcbv‡K <?php echo $row->prev_sec_name?> Gi <?php echo $row->prev_desig_name?> Gi  ‡_‡K <?php echo $row->new_line_name?>  G cwieZ©b Kivi wm×vš— M«nb Kiv nj| hv AvMvgx <?php echo date('d/m/Y',strtotime($row->effective_month))?> Bs ZvwiL n‡Z Kvh©Ki Kiv n‡e| Avcbvi hveZxq ‡eZb, fvZv I Ab¨vb¨ cvIbvw` c~‡e©i b¨vq envj _vK‡e|<br>
                AZGe, ‡Kv¤úvbx KZ©…c¶ Avkv Ki‡Q ‡h, Avcwb Avcbvi eZ©gvb ‡mKk‡bi wba©vwiZ jvB‡b Avcbvi Dci Awc©Z `vwqZ¡ I KZ©…e¨ cvj‡b AviI m‡PZb n‡eb Ges ‡Kv¤úvbxi D‡ËviËi mg…w×‡Z AviI mnvqK f~wgKv ivL‡eb|
            </p>
            <div style="line-height: 10px;">
                <p style="margin-bottom: 117px !important;">ab¨ev`v‡šÍ,</p>
                <hr style="border: 1px solid black; width: 340px;float:left;display: block;"><br>
                <br><br>
                <p class="mt-2">wefvMxq cÖavb (GBPAvi, GWwgb GÛ Kgcøv‡qÝ)</p>
                <p>nvwbI‡qj Mv‡g©›Um wjwg‡UW|</p>
                <p class="mt-5">Abywjwct</p>
                <p>1| MÖæc ‡Rbv‡ij g¨v‡bRvi (GBPAvi, GWwgb GÛ Kgcøv‡qÝ)</p>
                <p>2| ‡Rbv‡ij g¨v‡bRvi (cÖ‡R± ‡nW)</p>
                <p>3| wefvMxq c«avb</p>
                <p>4| e¨w³MZ bw_</p>
                <!-- <p class="text-justify">cÖvwß ¯^xKvit Avwg GB c‡Îi mKj welq mg~n c‡o, ey‡S Ges ‡g‡b wb‡q ¯^-Áv‡b wb‡¤œ Gi Abywjwc‡Z ¯^vÿi K‡i 1 (GK) Kwc MÖnb Kwi |</p> -->
                <p class="text-right mt-5">MÖnbKvixi ¯^vÿi.............................................</p>
            </div>
        </div>
    </div>
    <?php }?>
</body>
</html>
<?php exit(); ?>
