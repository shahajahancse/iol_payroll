<style>
    .page-content .content {
        padding-top: 85px !important;
        padding-left: 25px !important;
        padding-right: 25px !important;
    }
    .menu-acl-card {
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .menu-acl-card:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.08) !important;
    }
    #target-div {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>

<div class="content">
    <!-- Page Title -->
    <div class="page-title" style="margin-bottom: 15px; padding: 0 5px;">
        <h3 style="font-weight: 700; color: #1b75bb; margin: 0;">Left Menu Access</h3>
    </div>

    <!-- Flash Messages -->
    <div class="row">
        <div class="col-md-12">
            <?php $success = $this->session->flashdata('success');
            if ($success != "") { ?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $success; ?>
                </div>
            <?php } 
            $failuer = $this->session->flashdata('failuer');
            if ($failuer) { ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?php echo $failuer; ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- User Selector Section -->
    <div id="add_form" class="row tablebox" style="margin-bottom: 20px; padding: 18px 20px; display: block; clear: both;">
        <div class="row">
            <div class="col-md-6 col-sm-12" style="display: flex; align-items: center; gap: 12px; margin-bottom: 5px;">
                <label for="user_id" style="font-weight: 700; font-size: 14px; margin-bottom: 0; min-width: 100px; color: #2c3e50;">
                    <i class="fa fa-user" style="color: #1b75bb; margin-right: 5px;"></i> Select User:
                </label>
                <select name="user_id" id="user_id" onchange="get_user_level(this.value, 1)" class="form-control" style="width: 320px !important; height: 38px; font-size: 14px; border: 1px solid #b0c0df; border-radius: 4px; display: inline-block;">
                    <option value="" selected>-- Select User --</option>
                    <?php 
                    foreach($users as $key => $value) {
                        if (!empty($_SESSION['data']->level) && $_SESSION['data']->level != 'All' && !empty($_SESSION['data']->unit_name) && $value->unit_id != $_SESSION['data']->unit_name) {
                            continue;
                        }
                    ?>
                    <option value="<?= $value->id ?>"><?php echo htmlspecialchars($value->id_number) . ' >> ' . (!empty($value->unit_name) ? htmlspecialchars($value->unit_name) : 'All Units'); ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-6 col-sm-12 text-muted" style="display: flex; align-items: center; height: 38px; font-size: 13px;">
                <i class="fa fa-info-circle text-info" style="margin-right: 6px;"></i> Select a user to load and manage their menu permissions below.
            </div>
        </div>
    </div>

    <!-- Target Div for Permissions (Empty on initial load) -->
    <div id="target-div" class="row" style="margin-top: 15px; margin-left: 0 !important; margin-right: 0 !important;">
        <div class="col-md-12 text-center" style="padding: 55px 20px; background: #fff; border-radius: 6px; border: 2px dashed #cbd5e1; box-shadow: 0 1px 3px rgba(0,0,0,0.05); margin-bottom: 20px;">
            <div style="width: 65px; height: 65px; border-radius: 50%; background: #e8f4fd; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                <i class="fa fa-hand-o-up" style="font-size: 30px; color: #1b75bb;"></i>
            </div>
            <h4 style="font-weight: 600; color: #333; margin-top: 0; margin-bottom: 8px;">Please select a user from above</h4>
            <p style="color: #777; max-width: 520px; margin: 0 auto; font-size: 13px; line-height: 1.5;">
                After selecting a user, all left menu permissions (HRM, Entry System, Leave, Payroll, etc.) will be loaded here categorized by menu.
            </p>
        </div>
    </div>
</div>

<script>
    function get_user_level(id, type = 1){
        if (!id) {
            $("#target-div").html(`
                <div class="col-md-12 text-center" style="padding: 55px 20px; background: #fff; border-radius: 6px; border: 2px dashed #cbd5e1; margin-bottom: 20px;">
                    <div style="width: 65px; height: 65px; border-radius: 50%; background: #e8f4fd; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                        <i class="fa fa-hand-o-up" style="font-size: 30px; color: #1b75bb;"></i>
                    </div>
                    <h4 style="font-weight: 600; color: #333; margin-top: 0; margin-bottom: 8px;">Please select a user from above</h4>
                    <p style="color: #777; max-width: 520px; margin: 0 auto; font-size: 13px; line-height: 1.5;">
                        After selecting a user, all left menu permissions will be loaded here categorized by menu.
                    </p>
                </div>
            `);
            return;
        }

        $("#target-div").html(`
            <div class="col-md-12 text-center" style="padding: 60px 20px; background: #fff; border-radius: 6px; border: 1px solid #e2e8f0; margin-bottom: 20px;">
                <i class="fa fa-spinner fa-spin fa-3x" style="color: #1b75bb; margin-bottom: 15px;"></i>
                <h4 style="color: #333; font-weight: 600; margin-top: 0;">Loading menu permissions...</h4>
                <p style="color: #888; font-size: 13px;">Please wait a moment</p>
            </div>
        `);

        $.ajax({
            type: "POST",
            url: "<?php echo base_url('setting_con/checkbox_get_user_acl_hrm') ?>",
            data: { id: id, type: type },
            success: function(data){
                $("#target-div").html(data);
            },
            error: function(){
                alert("Failed to load permissions! Please try again.");
            }
        });
    }
</script>
