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
                    <a class="btn btn-info" href="<?php echo base_url('training_con/training') ?>">
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
    <div class="row">
        <?php
            $failuer = $this->session->flashdata('failure');
            ?>
    </div>
    <div class="tablebox">

        <h3>Update Training</h3>
        <hr>

        <form action="<?= base_url(uri_string())?>" enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" id="unit_id" class="form-control">
                            <option value="">Select Unit</option>
                            <?php foreach ($unit as $key => $value) {
                            ?>
                            <option value="<?php echo $value->unit_id; ?>" <?= $value->unit_id == $training->unit_id ? 'selected' : '' ?>><?php echo $value->unit_name; ?></option>
                            <?php } ?>
                        </select>
                        <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Title</label>
                        <input type="text" name="title" value="<?= $training->title ?>" placeholder="Title"
                            class="form-control">
                        <?=(isset($failuer['title'])) ? '<div class="alert alert-failuer">' . $failuer['title'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea name="description" id="description" style="height: 100px; width: 100%;"  class="form-control"><?= $training->description ?></textarea>
                    </div>

                </div>
                <div class="form-group" style="text-align: -webkit-right;padding-right: 30px;">
                        <button type="submit" class="btn btn-primary ">Submit</button></button>
                        <a href="" class="btn-warning btn">Cancel</a>
                </div>
                </div>
            </div>
        </form>
    </div>
</div>
