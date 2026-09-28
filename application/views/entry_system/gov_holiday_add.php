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
    <form action="<?= base_url('entry_system_con/gov_holiday_add')?>" enctype="multipart/form-data" method="post">
        <div class="col-md-12">
            <div class="form-group col-md-3">
                <label for="date">Date</label>
                <input name="date" class="form-control date" id="date">
                <?= (isset($failuer['date'])) ? '<div class="alert alert-failuer">' . $failuer['date'] . '</div>' : ''; ?>
            </div>
            <div class="form-group col-md-6">
                <label for="description">Remark</label>
                <input name="description" class="form-control description" id="description">
                <?= (isset($failuer['description'])) ? '<div class="alert alert-failuer">' . $failuer['description'] . '</div>' : ''; ?>
            </div>
            <div class="form-group col-md-2">
                <label for="acl_name" style="visibility: hidden">.</label>
                <input type="submit" value="Submit" class="btn btn-success">
            </div>
        </div>
    </form>
  </div>



  <div id="target-div" class="row tablebox">
      <div class="col-md-6" style="margin-left:-16px">
        <h3 style="font-weight:bold">Holiday List</h3>
      </div>
      <table class="table" id="mytable">
        <thead>
          <tr>
            <th>Sl. No.</th>
            <th>Date</th>
            <th>Remark</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php foreach($data as $key => $value) {
              echo '<tr>';
                echo '<td>'.($key+1).'</td>';
                echo '<td>'.$value->date.'</td>';
                echo '<td>'.$value->description.'</td>';
                echo '<td><a href="'.base_url('entry_system_con/gov_holiday_edit/'.$value->id).'" class="btn btn-primary">Edit</a>
                <a href="'.base_url('entry_system_con/gov_holiday_delete/'.$value->id).'" class="btn btn-danger">Delete</a></td>';
              echo '</tr>';
            } ?>
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
