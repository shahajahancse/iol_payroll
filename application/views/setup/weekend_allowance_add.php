<div class="content" style="padding-top: 10px;">
    <!-- Static navbar -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo base_url('setup_con/weekend_allowance_setup')?>">Back To
                    List</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <!-- <li class="active"><a href="<?php echo base_url('payroll_con')?>">Home</a></li> -->
                </ul>

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
            $failuer = $this->session->flashdata('failure');
            ?>
        </div>
    </div>

    <h3>Create Holyday/Weekend Allowance</h3>
    <hr>
    <form action="<?= base_url('setup_con/weekend_allowance_add')?>" enctype="multipart/form-data" method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <select name="unit_id" id="unit_id" class="form-control input-lg select22">
                        <option value="">Select Unit</option>
                        <?php foreach ($pr_units as $key => $value) {
                    ?>
                        <option value="<?php echo $value->unit_id; ?>"><?php echo $value->unit_name; ?></option>
                        <?php } ?>
                    </select>
                    <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">

                    <label>Rule Name</label>
                    <input type="text" name="rule_name" value="" placeholder="Rule Name" class="form-control">
                    <?=(isset($failuer['rule_name'])) ? '<div class="alert alert-failuer">' . $failuer['rule_name'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" name="rule" value="" placeholder="Rule" class="form-control">
                    <?=(isset($failuer['rule'])) ? '<div class="alert alert-failuer">' . $failuer['rule'] . '</div>' : ''; ?>
                </div>
                <br>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary ">Submit</button></button>
                    <a href="" class="btn-warning btn">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
