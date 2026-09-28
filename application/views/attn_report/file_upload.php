
<style type='text/css'>
  body
  {
  	font-family: Arial;
  	font-size: 14px;
  }
  a {
      color: blue;
      text-decoration: none;
      font-size: 14px;
  }
  a:hover{
  	text-decoration: underline;
  }
  .pagination a{
    padding: 7px 10px;
    margin-right:5px;
    background: #28c8d8;
    color:#fff;
  }
  .pagination strong{
    padding: 7px 10px;
    margin-right:5px;
    background: #0d9488;
    color:#fff;
  }

  .dataTables_paginate .paginate_button:hover
  {
      background: #28c8d8 !important;
      color:#fff !important;
  }

  .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover,
  .dataTables_paginate .paginate_button:active {
      background: #0d9488 !important;
      color:#fff !important;
  }
  table.dataTable thead th, table.dataTable thead td {
    border-bottom: none !important;
  }
  table.dataTable.no-footer {
    border-bottom: none;
  }


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
      white-space: nowrap;

    }
    table.dataTable tbody th, table.dataTable tbody td {
      padding: 4px !important;
      white-space: nowrap;
    }
    .center-text {
        vertical-align: center;
        padding: 5px 10px;

    }

</style>


  <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
  <div class="content">
        <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5" style="padding: 7px;">
                <div>
                    <a class="btn btn-info"  href="<?=base_url('attn_process_con/file_add')?>"><?= $title ?></a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
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
             <h3 style="font-weight:bold">File List</h3>
         </div>
      <!-- <div class="container"> -->
        <?php
          $user_id = $this->session->userdata('data')->id;
	        $acl = check_acl_list($user_id);
        ?>
        <table class="table" id="mytable">
          <thead>
            <tr>
              <th>SL.</th>
              <th>Unit Name </th>
              <th>Date</th>
              <th  style="<?php if(!in_array(10,$acl)) {echo '';} else { echo 'display:none;';}?>" >File Name </th>
              <th  style="<?php if(in_array(133,$acl)) {echo '';} else { echo 'display:none;';}?>">Delete</th>
            </tr>
          </thead>

          <tbody>
            <?php if(!empty($results)){ $i=0; foreach($results as $row){?>
              <tr>
                  <td><?php echo ++$i; ?></td>
                  <td><?php echo $row->unit_name; ?></td>
                  <td><?php echo $row->upload_date; ?></td>
                  <td style="<?php if(!in_array(10,$acl)) {echo '';} else { echo 'display:none;';}?>"><a href="<?=base_url('data/'.$row->file_name)?>"><?php echo $row->file_name; ?></a></td>
                  <td style="<?php if(in_array(133,$acl)) {echo '';} else { echo 'display:none;';}?>"><a href="<?=base_url('data/'.$row->file_name)?>">
                    <a href="<?=base_url('attn_process_con/delete_attn_file/'.$row->id)?>" class="btn btn-danger btn-mini" role="button">Delete</a>
                  </td>
              </tr>
            <?php } }else{?>
              <tr>
                  <td colspan="12">Records not Found</td>
              </tr>
            <?php }?>
        	</tbody>
        </table>
          <!-- <div class="pagination"><?php //echo $this->pagination->create_links(); ?></div> -->
      <!-- </div> -->
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
