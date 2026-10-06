<script src="<?php echo base_url(); ?>js/grid_content.js" type="text/javascript"></script>
<style>
    #fileDiv #removeTr td {
        padding: 5px 10px !important;
        font-size: 14px;
    }
</style>
<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->


<?php
// $this->load->model('common_model');
// $unit = $this->common_model->get_unit_id_name();
?>
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <?php $success = $this->session->flashdata('success');
            if ($success != "") { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
            $error = $this->session->flashdata('error');
            if ($error) { ?>
                <div class="alert alert-failuer"><?php echo $error; ?></div>
            <?php } ?>
        </div>
    </div>
    <!-- <div class="container-fluid">	 -->
    <div class="row tablebox" style="display: block;">
        <!-- <h3 style="font-weight: 600;"><?= $title ?></h3> -->
        <input type="hidden" name="unit_id" id="unit_id" value="1">
        <!-- department -->
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 10px !important;">
                <label>Department </label>
                <select class="form-control input-sm dept" id='dept' name='dept'>
                    <?php 
                        $dpts = $this->db->where('unit_id', 1)->get('emp_depertment'); ?>
                        <option value=''>Select Department</option>
                        <?php foreach ($dpts->result() as $key => $val) { ?>
                            <option value='<?= $val->dept_id ?>'><?= $val->dept_name ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <!-- section -->
        <div class="col-md-6">
            <div class="form-group" style="margin-bottom: 10px !important;">
                <label class="control-label">Section </label>
                <select class="form-control input-sm section" id='section' name='section'>
                    <option value=''></option>
                </select>
            </div>
        </div>
        <!-- line (hidden) -->
        <input type="hidden" class="line" id="line" name="line" value="0">
    </div>
    <br>
    <div id="loader" align="center" style="margin:0 auto; overflow:hidden; display:none; margin-top:5px;">
        <img src="<?php echo base_url('images/ajax-loader.gif'); ?>" />
    </div>

    <!-- present entry form -->
    <div id="present_entry" class="row nav_head" style="margin-top: 13px;">
        <div class="col-md-12" style="display: flex;gap: 11px;flex-direction: column;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Designation Name</th>
                        <th>Hide / Show</th>
                    </tr>
                </thead>
                <tbody id="desig_tbody">

                </tbody>
            </table>
        </div>
    </div>

    <style>
        .hints {
            color: #436D19;
            font-weight: bold;
        }
    </style>
    <!-- eot entry form   -->
</div>

<script>
    function loading_open() {
        $('#loader').css('display', 'block');
    }
</script>
<script type="text/javascript">
    // on load employee
function call_hide(el){
    var id=$(el).val();
    var status=1;

    var status;
    if ($(el).prop('checked')) {
        status = 0;
    } else {
        status = 1;
    }

    $.ajax({
        type: "POST",
        url: hostname + "setting_con/hide_designation/" + id + "/" + status,
        success: function(data) {
            console.log(data);
        }
    });

}

        function load_designation_table() {
            $('#desig_tbody').empty();
            var id = $('#line').val() || 0;
            var unit_id = $('#unit_id').val() || 1;
            var dept = $('#dept').val() || '';
            var section = $('#section').val() || '';

            $.ajax({
                type: "POST",
                url: hostname + "common/ajax_designation_by_line_id_h/" + id + "/" + unit_id + "/" + dept + "/" + section,
                success: function(func_data) {
                    if (!func_data) {
                        console.error("func_data is null or undefined");
                        return;
                    }
                    $('#desig_tbody').empty();
                    var tr = '';
                    try {
                        for (var i = 0; i < func_data.length; i++) {
                            var td1 = func_data[i].desig_name || "null";
                            var td2 = func_data[i].designation_id || "null";
                            var td3 = func_data[i].hide_status;
                            var tr_checked = (td3 == 0) ? 'checked' : '';
                            tr += `<tr>
                                        <td>
                                            <span class="hints">${td1}</span>
                                        </td>
                                        <td>
                                            <input type="checkbox" class="checkbox" id="emp_id" name="emp_id[]" value="${td2}" ${tr_checked} onclick="call_hide(this)">
                                        </td>
                                    </tr>`;
                        }
                    } catch (e) {
                        console.error("error while generating tr, error: ", e);
                    }
                    $('#desig_tbody').append(tr);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("jqXHR: ", jqXHR);
                    console.error("textStatus: ", textStatus);
                    console.error("errorThrown: ", errorThrown);
                }
            });
        }

        $(document).ready(function() {
            load_designation_table();

            $('#section').change(function() {
                load_designation_table();
            });

            $('#dept').change(function() {
                $('.section').addClass('form-control input-sm');
                $(".section > option").remove();
                var id = $('#dept').val();
                $.ajax({
                    type: "POST",
                    url: hostname + "common/ajax_section_by_dept_id/" + id,
                    success: function(func_data) {
                        $('.section').append("<option value=''>-- Select Section --</option>");
                        $.each(func_data, function(id, name) {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(name);
                            $('.section').append(opt);
                        });
                    }
                });
                load_designation_table();
            });
        });
    </script>

