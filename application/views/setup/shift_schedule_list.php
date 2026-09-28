<style>
    #mytable {
        border-collapse: collapse;
        /* width: 100%; */
    }

    #mytable, th, td {
        border: 1px solid #b0c0df;
          text-align: center;
          vertical-align: middle !important;

    }

    .table td {
        /* border-top: 1px solid #e8edf1; */
        padding: 0px 3px !important;
        font-size: 13px;
        width: 100%;
    }
    table.dataTable thead th, table.dataTable thead td {
        /* padding: 10px 18px; */
        border-bottom: none;
    }
</style>

<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5" style="padding: 7px;">
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/shiftschedule_add')?>">Add Shift Schedule</a>
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
      </div>
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
            <?php }  ?>
        </div>
    </div>

    <div class="row tablebox table-responsive">
            <div class="col-md-6">
                <h4 style="font-weight:bold">Shift Schedule List</h4>
            </div>
        <div class="col-md-12">
            <table class="table table-responsive" id="mytable">
                <thead>
                    <tr >
                        <th>Sl.No.</th></th>
                        <th>Unit Name </th>
                        <th >Shift Type</th>
                        <th>IN Start</th>
                        <th>IN Time</th>
                        <th>Late Start</th>
                        <th>IN End</th>
                        <th>OUT Start</th>
                        <th>OUT End</th>
                        <th>OT Start</th>
                        <th>OT Minute</th>
                        <th >One Hour OT Time</th>
                        <th >Two_Hour OT Time</th>
                        <th>Lunch start</th>
                        <th>Lunch minute</th>
                        <th>Tiffin break</th>
                        <th>Tiffin minute</th>
                        <th>Tiffin break 2</th>
                        <th>Tiffin minute 2</th>
                        <th>Random minute</th>
                        <th>off Days</th>
                        <th style="width:80px !important">Edit</th>
                        <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(148,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                   // dd($pr_emp_shift_schedule);
                        if(!empty($pr_emp_shift_schedule)){ $i=1;
                        foreach($pr_emp_shift_schedule as $pr_emp_shift_schedules){ ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td style="white-space: nowrap;"><?php echo $pr_emp_shift_schedules['unit_name'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['sh_type'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['in_start'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['in_time'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['late_start'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['in_end'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['out_start'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['out_end'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['ot_start'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['ot_minute_to_one_hour'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['one_hour_ot_out_time'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['two_hour_ot_out_time'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['lunch_start'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['lunch_minute'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['tiffin_break'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['tiffin_minute'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['tiffin_break2'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['tiffin_minute2'] ?></td>
                        <td><?php echo $pr_emp_shift_schedules['random_minute'] ?></td>
                        <?php if (!empty($pr_emp_shift_schedules['of_day'])) { ?>
                            <?php $days = json_decode($pr_emp_shift_schedules['of_day']); ?>
                            <td><?php echo implode(', ', $days); ?></td>
                        <?php } else { ?>
                            <td></td>
                        <?php } ?>

                        <td>
                            <a href="<?=base_url('setup_con/shiftschedule_edit').'/'.$pr_emp_shift_schedules["id"]?>"
                                 class="btn btn-primary input-sm" role="button">Edit</a>
                        </td>
                        <td <?php if(in_array(148,$acl)) {echo '';} else { echo 'style="display:none;"';}?> >
                            <a href="<?=base_url('setup_con/shiftschedule_delete').'/'.$pr_emp_shift_schedules["id"]?>"
                                class="btn btn-danger input-sm" role="button">Delete</a>
                        </td>
                    </tr>
                    <?php } }else{?>
                    <tr>
                        <td colspan="12">Records not Found</td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>
<script type="text/javascript">
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
        oTable.search($(this).val()).draw()
    })
})
</script>
