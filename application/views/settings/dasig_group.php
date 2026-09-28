
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
    <form action="<?= base_url('setting_con/dasig_group_add')?>" method="post" style="margin-bottom: -20px;">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="acl_name">Group Name</label>
                    <input style="height: 5px !important;" type="text" name="name_en" class="form-control input-lg" id="name_en" placeholder="Enter Name" required>
                    <?= (isset($failuer['name_en'])) ? '<div class="alert alert-failuer">' . $failuer['name_en'] . '</div>' : ''; ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="acl_name">Group Name (Bangla)</label>
                    <input style="height: 5px !important;" type="text" name="name_bn" class="form-control input-lg" id="name_bn" placeholder="Enter Name" required>
                    <?= (isset($failuer['name_bn'])) ? '<div class="alert alert-failuer">' . $failuer['name_bn'] . '</div>' : ''; ?>
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="unit_id">Unit</label>
                    <select name="unit_id" class="form-control" required>
                        <option value="">Select Unit</option>
                        <?php foreach ($units as $row) { ?>
                            <option value="<?= $row->unit_id ?>"><?= $row->unit_name?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="unit_id">status</label>
                    <select name="status" class="form-control" required>
                        <option value="1">Enable</option>
                        <option value="2">Disable</option>
                    </select>
                </div>
            </div>

            <div class="col-md-1" style="padding-left: 0px !important;">
                <div class="form-group">
                    <label for="unit_id">Serial</label>
                    <input style="height: 5px !important;" type="text" name="serial" class="form-control input-lg" id="name_en" placeholder="0">
                    <?= (isset($failuer['serial'])) ? '<div class="alert alert-failuer">' . $failuer['serial'] . '</div>' : ''; ?>
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

  <div id="target-div" class="row tablebox">
      <div class="col-md-6" style="margin-left:-16px">
        <h3 style="font-weight:bold">Access List</h3>
      </div>
      <table class="table" id="mytable">
        <thead>
          <tr>
            <th>Sl. No.</th>
            <th>Name</th>
            <th>Name Bangla</th>
            <th>Status</th>
            <th>unit</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($groups as $key => $row) { ?>
                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $row->name_en ?></td>
                    <td><?= $row->name_bn ?></td>
                    <td><?= ($row->status == 1)? 'Enable':'Disable' ?></td>
                    <td><?= $row->unit_name ?></td>
                    <td>
                        <a class="btn btn-primary" href="<?= base_url('setting_con/dasig_group/'.$row->id)?>"> Edit </a>
                        <a class="btn btn-info" href="<?= base_url('setting_con/dasig_group/'.$row->id.'/'.$row->unit_id)?>"> Manage </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
      </table>
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
