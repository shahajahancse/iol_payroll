
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
                    <a style="font-size: 16px; font-weight: bold;"> Manual Entry List</a>
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

    <div id="target-div" class="row tablebox">
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Punch Id </th>
                    <th>Date</th>
                    <th>Time</th>
                    <th width="80">Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!empty($results)) {foreach ($results as $key => $r) {?>
                    <tr>
                        <td><?php echo $key + 1  ?></td>
                        <td> <?php echo $r->proxi_id ?></td>
                        <td> <?php echo date('d-m-Y', strtotime($r->date_time)) ?></td>
                        <td> <?php echo date('h:i s', strtotime($r->date_time)) ?></td>
                        <td>
                            <a href="javascript:void(0);"
                            class="btn btn-primary center-text approve-btn"
                            data-id="<?= $r->id ?>"
                            data-time="<?= htmlspecialchars($r->date_time, ENT_QUOTES) ?>">
                            Approve </a>
                        </td>

                        <td>
                            <a href="javascript:void(0);"
                            class="btn btn-danger center-text delete-btn"
                            data-id="<?= $r->att_id ?>"
                            data-date="<?= $r->date_time ?>"
                            role="button">Delete</a>
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
    $(document).on('click', '.approve-btn', function() {

        if (!confirm('Are you sure you want to approve this?')) {
            return false;
        }

        var el = this;
        var att_id = $(this).data('id');
        var date_time = $(this).data('time');

        $.ajax({
            type: "POST",
            url: hostname + "monitoring_con/approves",
            data: {
                id: att_id,
                date_time: date_time
            },
            success: function(data) {
                if (data == 'success') {
                    $(el).closest('tr').remove();
                    showMessage('success', 'Updated Successfully');
                } else {
                    showMessage('error', 'Sorry! Not Updated');
                }
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                showMessage('error', 'Sorry! Not Updated');
            }
        });

    });
</script>

<script>
    $(document).on('click', '.delete-btn', function () {
        if(confirm('Are you sure you want to delete this?')){
            var att_id = $(this).data('id');
            var date_time = $(this).data('time');
            deletes(this, id, date);
        }
    });

    function deletes(el, att_id, date_time) {
        $.ajax({
            type: "POST",
            url: hostname + "monitoring_con/deletes",
            data: {
                id: att_id,
                date_time: date_time,
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
