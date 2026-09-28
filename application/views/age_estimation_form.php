<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body >

<?php 
foreach($value as $row){
?>
	
<div align="center" style="height:auto; width:678px; padding:25px; border:1px solid; margin-bottom:25px; ">
			<table width="683" cellpadding="3">
        <tr>
            <td width="10">&nbsp;</td>
            <?php $company_logo = $this->common_model->company_information("company_logo"); ?>
            <td width="75"><img width="70" src="<?php echo base_url(); ?>images/<?php echo $company_logo; ?>" /></td>
            <td width="273" style="font-size:20px; text-align:center;"><b><?php echo $company_name_english = $this->common_model->company_information("company_name_english");?></b>
              <br>
              <span style="margin: 22%;font-size:14px;"> <?php echo $company_add_english = $this->common_model->company_information("company_add_english");?></span>
            </td>
            <!-- <td width="" style="font-size:10px; text-align:right"></td> -->
            <td width="100" height="120" style=" text-align: center"><img border="1" src="<?php echo base_url();?>uploads/photo/<?php echo $row->img_source;?>" height="120" width="105" /></td>
        </tr>
      </table>
            
            <!--
<span style="margin: 22%;font-size:14px;"> <?php echo $company_add_english = $this->common_model->company_information("company_add_english");?></span>
-->
  			<table width="694" cellpadding="3">
              <tr><td colspan="7" style="font-size:19px; font-weight:bold; text-align:center;"><span style="border: solid 1px;background: silver;">AGE ESTIMATION AND MEDICAL FITNESS FORM</span></td></tr>
              <tr><td colspan="2" style="font-size:15px; font-weight:bold;">PARTICULARS</td></tr>
              
              <tr>
              <td width="24">01.</td>
              <td width="164"  style="font-weight:bold;width:150px">Name </td><td width="13">:</td>
              <td colspan="4"><?php echo $row->emp_full_name;?> </td>
              </tr>
              
              <tr>
              <td>02.</td>
              <td style="font-weight:bold;width:100px">Father's Name </td><td>:</td>
              <td colspan="4"><?php echo $row->emp_fname;?> </td>
              </tr>
              
              <tr>
              <td>03.</td>
              <td style="font-weight:bold;width:100px">Mother's Name</td><td>:</td>
              <td colspan="4"><?php echo $row->emp_mname;?> </td>
              </tr>
              
              <tr>
              <td>04.</td>
              <td style="font-weight:bold;width:100px">Address</td><td>:</td>
              <td colspan="4"><?php echo $row->emp_pre_add;?></td>
              </tr>
              
              <tr>
              <td>05.</td>
              <td style="font-weight:bold;width:100px">Date of Birth</td><td>:</td>
              <td height="15px" colspan="4"><?php $dob = $row->emp_dob;echo date("d-M-Y", strtotime($dob));?></td>
              </tr>
              
              <tr height="15px">
              <td>06.</td>
              <td style="font-weight:bold; width:100px">Identification Mark</td><td>:</td>
              <td colspan="4"> </td>
              </tr>
              
           
              
              <tr>
              <td  colspan="5" style="font-weight:bold; font-size:15px; text-decoration:underline">CONSENT OF FACTORY WORKER:</td>
              </tr>
              
              <tr>
              <td  colspan="7" style="font-size:14px;">I am hereby giving consent with full knowledge for medical examination and health check-up to the concerend physician.</td>
              </tr>
              
              <tr>
              <td  colspan="5" style="font-weight:bold; font-size:15px; text-decoration:">Signature/Thumb Impression:&nbsp;..........................................&nbsp;Date..................</td>
              </tr>
              
              <tr>
              <td  colspan="5" style=" font-size:15px; "><b>Madical Examination</b> (Done in board daylight)</td><br />
              </tr>
              
               <tr>
              <td  colspan="5" style="font-size:15px;"><b>1.	Height</b>&nbsp;<?= $row->posi_name;?>&nbsp;<b>&nbsp;2.Weight</b>&nbsp;<?= $row->ope_name;?></td>
              </tr>
              
              
               <tr>
              <td  colspan="5" style="font-weight:bold; font-size:15px; text-decoration:">3. Eruption of molar teeth :
             <br /> <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</span>
             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0</span>	<br />	
             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2nd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3rd</span>
             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2nd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3rd</span>
             <br /> <br /><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0</span>
             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;0</span>	<br />	
             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2nd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3rd</span>
             <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1st &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2nd &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3rd</span>			
              </td>
              </tr>
               <tr>
              <td  colspan="5" style="font-size:15px;"><b>4.Body Build  : </b>  &nbsp;<span style="border: solid 1px">Below Avg</span> &nbsp;     <span style="border: solid 1px"> Avg</span>     &nbsp;         <span style="border: solid 1px">Above Avg</span>                   </td>
              </tr>
              <tr>
              	<?php
              		$this->load->helper('date');
				 	$today = date('Y-m-d');
					$birthdate = date('Y-m-d',strtotime($row->emp_dob));
				
					$diff = $today - $birthdate;             	
              	?>
              <td  colspan="5" style="font-size:15px;"><b>5.Estimated Age : </b><?php echo $diff ;?>&nbsp;years </td>
              </tr>
              <tr>
              <td  colspan="5" style="font-size:15px;"><b>6.Employee is suffering form any contagious disease : </b><br /><br />
              	&nbsp;&nbsp;<span style="border: solid 1px">Yes</span>
              	&nbsp;&nbsp;<span style="border: solid 1px">No</span>
              </td>
              </tr>
            <tr>
              <td  colspan="5" style="font-size:15px;"><b>7.Employee is suffering form any chronic illness : </b><br /><br />
              	&nbsp;&nbsp;<span style="border: solid 1px">Yes</span>
              	&nbsp;&nbsp;<span style="border: solid 1px">No</span>
              </td>
              </tr>
              <tr>
              <td  colspan="5" style="font-size:15px;"><b>Doctors Coments : </b>Based on above findings the estimated age of the employee is <?=$diff;?> years and he/she is fit/unfit for the job/work .  <br /><br />
              </td>
              </tr>
              <tr>
              <td>&nbsp; </td>
              <td height="30"><span style="border-top:1px solid; font-family:SolaimanLipi; font-size:14px;"></span></td><td colspan="3">&nbsp; </td>
              <td colspan="2" style=" text-align:left;"><span style="border-top:1px solid; font-family:SolaimanLipi; font-size:14px;">Doctor</span></td>
              </tr>
            </table>
            
  
            
</div>
			
	
	
	<?php }
?>
</body>
</html>