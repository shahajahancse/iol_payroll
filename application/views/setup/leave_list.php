
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
            <div class="navbar-header col-md-6">
              <div>
                <a class="btn btn-info" href="<?php echo base_url('setup_con/leave_add') ?>">Add Leave</a>
                <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
              </div>
            </div>
            <div class="col-md-9">
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
            <?php } ?>
        </div>
    </div>
    <!-- <br> -->
    <div class="row tablebox">
        <div class="col-md-6" style="margin-left:-16px">
            <h4 style="font-weight:bold">Leave List</h4>
        </div>

        <!-- <div class="col-md-12"> -->
            <table class="table" id="mytable">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Leave Name</th>
                        <th>Unit Name</th>
                        <th>Sick Leave</th>
                        <th>Casual Leave</th>
                        <th>Maternity Leave</th>
                        <th>Paternity Leave</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($pr_leave)){ foreach($pr_leave as $pr_leaves){?>
                    <tr>
                        <td><?php echo @++$i ?></td>
                        <td><?php echo $pr_leaves['lv_name'] ?></td>
                        <td><?php echo $pr_leaves['unit_name'] ?></td>
                        <td><?php echo $pr_leaves['lv_sl'] ?></td>
                        <td><?php echo $pr_leaves['lv_cl'] ?></td>
                        <td><?php echo $pr_leaves['lv_ml'] ?></td>
                        <td><?php echo $pr_leaves['lv_pl'] ?></td>
                        <td>
                            <a href="<?=base_url('setup_con/leave_edit').'/'.$pr_leaves["lv_id"]?>"
                                class="btn btn-primary input-sm center-text" role="button">Edit</a>
                        </td>
                        <td>
                            <a href="<?=base_url('setup_con/leave_delete').'/'.$pr_leaves["lv_id"]?>"
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
        <!-- </div> -->
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
