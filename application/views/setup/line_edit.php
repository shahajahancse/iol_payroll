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
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/line') ?>"> << Back </a>
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

        <h3>Update Line</h3>
        <hr>

        <form action="<?= base_url(uri_string())?>" enctype="multipart/form-data" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group col-md-4">
                        <label for="unit_id">Unit</label>
                        <select name="unit_id" id="unit_id" onchange="getDepertment(this.value)" class="form-control">
                            <option value="">Select Unit</option>
                            <?php foreach ($unit as $key => $value) { ?>
                            <option value="<?php echo $value->unit_id; ?>" <?= $value->unit_id == $line->unit_id ? 'selected' : '' ?>><?php echo $value->unit_name; ?></option>
                            <?php } ?>
                        </select>
                        <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Department</label>
                        <select name="depertment_id" id="depertment_id" onchange="get_section(this.value)"
                            class="form-control">
                            <option value="">Select Depertment</option>
                        </select>
                        <?= (isset($failuer['depertment_id'])) ? '<div class="alert alert-failuer">' . $failuer['depertment_id'] . '</div>' : ''; ?>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="">Section</label>
                        <select name="section_id" id="section_id">
                            <option value="">Select Section</option>
                        </select>
                        <?= (isset($failuer['section_id'])) ? '<div class="alert alert-failuer">' . $failuer['section_id'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">

                        <label>Line Name Bangla</label>
                        <input type="text" name="line_name_bn" value="<?= $line->line_name_bn ?>" placeholder="Section Name Bangla" class="form-control bfont">
                        <?=(isset($failuer['line_name_bn'])) ? '<div class="alert alert-failuer">' . $failuer['line_name_bn'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Line Name English</label>
                        <input type="text" name="line_name_en" value="<?= $line->line_name_en ?>" placeholder="Section Name english"
                            class="form-control">
                        <?=(isset($failuer['line_name_en'])) ? '<div class="alert alert-failuer">' . $failuer['line_name_en'] . '</div>' : ''; ?>
                    </div>
                                    <div class="form-group col-md-4">
                        <label>Operator Budget</label>
                        <input type="number" name="group_one" value="<?= $line->group_one ?>" placeholder="Enter Man Power" class="form-control efont">
                        <?=(isset($failuer['group_one'])) ? '<div class="alert alert-failuer">' . $failuer['group_one'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Asst. Operator Budget</label>
                        <input type="number" name="group_two" value="<?= $line->group_two ?>" placeholder="Enter Man Power" class="form-control efont">
                        <?=(isset($failuer['group_two'])) ? '<div class="alert alert-failuer">' . $failuer['group_two'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Line Ironman Budget</label>
                        <input type="number" name="group_three" value="<?= $line->group_three ?>" placeholder="Enter Man Power" class="form-control efont">
                        <?=(isset($failuer['group_three'])) ? '<div class="alert alert-failuer">' . $failuer['group_three'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Input Budget</label>
                        <input type="number" name="group_four" value="<?= $line->group_four ?>" placeholder="Enter Man Power" class="form-control efont">
                        <?=(isset($failuer['group_four'])) ? '<div class="alert alert-failuer">' . $failuer['group_four'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Supervisor Budget</label>
                        <input type="number" name="group_five" value="<?= $line->group_five ?>" placeholder="Enter Man Power" class="form-control efont">
                        <?=(isset($failuer['group_five'])) ? '<div class="alert alert-failuer">' . $failuer['group_five'] . '</div>' : ''; ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label>LIne Chief Budget</label>
                        <input type="number" name="group_six" value="<?= $line->group_six ?>" placeholder="Enter Man Power" class="form-control efont">
                        <?=(isset($failuer['group_six'])) ? '<div class="alert alert-failuer">' . $failuer['group_six'] . '</div>' : ''; ?>
                    </div>
                    <br>

                </div>
                    <div class="form-group" style="margin-left: 15px;">
                        <button type="submit" class="btn btn-primary ">Submit</button></button>
                        <a href="" class="btn-warning btn">Cancel</a>
                    </div>
            </div>
        </form>
    </div>
</div>
<script>
    function getDepertment(unit_id) {
        $.ajax({
            url: "<?php echo base_url('setup_con/get_department') ?>",
            method: "POST",
            data: {
                unit_id: unit_id
            },
            success: function(data) {
                var parsedData = JSON.parse(data);
                var item = '<option value="">Select Depertment</option>';
                for (let index = 0; index < parsedData.length; index++) {
                    item +=
                        `<option value="${parsedData[index].dept_id}">${parsedData[index].dept_name}</option>`
                }
                $('#depertment_id').html(item);
                $('#depertment_id').val('<?= $line->dept_id ?>');
            }
        })
        get_section(<?= $line->dept_id ?>)
    }

    function get_section(depertment_id) {
        $.ajax({
            url: "<?php echo base_url('setup_con/get_section') ?>",
            method: "POST",
            data: {
                depertment_id: depertment_id
            },
            success: function(data) {
                var parsedData = JSON.parse(data);
                var item = '<option value="">Select Section</option>';
                for (let index = 0; index < parsedData.length; index++) {
                    item +=
                        `<option value="${parsedData[index].id}">${parsedData[index].sec_name_en}</option>`
                }
                $('#section_id').html(item);
                $('#section_id').val('<?= $line->section_id ?>');
            }
        })
    }

    getDepertment(<?= $line->unit_id ?>)
</script>
