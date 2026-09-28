<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title> OT <?php if ($status == 2) { echo "Female"; } ?>  Acknowledgement sheet </title>
    <style>
		@media print {
			table {
				widht: 100% !important;
			}
			@page{
				margin:5px 30px;
			}
		}
    </style>
</head>

<body style="margin: 0px;">
	<!-- < ?php echo $status; exit;?> -->
<!-- heading  -->
    <?php if($status == 1){?>
				<?php if($unit_id == 1){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 01/08/2024</div>
					<div>Revision: 00</div>
					<div> Doc. Code: AJFL/HRAC(HR)/03/049</div>
				</div>
				<?php }elseif($unit_id == 4){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 15/01/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: HGL/HRD(HR)/03/020</div>
 				</div>
				 <?php }elseif($unit_id == 2){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 01/02/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: LSA/HRD(COM)/03/175</div>
 				</div>
				<?php }?>
	<?php $this->load->view("head_bangla"); }?>
	<p style="text-align:center;font-size:15px; font-weight:bold;font-family:sutonnyMJ"> 
		<?php 
			if ($status == 2) { ?> 
				<?php if($unit_id == 1){?>
				<br>	
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 01/08/2024</div>
					<div>Revision: 00</div>
					<div> Doc. Code: AJFL/HRAC(HR)/03/049</div>
				</div>
				<?php }elseif($unit_id == 2){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 01/02/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: LSA/HRD(COM)/03/175</div>
 				</div>
				 <?php }elseif($unit_id == 4){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 15/01/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: HGL/HRD(HR)/03/020</div>
 				</div>
				<?php }?>
				<p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px">dig-35</p>
				<p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px">[aviv 109 wewa 103(1) `«óe¨]</p>
				<p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px">gwnjv‡`i ivwÎKvjxb KvR Kivi m¤§wZcÎ</p>
  			    <p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px"><?php echo date("01/m/Y",strtotime($date))?> Bs nB‡Z <?php echo date("t/m/Y",strtotime($date))?> Bs</p><br>
				<p style="margin:0 auto;text-align:left;width:98%"><span  style="font-family:sutonnyMJ ;line-height:1px;font-size:20px">KviLvbv / cÖwZôv‡bi bvg :</span> <span style="font-size:20px" class="unicode-to-bijoy"> <b><?php echo $unit_name_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_name_bangla;?></b></span></p>
				<p style="margin:0 auto;text-align:left;width:98%"><span style="font-family:sutonnyMJ ;line-height:1px;font-size:20px">KviLvbv / cÖwZôv‡bi  wVKvbv :</span> <span style="font-size:20px" class="unicode-to-bijoy"> <b><?php echo $unit_add_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_add_bangla;?></b></span></p>
				<p style="font-family:sutonnyMJ ;text-align:justify;width:98%;margin:0 auto;font-size:20px">
					Avwg GZØviv †Nvlbv Kwi‡ZwQ †h, e¨e¯’vcbv KZ…©c¶ KZ…©K Kv‡Ri mgq h_vh_ wbivcËv wbwðZ Kwievi k‡Z© D³ cÖwZôv‡bi ‰bk cvjvq 
					ivZ 10 NwUKv nB‡Z †fvi 06 NwUKv ch©šÍ KvR Kwi‡Z Avwg m¤§Z iwnqvwQ|
					D³ m¤§wZcÎ Avgvi KZ©„K evwZj bv Kiv nB‡j Dnv 1 gvm ch©šÍ Kvh©Ki _vwK‡e|
				</p>
			<?php }else{?>
				<span style='font-size:18px;'>kÖwgK‡`i AwZwi³ Kg©N›Uvi m¤§wZ cÎ</span>
				<span style='font-size:18px;position:absolute;margin-left:30px'> ZvwiL: <?php echo date("d/m/Y",strtotime($date))?></span>
			<?php }
		?>
	</p>
    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <table border="1" cellpadding="0" cellspacing="0" style="font-size:15px;margin-bottom:0px;width:100%;">
            <?php $this->load->model('Grid_model'); $i=1; ?>
			<tr style="font-family:sutonnyMJ;font-size:15px">
				<th style="padding:2px 2px;width:fit-content;">µwgK bs</th>
				<th style="padding:2px 2px;">AvBwW bs</th>
				<th style="padding:2px 2px;">bvg</th>
				<th style="padding:2px 2px;">c`ex</th>
				<th style="padding:2px 2px;"> ‡mKkb / jvBb</th>
				<?php if($status==2){?>
				<th style="padding:2px 2px; width:100px">m¤§wZ evwZ‡ji ZvwiL</th>
				<th style="padding:2px 2px; width:100px">kÖwg‡Ki ¯^vÿi </th>
				<?php }else{
				?>
				<th style="padding:2px 2px; width:100px">mvÿi</th>
				<?php }?>
			</tr>
<!-- heading -->

			<?php

			if($status ==2){
				$per_page=19;
			}else{
				$per_page=26;
			}
				
			
			
			foreach ($values as $key => $row) {?> 
				<tr>
					<td class='unicode-to-bijoy' style="font-size: 18px;width:fit-content;padding:2px;text-align:center;font-family:sutonnyMJ;"><?php echo $key +1; ?></td>
					<td class='unicode-to-bijoy' style="font-size: 22;width:fit-content;padding:2px;text-align:center;font-family:sutonnyMJ;"><?php echo $row['emp_id']?></td>
					<td class='unicode-to-bijoy' style="font-size: 18px;width:fit-content;padding:2px;text-align:center;white-space:nowrap"><?php echo $row['name_bn']?></td>
					<td class='unicode-to-bijoy' style="font-size: 18px;width:fit-content;padding:2px;text-align:center"><?php echo $row['desig_bangla']?></td>
					<td class='unicode-to-bijoy' style="font-size: 18px;width:fit-content;padding:2px;text-align:center"><?php echo $row['line_name_bn']?></td>

					<?php if($status==2){?>
					<td style="font-size: 18px;width:fit-content;padding:2px;text-align:center"></td>
					<td style="font-size: 18px;width:fit-content;padding:2px;text-align:center"></td>
					<?php }else{?>
						<td style="font-size: 18px;width:fit-content;padding:2px;text-align:center"></td>
					<?php }?>
				</tr>
			<?php
			if ($key!=0 && ($key % $per_page) == 0) {?>
			</table>
			</div>
			<br>
			<br>
			<div style="display:flex; justify-content:space-between;width:100%;margin:0 auto" class='border border-black' >
				<div style="font-family:SutonnyMJ;font-size:16px;border-top:1px solid black;width:fit-content">cÖ¯‘ZKvixi ¯^vÿi</div>
				<div> 
					<p style="font-family:SutonnyMJ;font-size:18px;margin-top: 0px !important;border-top:1px solid black;width:fit-content;">Aby‡gv`bKvixi ¯^vÿi</p>
					<span style="font-family:SutonnyMJ;font-size:18px;text-align: center;">(gvbem¤ú` wefvM)</span>
					<br>
					<?php if ($status == 2) {?>
						<span class="unicode-to-bijoy"></span>
					<?php }?>
				</div>
			</div>
			<br><br>
			<div style="page-break-after:always"></div>
			<!-- heading  -->
    <?php if($status != 2){?>
				<?php if($unit_id == 1){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 01/08/2024</div>
					<div>Revision: 00</div>
					<div> Doc. Code: AJFL/HRAC(HR)/03/049</div>
				</div>
				<?php }elseif($unit_id == 2){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 15/01/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: LSA/HRD(COM)/03/175</div>
 				</div>
				 <?php }elseif($unit_id == 4){?>
				<br>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 15/01/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: HGL/HRD(HR)/03/020</div>
 				</div>
				<?php }?>
	<?php $this->load->view("head_bangla"); }?>
	<p style="text-align:center;font-size:15px; font-weight:bold;font-family:sutonnyMJ"> 
		<?php 
			if ($status == 2) { ?> 
				<?php if($unit_id == 1){?>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 01/08/2024</div>
					<div>Revision: 00</div>
					<div> Doc. Code: AJFL/HRAC(HR)/03/049</div>
				</div>
				<?php }elseif($unit_id == 4){?>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 15/01/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: HGL/HRD(HR)/03/020</div>
 				</div>
				 <?php }elseif($unit_id == 2){?>
				<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
					<div>Effective Date: 15/01/2022</div>
					<div>Revision: 00</div>
					<div>Doc. Code: LSA/HRD(COM)/03/175</div>
 				</div>
				<?php }?>
				<br>
				<p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px">dig-35</p>
				<p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px">[aviv 109 wewa 103(1) `«óe¨]</p>
				<p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px">gwnjv‡`i ivwÎKvjxb KvR Kivi m¤§wZcÎ</p>
  			    <p style="margin:0 auto;text-align:center;width:80%;font-family:sutonnyMJ ;font-size:20px"><?php echo date("01/m/Y",strtotime($date))?> Bs nB‡Z <?php echo date("t/m/Y",strtotime($date))?> Bs</p><br>
				<p style="margin:0 auto;text-align:left;width:98%"><span  style="font-family:sutonnyMJ ;line-height:1px;font-size:20px">KviLvbv / c«wZôvbbi bvg :</span> <span style="font-size:20px" class="unicode-to-bijoy"> <b><?php echo $unit_name_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_name_bangla;?></b></span></p>
				<p style="margin:0 auto;text-align:left;width:98%"><span style="font-family:sutonnyMJ ;line-height:1px;font-size:20px">KviLvbv / c«wZôvbbi  wVKvbv :</span> <span style="font-size:20px" class="unicode-to-bijoy"> <b><?php echo $unit_add_bangla = $this->db->where("unit_id",$unit_id)->get('company_infos')->row()->company_name_bangla;?></b></span></p>
				<p style="font-family:sutonnyMJ ;text-align:justify;width:98%;margin:0 auto">
					Avwg GZØviv †Nvlbv Kwi‡ZwQ †h, e¨e¯’vcbv KZ…©c¶ KZ…©K Kv‡Ri mgq h_vh_ wbivcËv wbwðZ Kivi k‡Z© D³ cÖwZôv‡bi ‰bk cvjvq 
					ivZ 10 NwUKv nB‡Z †fvi 06 NwUKv ch©šÍ KvR Kwi‡Z Avwg m¤§Z iwnqvwQ|
					D³ m¤§wZcÎ Avgvi KZ©„K evwZj bv Kiv nB‡j Dnv 1 gvm ch©šÍ Kvh©Ki _vwK‡e|
				</p>
			<?php }else{?>
				<span style='font-size:18px;'>kÖwgK‡`i AwZwi³ Kg©N›Uvi m¤§wZ cÎ</span>
				<span style='font-size:18px;position:absolute;margin-left:30px'> ZvwiL: <?php echo date("d/m/Y",strtotime($date))?></span>
			<?php }
		?>
	</p>
    <div align="center" style=" margin:0 auto;  overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <table border="1" cellpadding="0" cellspacing="0" style="font-size:12px;margin-bottom:20px;width:100%;">
            <?php $this->load->model('Grid_model'); $i=1; ?>
			<tr style="font-family:sutonnyMJ;font-size:15px">
				<th style="padding:2px 2px;width:fit-content;">µwgK bs</th>
				<th style="padding:2px 2px;">AvBwW bs</th>
				<th style="padding:2px 2px;">bvg</th>
				<th style="padding:2px 2px;">c`ex</th>
				<th style="padding:2px 2px;"> ‡mKkb / jvBb</th>
				<?php if($status==2){?>
				<th style="padding:2px 2px; width:100px">m¤§wZ evwZ‡ji ZvwiL</th>
				<th style="padding:2px 2px; width:100px">kÖwg‡Ki ¯^vÿi </th>
				<?php }else{
				?>
				<th style="padding:2px 2px; width:100px">mvÿi</th>
				<?php }?>
			</tr>
			<!-- heading -->
			<?php }} ?>
		</table>
	</div>
	<br>
	<br>
	<br>
	<div style="display:flex; justify-content:space-between;width:80%;margin:0 auto">
		<div style="font-family:SutonnyMJ;font-size:16px;border-top:1px solid black;width:fit-content">cÖ¯‘ZKvixi ¯^vÿi</div>
		<div> 
		<p style="font-family:SutonnyMJ;font-size:18px;border-top:1px solid black;margin-top: 0px !important;width:fit-content">Aby‡gv`bKvixi ¯^vÿi</p>
			<span style="font-family:SutonnyMJ;font-size:18px;">(gvbem¤ú` wefvM)</span>
			<br>
			<?php if ($status == 2) {?>
				<span style="font-size:18px;" class="unicode-to-bijoy"></span>
			<?php }?>
		</div>
	</div>
	<br><br>
</body>
</html>
<script src="<?=base_url()?>js/unicode_to_bijoy.js" type="text/javascript"></script>
<?php echo "<script>applyUnicodeToBijoy()</script>"?>
<?php exit(); ?>
