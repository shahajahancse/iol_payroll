<style>
#mytable {
    border-collapse: collapse;
}

#mytable,
th,
td {
    border: 1px solid #b0c0df;
    text-align: center;
    vertical-align: middle !important;
}

.table td {
    padding: 0px 3px !important;
    font-size: 13px;

}

table.dataTable thead th,
table.dataTable thead td {
    border-bottom: none;
}

table.dataTable tbody th,
table.dataTable tbody td {
    padding: 4px !important;
}

.center-text {
    vertical-align: center;
    padding: 5px 10px;
    /* line-height: 40px; Should be equal to the button's height */
}
</style>

<div class="content" style="display: flex;flex-direction: column;gap: 10px">
    <div class="row">
        <div class="col-md-8">
            <?php $success = $this->session->flashdata('success');
            if ($success != "") { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
            $failuer = $this->session->flashdata('failuer');
            if ($failuer) { ?>
                <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php } ?>
        </div>
    </div>
       <!-- < ?php dd($units);?> -->
    <div class="row tablebox" style="display: flex;flex-direction: row;">
        <div class="col-md-6">
            <h4 style="font-weight:bold">Report Setting</h4>
        </div>
        <div class="col-md-6" style="text-align-last: right;">
            <a class="btn btn-primary" onclick="add_report_setting('add')"><i class="fa fa-plus"></i> Add</a>
        </div>
    </div>
 
    <div id="add_form" class="row tablebox " style="display: none">

        <form action="" method="post" id="report_setting_form">
            <div class="col-md-12">
                <div class="form-group col-md-2">
                    <label for="acl_name">Select Unit</label>
                    <select class="form-control input-sm" name="unit_id" id="unit_id" required>
                        <option value="">Select</option>
                        <!-- < ?php  foreach($units as $key => $value) {  dd($value)?>
                        <option value="< ?= $value['unit_id'] ?>">< ?= $value['unit_name'] ?></option>
                        < ?php } ?> -->

                        <?php 
                        // dd($users);
                        foreach($units as $key => $value) {
                        $selected = ($value['unit_id'] == $_SESSION['data']->unit_name) ? 'selected' : 'style="display:none;"';
                        ?>
                         <option value="<?= $value['unit_id'] ?>" <?= $selected ?>><?= $value['unit_name'] ?></option>
                        <!-- <option value="< ?= $value->id ?>" >< ?php echo $value->id_number.' >> '.$value->unit_name?></option> -->
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="acl_name">First Date</label>
                    <input class="form-control input-sm date" id="first_date" name="date" required autocomplete="off">
                </div>
                <div class="form-group col-md-2">
                    <label for="acl_name">Second Date</label>
                    <input class="form-control input-sm date" id="second_date" name="end_date" required autocomplete="off">
                </div>
                <div class="form-group col-md-1">
                    <label for="acl_name">Max OT</label>
                    <input class="form-control input-sm" type="number" name="max_ot" id="max_ot" max="24" min="0" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="acl_name">Type</label>
                    <select class="form-control input-sm" id="type" name ="type" required>
                        <option value="">Select type</option>
                        <option value="1">7pm job card</option>
                        <option value="3">9pm job card</option>
                        <option value="3">12am job card</option>
                        <option value="4">all wo week</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="acl_name">Select Status</label>
                    <select class="form-control input-sm" id="active_status" name ="active_status" required>
                        <option value="">Select Status</option>
                        <option value="1">Enable</option>
                        <option value="2">Disable</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="acl_name" style="co">.</label>
                    <input type="submit" value="Submit" class="btn btn-success pull-right" style="padding: 4px 12px !important;">
                </div>
            </div>
        </form>
    </div>
    <div id="target-div" class="row tablebox">
        <div class="col-md-12" style="display: flex;flex-direction: row;">
            <div class="col-md-6" style="">
                <h3 style="font-weight:bold">Access List</h3>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <input type="text" placeholder="Search" name="deptSearch" id="deptSearch">
            </div>
        </div>
        <table class="table" id="mytable">
            <thead>
                <tr>
                    <th>Sl. No.</th>
                    <th>Unit name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Max OT</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php  foreach($data as $key => $value) { ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $value['unit_name'] ?></td>
                    <td><?= date('d-m-Y', strtotime($value['date'])) ?></td>
                    <td><?= date('d-m-Y', strtotime($value['end_date'])) ?></td>
                    <td><?= $value['max_ot'] ?></td>
                    <td>
                        <?php if($value['type'] == 1){
                            echo "9pm job card";
                        }else if($value['type'] == 2){
                            echo "12am job card";
                        }else {
                            echo "all wo week";
                        } ?>
                    </td>
                    <td>
                        <?php if($value['status'] == 1){
                            echo "Enable";
                        }else{
                            echo "Disable";
                        } ?>
                    </td>
                    <td>
                        <a class="btn btn-primary" onclick="add_report_setting('edit',<?= $value['id'] ?>)"> Edit </a>
                        <a class="btn btn-danger" onclick="delete_user_mode(<?= $value['id'] ?>,this)"><i class="fa fa-trash"></i>Delete</a>
                    </td>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
<input type="hidden" name="ancor" id="ancor" value=0>
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
<script>
    function add_report_setting(status,id=null) {
        if (status == 'add') {
            $("#add_form").toggle();
            $("#report_setting_form")[0].reset();
            $("#ancor").val(0);
        }else if(status == 'edit'){
            $("#add_form").show();
            $("#report_setting_form")[0].reset();
            $("#ancor").val(id);
            $.ajax({
                type: "POST",
                url: "<?= base_url('setting_con/get_report_setting') ?>",
                data: {
                    id: id
                },
                success: function(data) {
                    data = JSON.parse(data)
                    console.log(data);
                    $("#unit_id").val(data.unit_id)
                    $("#active_status").val(data.status)
                    $("#max_ot").val(parseInt(data.max_ot))
                    $("#first_date").val(data.date);
                    $("#second_date").val(data.end_date);
                    $("#type").val(data.type);
            },
            })
        }

    }
    $("#report_setting_form").submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $status=$("#ancor").val();
        if ($('unit_id').val() == '') {
            showMessage('error', 'Please Select Unit')
            return false
        }
        if ($('active_status').val() == '') {
            showMessage('error', 'Please Select Status')
            return false
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url('setting_con/report_setting_save') ?>" + '/' + $status,
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == 'true') {
                    $("#add_form").toggle();
                    $("#report_setting_form")[0].reset();
                    showMessage('success', 'Record Added successfully')
                    window.location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX request error:", errorThrown);
            }
        })
    })
  function delete_user_mode($id,el) {
    var r = confirm("Are you sure you want to delete?");
    if (r == true) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('setting_con/delete_report_setting') ?>",
            data: {
                id: $id
            },
            success: function(data) {
                if (data == 'true') {
                    $(el).closest('tr').remove();
                    showMessage('success', 'Record Deleted successfully')
                }
            }
        })
    }

  }
</script>
