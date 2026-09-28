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
        padding: 3px 7px !important;
        font-size: 13px;
    }
</style>

<div class="content">
  <nav class="navbar navbar-inverse bg_none">
      <div class="container-fluid nav_head">
          <div class="navbar-header col-md-5">
                <h3 style="font-weight:bold">Alert List</h3>
          </div>
          <!--/.nav-collapse -->
      </div>
      <!--/.container-fluid -->
  </nav>

  <div id="target-div" class="row tablebox">
      <table class="table" id="mytable">
        <thead>
          <tr>
            <th>Sl. No.</th>
            <th>Date</th>
            <th>Emp Id </th>
            <th style="text-align : left;">Name </th>
            <th style="text-align : left;">Line</th>
            <th style="text-align : left;">Designation</th>
            <th style="text-align : left;">Remark</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($results)){$i=1; foreach($results as $r){?>
            <tr>
                <td><?php echo $i++ ?></td>
                <td><?php echo $r->date ?></td>
                <td><?php echo $r->emp_id ?></td>
                <td style="text-align : left;"><?php echo $r->name_en ?></td>
                <td style="text-align : left;"><?php echo $r->line_name_en ?></td>
                <td style="text-align : left;"><?php echo $r->desig_name ?></td>
                <td style="text-align : left;"><?php echo $r->msg ?></td>
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

