<style>
    .inputs{
        background: white !important;
        width: 100% !important;

    }
    td{
        text-align: center;
        vertical-align: middle !important;
        padding: 0px !important;
    }
    .form-control {
        width: 60%;
        display: inline-block !important;
        text-align: center;
        min-height: 25px !important;
    }
    .tables th, .tables td{
        padding: 0px !important;
    }
    input[type=number] {
        -moz-appearance: textfield;
        appearance: textfield;
        font-size: 15px;
        font-family: SutonnyMJ;
    }
</style>

<div class="content">
<nav class="navbar navbar-inverse bg_none">
    <div class="container-fluid nav_head">
        <div class="navbar-header col-md-5">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div>
                <a class="btn btn-info" href="<?php echo base_url('entry_system_con/left_resign_entry') ?>">Add Resign</a>
                <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
            </div>
        </div>
        <div class="col-md-7">
            <div id="navbar" class="navbar-collapse collapse">
                <div class="">
                    <form class="navbar-form pull-right" role="search">
                        <div class="input-group">
                            <input id="deptSearch" type="text" class="form-control" placeholder="Search">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</nav>
<div class="row">
    <div class="col-md-12">
        <?php $success = $this->session->flashdata('success');
            if ($success != "") { ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
            $failuer = $this->session->flashdata('failuer');
            if ($failuer) { ?>
            <div class="alert alert-failuer"><?php echo $failuer; ?></div>
        <?php } ?>
    </div>
</div>
<!-- <br> -->
<div class="row tablebox">

    <div class="col-md-12">
        <table class="table table-striped text-center" id="">
            <thead class="text-center">
                <tr class="text-center">
                    <th class="text-center">SL</th>
                    <th class="text-center">Emp Name </th>
                    <th class="text-center">Emp Id</th>
                    <th class="text-center">Unit name</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            </thead>

            <tbody id="tbody">
                <!-- <?php
                if (!empty($results)) {foreach ($results as $key => $r) {?>
                <tr>
                    <td style="padding: 1px !important;" ><?php echo $key + 1  ?></td>
                    <td style="padding: 1px !important;" ><?php echo $r->user_name ?></td>
                    <td style="padding: 1px !important;" ><?php echo $r->emp_id ?></td>
                    <td style="padding: 1px !important;" ><?php echo $r->unit_name ?></td>
                    <td style="padding: 1px !important;" ><?php echo date('d-m-Y', strtotime($r->resign_date))?></td>
                    <td style="padding: 1px !important;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <?php
                                    $user_id = $this->session->userdata('data')->id;
                                    $acl = check_acl_list($user_id);
                                ?>
                                <?php if($r->status == 1){?>
                                <?php if(in_array(116,$acl)) { ?>
                                <li><a class="btn btn-sm" onclick="report(<?= $r->emp_id ?>, 1)">Satalement Acc</a></li>
                                <?php } ?>
                                <?php if(in_array(117,$acl)) { ?>
                                    <li><a class="btn btn-sm" onclick="report(<?= $r->emp_id ?>, 2)">Final Satalement 7pm </a></li>
                                <?php } ?>
                                <?php if(in_array(118,$acl)) { ?>
                                <li><a class="btn btn-sm" onclick="report(<?= $r->emp_id ?>, 3)">Final Satalement 9pm</a></li>
                                <?php } ?>
                                <?php if(in_array(119,$acl)) { ?>
                                <li><a class="btn btn-sm" onclick="report(<?= $r->emp_id ?>, 4)">Satalement 12am</a></li>
                                <?php } ?>
                                <?php if(in_array(120,$acl)) { ?>
                                <li><a class="btn btn-sm" onclick="report(<?= $r->emp_id ?>, 5)">Satalement(W/H)</a></li>
                                <?php } ?>
                                <?php }else{ ?>
                                <li><a class="btn btn-sm" data-toggle="modal" data-target="#myModal" onclick="final_satalment(<?= $r->emp_id ?>)">Add Final Satalment</a></li>
                                <?php }?>
                                <li><a class="btn btn-sm" href="<?=base_url('entry_system_con/resign_delete/'.$r->emp_id)?>">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php }} else {?>

                <tr>
                    <td colspan="12">Records not Found</td>
                </tr>
                <?php }?> -->

            </tbody>
        </table>
    </div>
</div>
<br><br>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title h4" id="myModalLabel"> Final Satalment</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="post" id="form">
                    <input type="hidden" name="form_id" id="form_id">
                    <div class="row" style="font-size: 15px;">
                        <div class="col-md-4">
                            নাম	:	<span id="full_name"></span>
                        </div>
                        <div class="col-md-4">
                            কার্ড	:	<span id="card_no" style="font-family: SutonnyMJ;"></span>
                        </div>
                        <div class="col-md-4">
                            পদবী	:	<span id="designation_name"></span>
                        </div>
                    </div>
                    <div class="row" style="font-size: 15px;">
                        <div class="col-md-4">
                            সেকশন	:	<span id="section_name"></span>
                        </div>
                        <div class="col-md-4">
                            যোগদানের তারিখ	:	<span id="joining_date" style="font-family: SutonnyMJ;"></span> ইং

                        </div>
                        <div class="col-md-4">
                            শেষ কর্মদিবস	:	<span id="last_working_date" style="font-family: SutonnyMJ;"> </span> ইং
                        </div>
                    </div>
                    <div class="row" style="font-size: 15px;">
                        <div class="col-md-4">
                            চাকুরীকাল	:	<span id="job_duration"> </span>
                        </div>
                        <div class="col-md-4">
                            মোট বেতন	:	<span id="gross_salary" style="font-family:SutonnyMJ"> </span> টাকা
                        </div>
                        <div class="col-md-4">
                            মূল বেতন	:	<span id="basic_salary" style="font-family:SutonnyMJ"> </span> টাকা
                        </div>
                    </div>
                    <div class="row" style="font-size: 15px;">
                        <div class="col-md-4">
                            প্রতি ঘন্টার ওভার টাইম হার	:	<span id="ot_rate" style="font-family:SutonnyMJ"> </span> টাকা
                    </div>

                    <table class="table table-bordered ml-3 inputs tables" style="border: 1px solid #d6d1d1 !important;">
                        <tr class="text-center">
                            <th class="text-center" style="border: 1px solid #d6d1d1 !important;">বিষয় </th>
                            <th class="text-center" style="border: 1px solid #d6d1d1 !important;">দিন/ ঘন্টা </th>
                            <th class="text-center" style="border: 1px solid #d6d1d1 !important;">হার </th>
                            <th class="text-center" style="border: 1px solid #d6d1d1 !important;">টাকা</th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important; width:51%;">চাকুরী হইতে অবসান এর নোটিশ পে বাংলাদেশ শ্রম আইন ২০০৬ এর ধারা ২৬ (১)</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><input type="number" class="form-control" name="resign_pay_day" id="resign_pay_day" onkeyup=first_r()></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="service_benifit_rate" id="service_benifit_rate" style="font-size: 15px;font-family: SutonnyMJ;"></span></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="total_resign_pay_day" id="total_resign_pay_day" style="font-size: 15px;font-family: SutonnyMJ;" min="0"></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important;">অতিরিক্ত ক্ষতিপূরণ </td>
                            <td style="border: 1px solid #d6d1d1 !important;"><input type="number" class="form-control" name="extra_payoff" id="extra_payoff" onkeyup=second_r()></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="service_benifit_rate" style="font-size: 15px;font-family: SutonnyMJ;"></span></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="total_extra_payoff" id="total_extra_payoff" style="font-size: 15px;font-family: SutonnyMJ;"></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important;">জমাকৃত অর্জিত ছুটির দিন উপস্থিতি</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><input type="number" style="font-family:SutonnyMJ;font-size: 15px;" id="earn_leave_day" class="earn_leave form-control" onkeyup=third_r()></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span style="font-family:SutonnyMJ;font-size: 15px;" class="per_day_rate"></span></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span style="font-family:SutonnyMJ;font-size: 15px;" class="total_earn_leave" id="total_earn_leave"></span></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important;" colspan="3">অন্যান্য পাওনাদি</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><input type="number" class="another_deposit form-control" name="another_deposit" id="another_deposit" onkeyup=parshial_mot()></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important;" colspan="3">মোট প্রাপ্য টাকা</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span id="total_get" style="font-family:sutonnyMJ;font-size: 15px;"></span"></td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important;" colspan="4">কর্তন</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #d6d1d1 !important;">নোটিশ পিরিয়ড কম বা না দেয়ার কারনে কোম্পানীর প্রাপ্য বাবদ কর্তন (মোট মজুরি থেকে)</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><input type="number" class="form-control" name="notice_deduct" id="notice_deduct" onkeyup=noticeDeduct() ></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="service_benifit_rate" style="font-size: 15px;font-family: SutonnyMJ;"></span></td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="total_notice_deduct_rate" id="total_notice_deduct_rate" style="font-size: 15px;font-family: SutonnyMJ;"></span></td>
                        </tr>
                            <tr>
                            <td colspan="3" style="border: 1px solid #d6d1d1 !important;">অগ্রীম বেতন</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><input type="number" class="form-control" name="advanced_salary" id="advanced_salary"  onkeyup=total_deduct()></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 1px solid #d6d1d1 !important;">মোট কর্তন</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span class="total_deduct" style="font-size: 15px;font-family: SutonnyMJ;"></span></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="border: 1px solid #d6d1d1 !important;">নিট প্রাপ্য / প্রদেয় টাকা</td>
                            <td style="border: 1px solid #d6d1d1 !important;"><span id="net_pay" style="font-family: SutonnyMJ;font-size: 15px"></span"></td>
                        </tr>
                    </table>
                    <input type="hidden" id="hidden_gross_salary" name="hidden_gross_salary">
                    <input type="hidden" id="hidden_basic_salary" name="hidden_basic_salary">
                    <input type="hidden" id="hidden_ot_rate" name="hidden_ot_rate">
                    <input type="hidden" id="service_benifit" name="service_benifit">
                    <input type="hidden" id="service_benifit" name="service_benifit">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-primary" id="save_button">Save</button>
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>

<!-- <script type="text/javascript">
$(document).ready(function() {
    $("#mytable").dataTable();
    $('#mytable_filter').css({
        "display": "none"
    })
    $('#mytable_length').css({
        "display": "none"
    })
    $("#mytable").dataTable();
    oTable = $('#mytable').DataTable();
    $('#deptSearch').keyup(function() {
        oTable.search($(this).val()).draw();
    })
});
</script> -->
<script>
$('#myModal').on('hidden.bs.modal', function () {
    $(this).find("input,textarea,select").val('').end().find("input[type=checkbox], input[type=radio]").prop("checked", "").end().find("option:selected").removeAttr("selected");
})
function final_satalment(id) {
    // $('#form').reset();
        document.getElementById("form").reset();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>grid_con/final_satalment",
        data: {id: id},
        success: function (data) {
            $('#form_id').val(id);
            var employeeData = JSON.parse(data);
            $("#full_name").html(employeeData.name_bn);
            $("#card_no").html(employeeData.emp_id);
            $("#designation_name").html(employeeData.desig_bangla);
            $("#section_name").html(employeeData.sec_name_bn);
            $("#year").html(employeeData.resign_year);
            $("#joining_date").html(employeeData.emp_join_date.split('-').reverse().join('-'));
            var d = new Date(employeeData.resign_date);
            var bnMonths = ["জানুয়ারি", "ফেব্রুয়ারি", "মার্চ", "এপ্রিল", "মে", "জুন", "জুলাই", "আগস্ট", "সেপ্টেম্বর", "অক্টোবর", "নভেম্বর", "ডিসেম্বর"];
            var resign_date = d.toLocaleString('bn-BD', { year: 'numeric', month: 'long' });
            var year_str = "<span style='font-family:sutonnyMJ;font-size:16px'>"+d.getFullYear()+'</span>';

            $("#resign_date").html(bnMonths[d.getMonth()] + " " + year_str);
            $("#last_working_date").html(d.toLocaleString('en-US', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/[^0-9]/g, "-").replace(/^(..)-(..)-(....)$/, "$2-$1-$3"));
            $("#job_duration").html(calculateJobDuration(employeeData.emp_join_date, employeeData.resign_date));
            $("#gross_salary").html(employeeData.gross_sal);
            $("#basic_salary").html(employeeData.basic_sal);
            $("#ot_rate").html(employeeData.ot_rate);
            $("#hidden_gross_salary").val(employeeData.gross_sal);
            $("#hidden_basic_salary").val(employeeData.basic_sal);
            $("#hidden_ot_rate").val(employeeData.ot_rate);
            $("#resign_pay_day").val(0);
            $("#extra_payoff").val(0);
            $("#earn_leave_day").val(0);
            $("#another_deposit").val(0);
            $("#notice_deduct").val(0);
            $("#advanced_salary").val(0);
            $("#service_benifit").val(calculateServiceBenifit(employeeData.emp_join_date, employeeData.resign_date));
        },
        complete: function () {
            first_r();
            second_r();
            third_r();
        }
    });
}

// Function to calculate job duration
function calculateJobDuration(startDate, endDate) {
    var start = new Date(startDate);
    var end = new Date(endDate);
    var duration = end - start;
    var days = duration / (1000 * 60 * 60 * 24);
    var years = Math.floor(days / 365);
    days = days % 365;
    var months = Math.floor(days / 30);
    days = days % 30;
    return "<span style='font-family:SutonnyMJ'> " + years + " </span>  বছর <span style='font-family:SutonnyMJ'>" + months + "</span> মাস <span style='font-family:SutonnyMJ'>" + days + "</span> দিন";
}
function calculatePerDayRate(grossSalary) {
    var basic = ((parseFloat(grossSalary)/30));
    return basic.toFixed(2);
}
function calculateServiceBenifit(startDate, endDate) {
    var start = new Date(startDate);
    var end = new Date(endDate);
    var duration = end - start;
    var days = duration / (1000 * 60 * 60 * 24);
    var years = Math.floor(days / 365);
    //var years = 18;
    days = days % 365;
    var months = Math.floor(days / 30);
    // var months = 5;
    // alert(months);return false;

    days = days % 30;
    if(years >=4 && months >=10){
    // alert("4 yeasr and 10 months");
        return 14*5;
    }
    if (years >= 5) {
    // alert("6 years");
        if (months < 11) {
            if (years > 9) {
                return 30*years;
            }else{
                return 14*years;
            }
        }else if(months > 11) {
                if (years > 9) {
                return 30*(years++);
            }else{
                return 14*years;
            }
        }
    }else{
        return 0;
    }
}

function first_r(){
    console.log('sdkjfn');
    var resign_pay_day=$('#resign_pay_day').val();
    var basic_salary=Number($('#basic_salary').html());
    var har=basic_salary/30;
    var har=har.toFixed(2);
    var pay=har*resign_pay_day;
    var pay=pay.toFixed(2);
    $('#total_resign_pay_day').html(pay);
    $('.service_benifit_rate').html(har);
    parshial_mot()
}
function second_r(){
    var extra_payoff=$('#extra_payoff').val();
    var basic_salary=Number($('#basic_salary').html());
    var har=basic_salary/30;
    var har=har.toFixed(2);
    var pay=har*extra_payoff;
    var pay=pay.toFixed(2);

    $('#total_extra_payoff').html(pay);
    $('.service_benifit_rate').html(har);
    parshial_mot()
}
function third_r(){
    var extra_payoff=$('#earn_leave_day').val();
    var ette=Number(extra_payoff)/18;
    var extra_payoff=ette.toFixed(2);
    var gross_salary=Number($('#gross_salary').html());
    var har=gross_salary/30;
    var har=har.toFixed(2);
    var pay=har*extra_payoff;
    var pay=pay.toFixed(2);

    $('#total_earn_leave').html(pay);
    $('.per_day_rate').html(extra_payoff);
    parshial_mot()
}

function parshial_mot(){
        var another_deposit=Number($('#another_deposit').val());
    another_deposit=isNaN(another_deposit) ? 0 : another_deposit;
        var total_earn_leave=Number($('#total_earn_leave').html());
    total_earn_leave=isNaN(total_earn_leave) ? 0 : total_earn_leave;
        var total_extra_payoff=Number($('#total_extra_payoff').html());
    total_extra_payoff=isNaN(total_extra_payoff) ? 0 : total_extra_payoff;
        var total_resign_pay_day=Number($('#total_resign_pay_day').html());
    total_resign_pay_day=isNaN(total_resign_pay_day) ? 0 : total_resign_pay_day;
        var total=another_deposit+total_earn_leave+total_extra_payoff+total_resign_pay_day;
        total=total.toFixed(2);
        $('#total_get').html(total);
        mot_total()
}

function noticeDeduct() {
    var noticeDeduct = parseFloat($('#notice_deduct').val());
    noticeDeduct = isNaN(noticeDeduct) ? 0 : noticeDeduct;
    var basic_salary=Number($('#basic_salary').html());

        var har=basic_salary/30;
        var har=har.toFixed(2);
        var pay=har*noticeDeduct;
        var pay=pay.toFixed(2);

        $('#total_notice_deduct_rate').html(pay);
        total_deduct()
}

function total_deduct() {
        var total_notice_deduct_rate = parseFloat($('#total_notice_deduct_rate').html() || 0);
        var advanced_salary=parseFloat($('#advanced_salary').val() || 0);
        var total_deduct = advanced_salary + total_notice_deduct_rate;
        $('.total_deduct').html(advanced_salary+total_notice_deduct_rate);
        mot_total()
}

function mot_total() {
        var total_get = parseFloat($('#total_get').html() || 0);
        var total_deduct = parseFloat($('.total_deduct').html() || 0);
        console.log(total_deduct);
        var mot_total = total_get - total_deduct;
        console.log('mot_total'+mot_total);
        $('#net_pay').html(mot_total.toFixed(2));
}

$('#save_button').on('click', function() {
    var formData = {
        'form_id'               : $("#form_id").val(),
        'emp_id'                : $("#card_no").html(),
        'gross_salary'          : $("#gross_salary").html(),
        'basic_salary'          : $("#basic_salary").html(),
        'ot_rate'               : $("#ot_rate").html(),
        'hidden_gross_salary'   : $("#hidden_gross_salary").val(),
        'hidden_basic_salary'   : $("#hidden_basic_salary").val(),
        'hidden_ot_rate'        : $("#hidden_ot_rate").val(),
        'resign_pay_day'        : $("#resign_pay_day").val(),
        'extra_payoff'          : $("#extra_payoff").val(),
        'earn_leave_day'        : $("#earn_leave_day").val(),
        'another_deposit'       : $("#another_deposit").val(),
        'notice_deduct'         : $("#notice_deduct").val(),
        'advanced_salary'       : $("#advanced_salary").val(),
        'service_benifit'       : $("#service_benifit").val(),
    };
    $.ajax({
        url: "<?php echo base_url('entry_system_con/add_final_satalment'); ?>",
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (data) {
            var dataObj = (typeof data == "string") ? JSON.parse(data) : data;
            if(dataObj.success == true){
                Swal.fire({
                icon: 'success',
                title: "Added Successfully"
                }).then((result) => {
                    window.location.href = window.location.href;
                    setTimeout(function(){ $('#myModal').modal('hide'); }, 500);
                });
            }
        },
        error: function(jqXHR, exception) {
            console.error('jqXHR:', jqXHR);
            console.error('exception:', exception);
        }
    });
});

function report(id, type){
    // alert(id);
    $.ajax({
        url: "<?php echo base_url('grid_con/grid_final_satalment'); ?>",
        type: 'POST',
        data: {spl: id, type: type},
        success: function (data) {
            var win = window.open('', '_blank', 'height=800,width=1024,scrollbars=yes,resizable=yes,toolbar=no,location=no,directories=no,status=no,menubar=no,top=10,left=10');
            win.document.write(data);
            win.document.close();
        },
        error: function(jqXHR, exception) {
            console.error('jqXHR:', jqXHR);
            console.error('exception:', exception);
        }
    });
}
</script>




<!-- lazy loading script -->
<script>
    var offset = 0
    var limit = 15
    var i = 0
    $(document).ready(function() {
        get_data(offset)
    })
    var e=true;
    function get_data(offset=0) {
        if(e===false){
            return false
        }else{
            e=false
        }

        var deptSearch = $('#deptSearch').val()
        $.ajax({
            url: "<?php echo base_url('entry_system_con/resign_list_ajax') ?>",
            type: "post",
            data: {
                offset: offset,
                limit: limit,
                deptSearch: deptSearch
            },
            success: function(data) {
                var obj = JSON.parse(data)
            // console.log('data=?'+obj);
                //var i = offset
                    <?php
                        $user_id = $this->session->userdata('data')->id;
                        $acl = check_acl_list($user_id);
                    ?>
                obj.forEach(element => {
                    var lid = ''

                    if (element.status == 1) {
                        <?php if(in_array(116,$acl)) { ?>
                        lid+= `<li><a class="btn btn-sm" onclick="report(${element.emp_id}, 1)">Satalement Acc</a></li>`
                        <?php } ?>
                        <?php if(in_array(117,$acl)) { ?>
                            lid+= `<li><a class="btn btn-sm" onclick="report(${element.emp_id}, 2)">Final Satalement 7pm </a></li>`
                        <?php } ?>
                        <?php if(in_array(118,$acl)) { ?>
                        lid+= `<li><a class="btn btn-sm" onclick="report(${element.emp_id}, 3)">Final Satalement 9pm</a></li>`
                        <?php } ?>
                        <?php if(in_array(119,$acl)) { ?>
                        lid+= `<li><a class="btn btn-sm" onclick="report(${element.emp_id}, 4)">Satalement 12am</a></li>`
                        <?php } ?>
                        <?php if(in_array(120,$acl)) { ?>
                        lid+= `<li><a class="btn btn-sm" onclick="report(${element.emp_id}, 5)">Satalement(W/H)</a></li>`
                        <?php } ?>
                    }else{
                        lid+= `<li><a class="btn btn-sm" data-toggle="modal" data-target="#myModal" onclick="final_satalment(${element.emp_id})">Add Final Satalment</a></li>`
                    }
                    lid+= `<li><a class="btn btn-sm" href="<?=base_url('entry_system_con/resign_delete/')?>${element.emp_id}">Delete</a></li>`

                    $('#tbody').append(`<tr>
                    <td>${++i}</td>
                    <td style="padding: 1px !important;" >${element.user_name}</td>
                        <td style="padding: 1px !important;" >${element.emp_id}</td>
                        <td style="padding: 1px !important;" >${element.unit_name}</td>
                        <td style="padding: 1px !important;" >${element.resign_date}</td>
                        <td style="padding: 1px !important;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                        $user_id = $this->session->userdata('data')->id;
                                        $acl = check_acl_list($user_id);
                                    ?>
                                    ${lid}
                                </ul>
                            </div>
                        </td>


                </tr>`)
                });
            },
            complete: function() {
                e = true
            }
        })
    }
    window.onscroll = function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            offset += limit
            get_data(offset)
        }
    }

    $('#deptSearch').keyup(function() {
        $('#tbody').empty()
        offset = 0
        i = 0
        get_data(offset)
        $('#tbody').empty()
    })
</script>
