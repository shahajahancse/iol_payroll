
    <div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-4" style="padding: 7px;">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="btn btn-info"href="<?=base_url('setting_con/member_add')?>" >Add Member</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                </div>
            </div>
            <div class="col-md-8">
                <div id="navbar" class="navbar-collapse collapse">
                    <div class="">
                        <form class="pull-right" role="search">
                            <div class="input-group">
                                <input id="acl_search" type="text" class="form-control" placeholder="Search">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
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

            <div class=" col-md-12 ">
                <table class="table table-striped" id="mytable">
                  <thead>
                    <tr>
                        <th class="text-center">Sl.</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Unit name</th>
                        <th class="text-center">Level</th>
                        <th class="text-center">User Type</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      //echo "<pre>"; print_r($members); exit;
                    if(!empty($members)){
                      foreach($members as $member){?>
                      <?php if ($member['user_mode'] == 1) {
                        $ttt = '7pm';
                      } elseif ($member['user_mode'] == 2) {
                        $ttt = '9pm';
                      } elseif ($member['user_mode'] == 3) {
                        $ttt = '12pm';
                      } else {
                        $ttt = 'All';
                      }?>
                      <tr>
                          <td class="text-center"><?php echo @$i=$i+1 ?></td>
                          <td class="text-center"><?php echo $member['id_number'] ?></td>
                          <td class="text-center"><?php echo $member['unit_name'] ?></td>
                          <td class="text-center"><?php echo $member['level'] ?></td>
                          <td class="text-center"><?php echo $ttt ?></td>
                          <td class="text-center"><?php echo $member['status'] ?></td>
                          <td class="text-center">
                              <a href="<?=base_url('setting_con/member_edit').'/'.$member["id"]?>" class="btn btn-primary" role="button">Edit</a>
                              <a href="<?=base_url('setting_con/members_delete').'/'.$member["id"]?>" class="btn btn-danger" role="button">Delete</a>
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
    </div>

<!-- <script>
  $("#myTable").dataTable();
</script> -->


<script type="text/javascript">
  $(document).ready(function() {
    $("#mytable").dataTable();
    $('#mytable_filter').css({
      "display": "none"
    })
    $('#mytable_length').css({
      "display": "none"
    })
    $("#mytable").dataTable();
    oTable = $('#mytable').DataTable();
    $('#acl_search').keyup(function() {
        oTable.search($(this).val()).draw();
    })
  });
</script>
