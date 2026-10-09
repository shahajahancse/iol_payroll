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
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addHolidayModal">Add Holiday</button>
                    <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a>
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
            <?php
                $success = $this->session->flashdata('success');
                if ($success != "") {
                    ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php
                }
                $failuer = $this->session->flashdata('failuer');
                if ($failuer) {
                    ?>
            <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php
                }
                ?>

        </div>
    </div>
    <!-- <br> -->
    <div class="row tablebox">
        <div class="col-md-12">
            <table class="table table-striped" id="mytable">
                <thead>
                    <?php $unit_count = isset($dept) ? count($dept) : 1; ?>
                    <tr>
                        <th>SL</th>
                        <th>User name</th>
                        <th>Emp Id</th>
                        <?php if ($unit_count > 1) { ?>
                            <th>Unit name</th>
                        <?php } ?>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Description</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody id="tbody">
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>

<!-- Modal for Add Holiday -->
<div class="modal fade" id="addHolidayModal" tabindex="-1" role="dialog" aria-labelledby="addHolidayModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" style="max-width: 500px;">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #0177bc; color: white;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="color: white;">&times;</button>
                <h4 class="modal-title" id="addHolidayModalLabel" style="color: white; font-weight: bold;">Add Holiday</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="unit_id" id="unit_id" value="1">
                <input type="hidden" class="line" id="line" name="line" value="0">
                
                <div class="row">
                    <!-- From Date -->
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-weight: bold;">From Date *</label>
                            <input type="text" class="form-control date" id="from_date" placeholder="Select from date" autocomplete="off">
                        </div>
                    </div>
                    <!-- To Date -->
                    <div class="col-md-6">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-weight: bold;">To Date</label>
                            <input type="text" class="form-control date" id="to_date" placeholder="Select to date" autocomplete="off">
                        </div>
                    </div>
                    <!-- Description -->
                    <div class="col-md-12">
                        <div class="form-group" style="margin-bottom: 15px;">
                            <label style="font-weight: bold;">Description</label>
                            <textarea class="form-control input-sm" id="description" placeholder="Description here" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:10px;">
                    <img src="<?php echo base_url('images/ajax-loader.gif');?>" />
                </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" onclick='add_Holiday()' type="button" value='Add Holiday' />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
var hostname = typeof hostname !== 'undefined' ? hostname : '<?php echo base_url(); ?>';
var offset = 0;
var limit = 15;
var i = 0;
var unitCount = <?php echo $unit_count; ?>;

$(document).ready(function() {
    get_data(offset);

    $('#addHolidayModal').on('shown.bs.modal', function () {
        if ($.fn.datepicker) {
            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true
            });
        }
    });
});

function get_data(offset=0) {
    var deptSearch = $('#deptSearch').val();
    $.ajax({
        url:"<?php echo base_url('entry_system_con/holiday_list_ajax') ?>",
        type:"post",
        data:{
            offset:offset,
            limit:limit,
            deptSearch:deptSearch
        },
        success:function(data){
            var obj = JSON.parse(data);

            obj.forEach(element => {
                var from_d = element.from_date ? element.from_date : element.work_off_date;
                var to_d   = element.to_date ? element.to_date : element.work_off_date;
                var unitCol = unitCount > 1 ? `<td>${element.unit_name}</td>` : '';

                $('#tbody').append(`<tr>
                <td>${++i}</td>
                <td>${element.user_name}</td>
                <td>${element.emp_id}</td>
                ${unitCol}
                <td>${from_d}</td>
                <td>${to_d}</td>
                <td>${element.description ? element.description : ''}</td>
                <td>
                    <button onclick="delete_individual(${element.id})" class="btn btn-danger" role="button">Delete</button>
                </td>
            </tr>`);
            });
        }
    });
}

function delete_individual(id) {
    if (!confirm('Are you sure you want to delete this holiday record?')) {
        return false;
    }
    $.ajax({
        url: "<?php echo base_url('entry_system_con/emp_holiday_del') ?>",
        type: "post",
        data: { id: id },
        success: function(response) {
            if (response == 'success') {
                if (typeof showMessage === 'function') {
                    showMessage('success', 'Record Deleted successfully!');
                } else {
                    alert('Record Deleted successfully!');
                }
                offset = 0;
                i = 0;
                $('#tbody').empty();
                get_data(0);
            } else {
                if (typeof showMessage === 'function') {
                    showMessage('error', 'Record Not Deleted');
                } else {
                    alert('Record Not Deleted');
                }
            }
        }
    });
}

window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        offset += limit;
        get_data(offset);
    }
};

$('#deptSearch').keyup(function() {
    offset = 0;
    i = 0;
    get_data(offset);
    $('#tbody').empty();
});

function get_filtered_emp_ids(callback) {
    var unit = $('#unit_id').val() || '1';
    var url = hostname + "common/grid_emp_list/" + unit + "///0/";
    $.ajax({
        url: url,
        type: 'GET',
        contentType: "application/json",
        dataType: "json",
        success: function(response) {
            if (response && response.length > 0) {
                var emp_ids = response.map(emp => emp.emp_id).join(",");
                callback(emp_ids);
            } else {
                callback("");
            }
        },
        error: function() {
            callback("");
        }
    });
}

function add_Holiday() {
    var from_date = $('#from_date').val();
    var to_date   = $('#to_date').val();
    if (!to_date) {
        to_date = from_date;
    }
    if (from_date == '') {
        alert('Please select From Date');
        return false;
    }
    var unit_id = $('#unit_id').val();
    if (unit_id == '') {
        alert('Please select Unit');
        return false;
    }
    var description = $('#description').val();

    $("#loader").show();

    get_filtered_emp_ids(function(sql) {
        if (!sql || sql == '') {
            alert('No employee found to assign holiday.');
            $("#loader").hide();
            return false;
        }

        $.ajax({
            type: "POST",
            url: hostname + "entry_system_con/holiday_add_ajax",
            data: {
                sql: sql,
                from_date: from_date,
                to_date: to_date,
                date: from_date,
                unit_id: unit_id,
                description: description,
            },
            success: function(data) {
                $("#loader").hide();
                if (data == 'success') {
                    if (typeof showMessage === 'function') {
                        showMessage('success', 'Holiday Added Successfully');
                    } else {
                        alert('Holiday Added Successfully');
                    }
                    $('#addHolidayModal').modal('hide');
                    offset = 0;
                    i = 0;
                    $('#tbody').empty();
                    get_data(0);
                } else {
                    if (typeof showMessage === 'function') {
                        showMessage('error', 'Holiday Not Added');
                    } else {
                        alert('Holiday Not Added');
                    }
                }
            },
            error: function() {
                $("#loader").hide();
                alert('An error occurred while adding holiday.');
            }
        });
    });
}
</script>
