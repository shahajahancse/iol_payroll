
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
        <div class="col-md-12"><h3>Edit</h3></div>
        <div class="form-group col-md-3">
            <label for="date">Date</label>
            <input name="date" class="form-control date" id="date" value="<?= date('d-m-Y', strtotime($row->date)) ?>" >
            <?= (isset($failuer['date'])) ? '<div class="alert alert-failuer">' . $failuer['date'] . '</div>' : ''; ?>
        </div>
        <div class="form-group col-md-6">
            <label for="description">Remark</label>
            <input name="description" class="form-control" value="<?= $row->description ?>" >
            <?= (isset($failuer['description'])) ? '<div class="alert alert-failuer">' . $failuer['description'] . '</div>' : ''; ?>
        </div>
        <div class="form-group col-md-2">
            <label for="acl_name" style="visibility: hidden">.</label>
            <input type="submit" value="Submit" class="btn btn-success">
        </div>
    </form>
  </div>
</div>

