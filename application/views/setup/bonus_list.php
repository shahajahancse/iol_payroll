<style>
    #mytable {
        border-collapse: collapse;
    }

    #mytable, th, td {
        border: 1px solid #b0c0df;
        text-align: center;
        vertical-align: middle !important;
    }
    .table td {
        padding: 0px 3px !important;
        font-size: 13px;
      
    }
    table.dataTable thead th, table.dataTable thead td {
        border-bottom: none;
      white-space: nowrap;

    }
    table.dataTable tbody th, table.dataTable tbody td {
      padding: 4px !important;
      white-space: nowrap;
    }
    .center-text {
        vertical-align: center;
        padding: 5px 10px;
    }
</style>
<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5">
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/bonus_add') ?>">Add Bonus</a>
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
    <div class="row tablebox table-responsive">
        <div class="col-md-6" style="margin-left:-16px">
          <h4 style="font-weight:bold">Bonus List</h4>
        </div>
            <table class="table" id="mytable">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Unit Name</th>
                        <th>Emp type</th>
                        <th>Enabled Days</th>
                        <th>Less Than Days</th>
                        <th>Bonus Pay</th>
                        <th>Bonus percent</th>
                        <th>Effective date</th>
                        <th width="80">Edit</th>
                        <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(146,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pr_bonus_rules)){ foreach($pr_bonus_rules as $pr_bonus_rule){?>
                        <tr>
                            <td><?php echo @++$i; ?></td>
                            <td><?php echo $pr_bonus_rule['unit_name'] ?></td>
                            <td><?php echo ($pr_bonus_rule['emp_type'] == 1) ? "Worker" : "Staff" ?></td>
                            <td><?php echo $pr_bonus_rule['bonus_first_month'] ?></td>
                            <td><?php echo $pr_bonus_rule['bonus_second_month'] ?></td>
                            <td><?php echo $pr_bonus_rule['bonus_amount'] ?></td>
                            <!-- <td><?php echo $pr_bonus_rule['bonus_amount_fraction'] ?></td> -->
                            <td><?php echo $pr_bonus_rule['bonus_percent'] ?></td>
                            <td><?php echo $pr_bonus_rule['effective_date'] ?></td>
                            <td>
                                <a href="<?=base_url('setup_con/bonus_edit').'/'.$pr_bonus_rule["id"]?>"
                                    target='_blank' class="btn btn-primary input-sm center-text" role="button">Edit</a>
                            </td>
                            <td <?php if(in_array(146,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>
                                <a href="<?=base_url('setup_con/bonus_delete').'/'.$pr_bonus_rule["id"]?>"
                                    class="btn btn-danger input-sm center-text" role="button">Delete</a>
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
        oTable.search($(this).val()).draw();
    })
});
</script>