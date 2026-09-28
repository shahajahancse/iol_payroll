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
            <div class="navbar-header col-md-5" style="padding: 7px;">
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/iftar_bill_add') ?>">Add Iftar Bill  Allowance</a>
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
            <?php
                $success = $this->session->flashdata('success');
                    if ($success != "") {?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php
                    }
                    $failuer = $this->session->flashdata('failuer');
                    if ($failuer) { ?>
                    <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php }?>
    </div>
    </div>
    <div class="row tablebox">
        <div class="col-md-6">
            <h4 style="font-weight:bold">Iftar Bill  Allowance List</h4>
        </div>
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Rule Name</th>
                    <th>Allowance Amount</th>
                    <th>Unit name</th>
                    <th width="80">Edit</th>
                    <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(144,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($allowance_iftar_bill)) {foreach ($allowance_iftar_bill as $key => $pr_lines) {?>
                <tr>
                    <td><?php echo $key + 1  ?></td>
                    <td><?php echo $pr_lines['rule_name'] ?></td>
                    <td><?php echo $pr_lines['allowance_amount'] ?></td>
                    <td><?php echo $pr_lines['unit_name'] ?></td>
                    <td>
                        <a href="<?=base_url('setup_con/iftar_bill_edit') . '/' . $pr_lines["id"]?>"
                                class="btn btn-primary input-sm center-text" role="button">Edit</a>
                    </td>
                    <td <?php if(in_array(144,$acl)) {echo '';} else { echo 'style="display:none;"';} ?>>
                        <a href="<?=base_url('setup_con/iftar_bill_delete') . '/' . $pr_lines["id"]?>"
                            class="btn btn-danger input-sm center-text" role="button">Delete</a>
                    </td>
                </tr>
                <?php }} else {?>

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
