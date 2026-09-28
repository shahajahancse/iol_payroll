
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Actual Pay Slip</title>
    <style type="text/css">
        @page {
            size: A4;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .content {
            width: 100%;
            height: 33.33%;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        table{
            padding: 0 10px
        }
        td tr{
            white-space: nowrap;
            overflow: hidden;
        }
    </style>
</head>
<body style=" margin:0px auto; margin-left:20px;">
    <table align="left" border="0" cellpadding="0" cellspacing="0">
        <!-- <tr> -->
            <?php
                $row_count=count($values);
                if($row_count >3)
                {
                $page=ceil($row_count/3);
                }
                else
                {
                $page=1;
                }
                $i = 0;
                $k = 0;
                foreach($values as $rows)
                {
                    $day_info = json_decode($rows->day_info);
                    // dd($rows);
                echo "<tr>";
            ?>
            <td style="width:450px; height:300px;">
                <div style="width:100%; height:auto; ">
                    <?php 
                        if($i % 3 == 0){
                            $k = $k + 1;
                            echo "&nbsp";
                            echo "&nbsp";
                         } 
                    ?>
                    <div class="content"  style="width:350px; height:auto; overflow:hidden; font-size:9px; font-family: SolaimanLipi; border:1px solid black;">
                        <div style="width:280px; height:32px; margin:0 auto; text-align:center; line-height: 16px;padding-bottom:20px;padding-top: 3px">
                            <?php 
                                $this->load->view('head_bangla'); ?>
                                <p style="font-weight:bold;margin-top:-6px">&#2474;&#2503; - &#2488;&#2509;&#2482;&#2495;&#2474;-<span style="font-family:'Times New Roman', Times, serif;">
                                    <?php
                                        $first= $rows->salary_month;
                                        $first_y=trim(substr($first,0,4));
                                        $first_m=trim(substr($first,5,2));
                                        $first_d=trim(substr($first,8,2));
                                        $month_format = date("F", mktime(0, 0, 0, $first_m, 1, $first_y));
                                        echo "$month_format, $first_y";
                                    ?>
                            </span>(অফিস কপি)</p>
                        </div>
                    <div style="width:350px margin-top:5px; line-height: 12px; height:auto; overflow:hidden; border-top:1px solid black">
                        <div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden; line-height:12px;">
                            <table  border="0" cellspacing="0" cellpadding="0" style="width:100%">
                                <tr>
                                    <td width="90" style="font-size: 10px;">&#2472;&#2494;&#2478; </td>
                                    <td width="">
                                        <font style="font-family:'Times New Roman', Times, serif; font-size: 11px;">
                                            : <strong>
                                                <?php echo $rows->name_en;   ?>
                                            </strong> </font>
                                    </td>
                                    <?php if($unit_id !=4){?>
                                    <td width="72">গ্রেড</td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ;font-size: 11px;">:
                                            <?php echo $rows->gr_name;   ?>
                                        </font>
                                    </td>
                                    <?php }?>
                                </tr>

                                <tr>
                                    <td width="76" style="font-size: 10px;">পদবী </td>
                                    <td width="100">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->desig_name;   ?>
                                        </font>
                                    </td>
                                 <?php if($unit_id ==4){?>
                                    <td width="72">গ্রেড</td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ;font-size: 11px;">:
                                            <?php echo $rows->gr_name;   ?>
                                        </font>
                                    </td>
                                    <?php }?>
                                    <?php if($unit_id !=4 ){;?>
                                    <td width="72" style="font-size: 10px;">
                                        &#2465;&#2495;&#2474;&#2494;&#2480;&#2509;&#2463;&#2478;&#2503;&#2472;&#2509;&#2463;
                                    </td>
                                    <td width="75" style="font-size: 10px;">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->dept_name;   ?>
                                        </font>
                                    </td>
                                    <?php }?>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2453;&#2494;&#2480;&#2509;&#2465;</td>
                                    <td width="100">
                                        <font
                                            style="font-family:'Times New Roman', Times, serif;font-size: 11px; font-weight: bold;">
                                            :
                                            <?php echo $rows->emp_id;   ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2488;&#2503;&#2453;&#2486;&#2472;
                                    </td>
                                    <td width="75">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->sec_name_en;   ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">
                                        &#2479;&#2507;&#2455;&#2470;&#2494;&#2472;&#2503;&#2480;
                                        &#2468;&#2494;&#2480;&#2495;&#2454; </td>
                                    <td width="100">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                        <?php 
                                            $date =  $rows->emp_join_date;  
                                            $year=trim(substr($date,0,4));
                                            $month=trim(substr($date,5,2));
                                            $day=trim(substr($date,8,2));
                                            $date_format = date("d-M-y", mktime(0, 0, 0, $month, $day, $year));
                                            echo $date_format; 
                                        ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2482;&#2494;&#2439;&#2472; </td>
                                    <td width="75">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->line_name_en;   ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463;
                                        &#2470;&#2495;&#2472; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;font-size: 11px;">:
                                            <?php echo $day_info->total_days;   ?>
                                        </font>
                                    </td>
                                    <!-- <td width="72" style="font-size: 10px;">&#2474;&#2460;&#2495;&#2486;&#2472;</td>
                                    <td width="75">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            < ?php echo $rows->posi_name;   ?>
                                        </font>
                                    </td> -->
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463;
                                        &#2453;&#2480;&#2509;&#2478; &#2470;&#2495;&#2476;&#2488; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $day_info->num_of_workday;?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2459;&#2497;&#2463;&#2495; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php 
                                                $c_l = $day_info->c_l;  
                                                $s_l = $day_info->s_l;  
                                                $e_l = $day_info->e_l;   
                                                echo $total_leave = $c_l + $s_l + $e_l;
                                            ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463;
                                        &#2437;&#2472;&#2497;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php  echo $day_info->absent_days;   ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">
                                        &#2441;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $day_info->att_days; ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">
                                        &#2488;&#2494;&#2474;&#2509;&#2468;&#2494;&#2489;&#2495;&#2453;
                                        &#2459;&#2497;&#2463;&#2495; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $day_info->weekend;?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495;
                                        &#2456;&#2472;&#2509;&#2463;&#2494; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $rows->ot_hour;   ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" height="14" style="font-size: 10px;">
                                        &#2437;&#2472;&#2509;&#2479;&#2494;&#2472;&#2509;&#2479;
                                        &#2459;&#2497;&#2463;&#2495;
                                    </td>
                                    <td width="100" style="font-size: 10px;">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php  echo $day_info->holiday;   ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495;
                                        &#2480;&#2503;&#2463; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php  echo $rows->ot_rate;    ?>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <div style="display: flex;border-bottom:1px solid black;width:100%;align-items: flex-start;line-height:12px">
                                <table cellspacing="0" cellpadding="0" style="font-size: 11px;border-right:1px solid black ; width:50%;">
                                    <tr><td>(&#2453;) &#2476;&#2503;&#2468;&#2472;</td></tr>
                                    <tr><td></td></tr>
                                    <tr>
                                        <td  width="50%">মূল বেতন </td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">: <?php   echo $rows->basic_sal;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">বাড়ী ভাড়া </td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">: <?php echo $rows->house_r;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">&#2458;&#2495;&#2453;&#2495;&#2510;&#2488;&#2494;
                                            &#2477;&#2494;&#2468;&#2494; </td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  echo $rows->medical_a;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"> যাতায়াত ভাতা</td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  $trans_allow = $rows->trans_allow; echo ($trans_allow);   ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">খাদ্য ভাতা</td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  $food_allow = $rows->food_allow;  echo ($food_allow);  ?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" height="14">&#2478;&#2507;&#2463;</td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  echo $rows->gross_sal;    ?></td>
                                    </tr>
                                </table>

                                <table  style="font-size: 11px;margin-left:10px;width:50%;" cellspacing="0" cellpadding="0">
                                    <tr><td>(খ) কর্তন</td></tr>
                                    <tr><td> </td></tr>
                                    <tr>
                                        <td width="50%"> অগ্রীম </td>
                                        <td style="font-family: SutonnyMJ; font-size:12px;">
                                                : <?php  echo $rows->adv_deduct;   ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >অনুপস্থিত</td>
                                        <td  style="font-family: SutonnyMJ; font-size:12px;">
                                                : <?php  echo $rows->abs_deduction;     ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="152">ষ্ট্যাম্প</td>
                                
                                    <td style="font-family: SutonnyMJ; font-size:12px;">
                                                : <?php  echo $rows->stamp;     ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&#2478;&#2507;&#2463; &#2453;&#2480;&#2509;&#2468;&#2472;
                                        </td>
                                    <td style="font-family: SutonnyMJ; font-size:12px;">                        
                                        :   <?php  echo $rows->total_deduct;    ?>
                                    </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <!--add-->
                            <div style="border-bottom: 1px solid #000000; line-height: 12px;">
                                <table width="300" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td width="210" style="font-weight: bold; padding-left: 5px;">(গ) উপস্থিত বোনাস :
                                            <font style="font-family: SutonnyMJ; font-size: 12px;">
                                                <?php echo ($rows->att_bonus); ?>
                                            </font>
                                        </td>
                                        <td></td>
                                        <td width="210" style="font-weight: bold; padding-left: 5px;">(ঘ) অতিরিক্ত কাজ :
                                            <span style="font-family: SutonnyMJ; font-size: 12px;">
                                                <?php echo ($rows->ot_amount); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <table width="350" height="14" cellspacing="0" cellpadding="0" style="border-bottom:1px solid black">
                                    <tr>
                                        <td width="215"><span
                                                style="position:relative; left:5px; font-weight:bold;">সর্বমোট প্রদেয়
                                                বেতন ( ক - খ + গ + ঘ ) </span>
                                        <td>:</td>
                                        <td width="78" style="padding-right: 9px;" align="right">
                                            <font style="font-family: SutonnyMJ; font-size:12px;">
                                                <?php  echo $rows->net_pay;    ?>
                                            </font>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                            <table width="295" height="14" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="215"><span style="position:relative; font-weight:bold;">বিকাশ
                                            নম্বর : &nbsp;&nbsp;</span>
                                        <font style="font-family: SutonnyMJ; font-size:12px; font-weight:bold;">
                                            <?php echo $rows->mobile;   ?>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                            <span style="margin-left: 10px">উপরের সকল তথ্যসমূহ সঠিক বলে সম্মতি জ্ঞাপন করে স্বাক্ষর
                                করছি</span>
                            <span></span>
                        <div style=" width:350px; font-size:10px; padding-top:15px;">
                            <div style=" width:150px; float:left;margin-left: 10px">কর্তৃপক্ষের স্বাক্ষর</div>
                            <div style=" width:150px; float:right; text-align:right;margin-right: 10px">কর্মচারীর স্বাক্ষর</div>
                        </div>
                        </div>
                    </div>
                </div>
            </td>
            <td  style="width:450px;">
                <div class="content" style="width:100%; height:auto;" >
                    <?php 
                        if($i % 3 == 0){
                            echo "<div style='width:318px;text-align: right;font-weight:bold;font-size:10px'>Page No # $k of $page</div>";
                        } 
                    ?><br>
         <div class="content"  style="width:350px; height:auto; overflow:hidden; font-size:9px; font-family: SolaimanLipi;margin-bottom:10px; border:1px solid black;">
                        <div style="width:280px; height:32px; margin:0 auto; text-align:center; line-height: 16px;padding-bottom:20px;padding-top: 3px">
                            <?php 
                                $this->load->view('head_bangla'); ?>
                                <p style="font-weight:bold;margin-top:-6px">&#2474;&#2503; - &#2488;&#2509;&#2482;&#2495;&#2474;-<span style="font-family:'Times New Roman', Times, serif;">
                                    <?php
                                        $first= $rows->salary_month;
                                        $first_y=trim(substr($first,0,4));
                                        $first_m=trim(substr($first,5,2));
                                        $first_d=trim(substr($first,8,2));
                                        $month_format = date("F", mktime(0, 0, 0, $first_m, 1, $first_y));
                                        echo "$month_format, $first_y";
                                    ?>
                            </span>(শ্রমিক কপি)</p>
                        </div>
                    <div style="width:350px margin-top:5px; line-height: 12px; height:auto; overflow:hidden; border-top:1px solid black">
                        <div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden; line-height:12px;">
                            <table width="" border="0" cellspacing="0" cellpadding="0" style="width:100%">
                                <tr>
                                    <td width="90" style="font-size: 10px;">&#2472;&#2494;&#2478; </td>
                                    <td width="">
                                        <font style="font-family:'Times New Roman', Times, serif; font-size: 11px;">
                                            : <strong>
                                                <?php echo $rows->name_en;   ?>
                                            </strong> </font>
                                    </td>
                                    <?php if($unit_id !=4){?>
                                    <td width="72">গ্রেড</td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ;font-size: 11px;">:
                                            <?php echo $rows->gr_name;   ?>
                                        </font>
                                    </td>
                                    <?php }?>
                                </tr>

                                <tr>
                                    <td width="76" style="font-size: 10px;">পদবী </td>
                                    <td width="100">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->desig_name;   ?>
                                        </font>
                                    </td>
                                 <?php if($unit_id ==4){?>
                                    <td width="72">গ্রেড</td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ;font-size: 11px;">:
                                            <?php echo $rows->gr_name;   ?>
                                        </font>
                                    </td>
                                    <?php }?>
                                    <?php if($unit_id !=4 ){;?>
                                    <td width="72" style="font-size: 10px;">
                                        &#2465;&#2495;&#2474;&#2494;&#2480;&#2509;&#2463;&#2478;&#2503;&#2472;&#2509;&#2463;
                                    </td>
                                    <td width="75" style="font-size: 10px;">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->dept_name;   ?>
                                        </font>
                                    </td>
                                    <?php }?>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2453;&#2494;&#2480;&#2509;&#2465;</td>
                                    <td width="100">
                                        <font
                                            style="font-family:'Times New Roman', Times, serif;font-size: 11px; font-weight: bold;">
                                            :
                                            <?php echo $rows->emp_id;   ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2488;&#2503;&#2453;&#2486;&#2472;
                                    </td>
                                    <td width="75">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->sec_name_en;   ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">
                                        &#2479;&#2507;&#2455;&#2470;&#2494;&#2472;&#2503;&#2480;
                                        &#2468;&#2494;&#2480;&#2495;&#2454; </td>
                                    <td width="100">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                        <?php 
                                            $date =  $rows->emp_join_date;  
                                            $year=trim(substr($date,0,4));
                                            $month=trim(substr($date,5,2));
                                            $day=trim(substr($date,8,2));
                                            $date_format = date("d-M-y", mktime(0, 0, 0, $month, $day, $year));
                                            echo $date_format; 
                                        ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 12px;">&#2482;&#2494;&#2439;&#2472; </td>
                                    <td width="75">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            <?php echo $rows->line_name_en;   ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463;
                                        &#2470;&#2495;&#2472; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;font-size: 11px;">:
                                            <?php echo $day_info->total_days;   ?>
                                        </font>
                                    </td>
                                    <!-- <td width="72" style="font-size: 10px;">&#2474;&#2460;&#2495;&#2486;&#2472;</td>
                                    <td width="75">
                                        <font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">:
                                            < ?php echo $rows->posi_name;   ?>
                                        </font>
                                    </td> -->
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463;
                                        &#2453;&#2480;&#2509;&#2478; &#2470;&#2495;&#2476;&#2488; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $day_info->num_of_workday;?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2459;&#2497;&#2463;&#2495; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php 
                                                $c_l = $day_info->c_l;  
                                                $s_l = $day_info->s_l;  
                                                $e_l = $day_info->e_l;   
                                                echo $total_leave = $c_l + $s_l + $e_l;
                                            ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463;
                                        &#2437;&#2472;&#2497;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php  echo $day_info->absent_days;   ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">
                                        &#2441;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $day_info->att_days; ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" style="font-size: 10px;">
                                        &#2488;&#2494;&#2474;&#2509;&#2468;&#2494;&#2489;&#2495;&#2453;
                                        &#2459;&#2497;&#2463;&#2495; </td>
                                    <td width="100">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $day_info->weekend;?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495;
                                        &#2456;&#2472;&#2509;&#2463;&#2494; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php echo $rows->ot_hour;   ?>
                                        </font>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="76" height="14" style="font-size: 10px;">
                                        &#2437;&#2472;&#2509;&#2479;&#2494;&#2472;&#2509;&#2479;
                                        &#2459;&#2497;&#2463;&#2495;
                                    </td>
                                    <td width="100" style="font-size: 10px;">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php  echo $day_info->holiday;   ?>
                                        </font>
                                    </td>
                                    <td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495;
                                        &#2480;&#2503;&#2463; </td>
                                    <td width="75">
                                        <font style="font-family: SutonnyMJ; font-size:12px;">:
                                            <?php  echo $rows->ot_rate;    ?>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <div style="display: flex;border-bottom:1px solid black;width:100%;align-items: flex-start;line-height:12px">
                                <table cellspacing="0" cellpadding="0" style="font-size: 11px;border-right:1px solid black ; width:50%;">
                                    <tr><td>(&#2453;) &#2476;&#2503;&#2468;&#2472;</td></tr>
                                    <tr><td></td></tr>
                                    <tr>
                                        <td  width="50%">মূল বেতন </td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">: <?php echo $rows->basic_sal;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">বাড়ী ভাড়া </td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">: <?php echo $rows->house_r;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">&#2458;&#2495;&#2453;&#2495;&#2510;&#2488;&#2494;
                                            &#2477;&#2494;&#2468;&#2494; </td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  echo$rows->medical_a;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%"> যাতায়াত ভাতা</td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  echo $rows->trans_allow;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%">খাদ্য ভাতা</td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  echo $rows->food_allow;?></td>
                                    </tr>
                                    <tr>
                                        <td width="50%" height="14">&#2478;&#2507;&#2463;</td>
                                        <td style="font-family: SutonnyMJ;font-size:12px">:  <?php  echo$rows->gross_sal;?></td>
                                    </tr>
                                </table>

                                <table  style="font-size: 11px;margin-left:10px;width:50%;" cellspacing="0" cellpadding="0">
                                    <tr><td>(খ) কর্তন</td></tr>
                                    <tr><td> </td></tr>
                                    <tr>
                                        <td width="50%"> অগ্রীম </td>
                                        <td style="font-family: SutonnyMJ; font-size:12px;">
                                                : <?php  echo $rows->adv_deduct;   ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td >অনুপস্থিত</td>
                                        <td  style="font-family: SutonnyMJ; font-size:12px;">
                                                : <?php  echo $rows->abs_deduction;     ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="152">ষ্ট্যাম্প</td>
                                
                                    <td style="font-family: SutonnyMJ; font-size:12px;">
                                                : <?php  echo $rows->stamp;     ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&#2478;&#2507;&#2463; &#2453;&#2480;&#2509;&#2468;&#2472;
                                        </td>
                                    <td style="font-family: SutonnyMJ; font-size:12px;">                        
                                        :   <?php  echo $rows->total_deduct;    ?>
                                    </td>
                                    </tr>
                                </table>
                            </div>
                            </div>
                            <!--add-->
                            <div style="border-bottom: 1px solid #000000; line-height: 12px;">
                                <table width="300" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <tr>
                                        <td width="210" style="font-weight: bold; padding-left: 5px;">(গ) উপস্থিত বোনাস :
                                            <font style="font-family: SutonnyMJ; font-size: 12px;">
                                                <?php echo $rows->att_bonus; ?>
                                            </font>
                                        </td>
                                        <td></td>
                                        <td width="210" style="font-weight: bold; padding-left: 5px;">(ঘ) অতিরিক্ত কাজ :
                                            <span style="font-family: SutonnyMJ; font-size: 12px;">
                                                <?php echo $rows->ot_amount; ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <table width="350" height="14" cellspacing="0" cellpadding="0" style="border-bottom:1px solid black">
                                    <tr>
                                        <td width="215"><span
                                                style="position:relative; left:5px; font-weight:bold;">সর্বমোট প্রদেয়
                                                বেতন ( ক - খ + গ + ঘ ) </span>
                                        <td>:</td>
                                        <td width="78" style="padding-right: 9px;" align="right">
                                            <font style="font-family: SutonnyMJ; font-size:12px;">
                                                <?php  echo $rows->net_pay;  ?>
                                            </font>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <table width="295" height="14" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="215"><span style="position:relative; font-weight:bold;">বিকাশ
                                            নম্বর : &nbsp;&nbsp;</span>
                                        <font style="font-family: SutonnyMJ; font-size:12px; font-weight:bold;">
                                            <?php echo $rows->mobile;   ?>
                                        </font>
                                    </td>
                                </tr>
                            </table>
                            <span style="margin-left: 10px">উপরের সকল তথ্যসমূহ সঠিক বলে সম্মতি জ্ঞাপন করে স্বাক্ষর
                                করছি</span>
                            <span></span>
                        </div>
                        <div style=" width:350px; font-size:10px; padding-top:15px;">
                            <div style=" width:150px; float:left;margin-left:10px">কর্তৃপক্ষের স্বাক্ষর</div>
                            <div style=" width:150px; float:right; text-align:right;margin-right:10px;">কর্মচারীর স্বাক্ষর</div>
                        </div>
                    </div>
                </div>
                <?php echo "</td>"; ?>
                <?php
                     echo "</tr>";
                     $i = $i + 1;
                     }
                 ?>
  
    </table>
</body>
</html>


