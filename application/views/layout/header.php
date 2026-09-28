<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <link rel="icon" type="image/ico" href="<?=base_url()?>awedget/assets/img/loopdot.png" />

    <title>Hr | Payroll</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Mysoftheaven (BD) Ltd." name="author" />
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <link href="<?=base_url()?>awedget/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="<?=base_url()?>awedget/assets/plugins/jquery-superbox/css/style.css" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="<?=base_url()?>awedget/assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css"
        media="screen" />
    <link href="<?=base_url()?>awedget/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css"
        media="screen" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/min/dropzone.min.css" rel="stylesheet">

    <link href="<?=base_url()?>awedget/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet"
        type="text/css" />
    <link href="<?=base_url()?>awedget/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css"
        rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>awedget/assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet"
        type="text/css" />
    <link href="<?=base_url()?>awedget/assets/plugins/datatables-responsive/css/datatables.responsive.css"
        rel="stylesheet" type="text/css" media="screen" />
    <link href="<?=base_url()?>awedget/assets/plugins/boostrap-checkbox/css/bootstrap-checkbox.css" rel="stylesheet"
        type="text/css" media="screen" />
    <link href="<?=base_url()?>awedget/assets/plugins/ios-switch/ios7-switch.css" rel="stylesheet" type="text/css"
        media="screen">
    <link href="<?=base_url()?>awedget/assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet"
        type="text/css" media="screen" />
    <link href="<?=base_url()?>awedget/assets/plugins/boostrap-3.3.7/css/bootstrap.min.css" rel="stylesheet"
        type="text/css" />

    <!-- <link href="<?=base_url()?>awedget/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet"
        type="text/css" /> -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="<?=base_url()?>awedget/assets/css/animate.min.css" rel="stylesheet" type="text/css" />

    <link href="<?=base_url()?>awedget/assets/croper/css/cropper.min.css" rel="stylesheet">
    <link href="<?=base_url()?>awedget/assets/croper/css/main.css" rel="stylesheet">

    <!-- BEGIN CSS TEMPLATE -->
    <link href="<?=base_url()?>awedget/assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>awedget/assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <link href="<?=base_url()?>awedget/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css" />
    <script src="<?=base_url()?>awedget/assets/plugins/jquery-3.2.1.min.js" type="text/javascript"></script>

    <!-- new -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- new -->



    <!--data table-->
    <link rel="stylesheet" href="<?php echo base_url('css/dataTables.min.css'); ?>">
    <script src="<?php echo base_url('/js/dataTables.min.js') ?>"></script>
    <!--/.data table-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">



<style>
    *:not(i) {
    font-family: roboto !important;
}
</style>



    <script type="text/javascript">
    var hostname = '<?=base_url()?>';
    </script>

    <style type="text/css">
        /* input[type="text"] {
        font-family:"Helvetica Neue",Helvetica,Arial,"SutonnyMJ";
        } */


    .n_demand {
        position: absolute;
        top: 10px;
        right: 65px;
        font-size: 7px;
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
        font-size: 7px;
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

    .page-sidebar .page-sidebar-wrapper>ul>li>ul.sub-menu li>ul.sub-menu>li>a {
        color: #683091;
    }

    </style>
</head> <!-- END HEAD -->

<style type="text/css">
@font-face {
    font-family: 'Kalpurush,';
    src: url('<?=base_url()?>awedget/assets/fonts/Kalpurush.ttf') format('truetype');
    font-weight: normal;
    font-style: normal;
}

.page-content {
    font-family: 'Kalpurush', 'Open Sans', Arial, sans-serif;
    background: #e5e9ec;
}

.report-table {
    width: 100%;
}

.report-table tr th {
    font-size: 15px;
    text-align: left;
    width: 25%;
    font-weight: normal;
}

.report-table tr td {
    text-align: left;
    width: 25%;
    font-size: 15px;
}

.report-table tr th:nth-child(1),
.report-table tr td:nth-child(1) {
    width: 35%;
}

.report-table tr th:nth-child(2),
.report-table tr td:nth-child(2) {
    width: 20px;
}

.sub-mark {
    width: 5% !important;
}

.new {
    -webkit-box-shadow: 13px 11px 40px 0px rgba(82, 82, 82, 0.43);
    -moz-box-shadow: 13px 11px 40px 0px rgba(82, 82, 82, 0.43);
    box-shadow: 13px 11px 40px 0px rgba(82, 82, 82, 0.43);
}

.new .tiles-title {
    height: 40px;
}

.new .heading {
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

.new1 .heading {
    color: #fff !important;
    background: #9424b8;
}

.new2 tr:nth-child(1),
.new1 .tiles-title {
    color: #9424b8 !important;
}

.new3 tr:nth-child(1) {
    color: #78c72f !important;
}

.new1 .triangle-up {

    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #9424b8;
}

.new2 .heading {
    color: #fff !important;
    background: #00adef;
}

.new1 tr:nth-child(1),
.new2 .tiles-title {
    color: #00adef !important;
}

.new2 .triangle-up {

    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #00adef;
}

.new3 .heading {
    color: #fff !important;
    background: #ff940b;
}

.new4 tr:nth-child(1),
.new3 .tiles-title {
    color: #ff940b !important;
}

.new3 .triangle-up {

    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #ff940b;
}

.new4 .heading {
    color: #fff !important;
    background: #78c72f;
}

.new4 .tiles-title {
    color: #78c72f !important;
}

.new4 .triangle-up {

    border-left: 70px solid transparent;
    border-right: 0px solid transparent;
    border-bottom: 70px solid #78c72f;
}

.grand_total {
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

.head-title {
    font-size: 14px;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
    font-weight: 600;
}

.field,
.field1 {
    position: relative;
}

.field .tiles-title {
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

.field1 .tiles-title {
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

.head-title i {
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

td i {
    color: #9424b8 !important;
    font-size: 12px !important;
}

body {
    background: none !important;
}

.anchor_cls.mactive {
    background: #c3e6e2;
    color: #fff;
}

/* .tablebox {
    box-shadow: 0 0 6px 1px #a9a9a9;
    background: #fbfbfb;
    padding: 14px 14px;
    margin: 0;
    border-radius: 4px;
} */

table.dataTable.no-footer {
    border-bottom: none;
    border-top: none;
}

select {
    height: 29px !important;
    padding: 2px !important;
    border: 1px solid #0aa699 !important;
}

.footer_button {
    justify-content: right;
    display: flex;
    gap: 16px;
    padding-right: 17px;
}

/* .nav_head{
    background: white;
    border-radius: 4px;
    box-shadow: 0 0 3px 2px #b1b1b1;
    align-items: center;
    display: flex;
} */
.nav_head {
    position: relative;
    display: flex;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border-radius: 4px;
    padding: 14px 14px;
    margin: 0;
    align-items: center;
    box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    -webkit-box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    -moz-box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    -ms-box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    background-image: linear-gradient(to top, #f1f2f5, rgba(255, 255, 255, 0)), linear-gradient(to bottom, #f6f6f9, #f6f6f9);
    border: 1px solid #eeeef0;
}

.bg_none {
    background: none;
}

input {
    border-radius: 4px !important;
}

.btn {
    font-weight: bold;
}

.tablebox {
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #fff;
    background-clip: border-box;
    border: 1px solid #e7eaed;
    border-radius: 4px;
    padding: 14px 14px;
    margin: 0;
}

.tablebox {
    box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    -webkit-box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    -moz-box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    -ms-box-shadow: 4px 4px 10px 0 rgba(0, 0, 0, 0.08), -5px -6px 10px 0 rgb(205 205 205 / 90%);
    background-image: linear-gradient(to top, #f1f2f5, rgba(255, 255, 255, 0)), linear-gradient(to bottom, #f6f6f9, #f6f6f9);
    border: 1px solid #eeeef0;
}
</style>

<style>
    .bfont {
        font-family: SutonnyMJ !important;
        font-size: 15px !important;
    }
</style>
