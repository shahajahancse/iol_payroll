
<div class="content">
  <nav  class="navbar navbar-inverse bg_none">
    <div class="container-fluid nav_head">
      <div class="navbar-header col-md-5" style="padding: 7px;">
          <div>
          <a href="<?=base_url('crud_con/taxnother_add')?>" class="btn btn-info" role="button">Add Tax & Others Deduct</a>
          <a href="<?php echo base_url('payroll_con')?>" class="btn btn-primary">Home</a>
          </div>
      </div>
      <div class="col-md-7">
        <div id="navbar" class="navbar-collapse collapse">
            <div class="">
                <form class="navbar-form pull-right" role="search">
                    <div class="input-group">
                        <input id="deptSearch" type="text" class="form-control" placeholder="Search">
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </nav>

  <div class="row">
    <div class="col-md-8">
      <?php
      $success = $this->session->flashdata('success');
      if ($success != "") {
        ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
        <?php
        }
        $failuer = $this->session->flashdata('failuer');
        if ($failuer) {
          ?>
        <div class="alert alert-failuer"><?php echo $failuer; ?></div>
        <?php
        }
        ?>
    </div>
  </div>
        <!-- <br> -->
  <div class="row tablebox">
    <div class="col-md-6"><h3 style="margin-top: 0px; margin-bottom: 8px;">Tax & Others List</h3></div>
      <div class="col-md-12">
        <table class="table" id="mytableee">
          <thead>
            <tr>
                <th>Company Unit</th>
                <th>Emp. ID </th>
                <th>Tax</th>
                <th>Others</th>
                <th>Month</th>
                <th>Delete</th>

            </tr>
          </thead>
          <tbody>
            <?php
              if(!empty($pr_deduct)){ foreach($pr_deduct as $pr_deducts){?>
              <tr>
                <td><?php echo $pr_deducts['unit_name'] ?></td>
                <td><?php echo $pr_deducts['emp_id'] ?></td>
                <td><?php echo $pr_deducts['tax_deduct'] ?></td>
                <td><?php echo $pr_deducts['others_deduct'] ?></td>
                <td><?php echo $pr_deducts['deduct_month'] ?></td>
                <td>
                    <a href="<?=base_url('crud_con/taxnother_delete').'/'.$pr_deducts["deduct_id"]?>" class="btn btn-danger" role="button">Delete</a>
                </td>
              </tr>
            <?php } }else{?>
              <tr>
                <td colspan="12">Records not Found</td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
    </div> <br><br>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  $("#mytablee").dataTable();
  $('#mytablee_filter').css({
    "display": "none"
  })
  $('#mytablee_length').css({
    "display": "none"
  })
  $("#mytablee").dataTable();
  oTable = $('#mytablee').DataTable();
  $('#deptSearch').keyup(function() {
    oTable.search($(this).val()).draw();
  })
});
</script>
