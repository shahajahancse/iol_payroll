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
                    <a class="btn btn-info" href="<?php echo base_url('entry_system_con/advance_loan_form') ?>">Add Loan / Tax</a>
                    <a class="btn btn-success" href="<?php echo base_url('entry_system_con/advance_loan') ?>">Go => Loan List</a>
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
                    <tr>
                        <th>SL</th>
                        <th>Emp name </th>
                        <th>Emp Id</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Unit name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)) { foreach ($results as $key => $r) {?>
                    <tr>
                        <td><?php echo $key + 1  ?></td>
                        <td><?php echo $r->name_en ?></td>
                        <td><?php echo $r->emp_id ?></td>
                        <td><?php echo $r->amount ?></td>
                        <td><?php echo date('d-m-Y', strtotime($r->effect_date)) ?></td>
                        <td><?php echo $r->unit_name ?></td>
                        <td><?php echo ($r->status == 1)? "Active":'Inactive'; ?></td>
                    </tr>
                    <?php }} else {?>
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
        oTable.search($(this).val()).draw();
    })
});
</script>
