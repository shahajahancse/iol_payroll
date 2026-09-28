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
</style>







<div class="content">
    <!-- Top Cards -->
    <div class="dash-cards">
        <div class="dash-card dash-card--blue">
            <div class="dash-card__icon"><i class="fa fa-users"></i></div>
            <div class="dash-card__content">
                <div class="dash-card__row"><span class="dash-card__title">Total Staff</span><span
                        class="dash-card__value" id="total_staff">0</span></div>
                <div class="dash-card__row"><span class="dash-card__title">Total Worker</span><span
                        class="dash-card__value" id="total_worker">0</span></div>
            </div>
        </div>
        <div class="dash-card dash-card--green">
            <div class="dash-card__icon"><i class="fa fa-university"></i></div>
            <div class="dash-card__content">
                <div class="dash-card__row"><span class="dash-card__title">Department</span><span
                        class="dash-card__value" id="total_department">0</span></div>
                <div class="dash-card__row"><span class="dash-card__title">Line</span><span class="dash-card__value"
                        id="total_line">0</span></div>
            </div>
        </div>
        <div class="dash-card dash-card--blue2">
            <div class="dash-card__icon"><i class="fa fa-id-card-o"></i></div>
            <div class="dash-card__content">
                <div class="dash-card__row"><span class="dash-card__title">Section</span><span class="dash-card__value"
                        id="total_section">0</span></div>
                <div class="dash-card__row"><span class="dash-card__title">Designation</span><span
                        class="dash-card__value" id="total_designation">0</span></div>
            </div>
        </div>
    </div>

    <!-- Stats -->
    <div class="dash-stats">
        <div class="dash-stat dash-stat--total">
            <div class="dash-stat__header"><i class="fa fa-table"></i> Total Manpower</div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Total
                        Employee</span><span class="dash-stat__value" id="total_employee">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Total
                        Male</span><span class="dash-stat__value" id="total_male">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Total
                        Female</span><span class="dash-stat__value" id="total_female">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Total
                        Common</span><span class="dash-stat__value" id="total_common">0</span></li>
            </ul>
        </div>
        <div class="dash-stat dash-stat--today">
            <div class="dash-stat__header"><i class="fa fa-calendar"></i> Today Attendance</div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Present</span><span class="dash-stat__value"
                        id="total_present">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Absent</span><span class="dash-stat__value" id="total_absent">0</span>
                </li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Leave</span><span class="dash-stat__value" id="total_leave">0</span>
                </li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Late</span><span class="dash-stat__value" id="total_late">0</span>
                </li>
            </ul>
        </div>
        <div class="dash-stat dash-stat--current">
            <div class="dash-stat__header"><i class="fa fa-bell"></i> Current Month Status</div>
            <ul class="dash-stat__list">
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">Regular</span><span class="dash-stat__value" id="total_regular">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span class="dash-stat__label">New
                        Join</span><span class="dash-stat__value" id="total_new_join">0</span></li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Resign</span><span class="dash-stat__value" id="total_resign">0</span>
                </li>
                <li class="dash-stat__item"><span class="dash-bullet"></span><span
                        class="dash-stat__label">Lefty</span><span class="dash-stat__value" id="total_lefty">0</span>
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

                    // console.log(data);
                    // top card
                    $("#total_staff").html(all_staff);
                    $("#total_worker").html(all_employee);
                    $("#total_department").html(all_department);
                    $("#total_line").html(all_line);
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

