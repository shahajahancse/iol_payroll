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
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/attendance_bonus') ?>">
                        < < Back</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                </div>
            </div>
            <div class="col-md-6">
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="">
                        <form class="navbar-form pull-right" role="search">
                            <div class="input-group">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
    <?php $failuer = $this->session->flashdata('failure');?>
    <div class="tablebox">
        <h3>Update Attendance Bonus</h3>
        <form action="<?= base_url('setup_con/attn_bonus_edit').'/'.$attbn->id?> "
            enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-3">
                            <label for="unit_id">Unit</label>
                            <select name="unit_id" id="unit_id" class="form-control">
                                <option value="">Select Unit</option>
                                <?php foreach ($pr_units as $key => $value) {?>
                                <option value="<?php echo $value->unit_id; ?>"
                                    <?= ($value->unit_id == $attbn->unit_id) ? 'selected' : '' ?>>
                                    <?php echo $value->unit_name; ?></option>
                                <?php } ?>
                            </select>
                            <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Rule Name</label>
                            <input type="text" name="rule_name" value="<?php echo $attbn->rule_name; ?>"
                                placeholder="Rule Name" class="form-control">
                            <?=(isset($failuer['rule_name'])) ? '<div class="alert alert-failuer">' . $failuer['rule_name'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Prev Attendance Amt</label>
                            <input type="text" name="prev_rule" value="<?php echo $attbn->prev_rule; ?>"
                                placeholder="Rule Name" class="form-control">
                            <?=(isset($failuer['prev_rule'])) ? '<div class="alert alert-failuer">' . $failuer['prev_rule'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Prev End Date</label>
                            <input type="text" name="prev_end" value="<?php echo $attbn->prev_end; ?>"
                                placeholder="Rule Name" class="form-control date">
                            <?=(isset($failuer['prev_end'])) ? '<div class="alert alert-failuer">' . $failuer['prev_end'] . '</div>' : ''; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-3">
                            <label>Last Amt</label>
                            <input type="text" name="rule1" value="<?php echo $attbn->rule1; ?>"
                                placeholder="Rule Name" class="form-control">
                            <?=(isset($failuer['rule1'])) ? '<div class="alert alert-failuer">' . $failuer['rule1'] . '</div>' : ''; ?>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Last End Date</label>
                            <input type="text" name="rule1_end" value="<?php echo $attbn->rule1_end; ?>"
                                placeholder="Rule Name" class="form-control date">
                            <?=(isset($failuer['rule1_end'])) ? '<div class="alert alert-failuer">' . $failuer['rule1_end'] . '</div>' : ''; ?>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Current Amt</label>
                            <input type="text" name="rule" value="<?php echo $attbn->rule; ?>" placeholder="Rule"
                                class="form-control">
                            <?=(isset($failuer['rule'])) ? '<div class="alert alert-failuer">' . $failuer['rule'] . '</div>' : ''; ?>
                        </div>
                    </div>

                    <div class="form-group footer_button">
                        <button type="submit" class="btn btn-primary ">Submit</button></button>
                        <a href="<?php echo base_url('setup_con/attendance_bonus') ?>"
                            class="btn-warning btn">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
