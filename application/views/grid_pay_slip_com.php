<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pay Slip</title>
<style type="text/css">
<!--
.style1 {font-size: 15px}
-->
</style>
</head>
<body style=" margin:0px auto; margin-left:60px;">
<table align="left" border="0" cellpadding="0" cellspacing="0">
<tr>
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
	echo "<tr>";
	//}?>
	<?php //echo "<td height='350;' width='450' valign='top' align='center'>"; ?>
    <td style="width:450px; height:300px;">
	<div style="width:100%; height:auto; ">
		<?php if($i % 3 == 0)
		{
			//echo "<div>";
			$k = $k + 1;
			echo "<div style='width:318px;;height:26px;text-align: right'>&nbsp;</div>";
			//echo "</div>";
		} ?>
		<div style="width:315px; height:auto; overflow:hidden; font-size:9px; font-family: SolaimanLipi;margin-bottom:50px; border:1px solid black;">

			<div style="width:280px; height:40px; margin:0 auto; text-align:center;">
				<?php
				//$data['unit_id'] = $unit_id;
				$this->load->view('head_bangla'); ?>



				<span style="font-size:12px; font-weight:bold;">&#2474;&#2503; - &#2488;&#2509;&#2482;&#2495;&#2474;-<span style="font-family:'Times New Roman', Times, serif;">
				<?php
					$first= $rows["salary_month"];
					$first_y=trim(substr($first,0,4));
					$first_m=trim(substr($first,5,2));
					$first_d=trim(substr($first,8,2));
					$month_format = date("F", mktime(0, 0, 0, $first_m, 1, $first_y));
					echo "$month_format, $first_y";
				?>
				</span>(অফিস কপি)
			</div>

			<div style="width:312px; margin-top:12px; line-height: 14px; height:auto; overflow:hidden; border:1px solid #000000;">
				<div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden; line-height:11px;">
					<table width="300" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="76" style="font-size: 10px;">&#2472;&#2494;&#2478; </td>
							<td width="100"><font style="font-family:SutonnyMJ; font-size: 8px;">: <strong><?php echo $rows["bangla_nam"];?></strong> </font></td>
							<td width="72">গ্রেড</td>
							<td width="75"><font style="font-family: SutonnyMJ;font-size: 11px;">: <?php echo $rows["gr_name"];   ?> </font></td>
						</tr>

						<tr>
							<td width="76" style="font-size: 10px;">পদবী </td>
							<td width="100"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["desig_bangla"];   ?> </font></td>
							<td width="72" style="font-size: 10px;">&#2465;&#2495;&#2474;&#2494;&#2480;&#2509;&#2463;&#2478;&#2503;&#2472;&#2509;&#2463; </td>
							<td width="75" style="font-size: 10px;"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["dept_bangla"];   ?> </font></td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2453;&#2494;&#2480;&#2509;&#2465;</td>
							<td width="100"><font style="font-family:SutonnyMJ;font-size: 11px; font-weight: bold;">: <?php echo $rows["emp_id"];   ?></font></td>
							<td width="72" style="font-size: 10px;">&#2488;&#2503;&#2453;&#2486;&#2472; </td>
							<td width="75"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["sec_bangla"];   ?></font></td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2479;&#2507;&#2455;&#2470;&#2494;&#2472;&#2503;&#2480; &#2468;&#2494;&#2480;&#2495;&#2454; </td>
							<td width="100"><font style="font-family:SutonnyMJ, Times, serif;font-size: 11px;">:
							<?php
							$date =  $rows["emp_join_date"];
							$year=trim(substr($date,0,4));
							$month=trim(substr($date,5,2));
							$day=trim(substr($date,8,2));
							$date_format = date("d-m-y", mktime(0, 0, 0, $month, $day, $year));
							echo $date_format;
							?>
							</font></td>
							<td width="72" style="font-size: 10px;">&#2482;&#2494;&#2439;&#2472; </td>
							<td width="75"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["line_bangla"];   ?> </font></td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463; &#2470;&#2495;&#2472; </td>
							<td width="100"><font style="font-family: SutonnyMJ; font-size:14px;font-size: 11px;">: <?php echo $total_days = $rows["total_days"];   ?> </font></td>
							<!--<td width="72" style="font-size: 10px;">&#2474;&#2460;&#2495;&#2486;&#2472;</td>
							<td width="75"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["posi_name"];   ?> </font></td>-->
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463; &#2453;&#2480;&#2509;&#2478; &#2470;&#2495;&#2476;&#2488; </td>
							<td width="100"><font style="font-family: SutonnyMJ; font-size:14px;">:
							<?php
						//	$holidy_or_weeked = $rows["holiday_or_weeked"];
							echo $rows["num_of_workday"];
							?>
							</font></td>
							<td width="72" style="font-size: 10px;">&#2459;&#2497;&#2463;&#2495; </td>
							<td width="75">
							<font style="font-family: SutonnyMJ; font-size:14px;">:
							<?php
							$c_l = $rows["c_l"];
							$s_l = $rows["s_l"];
							$e_l = $rows["e_l"];
							echo $total_leave = $c_l + $s_l + $e_l;
							?>
							</font>
							</td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463; &#2437;&#2472;&#2497;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
							<td width="100"> <font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["absent_days"];   ?> </font>    </td>
							<td width="72" style="font-size: 10px;">&#2441;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
							<td width="75"><font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["att_days"];   ?> </font>  </td>
						</tr>

						<tr>
							<td width="76" style="font-size: 10px;">&#2488;&#2494;&#2474;&#2509;&#2468;&#2494;&#2489;&#2495;&#2453; &#2459;&#2497;&#2463;&#2495; </td>
							<td width="100">   <font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["weekend"];   ?> </font>  </td>
							<td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495; &#2456;&#2472;&#2509;&#2463;&#2494; </td>
							<td width="75">
								<font style="font-family: SutonnyMJ;font-size:14px;">:
									<?php echo round($rows["ot_hour"] + $rows["w_h_ot"]); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td width="76" height="14" style="font-size: 10px;">&#2437;&#2472;&#2509;&#2479;&#2494;&#2472;&#2509;&#2479; &#2459;&#2497;&#2463;&#2495;
							</td>
							<td width="100" style="font-size: 10px;"><font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["holiday"];   ?> </font> </td>
							<td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495; &#2480;&#2503;&#2463; </td>
							<td width="75"><font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["ot_rate"];   ?> </font></td>
						</tr>

					</table>
				</div>
				<div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden;">
					<div style="float:left; width:55px; height: auto; position:relative; left:5px; top:18px; font-weight:bold;">
					</div>
					<div style="float: left; width:240px; border-left:1px solid #000000; line-height:11px;" >
						<table width="230" cellspacing="0" cellpadding="0" style="font-size: 11px;">
							<tr>
								<td width="160" >মূল বেতন  </td>
								<td>:</td>
								<td width="70" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["basic_sal"];   ?> </font></td>
							</tr>
							<tr>
								<td width="160">বাড়ী ভাড়া </td>
								<td>:</td>
								<td width="12" align="right">  <font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["house_r"];   ?> </font></td>
							</tr>

							<tr>
								<td width="160">&#2458;&#2495;&#2453;&#2495;&#2510;&#2488;&#2494; &#2477;&#2494;&#2468;&#2494;	  	  </td>
								<td>:</td>
								<td width="12" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["medical_a"];   ?> </font> </td>
							</tr>
							<tr>
								<td width="160"> যাতায়াত ভাতা</td>
								<td>:</td>
								<td width="12" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $trans_allow = $rows["trans_allow"];   ?> </font> </td>
							</tr>
							<tr>
								<td width="160">খাদ্য ভাতা</td>
								<td>:</td>
								<td width="12" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $food_allow = $rows["food_allow"];   ?> </font> </td>
							</tr>
							<tr>
								<td width="160" height="14">&#2478;&#2507;&#2463;</td>
								<td>:</td>
								<td width="12" align="right">  <font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["gross_sal"];   ?> </font></td>
							</tr>
						</table>
					</div>
				</div>
				<!--add-->
				<div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden;">

				<div style="float:left; width:55px; position:relative; left:5px; top:25px; font-weight:bold;">(খ) কর্তন </div>
					<div style="float: left; width:240px; border-left:1px solid #000000; line-height:8px;" >
						<table width="236" style="font-size: 11px;">
							<tr>
								<td width="152"> বাস </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["transport_deduct"];   ?> </font></td>
							</tr>
							<tr>
								<td width="152"> অগ্রীম </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["adv_deduct"];   ?> </font></td>
							</tr>
							<tr>
								<td width="152">অনুপস্থিত</td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["abs_deduction"];    ?> </font></td>
							</tr>
							<!--<tr>
								<td width="152">লেট </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["late_deduct"];    ?> </font></td>
							</tr>-->
						<!--	<tr>
								<td width="152">ষ্ট্যাম্প</td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["stamp"];    ?> </font></td>
							</tr>-->
							<tr>
								<td width="152">&#2478;&#2507;&#2463; &#2453;&#2480;&#2509;&#2468;&#2472; </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $rows["total_deduct"];   ?> </font></td>
							</tr>
						</table>
					</div>
				</div>

				<div style="border-bottom:1px solid #000000; line-height: 25px;">
				<table width="295" cellspacing="0" cellpadding="0">
						<tr>
						<td width="210" ><span style="position:relative; left:5px; font-weight:bold;"> (গ) উপস্থিত বোনাস </span></td>
						<td >:</td>
						<td width="45" style="padding-right: 10px;" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["att_bonus"];   ?> </font></td>
						</tr>
					</table>
				</div>

				<div style="border-bottom:1px solid #000000; line-height: 25px;">
					<table width="298" cellspacing="0" cellpadding="0">
						<tr>
							<td width="210"><span style="position:relative; left:5px; font-weight:bold;"> (ঘ) ওভার টাইম</span></td>
							<td >:</td>
							<td width="45" style="padding-right: 12px;" align="right">
								<span style="font-family: SutonnyMJ; font-size:14px;" > <?php echo $rows["ot_amount"] + $rows["w_h_ot_amt"];?> </span>
							</td>
						</tr>
					</table>
				</div>

				<div>
					<table width="295" height="17" cellspacing="0" cellpadding="0">
						<tr>
							<td width="215"><span style="position:relative; left:5px; font-weight:bold;">সর্বমোট প্রদেয় বেতন ( ক - খ + গ + ঘ )  </span>
							<td >:</td>



							<td width="78" style="padding-right: 9px;" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $rows["gross_sal"] + $rows["ot_amount"] + $rows["w_h_ot_amt"] + $rows["att_bonus"] - $rows["total_deduct"];?> </font></td>


						</tr>
					</table>
				</div>
			</div>
			<div style=" width:315px; font-size:12px; padding-top:20px; margin-left: 10px; margin-bottom: 1px; margin-right: 10px;">
				<span style=" width:150px; float:left;">কর্তৃপক্ষের স্বাক্ষর</span>
				<span style=" width:150px; margin-left: 70px;">কর্মচারীর স্বাক্ষর</span>
			</div>
		</div>
	</div>
	<?php echo "</td>"; ?>

    <?php //echo "<td height='350;' width='450' valign='top' align='center'>"; ?>
    <td style="width:450px; height:300px;">
	<div style="width:100%; height:auto; ">
		<?php if($i % 3 == 0)
		{
			//echo "<div>";
			echo "<div style='width:318px;height:26px;text-align: right;font-weight:bold;'>Page No # $k of $page</div>";
			//echo "</div>";float:left
		} ?>
		<div style="width:315px; height:auto; overflow:hidden; font-size:9px; font-family: SolaimanLipi;margin-bottom:50px; border:1px solid black;">
			<div style="width:280px; height:40px; margin:0 auto; text-align:center;">
					<?php $this->load->view('head_bangla'); ?>
				<span style="font-size:12px; font-weight:bold;">&#2474;&#2503; - &#2488;&#2509;&#2482;&#2495;&#2474;-
				<span style="font-family:'Times New Roman', Times, serif;">
					<?php
						$first= $rows["salary_month"];
						$first_y=trim(substr($first,0,4));
						$first_m=trim(substr($first,5,2));
						$first_d=trim(substr($first,8,2));
						$month_format = date("F", mktime(0, 0, 0, $first_m, 1, $first_y));
						echo "$month_format, $first_y";
					?>
				</span>(শ্রমিক কপি)
			</div>

			<div style="width:312px; margin-top:12px; line-height: 14px; height:auto; overflow:hidden; border:1px solid #000000;">
				<div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden; line-height:11px;">
					<table width="300" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="76" style="font-size: 10px;">&#2472;&#2494;&#2478; </td>
							<td width="100"><font style="font-family:SutonnyMJ; font-size: 8px;">: <strong><?php echo $rows["bangla_nam"];?></strong> </font></td>
							<td width="72">গ্রেড</td>
							<td width="75"><font style="font-family: SutonnyMJ;font-size: 11px;">: <?php echo $rows["gr_name"];   ?> </font></td>
						</tr>

						<tr>
							<td width="76" style="font-size: 10px;">পদবী </td>
							<td width="100"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["desig_bangla"];   ?> </font></td>
							<td width="72" style="font-size: 10px;">&#2465;&#2495;&#2474;&#2494;&#2480;&#2509;&#2463;&#2478;&#2503;&#2472;&#2509;&#2463; </td>
							<td width="75" style="font-size: 10px;"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["dept_bangla"];   ?> </font></td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2453;&#2494;&#2480;&#2509;&#2465;</td>
							<td width="100"><font style="font-family:SutonnyMJ;font-size: 11px; font-weight: bold;">: <?php echo $rows["emp_id"];   ?></font></td>
							<td width="72" style="font-size: 10px;">&#2488;&#2503;&#2453;&#2486;&#2472; </td>
							<td width="75"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["sec_bangla"];   ?></font></td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2479;&#2507;&#2455;&#2470;&#2494;&#2472;&#2503;&#2480; &#2468;&#2494;&#2480;&#2495;&#2454; </td>
							<td width="100"><font style="font-family:SutonnyMJ, Times, serif;font-size: 11px;">:
							<?php
							$date =  $rows["emp_join_date"];
							$year=trim(substr($date,0,4));
							$month=trim(substr($date,5,2));
							$day=trim(substr($date,8,2));
							$date_format = date("d-m-y", mktime(0, 0, 0, $month, $day, $year));
							echo $date_format;
							?>
							</font></td>
							<td width="72" style="font-size: 10px;">&#2482;&#2494;&#2439;&#2472; </td>
							<td width="75"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["line_bangla"];   ?> </font></td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463; &#2470;&#2495;&#2472; </td>
							<td width="100"><font style="font-family: SutonnyMJ; font-size:14px;font-size: 11px;">: <?php echo $total_days = $rows["total_days"];   ?> </font></td>
							<!--<td width="72" style="font-size: 10px;">&#2474;&#2460;&#2495;&#2486;&#2472;</td>
							<td width="75"><font style="font-family:'Times New Roman', Times, serif;font-size: 11px;">: <?php echo $rows["posi_name"];   ?> </font></td>-->
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463; &#2453;&#2480;&#2509;&#2478; &#2470;&#2495;&#2476;&#2488; </td>
							<td width="100"><font style="font-family: SutonnyMJ; font-size:14px;">:
							<?php
						//	$holidy_or_weeked = $rows["holiday_or_weeked"];
							echo $rows["num_of_workday"];
							?>
							</font></td>
							<td width="72" style="font-size: 10px;">&#2459;&#2497;&#2463;&#2495; </td>
							<td width="75">
							<font style="font-family: SutonnyMJ; font-size:14px;">:
							<?php
							$c_l = $rows["c_l"];
							$s_l = $rows["s_l"];
							$e_l = $rows["e_l"];
							echo $total_leave = $c_l + $s_l + $e_l;
							?>
							</font>
							</td>
						</tr>
						<tr>
							<td width="76" style="font-size: 10px;">&#2478;&#2507;&#2463; &#2437;&#2472;&#2497;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
							<td width="100"> <font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["absent_days"];   ?> </font>    </td>
							<td width="72" style="font-size: 10px;">&#2441;&#2474;&#2488;&#2509;&#2469;&#2495;&#2468;&#2495; </td>
							<td width="75"><font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["att_days"];   ?> </font>  </td>
						</tr>

						<tr>
							<td width="76" style="font-size: 10px;">&#2488;&#2494;&#2474;&#2509;&#2468;&#2494;&#2489;&#2495;&#2453; &#2459;&#2497;&#2463;&#2495; </td>
							<td width="100">   <font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["weekend"];   ?> </font>  </td>
							<td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495; &#2456;&#2472;&#2509;&#2463;&#2494; </td>
							<td width="75">
								<font style="font-family: SutonnyMJ;font-size:14px;">:
									<?php echo round($rows["ot_hour"] + $rows["w_h_ot"]); ?>
								</font>
							</td>
						</tr>
						<tr>
							<td width="76" height="14" style="font-size: 10px;">&#2437;&#2472;&#2509;&#2479;&#2494;&#2472;&#2509;&#2479; &#2459;&#2497;&#2463;&#2495;
							</td>
							<td width="100" style="font-size: 10px;"><font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["holiday"];   ?> </font> </td>
							<td width="72" style="font-size: 10px;">&#2451;&#2463;&#2495; &#2480;&#2503;&#2463; </td>
							<td width="75"><font style="font-family: SutonnyMJ; font-size:14px;">: <?php echo $total_days = $rows["ot_rate"];   ?> </font></td>
						</tr>

					</table>
				</div>
				<div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden;">
					<div style="float:left; width:55px; height: auto; position:relative; left:5px; top:18px; font-weight:bold;">
					</div>
					<div style="float: left; width:240px; border-left:1px solid #000000; line-height:11px;" >
						<table width="230" cellspacing="0" cellpadding="0" style="font-size: 11px;">
							<tr>
								<td width="160" >মূল বেতন  </td>
								<td>:</td>
								<td width="70" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["basic_sal"];   ?> </font></td>
							</tr>
							<tr>
								<td width="160">বাড়ী ভাড়া </td>
								<td>:</td>
								<td width="12" align="right">  <font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["house_r"];   ?> </font></td>
							</tr>

							<tr>
								<td width="160">&#2458;&#2495;&#2453;&#2495;&#2510;&#2488;&#2494; &#2477;&#2494;&#2468;&#2494;	  	  </td>
								<td>:</td>
								<td width="12" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["medical_a"];   ?> </font> </td>
							</tr>
							<tr>
								<td width="160"> যাতায়াত ভাতা</td>
								<td>:</td>
								<td width="12" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $trans_allow = $rows["trans_allow"];   ?> </font> </td>
							</tr>
							<tr>
								<td width="160">খাদ্য ভাতা</td>
								<td>:</td>
								<td width="12" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $food_allow = $rows["food_allow"];   ?> </font> </td>
							</tr>
							<tr>
								<td width="160" height="14">&#2478;&#2507;&#2463;</td>
								<td>:</td>
								<td width="12" align="right">  <font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["gross_sal"];   ?> </font></td>
							</tr>
						</table>
					</div>
				</div>
				<!--add-->
				<div style="width:100%; border-bottom:1px solid #000000; height:auto; overflow:hidden;">

				<div style="float:left; width:55px; position:relative; left:5px; top:25px; font-weight:bold;">(খ) কর্তন </div>
					<div style="float: left; width:240px; border-left:1px solid #000000; line-height:8px;" >
						<table width="236" style="font-size: 11px;">
							<tr>
								<td width="152"> বাস </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["transport_deduct"];   ?> </font></td>
							</tr>
							<tr>
								<td width="152"> অগ্রীম </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["adv_deduct"];   ?> </font></td>
							</tr>
							<tr>
								<td width="152">অনুপস্থিত</td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["abs_deduction"];    ?> </font></td>
							</tr>
							<!--<tr>
								<td width="152">লেট </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["late_deduct"];    ?> </font></td>
							</tr>-->
							<!--<tr>
								<td width="152">ষ্ট্যাম্প</td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $total_days = $rows["stamp"];    ?> </font></td>
							</tr>-->
							<tr>
								<td width="152">&#2478;&#2507;&#2463; &#2453;&#2480;&#2509;&#2468;&#2472; </td>
								<td >:</td>
								<td width="59" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $rows["total_deduct"];   ?> </font></td>
							</tr>
						</table>
					</div>
				</div>
				<?php /*
				<div style="border-bottom:1px solid #000000; line-height: 25px;">
				<table width="295" cellspacing="0" cellpadding="0">
						<tr>
						<td width="210" ><span style="position:relative; left:5px; font-weight:bold;"> অগ্রীম দণ্ড </span></td>
						<td >:</td>
						<td width="45" style="padding-right: 10px;" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $due_pay_add = $rows["due_pay_add"];   ?> </font></td>
						</tr>
					</table>
				</div> */?>

				<div style="border-bottom:1px solid #000000; line-height: 25px;">
				<table width="295" cellspacing="0" cellpadding="0">
						<tr>
						<td width="210" ><span style="position:relative; left:5px; font-weight:bold;"> (গ) উপস্থিত বোনাস </span></td>
						<td >:</td>
						<td width="45" style="padding-right: 10px;" align="right"><font style="font-family: SutonnyMJ; font-size:14px;"><?php echo $total_days = $rows["att_bonus"];   ?> </font></td>
						</tr>
					</table>
				</div>

				<div style="border-bottom:1px solid #000000; line-height: 25px;">
					<table width="298" cellspacing="0" cellpadding="0">
						<tr>
							<td width="210"><span style="position:relative; left:5px; font-weight:bold;"> (ঘ) ওভার টাইম</span></td>
							<td >:</td>
							<td width="45" style="padding-right: 12px;" align="right">
								<span style="font-family: SutonnyMJ; font-size:14px;" > <?php echo $rows["ot_amount"] + $rows["w_h_ot_amt"];?> </span>
							</td>
						</tr>
					</table>
				</div>

				<div>
					<table width="295" height="17" cellspacing="0" cellpadding="0">
						<tr>
							<td width="215"><span style="position:relative; left:5px; font-weight:bold;">সর্বমোট প্রদেয় বেতন ( ক - খ + গ + ঘ )  </span>
							<td >:</td>



							<td width="78" style="padding-right: 9px;" align="right"> <font style="font-family: SutonnyMJ; font-size:14px;"> <?php echo $rows["gross_sal"] + $rows["ot_amount"] + $rows["w_h_ot_amt"] + $rows["att_bonus"] - $rows["total_deduct"];?> </font></td>


						</tr>
					</table>
				</div>
			</div>
			<div style=" width:315px; font-size:12px; padding-top:20px; margin-left: 10px; margin-bottom: 1px; margin-right: 10px;">
				<span style=" width:150px; float:left;">কর্তৃপক্ষের স্বাক্ষর</span>
				<span style=" width:150px; margin-left: 70px;">কর্মচারীর স্বাক্ষর</span>
			</div>
		</div>
	</div>

	<?php echo "</td>"; ?>
<?php
	echo "</tr>";
	$i = $i + 1;
}
?>
</tr>
</table>

</body>
</html>
