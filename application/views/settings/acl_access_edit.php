
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
            <?php } $failuer = $this->session->flashdata('failuer');
            if ($failuer) { ?>
            <div class="alert alert-failuer"><?php echo $failuer; ?></div>
        <?php } ?>
    </div>
  </div>
  <div id="add_form" class="row tablebox">
      <form action="<?= current_url()?>" enctype="multipart/form-data" method="post">
        <div class="col-md-12"><h3>Access Edit</h3></div>
        <div class="col-md-12">
            <div class="form-group col-md-5">
                <label for="acl_name">ACL Name</label>
                <input style="height: 5px !important;" value="<?= $row->acl_name ?>" type="text" name="acl_name" class="form-control input-lg" id="acl_name" placeholder="Enter ACL Name">
                <?= (isset($failuer['acl_name'])) ? '<div class="alert alert-failuer">' . $failuer['acl_name'] . '</div>' : ''; ?>
            </div>
            <div class="form-group col-md-3">
                <label for="acl_name">ACL Type</label>
                <select name="type" id="">
                    <option <?= ($row->type == 1)?'selected':'';?> value="1">Left Menu</option>
                    <option <?= ($row->type == 2)?'selected':'';?> value="2">Hr Report</option>
                    <option <?= ($row->type == 3)?'selected':'';?> value="3">Payroll Report</option>
                    <option <?= ($row->type == 4)?'selected':'';?> value="4">Other Report</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="acl_name" style="visibility: hidden">.</label>
                <input type="submit" value="Submit" class="btn btn-success">
            </div>
        </div>
    </form>
  </div>
</div>

