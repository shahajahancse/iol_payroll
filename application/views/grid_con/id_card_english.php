<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <!-- <meta name="viewport" content="width=device-width"> -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <style>
   body {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 10px;
    }
    .box {
      display: flex;
      flex-direction: column;
      align-items: center;
      width: 265px;
      height:435px;
      margin: 19px;
      border: 3px solid black;
      position: relative;
    }

    .container-fluid {
      display: flex;
      flex-wrap: wrap;
    }
    p{
      margin: 0px;
      /* padding: 1px; */
      font-size: 13px;
    }
    .box-img{
      width: 100px;
      height: 100px;
      border: 1px solid black;
      margin: 0 75px;
    }
    .left_content{
      display: flex;
      flex-direction: column;
      align-items: start;
      width:93%;
    }
    .d_flex {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      width: 93%;
      margin-top: 45px;
      position:absolute;
      bottom:20px;
    }
      @media print {

        @page {
          size: A4;
        }

        .box {
          display: flex;
          flex-direction: column;
          align-items: center;
          width: 265px;
          height:435px;
          margin: 15px;
          border: 2px solid #ccc;
          position: relative;        
        }
        h6{
          font-size: 18px !important;
        }
        p{
          font-size: 13px;
        }
         .left_content{
          width: 93%;
        }
        .p_padding{
          padding: 0;
          line-height: 18px;
          font-size: 13px !important;
        }
      }
      .page_break{
        page-break-after: always;
      }
  </style>
  <title>Id Card English</title>
</head>

<body>

  <div class="container-fluid">
    <!-- < ?php dd($values)?> -->
    <?php  $unit_id= $this->session->userdata('data')->unit_name; foreach($values as $value){?>
      <div class="page_break" style="margin-left:-10px">
        <div class="box">
          <?php  $image = $this->db->where('unit_id', $unit_id)->get('company_infos')->row(); ?>
          <p><img src="<?php echo base_url('/images'.'/'.$image->company_logo)?>" style="height: 40px;width: 70px;margin-top:15px;margin-bottom:10px"></p>
          <?php if($unit_id == 4) {?>
          <h6 style="margin-bottom:10px" class='font-weight-bold'><?= $image->company_name_english; ?></h6>
          <?php } else{?>
          <h5 style="margin-bottom:10px" class='font-weight-bold'><?= $image->company_name_english; ?></h5>
          <?php }?>
          <img src="<?php echo base_url('/uploads/photo'.'/'.$value->img_source)?>" alt="" class="box-img">
          <div class="left_content" style="line-height: 25px;margin:0px">
            <p style="margin:0 auto;font-size:16px"><b><?php echo $value->name_en?></b></p>
            <p style="margin:0 auto;font-size:16px"><b><?php echo $value->desig_name?></b></p>
            <p style="font-size:15px">Department : <b><?php echo $value->dept_name?></b></p>
            <p style="font-size:15px">ID Card No : <b><?php echo $value->emp_id?></b></p>
            <p style="font-size:15px">Join Date : <b><?php echo date('d-m-Y',strtotime($value->emp_join_date))?></b></p>
            <p style="font-size:15px">Blood Group: <b><?php echo $value->blood?></b></p>
          </div>

          <div class="d_flex">
            <p style="border-top:1px solid black;width:fit-content"><b>Card Holder</b></p>
            <div style="display: flex; flex-direction: column; align-items: center;margin-top: -29px;">
              <img src="<?php echo base_url('/images'.'/'.$image->company_signature)?>" alt="Authorized Signature" height="30px">
              <p style="border-top:1px solid black;width:fit-content; text-align: center;">
                <b>Authorized Signature</b>
              </p>
            </div>
          </div>

          <p class="text-center bg-info" style="width:100% ; border-radius: 10px 10px 0 0;position: absolute;bottom: 0px;">www.ajgroupbd.com</p>
        </div>
        <div class="box text-center p_padding" style="line-height: <?php echo $unit_id == 1 ? '20' : '21'?>px">
        <!-- <div class="box text-center p_padding" style="line-height: 22px"> -->
          <?php echo $unit_id == 1 ? "<br>":''?>
          <p style="margin-top: 0px;">
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
          <p style="font-size:14px"><b>Validity: Till The Time of Employement</b></p>
          <p style="font-size:14px">Issue Date: <b><?php echo date('d-m-Y',strtotime($value->emp_join_date))?></b></p>
          <p style="font-size:14px">Type of Work: <b><?php echo $value->emp_cat_id == 1 ? 'Permanent':'New'?></b></p>
          <p style="font-size:14px">Card Holder Must Carry This Card At All Time, If the Identity card is lost, the <span style="white-space:nowrap;font-size:13.5px">management autharity should be informed</span> </p>
          <p style="font-size:14px">immediately to the following address, Factory Address:<b> <?php echo $image->company_add_english?></b></p>
          <p style="font-size:14px">Company Contact Number: <b><?php echo $image->company_phone?></b></p>
          <p style="font-size:14px">Emergency Contact Number: <b><?php echo $value->personal_mobile?></b></p>
          <p style="font-size:14px"><?php echo $value->nid_dob_check == 1?'NID':'Birth Certificate'?>: <b><?php echo $value->nid_dob_id?></b></p>
          <p style="font-size:14px">Permanent Address:-</p>
          <p style="font-size:14px">Vill: <b><?php echo $value->per_village?></b>, Post: <b><?php echo $value->post_name_en?></b>,</p>
          <p style="font-size:14px">Upazila: <b><?php echo $value->upa_name_en?></b>, District: <b><?php echo $value->dis_name_en?></b></p>
          <p class="text-center bg-info" style="width:100% ; border-radius: 10px 10px 0 0;position: absolute;bottom: 0px;height: 22px;">
          </p>
        </div>
        <div class="page_break"></div>
      </div>
      <?php }?>
  </div>


  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>
<?php exit(); ?>
