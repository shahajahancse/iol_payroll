
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
    <div id="add_form" class="row tablebox">
        <label for="user_id">Select User</label>
        <select name="user_id" id="user_id" onchange="get_user_level(this.value, 1)" style="width: 300px!important;">
            <option>Select User</option>
            <?php 
            foreach($users as $key => $value) {
            $selected = ($value->unit_id == $_SESSION['data']->unit_name) ? 'selected' : 'style="display:none;"';
            ?>
            <option value="<?= $value->id ?>" <?= $selected ?>><?php echo $value->id_number.' >> '.$value->unit_name?></option>
            <?php } ?>
        </select>
    </div>

    <div id="target-div" class="row tablebox">
        <div class="col-md-12" style="display: flex;flex-wrap: wrap;">
            <div class=col-md-4 style="display: flex;flex-direction: column;">
                <?php $limit = 20; $offset=$limit; $i=0; foreach($access_list as $key => $value) { 
                    if ($offset==$i) {
                        echo '</div><div class=col-md-4 style="display: flex;flex-direction: column;">';
                        $offset+=$limit;
                    }
                ?>
                <div>
                    <input type="checkbox" name="" onchange="check_level(<?=$value->id?>,<?=$user_id?>)" <?= in_array($value->id, $level_array) ? 'checked' : ''?>> <span><?php echo $value->acl_name; ?></span>
                </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $("#mytable").dataTable();
    $('#mytable_filter').css({"display": "none"})
    $('#mytable_length').css({"display": "none"})
    $("#mytable").dataTable();
    oTable = $('#mytable').DataTable();
    $('#deptSearch').keyup(function(){
      oTable.search($(this).val()).draw() ;
    })
  });
</script>
<script>
    function get_user_level(id, type = null){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('setting_con/checkbox_get_user_acl_hrm') ?>",
            data: {id: id, type: type },
            success: function(data){
                $("#target-div").html(data);
            },
            error: function(){
                alert("error");
            }
        })
    }
</script>
<script>
    function check_level(id, user_id){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('setting_con/check_level') ?>",
            data: {id: id, user_id: user_id},
            success: function(data){
                console.log('success');
            }
        })
    }
</script>

