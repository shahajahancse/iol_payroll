<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Book</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body{
            @page {
                size: A4 landscape;
            }
        }
        @media print {
            @page {
                size: A4 landscape;
            }
        }
        p{
            font-size: 16px;
            line-height: 10px;
        }
        tr td{
            text-align: center;
        }
    </style>
</head>
<body class="container">
    <br>
    <?php
        $session = $this->session->userdata('data');
    foreach($values as $value){
        $emp_signature =$this->db->select('signature')->where('emp_id',$value->emp_id)->get('pr_emp_per_info')->row('signature');
        $register =$this->db->select('register')->where('unit_id',$unit_id)->get('company_infos')->row('register');
    ?>
    <div class="d-flex">
        <div class="flex-fill" style="height:90vh;width:70vw;border: 3px solid black;">
            <div class="text-center" >
                <br><br><br><br><br><br>
                <h5>Document Code-HGL/HRD(HR)/03/010</h5>
                <br><br>
                <h1 class="unicode-to-bijoy">সার্ভিসবহি </h1>
                <br>
                <h4 class="unicode-to-bijoy">ফরম-৭ </h4>
                <p class="unicode-to-bijoy">[ধারা ৭ এবং বিধি ২০ (১) ও (২) দ্রষ্টব্য]</p>
            </div>
        </div>
        <div style="width:10% !important"></div>
        <div class="flex-fill" style="height:90vh;width:70vw;border: 1px solid black;">
            <div style="padding: 10px 0px 0px 5px;position: relative;line-height: 10px">
                <p class="unicode-to-bijoy">ফরম নং - ৭(ক)</p>
                <p class="unicode-to-bijoy text-center">প্রথম ভাগ</p>
                <p class="unicode-to-bijoy text-center">শ্রমিককে সনাক্তকরণের তথ্য:</p>
                <p class="unicode-to-bijoy">১। শ্রমিকের নাম: <?php echo $value->name_bn?></p>
                <p class="unicode-to-bijoy">২। পিতার নাম: <?php echo $value->father_name?></p>
                <p class="unicode-to-bijoy">৩। মাতার নাম: <?php echo $value->mother_name?></p>
                <p class="unicode-to-bijoy">৪। স্বামী/স্ত্রীর নাম (প্রযোজ্য ক্ষেত্রে): <?php echo $value->spouse_name?></p>
                <p class="unicode-to-bijoy" style='line-height:24px'>৫। স্থায়ী ঠিকানা গ্রামঃ <?php echo $value->per_village_bn?>, ডাকঘরঃ <?php echo $value->per_post_name_bn?>, থানা ঃ <?php echo $value->per_upa_name_bn?>, জেলাঃ <?php echo $value->per_dis_name_bn?> </p>
                <p class="unicode-to-bijoy" style='line-height:24px'>৬। বর্তমান ঠিকানা: <?php echo $value->pre_village_bn.', '.$value->pre_post_name_bn.', '.$value->pre_upa_name_bn.', '.$value->pre_dis_name_bn?></p>
                <p class="unicode-to-bijoy">৭। জন্ম তারিখ/বয়স: <?php echo $value->emp_dob?></p>
                <p class="unicode-to-bijoy">৮। জাতীয় পরিচয় পত্র নং (যদি থাকে): <?php echo $value->nid_dob_id?></p>
                <p class="unicode-to-bijoy">৯।  শিক্ষাগত যোগ্যতা: <?php echo $value->education==''? 'নাই' : $value->education?></p>
                <p class="unicode-to-bijoy" style='line-height:24px'>১০। বিশেষ দক্ষতা (যদি থাকে): <?php echo $value->exp_factory_name.','. $value->exp_duration.','.$value->exp_dasignation ?></p>
                <p class="unicode-to-bijoy">১১। উচ্চতা: </p>
                <p><span class="unicode-to-bijoy">১২। রক্তের গ্রুপ (যদি থাকে):</span> <?php echo $value->blood == 'None'? ' <span class="unicode-to-bijoy">নাই </span>' : '<span style="font-size:15px">'.$value->blood.'</span>' ?></p>
                <p class="unicode-to-bijoy">১৩। সনাক্ত করিবার জন্য বিশেষ কোনচিহ্ন (যদি থাকে): নাই</p>
                <p class="unicode-to-bijoy">১৪। সার্ভিস বহি খুলিবার তারিখ: ইং</p>
                <p class="unicode-to-bijoy">১৫। বাম হাতের বৃদ্ধাঙ্গুলীর ছাপ: </p>
                <div style="position: absolute; top: 60px;right: 35px;">
                    <img style="border: 3px solid black;" src="<?php echo base_url('uploads/photo/'.$value->img_source.'')?>" alt="" width="70px" height="100px">
                </div>
                <div style="display: flex; justify-content: space-between">
                    <img  src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px;width:70px;margin-left: 0px;margin-top: 25px;">
                    <img  src="<?php echo base_url('images/'.$register)?>" style="height: 30px;width:70px;margin-right: 60px;    margin-top: 25px;">
                </div>
                <div style="display:flex; justify-contant:space-between;position: fiexd ">
                <p  style="width:fit-content;position: relative;bottom: -8px;"><span class="unicode-to-bijoy">শ্রমিকের স্বাক্ষর</span>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
                <p style="position: relative;bottom: -8px;" class="unicode-to-bijoy">মালিক/ব্যবস্থাপনা কর্তৃপক্ষের স্বাক্ষর</p>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-bottom: 20px;page-break-after: always;"></div>

    <div class="d-flex">
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p style="padding: 5px 0px 0px 5px;" class="unicode-to-bijoy"> ফরম নং - ৭(খ)</p>
            <h6 class="text-center unicode-to-bijoy"> দ্বিতীয়ভাগ</h6>
            <p style="padding: 5px 0px 0px 5px;" class="unicode-to-bijoy"> মালিকের ও চাকুরীর তথ্যসমূহঃ</p>
            <table class=" table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr class="text-center" >
                        <th><span class="unicode-to-bijoy">কারখানা</span>/<br><span class="unicode-to-bijoy">প্রতিষ্ঠানেরনাম ও ঠিকানা </span></th>
                        <th class="unicode-to-bijoy">মালিক/ব্যবস্থাপনা কর্তৃপক্ষেরনাম</th>
                    </tr>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">১</th>
                        <th class="unicode-to-bijoy">২</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr class="text-center">
                            <td class="unicode-to-bijoy">হানিওয়েলগার্মেন্টস লিঃ<br>
                            ৭৯৯ (১০১০/১০১১) আমবাগ, কোনাবাড়ী, গাজীপুর-১৭০০।</td>
                            <td class="unicode-to-bijoy">মোঃআবদুররহিম<br>
                            সহঃম্যানেজার (এইচ.আর.ডি)<br>
                            হানিওয়েলগার্মেন্টস লিঃ</td>
                        </tr>
                    </tbody>
            </table>
        </div>
        <div style="width:1% !important"></div>
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px">ফরম নং - ৭(খ)</p>
            <h6 class="text-center unicode-to-bijoy"> দ্বিতীয়ভাগ</h6>
            <p class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px">মালিকের ও চাকুরীর তথ্যসমূহঃ</p>
            <table class=" table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">যোগদানের তারিখ</th>
                        <th class="unicode-to-bijoy">চাকরিত্যাগ/ অবসানেরতারিখ</th>
                        <th class="unicode-to-bijoy">ত্যগ/অবসানেরধরন/কারন </th>
                        <th class="unicode-to-bijoy">মালিক/প্রাধিকারপ্রাপ্ত ব্যক্তির স্বাক্ষর</th>
                        <th class="unicode-to-bijoy">শ্রমিকের স্বাক্ষর/টিপসই </th>
                    </tr>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">৩</th>
                        <th class="unicode-to-bijoy">৪</th>
                        <th class="unicode-to-bijoy">৫</th>
                        <th class="unicode-to-bijoy">৬</th>
                        <th class="unicode-to-bijoy">৭</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <?php $image =  $this->db->select('*')->where('unit_id',1)->get('company_infos')->row()?>
                        <td style="white-space: nowrap;font-family:sutonnyMJ;font-size:15px"><?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</td>
                        <td><?php echo $value->left_date=='' ? 'বর্তমান': '<span style="font-family:sutonnyMJ;font-size:15px">'.date('d-m-Y',strtotime($value->left_date)).' Bs </span>'?> </td>
                        <td><?php echo $value->left_date=='' ? '-': cc($value->resign_reason)?> </td>
                        <td><img src="<?php echo base_url('images/'.$register)?>" style="height: 30px;width:70px"></td>
                        <td><img src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px;width:70px"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-bottom: 20px;page-break-after: always;"></div>
    <div class="d-flex">
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;">ফরম নং - ৭(গ)</p>
            <h6 class="unicode-to-bijoy" class="text-center" style="font-weight:700;"> তৃতীয়ভাগ</h6>
            <p class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;font-weight:600;"> সার্ভিস রেকর্ড ও মজুরি এবং ভাতাসংক্রান্ত তথ্য</p>
            <table class=" table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">বর্তমান <br>পদে চাকুরী আরম্ভের<br> তারিখ</th>
                        <th class="unicode-to-bijoy">চাকুরীর <br>পদ <br>ও কার্ড <br>নম্বর</th>
                        <th colspan="4" class="unicode-to-bijoy">মাসিক মজুরির হার</th>
                    </tr>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">১</th>
                        <th class="unicode-to-bijoy">২</th>
                        <th colspan="4" >৩</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center" style="font-weight: bold;white-space: nowrap">
                        <td></td>
                        <td></td>
                        <td class="unicode-to-bijoy">মূল মজুরী</td>
                        <td class="unicode-to-bijoy">বাড়ী ভাড়া ভাতা</td>
                        <td class="unicode-to-bijoy">চিকিৎসা ভাতা</td>
                        <td class="unicode-to-bijoy">বোনাস (যদি থাকে)</td>
                    </tr>
                    <tr class="text-center" style="font-weight: bold;" >
                        <td></td>
                        <td></td>
                        <td class="unicode-to-bijoy">টাকা</td>
                        <td class="unicode-to-bijoy">টাকা</td>
                        <td class="unicode-to-bijoy">টাকা</td>
                        <td class="unicode-to-bijoy">টাকা</td>
                    </tr>
                    <tr class="text-center">
                        <td style="white-space: nowrap;font-family:sutonnyMJ;font-size:15px"><?php echo date('d-m-Y',strtotime($value->emp_join_date))?> Bs</td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo '<span style="font-size:12px;">'.$value->desig_bangla.'</span>'.' '.$value->emp_id?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo round(($value->gross_sal-2450)/1.5)?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo round((($value->gross_sal-2450)/1.5/2))?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ">750</td>
                        <td>-</td>
                    </tr>
                    <?php
                        $incProms = $this->db->where('new_emp_id',$value->emp_id)->get('pr_incre_prom_pun')->result();
                        foreach($incProms as $incProm){
                    ?>

                    <tr>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo $incProm->effective_month?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo $incProm->new_dept?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo round(($incProm->new_salary-2450)/1.5)?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo round((($incProm->new_salary-2450)/1.5/2))?></td>
                        <td style="font-size:15px;font-family:sutonnyMJ">750</td>
                        <td>-</td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
        <div style="width:1% !important"></div>
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p  class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;">ফরম নং - ৭(গ)</p>
            <h6 class="text-center unicode-to-bijoy" style="font-weight:700;"> তৃতীয়ভাগ</h6>
            <p  class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;font-weight:600;"> সার্ভিস রেকর্ড ও মজুরি এবং ভাতাসংক্রান্ত তথ্য</p>
            <table class="table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">অন্যান্য ভাতা</th>
                        <th class="unicode-to-bijoy">মোট, প্রভিডেন্ট ফান্ড (যদি থাকে)</th>
                        <th class="unicode-to-bijoy">শ্রমিকের প্রদেয় চাঁদা</th>
                        <th class="unicode-to-bijoy">মালিকের প্রদেয় চাঁদা</th>
                        <th class="unicode-to-bijoy">ত্যাগ/অবসানের ধরন/কারন </th>
                        <th class="unicode-to-bijoy">মালিক/প্রাধিকার প্রাপ্ত ব্যক্তির স্বাক্ষর</th>
                        <th class="unicode-to-bijoy">শ্রমিকের স্বাক্ষর/টিপসই </th>
                    </tr>
                    <tr class="text-center">
                        <th class="unicode-to-bijoy">৩</th>
                        <th class="unicode-to-bijoy">৪</th>
                        <th class="unicode-to-bijoy">৫</th>
                        <th class="unicode-to-bijoy">৬</th>
                        <th class="unicode-to-bijoy">৭</th>
                        <th class="unicode-to-bijoy">৮</th>
                        <th class="unicode-to-bijoy">৯</th>
                    </tr>
                    <tr class="text-center" style="font-weight:">
                        <th class='unicode-to-bijoy' style="bold;padding:20px;">টাকা</th>
                        <th class="unicode-to-bijoy">টাকা</th>
                        <th class="unicode-to-bijoy">টাকা</th>
                        <th class="unicode-to-bijoy">টাকা</th>
                        <th class="unicode-to-bijoy">টাকা</th>
                        <th class="unicode-to-bijoy">টাকা</th>
                        <th class="unicode-to-bijoy">টাকা</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-center">
                        <td class='unicode-to-bijoy' style="padding:6px;">1700</td>
                        <td  style="font-size:15px;font-family:sutonnyMJ"><?php echo round(($value->gross_sal))?> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td><img src="<?php echo base_url('images/'.$register)?>" style="height: 30px"></td>
                        <td><img src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px"></td>
                    </tr>

                    <?php  foreach($incProms as $incProm){?>
                    <tr>
                        <td class='unicode-to-bijoy'>1700</td>
                        <td style="font-size:15px;font-family:sutonnyMJ"><?php echo round(($incProm->new_salary))?> </td>
                        <td> </td>
                        <td> </td>
                        <td> </td>
                        <td><img src="<?php echo base_url('images/'.$register)?>" style="height: 30px"></td>
                        <td><img src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px"></td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <div style="margin-bottom: 20px;page-break-after: always;"></div>

    <div class="d-flex">
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p  class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;">ফরম নং - ৭(ঘ)</p>
            <h6 class="text-center unicode-to-bijoy" style="font-weight:700;"> চতুর্থ ভাগ</h6>
            <p class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;font-weight:600;"> ছুটির রেকর্ডঃ </p>
            <table class=" table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr class="text-center">
                        <th colspan="4" class="unicode-to-bijoy">ভোগকৃত বার্ষিক ছুটির বিবরণ</th>
                        <th colspan="3" class="unicode-to-bijoy">নগদায়নকৃত ছুটির বিবরণ</th>
                        <th rowspan="2" class="unicode-to-bijoy">মালিক/প্রধিকার প্রাপ্ত ব্যক্তির স্বাক্ষর</th>
                        <th rowspan="2" class="unicode-to-bijoy">শ্রমিকের স্বাক্ষর/টিপসই </th>
                    </tr>
                    <tr  class="text-center" >
                        <th class="unicode-to-bijoy">হইতে</th>
                        <th class="unicode-to-bijoy">পর্যন্ত</th>
                        <th class="unicode-to-bijoy">মোট</th>
                        <th class="unicode-to-bijoy">অভোগকৃত পাওনা <br>ছুটি</th>
                        <th class="unicode-to-bijoy">মোট</th>
                        <th class="unicode-to-bijoy">তারিখ</th>
                        <th class="unicode-to-bijoy">অবশিষ্ট পাওনা ছুটি</th>
                    </tr>
                    <tr  class="text-center" >
                        <th class="unicode-to-bijoy">১</th>
                        <th class="unicode-to-bijoy">২</th>
                        <th class="unicode-to-bijoy">৩</th>
                        <th class="unicode-to-bijoy">৪</th>
                        <th class="unicode-to-bijoy">৫</th>
                        <th class="unicode-to-bijoy">৬</th>
                        <th class="unicode-to-bijoy">৭</th>
                        <th class="unicode-to-bijoy">৮</th>
                        <th class="unicode-to-bijoy">৯</th>
                    </tr>
                </thead>
                <?php
                    $leave  = $this->db->select('*')->where('emp_id',$value->emp_id)->where('leave_type','el')->order_by('leave_start','asc')->get('pr_leave_trans')->result();
                    $leaves=[];
                    foreach($leave as $key => $row){
                        $leave[$key]->leave_start = $row->leave_start;
                        if(isset($leave[$key+1]) && $leave[$key+1]->leave_start ==$leave[$key]->leave_start){
                            continue;
                        }else{
                            $leaves[] = $row;
                        }
                    }
                    $earn_leave  = $this->db->select('*')->where('emp_id',$value->emp_id)->get('pr_earn_leave')->row();
                ?>
                <tbody>
                    <?php
                        $earn_leave_balance=0;
                        foreach($leaves as $row){?>
                            <tr>
                                <td class="text-center unicode-to-bijoy" style="font-family:sutonnyMJ;font-size:15px"><?php echo $row->leave_start==''?'-': date('d-m-Y',strtotime($row->leave_start)).' Bs'?> </td>
                                <td class="text-center unicode-to-bijoy" style="font-family:sutonnyMJ;font-size:15px"><?php echo $row->leave_end =='' ? '-' : date('d-m-Y',strtotime($row->leave_end)).' Bs'?> </td>
                                <td class="text-center unicode-to-bijoy" style="font-family:sutonnyMJ;font-size:15px"><?php $qty = ( date_diff(date_create($row->leave_start),date_create($row->leave_end))->format("%a") +1 );echo $qty;?></td>
                                <td class="text-center unicode-to-bijoy" style="font-family:sutonnyMJ;font-size:15px"><?php $earn_leave_balance += $qty ;  echo $earn_leave->earn_leave - $earn_leave_balance  ;?></td>
                                <td style="font-family:sutonnyMJ;font-size:15px"><?php echo ""?></td>
                                <td class="unicode-to-bijoy" style="font-family:sutonnyMJ;font-size:15px;white-space: nowrap"><?php echo $earn_leave->earn_month ?></td>
                                <td style="font-family:sutonnyMJ;font-size:15px"><?php echo "" ?></td>
                                <td><img src="<?php echo base_url('images/'.$register)?>" style="height: 30px"></td>
                                <td><img src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px"></td>
                            </tr>
                        <?php }?>
                </tbody>
            </table>

        </div>
        <div style="width:1% !important"></div>
    </div>
    <div style="margin-bottom: 20px;page-break-after: always;"></div>
    <div class="d-flex">
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p  class="unicode-to-bijoy " style="padding: 5px 0px 0px 5px;">ফরম নং - ৭(ঙ)</p>
            <h6 class="text-center attendance_bonus unicode-to-bijoy" style="font-weight:700;"> পঞ্চম ভাগ</h6>
            <p class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;font-weight:600;"> আচরণের রেকর্ডঃ </p>
            <table class=" table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr  class="text-center" >
                        <th class="unicode-to-bijoy">তারিখ</th>
                        <th class="unicode-to-bijoy">আচরণ বিষয়ক বিবরণ</th>
                        <th class="unicode-to-bijoy">মালিক/প্রধিকার প্রাপ্ত ব্যক্তির স্বাক্ষর</th>
                        <th class="unicode-to-bijoy">শ্রমিকের স্বাক্ষর/টিপসই</th>
                    </tr>
                    <tr  class="text-center" >
                        <th class="unicode-to-bijoy">১</th>
                        <th class="unicode-to-bijoy">২</th>
                        <th class="unicode-to-bijoy">৩</th>
                        <th class="unicode-to-bijoy">৪</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td><img src="<?php echo base_url('images/'.$register)?>" style="height: 30px"></td>
                        <td><img src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px"></td>
                    </tr>
                </tbody>
            </table>

        </div>
        <div style="width:1% !important"></div>
        <div class="flex-fill" style="height:90vh;width:60vw;border: 1px solid black;">
            <p  class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;">ফরম নং - ৭(ঙ)</p>
            <h6 class="text-center unicode-to-bijoy" style="font-weight:700;"> পঞ্চম ভাগ</h6>
            <p  class="unicode-to-bijoy" style="padding: 5px 0px 0px 5px;font-weight:600;"> আচরণের রেকর্ডঃ </p>
            <table class=" table-sm" style="font-size: 0.8em;width: 100%;" border="1">
                <thead>
                    <tr  class="text-center" >
                        <th class="unicode-to-bijoy">তারিখ</th>
                        <th class="unicode-to-bijoy">আচরণ বিষয়ক বিবরণ</th>
                        <th class="unicode-to-bijoy">মালিক/প্রধিকার প্রাপ্ত ব্যক্তির স্বাক্ষর</th>
                        <th class="unicode-to-bijoy">শ্রমিকের স্বাক্ষর/টিপসই</th>
                    </tr>
                    <tr  class="text-center" >
                        <th>১</th>
                        <th>২</th>
                        <th>৩</th>
                        <th>৪</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>-</td>
                        <td>-</td>
                        <td><img src="<?php echo base_url('images/'.$register)?>" style="height: 30px"></td>
                        <td><img src="<?php echo base_url('uploads/emp_signature/'.$emp_signature)?>" style="height: 30px"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php }?>
    <!-- <div style="page-break-after: always;"></div> -->
    <script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
    <?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>
</html>


