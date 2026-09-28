 
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
    .btns{
      padding: 3px;
      margin: 8px;
    }
</style>

 
 <div class="content" >
      <nav  class="navbar navbar-inverse bg_none">
    <div class="container-fluid nav_head">
      <div class="navbar-header col-md-5" style="padding: 7px;">
          <div>
          <a href="<?=base_url('entry_system_con/add_left')?>" class="btn btn-info" role="button">Add Left</a>
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
    <div class="col-md-12">
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
    <div class="col-md-6"><h3 style="margin-top: 0px; margin-bottom: 8px;" >Left List</h3></div>
    <div class="col-md-12">
      <table class="table" id="mytable">
        <thead>
          <tr>
            <th>Emp. ID </th>
            <th>Name</th>
            <th>Unit</th>
            <th>Join Date</th>
            <th>Left Date</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody id="tbody"> 
        
        </tbody>
      </table>
    </div>
  </div> <br><br>
</div>
<!-- <script type="text/javascript">
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
</script> -->

<script>
  var limit=10;
  var offset=0;
function get_left_del_list(){
 var deptSearch = $('#deptSearch').val();
  $.ajax({
    type: "get",
    url: "<?=base_url('entry_system_con/get_left_del_list/')?>",
    data: {
      limit: limit,
      offset: offset,
      deptSearch: deptSearch
    },
    success: function (d) {
        offset += limit;
        var data = JSON.parse(d);
        var tableRows = '';

        data.forEach(function (item) {
          var tr = `
            <tr>
              <td>${item.emp_id}</td>
              <td>${item.name_en}</td>
              <td>${item.unit_name}</td>
              <td>${item.emp_join_date}</td>
              <td>${item.left_date}</td>
              <td><button type="button" class="btn btns btn-danger" onclick="delete_left(${item.id},this)">Delete</button></td>
            </tr>
          `;
          tableRows += tr;
        });

        console.log(tableRows);
        $("#tbody").append(tableRows);
      }

  })
}
window.onscroll = function() {
  if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
    get_left_del_list();
  }
}
$('#deptSearch').keyup(function(){
  offset = 0;
  $("#tbody").empty();
  get_left_del_list();
})

get_left_del_list();
</script>
<script>
  function delete_left(id , element) {
    $.ajax({
      type: "get",
      url: "<?=base_url('entry_system_con/delete_left/')?>" + id,
      data: {
        id: id
      },
      success: function (d) {
        if(d >= 0){
          $(element).closest('tr').remove();
          showMessage('success','Record Deleted successfully!')
          
        }  
        else{
          showMessage('danger','Something went wrong!')
        }
      }
    })
  }
</script>