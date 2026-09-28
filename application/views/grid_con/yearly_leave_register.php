<?php
    $this->db->select('*')->where_in('leave_type',['cl','sl','el'])->where('emp_id', $values['emp_info']->emp_id)->order_by('start_date','ASC');
    if( $first_date == '' && $second_date == ''){
        $this->db->where('start_date >',date('d/m/Y',strtotime($values['emp_info']->emp_join_date)));
    }else if( !$first_date == '' && $second_date == ''){
        $this->db->where('start_date >',date('Y-01-01',strtotime($first_date)))->where('start_date <',date('Y-12-31',strtotime($first_date)));
    }else{
        $this->db->where('start_date >',date('Y-01-01',strtotime($first_date)))->where('start_date <',date('Y-m-d',strtotime($second_date)));
    }
    $take_leaves =$this->db->get('pr_leave_trans')->result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">

    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: normal;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg .tg-8jvv {
            border-color: inherit;
            font-size: 15px;
            text-align: left;
            vertical-align: top
        }
    </style>
</head>
<body>
<div class="container">
        <div class="text-center" style="line-height: 10px;margin-top:20px">
            <p class="unicode-to-bijoy">বাংলাদেশ গেজেট,অতিরিক্ত,সেপ্টেম্বর ১৫,২০১৫ </p>
            <p class="unicode-to-bijoy">ফরম-৯</p>
            <p class="unicode-to-bijoy">[ধারা ১০,১১৫,১১৬ ও ১১৭ এবং বিধি ২৪ ও ১০৮(১) দ্রষ্টব্য]</p>
            <p  class="unicode-to-bijoy">ছুটির রেজিস্টার ও ছুটির বহি</p>

        </div>
        <?php
        // dd();
        $unit_id =$this->session->userdata['data']->unit_name;
        $com_info = $this->db->select('*')->where('unit_id',$unit_id)->get('company_infos')->row();

        ?>
        <div class="mt-5" style="line-height: 10px;">
            <p class="unicode-to-bijoy">কারখানা/প্রতিষ্ঠানের নামঃ <?php echo $com_info->company_name_bangla?></p>
            <p class="unicode-to-bijoy">কারখানা/প্রতিষ্ঠানের নাম ঠিকানাঃ <?php echo $com_info->company_add_bangla?>।</p>
            <p class="unicode-to-bijoy">শ্রমিকের নামঃ <?php echo $values['emp_info']->name_bn?> <span style="margin-left: 20px">কার্ড নংঃ <?php echo $values['emp_info']->emp_id?></span> <span style="margin-left: 20px">পদবীঃ <?php echo $values['emp_info']->desig_bangla?></span></p>
            <p class="unicode-to-bijoy">শ্রমিক রেজিস্টারের ক্রমিক নংঃ <?php echo $values['emp_info']->id?></p>
            <p class="unicode-to-bijoy">বিভাগ বা শাখার নামঃ  <?php echo $values['emp_info']->dept_bangla?> <span class="unicode-to-bijoy" style="margin-left: 20px">নিয়োগের তারিখঃ <?php echo date('d/m/Y',strtotime($values['emp_info']->emp_join_date))?></span></p>
        </div>
        <table class="tg">
            <thead>
                <tr>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">বৎসরের প্রারম্ভে জমাকৃত বার্ষিক ছুটি</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" colspan="3">কি ধরনের ছুটি চাওয়া হইয়াছে</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">প্রত্যাখ্যান বা মুলতবি রাখা হইলে প্রত্যাখ্যানের বা মুলতবীর কারণ</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">ছুটি মঞ্জুরের তারিখ</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">কত দিন <span style="font-family:SutonnyMJ;font-size: 20px;">gÄy‡ii</span> করা হইল</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">বার্ষিক ছুটি নগদায়নের সংখ্যা ও অর্থ প্রদানের তারিখ</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" colspan="3">অবশিষ্ট পাওনা ছুটির পরিমাণ</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">শ্রমিকের স্বাক্ষর</th>
                    <th class="tg-8jvv text-center unicode-to-bijoy" rowspan="2">মালিক/ব্যবস্থাপকের স্বাক্ষর</th>
                </tr>
                <tr>
                    <th class="tg-8jvv unicode-to-bijoy">বার্ষিক</th>
                    <th class="tg-8jvv unicode-to-bijoy">নৈমিত্তিক</th>
                    <th class="tg-8jvv unicode-to-bijoy">পীড়া</th>
                    <th class="tg-8jvv unicode-to-bijoy">বার্ষিক</th>
                    <th class="tg-8jvv unicode-to-bijoy">নৈমিত্তিক</th>
                    <th class="tg-8jvv unicode-to-bijoy">পীড়া</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tg-8jvv text-center unicode-to-bijoy">1</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">2</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">3</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">4</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">5</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">6</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">7</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">8</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">9</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">10</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">11</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">12</td>
                    <td class="tg-8jvv text-center unicode-to-bijoy">13</td>
                </tr>
				<?php
					// dd($take_leaves);
					$separated_data = [];
					foreach ($take_leaves as $object) {
						$year = date('Y', strtotime($object->start_date));
						$separated_data[$year][] = $object;
					}
                    ?>
				<tr>
				<?php $leave_year='';	foreach ($separated_data as $year => $objects) {

                    $total_cl_leave = $values['leave_balance']->lv_cl;
                    $total_sl_leave = $values['leave_balance']->lv_sl;
                    $total_el_leave = 0;
                    $total_cl_use =0;
                    $total_sl_use =0;
                    $total_el_use =0;
					echo "<td colspan='13' class='unicode-to-bijoy'>বছর: $year</td>";
                ?>
                </tr>
				<?php
                    $count = count($objects) - 1;
                    foreach ($objects as $key => $object) {
                ?>
                    <tr>
                        <td class="text-center unicode-to-bijoy">
                            <?php
                                $array = $values['yearly_total_info'];
                                // dd($array);
                                if (isset($array[$year]["P"])) {
                                    $total_el_leave = round($array[$year]["P"]/18,2);
                                } else {
                                    // Handle the case when the key is undefined
                                    $total_el_leave = 0; // or any other default value
                                }
                            ?>
                        </td>
						<td class="text-center unicode-to-bijoy"><?php echo $object->leave_type == 'el' ? "বার্ষিক":""?></td>
						<td class="text-center unicode-to-bijoy"><?php echo $object->leave_type == 'cl' ? "নৈমিত্তিক":""?></td>
						<td class="text-center unicode-to-bijoy"><?php echo $object->leave_type == 'sl' ? "পীড়া":""?></td>
						<td><?php echo " "?></td>
						<td class="text-center"><?php echo "<span class='unicode-to-bijoy'>".date('d/m/Y', strtotime($object->start_date))."</span>"?></td>
						<td class="text-center unicode-to-bijoy">
							<?php  $date1 = new DateTime($object->leave_start);
								$date2 = new DateTime($object->leave_end);
								$interval = $date2->diff($date1);
								$interval->d += 1;
								$use =  $interval->format('%d');
								echo "<span class='unicode-to-bijoy'>".$use."</span>";
                                 $object->leave_type == 'cl'?($total_cl_use += $use):($object->leave_type == 'sl'?($total_sl_use += $use):($total_el_use += $use) );
                        	?>
						</td>
						<td><?php echo " "?></td>
						<td class="text-center unicode-to-bijoy"><?php   echo  $object->leave_type == 'el' ? ($el_leaves =$total_el_leave - $total_el_use):'';?></td>
						<td class="text-center unicode-to-bijoy"><?php   echo  $object->leave_type == 'cl' ? ($total_cl_leave - $total_cl_use):'';?></td>
						<td class="text-center unicode-to-bijoy"><?php   echo  $object->leave_type == 'sl' ? ($total_sl_leave - $total_sl_use):'';?></td>
						<td style="text-align:center"><img style="height: 20px;" src="<?=base_url('/uploads/emp_signature/'.$values['emp_info']->signature)?>"></td>
						<td style="text-align:center"><img style="height: 38px;" src="<?=base_url('images/'.$values['emp_info']->register)?>"></td>
					</tr>

					<?php
                       if($count == $key){ ?>
                            <tr>
                                <td class="text-center unicode-to-bijoy">
                                    <!-- < ?php dd($array[$year]["P"]) ?> -->
                                    <?php echo isset($array[$year]) ? round($array[$year]["P"]/18,2).'দিন' : ''?>
                                </td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <?php
                                    @$paid_date = $this->db->select('paid_date')->where('year',$year)->where('emp_id',$object->emp_id)->get('pr_earn_leave_paid')->row()->paid_date;
                                ?>
                                <td class="text-center unicode-to-bijoy">
                                    <?php
                                        echo (isset($el_leaves) && $el_leaves != '') ? round($el_leaves,2).' দিন , <br>':'';
                                        // echo round($el_leaves,2).' দিন , <br>';
                                        echo "</br>";
                                        echo isset($paid_date)? $paid_date:'';
                                    ?>
                                </td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                                <td><?php echo ""?></td>
                            </tr>
                    <?php } } }

                    ?>
            </tbody>
        </table>
</div>
<script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
<?php echo "<script>applyUnicodeToBijoy()</script>"?>
</body>
</html>
<br><br><br>
