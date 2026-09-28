
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
        width: 100%;
    }
    table.dataTable thead th, table.dataTable thead td {
        border-bottom: none;
    }
    thead th{
        white-space: nowrap;
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
            <div class="navbar-header col-md-6">
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('setup_con/company_add') ?>">Add Company
                        Info</a>
                    <!-- <a class="btn btn-primary" href="<?php echo base_url('payroll_con') ?>">Home</a> -->
                </div>
            </div>
            <div class="col-md-6">
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
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
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
    <!-- <br> -->
    <div class="row tablebox">
            <div class="col-md-6" style="margin-left:-16px">
                <h4 style="font-weight:bold">Company Info List</h4>
            </div>
        <!-- <div class="col-md-12"> -->
            <table class="table" id="mytable">
                <thead>
                    <tr>
                        <th>Company Name </th>
                        <th>Company Address</th>
                        <th>Company Phone No</th>
                        <th>Company Logo</th>
                        <th>Company Signature</th>
                        <th>Register Signature</th>
                        <th>Edit</th>
                        <th <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(136,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // dd($company_infos);
                        if (is_array($company_infos) || is_object($company_infos)) {foreach ($company_infos as $cominfos) {?>
                    <tr>
                        <td class="bangla_font"><?php echo $cominfos->company_name_bangla ?></td>
                        <td class="bangla_font"><?php echo $cominfos->company_add_bangla ?></td>
                        <td><?php echo $cominfos->company_phone ?></td>
                        <td><img width="55" height="55" src="<?=base_url()?>images/<?=$cominfos->company_logo?>" />
                        </td>
                        <td><img width="55" height="55"
                            src="<?=base_url()?>images/<?=$cominfos->company_signature?>" />
                        </td>
                        <td><img width="55" height="55"
                            src="<?=base_url()?>images/<?=$cominfos->register?>" />
                        </td>
                        <td>
                            <a href="<?=base_url('setup_con/company_edit') . '/' . $cominfos->id?>" class="btn btn-primary input-sm center-text" role="button">Edit</a>
                        </td>
                        <td <?php  $user_id = $this->session->userdata('data')->id; $acl = check_acl_list($user_id); if(in_array(136,$acl)) {echo '';} else { echo 'style="display:none;"';}?>>
                            <a href="<?=base_url('setup_con/company_delete') . '/' . $cominfos->id?>" class="btn btn-danger input-sm center-text" role="button">Delete</a>
                        </td>
                    </tr>
                    <?php }} else {?>
                    <tr>
                        <td colspan="12">Records not Found</td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        <!-- </div> -->
    </div>
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
