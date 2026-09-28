
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
    <label for="user_id"><?php echo $title .' ( '. $row->name_en .' )'; ?></label>
  </div>



    <div id="target-div" class="row tablebox">
        <div class="col-md-12" style="display: flex;flex-wrap: wrap;">
            <div class=col-md-4 style="display: flex;flex-direction: column;">
                <?php $limit = 25; $offset=$limit; $i=0; foreach($results as $key => $value) {
                    if ($offset==$i) {
                        echo '</div><div class=col-md-4 style="display: flex;flex-direction: column;">';
                        $offset+=$limit;
                    }
                ?>
                <div>
                    <?php if (!empty($not_match) && in_array($value->id, $not_match)) { ?>
                        <input type="checkbox" onchange="check_level(this,<?=$row->id?>,<?=$row->unit_id?>)" value="<?=$value->id?>" >
                        <span><?php echo $value->desig_name; ?></span> <span style="color: #0d14f3;">( <?= $value->name_en ?> )</span>
                    <?php } else { ?>
                        <input type="checkbox" onchange="check_level(this,<?=$row->id?>,<?=$row->unit_id?>)"
                        <?= in_array($value->id, $match)? 'checked' : ''?> value="<?=$value->id?>" >
                        <span><?php echo $value->desig_name; ?></span>
                    <?php } ?>
                </div>
                <?php $i++; } ?>
            </div>
        </div>
    </div>
</div>

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
    function check_level(e, gd_id, unit_id){
        var is_check    = 0;
        if (e.checked) { is_check= 1; }
        var id          = $(e).val();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('setting_con/check_level_dg') ?>",
            data: {id: id, gd_id: gd_id, unit_id: unit_id, is_check: is_check},
            success: function(data){
                console.log('success');
            }
        })
    }
</script>

