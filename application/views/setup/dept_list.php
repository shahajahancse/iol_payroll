
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
    .bangla_font {
        font-family: SutonnyMJ !important;
    }
</style>

<div class="content">
  <nav class="navbar navbar-inverse bg_none">
      <div class="container-fluid nav_head">
          <div class="navbar-header col-md-5">
            <a class="btn btn-info" href="<?php echo base_url('setup_con/dept_add') ?>">Add Department</a>
            <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
          </div>
          <div class="col-md-7">
            <div id="navbar" class="navbar-collapse collapse">
                <form class="navbar-form pull-right" role="search">
                  <div class="input-group">
                    <input id="deptSearch" type="text" class="form-control" placeholder="Search">
                  </div>
                </form>
            </div>
          </div>
          <!--/.nav-collapse -->
      </div>
      <!--/.container-fluid -->
  </nav>
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

  <div id="target-div" class="row tablebox">
      <div class="col-md-6" style="margin-left:-16px">
        <h3 style="font-weight:bold">Department List</h3>
      </div>
      <table class="table" id="mytable">
        <thead>
          <tr>
            <th>Sl. No.</th>
            <th>Departent Name </th>
            <th>Departent Name Bangla </th>
            <th>Company Unit</th>
            <th width="80">Edit</th>
            <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(136,$acl)) {echo '';} else { echo 'style="display:none;"';}?>
            >Delete </th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($pr_dept)){$i=1; foreach($pr_dept as $pr_depts){?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $pr_depts['dept_name'] ?></td>
                <td class="bangla_font"><?php echo $pr_depts['dept_bangla'] ?></td>
                <td><?php echo $pr_depts['unit_name'] ?></td>
                <td >
                  <a href="<?=base_url('setup_con/dept_edit/'.$pr_depts['dept_id'])?>" class="btn btn-primary center-text " role="button">Edit</a>
                </td>
                <td <?php if(in_array(136,$acl)) {echo '';} else { echo 'style="display:none;"';}?>?>
                  <a href="<?=base_url('setup_con/dept_delete/'.$pr_depts["dept_id"])?>" class="btn btn-danger center-text" role="button">Delete</a>
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
