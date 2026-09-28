<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
    body {
      margin: 20px;
      padding: 0;
      box-sizing: border-box;
    }
    .box {
      display: flex;
      flex-direction: row;
      width: 435px;
      height:265px;
      margin: 5px 18px 14px 8px;
      border: 3px solid black;
      position: relative;
    }
    .box-img{
      width: 100px;
      height: 100px;
      border: 1px solid black;
    }
    @media print{
      @page{
        margin:0px;
        paddin: 0px;
        box-sizing: border-box;
      }
    }
  </style>
  <title>Id Card English</title>
</head>
<body">
  <div class="container">
    <?php  $count =0; $unit_id= $this->session->userdata('data')->unit_name; foreach($values as $value){   $count++;?>
      <div class='d-flex'>
        <div class='box'>
            <div style="rotate:-90deg;margin: 0px <?php echo $unit_id == 2 ? '20px':'50px'?> 0px;text-align: center">
              <?php  $image = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
              <p style="margin-top: 5px;">
                <img src="<?php echo base_url('/images'.'/'.$image->company_logo)?>" style="height: 30px; width: 100px;">
              </p>
              <?php if($unit_id == 4) {?>
               <h6 style="" class='font-weight-bold'><?= $image->company_name_english; ?></h6>
              <?php } else{?>
                <h5 style="" class='font-weight-bold'><?= $image->company_name_english; ?></h5>
              <?php }?>
              <img src="<?php echo base_url('/uploads/photo'.'/'.$value->img_source)?>" alt="" class="box-img">
              <div style="line-height: 30px;">
                <p style="margin:0px <?php echo ($unit_id == 1 && strlen($value->name_en) >= 17) ? "-14px": "auto"; ?> ;font-size:16px">
                <b><?php echo $value->name_en?></b></p>
                <p style="margin:0px auto;  line-height:6px; font-size:16px"><b><?php echo $value->desig_name?></b></p>
                <p style="margin-left: <?php echo $unit_id == 2 ? '4px':($unit_id == 1?'-30px':'-10px')?>;text-align: left; line-height:6px;margin-top:15px; font-size:15px">Department : <b><?php echo $value->dept_name?></b></p>
                <p style="margin-left: <?php echo $unit_id == 2 ? '4px':($unit_id == 1?'-30px':'-10px')?>;text-align: left; line-height:6px; font-size:15px">ID Card No : <b><?php echo $value->emp_id?></b></p>
                <p style="margin-left: <?php echo $unit_id == 2 ? '4px':($unit_id == 1?'-30px':'-10px')?>;text-align: left; line-height:6px; font-size:15px">Join Date : <b><?php echo date('d-m-Y',strtotime($value->emp_join_date))?></b></p>
                <p style="margin-left: <?php echo $unit_id == 2 ? '4px':($unit_id == 1?'-30px':'-10px')?>;text-align: left; line-height:6px; font-size:15px">Blood Group: <b><?php echo $value->blood?></b></p>
              </div>
              <div class="d_flex">
                <p style="border-top: 1px solid black;width: fit-content;position: absolute;margin-top: <?= $unit_id == 2? "70px":($unit_id ==1? "72px":"60px")?>;font-size: 14px;margin-left: <?php echo $unit_id == 2 ? '4px':($unit_id == 1?'-30px':'-10px')?>;"><b>Card Holder</b></p>
                  <div style="display: flex; flex-direction: column; align-items: center;margin-top: -29px;">
                    <img style="position: absolute;margin-top: 25px;margin-left: 118px;" src="<?php echo base_url('/images'.'/'.$image->company_signature)?>" alt="Authorized Signature" height="30px">
                    <p style="border-top: 1px solid black;width: 142px;margin-left: 102px;position: absolute;margin-top: <?= $unit_id == 2? "70px":($unit_id ==1? "72px":"60px")?>;font-size: 14px;">
                      <b>Authorized Signature</b>
                    </p>
                  </div>
              </div>
              <p class="text-center bg-info" style="width: <?php echo $unit_id == 2 ? '100%':($unit_id == 1 ? '141%':'120%')?>;border-radius: 10px 10px 0 0;position: relative;bottom: <?php echo $unit_id == 2 ? '-92px':($unit_id ==1 ? "-98px":'-87px')?>;margin-left: <?php echo $unit_id == 2 ? '0px':($unit_id == 1 ? '-38px' : '-22px')?>;">www.ajgroupbd.com</p>
            </div>
        </div>
        <div class='box'>
            <div style='rotate: -90deg;margin: 40px 240px 40px -60px;text-align: center;'>
                  <?php echo $unit_id == 1 ? "<br>":''?>
                  <p style="margin-top: 20px;font-size:14px;white-space:nowrap">
                    <?php

                      if($unit_id == 1){
                        echo "  ";
                        // echo " Document Code : AJFL/HRAC(HR)/03/021 ";
                      }else if($unit_id == 2){
                        echo "Document Code : LSAL/HR/03/174";
                      }else if($unit_id == 4){
                        echo "Document Code : HGL/HRD/HR/03/051";
                      }
                    ?>
                  </p>
          <p style="font-size:14px;line-height:0px"><b>Validity: Till The Time of Employement</b></p>
          <p style="font-size:14px;line-height:0px">Issue Date: <b><?php echo date('d-m-Y',strtotime($value->emp_join_date))?></b></p>
          <p style="font-size:14px;line-height:0px">Type of Work: <b><?php echo $value->emp_cat_id == 1 ? 'Permanent':'New'?></b></p>
          <p style="font-size:14px;line-height:14px">Card Holder Must Carry This Card At All <br> Time, If the Identity card is lost, the <span style="white-space:nowrap;font-size:13.5px">management autharity should be informed</span> </p>
          <p style="font-size:14px;line-height:15px">immediately to the following address, Factory Address:<b> <?php echo $image->company_add_english?></b></p>
          <p style="font-size:14px;line-height:14px">Company Contact Number: <b><?php echo $image->company_phone?></b></p>
          <p style="font-size:14px;line-height:15px">Emergency Contact Number: <b><?php echo $value->personal_mobile?></b></p>
          <p style="font-size:14px;line-height:15px"><?php echo $value->nid_dob_check == 1?'NID':'Birth Certificate'?>: <b><?php echo $value->nid_dob_id?></b></p>
          <p style="font-size:14px;line-height:0px">Permanent Address:-</p>
          <p style="font-size:14px;line-height:14px">Vill: <b><?php echo $value->per_village?></b>, Post: <b><?php echo $value->post_name_en?></b>,</p>
          <p style="font-size:14px;line-height:14px">Upazila: <b><?php echo $value->upa_name_en?></b>, District: <b><?php echo $value->dis_name_en?></b></p>
          <p class="text-center bg-info" style="width:102% ; border-radius: 10px 10px 0 0;position: absolute;bottom: -289px;height: 22px;margin-left:-3px">
          </p>
              </div>
          </div>
        </div>
      <?php if($count == 4){?>
        <div style="page-break-after: always"></div>

    <?php $count = 0; } }?>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php exit(); ?>
