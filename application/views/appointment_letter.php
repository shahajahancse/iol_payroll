<!DOCTYPE html>
<html>
<head>
	<title>Appointment Letter</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style>
	#wrapper{
          margin:0 auto;		  
		  width:700px;
		  overflow:hidden;
  		  margin-bottom:50px;
		 }
	#header{
	          width:700px;
			  height:42px;
			  /*background-color: #CCCCCC;*/
	        } 
	#h_left {
	         width:500px;
			 height:auto;
			 float:left;
			 }
	#h_right {
	         width:200px;
			 height:auto;
			 float:right;
			 }
	#nav {
	         float:left;
			 width:700px;
			 height:auto;
			 padding:10px;
	     }
	#nav_inner {
	         width:190px;
			 height:30px;
			 font-size:20px;
			 font-weight:bold;
			 padding-top:5px;
			 border:1px solid #333333;
			 border-collapse:collapse;
			 border-radius:18px;
			 -moz-border-radius:18px;
			 -webkit-border-radius:18px;
			 background-color:#999999;
			 }
	#nav_bottom {
	         float:left;
	         width:700px;
			 height:auto;
			 text-align:justify;
			 } 
	.body {
	         float:left;
	         width:700px;
			 height:auto;
			 text-align:justify;
			}
	#body_inner_left {
	         float:left;
			 width:200px;
			 height:auto;
			 text-align:left;
			 } 
	#body_inner_center {
	         float:left;
			 width:100px;
			 height:auto;
			 }
	#body_inner_right {
	         float:left;
			 width:200px;
			 height:auto;
			 text-align:left;
			 } 
	#body_inner_left_ep {
	         float:left;
			 width:200px;
			 height:auto;
			 text-align:right;
			 } 
	#break { 
	         float:left;
			 width:700px;
			 height:auto;
	       } 
	#footer {
	         float:left;
			 width:700px;
			 height:auto;
			 background:red;   
	         }  
	#footer_left {
	         float:left;
			 width:300px;
			 height:auto;   
	         } 
	#footer_right {
	         float:right;
			 width:300px;
			 height:auto;   
         }       
</style>		 
</head>
		   
<body style="font-family:SolaimanLipi;">

	<?php foreach($values->result() as $row){ ?>
		<div id="wrapper">
			<div id="header" align="center" style="min-height: 60px;">
				<div style="float: left;">
					
					<img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_info()->company_logo; ?>" />
				</div>

				<div style="float: left; width: 80%;">
					
					<span style="text-align:center"><span style="font-size:18px; font-weight:bold;">
		        		<?php echo $company_logo = $this->common_model->company_info()->company_name_bangla; ?></span><br>
		        		<?php echo $company_logo = $this->common_model->company_info()->company_add_bangla; ?>
					</span>
					 <?php //$this->load->view('head_bangla'); ?>  
					 <br>

					 <div align="center" >
						<div><b>Appointment Letter</b></div>
						<div><b>নিয়োগ পত্র</b> </div>
					</div>

				</div>
			</div>
			<br>
			

			<!-- <div id="nav" align="center" >
				<div>appointment_letter</div>
				<div id="nav_inner">
					বিষয়ঃ  নিয়োগ পত্র 
				</div>
			</div> -->

			<div style="line-height:20px; font-size:13px; width: 100%; display: inline-block;">
				<div style="width: 50%; float: left;">
					<span>আইডি কার্ড নং : &nbsp;<b style="font-family: SutonnyMj"><?php echo $row->emp_id; ?> </b></span> <br>
					<span>পিতার নাম  : &nbsp;&nbsp;<b><?php echo $row->emp_fname; ?> </b></span><br>
					<span>স্বামী বা স্ত্রীর নাম : &nbsp;&nbsp;<b><?php echo ($row->spouse_name == "0")?"":$row->spouse_name; ?></b></span><br>
					<span>বর্তমান ঠিকানা : &nbsp;&nbsp;<b><?php echo $row->emp_pre_add; ?> </b></span><br>
				</div>
				<div style="width: 50%; float: left;">
					<span>নাম : &nbsp;&nbsp;<b><?php echo $row->bangla_nam; ?> </b></span><br>
					<span>মাতার নাম : &nbsp;&nbsp;<b><?php echo $row->emp_mname; ?> </b></span><br>
					<span>স্থায়ী ঠিকানা : &nbsp;&nbsp;<b><?php echo $row->emp_par_add; ?> </b></span><br>
				</div>
			</div><br/>

			<div style="line-height:20px; font-size:13px; padding-top: 5px ">
				<span><b>জনাব /জনাবা,</b></span><br>
				<span> আপনার আবেদন এবং সাক্ষাৎকার ও যোগ্যতা যাচাই এর প্রেক্ষিতে কর্তৃপক্ষ আপনাকে-</span>
			</div>

			<div style="line-height:20px; font-size:13px; width: 100%; display: inline-block;">
				<div style="width: 25%; float: left;">
					<span>বিভাগ : &nbsp;&nbsp;<b><?php echo $row->dept_bangla; ?> </b></span>
				</div>
				<div style="width: 25%; float: left;">
					<span>পদবী : &nbsp;&nbsp;<b><?php echo $row->desig_bangla; ?> </b></span>
				</div>
				<div style="width: 25%; float: left;">
					<span>শ্রমিকের শ্রেণী : &nbsp;&nbsp;<b>স্থায়ী</b></span>
				</div>
				<div style="width: 25%; float: left;">
					<span>কাজের ধরণ: &nbsp;&nbsp;<b></b></span>
				</div>
			</div>
			
			<br/>

			<div style="line-height:20px; font-size:13px;">
				<span>
					যোগদানের তারিখ : <b style="font-weight: bold;font-family: SutonnyMj;"><?php echo date('d-m-Y', strtotime($row->emp_join_date));?></b>, নিম্নলিখিত শর্ত সাপেক্ষে নিয়োগ প্রদান করিতেছে। আপনার শিক্ষানবিশকাল তিন মাস। এই সময়ের পর আপনি স্থায়ী শ্রমিক হিসেবে গণ্য হইবেন এবং এর জন্য কোন চিঠি প্রদান করা হইবে না। তবে শর্ত থাকে যে, একজন দক্ষ শ্রমিকের ক্ষেত্রে যদি উপরোক্ত তিন মাসে দক্ষতার প্রমাণ দিতে ব্যর্থ হন তাহলে কর্তৃপক্ষ আপনাকে আরো ও তিন মাস শিক্ষানবিশকাল বৃদ্ধি করিতে পারিবেন। 
				</span>
			</div>

				<?php $salary_strc = $this->common_model->salary_structure($row->gross_sal); ?>
		

			<div style="line-height:20px; font-size:13px;">
				<span><b>১. বেতন :</b> </span> <br>
				<table style="" class="sal" width="100%" cellpadding="5" cellspacing="0" border="1" >
					<tr>
						<th>মোট বেতন	<br /> Gross Salary				</th>
						<th>মুল বেতন	<br /> Basic Salary			</th>
						<th>বাড়ি ভাড়া	<br /> House Rent		</th>
						<th>চিকিৎসা ভাতা <br /> Medical	</th>
						<th>যাতায়াত ভাতা	<br /> Conveyance	</th>
			            <th>খাদ্য ভাতা<br />	Food</th>
			            <th>	প্রতি ঘণ্টা ওটি <br /> Hourly O.T Rate	</th>
					</tr>
					<?php 
					
					{ ?>
			        <tr>
			        	<?php $salary_strc = $this->common_model->salary_structure($row->gross_sal); ?>
			        	<td style="text-align:center;font-family: SutonnyMj"><?php echo $salary_strc['gross_salary'];?> </td>
			            <td style="text-align:center; font-weight:bold;font-family: SutonnyMj"><?php echo number_format($salary_strc['basic_sal']) ;?></td>
			            <?php  
			            		$number = $salary_strc['gross_salary'];
			            		$no = round($number);
						        $point = round($number - $no, 2) * 100;
						        $hundred = null;
						        $digits_1 = strlen($no);
						        $i = 0;
						        $str = array();
						        $words = array('0' => '', '1' => 'এক', '2' => 'দুই',
						            '3' => 'তিন', '4' => 'চার', '5' => 'পাঁচ', '6' => 'ছয়',
						            '7' => 'সাত', '8' => 'আট', '9' => 'নয়',
						            '10' => 'দশ', '11' => 'এগার', '12' => 'বার',
						            '13' => 'তের', '14' => 'চোদ্দ',
						            '15' => 'পনের', '16' => 'ষোল', '17' => 'সতের',
						            '18' => 'আঠার', '19' => 'উনিশ', '20' => 'বিশ',
						            '21' => 'একুশ', '22' => 'বাইস', '23' => 'তেইশ', '24' => 'চব্বশি', '25' => 'পঁচশি', '26' => 'ছাব্বশি', '27' => 'সাতাশ', '28' => 'আঠাশ', '29' => 'ঊনত্রশি',
						            '31' => 'একত্রিশ', '32' => 'বত্রিশ', '33' => 'তেত্রিশ', '34' => 'চৌত্রিশ', '35' => 'পঁয়ত্রিশ', '36' => 'ছত্রিশ', '37' => 'সাঁইত্রিশ', '38' => 'আটত্রিশ', '39' => 'ঊনচল্লিশ',
						            '41' => 'একচল্লিশ', '42' => 'বিয়াল্লিশ', '43' => 'তেতাল্লিশ', '44' => 'চুয়াল্লিশ', '45' => 'পঁয়তাল্লিশ', '46' => 'ছেচল্লিশ', '47' => 'সাতচল্লিশ', '48' => 'আটচল্লিশ', '49' => 'ঊনপঞ্চাশ',
						            '51' => 'একান্ন',  '52' => 'বায়ান্ন',  '53' => 'তিপ্পান্ন', '54' => 'চুয়ান্ন',  '55' => 'পঞ্চান্ন',  '56' => 'ছাপ্পান্ন',  '57' => 'সাতান্ন',  '58' => 'আটান্ন',  '59' => 'ঊনষাট',
						            '61' => 'একষট্টি', '62' => 'বাষট্টি', '63' => 'তেষট্টি', '64' => 'চৌষট্টি', '65' => 'পঁয়ষট্টি', '66' => 'ছেষট্টি', '67' => 'সাতষট্টি', '68' => 'আটষট্টি', '69' => 'ঊনসত্তর',
						            '71' => 'একাত্তর', '72' => 'বাহাত্তর', '73' => 'তিয়াত্তর', '74' => 'চুয়াত্তর', '75' => 'পঁচাত্তর', '76' => 'ছিয়াত্তর', '77' => 'সাতাত্তর', '78' => 'আটাত্তর', '79' => 'ঊনআশি',
						            '81' => 'একাশি', '82' => 'বিরাশি', '83' => 'তিরাশি', '84' => 'চুরাশি', '85' => 'পঁচাশি', '86' => 'ছিয়াশি', '87' => 'সাতাশি', '88' => 'আটাশি', '89' => 'ঊননব্বই',
						            '91' => 'একানব্বই', '92' => 'বিরানব্বই', '93' => 'তিরানব্বই', '94' => 'চুরানব্বই', '95' => 'পঁচানব্বই', '96' => 'ছিয়ানব্বই', '97' => 'সাতানব্বই', '98' => 'আটানব্বই', '99' => 'নিরানব্বই',
						            '30' => 'ত্রিশ', '40' => 'চল্লিশ', '50' => 'পঞ্চাশ',
						            '60' => 'ষাট', '70' => 'সত্তর',
						            '80' => 'আশি', '90' => 'নব্বয়');
						        $digits = array('', 'শত', 'হাজার', 'লক্ষ', 'কোটি');
						        while ($i < $digits_1) {
						            $divider = ($i == 2) ? 10 : 100;
						            $number = floor($no % $divider);
						            $no = floor($no / $divider);
						            $i += ($divider == 10) ? 1 : 2;
						            if ($number) {
						                $plural = (($counter = count($str)) && $number > 9) ? '' : null;
						                $hundred = ($counter == 1 && $str[0]) ? '' : null;
						                $str [] = ($number < 100) ? $words[$number] .
						                        " " . $digits[$counter] . $plural . " " . $hundred :
						                        $words[floor($number / 10) * 10]
						                        . " " . $words[$number % 10] . " "
						                        . $digits[$counter] . $plural . " " . $hundred;
						            } else
						                $str[] = null;
						        }
						        $str = array_reverse($str);
						        $result = implode('', $str);
						        $points = ($point) ?
						                "." . $words[$point / 10] . " " .
						                $words[$point = $point % 10] : '';
						        $numtoword = $result . "টাকা মাত্র.";
			            
			            ?>
			            <?php { ?>
			            	<td style="text-align:center;font-family: SutonnyMj"> <?php echo number_format($salary_strc['house_rent']);?>	</td>
			                <td style="text-align:center;font-family: SutonnyMj"> <?php echo number_format($salary_strc['medical_allow']);?>	</td>
			                <td style="text-align:center;font-family: SutonnyMj"> <?php echo number_format($salary_strc['trans_allow']);?> 	</td>
			                <td style="text-align:center;font-family: SutonnyMj"> <?php echo number_format($salary_strc['food_allow']);?>	</td>
			                <td style="text-align:center;font-family: SutonnyMj"> <?php echo number_format($salary_strc['ot_rate']);?>	</td>
			                
			            <?php 
							
						
						} ?>
			        </tr>
			       
			        <?php } ?>
						
				</table>  
				<span>যোগদানের তারিখ থেকে ০১ বছর পূর্ণ হলে আপনার মুল বেতনের কমপক্ষে ৫% বৃদ্ধি হবে ।</span>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>২. সাধারন কর্মঘন্টা এবং অতিরিক্ত কর্মঘন্টা :</b></span> <br>
				<span>ক । দৈনিক কর্মঘণ্টা : ০৮ ঘন্টা প্রতিদিন (০১ ঘন্টা খাবার বিরতি) ।</span><br>
				<span>খ । বেতন/মজুরি প্রদানের সময় প্রত্যেক মাসের বেতন/ অতিরিক্ত কাজের মজুরি একত্রে পরবর্তী মাসের ০৭ কর্মদিবসের মধ্যে যে কোন দিন প্রদান করা হয়।</span><br>
				<span>গ । অতিরিক্ত কর্মঘন্টা হিসাব । প্রতি ঘন্টার মূল মজুরির দ্বিগুণ হারে হিসাব করা হয় | মূল মজুরি /  ২০৮  x ২  x মোট অতিরিক্ত কর্মঘন্টা ।</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৩. মালিক কর্তৃক শ্রমিকের চাকরির অবসান :</b></span> <br>
				<span>ক | বাংলাদেশ শ্রম আইন ২০০৬ সংশোধন ২০১৩ অনুসারে ধারা ২৬ (১) মোতাবেক স্থায়ী শ্রমিক এর চাকরির অবসান করার জন্য ১২০ দিনের নোটিশ প্রদান করা হইবে এবং অস্থায়ী শ্রমিকদের ক্ষেত্রে 30 দিনের লিখিত নোটিশ প্রদান করিতে হইবে ধারা ২৬ (৩) মোতাবেক নোটিশ এর পরিবর্তে নোটিশ মেয়াদের জন্য মজুরি প্রদান করিয়া চাকরি অবসান করিতে পারিবেন।</span><br>
				<span><b>চাকরির ক্ষতিপূরণ : </b> এক্ষেত্রে শ্রমিকের চাকুরীর মেয়াদ এক বছর পূর্ণ হলে প্রত্যেক সম্পূর্ণ বছরের জন্য ক্ষতিপূরণ হিসেবে মালিক ৩০ দিনের মজুরি প্রদান করিবেন |</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৪. শ্রমিক কর্তৃক চাকরির অবসান :</b></span> <br>
				<span>ক) চাকরি হতে ইস্তফা দিতে হইলে বাংলাদেশ শ্রম আইন ২০০৬ সংশোধন ২০১৩ অনুসারে ২৭ (১) ধারা মোতাবেক কোন স্থায়ী শ্রমিক চাকরি ছাড়ার ০২ (দুই) মাস (৬০ দিন) এবং অস্থায়ী শ্রমিককে ১ মাস (৩০ দিন) পূর্বে কর্তৃপক্ষকে লিখিত নোটিশ প্রদান করিতে হইবে | অন্যথায় প্রদেয় নোটিশ এর পরিবর্তে নোটিশ মেয়াদের জন্য মজুরি সমপরিমাণ অর্থ প্রদান করিয়া চাকরি হতে ইস্তফা দিতে পারবেন।</span><br>

				<span><b>চাকরির সুবিধা : </b></span><br>
				<span>ক । এক্ষেত্রে শ্রমিকের চাকরির মেয়াদ পাঁচ বছর বা তদূর্ধ্ব ১০ বছরের কম হলে প্রত্যেক সম্পূর্ণ বছরের জন্য ক্ষতিপূরণ হিসেবে ১৪ দিনের মজুরি প্রদান করিবেন।</span><br>
				<span>খ । শ্রমিকের চাকরির মেয়াদ ১০ বছর বা তদূর্ধ্ব হলে প্রত্যেক সম্পন্ন বছরের জন্য ক্ষতিপূরণ হিসেবে ৩০ দিনের মজুরি প্রদান করিবেন।</span><br>

				<span><b>ক্ষতিপূরণঃ </b></span><br>
				<!-- <span>ক । কোন শ্রমিক মালিকের অধীন অবিচ্ছিন্নভাবে দুই বছর চাকরিরত থাকা অবস্থায় মৃত্যুবরণ করেন, তাহা হইলে তার মনোনীত ব্যাক্তিকে পূর্ণ বৎসর বা উহার ছয় মাসের অধিক সময় চাকুরীর জন্য ক্ষতিপূরন হিসাবে ৩০ দিনের এবং কর্মকালীন দূর্ঘটনার কারণে মৃত্যুর ক্ষেত্রে ৪৫ দিনের মজুরী প্রদান করিবেন। </span><br> -->
				<span>ক । ধারা ২৩ (২)  উপধারা ২ এর (ক) এর অধীন অপসারিত কোনো শ্রমিককে যদি তার অবিচ্ছিন্ন চাকুরীর মেয়াদ অনূন্য ১ বছর হয়, মালিক ক্ষতিপূরণ বাবদ প্রত্যেক সম্পূর্ণ চাকুরী বছরের জন্য ১৫ দিনের মজুরি প্রদান করিবেন। তবে শর্ত থাকে যে, কোনো শ্রমিককে উপধারা ৪ এর (খ) ও (ছ)  অধীন অসদাচরণের জন্য অপসারণ বরখাস্ত করা হলে কোনো ক্ষতিপূরণ পাইবেন না,  তবে এরূপ ক্ষেত্রে সংশ্লিষ্ট শ্রমিক তাহার অন্যান্য পাওনাদি যথা নিয়মে পাইবেন। </span><br>
				<span>খ । চাকরি ছাড়ার পর কোম্পানি প্রদত্ত মালামাল অর্থাৎ আইডি কার্ড, কাটার,  সিজার, টেপ ইত্যাদি দায়িত্বপ্রাপ্ত লোকের কাছে জমা দিয়ে কারখানা হইতে ছাড়পত্র/ক্লিয়ারেন্স নিতে হইবে।</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৫. ছুটি :</b></span> <br>
				<span><b>ক | সাপ্তাহিক ছুটিঃ </b>  সপ্তাহে (১) দিন (শুক্রবার )</span> <br>
				<span><b>খ | উৎসব জনিত ছুটি: </b> আইন অনুযায়ী বছরে ১১ দিন পূর্ণ মজুরিসহ যাহা পরবর্তী বছরে যোগ করা হয় না কিন্তু অত্র প্রতিষ্ঠান বছরের ১১ দিন পূর্ণ মজুরিসহ উৎসব ছুটি প্রদান করা হয় ।</span><br>
				<span><b>গ | নৈমিত্তিক ছুটি: </b> বছরে ১০ দশদিন পুরনো মজুরিসহ যাহা পরবর্তী বছরের সাথে যোগ হয় না |</span><br>
				<span><b>ঘ | চিকিৎসা / পীড়া/অসুস্থতার ছুটি: </b> বছরের ১৪ দিন পূর্ণ মজুরিসহ যাহা পরবর্তী বছরের সাথে যোগ হয় না। </span><br>
				<span><b>ঙ | বার্ষিক অর্জিত ছুটি: </b> এক (১) বৎসর এই প্রতিষ্ঠানে চাকুরী করিবার পর আপনি প্রতি ১৮ কর্মদিবসের জন্য একদিন সবেতনে বার্ষিক ছুটি ভোগ করতে পারবেন। কোনো শ্রমিক ১২ মাস মেয়াদে তার প্রাপ্য ছুটি অংশগত ভোগ না করেন তাহা হইলে উক্তরূপ প্রাপ্য ছুটি পরবর্তী ১২ মাস মেয়াদে তাহার প্রাপ্য তাহার ছুটির সহিত যুক্ত হইবে। বছরের শেষে অর্জিত ছুটি ভোগ না করলে বছরান্তে আপনার অর্জিত অর্ধেক ছুটির টাকা পূর্ণ বেতন প্রদান করা হইবে ।</span><br>
				<span><b>চ | প্রসুতি কল্যাণ( অন্যান্য সুবিধা): </b></span> ১৬ সপ্তাহ (১১২ দিন) মজুরীসহ ছুটি কেবল সেই সব মহিলার জন্য প্রযোজ্য যাহা অত্র প্রতিষ্ঠানে সন্তান প্রসবের অব্যবহিত পূর্বে কমপক্ষে (৬) ছয় মাস চাকরি পূর্ণ করিয়াছেন। তাহারা পূর্ণ গড় মজুরী হারে সম্পূর্ণ নগদে ১৬ সপ্তাহের ছুটি ভোগ করিতে পারিবেন। <span style="font-family: SutonnyMj;">`yB ev Z‡ZvwaK mšÍvb RxweZ _vK‡j myweav cÖ‡`q nB‡e bv, Z‡e wZwb †Kvb QzwU cvBevi AwaKvix nB‡j Zvnv cvB‡eb|</span> <br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৬. ছুটির নিয়মাবলী :</b></span> <br>
				<span>ক) কোন শ্রমিক-কর্মচারীকে ছুটি নিতে হইলে কোম্পানির নির্ধারিত ফরমে ছুটির জন্য আবেদন করতে হবে</span><br>
				<span>খ) ছুটির আবেদন পূরণ করে প্রথমে যার যার বিভাগের বিভাগীয় প্রধান দের কাছে জমা দিতে হইবে</span><br>
				<span>গ) বিভাগীয় প্রধান ছুটির সুপারিশ করে চূড়ান্ত অনুমোদনের জন্য প্রশাসন বিভাগে পাঠাবেন </span><br>
				<span>ঘ) প্রশাসন বিভাগ চূড়ান্ত অনুমোদনের যাবতীয় ব্যবস্থা গ্রহণ করবেন</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৭. সুবিধা :</b></span> <br>
				<span>ক) বিনা খরচে কারখানার ডাক্তার এবং নার্সের মাধ্যমে চিকিৎসা সুবিধা প্রদান করা হয় ।</span><br>
				<span>খ) শ্রমিক-কর্মচারীর জন্য গ্রুপ ইন্সুরেন্স এর ব্যবস্থা আছে ।</span><br>
				<!-- <span>গ) শিশু কক্ষে অভিÁ শিশু পরিচর্যাকারী দ্বারা ৬ বছরের কম বয়সী শিশু সন্তানগণের প্রতিপালনের সুবিধা প্রদান করা হয় ।</span><br> -->
				<span style="font-family: SutonnyMj;">M| wkï K‡ÿ AwfÁ wkï cwiPh©vKvix Øviv 6 eQ‡ii Kg eqmx wkï‡`i cÖwZcvj‡bi myweav cÖ`vb Kiv nq|</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৮. উৎসব ভাতা (বোনাস) :</b></span> <br>
				<span>যাহারা অত্র প্রতিষ্ঠান নিরবিচ্ছিন্নভাবে এক ১ বছর চাকরি পূর্ণ করিয়াছেন তাহারা দুইটি উৎসব ভাতা পাইবেন সাধারণত ইহা দুই ঈদে দেওয়া হয়। প্রতিটি উৎসব ভাতা মাসিক মূল মজুরির অধিক হইবেনা ।</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>৯. হাজিরা বোনাস :</b></span>
				<span> অপারেটর সমপর্যায়ের কর্মীরা সাতশত (৭০০) টাকা এবং হেলপারগণ তিনশত (৩০০) টাকা এবং অন্যান্য শ্রমিকগণ পাঁচশত (৫০০) টাকা করে হাজিরা বোনাস পাইবেন। প্রতিটি কর্মী মাসের প্রতিটি পূর্ণ কর্মদিবসে উপস্থিত থাকলে এবং প্রতিদিন সঠিক সময়ে কারখানায় উপস্থিত হইলে এই বোনাস পাবেন প্রত্যেক মাসে মাসিক বেতনের সাথে এই বোনাস প্রদান করা হয় এই বোনাস স্টাফ ব্যতীত কারখানায় কর্মরত নির্ধারিত শ্রমিকদের জন্য প্রযোজ্য ।</span>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>১০. বাংলাদেশ শ্রম আইন ২০০৬ সংশোধন ২০১৩ অনুসারে ধারা ২৩ (৪) মোতাবেক নিম্নোক্ত কাজগুলো অসদাচরণ বলিয়া গণ্য হইবে :</b></span> <br>
				<span>ক) উপরস্থের কোন আইন সংগত যুক্তিসংগত আদেশ ক্ষেত্রে এককভাবে অন্যের সঙ্গে সংঘবদ্ধতা ইচ্ছাকৃতভাবে অবাধ্যতা ।</span><br>
				<span>খ) মালিকের ব্যবসা বা সম্পত্তির প্রতারণা অসাধুতা ।</span><br>
				<span>গ) মালিকের অধীনে তাহার বা অন্য কোন শ্রমিকের চাকরি সংক্রান্ত ব্যাপারে ঘুষ গ্রহণ বা প্রদান ।</span><br>
				<span>ঘ) বিনা ছুটিতে অভ্যাসগত অনুপস্থিতি অথবা ছুটি না নিয়া এক সাথে দশ দিনের অধিক সময় অনুপস্থিত ।</span><br>
				<span>ঙ) অভ্যাসগত বিলম্বে উপস্থিতি ।</span><br>
				<span>চ) প্রতিষ্ঠানে প্রযোজ্য কোন আইন বিধি প্রবিধানের অভ্যাসগত লংঘন ।</span><br>
				<span>ছ) প্রতিষ্ঠানে উচ্ছৃঙ্খল বা দাঙ্গা আচরণ , অথবা শৃঙ্খলা হানিকর কোন কর্ম ।</span><br>
				<span>জ) কাজ কর্মে  অভ্যাসগত গাফলতি ।</span><br>
				<span>ঝ) প্রধান পরিদর্শক কর্তৃক অনুমোদিত চাকরি সংক্রান্ত শৃঙ্খলা বা আচরণ সহ যেকোন বিধির অভ্যাসগত লংঘন ।</span><br>
				<span>ঞ) মালিকের অফিশিয়াল রেকর্ডের রদবদল জালকরণ, অন্যায় পরিবর্তন উহার ক্ষতিকরন বা উহা হারাইয়া ফেলা ।</span><br>
			</div>
			<div style="line-height:20px; font-size:13px;">
				<span><b>১১. ঠিকানা প্রদান :</b> আপনি /আপনার ঠিকানা পরিবর্তন করলে সাথে সাথে কর্তৃপক্ষকে লিখিতভাবে জানাইতে হইবে ।</span> <br>
			</div>
			<div style="line-height:20px; font-size:13px;">
				<span><b>১২. আইডি কার্ড :</b></span>
				<span>প্রত্যেক শ্রমিক কর্মচারীকে আইডি কার্ড প্রদান করা হয় এবং উক্ত কার্ডে কারখানা প্রবেশ ও বাহিরের সময় প্রধান ফটকে নিরাপত্তা বিভাগের প্রদর্শন করিতে হইবে এবং কর্মকালীন সময় তা দৃশ্যমান স্থানে ঝুলন্ত অবস্থায় রাখিতে হইবে । কারখানায় প্রবেশ এবং বের হবার সময় কার্ডটি ইলেকট্রনিক্স হাজিরা মেশিনের পাঞ্চ করিবেন এবং উক্ত পাঞ্চ মেশিন থেকে আপনার মাসিক হাজিরা এবং অতিরিক্ত কাজের সময় নির্ধারণ করা হবে ।</span><br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span><b>১৩. সার্ভিস বই :</b> বাংলাদেশ শ্রম আইন ২০০৬ সংশোধন ২০১৩ অনুযায়ী প্রত্যেক শ্রমিকের জন্য কম্পানি খরচে সার্ভিস চালুর ব্যবস্থা আছে ।</span> <br>
			</div>
			<div style="line-height:20px; font-size:13px;">
				<span>১৪. আপনার চাকরি বাংলাদেশ শ্রম আইন ও বিধি দ্বারা পরিচালিত হইবে ।</span> <br>
			</div>

			<div style="line-height:20px; font-size:13px;">
				<span style="font-family: SutonnyMj;">১৫. KZ…©cÿ cÖ‡qvRb †ev‡a Avcbv‡K jycWU d¨vkb wjt Gi †h †Kvb wefv‡M e`wj Kwi‡Z cvwi‡eb|</span> <br>
			</div>
			<div style="line-height:20px; font-size:13px;">
				<span>১৬. কোম্পানির যাবতীয় নিয়মকানুন পরিবর্তনযোগ্য এবং আপনি পরিবর্তিত নিয়মকানুন মানিয়া চলিতে বাধ্য থাকবেন ।</span> <br>
			</div>
			<div style="line-height:20px; font-size:13px;">
				<span>আমি <?php echo $row->bangla_nam; ?> উপরোক্ত শর্তাবলী সুস্থ মস্তিষ্কে স্বেচ্ছায় সজ্ঞানে পরিয়া এবং বুঝিয়া উক্ত প্রতিষ্ঠানে কাজে যোগদান করিলাম এবং নিম্ন স্বাক্ষরকারী একটি কপি গ্রহণ করিলাম।</span> <br>
			</div>
			<br><br>
			<div style="width: 100%; display: inline-block;">
				<div style="width: 33%; float: left;">
					<span>তারিখ : <?php// echo date("d-M-Y");?></span>
				</div>
				<div style="width: 33%; float: left;">
					<span style="border-top-style: dotted">শ্রমিকের স্বাক্ষর</span>
				</div>
				<div style="width: 33%; float: left;">
					<span style="border-top-style: dotted">নিয়োগকারীর স্বাক্ষর</span>
				</div>
			</div>
		</div>
	<?php } ?>
</body>
</html>