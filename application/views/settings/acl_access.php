
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
    <form action="<?= base_url('setting_con/acl_access_add')?>" enctype="multipart/form-data" method="post">
        <div class="col-md-12">
            <div class="form-group col-md-5">
                <label for="acl_name">ACL Name</label>
                <input style="height: 5px !important;" type="text" name="acl_name" class="form-control input-lg" id="acl_name" placeholder="Enter ACL Name">
                <?= (isset($failuer['acl_name'])) ? '<div class="alert alert-failuer">' . $failuer['acl_name'] . '</div>' : ''; ?>
            </div>
            <div class="form-group col-md-3">
                <label for="acl_name">ACL Type</label>
                <select name="type" id="">
                    <option value="1">Left Menu</option>
                    <option value="2">Hr Report</option>
                    <option value="3">Payroll Report</option>
                    <option value="4">Other Report</option>
                </select>
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
        <h3 style="font-weight:bold">Access List</h3>
      </div>
      <table class="table" id="mytable">
        <thead>
          <tr>
            <th>Sl. No.</th>
            <th>acl Name</th>
            <th>Type</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach($data as $key => $value) {
            echo '<tr>';
            echo '<td>'.($key+1).'</td>';
            echo '<td>'.$value->acl_name.'</td>';
            if ($value->type == 1) {
                echo '<td>Left Menu</td>';
            } elseif ($value->type == 2) {
                echo '<td>Attendance Button</td>';
            } elseif ($value->type == 3) {
                echo '<td>Payroll Button</td>';
            } else {
                echo '<td>Other Button</td>';
            }
            echo '<td>
              <a href="'.base_url('setting_con/acl_access_edit/'.$value->id).'" class="btn btn-primary">Edit</a>';
              if (!in_array($value->id, array(1,2,3,4,5,6,7,8,9,10))) {
                echo '<a href="'.base_url('setting_con/acl_access_delete/'.$value->id).'" class="btn btn-danger">Delete</a>';
              } else {
                echo '<a href="#" class="btn btn-secondary disabled">Delete</a>';
              }
            echo '</td></tr>';
          }?>
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
