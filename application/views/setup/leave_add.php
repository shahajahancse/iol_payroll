<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-3" style="padding: 7px;">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/leave_setup') ?>">< < Back</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                </div>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
    <div class="row">
        <?php
            $failuer = $this->session->flashdata('failure');
            ?>
    </div>
    <div class="tablebox">
    <h3>Create Attendance Bonus</h3>
    <form action="<?= base_url('setup_con/leave_add')?>" enctype="multipart/form-data" method="post">
    <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="form-group col-md-6">
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
                    <div class="form-group col-md-6">

                        <label>Leave Name</label>
                        <input required type="text" name="leave_name" value="" placeholder="Leave Name" class="form-control">
                        <?=(isset($failuer['leave_name'])) ? '<div class="alert alert-failuer">' . $failuer['leave_name'] . '</div>' : ''; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-3">
                        <label>Sick Leave</label>
                        <input required type="number" name="sick_leave" value="" placeholder="Sick Leave" class="form-control">
                        <?=(isset($failuer['sick_leave'])) ? '<div class="alert alert-failuer">' . $failuer['sick_leave'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Casual Leave</label>
                        <input required type="number" name="casual_leave" value="" placeholder="Casual Leave" class="form-control">
                        <?=(isset($failuer['casual_leave'])) ? '<div class="alert alert-failuer">' . $failuer['casual_leave'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Maternity Leave</label>
                        <input required type="number" name="maternity_leave" value="" placeholder="Maternity Leave" class="form-control">
                        <?=(isset($failuer['maternity_leave'])) ? '<div class="alert alert-failuer">' . $failuer['maternity_leave'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Special Leave</label>
                        <input required type="number" name="special_leave" value="" placeholder="Special Leave" class="form-control">
                        <?=(isset($failuer['special_leave'])) ? '<div class="alert alert-failuer">' . $failuer['special_leave'] . '</div>' : ''; ?>
                    </div>
                </div>
                <br>

                <div class="form-group footer_button">
                    <button type="submit" class="btn btn-primary ">Submit</button></button>
                    <a href="" class="btn-warning btn">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
