<?php //print_r($username);exit; ?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
  <meta charset="utf-8" />
  <link rel="icon" type="image/ico" href="<?=base_url()?>awedget/assets/img/mysoft-logo.png"/>

  <title>Management Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta content="Mysoftheaven (BD) Ltd." name="author" />

  <link href="<?=base_url()?>awedget/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
  <link href="<?=base_url()?>awedget/assets/plugins/jquery-superbox/css/style.css" rel="stylesheet" type="text/css" media="screen"/>
  <link href="<?=base_url()?>awedget/assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" media="screen"/>
  <link href="<?=base_url()?>awedget/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

  <link href="<?=base_url()?>awedget/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>awedget/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
  <link href="<?=base_url()?>awedget/assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
  <link href="<?=base_url()?>awedget/assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
  <link href="<?=base_url()?>awedget/assets/plugins/boostrap-checkbox/css/bootstrap-checkbox.css" rel="stylesheet" type="text/css" media="screen"/>
  <link href="<?=base_url()?>awedget/assets/plugins/ios-switch/ios7-switch.css" rel="stylesheet" type="text/css" media="screen">
  <link href="<?=base_url()?>awedget/assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css" media="screen"/>
  <link href="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

  <link href="<?=base_url()?>awedget/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
  <link href="<?=base_url()?>awedget/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>

  <link href="<?=base_url()?>awedget/assets/croper/css/cropper.min.css" rel="stylesheet" >
  <link href="<?=base_url()?>awedget/assets/croper/css/main.css" rel="stylesheet" >

  <!-- BEGIN CSS TEMPLATE -->
  <link href="<?=base_url()?>awedget/assets/css/style.css" rel="stylesheet" type="text/css"/>
  <link href="<?=base_url()?>awedget/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
  <link href="<?=base_url()?>awedget/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
  <script src="<?=base_url()?>awedget/assets/plugins/jquery-1.9.1.min.js" type="text/javascript"></script>
  <script type="text/javascript">var hostname='<?=base_url()?>';</script>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
  <style type="text/css">
  .n_demand {
  position: absolute;
  top: 10px;
  right: 65px;
  font-size:7px;
  color: white;
  border-radius: 50%;
  background: #f95959;
  min-width: 16px;
  min-height: 16px;
  text-align: center;
  line-height: 16px;

}
.n_demand_sub {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size:7px;
  color: white;
  border-radius: 50%;
  background: #f95959;
  min-width: 16px;
  min-height: 16px;
  text-align: center;
  line-height: 16px;

}
.n_budget {
  position: absolute;
  top: 10px;
  right: 45px;
  font-size: 7px;
  color: white;
  border-radius: 50%;
  background: #a1c45a;
  min-width: 16px;
  min-height: 16px;
  text-align: center;
  line-height: 16px;

}
.n_budget_sub {
  position: absolute;
  top: 10px;
  right: 15px;
  font-size: 7px;
  color: white;
  border-radius: 50%;
  background: #a1c45a;
  min-width: 16px;
  min-height: 16px;
  text-align: center;
  line-height: 16px;
}
.page-sidebar .page-sidebar-wrapper > ul > li > ul.sub-menu li > ul.sub-menu > li > a {
    color: #683091;
}

  </style>

</head> <!-- END HEAD -->

  <body class="" style="background-color: #ffffff !important;">
    <!-- <div id="loading">
      <img id="loading-image" src="<?=base_url()?>awedget/assets/img/icon/loading.gif" alt="Loading..." />
    </div> -->
    
    <div class="header navbar navbar-inverse ">
      <!-- BEGIN TOP NAVIGATION BAR -->
      <div class="navbar-inner">
        <div class="header-seperation">
          <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">
            <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" >              
              <div class="iconset top-menu-toggle-white"></div> </a> 
            </li>
          </ul>
          <a href="<?=base_url()?>"><span style="color:#ffffff; font-size: 19px; padding-left: 15px; line-height: 60px">MHL KORMOCHARI</span></a>
          <ul class="nav pull-right notifcation-center">
          </ul>
        </div> <!-- END RESPONSIVE MENU TOGGLER -->

        <div class="header-quick-nav" >
          <!-- BEGIN TOP NAVIGATION MENU -->
          <div class="pull-left">
            <ul class="nav quick-section">
              <li class="quicklinks"> <a href="javascript:;" class="" id="layout-condensed-toggle" style="color: #006ba3;">
                <i class="fa fa-bars" style="font-size: 22px; color: #006ba3 !important;"></i>
                <!-- <div class="iconset top-menu-toggle-dark"></div> --> </a> 
              </li>
            </ul>
          </div> <!-- END TOP NAVIGATION MENU -->

          <!-- BEGIN CHAT TOGGLER -->
          <div class="pull-right">
            <div class="chat-toggler">
              <div class="user-details" style="float:right;">                
                <div class="username">
                  <span class="" style="margin-left: 20px;">Welcome, <b><?=$username?></b> <img src="<?=base_url()?>awedget/assets/img/avater.jpg"  alt="Profile Image" data-src="<?=base_url()?>awedget/assets/img/avater.jpg" data-src-retina="<?=base_url()?>awedget/assets/img/avater.jpg" width="35" height="35" style="border-radius: 35px;" /> 
                  </span>
                </div>
              </div>
            </div>

            <ul class="nav quick-section ">
              <li class="quicklinks"> <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="javascript:;" id="user-options">
               <i class="fa fa-cog" style="font-size: 22px; color: #006ba3 !important;"></i>
               </a>
               <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">          
                  <li><a href="<?=base_url()?>change_password"><i class="fa fa-lock"></i>&nbsp;&nbsp;Change Password</a></li>
                  <!-- <li><a href="<?=base_url()?>general_setting/single_office_update"><i class="fa fa-building-o " aria-hidden="true"></i>&nbsp;&nbsp; অফিস হালনাগাদ</a></li> -->
                  <li><a href="<?=base_url()?>logout_FE"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
                </ul>
              </li>
            </ul>
          </div> <!-- END CHAT TOGGLER -->
        </div> <!-- END TOP NAVIGATION MENU -->
      </div> <!-- END TOP NAVIGATION BAR -->
    </div> <!-- END HEADER -->


  <!-- BEGIN CONTAINER -->
  <div class="page-container row-fluid">
    <div class="page-sidebar" id="main-menu">
      <!-- BEGIN MINI-PROFILE -->
      <div class="page-sidebar-wrapper" id="main-menu-wrapper">
        <!-- <div class="slimScrollDiv"> -->
        <div class="user-info-wrapper text-center" style=" padding-bottom: 10px; border-bottom: 1px solid #db0424;">        
          <div class="user-info" style="background-color: white; ">
              <span class="label label-success"> 
                <strong><?=$unit_name?></strong>
              </span>
          </div>
        </div>

        <!-- BEGIN SIDEBAR MENU -->
          <ul class="pull-left">
            <li class="start active"> 
               <a href="<?=base_url()?>"> <i class="icon-custom-home"></i>  <span class="title">Home</span></a>
            </li>
            <li class="start "> <a href="javascript:;" > <i class="fa fa-tachometer"></i> <span class="title">Dash Board</span> <span class="selected"></span> <span class="arrow"></span> </a> 
              <ul class="sub-menu">
                <li> <a href="<?=base_url()?>setup_con/dashboard_date_setup" target="body_load"> Date Setup </a></li>
                <li> <a href="<?=base_url()?>emp_info_con/at_a_glance_info_view" target="body_load"> At A Glance </a></li>
              </ul>
            </li>                                        
          </ul>
         <div id="notification_div"></div>
         <div class="clearfix"></div>
         <!-- END SIDEBAR MENU -->
       </div>
    </div>
    <a href="#" class="scrollup">Scroll</a>
    <div class="footer-widget">
      <!-- <div class="copyrights pull-left" style="width: 50%" >
        <span> <span style="vertical-align: bottom; font-size: 10px;">কারিগরি সহায়তায় |</span>  <a href="http://www.lrb.gov.bd/" target="_blank"> 
        <img src="<?=base_url()?>awedget/assets/img/a2i-logo.png" height="18"> </a> </span>
      </div> -->
      <div class="copyrights text-center" style="width: 100%">
      <span style=" float: right;"> <span style="vertical-align: bottom; font-size: 11px;">Developed By |</span> <a href="http://www.mysoftheaven.com/" target="_blank"> 
      <img src="<?=base_url()?>awedget/assets/img/mysoft-logo.png" height="18"> Mysoftheaven (BD) Ltd.</a> </span>
      </div>
    </div>
<!-- END SIDEBAR --> 
<style type="text/css">
   @font-face {
    font-family: 'Kalpurush';
    src: url('<?=base_url()?>awedget/assets/fonts/Kalpurush.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
  }
  .page-content {
    font-family: 'Kalpurush', 'Open Sans', Arial, sans-serif;
    background: #e5e9ec;
  }
  .report-table{
    width: 100%;
  }
  .report-table tr th{
    font-size: 15px;
    text-align: left;
    width: 25%;
    font-weight: normal;
  }
  .report-table tr td{
    text-align: left;
    width: 25%;
    font-size: 15px;
  }
  .report-table tr th:nth-child(1),
  .report-table tr td:nth-child(1){
    width: 35%;
  }
  .report-table tr th:nth-child(2),
  .report-table tr td:nth-child(2){
    width: 20px;
  }
  .sub-mark{
    width: 5% !important;
  }
  .new{
    -webkit-box-shadow: 13px 11px 40px 0px rgba(82,82,82,0.43);
    -moz-box-shadow: 13px 11px 40px 0px rgba(82,82,82,0.43);
    box-shadow: 13px 11px 40px 0px rgba(82,82,82,0.43);
  }
  .new .tiles-title {
    height: 40px;
}
  .new .heading{
    width: 180px;
    padding: 5px 10px;
    margin-left: -30px !important;
    border-radius: 0 20px 20px 0px;
    position: relative;
    text-align: center;
  }
  .new .triangle-up {
    width: 0;
    height: 0;
    right: -3px;
    bottom: -3px;
    position: absolute;
  }
  
  .new1 .heading{
    color: #fff !important;
    background: #9424b8;
  }

  .new2 tr:nth-child(1),
  .new1 .tiles-title{
    color: #9424b8 !important;
  }

  .new3 tr:nth-child(1){
    color: #78c72f !important;
  }

  .new1 .triangle-up {
   
    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #9424b8;
  }

  .new2 .heading{
    color: #fff !important;
    background: #00adef;
  }

  .new1 tr:nth-child(1),
  .new2 .tiles-title{
    color: #00adef !important;
  }
  .new2 .triangle-up {
   
    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #00adef;
  }

  .new3 .heading{
    color: #fff !important;
    background: #ff940b;
  }

  .new4 tr:nth-child(1),
  .new3 .tiles-title{
    color: #ff940b !important;
  }
  .new3 .triangle-up {
   
    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #ff940b;
  }

  .new4 .heading{
    color: #fff !important;
    background: #78c72f;
  }

  .new4 .tiles-title{
    color: #78c72f !important;
  }
  .new4 .triangle-up {
   
    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #78c72f;
  }
  .grand_total{
      color: #fff !important;
      background: #9424b8;
      width: 20%;
      height: 40px;
      padding: 0px 10px;
      font-size: 20px;
      border-radius: 0;
      text-align: center;
      position: relative;
      right: 40%;
      bottom: 45px;
      float: right;
  }
  .head-title{
    font-size: 14px;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
    font-weight:600;
  }
  .field, .field1{
    position: relative;
  }
  .field .tiles-title{
    color: #9424b8;
  }

  .field .triangle-up {
    width: 0;
    height: 0;
    right: 0px;
    bottom: 0px;
    position: absolute;
    border-left: 50px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 50px solid #9424b8;
  }
  .field1 .tiles-title{
    color: #00adef;
  }

  .field1 .triangle-up {
    width: 0;
    height: 0;
    right: 0px;
    bottom: 0px;
    position: absolute;
    border-left: 50px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 50px solid #00adef;
  }
  .head-title i{
    margin-right: 10px;
    line-height: 20px
  }

  .zc-ref {
    display: none;
  }
  div#myChart1-license-text,
  div#myChart2-license-text,
  div#myChart-license-text {
      display: none !important;
  }
  td i{
    color: #9424b8 !important;
    font-size: 12px !important;
  }

 body{
   background: none !important;
}

.anchor_cls.mactive{
  background: red;
  color:#fff;
}

</style>
 
<div class="page-content">
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- <div id="portlet-config" class="modal hide">
      <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"></button>
        <h3>Widget Settings</h3>
      </div>
      <div class="modal-body"> Widget settings form goes here </div>
    </div> -->    
    <div class="clearfix"></div>
    <div class="content">
      <div id="container" style="margin-bottom: 100px;">
        <iframe id="idIframe" width="100%" src="<?= base_url()?>payroll_con/first_body" name="body_load" style="border:0px solid;" scrolling="no" onload="iframeLoaded()"></iframe>
      </div>
    </div>
  </div></div>
<!-- END CONTAINER --> 

<!-- BEGIN CORE JS FRAMEWORK--> 
<!-- <script src="<?=base_url()?>awedget/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>  -->
<script src="<?=base_url()?>awedget/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script> 
<!-- <script src="<?=base_url()?>awedget/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>  -->
<script src="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script> 
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<script src="<?=base_url()?>awedget/assets/plugins/breakpoints.js" type="text/javascript"></script> 
<script src="<?=base_url()?>awedget/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script> 
<script src="<?=base_url()?>awedget/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script> 
<!-- END CORE JS FRAMEWORK --> 
<!-- BEGIN PAGE LEVEL JS -->  
<script src="<?=base_url()?>awedget/assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>  
<script src="<?=base_url()?>awedget/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="<?=base_url()?>awedget/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/ios-switch/ios7-switch.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<!-- <script src="<?=base_url()?>awedget/assets/plugins/select2/select2.min.js" type="text/javascript"></script> -->
<script src="<?=base_url()?>awedget/assets/plugins/boostrap-form-wizard/js/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/jquery-validation/dist/additional-methods.min.js" type="text/javascript"></script>
<script src="//oss.maxcdn.com/jquery.mask/1.11.4/jquery.mask.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- <script src="<?=base_url()?>awedget/assets/js/form_validations.js" type="text/javascript"></script> -->
<!-- <script src="<?=base_url()?>awedget/assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script> -->

<script src="<?=base_url()?>awedget/assets/plugins/jquery-superbox/js/superbox.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.2.0/min/dropzone.min.js"></script>
  
<!-- BEGIN PAGE DATATABLE -->   
<script src="<?=base_url()?>awedget/assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="<?=base_url()?>awedget/assets/plugins/jquery-datatable/extra/js/TableTools.min.js" type="text/javascript" ></script>
<script src="<?=base_url()?>awedget/assets/plugins/datatables-responsive/js/datatables.responsive.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/datatables-responsive/js/lodash.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- <script src="<?=base_url()?>awedget/assets/js/datatables.js" type="text/javascript"></script> -->
<script src="<?=base_url()?>awedget/assets/js/tabs_accordian.js" type="text/javascript"></script>
<script src="<?=base_url()?>awedget/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?=base_url()?>awedget/assets/js/messages_notifications.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS --> 
<script src="<?=base_url()?>awedget/assets/js/core.js" type="text/javascript"></script> 
<!-- <script src="<?=base_url()?>awedget/assets/js/chat.js" type="text/javascript"></script>  -->
<script src="<?=base_url()?>awedget/assets/js/demo.js" type="text/javascript"></script> 

<script src="<?=base_url()?>awedget/assets/croper/js/cropper.min.js"></script>
<script src="<?=base_url()?>awedget/assets/croper/js/main.js"></script>

<!-- END CORE TEMPLATE JS --> 
<!-- <script src="<?=base_url()?>awedget/assets/js/dashboard_v2.js" type="text/javascript"></script> -->
<script type="text/javascript">
  $(document).ready(function () {
      // $(".live-tile,.flip-list").liveTile();
      $(".source").select2();
  });
</script>

<script src="<?=base_url()?>awedget/assets/js/jquery.bongabdo.js"></script>
<!-- <script src="https://cdn.ckeditor.com/4.10.0/standard/ckeditor.js"></script> -->
<script type="text/javascript">
  var iFrameID = document.getElementById('idIframe');
   // iFrameID.style.backgroundColor = 'green';
  function iframeLoaded() {
      var iFrameID = document.getElementById('idIframe');

        if(iFrameID){
        // iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
        var autoheight = iFrameID.contentWindow.document.body.scrollHeight;
        if(autoheight < '500'){
          iFrameID.height = "500px";
        }else{
          iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
        }
    }   
  }
</script>  
<script>
  // $(function () {
  //   CKEDITOR.replace('editor1');
  // });

  
  $(function() {    
    // Call SuperBox - that's it!
    $('.superbox').SuperBox();    
  });

    //district dropdown
    $('#division').change(function(){
      $('.distirict_val').addClass('form-control input-sm');
      $(".distirict_val > option").remove();
      var id = $('#division').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_district_by_division/" + id,
        success: function(func_data)
        {
          $.each(func_data['district'],function(id,name)
          {
            var opt = $('<option />');
            opt.val(id);
            opt.text(name);
            $('.distirict_val').append(opt);
          });
          $('#office').empty();
          if(func_data['offices'].length !==0){
            loadOffices(func_data['offices']);            
          }
        }
      });
    });


    // Upazila  dropdown
    $('#district').change(function(){
      $('.upazila_val').addClass('form-control input-sm');
      $(".upazila_val > option").remove();
      var dis_id = $('#district').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_upazila_by_district/" + dis_id,
        success: function(func_data)
        {
          $.each(func_data['upazila'],function(id,ut_name)
          {
            var opt = $('<option />');
            opt.val(id);
            opt.text(ut_name);
            $('.upazila_val').append(opt);
          });

          $('#office').empty();
          if(func_data['offices'].length !==0){
            loadOffices(func_data['offices']);            
          }
        }
      });
    });

    // Union  dropdown
    $('#upazila').change(function(){
      $('.union_val').addClass('form-control input-sm');
      $(".union_val > option").remove();
      var dis_id = $('#upazila').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_union_by_upazila/" + dis_id,
        success: function(func_data)
        {
          $.each(func_data['union'],function(id,ut_name)
          {
            var opt = $('<option />');
            opt.val(id);
            opt.text(ut_name);
            $('.union_val').append(opt);
          });
          $('#office').empty();
          if(func_data['offices'].length !==0){
            loadOffices(func_data['offices']);            
          }
        }
      });
    });

    // Designation Dropdown
    $('#office').change(function(){
      $("#employee > option").remove();
      var office_id = $('#office').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_employee_by_office/" + office_id,
        success: function(func_data)
        {
          $.each(func_data['union'],function(id,ut_name)
          {
            var opt = $('<option />');
            opt.val(id);
            opt.text(ut_name);
            $('#employee').append(opt);
          });
          
        }
      });
    });

    // estimated Budget check
    $(".exits").hide();
    $('#checking_lrb').change(function(){
      var fiscal_year = $('#checking_lrb').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_lrb_estimated_exits_by_fiscal_year/" + fiscal_year,
        success: function(fiscal_year)
        { 
          if(fiscal_year){
            $(".used").hide();
            $(".exits").show();
          }else{
            $(".exits").hide();
            $(".used").show();
          }
        }
      });
    });
    $('#checking_sa').change(function(){
      var fiscal_year = $('#checking_sa').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_sa_estimated_exits_by_fiscal_year/" + fiscal_year,
        success: function(fiscal_year)
        { 
          if(fiscal_year){
            $(".used").hide();
            $(".exits").show();
          }else{
            $(".exits").hide();
            $(".used").show();
          }
        }
      });
    });
    $('#checking_la').change(function(){
      var fiscal_year = $('#checking_la').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_la_estimated_exits_by_fiscal_year/" + fiscal_year,
        success: function(fiscal_year)
        { 
          if(fiscal_year){
            $(".used").hide();
            $(".exits").show();
          }else{
            $(".exits").hide();
            $(".used").show();
          }
        }
      });
    });

    $('#checking_upazila').change(function(){
      var fiscal_year = $('#checking_upazila').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_upazila_estimated_exits_by_fiscal_year/" + fiscal_year,
        success: function(fiscal_year)
        { 
          if(fiscal_year){
            $(".used").hide();
            $(".exits").show();
          }else{
            $(".exits").hide();
            $(".used").show();
          }
        }
      });
    });

    $('#checking_circle').change(function(){
      var fiscal_year = $('#checking_circle').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_circle_estimated_exits_by_fiscal_year/" + fiscal_year,
        success: function(fiscal_year)
        { 
          if(fiscal_year){
            $(".used").hide();
            $(".exits").show();
          }else{
            $(".exits").hide();
            $(".used").show();
          }
        }
      });
    });

    $('#checking_union').change(function(){
      var fiscal_year = $('#checking_union').val();
      $.ajax({
        type: "POST",
        url: hostname +"common/ajax_get_union_estimated_exits_by_fiscal_year/" + fiscal_year,
        success: function(fiscal_year)
        { 
          if(fiscal_year){
            $(".used").hide();
            $(".exits").show();
          }else{
            $(".exits").hide();
            $(".used").show();
          }
        }
      });
    });


    // Jquery Onload
    $(document).ready(function() {
      // console.log( "run!" );

      //Datepicker
      $('.datetime').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true
      });


     

      $('#letter_form_submit').on('click',function(){
        //alert("hh");
        var division_id = $('#division').val();
        if(division_id == null || typeof(division_id) == 'undefined' || division_id == '')division_id = '0';

        var district_id = $('#district').val();
        if(district_id == null || typeof(district_id) == 'undefined' || district_id == '')district_id = '0';

        var upazila_id = $('#upazila').val();
        if(upazila_id == null || typeof(upazila_id) == 'undefined' || upazila_id == '')upazila_id = '0';

        var union_id = $('#union').val();
        if(union_id == null || typeof(union_id) == 'undefined' || union_id == '')union_id = '0';

        var office_id = $('#offices').val();
        if(office_id == null || typeof(office_id) == 'undefined' || office_id == '')office_id = '0';

        var budget_fiscal_year_id = $('#budget_fiscal_year').val();
        if(budget_fiscal_year_id == null || typeof(budget_fiscal_year_id) == 'undefined' || budget_fiscal_year_id == '')budget_fiscal_year_id = '0';

        var budget_file_id = $('#budget_files').val();
        if(budget_file_id == null || typeof(budget_file_id) == 'undefined' || budget_file_id == '')budget_file_id = '0';
        $.ajax({
          type: "POST",
          url: "budget_setting/budget_letter_add/",
          data: { "division_id": division_id, "district_id": district_id, "upazila_id" : upazila_id, "union_id" : union_id, "office_id" : office_id, "budget_fiscal_year_id" : budget_fiscal_year_id, "budget_file_id" : budget_file_id },
          success: function(data)
            {

            }
          });
      });
    });

function loadOffices(data){
   $.each(data,function(id,name)
    {
      var opt = $('<option />');
      opt.val(id);
      opt.text(name);
      $('.office_val').append(opt);
    });
}
</script>

<script>
      setTimeout(function() {
        $('#mydivdanger').fadeOut('fast');
      }, 4000); // <-- time in milliseconds

      function printDiv(divName) {
          var printContents = document.getElementById(divName).innerHTML;
          var originalContents = document.body.innerHTML;
          document.body.innerHTML = printContents;
          window.print();
          document.body.innerHTML = originalContents;
      }
    function printSpecificContents(id)
    {
          var divContents = document.getElementById(id).innerHTML;
          var printWindow = window.open('', '', 'height=800,width=1000');
          printWindow.document.write(divContents);

          printWindow.print();

    }
</script>

<script type="text/javascript">
  function subTotal(sl, sl2){
      var sum = 0;
      $(".sum_"+sl).each(function(){
          sum += +$(this).val();
      });

      $("#sum_"+sl).val(sum);

      var extra = $(".before_extra_"+sl2).val()-0;
      var budget = $(".single_"+sl2).val()-0;
      var after_extra = extra-budget;

      if(extra<budget){
          alert('বাজেট লিমিটেড ।');
          $(".single_"+sl2).val(0);
          var extra = $(".before_extra_"+sl2).val()-0;
          var budget = $(".single_"+sl2).val()-0;
          var after_extra = extra-budget;
      }

      $(".after_extra_"+sl2).val(after_extra);

      var extra = 0;
      $(".after_extra").each(function(){
          extra += +$(this).val();
      });
      $("#after_extra").val(extra);

      var sum = 0;
      $(".sum").each(function(){
          sum += +$(this).val();
      });
      $("#sum").val(sum);
      
  }
  
</script>

<script type="text/javascript">
  $(".sum").on("keyup", function() {
    var sum = 0;
    $(".sum").each(function(){
        sum += +$(this).val();
    });
    $("#sum").val(sum);
    var bangla_converted_number=en2bn(sum);
    var convert_in_word =convertNumberToWords(sum);
    $("#total-amount").html(bangla_converted_number + ' ('+convert_in_word+')');
    $(".edit-text").val($(".default-text").html());

    var extra = 0;
    $(".after_extra").each(function(){
        extra += +$(this).val();
    });
    $("#after_extra").val(extra);
  });
</script>

<script type="text/javascript">
  $(".edit-text").on("keyup", function() {
      $(".default-text").html($(".edit-text").val());
  });

  function en2bn(sum){
    var finalEnlishToBanglaNumber={'0':'০','1':'১','2':'২','3':'৩','4':'৪','5':'৫','6':'৬','7':'৭','8':'৮','9':'৯'};
 
    String.prototype.getDigitBanglaFromEnglish = function() {
        var retStr = this;
        for (var x in finalEnlishToBanglaNumber) {
             retStr = retStr.replace(new RegExp(x, 'g'), finalEnlishToBanglaNumber[x]);
        }
        return retStr;
    };
     
    var english_number=String(sum);
     
    var bangla_converted_number=english_number.getDigitBanglaFromEnglish();

    return bangla_converted_number;
  }

</script>


<!-- Privious year calculation -->
<script type="text/javascript">
  function subreceived(sl, sl2){
      var remaining=$(".received_"+sl2).val()-$(".expenditure_"+sl2).val();
      $(".remaining_"+sl2).val(remaining);

      var sub_received = 0;
      $(".received_"+sl).each(function(){
          sub_received += +$(this).val();
      });

      $("#received_"+sl).val(sub_received);

      var sub_remaining=$("#received_"+sl).val()-$("#expenditure_"+sl).val();
      $("#remaining_"+sl).val(sub_remaining);


      var total_received = 0;
      $(".received").each(function(){
          total_received += +$(this).val();
      });

      $("#received").val(total_received);

      var total_remaining=$("#received").val()-$("#expenditure").val();
      $("#remaining").val(total_remaining);
      
  }

  function subexpenditure(sl, sl2){
      var remaining=$(".received_"+sl2).val()-$(".expenditure_"+sl2).val();
      $(".remaining_"+sl2).val(remaining);

      var sub_received = 0;
      $(".expenditure_"+sl).each(function(){
          sub_received += +$(this).val();
      });

      $("#expenditure_"+sl).val(sub_received);

      var sub_remaining=$("#received_"+sl).val()-$("#expenditure_"+sl).val();
      $("#remaining_"+sl).val(sub_remaining);


      var total_received = 0;
      $(".expenditure").each(function(){
          total_received += +$(this).val();
      });

      $("#expenditure").val(total_received);

      var total_remaining=$("#received").val()-$("#expenditure").val();
      $("#remaining").val(total_remaining);
      
  }

  function update() {
    $("#notification_div").html('Loading..'); 
    $.ajax({
      type: 'GET',
      url: '',
      timeout: 2000,
      success: function(data) {
        //console.log(data);
        //$("#some_div").html(data);
        $("#notification_div").html(''); 
        window.setTimeout(update, 10000);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
        $("#notification_div").html('Timeout contacting server..');
        window.setTimeout(update, 60000);
      }
  });
}

 $(document).ready(function () {
    $('.memorandum_no').bind('keydown', function(e){

        var num = this.value;

        if(e.keyCode== 32){
          e.preventDefault();
        }

        if(e.key!= 0 && e.key != 1 && e.key!= 2 && e.key!= 3 && e.key!= 4 && e.key!= 5 && e.key!= 6 && e.key!= 7 && e.key!= 8 && e.key!= 9 && e.keyCode!= 8 && e.keyCode!= 9 && e.keyCode!= 16 && e.keyCode!= 37 && e.keyCode!= 38 && e.keyCode!= 39 && e.keyCode!= 40){
          e.preventDefault();
        }

        if(num.length >= 5 && e.keyCode!= 8 && e.keyCode!= 9 && e.keyCode!= 16 && e.keyCode!= 37 && e.keyCode!= 38 && e.keyCode!= 39 && e.keyCode!= 40){
          e.preventDefault();
        }

    });
    // update();
  });

</script>

<script language="javascript" type="text/javascript">
     $(window).load(function() {
       $('#loading').hide();
    });

    function convertNumberToWords(amount) {
        var words = new Array();
        words[0] = '';
        words[1] = 'One';
        words[2] = 'Two';
        words[3] = 'Three';
        words[4] = 'Four';
        words[5] = 'Five';
        words[6] = 'Six';
        words[7] = 'Seven';
        words[8] = 'Eight';
        words[9] = 'Nine';
        words[10] = 'Ten';
        words[11] = 'Eleven';
        words[12] = 'Twelve';
        words[13] = 'Thirteen';
        words[14] = 'Fourteen';
        words[15] = 'Fifteen';
        words[16] = 'Sixteen';
        words[17] = 'Seventeen';
        words[18] = 'Eighteen';
        words[19] = 'Nineteen';
        words[20] = 'Twenty';
        words[30] = 'Thirty';
        words[40] = 'Forty';
        words[50] = 'Fifty';
        words[60] = 'Sixty';
        words[70] = 'Seventy';
        words[80] = 'Eighty';
        words[90] = 'Ninety';
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Crores ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Lakhs ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Thousand ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "Hundred and ";
                } else if (i == 6 && value != 0) {
                    words_string += "Hundred ";
                }
            }
            words_string = words_string.split("  ").join(" ");
        }
        return words_string;
    }

</script>

<!-- <script language="javascript">
  document.onkeydown = function(e) {
      if(event.keyCode == 123) {
         return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
         return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
         return false;
      }
      if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
         return false;
      }
      if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
         return false;
      }
  }
  
  $(document).bind("contextmenu",function(e) { 
    e.preventDefault();
   
  });

</script> -->

<script>

 $(document).ready(function() {

    $("#main-menu ul > li").click(function(e) {
        $(this).siblings('li.active').removeClass("active");
        $(this).find('li.open').removeClass("open");
        $(this).addClass("active");        
     });

    /*$("#main-menu ul li").click(function(e) {
        $(this).find('li.open').removeClass("open");
        // $(this).addClass("active");        
     });*/

    $('.anchor_cls').on('click', function(){       
       $(this).parent().siblings().find('.mactive').removeClass('mactive');
       $(this).addClass('mactive');
    });
 });
 </script>
</body>
</html>