<!DOCTYPE html>
<html>
<head>
	<title>Appointment Letter</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style>
	#wrapper {
          margin:0 auto;		  
		  width:700px;
		  overflow:hidden;
  		  margin-bottom:240px;
  		 font-family:SutonnyMJ;
  		  
		 }
#header {
          width:700px;
		  height:auto;
		  background-color: #CCCCCC;
		  padding:10px;

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
         width:800px;
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
.decoration{ font-family:SutonnyMJ, SolaimanLipi; text-decoration:underline; font-weight:bold; padding:0px 10px 0px 10px;}       
      

</style>
</head>
<?php
$count = count($values["emp_id"]);
//for($i=0; $i<$count; $i++)
//{	
$leave = "";
if($leave_type == "cl")
{
	$leave = "নৈমিত্তিক";
}
if($leave_type == "sl")
{
	$leave = "অসুস্থতা";
}
if($leave_type == "el")
{
	$leave = "অর্জিত";
}
?>	   
<body style="font-family: Arial, Helvetica, sans-serif;">
	<div id="wrapper">
		<div id="header">
			 <?php $this->load->view('head_bangla'); ?>  
			 <br>
		</div>
		<div id="nav" align="center" >
			
			</div>
            <br> 
            
<div style="width:200px; height:30px; border:3px solid blue; border-radius: 5px; text-align:center; margin:0 auto; font-family:solaimanlipi; font-size:18px; font-weight:bold;">ছুটির আবেদন পত্র</div>
<div style="width:700px;">            

  <div style="width:700px;height:30px; float:right; position:relative;font-family:SolaimanLipi;">তারিখ :  ......................</div>
  </div>
  
<table style="font-family:SolaimanLipi;">
	<tr>
		<td>বরাবর,<br/>
		ব্যবস্থাপনা পরিচালক / মহাব্যবস্থাপক,
		</td>
	</tr>
	<tr height="30px"></tr>
		
	<tr>
		<td colspan="2">  
		 বিনীত নিবেদন এই যে, অনুগ্রহ পূর্বক ..............................কারনে <span class="decoration"> <?php echo $firstdate; ?></span> তারিখ হইতে <span class="decoration"><?php echo $seconddate; ?></span> তারিখ পর্যন্ত মোট <span class="decoration"><?php echo $values["no_of_days"]; ?></span> দিন আমাকে <?php echo $leave; ?>  ছুটি মঞ্জুরের জন্য 		আবেদন জানাচ্ছি।
		 </td>
	</tr>
	</table>
    
    <div style="float:right;">
    
	<table style="width:auto;">
	<tr height="30px"></tr>
	<tr style="font-family:SolaimanLipi;">
		<td colspan="6">
			আবেদন কারীর স্বাক্ষর ....................
		</td>
	</tr>
	
	<tr style="font-family:SolaimanLipi;">
		<td>নাম</td><td>:</td><td><?php echo $values["emp_full_name"]; ?></td>
		<td>পদবি</td><td>:</td><td><?php echo $values["desig_name"]; ?></td>
	</tr>
	
	<tr style="font-family:SolaimanLipi;">
		<td>কার্ড নং</td><td>:</td><td style="font-weight: bold;"><?php echo $values["emp_id"]; ?></td>
		<td>বিভাগ</td>
		<td>:</td><td><?php echo $values["sec_name"]; ?></td>
	</tr>
    <tr style="font-family:SolaimanLipi;">
		<td>লাইন</td><td>:</td><td style="font-weight: bold;"><?php echo $values["line_name"]; ?></td>
	</tr>
	
	</table>
    </div>
    <br/><br/>
    
    
    <div style=" width:auto; float:left; font-family:SolaimanLipi;">
    <table style="width:auto;">
    
	<tr height="20px"></tr>
	<tr>
		<td colspan="6">
			অফিস রেকর্ডঃ<br/>
			আবেদন কারীর কাজে যোগদানের তারিখঃ
			<span class="decoration"><?php echo date('d-m-Y',strtotime($values["emp_join_date"])); ?></span>
		</td>
	</tr>
	<tr height="10px"></tr>
</table>
</div>
<div style="float:left; font-family:SolaimanLipi;">
<table>
	<tr >
		<td>১। নৈমিত্তিক ছুটি মোট প্রাপ্য</td>
		<td class="decoration"><?php echo $values["casual_leave_balance"]; ?></td>
		<td>দিন,&nbsp;&nbsp;&nbsp;&nbsp;ভোগকৃত ছুটি</td>
		<td class="decoration"><?php echo $values["entitle_casual_leave"]; ?></td>
		<td> দিন, &nbsp;&nbsp;&nbsp;&nbsp;অবশিষ্ট </td>
		<td class="decoration"><?php echo $values["available_causual_leave"]; ?></td>
        <td>দিন</td>
		<br/>
	</tr>
	<tr>
		<td>২। অসুস্থতা</td>
		<td class="decoration"><?php echo $values["sick_leave_balance"]; ?></td>
		<td>দিন,&nbsp;&nbsp;&nbsp;&nbsp;ভোগকৃত ছুটি </td>
		<td class="decoration"><?php echo $values["entitle_sick_leave"]; ?></td>
		<td>দিন, &nbsp;&nbsp;&nbsp;&nbsp;অবশিষ্ট</td>
		<td class="decoration"><?php echo $values["available_sick_leave"]; ?></td>
        <td>দিন</td><br/>
	</tr>
	<tr>
		<td>৩। অর্জিত </td>
		<td class="decoration"><?php echo '...'; ?></td>
		<td> দিন,&nbsp;&nbsp;&nbsp;&nbsp; ভোগকৃত ছুটি</td>
		<td class="decoration"><?php echo $values["entitle_earn_leave"]; ?></td>
		<td>দিন, &nbsp;&nbsp;&nbsp;&nbsp;অবশিষ্ট</td>
        <td class="decoration"><?php echo '...'; ?></td>
		<td>দিন</td>
	</tr>
	
	<tr height="60px"></tr>
</table>
</div>
<br/><br/>
<div style="float:left; font-family:SolaimanLipi;">

		<div style="width:350px; float:left;">
			অফিস সহকারী কর্তৃক যাচাইকৃত ও স্বাক্ষরীত<br/>
			তারিখঃ ...........................................................
		</div>
      
        <div style="width:350px; float:right;">
			প্রশাসনিক কর্মকর্তার স্বাক্ষর<br/>
			তারিখঃ ...........................................................
		</div>
	
	
    </div>
    
    
    <br/><br/><br/><br/>
    
    <div style="float:left; font-family:SolaimanLipi; position:relative; top:30px;">
		
			আবেদনকারীকে <span class="decoration"><?php echo $firstdate; ?></span> তারিখ হতে <span class="decoration"><?php echo $seconddate; ?></span> পর্যন্ত মোট <span class="decoration"><?php echo $values["no_of_days"]; ?></span>  দিন  <?php echo $leave; ?> ছুটি মঞ্জুর করা যেতে পারে। <br/><br/> উক্ত সুপারিশ মোতাবেক ছুটি মঞ্জুর করা হইল।
</div>

 <div style="float:left; font-family:SolaimanLipi; padding-top:80px; margin-bottom:50px;">
<table>
	<tr height="100px"></tr>
	<tr class="decoration">
		<td width="250px">বিভাগীয় প্রধান</td>
		<td width="280px">প্রশাসনিক ব্যবস্থাপক  </td>
		<td width="250px">মহাব্যাস্থাপক  </td>
		<td width="250px">পরিচালক</td>
	</tr>
</table>
</div>
</div>

</body>
<?php 
//} 
?>
</html>