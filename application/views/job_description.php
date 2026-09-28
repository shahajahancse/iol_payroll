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
  		  margin-bottom:225px;
  		  font-size: 18px;
  		  
		 }
#header {
          width:700px;
		  height:42px;
		  background-color: #CCCCCC;

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
	<?php  foreach($value as $row){ ?>
	<div id="wrapper">
		<div align="center" id="header">
			 <b style="font-size: 18px">কিমবার্লী  ডিজাইন </b>
			 <br>
			 বাসাইল, হাজির বাজার, ভালুকা, ময়মনসিংহ 
		</div>
		<div  id="nav" align="center" >
			<div style="width: 200px;" id="nav_inner">
				কাজের বর্ণনা  
			</div>
		</div>
		<div id="nav_bottom" style="line-height:20px; font-size:13px;">
        
			<br>
			<b>নাম :</b> &nbsp;&nbsp;<?= $row->bangla_nam;?><br />
			<b>পদবী :</b>&nbsp;&nbsp;<?= $row->desig_bangla;?> <br />
			<b>কার্ড নং : </b><span style="font-family: SutonnyMJ"><?= $row->proxi_id;?></span><br />
			<b> সেকশন :</b> 
			<?php echo $row->sec_bangla;?>
			 <br/><br/>
</div>

<br />
<div style="line-height:19px; font-size:16px;"><br />
<u style="font-size:18px;"><b>বিশেষ দায়বদ্ধতা:</b></u><br /><br />


<?= $row->description;?>
	
<br /><br />


<table>

<tr style="width: 100px">
<td width="10"></td>
<br /><br />
<td width="300">কারখানার পক্ষে :</td><td width="200">&nbsp;</td><td width="200"> গ্রহনকারীর স্বাক্ষর: </td></tr>
</table><br /><br />
বিভাগীয় প্রধান (প্রশাষন ও মানব সম্পদ)
</div>
</div>
<?php } ?>
</body>
</html>