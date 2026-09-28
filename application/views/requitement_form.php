<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body >

<?php 
//print_r($data);
foreach($value as $row)
			{

?>
	
<div align="center" style="height:auto; float:left; width:678px; padding:25px; border:1px solid; margin-bottom:25px; ">
			<table width="683" cellpadding="3">
            <tr>
            <td width="29">&nbsp;</td>
           
            <td width="75"></td>
            <td width="273" style="font-size:20px; text-align:right"><b>লুপ ডট ফ্যাশন</b></td>
            <td width="" style="font-size:10px; text-align:right"> মোট নম্বর : ৫০
                                                                                 পাশ নম্বর : ২৫(৫০%)</td>
            <td ></td>
            </tr>
           
            </table>
            
<span style="margin: 22%;font-size:14px;"> <?php echo $company_add_english = $this->common_model->company_information("company_add_bangla");?></span>

  			<table width="694" cellpadding="3">
              <tr><td colspan="7" style="font-size:19px; font-weight:bold; text-align:center;"><span style="border: solid 1px;background: silver;">নিয়োগ পরীক্ষা  </span></td></tr>             
              <tr>
              <td width="164"  style="font-weight:bold;width:150px"> নাম   </td><td width="20">: </td>
              <td colspan="4"><?= $row->bangla_nam;?> </td>
              </tr>
              
              <tr>
             
              <td style="font-weight:bold;width:100px"> জন্ম তারিখ</td><td>:</td>
              <td style="font-family: SutonnyMJ" colspan="4"><?= $row->emp_dob;?> </td>
              </tr>
              
              <tr>
             
              <td style="font-weight:bold;width:100px">পিতার নাম </td><td>:</td>
              <td colspan="4"><?= $row->emp_fname;?> </td>
              </tr>
              
              <tr>
              
              <td style="font-weight:bold;width:100px">মাতার নাম</td><td>:</td>
              <td colspan="4"><?= $row->emp_mname;?></td>
              </tr>
              
              <tr height="15px">
             
              <td style="font-weight:bold; width:100px">স্থায়ী ঠিকানা</td><td>:</td>
              <td colspan="4"><?= $row->emp_par_add_ban;?> </td>
              </tr>
              
              <tr>
            
              <td style="font-weight:bold;width:100px">প্রাথীর পদের নাম</td><td>:</td>
              <td height="15px" colspan="4"> <?= $row->desig_bangla;?></td>
              </tr>
              
         
              <tr>
              <td style="font-weight:bold;width:100px">বিভাগ/সেকশন</td><td>:</td>
              <td height="15px" colspan="4"> <?= $row->sec_bangla;?></td>
              </tr>
           
                          
               <tr>
              <td  colspan="5" style="font-size:15px;">১ . A-Z পর্যন্ত লিখ : .......................................................................................................................................... </td>
              </tr>
              <tr>
              <td  colspan="5" style="font-size:15px;">২. ১-১০০ পর্যন্ত লিখ : ..........................................................................................................................................</td>
              </tr>
               <tr>
              <td  colspan="5" style="font-size:15px;">অভিজ্ঞতা : <span style="height: 10px;width: 10px; border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;আছে &nbsp;<span style="height: 10px;width: 10px; border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;না</td>
              </tr>
              <tr>
              <td  colspan="5" style="font-size:15px;">ক) আগে যে প্রতিষ্ঠানে চাকুরী করেছেন সেই প্রতিষ্ঠানের নাম :  .......................................................... </td>
              </tr>
              <tr>
              <td  colspan="5" style="font-size:15px;">কার্যকাল : ............................................................................................................ </td>
              </tr>
              <tr>
              <td  colspan="5" style="font-size:15px;">চাকুরী ছাড়ার কারন : ..................................................................................................... <br /><br />
              	
              </td>
              </tr>
            <tr>
              <td  colspan="5" style="font-size:15px;"> পারদর্শিতা  : ক)প্রস্তুত-প্রক্রিয়া
	
..................................... <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;খ)পরিমাণ/ঘণ্টা.........................
              	<br />
              	
              </td>
              </tr>
          
          		<tr>
              <td  colspan="5" style="font-size:15px;">এ প্রতিষ্ঠানে কেন চাকুরী করতে চান ? : ..................................................................................................... 
              	
              </td>
              </tr>
                
              <tr style="border: 1px solid;">
              	
              <td  colspan="5" style="font-size:15px;"><span style="height: 10px;width: 10px; border: 1px solid;">&nbsp;&nbsp;&nbsp;&nbsp;</span> </td>
              </tr>
              
              <tr>
              <td  colspan="5" style="font-size:15px;">কাজের বাস্তব অভিজ্ঞতা : ..........................................................................
              <tr>
              <td  colspan="5" style="font-size:15px;">নির্ধারিত বেতন : ...........................................................................................<br /><br />
              	
              </td>
              </tr>
            
              
              
              
            </table>
            
  
            
</div>
			
	
	
	<?php }
?>
</body>
</html>