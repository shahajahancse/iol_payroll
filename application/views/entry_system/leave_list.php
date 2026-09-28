
<div class="content">
    <nav class="navbar navbar-default" style="padding:15px;">
        <div class="container-fluid">
            <div class="row align-items-end">
                <!-- Add Leave Button -->
                <div class="col-md-2">
                    <label style="visibility:hidden;">Action</label>
                    <a class="btn btn-info btn-block" href="<?= base_url('entry_system_con/leave_transation') ?>">
                        Add Leave
                    </a>
                </div>

                <!-- From Date -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>From Date</label>
                        <input type="date" name="from_date" id="from_date"
                            class="form-control" onchange="filtering_data(0)">
                    </div>
                </div>

                <!-- To Date -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>To Date</label>
                        <input type="date" name="to_date" id="to_date"
                            class="form-control" onchange="filtering_data(0)">
                    </div>
                </div>

                <!-- Month -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Month</label>
                        <input type="month" name="month" id="month"
                            class="form-control" onchange="filtering_data(0)">
                    </div>
                </div>

                <!-- Year -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Year</label>
                        <select name="year" id="year"
                            class="form-control" onchange="get_data(0)">
                            <option value="">Select Year</option>
                            <?php
                                $start = date('Y', strtotime('-5 year'));
                                $end   = date('Y', strtotime('+1 year'));
                                for ($i = $end; $i >= $start; $i--) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <!-- Emp ID -->
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Emp ID</label>
                        <input type="text" name="emp_id" id="emp_id"
                            class="form-control"
                            placeholder="Enter Employee ID"
                            oninput="debounceSearch()">
                    </div>
                </div>

            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <?php
                $success = $this->session->flashdata('success');
                if ($success != "") { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php } ?>
            <?php
                $failuer = $this->session->flashdata('failuer');
                if ($failuer) { ?>
                <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php } ?>
        </div>
    </div>
    <!-- <br> -->
    <div class="row tablebox">
        <div class="col-md-12">
            <table class="table table-striped" id="">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>User name </th>
                        <th>Emp Id</th>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Total Day</th>
                        <th>Unit name</th>
                        <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(!in_array(10,$acl)) {echo '';} else { echo 'style="display:none;"';}?> >Delete</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>

<script>
    var offset = 0
    var limit = 15
    var i = 0
    $(document).ready(function() {
        get_data(offset)
    })
</script>

<script>
    let timer;
    function debounceSearch(){
        $('#tbody').empty();
        clearTimeout(timer);
        timer = setTimeout(() => {
            get_data(0);
        }, 500); // 0.5 sec delay
    }

    function filtering_data(params) {
        $('#tbody').empty();
        get_data(params);
    }
</script>

<script>
    window.onscroll = function() {
        if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
            offset += limit
            get_data(offset)
        }
    }

    function get_data(offset=0) {
        var from_date = $('#from_date').val();
        var to_date = $('#to_date').val();
        var month = $('#month').val();
        var year = $('#year').val();
        var emp_id = $('#emp_id').val();

        $.ajax({
            url:"<?php echo base_url('entry_system_con/leave_list_ajax') ?>",
            type:"post",
            data:{
                offset:offset,
                limit:limit,
                from_date:from_date,
                to_date:to_date,
                month:month,
                year:year,
                emp_id:emp_id
            },
            success:function(data){
                var obj = JSON.parse(data)

                obj.forEach(element => {
                    $('#tbody').append(`<tr>
                    <td>${++i}</td>
                    <td>${element.user_name}</td>
                    <td>${element.emp_id}</td>
                    <td title="${element.leave_descrip}" ><a>${element.leave_type}</a></td>
                    <td>${element.leave_start}</td>
                    <td>${element.leave_end}</td>
                    <td>${element.total_leave}</td>
                    <td>${element.unit_name}</td>
                    <td>
                        <a   <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(130,$acl)) {echo '';} else { echo 'style="display:none;"';}?>   href="<?=base_url('entry_system_con/emp_leave_del/')?>${element.id}" class="btn btn-danger" role="button">Delete</a>
                    </td>
                </tr>`)
                });
            }
        })
    }

</script>
