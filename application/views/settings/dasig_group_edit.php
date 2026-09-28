
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
    <form action="<?= base_url('setting_con/dasig_group_add/'.$row->id)?>" method="post" style="margin-bottom: -20px;">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="acl_name">Group Name</label>
                    <input style="height: 5px !important;" value="<?= $row->name_en ?>" type="text" name="name_en" class="form-control input-lg" >
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="acl_name">Group Name (Bangla)</label>
                    <input style="height: 5px !important;" value="<?= $row->name_bn ?>" type="text" name="name_bn" class="form-control input-lg">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="unit_id">Unit</label>
                    <select name="unit_id" class="form-control" >
                        <option value="">Select Unit</option>
                        <?php foreach ($units as $r) { ?>
                            <option <?php echo ($row->unit_id == $r->unit_id)? 'selected':'' ?> value="<?= $r->unit_id ?>"><?= $r->unit_name?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="unit_id">Status</label>
                    <select name="status" class="form-control" >
                        <option <?php echo ($row->status == 1)? 'selected':'' ?> value="1">Enable</option>
                        <option <?php echo ($row->status == 2)? 'selected':'' ?> value="2">Disable</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1" style="padding-left: 0px !important;">
                <div class="form-group">
                    <label for="unit_id">Serial</label>
                    <input style="height: 5px !important;" value="<?= $row->serial ?>" type="text" name="serial" class="form-control input-lg" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 pull-right" style="top: -15px !important; right: -60px !important;">
                <div class="form-group">
                    <label for="acl_name" style="visibility: hidden">.</label>
                    <input type="submit" value="Submit" class="btn btn-success">
                </div>
            </div>
        </div>
   </form>
  </div>
</div>


