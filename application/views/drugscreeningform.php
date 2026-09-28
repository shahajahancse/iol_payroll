<!DOCTYPE html>
<html>
<head>
	<title>Join Letter</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/appointment_letter.css">
	<style type="text/css">
		table td{
			margin:5px;
		}
		.header_top{
			width: 300px;
			margin:0 auto 15px;
			border-bottom:1px solid #000;
			text-align: center;
			font-size: 20px
		}
        table.check_table{
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table.check_table tr,table.check_table td,table.check_table th{
            border:1px solid #000;
        }
        p{margin:0px; padding:1px; }
	</style> 
</head>
		   
<body style="font-family:SolaimanLipi;">
	<?php  foreach($value as $row){ 
		?>
	<div id="wrapper" style="margin-bottom:180px; width:800px; min-height:700px;">
		<div class="header">
    		<div class="header-top">
    		<table style="width:800px">
    			<tr>
		       <?php //$company_logo = $this->common_model->company_information("company_logo"); ?>
		       <td width="105" style="vertical-align: top;"><img width="55" height="55" src="<?php  echo base_url();?>images/<?php echo $company_logo = $this->common_model->company_information("company_logo"); ?>" />
		        </td>
		        <td style="font-size:15px;text-align:center; margin: 0px; padding: 0px; ">
		        		<!-- <span style="font-size: 25px;text-transform: uppercase;">Creative Group</span>
		        		<br> -->
                        <span style="font-size:25px; font-weight:bold;">
                            <?php echo $company_logo = $this->common_model->company_information("company_name_english"); ?></span><br>
		        		<span style="text-align:center"><?php echo $company_logo = $this->common_model->company_information("company_add_english"); ?></span>
		        	<br>
		        </td>

			  </tr>
			</table>

    		</div>
            <div align="center" style="width:800px; border-bottom:3px solid #000;margin:10px 0px;"></div>
        </div>
        <p  style="text-align: center;"><span style="font-size: 17px;text-transform: uppercase;  border: 1px solid black; border-radius: 10px 10px;font-weight: bolder;padding:3px;">Drug Screning Form</span></p>

        <div class="particulars">
            <?php
                $this->load->helper('date');
                $today = date('Y-m-d');
                $birthdate = date('Y-m-d',strtotime($row->emp_dob));
                $diff = $today - $birthdate;
             ?>
        	<span style="text-transform: uppercase;font-size: 18px;margin-bottom:12px;"><strong>Particulars:</strong></span>
        	<p>1. Name: <strong><?php echo $row->emp_full_name;?></strong></p>
        	<p>2. Father/Husband Name: <strong><?php echo $row->emp_fname;?></strong></p>
        	<p>3. Present Address: <strong><?php echo $row->emp_pre_add;?></strong></p>
        	<p>4. Age: <strong><?php echo $diff; ?></strong> <span style="margin-left: 40px;">5. Height:<strong> <?php echo $row->posi_name;?></strong></span> <span style="margin-left: 40px;">6. Weight: <strong><?php echo $row->ope_name;?></strong></span></p>
        </div>

        <div class="consent">
        	<span style="text-transform: uppercase;font-size: 16px;margin-bottom:12px;"><strong>Conset of Worker:</strong></span>
        	<p>I solemnly declare that all the information mentioned on this page are true & correct the best of my knowledge. Any information found to be false then my authority could legal action against me </p>
        	<p>(আমি এই মর্মে ঘোষণা করিতেছি যে, নিচে প্রদত্ত সকল তথ্য আমার জানামতে সত্য ও সঠিক। যদি কোন তথ্য মিথ্যা পাওয়া যায় তবে কর্তৃপক্ষ আমার বিরুদ্ধে আইনানুগ ব্যবস্থা গ্রহন করিতে পারিবে না।)</p>
            <br>
        </div>

        <div class="signature">
        	<span style="text-transform: uppercase;font-size: 16px;margin-bottom:12px;"><strong>Signature:</strong></span>
        	<h4>Medical Examination(Done in good day light & Privacy)</h4>
        	<table class="check_table">
        		<tr>
        			<td>1. Inability to sleep</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>2. Increased sensitivity to noise</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>3. Nervous physical activity, like Scratching</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>4. Irritability,dizziness or confusion.</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>5. Extreme anorexia</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>6. Tremors or even convulsions</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>7. Increase heart rate</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>8. High blood Pleasure</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>9. Presence of inhalingparaphernalia, Suchas razorblades,mirrors and straws</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        		<tr>
        			<td>10. Physical effect, such as liver kidney and lung damage</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">Yes</td>
        			<td><input type="checkbox" style="width: 11px;height: 11px;border:1px solid #000">No</td>
        		</tr>
        	</table>
        </div>

        <div class="comments">
            <br>
        	<span style="text-transform: uppercase;font-size: 16px;margin-bottom:12px;"><strong>Doctor's comments:</strong></span>
        	<p style="margin-bottom: 8px">Based on above finding this person is free from drug:</p>
        	<strong>she/he is fit for work.</strong>
        </div>

</div>
<?php } ?>
</body>
</html>