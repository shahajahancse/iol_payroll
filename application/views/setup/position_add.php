
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
    }
    table.dataTable tbody th, table.dataTable tbody td {
      padding: 4px !important;
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
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/position') ?>"><< Back</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
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

    <div class="row tablebox">
        <div class="col-md-12">
          <h4 style="font-weight:bold">Add Position</h4>
        </div>
        <form action="<?php echo base_url('setup_con/position_add') ?>" method="post">
            <div class="form-group col-md-4">
                <label for="unit_id">Unit</label>
                <select name="unit_id" id="unit_id" class="form-control">
                    <option value="">Select Unit</option>
                    <?php foreach ($pr_units as $key => $value) {
                    ?>
                    <option value="<?php echo $value->unit_id; ?>"><?php echo $value->unit_name; ?></option>
                    <?php } ?>
                </select>
                <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
            </div>
            <div class="form-group col-md-4">
                <label>Position Name (English)</label>
                <input type="text" name="posi_name" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
                <label>Position Name (Bangla)</label>
                <input type="text" name="posi_name_bn" class="form-control" required>
            </div>

            <div class="col-md-12">
                <div class="pull-right">
                    <div class="form-group">
                        <a href="<?= base_url('setup_con/position_add') ?>" class="btn-warning btn">Cancel</a>
                        <button type="submit" class="btn btn-primary ">Submit</button></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <br><br>
</div>
