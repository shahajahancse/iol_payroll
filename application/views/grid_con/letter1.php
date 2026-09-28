<!-- < ?php dd($values);?> -->
<!doctype html>
<html lang="en">

<head>
    <title>Letter 1</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #000000;
        padding: 2px;
    }

    p {
        font-size: 23px
    }

    @media print {
        @page {
            size: A4 portrait;
        }
    }
    </style>
</head>

<body style="font-family: SutonnyMJ">
    <?php
      if(count($values)==0){
        echo "<h6 style='font-family:Arial;margin-left:10px'>No Record Found</h6>";exit;
      }
    foreach($values as $value){
      // dd($values);
    ?>
    <div class="container w-75">
        <?php $unit_id =$this->session->userdata('data')->unit_name; if($unit_id ==1){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :03.10.2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : AJFL/HRAC(HR)/03/026</p>
        </div>
        <?php } else if($unit_id == 2){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date :01-01-2020</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : LSAL/HR/03/168</p>
        </div>
        <?php }else if($unit_id == 4){?>
        <div class="d-flex flex-row justify-content-between">
            <p style="font-family: Arial, Helvetica, sans-serif;">Effective Date : 15.01.2022</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Version # 00</p>
            <p style="font-family: Arial, Helvetica, sans-serif;">Document Code : HGL/HRD/HR/03/025</p>
        </div>
        <?php }?>
        <div class="mt-3">
            <?php  $com_info = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
            <div class="d-flex">
                <img src="<?php echo base_url('/awedget/assets/img/logo.png')?>" alt="Logo"
                    style="width: 120px;height: 45px;position: absolute;">
                <h1 class="text-center" style="margin:0 auto"><?= $com_info->company_name_bangla ?></h1>
            </div>
        </div>
        <div class="col-md-12" style="border-bottom: 1px solid black!important;">
            <p class="text-center h5"><?= $com_info->company_add_bangla ?></p>
        </div>
        <?php
          if (isset($no_change) && $no_change == 2) {
            $this->db->where('left_id', $value->left_id)->update('pr_emp_left_history', array('status' => 2));
          }
        ?>
        <div class="d-flex">
            <div class="col-md-6" style="font-family: SutonnyMJ;font-size:23px">m~Ît-
                <?php echo ($unit_id == 1) ? 'G‡RGdGj' : (($unit_id == 2) ? 'GjGmGGj' : 'GBPwRGj') ?>/ Aby <span
                    style="font-family: SutonnyMJ;font-size:23px"><?php echo $value->id?>/<?php echo date('m/Y',strtotime($value->left_date))?></span><span
                    style="font-family: SutonnyMJ;font-size:23px">-G</span></div>
            <div class="col-md-6 text-right">তারিখঃ <span style="font-family: SutonnyMJ;font-size:23px">
                    <?php
              $l_date =  add_days_skipping_fridays($value->left_date, 11,$value->emp_id);
              // dd($l_date);
              list($day, $month, $year) = explode('/', $l_date);
              $formatted_date_str = "$year-$month-$day";
              $date_timestamp = strtotime($formatted_date_str);
              if ($date_timestamp === false) {
                  throw new Exception("Failed to parse date string");
              }
              $day_of_week = date('N', $date_timestamp);
              if ($day_of_week == 5 ) {
                $date_timestamp = strtotime('+1 day', $date_timestamp);
              }
              if ( $day_of_week == 6) {
                $date_timestamp = strtotime('+1 day', $date_timestamp);
              }

              // Format the new date in yyyy-mm-dd
              $new_date_str = date('d/m/Y', $date_timestamp);
              // dd($new_date_str);
              echo $new_date_str;
            ?></span> ইং</div>
        </div>

        <div>
            <h3 class="text-center mt-5 unicode-to-bijoy">"†iwRwóª WvK †hv‡M †cÖwiZ" cÖ_g wPwV</h3>
        </div>

        <div class="d-flex ml-3 mt-5">
            <div class="col-md-4 border" style="line-height: 10px;">
                <p class="mt-3 unicode-to-bijoy" style='font-size:23px'><b>অফিস বিবরনীঃ</b></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>নামঃ <?php echo $value->name_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>পদবীঃ <?php echo $value->desig_bangla?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>কার্ডঃ <span
                        style="font-family: SutonnyMJ;font-size:23px"><?php echo $value->emp_id?></span></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>সেকশনঃ <?php echo $value->sec_name_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>লাইনঃ <?php echo $value->line_name_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>যোগদানঃ <span
                        style="font-family: SutonnyMJ;font-size:23px">
                        <?php echo date('d/m/Y',strtotime($value->emp_join_date))?></span> ইং</p>
            </div>
            <div class="col-md-4 border" style="line-height: 10px;">
                <p class="mt-3 unicode-to-bijoy" style='font-size:23px'><b>বর্তমান ঠিকানাঃ</b></p>
                <p class='unicode-to-bijoy' style='font-size:20px'>হোল্ডিং নংঃ <span
                        style="font-family: SutonnyMJ;font-size:15px">
                        <?php
                echo $value->holding_num.', '.$value->pre_village_bn?>
                        </sapn>
                </p>
                <!-- <p>গ্রামঃ < ?php echo $value->pre_village_bn?></p> -->
                <p class='unicode-to-bijoy' style='font-size:23px'>ডাকঘরঃ <?php echo $value->post_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>থানাঃ <?php echo $value->upa_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>জেলাঃ <?php echo $value->dis_bn?></p>
            </div>
            <div class="col-md-4 border" style="line-height: 10px;">
                <p class="mt-3 unicode-to-bijoy" style='font-size:23px'><b>স্থায়ী ঠিকানাঃ</b></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>পিতার নামঃ <?php echo $value->father_name?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>মাতার নামঃ <?php echo $value->mother_name?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>গ্রামঃ <?php echo $value->per_village_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>ডাকঘরঃ <?php echo $value->post_name_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>থানাঃ <?php echo $value->upa_name_bn?></p>
                <p class='unicode-to-bijoy' style='font-size:23px'>জেলাঃ <?php echo $value->dis_name_bn?></p>
            </div>
        </div>

        <h6 class="ml-3 mt-5 unicode-to-bijoy" style='font-size:23px'><b>welq: evsjv‡`k kÖg AvBb 2006 Gi 27(3K) aviv
                ‡gvZv‡eK e¨vL¨v cÖ`vb mn PvKzix‡Z ‡hvM`v‡bi Rb¨ ‡bvwUk|</b></h6>
        <div class="ml-3 mt-5">
            <span class="text-justify unicode-to-bijoy" style='font-size:23px'>জনাব/জনাবা,</span><br>
            <p class="text-justify unicode-to-bijoy" style='font-size:23px'>
                আপনি গত <b><span
                        style="font-family: SutonnyMJ;font-size:23px"><?php echo date('d/m/Y',strtotime($value->left_date . '+1 days'))?></span></b>
                ইং তারিখ থেকে কারখানা কর্তৃপক্ষের বিনা অনুমতিতে কর্মস্থলে অনুপস্থিত রয়েছেন। আপনার এরূপ অনুপস্থিতি
                বাংলাদেশ kÖম আইন ২০০৬ এর ২৭(৩ক) ধারার আওতায় পড়ে। সুতরাং অত্র পত্র cÖvwßi ১০ (দশ) দিনের মধ্যে আপনার
                অনুপস্থিতির কারন ব্যাখ্যা সহ কাজে যোগদানের জন্য আপনাকে নির্দেশ দেওয়া হলো। আপনার লিখিত জবাব উক্ত সময়ের
                মধ্যে নিম্ন স্বাক্ষরকারীর নিকট অবশ্যই পৌছাতে হবে। অন্যথায় কর্তৃপক্ষ আপনার weiæ‡× cÖ‡qvRbxq আইনানুগ
                ব্যবস্থা নিবে।
            </p>

            <div class="mt-5">
                <p class=" unicode-to-bijoy" style="margin-bottom: 117px !important;font-size:23px"> ab¨ev`v‡šÍ ,</p>
                <p class="mt-5 unicode-to-bijoy"
                    style="border-top:2px solid black;width:fit-content;padding-top: 5px;font-size:23px">wefvMxq cÖavb
                </p>
                <p class=" unicode-to-bijoy" style="font-size:23px">এইচআর, এডমিন GÛ Kgcøv‡qÝ</p>
                <p class=" unicode-to-bijoy" style="font-size:23px"><?php echo $com_info->company_name_bangla?></p>
                <p class="mt-5 unicode-to-bijoy" style="font-size:23px">অনুলিপিঃ</p>
                <p class=" unicode-to-bijoy" style="font-size:23px">১ . কোম্পানীর সংশ্লিষ্ট বিভাগ সমূহ</p>
                <p class=" unicode-to-bijoy" style="font-size:23px">২. কারখানার নোটিশ বোর্ড</p>
                <p class=" unicode-to-bijoy" style="font-size:23px">৩. kÖwg‡Ki e¨w³MZ bw_|</p>
            </div>
        </div>
    </div>
    <div style="page-break-after:always"></div>
    <?php }?>

    <script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
    <?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>

</html>
<?php exit(); ?>
