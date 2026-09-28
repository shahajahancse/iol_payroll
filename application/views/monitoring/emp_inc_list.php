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
        /* line-height: 40px; Should be equal to the button's height */

    }
</style>

<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5" style="padding: 7px;">
                <div>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                    <a style="font-size: 16px; font-weight: bold;">Promotion / Increment / Line List</a>
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

    <div class="col-md-12">
        <?php
            $success = $this->session->flashdata('success');
            if ($success != "") {
        ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php }
            $failuer = $this->session->flashdata('failuer');
            if ($failuer) {
        ?>
        <div class="alert alert-failuer"><?php echo $failuer; ?></div>
        <?php }  ?>
    </div>

    <div id="target-div" class="row tablebox table-responsive">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Emp Id </th>
                    <th>Name</th>
                    <th>DOJ</th>
                    <th>Old Line</th>
                    <th>New Line</th>
                    <th>Old Designation</th>
                    <th>New Designation</th>
                    <th>Old Salary</th>
                    <th>Increment</th>
                    <th>New Salary</th>
                    <th>Effective Date</th>
                    <th>status</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($results)) {foreach ($results as $key => $r) {?>
                    <?php if ($r->status == 1) {
                        $status = "Increment";
                    } else if ($r->status == 2) {
                        $status = "Promotion";
                    } else if ($r->status == 3) {
                        $status = "Line Change";
                    } else {
                        $status = "Special Increment";
                    } ?>
                    <tr>
                        <td><?php echo $key + 1  ?></td>
                        <td> <?php echo $r->emp_id ?></td>
                        <td> <?php echo $r->name_en ?></td>
                        <td> <?php echo date('d-m-Y', strtotime($r->emp_join_date)) ?></td>
                        <td> <?php echo $r->line_name_en ?></td>
                        <td> <?php echo $r->new_line ?></td>
                        <td> <?php echo $r->desig_name ?></td>
                        <td> <?php echo $r->new_desig ?></td>
                        <td> <?php echo $r->prev_salary ?></td>
                        <td> <?php echo ($r->new_salary - $r->prev_salary) ?></td>
                        <td> <?php echo $r->new_salary ?></td>
                        <td> <?php echo date('d-m-Y', strtotime($r->effective_month)) ?></td>
                        <td> <?php echo $status ?></td>
                        <td>
                            <a onclick="return confirm('Are you sure you want to approve this?') ? approves(this, '<?= $r->emp_id ?>', '<?= $r->effective_month ?>') : false;" class="btn btn-primary center-text" role="button">Approve</a>
                        </td>
                        <td>
                            <a onclick="return confirm('Are you sure you want to delete this?') ? deletes(this, '<?= $r->emp_id ?>', '<?= $r->effective_month ?>') : false;" class="btn btn-danger center-text" role="button">Delete</a>
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

<script>
    function approves(el, emp_id, effective_month) {
        $.ajax({
            type: "POST",
            url: hostname + "monitoring_con/approve_emp_ipl",
            data: {
                emp_id: emp_id,
                effective_month: effective_month
            },
            success: function(data) {
                if (data == 'success') {
                    $(el).closest('tr').remove();
                    showMessage('success', 'Updated Successfully');
                }else {
                    showMessage('error', 'Sorry! Not Updated');
                }
            } ,
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                showMessage('error', 'Sorry! Not Updated');
            }
        })
    }
    function deletes(el, emp_id, effective_month) {
        $.ajax({
            type: "POST",
            url: hostname + "monitoring_con/delete_emp_ipl",
            data: {
                emp_id: emp_id,
                effective_month: effective_month
            },
            success: function(data) {
                if (data == 'success') {
                    $(el).closest('tr').remove();
                    showMessage('success', 'Deleted Successfully');
                }else {
                    showMessage('error', 'Sorry! Not Deleted');
                }
            } ,
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
                showMessage('error', 'Sorry! Not Deleted');
            }
        })
    }
</script>

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
