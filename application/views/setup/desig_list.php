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
<div class="content">
    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5">
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/designation_add') ?>">Add Designation</a>
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
        <div class="col-md-12">
            <?php
                $success = $this->session->flashdata('success');
                if ($success != "") {
            ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
                $failuer = $this->session->flashdata('failuer');
                if ($failuer) {
            ?>
                <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php   }?>
        </div>
    </div>
    <!-- < ?php dd($unit_id);?> -->
    <div id="target-div" class="row tablebox table-responsive">
        <div class="col-md-6" style="margin-left:-16px">
             <h3 style="font-weight:bold">Designation List</h3>
         </div>
        <!-- <div class="col-md-12"> -->
            <table class="table" id="mytable">
                <thead>
                    <tr>
                        <th>Sl. No.</th>
                        <th>Designation Name </th>
                        <th>Unit Name </th>
                        <th>Attendance Bonus</th>
                        <th>Holiday Weekend Allowance </th>
                        <th>Iftar Allowance </th>
                        <th>Night Allowance </th>
                        <th>Tiffin Allowance </th>
                        <th width="80">Edit</th>
                        <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(139,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($emp_designation)){ foreach($emp_designation as $key => $data){

                            // dd($data);
                         $this->db->select('emp_depertment.dept_name, emp_section.sec_name_en, emp_line_num.line_name_en');
                         $this->db->from('emp_dasignation_line_acl');
                         $this->db->join('emp_depertment','emp_dasignation_line_acl.dept_id =emp_depertment.dept_id');
                         $this->db->join('emp_section','emp_dasignation_line_acl.section_id = emp_section.id');
                         $this->db->join('emp_line_num','emp_dasignation_line_acl.line_id = emp_line_num.id');
                         $this->db->where('emp_dasignation_line_acl.designation_id',$data['id']);
                         $info = $this->db->get()->row();
                        // dd($info);
                    ?>

                    <tr>
                        <td><?php echo $key+1?></td>
                        <td><?php echo $data['desig_name'] ?></td>
                        <td><?php echo $data['unit_name'] ?></td>
                        <td><?php echo $data['allowance_attn_bonus'] ?></td>
                        <td><?php echo $data['allowance_holiday_weekend'] ?></td>
                        <td><?php echo $data['allowance_iftar'] ?></td>
                        <td><?php echo $data['allowance_night_rules'] ?></td>
                        <td><?php echo $data['allowance_tiffin'] ?></td>
                        <td>
                            <a href="<?=base_url('setup_con/designation_edit') . '/' . $data["id"]?>"
                            class="btn btn-primary center-text" role="button">Edit</a>
                        </td>
                        <td <?php  if(in_array(139,$acl)) {echo '';} else { echo 'style="display:none;"';}?>?>
                            <a href="<?=base_url('setup_con/designation_delete') . '/' . $data["id"]?>"
                                class="btn btn-danger center-text" role="button">Delete</a>
                        </td>
                    </tr>
                    <?php } }else{?>

                    <tr>
                        <td colspan="12">Records not Found</td>
                    </tr>
                    <?php }?>

                </tbody>
            </table>
        <!-- </div> -->
    </div>
    <br><br>
</div>

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
    $('#deptSearch').keyup(function() {
        oTable.search($(this).val()).draw();
    })
});
</script>
