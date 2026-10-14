<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #f4f6f8;
        color: #333;
        padding: 20px;
    }

    /* Dashboard Cards */
    .dash-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
        flex-wrap: wrap;
    }

    .dash-card {
        background: #fff;
        flex: 1;
        min-width: 290px;
        display: flex;
        height: 117px;
    }


    .dash-card__icon {
        padding: 16px 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .dash-card__icon i {
        font-size: 2em;
        color: #fff;
    }

    .dash-card__content {
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }




    .dash-card__row {
        display: flex;
        height: 50%;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0px 0px 2px 0px #828282;
        padding: 11px 33px;
    }

    .dash-card__title {
        font-size: 16px;
        font-weight: 400;
        color: #070707;
    }

    .dash-card__value {
        font-family: Roboto;
        font-weight: 600;
        font-size: 20px;
        line-height: 150%;
        letter-spacing: 0%;
        color: #000000;
    }




    .dash-card--blue .dash-card__icon {
        background: #009bbd;
    }

    .dash-card--green .dash-card__icon {
        background: #448644;
    }

    .dash-card--blue2 .dash-card__icon {
        background: #4b87f9;
    }

    /* Dashboard Stats */
    .dash-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .dash-stat {
        background: #fff;
        border: 1px solid #e0e0e0;
    }

    .dash-stat--total {}

    .dash-stat--today {}

    .dash-stat--current {}

    .dash-stat--prev {}

    .dash-stat__header {
        padding: 8px 12px;
        font-weight: bold;
        color: #fff;
    }

    .dash-stat--total .dash-stat__header {
        background: #7c0b22;
    }

    .dash-stat--today .dash-stat__header {
        background: #7c1478;
    }

    .dash-stat--current .dash-stat__header {
        background: #1e4486;
    }

    .dash-stat--prev .dash-stat__header {
        background: #00732e;
    }

    .dash-stat__list {
        list-style: none;
        padding: 12px;
    }


    .dash-stat__item {
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        border: 1px solid #e1e1e1;
        padding: 3px;
    }

    .dash-bullet {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin-right: 8px;
        border-radius: 50%;
    }

    .dash-stat--total .dash-bullet {
        background: #60c94f;
    }

    .dash-stat--total:nth-child(2) .dash-bullet {
        background: #e02424;
    }

    .dash-stat--total:nth-child(3) .dash-bullet {
        background: #5b5bdc;
    }

    .dash-stat--total:nth-child(4) .dash-bullet {
        background: #7c1478;
    }

    .dash-stat--today .dash-bullet {
        background: #60c94f;
    }

    .dash-stat--today:nth-child(2) .dash-bullet {
        background: #e02424;
    }

    .dash-stat--today:nth-child(3) .dash-bullet {
        background: #5b5bdc;
    }

    .dash-stat--today:nth-child(4) .dash-bullet {
        background: #7c1478;
    }

    .dash-stat--current .dash-bullet {
        background: #60c94f;
    }

    .dash-stat--current:nth-child(2) .dash-bullet {
        background: #e02424;
    }

    .dash-stat--current:nth-child(3) .dash-bullet {
        background: #5b5bdc;
    }

    .dash-stat--current:nth-child(4) .dash-bullet {
        background: #7c1478;
    }

    .dash-stat--prev .dash-bullet {
        background: #60c94f;
    }

    .dash-stat--prev:nth-child(2) .dash-bullet {
        background: #e02424;
    }

    .dash-stat--prev:nth-child(3) .dash-bullet {
        background: #5b5bdc;
    }

    .dash-stat--prev:nth-child(4) .dash-bullet {
        background: #7c1478;
    }

    .dash-stat__label {
        flex: 1;
        color: #444;
    }

    .dash-stat__value {
        font-weight: bold;
    }

    .pichart_main {}

    .piechart_c {
        height: 276px !important;
        background: #ffffff;
        padding: 27px;
        margin-bottom: 13px;
    }

    /* Clickable styling for cards and stats */
    .dash-card__row.clickable-card {
        cursor: pointer;
        position: relative;
        transition: background-color 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
        user-select: none;
    }
    .dash-card__row.clickable-card:hover {
        background-color: #f0f7ff;
        box-shadow: inset 4px 0 0 #009bbd;
    }
    .dash-card--green .dash-card__row.clickable-card:hover {
        box-shadow: inset 4px 0 0 #448644;
    }
    .dash-card--blue2 .dash-card__row.clickable-card:hover {
        box-shadow: inset 4px 0 0 #4b87f9;
    }

    .dash-stat__item.clickable-stat {
        cursor: pointer;
        transition: background-color 0.2s ease, transform 0.15s ease, border-color 0.2s ease;
        user-select: none;
    }
    .dash-stat__item.clickable-stat:hover {
        background-color: #f2f7fc;
        border-color: #0177bc;
        transform: translateX(3px);
    }
    .dash-stat--total .dash-stat__item.clickable-stat:hover {
        border-left: 3px solid #7c0b22;
    }
    .dash-stat--today .dash-stat__item.clickable-stat:hover {
        border-left: 3px solid #7c1478;
    }
    .dash-stat--current .dash-stat__item.clickable-stat:hover {
        border-left: 3px solid #1e4486;
    }

    /* Modal Header & Table Styling */
    #dashDetailsModal .modal-header {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: linear-gradient(135deg, #0177bc 0%, #005691 100%) !important;
        color: #ffffff !important;
        padding: 14px 20px !important;
        border-bottom: none !important;
    }
    #dashDetailsModal .modal-header:before,
    #dashDetailsModal .modal-header:after {
        display: none !important;
    }
    #dashDetailsModal .modal-header .close {
        color: #ffffff !important;
        opacity: 0.9 !important;
        font-size: 26px !important;
        text-shadow: none !important;
        line-height: 1 !important;
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
        cursor: pointer;
        transition: opacity 0.2s ease, transform 0.2s ease;
    }
    #dashDetailsModal .modal-header .close:hover {
        opacity: 1 !important;
        transform: scale(1.15);
    }
    #dashDetailsTable thead th {
        background-color: #0177bc !important;
        color: #ffffff !important;
        font-weight: 600;
        font-size: 12px;
        position: sticky;
        top: 0;
        z-index: 10;
        border-color: #01629b !important;
        white-space: nowrap;
        vertical-align: middle;
        text-align: center;
    }
    #dashDetailsTable tbody td {
        vertical-align: middle;
        font-size: 12px;
    }
    #dashDetailsTable tbody tr:hover {
        background-color: #f5faff !important;
    }
</style>

<div class="content">
    <!-- Top Cards -->
    <div class="dash-cards">
        <div class="dash-card dash-card--blue">
            <div class="dash-card__icon"><i class="fa fa-users"></i></div>
            <div class="dash-card__content">
                <div class="dash-card__row clickable-card" data-type="staff" data-title="Total Staff List" data-modal-icon="fa-users" title="Click to view Staff List">
                    <span class="dash-card__title">Total Staff</span>
                    <span class="dash-card__value" id="total_staff">0</span>
                </div>
                <div class="dash-card__row clickable-card" data-type="worker" data-title="Total Worker List" data-modal-icon="fa-wrench" title="Click to view Worker List">
                    <span class="dash-card__title">Total Worker</span>
                    <span class="dash-card__value" id="total_worker">0</span>
                </div>
            </div>
        </div>
        <div class="dash-card dash-card--green">
            <div class="dash-card__icon"><i class="fa fa-university"></i></div>
            <div class="dash-card__content">
                <div class="dash-card__row clickable-card" data-type="department" data-title="Departments List" data-modal-icon="fa-university" title="Click to view Departments">
                    <span class="dash-card__title">Department</span>
                    <span class="dash-card__value" id="total_department">0</span>
                </div>
                <div class="dash-card__row clickable-card" data-type="designation" data-title="Designations List" data-modal-icon="fa-id-badge" title="Click to view Designations">
                    <span class="dash-card__title">Designation</span>
                    <span class="dash-card__value" id="total_designation">0</span>
                </div>
            </div>
        </div>
        <div class="dash-card dash-card--blue2">
            <div class="dash-card__icon"><i class="fa fa-id-card-o"></i></div>
            <div class="dash-card__content">
                <div class="dash-card__row clickable-card" data-type="section" data-title="Sections List" data-modal-icon="fa-id-card-o" title="Click to view Sections">
                    <span class="dash-card__title">Section</span>
                    <span class="dash-card__value" id="total_section">0</span>
                </div>
                <div class="dash-card__row clickable-card" data-type="others" data-title="Lines / Others List" data-modal-icon="fa-sitemap" title="Click to view Lines / Others">
                    <span class="dash-card__title">Others</span>
                    <span class="dash-card__value" id="total_others">0</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="dash-stats">
        <div class="dash-stat dash-stat--total">
            <div class="dash-stat__header"><i class="fa fa-table"></i> Total Manpower</div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item clickable-stat" data-type="employee" data-title="Total Active Employees" data-modal-icon="fa-users" title="Click to view All Active Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Total Employee</span>
                    <span class="dash-stat__value" id="total_employee">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="male" data-title="Total Male Employees" data-modal-icon="fa-male" title="Click to view Male Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Total Male</span>
                    <span class="dash-stat__value" id="total_male">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="female" data-title="Total Female Employees" data-modal-icon="fa-female" title="Click to view Female Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Total Female</span>
                    <span class="dash-stat__value" id="total_female">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="common" data-title="Total Common Employees" data-modal-icon="fa-user" title="Click to view Common Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Total Common</span>
                    <span class="dash-stat__value" id="total_common">0</span>
                </li>
            </ul>
        </div>
        <div class="dash-stat dash-stat--today">
            <div class="dash-stat__header"><i class="fa fa-calendar"></i> Today Attendance</div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item clickable-stat" data-type="present" data-title="Today's Present Employees" data-modal-icon="fa-check-circle" title="Click to view Today's Present Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Present</span>
                    <span class="dash-stat__value" id="total_present">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="absent" data-title="Today's Absent Employees" data-modal-icon="fa-times-circle" title="Click to view Today's Absent Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Absent</span>
                    <span class="dash-stat__value" id="total_absent">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="leave" data-title="Today's Employees on Leave" data-modal-icon="fa-calendar-minus-o" title="Click to view Employees on Leave">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Leave</span>
                    <span class="dash-stat__value" id="total_leave">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="late" data-title="Today's Late Employees" data-modal-icon="fa-clock-o" title="Click to view Today's Late Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Late</span>
                    <span class="dash-stat__value" id="total_late">0</span>
                </li>
            </ul>
        </div>
        <div class="dash-stat dash-stat--current">
            <div class="dash-stat__header"><i class="fa fa-bell"></i> Current Month Status</div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item clickable-stat" data-type="regular" data-title="Current Month Regular Employees" data-modal-icon="fa-check" title="Click to view Regular Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Regular</span>
                    <span class="dash-stat__value" id="total_regular">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="new_join" data-title="Current Month New Joined Employees" data-modal-icon="fa-user-plus" title="Click to view New Join Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">New Join</span>
                    <span class="dash-stat__value" id="total_new_join">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="resign" data-title="Current Month Resigned Employees" data-modal-icon="fa-user-times" title="Click to view Resigned Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Resign</span>
                    <span class="dash-stat__value" id="total_resign">0</span>
                </li>
                <li class="dash-stat__item clickable-stat" data-type="lefty" data-title="Current Month Left Employees" data-modal-icon="fa-sign-out" title="Click to view Left Employees">
                    <span class="dash-bullet"></span>
                    <span class="dash-stat__label">Lefty</span>
                    <span class="dash-stat__value" id="total_lefty">0</span>
                </li>
            </ul>
        </div>
        <div class="dash-stat dash-stat--prev">
            <div class="dash-stat__header"><i class="fa fa-address-book" aria-hidden="true"></i> Previous Month Summary
            </div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Salary</span><span class="dash-stat__value"
                        id="total_salary">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Overtime</span><span class="dash-stat__value"
                        id="total_overtime">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Ext.
                        Overtime</span><span class="dash-stat__value" id="total_ext_overtime"></span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Attn.
                        Bonus</span><span class="dash-stat__value" id="total_attn_bonus">0</span></li>
            </ul>
        </div>
    </div>

    <!-- Dashboard Details Modal -->
    <div class="modal fade" id="dashDetailsModal" tabindex="-1" role="dialog" aria-labelledby="dashDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 92%; max-width: 1250px; margin: 30px auto;">
            <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 10px 35px rgba(0,0,0,0.25); overflow: hidden;">
                <div class="modal-header">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <button type="button" id="dashModalBackBtn" class="btn btn-xs btn-default" style="display: none; font-weight: 600; margin-right: 8px;">
                            <i class="fa fa-arrow-left"></i> Back
                        </button>
                        <i id="dashModalIcon" class="fa fa-list-alt" style="font-size: 20px;"></i>
                        <h4 class="modal-title" style="font-weight: 600; font-size: 17px; margin: 0; color: #fff;">
                            <span id="dashModalTitle">Details</span>
                        </h4>
                        <span id="dashModalBadge" class="badge" style="background: #ffc107; color: #111; font-size: 13px; font-weight: bold; padding: 4px 9px;">0</span>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding: 16px 20px; background: #fdfdfd;">
                    <!-- Filter Bar inside Modal -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; gap: 15px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 250px; position: relative;">
                            <input type="text" id="dashModalSearch" class="form-control input-sm" placeholder="Search by ID, Name, Department, Designation, Mobile..." style="padding-left: 30px; border-radius: 4px; box-shadow: none; border-color: #ccd0d4;">
                            <i class="fa fa-search" style="position: absolute; left: 10px; top: 9px; color: #999;"></i>
                        </div>
                        <div style="font-size: 13px; color: #666; font-weight: 500;">
                            <span id="dashModalSubtitle"></span> | Total Records: <strong id="dashModalFilteredCount" style="color: #0177bc;">0</strong>
                        </div>
                    </div>

                    <!-- Table Container with sticky header & smooth scroll -->
                    <div id="dashModalTableContainer" style="max-height: 480px; overflow-y: auto; border: 1px solid #e1e4e8; border-radius: 4px;">
                        <table class="table table-bordered table-striped table-hover" id="dashDetailsTable" style="margin-bottom: 0; font-size: 13px;">
                            <thead id="dashDetailsThead">
                                <!-- Dynamic Thead -->
                            </thead>
                            <tbody id="dashDetailsTbody">
                                <!-- Dynamic Tbody -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="padding: 10px 20px; background: #f8f9fa; border-top: 1px solid #e9ecef;">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal" style="font-weight: 600; padding: 4px 15px;">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-8 pichart_main">
                <div class="piechart_c">
                    <canvas id="dash-barChart" style="height: 240px !important;"></canvas>
                </div>
            </div>
            <div class="col-md-4 pichart_main">
                <div class="piechart_c">
                    <canvas id="dash-pieChart" style="height: 240px !important;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard -->
    <script>
        function get_dashboard_data() {
            $.ajax({
                url: '<?php echo base_url(); ?>/dashboard/get_dashboard_data',
                method: 'POST',
                success: function(data) {
                    data = JSON.parse(data);
                    var all_designation = data.total_designation;
                    var all_line = data.total_line;
                    var all_section = data.total_section;
                    var all_department = data.total_department;
                    var all_emp = data.all_emp;
                    var all_employee = data.all_employee;
                    var all_staff = data.all_staff;

                    var all_absent = data.all_absent;
                    var all_female = data.all_female;
                    var all_late = data.all_late;
                    var all_leave = data.all_leave;
                    var all_male = data.all_male;
                    var all_present = data.all_present;
                    var att_bonus = data.att_bonus;
                    var eot = data.eot;
                    var monthly_join_id = data.monthly_join_id;
                    var monthly_left_id = data.monthly_left_id;
                    var monthly_resign_id = data.monthly_resign_id;
                    var ot = data.ot;
                    var salary = data.salary;

                    // top card
                    $("#total_staff").html(all_staff);
                    $("#total_worker").html(all_employee);
                    $("#total_department").html(all_department);
                    $("#total_others").html(all_line);
                    $("#total_section").html(all_section);
                    $("#total_designation").html(all_designation);

                    // stats card 1 box
                    $("#total_employee").html(all_emp);
                    $("#total_male").html(all_male);
                    $("#total_female").html(all_female);
                    $("#total_common").html(all_emp - all_male - all_female);

                    // stats card 2 box
                    $("#total_present").html(all_present);
                    $("#total_absent").html(all_absent);
                    $("#total_late").html(all_late);
                    $("#total_leave").html(all_leave);

                    // stats card 3 box
                    $("#total_regular").html(all_emp);
                    $("#total_new_join").html(monthly_join_id);
                    $("#total_resign").html(monthly_resign_id);
                    $("#total_lefty").html(monthly_left_id);

                    // stats card 4 box
                    $("#total_salary").html(salary);
                    $("#total_overtime").html(ot);
                    $("#total_ext_overtime").html(eot);
                    $("#total_attn_bonus").html(att_bonus);

                    // pie chart
                    const ctxPie = document.getElementById('dash-pieChart').getContext('2d');
                    const pieChart = new Chart(ctxPie, {
                        type: 'pie',
                        data: {
                            labels: ['New Joining', 'Resign', 'Lefty'],
                            datasets: [{
                                data: [monthly_join_id, monthly_resign_id, monthly_left_id]
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                },
                error: function() {
                    alert('error');
                }
            });
        }

        $(document).ready(function() {
            get_dashboard_data();
        });

        /* --- Clickable Dashboard Cards & Modal Logic --- */
        var currentModalData = [];
        var modalHistory = [];

        $(document).on('click', '.clickable-card, .clickable-stat', function() {
            var type = $(this).data('type');
            var title = $(this).data('title');
            var icon = $(this).data('modal-icon') || $(this).data('icon') || 'fa-list-alt';

            modalHistory = [];
            $('#dashModalBackBtn').hide();
            openDashboardModal(type, title, icon);
        });

        function openDashboardModal(type, title, icon, extra_id, parentTitle, parentType) {
            if (parentType) {
                modalHistory.push({ type: parentType, title: parentTitle, icon: icon });
                $('#dashModalBackBtn').show();
            }

            $('#dashModalTitle').text(title);
            $('#dashModalIcon').attr('class', 'fa ' + icon);
            $('#dashModalBadge').text('Loading...');
            $('#dashModalSubtitle').text(title);
            $('#dashModalSearch').val('');
            $('#dashModalFilteredCount').text('0');

            $('#dashDetailsThead').html('');
            $('#dashDetailsTbody').html('<tr><td colspan="13" class="text-center" style="padding: 40px; color: #777;"><i class="fa fa-spinner fa-spin fa-2x"></i><br><span style="margin-top: 10px; display: inline-block;">Loading data, please wait...</span></td></tr>');

            $('#dashDetailsModal').modal('show');

            $.ajax({
                url: '<?= base_url("dashboard/get_card_details") ?>',
                type: 'GET',
                data: {
                    type: type,
                    extra_id: extra_id
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status && res.data) {
                        currentModalData = res.data;
                        $('#dashModalBadge').text(res.total);
                        $('#dashModalFilteredCount').text(res.total);
                        renderModalTable(type, res.data);
                    } else {
                        $('#dashModalBadge').text('0');
                        $('#dashDetailsTbody').html('<tr><td colspan="13" class="text-center text-muted" style="padding: 30px;"><em>No records found.</em></td></tr>');
                    }
                },
                error: function() {
                    $('#dashModalBadge').text('!');
                    $('#dashDetailsTbody').html('<tr><td colspan="13" class="text-center text-danger" style="padding: 30px;"><i class="fa fa-exclamation-triangle"></i> Failed to load data. Please try again.</td></tr>');
                }
            });
        }

        $('#dashModalBackBtn').click(function() {
            if (modalHistory.length > 0) {
                var prev = modalHistory.pop();
                if (modalHistory.length === 0) {
                    $('#dashModalBackBtn').hide();
                }
                openDashboardModal(prev.type, prev.title, prev.icon);
            }
        });

        $(document).on('click', '.btn-drilldown', function(e) {
            e.stopPropagation();
            var drillType = $(this).data('type');
            var extraId = $(this).data('id');
            var name = $(this).data('name');
            var parentType = $(this).data('parenttype') || 'department';
            var parentTitle = $('#dashModalTitle').text();
            openDashboardModal(drillType, name + ' - Employee List', 'fa-users', extraId, parentTitle, parentType);
        });

        $('#dashModalSearch').on('keyup', function() {
            var query = $(this).val().toLowerCase().trim();
            var visibleCount = 0;
            $('#dashDetailsTbody tr').each(function() {
                var rowText = $(this).text().toLowerCase();
                if (query === '' || rowText.indexOf(query) !== -1) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });
            $('#dashModalFilteredCount').text(visibleCount);
        });



        function renderModalTable(type, data) {
            var thead = '';
            var tbody = '';

            if (!data || data.length === 0) {
                thead = '<tr><th>#</th><th>Details</th></tr>';
                tbody = '<tr><td colspan="2" class="text-center text-muted" style="padding: 30px;"><em>No records found matching criteria.</em></td></tr>';
                $('#dashDetailsThead').html(thead);
                $('#dashDetailsTbody').html(tbody);
                return;
            }

            if (type === 'department') {
                thead = '<tr>' +
                    '<th style="width: 50px;">#</th>' +
                    '<th>Department Name (English)</th>' +
                    '<th>Bangla Name</th>' +
                    '<th style="width: 150px;">Active Employees</th>' +
                    '<th style="width: 180px;">Action</th>' +
                '</tr>';
                $.each(data, function(i, d) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><strong>' + (d.dept_name || '-') + '</strong></td>' +
                        '<td>' + (d.dept_bangla || '-') + '</td>' +
                        '<td class="text-center"><span class="badge" style="background: #0177bc; font-size: 13px;">' + (d.total_emp || 0) + '</span></td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-xs btn-primary btn-drilldown" data-type="dept_employees" data-parenttype="department" data-id="' + d.dept_id + '" data-name="' + escapeHtml(d.dept_name) + '" style="font-weight: 600;">' +
                                '<i class="fa fa-users"></i> View Employees' +
                            '</button> ' +
                            '<a href="<?= base_url("setup_con/department") ?>" class="btn btn-xs btn-default" target="_blank" title="Manage Setup"><i class="fa fa-cog"></i></a>' +
                        '</td>' +
                    '</tr>';
                });
            } else if (type === 'designation') {
                thead = '<tr>' +
                    '<th style="width: 50px;">#</th>' +
                    '<th>Designation Name (English)</th>' +
                    '<th>Bangla Name</th>' +
                    '<th style="width: 150px;">Active Employees</th>' +
                    '<th style="width: 180px;">Action</th>' +
                '</tr>';
                $.each(data, function(i, d) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><strong>' + (d.desig_name || '-') + '</strong></td>' +
                        '<td>' + (d.desig_bangla || '-') + '</td>' +
                        '<td class="text-center"><span class="badge" style="background: #448644; font-size: 13px;">' + (d.total_emp || 0) + '</span></td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-xs btn-success btn-drilldown" data-type="desig_employees" data-parenttype="designation" data-id="' + d.desig_id + '" data-name="' + escapeHtml(d.desig_name) + '" style="font-weight: 600;">' +
                                '<i class="fa fa-users"></i> View Employees' +
                            '</button> ' +
                            '<a href="<?= base_url("setup_con/designation") ?>" class="btn btn-xs btn-default" target="_blank" title="Manage Setup"><i class="fa fa-cog"></i></a>' +
                        '</td>' +
                    '</tr>';
                });
            } else if (type === 'section') {
                thead = '<tr>' +
                    '<th style="width: 50px;">#</th>' +
                    '<th>Section Name (English)</th>' +
                    '<th>Bangla Name</th>' +
                    '<th>Department</th>' +
                    '<th style="width: 150px;">Active Employees</th>' +
                    '<th style="width: 180px;">Action</th>' +
                '</tr>';
                $.each(data, function(i, d) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><strong>' + (d.sec_name_en || '-') + '</strong></td>' +
                        '<td>' + (d.sec_name_bn || '-') + '</td>' +
                        '<td>' + (d.dept_name || '-') + '</td>' +
                        '<td class="text-center"><span class="badge" style="background: #4b87f9; font-size: 13px;">' + (d.total_emp || 0) + '</span></td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-xs btn-info btn-drilldown" data-type="sec_employees" data-parenttype="section" data-id="' + d.sec_id + '" data-name="' + escapeHtml(d.sec_name_en) + '" style="font-weight: 600;">' +
                                '<i class="fa fa-users"></i> View Employees' +
                            '</button> ' +
                            '<a href="<?= base_url("setup_con/section") ?>" class="btn btn-xs btn-default" target="_blank" title="Manage Setup"><i class="fa fa-cog"></i></a>' +
                        '</td>' +
                    '</tr>';
                });
            } else if (type === 'others' || type === 'line') {
                thead = '<tr>' +
                    '<th style="width: 50px;">#</th>' +
                    '<th>Line / Others Name (English)</th>' +
                    '<th>Bangla Name</th>' +
                    '<th style="width: 150px;">Active Employees</th>' +
                    '<th style="width: 180px;">Action</th>' +
                '</tr>';
                $.each(data, function(i, d) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><strong>' + (d.line_name_en || '-') + '</strong></td>' +
                        '<td>' + (d.line_name_bn || '-') + '</td>' +
                        '<td class="text-center"><span class="badge" style="background: #6c757d; font-size: 13px;">' + (d.total_emp || 0) + '</span></td>' +
                        '<td class="text-center">' +
                            '<button type="button" class="btn btn-xs btn-default btn-drilldown" data-type="line_employees" data-parenttype="others" data-id="' + d.line_id + '" data-name="' + escapeHtml(d.line_name_en) + '" style="font-weight: 600;">' +
                                '<i class="fa fa-users"></i> View Employees' +
                            '</button> ' +
                            '<a href="<?= base_url("setup_con/line") ?>" class="btn btn-xs btn-default" target="_blank" title="Manage Setup"><i class="fa fa-cog"></i></a>' +
                        '</td>' +
                    '</tr>';
                });
            } else if (type === 'present') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Punch ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Designation</th>' +
                    '<th>Shift</th>' +
                    '<th>Permanent Shift</th>' +
                    '<th style="width: 90px;">In Time</th>' +
                    '<th style="width: 90px;">Out Time</th>' +
                    '<th style="width: 90px;">Status</th>' +
                    '<th style="width: 80px;">OT / EOT</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    var inBadge = emp.in_time ? '<span class="label label-success" style="padding: 3px 6px; font-size: 11px;">' + emp.in_time + '</span>' : '-';
                    var outBadge = emp.out_time ? '<span class="label label-default" style="padding: 3px 6px; font-size: 11px;">' + emp.out_time + '</span>' : '-';
                    var statusBadge = (emp.late_status == '1') ? '<span class="label label-danger" style="padding: 3px 6px; font-size: 11px;">Late ' + (emp.late_time ? '('+emp.late_time+'m)' : '') + '</span>' : '<span class="label label-primary" style="padding: 3px 6px; font-size: 11px;">On Time</span>';
                    var otText = (emp.ot || 0) + 'h / ' + (emp.eot || 0) + 'h';

                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><a href="<?= base_url('emp_info_con/personal_info_short') ?>?emp_id=' + emp.emp_id + '" target="_blank" style="font-weight: bold; color: #0177bc;">' + emp.emp_id + '</a></td>' +
                        '<td>' + (emp.proxi_id || '-') + '</td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td>' + (emp.shift_name || '-') + '</td>' +
                        '<td>' + (emp.per_shift_name || '-') + '</td>' +
                        '<td class="text-center">' + inBadge + '</td>' +
                        '<td class="text-center">' + outBadge + '</td>' +
                        '<td class="text-center">' + statusBadge + '</td>' +
                        '<td class="text-center"><small>' + otText + '</small></td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else if (type === 'absent') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Punch ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Section</th>' +
                    '<th>Designation</th>' +
                    '<th>Shift</th>' +
                    '<th>Permanent Shift</th>' +
                    '<th style="width: 90px;">Status</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><a href="<?= base_url('emp_info_con/personal_info_short') ?>?emp_id=' + emp.emp_id + '" target="_blank" style="font-weight: bold; color: #dc3545;">' + emp.emp_id + '</a></td>' +
                        '<td>' + (emp.proxi_id || '-') + '</td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.sec_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td>' + (emp.shift_name || '-') + '</td>' +
                        '<td>' + (emp.per_shift_name || '-') + '</td>' +
                        '<td class="text-center"><span class="label label-danger" style="padding: 3px 8px; font-size: 11px;">Absent</span></td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else if (type === 'leave') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Punch ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Section</th>' +
                    '<th>Designation</th>' +
                    '<th>Shift</th>' +
                    '<th>Permanent Shift</th>' +
                    '<th style="width: 90px;">Status</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><a href="<?= base_url('emp_info_con/personal_info_short') ?>?emp_id=' + emp.emp_id + '" target="_blank" style="font-weight: bold; color: #ff9800;">' + emp.emp_id + '</a></td>' +
                        '<td>' + (emp.proxi_id || '-') + '</td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.sec_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td>' + (emp.shift_name || '-') + '</td>' +
                        '<td>' + (emp.per_shift_name || '-') + '</td>' +
                        '<td class="text-center"><span class="label label-warning" style="padding: 3px 8px; font-size: 11px;">On Leave</span></td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else if (type === 'late') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Punch ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Designation</th>' +
                    '<th>Shift</th>' +
                    '<th>Permanent Shift</th>' +
                    '<th style="width: 90px;">In Time</th>' +
                    '<th style="width: 100px;">Late Duration</th>' +
                    '<th style="width: 90px;">Out Time</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><a href="<?= base_url('emp_info_con/personal_info_short') ?>?emp_id=' + emp.emp_id + '" target="_blank" style="font-weight: bold; color: #d9534f;">' + emp.emp_id + '</a></td>' +
                        '<td>' + (emp.proxi_id || '-') + '</td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td>' + (emp.shift_name || '-') + '</td>' +
                        '<td>' + (emp.per_shift_name || '-') + '</td>' +
                        '<td class="text-center"><span class="label label-danger" style="padding: 3px 6px; font-size: 11px;">' + (emp.in_time || '-') + '</span></td>' +
                        '<td class="text-center"><span class="label label-warning" style="padding: 3px 6px; font-size: 11px;">' + (emp.late_time ? emp.late_time + ' min' : 'Late') + '</span></td>' +
                        '<td class="text-center">' + (emp.out_time || '-') + '</td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else if (type === 'resign') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Section</th>' +
                    '<th>Designation</th>' +
                    '<th style="width: 110px;">Resign Date</th>' +
                    '<th>Reason</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><strong style="color: #d9534f;">' + emp.emp_id + '</strong></td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.sec_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td class="text-center"><span class="label label-danger" style="padding: 3px 7px;">' + (emp.resign_date || '-') + '</span></td>' +
                        '<td>' + (emp.resign_reason || '-') + '</td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else if (type === 'lefty') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Section</th>' +
                    '<th>Designation</th>' +
                    '<th style="width: 110px;">Left Date</th>' +
                    '<th>Remark</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><strong style="color: #f0ad4e;">' + emp.emp_id + '</strong></td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.sec_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td class="text-center"><span class="label label-warning" style="padding: 3px 7px;">' + (emp.left_date || '-') + '</span></td>' +
                        '<td>' + (emp.remark || '-') + '</td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else if (type === 'new_join') {
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Punch ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th>Department</th>' +
                    '<th>Designation</th>' +
                    '<th style="width: 110px;">Join Date</th>' +
                    '<th style="width: 80px;">Type</th>' +
                    '<th>Shift</th>' +
                    '<th>Permanent Shift</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    var typeBadge = (emp.emp_type_name === 'Staff') ? '<span class="label label-primary" style="padding: 2px 6px;">Staff</span>' : '<span class="label label-default" style="padding: 2px 6px;">Worker</span>';
                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><a href="<?= base_url('emp_info_con/personal_info_short') ?>?emp_id=' + emp.emp_id + '" target="_blank" style="font-weight: bold; color: #0177bc;">' + emp.emp_id + '</a></td>' +
                        '<td>' + (emp.proxi_id || '-') + '</td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td class="text-center"><span class="label label-success" style="padding: 3px 7px;">' + (emp.emp_join_date || '-') + '</span></td>' +
                        '<td class="text-center">' + typeBadge + '</td>' +
                        '<td>' + (emp.shift_name || '-') + '</td>' +
                        '<td>' + (emp.per_shift_name || '-') + '</td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            } else {
                // Standard Employee Lists (staff, worker, employee, regular, male, female, common, dept_employees, desig_employees, etc.)
                thead = '<tr>' +
                    '<th style="width: 45px;">#</th>' +
                    '<th>Emp ID</th>' +
                    '<th>Punch ID</th>' +
                    '<th>Employee Name</th>' +
                    '<th style="width: 70px;">Gender</th>' +
                    '<th>Department</th>' +
                    '<th>Section</th>' +
                    '<th>Designation</th>' +
                    '<th>Shift</th>' +
                    '<th>Permanent Shift</th>' +
                    '<th style="width: 80px;">Type</th>' +
                    '<th style="width: 100px;">Join Date</th>' +
                    '<th>Mobile</th>' +
                '</tr>';
                $.each(data, function(i, emp) {
                    var typeBadge = (emp.emp_type_name === 'Staff' || emp.emp_type == 2) ? '<span class="label label-primary" style="padding: 2px 6px;">Staff</span>' : '<span class="label label-default" style="padding: 2px 6px;">Worker</span>';
                    var genderBadge = (emp.gender === 'Male') ? '<span class="label label-info" style="padding: 2px 6px;"><i class="fa fa-male"></i> Male</span>' : (emp.gender === 'Female' ? '<span class="label label-danger" style="padding: 2px 6px;"><i class="fa fa-female"></i> Female</span>' : '-');

                    tbody += '<tr>' +
                        '<td class="text-center">' + (i + 1) + '</td>' +
                        '<td><a href="<?= base_url('emp_info_con/personal_info_short') ?>?emp_id=' + emp.emp_id + '" target="_blank" style="font-weight: bold; color: #0177bc;">' + emp.emp_id + '</a></td>' +
                        '<td>' + (emp.proxi_id || '-') + '</td>' +
                        '<td><strong>' + (emp.name_en || emp.name_bn || '-') + '</strong></td>' +
                        '<td class="text-center">' + genderBadge + '</td>' +
                        '<td>' + (emp.dept_name || '-') + '</td>' +
                        '<td>' + (emp.sec_name || '-') + '</td>' +
                        '<td>' + (emp.desig_name || '-') + '</td>' +
                        '<td>' + (emp.shift_name || '-') + '</td>' +
                        '<td>' + (emp.per_shift_name || '-') + '</td>' +
                        '<td class="text-center">' + typeBadge + '</td>' +
                        '<td class="text-center">' + (emp.emp_join_date || '-') + '</td>' +
                        '<td>' + (emp.personal_mobile || '-') + '</td>' +
                    '</tr>';
                });
            }

            $('#dashDetailsThead').html(thead);
            $('#dashDetailsTbody').html(tbody);
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
        }
    </script>

    <!-- bar chart -->
    <script>
        const ctx = document.getElementById('dash-barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    { label: 'Salary', data: [] },
                    { label: 'Overtime', data: [] },
                    { label: 'Allowance', data: [] }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        $.ajax({
            url: "<?= base_url('dashboard/get_bar_chart_data') ?>",
            type: "GET",
            dataType: "json",
            success: function (res) {

                // Convert YYYY-MM → Jan, Feb
                const labels = res.labels.map(m => {
                    const d = new Date(m + '-01');
                    return d.toLocaleString('default', { month: 'short' });
                });

                barChart.data.labels = labels;
                barChart.data.datasets[0].data = res.salary;
                barChart.data.datasets[1].data = res.ot;
                barChart.data.datasets[2].data = res.allowance;
                barChart.update();
            }
        });
    </script>












    <script>
        // Bar Chart Data
        // const ctxBar = document.getElementById('dash-barChart').getContext('2d');
        // const barChart = new Chart(ctxBar, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        //         datasets: [{
        //                 label: 'Salary',
        //                 data: [480, 420, 410, 390, 430, 450, 560, 400, 380, 390, 420, 430]
        //             },
        //             {
        //                 label: 'Overtime',
        //                 data: [440, 380, 370, 360, 390, 410, 530, 380, 360, 370, 390, 400]
        //             },
        //             {
        //                 label: 'Allowance',
        //                 data: [460, 400, 400, 380, 410, 420, 520, 390, 370, 380, 400, 410]
        //             }
        //         ]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false
        //     }
        // });

    </script>



    <script>

        // Pie Chart Data
        // const ctxPie = document.getElementById('dash-pieChart').getContext('2d');
        // const pieChart = new Chart(ctxPie, {
        //     type: 'pie',
        //     data: {
        //         labels: ['New Joining', 'Resign', 'Lefty'],
        //         datasets: [{
        //             data: [370, 28, 75]
        //         }]
        //     },
        //     options: {
        //         responsive: true,
        //         maintainAspectRatio: false
        //     }
        // });
    </script>

</div>

