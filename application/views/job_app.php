<!DOCTYPE html>
<html lang="en">

<head>
    <title>Application</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        p{
            margin-top: 0;
            margin-bottom: 0;
        }
    </style>
</head>
<!-- < ?php dd($values)?> -->
<body>
    <div class="container break_page" style=" font-family: sutonnymj;width:60%">
                <div class="d-flex text-center">
                    <div class="col-md-2">
                        <img src="path/to/your/logo.png" alt="Logo" style="max-width: 100%;">
                    </div>
                    <div class="col-md-6">
                        <h3 class="text-center">nvwbI‡qj Mv‡g©›Um wjwg‡UW</h3>
                    </div>
                    <div class="col-md-4">
                        <p style="font-family: Arial, Helvetica, sans-serif;">HGL/HRD(HR)/03/008</p>
                    </div>
                </div>
                <div class="text-center col-md-12" style="border-bottom: 1px solid black!important;">
                    <p class="text-center h6">799, (cyivZb cøU bs- 1010/1011), AvgevM, ‡gŠRv evwNqv, ‡Kvbvevox, MvRxcyi-1700|</p>
                </div>
                <!-- <div class="row"> -->
                        <h3 class="text-center mt-2"><b style="border: 2px solid black;">Av‡e`b cÎ</b></h3>
                <!-- </div> -->
                <?php foreach($values as $value){?>
                <div class="row">
                    <div class="col-md-6 mt-4">
                        <table>
                            <tr>
                                <th>ZvwiL </th>
                                <td> t </td>
                                <td><?php echo  date('d-m-Y',strtotime($value->emp_join_date))?> Bs</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">

                    <p>eivei,</p>
                    <p>cwiPvjK/wbev©nx cwiPvjK/gnve¨e¯’vcK/KviLvbv e¨e¯’vcK</p>
                    <p>KviLvbvi bvg t nvwbI‡qj Mv‡g©›Um wjwg‡UW</p>
                    <p>wVKvbv t 799 (cyivZb cøU bs-1010/1011) AvgevM, †gŠRv evwNqv, ‡Kvbvevox, MvRxcyi|</p>
                    <p>welq t c‡` PvKzixi Rb¨ Av‡e`b ।</p>
                    
                    <p>Rbve,</p>
                    <p> h_vwenxZ m¤§vb cÖ`k©b c~e©K weYxZ wb‡e`b GB †h, Avwg Avcbvi KviLvbvq   <?php echo "<span style='font-size:11px'>".$value->desig_bangla."</span>"?> c‡` †hvM`vb Ki‡Z
                    B”QzK| D³ c‡`i GKRb cÖv_x© wnmv‡e Avgvi Rxeb e„ËvšÍ Avcbvi my-we‡ePbvi Rb¨ `vwLj Kijvg|</p>

                    <p>GZGe, wb¤œ cÖ`Ë Z_¨vejx hvPvB K‡i Avgv‡K D³ c‡` wb‡qvM `vb Ki‡j Avwg Avcbvi wbKU K…ZÁ _vKe|</p>
                    
                    <p>1| bvg t   <?php echo "<span style='font-size:11px'>".$value->name_bn."</span>"?></p>
                    <p>2| wcZv t  <?php echo "<span style='font-size:11px;margin-right'>".$value->father_name."</span>"?>,gvZvi bvg t  <?php echo "<span style='font-size:11px'>".$value->mother_name."</span>"?>,¯^vgx/¯¿xi bvg t <?php echo "<span style='font-size:11px'>".$value->spouse_name."</span>"?></p>
                    <p>3| eZ©gvb wVKvbv t  <?php echo "<span style='font-size:11px'>".$value->pre_village_bn."</span>"?>, <?php echo "<span style='font-size:11px'>".$value->pre_post_name_bn."</span>"?>, <?php echo "<span style='font-size:11px'>".$value->pre_upa_name_bn."</span>"?>, <?php echo "<span style='font-size:11px'>".$value->pre_dis_name_bn."</span>"?>| </p>
                    <p>4| ¯’vqx wVKvbv t  <?php echo "<span style='font-size:11px'>".$value->per_village_bn."</span>"?>, <?php echo "<span style='font-size:11px'>".$value->post_name_bn."</span>"?>, <?php echo "<span style='font-size:11px'>".$value->upa_name_bn."</span>"?>, <?php echo "<span style='font-size:11px'>".$value->dis_name_bn."</span>"?>| </p>
                    <p>5| wkÿvMZ †hvM¨Zv t <?php echo "<span style='font-size:11px'>".empty($value->emp_degree) ? "<span style='font-size:11px'>নাই</span>": $value->emp_degree."</span>"?></p>
                    <p>6| R¤œ ZvwiLt   <?php echo "<span style='font-size:16px'>".date('d-m-Y',strtotime($value->emp_dob))."</span>"?></p>
                    <p>7| ag© t  <?php echo "<span style='font-size:11px'>".($value->religion_id == 1 ? "ইসলাম":($value->religion_id == 2 ? "হিন্দু" : ($value->religion_id == 3 ?"খ্রিঠান":"বৌদ্ধ")))."</span>"?></p>
                    <p>8| RvZxqZv t <span style='font-size:11px'>বাংলাদেশী , </span> Kg©xi †gvevBj bst <?php echo "<span style='font-size:16px'>".$value->bank_bkash_no."</span>"?> </p>
                    <p>9| AwfÁZv t </p>

                    <table class="tabel table-bordered table-sm" style="width: 102%;" border='1'>
                        <tr>
                            <th class="text-center">µwgK bs</th>
                            <th class="text-center">AwfÁZvi c~b© weeib</th>
                            <th class="text-center">cÖwZôv‡bi bvg, wVKvbv, †dvb b¤^i</th>
                            <th class="text-center">PvKzixi mgqKvj</th>
                        </tr>
                        <tr>
                            <td style="padding:15px"></td>
                            <td style="padding:15px"></td>
                            <td style="padding:15px"></td>
                            <td style="padding:15px"></td>
                        </tr>
                    </table>
              
                    <p style="margin-top:5px">10| †idv‡iÝ t (1) bvg t ........................................</p>
                    <p style="margin-left: 106px;">wVKvbv t ........................................</p>
                    <p style="margin-left: 106px;"> †dvb t ..........................................</p>

                        <div style="float:right;margin-top:10px">
                            <p>¯^vÿi t ................ √.......................</p>
                            <p>bvg t <?php echo "<span style='font-size:11px'>".$value->name_bn."</span>"?></p>
                            <p>c`ex t <?php echo "<span style='font-size:11px'>".$value->desig_bangla."</span>"?></p>
                        </div>

                   
                    <p style="margin-top:80px">AwdmKZ…©K c~iYxq t</p>
                    <div class="row" style="border:1px solid black;margin-left: 0px;" >
                        <div class="col-md-6">
                            <p>gšÍe¨ t</p> 
                        </div>
                        <div class="col-md-6">
                            <p>Kg©KZ©vi ¯^vÿi t</p>
                            <p>bvg t ........................................................................</p>
                            <p>c`ext .......................................................................</p>
                        </div>
                    </div>
                    
                 
                </div>
      

                <?php }?>
         </div>
         <br>
         <br>
         <br>
</body>

</html>

