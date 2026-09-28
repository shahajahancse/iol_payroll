<div class="content">

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
                <a class="navbar-brand" href="<?php echo base_url("setup_con/shift_management");?>">Back To
                    List</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <!-- <li class="active"><a href="<?php echo base_url("payroll_con");?>">Home</a></li> -->
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

    <h3>Update Shift </h3>
    <hr>
    <form action="<?= base_url('setup_con/shiftmanagement_edit/'.$pr_emp_shift->id)?> " enctype="multipart/form-data" method="post"
        name="creatsection">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label>Shift Name</label>
                    <input type="text" name="shift_name" value="<?= $pr_emp_shift->shift_name ?>" placeholder="Shift Name "
                        class="form-control">
                    <?=(isset($failuer['shift_name'])) ? '<div class="alert alert-failuer">' . $failuer['shift_name'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                    <select name="unit_id" onchange="get_data()" id="unit_id" class="form-control input-lg select22">
                        <option value="">Select Unit</option>
                        <?php foreach ($pr_units as $key => $value) {?>
                        <option value="<?php echo $value->unit_id; ?>" <?= ($value->unit_id == $pr_emp_shift->unit_id) ? 'selected' : ''; ?>><?php echo $value->unit_name; ?></option>
                        <?php } ?>
                    </select>
                    <?= (isset($failuer['unit_id'])) ? '<div class="alert alert-failuer">' . $failuer['unit_id'] . '</div>' : ''; ?>
                </div>
                <div class="form-group">
                    <select name="shift_type" id="shift_type" class="form-control input-lg select22">
                        <option value="">Select Shift Type</option>
                        <?php foreach ($shift_type as $key => $value) {?>
                        <option value="<?php echo $value->id; ?>" <?= ($value->id == $pr_emp_shift->schedule_id) ? 'selected' : ''; ?>><?php echo $value->sh_type; ?></option>
                        <?php } ?>
                    </select>
                    <?= (isset($failuer['shift_type'])) ? '<div class="alert alert-failuer">' . $failuer['shift_type'] . '</div>' : ''; ?>
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
<script>
function get_data() {
    var unit_id = $('#unit_id').val();
    $.ajax({

        url: "<?php echo base_url('setup_con/get_shift') ?>",
        method: "POST",
        data: {
            unit_id: unit_id
        },
        success: function(data) {
            $('#shift_type').val('').trigger('change');
            var parsedData = JSON.parse(data);
            console.log(parsedData);
            var item;
            if (parsedData.length != 0) {
                for (var i = 0; i < parsedData.length; i++) {
                    item+='<option value="'+parsedData[i].id+'">'+parsedData[i].sh_type+'</option>';
                }
            }
            $('#shift_type').html(item);
        }
    })
}
</script>
