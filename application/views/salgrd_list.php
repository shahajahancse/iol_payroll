

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
<div class="content" >
  <nav class="navbar navbar-inverse bg_none">
    <div class="container-fluid nav_head">
      <div class="navbar-header col-md-5" style="padding: 7px;">
        <div>
          <a class="btn btn-info"href="<?=base_url('crud_con/salgrd_add')?>">Add Salary Grade</a>
          <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a>
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
  <div class="row tablebox">
    <div class="col-md-6" style="margin-left:-16px">
      <h4 style="font-weight:bold">Salary Grade List</h4>
    </div>
      <table class="table" id="mytable">
        <thead >
          <tr>
            <th class="text-center">Sl. No. </th>
            <th class="text-center">Salary Grade</th>
            <th class="text-center" width="80">Edit</th>
            <th class="text-center">Delete</th>
          </tr>
        </thead>
          <tbody>
              <?php
              if(!empty($salary_grade)){$i=1; foreach($salary_grade as $pr_grades){?>
                  <tr>
                    <td class="text-center"><?php echo $i++ ?></td>
                    <td class="text-center"><?php echo $pr_grades['gr_name'] ?></td>
                    <td class="text-center" >
                      <a href="<?=base_url('crud_con/salgrd_edit').'/'.$pr_grades["gr_id"]?>"target='_blank' class="btn btn-primary input-sm center-text" role="button">Edit</a>
                    </td>
                    <td class="text-center">
                      <a href="<?=base_url('crud_con/salgrd_delete').'/'.$pr_grades["gr_id"]?>" class="btn btn-danger input-sm center-text" role="button">Delete</a>
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
  <br><br>
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