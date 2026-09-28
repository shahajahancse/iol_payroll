<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="tablebox">
            <?php
            if (!empty($user_data->unit_name)) {
                $depts = $this->db->where('unit_id', $user_data->unit_name);
            }
            $depts = $this->db->get('emp_depertment')->result();
            ?>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Unit <span style="color: red;">*</span> </label>
                        <select name="unit_id" id="unit_id" class="form-control input-sm" required>
                            <option>Select Unit</option>
                            <?php
                            foreach ($units as $row) {
                                if ($row->unit_id == $user_data->unit_name) {
                                    $select_data = "selected";
                                } else {
                                    $select_data = '';
                                }
                                echo '<option ' . $select_data . '  value="' . $row->unit_id . '">' . $row->unit_name .
                                    '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Department <span style="color: red;">*</span> </label>
                        <?php echo form_error('dept_id'); ?>
                        <select name="dept_id" id="dept_id" class="dept_id form-control input-sm" required>
                            <option>-- Select Department --</option>
                            <?php foreach ($depts as $key => $row) { ?>
                                <option value="<?= $row->dept_id ?>"><?= $row->dept_name . ' >>' . $row->dept_bangla; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Section <span style="color: red;">*</span> </label>
                        <?php echo form_error('section_id'); ?>
                        <select name="section_id" id="section_id" class="section_id form-control input-sm" required>
                            <option>-- Select Section --</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Line<span style="color: red;">*</span> </label>
                        <?php echo form_error('line_id'); ?>
                        <select name="line_id" id="line_id" class="line_id form-control input-sm" required>
                            <option>-- Select Line --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
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

    <div id="target-div" class="row tablebox" style="display: none;">
    </div>
</div>


<script>
    function check_level(e) {
        var is_check    = 0;
        if (e.checked) { is_check= 1; }
        var id          = $(e).val();
        var unit_id     = $('#unit_id').val();
        var dept_id     = $('#dept_id').val();
        var section_id  = $('#section_id').val();
        var line_id     = $('#line_id').val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('setup_con/manage_designation_add_ajax') ?>",
            data: {
                unit_id     : unit_id,
                dept_id     : dept_id,
                section_id  : section_id,
                line_id     : line_id,
                id          : id,
                is_check    : is_check,
            },
            success: function(data) {
                console.log('success');
            }
        })
    }
</script>

<script type="text/javascript">
    //Designation dropdown
    $('#line_id').change(function() {
        var unit_id = $('#unit_id').val();
        var dept_id = $('#dept_id').val();
        var section_id = $('#section_id').val();
        var line_id = $('#line_id').val();
        $.ajax({
            type: "POST",
            data: {
                unit_id: unit_id,
                dept_id: dept_id,
                section_id: section_id,
                line_id: line_id,
            },
            url: hostname + "setup_con/manage_designation_list_ajax/",
            success: function(func_data) {
                $('#target-div').show().empty().html(func_data);
            }
        });
    });

    //Line dropdown
    $('#section_id').change(function() {
        $('.line_id').addClass('form-control input-sm');
        $(".line_id > option").remove();
        var id = $('#section_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_line_by_sec_id/" + id,
            success: function(func_data) {
                $('.line_id').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.line_id').append(opt);
                });
            }
        });
    });

    //section dropdown
    $('#dept_id').change(function() {
        $('.section_id').addClass('form-control input-sm');
        $(".section_id > option").remove();
        $(".line_id > option").remove();
        var id = $('#dept_id').val();
        var unit_id = $('#unit_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_section_by_dept_id/" + id + '/' + unit_id,
            success: function(func_data) {
                $('.section_id').append("<option value=''>-- Select District --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.section_id').append(opt);
                });
            }
        });
    });

    //Department dropdown
    $('#unit_id').change(function() {
        $('.dept_id').addClass('form-control input-sm');
        $(".dept_id > option").remove();
        $(".section_id > option").remove();
        $(".line_id > option").remove();
        var id = $('#unit_id').val();
        $.ajax({
            type: "POST",
            url: hostname + "common/ajax_department_by_unit_id/" + id,
            success: function(func_data) {
                $('.dept_id').append("<option value=''>-- Select Department --</option>");
                $.each(func_data, function(id, name) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(name);
                    $('.dept_id').append(opt);
                });
            }
        });
    });
</script>
