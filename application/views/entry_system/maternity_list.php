
<div class="content">

    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div>
                    <a class="btn btn-info" href="<?php echo base_url('entry_system_con/maternity_entry') ?>">Add Maternity</a>
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
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
    <div class="row">
        <div class="col-md-12">
            <?php
                $success = $this->session->flashdata('success');
                if ($success != "") { ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
                $failuer = $this->session->flashdata('failuer');
                if ($failuer) { ?>
                <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php } ?>
        </div>
    </div>
    <!-- <br> -->
    <div class="row tablebox">

        <div class="col-md-12 table-responsive">
            <table class="table table-striped" id="mytable">
                <thead>
                    <tr>
                        <th style="white-space: nowrap;" >SL</th>
                        <th style="white-space: nowrap;" >User name </th>
                        <th style="white-space: nowrap;" >Emp Id</th>
                        <th style="white-space: nowrap;" >Prev. M. Salary</th>
                        <th style="white-space: nowrap;" >Attendance Bonus</th>
                        <th style="white-space: nowrap;" >Festival Bonus</th>
                        <th style="white-space: nowrap;" >Other Benifit</th>
                        <th style="white-space: nowrap;" >Inform Date</th>
                        <th style="white-space: nowrap;" >Probable Date</th>
                        <th style="white-space: nowrap;" >Start Date</th>
                        <th style="white-space: nowrap;" >End Date</th>
                        <th style="white-space: nowrap;" >First Pay</th>
                        <th style="white-space: nowrap;" >Second Pay</th>
                        <th style="white-space: nowrap;" >Pay Day</th>
                        <th style="white-space: nowrap;" >Total Day</th>
                        <th style="white-space: nowrap;" >Unit name</th>
                        <th style="white-space: nowrap;" >Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($results)){
                        $cc=count($results);
                        foreach ($results as $key => $r) {?>
                    <tr>
                        <td style="white-space: nowrap;"><?php echo $key + 1  ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->name_en ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->emp_id ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->prev_month_salary ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->attn_bonus ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->festival_bonus ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->ather_benifit ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->inform_date ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->probability ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->start_date ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->end_date ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->first_pay ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->second_pay ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->pay_day ?></td>
                        <td style="white-space: nowrap;"><?php echo $r->total_day * 2?></td>
                        <td style="white-space: nowrap;"><?php echo $r->unit_name ?></td>
                            <td style="padding: 1px !important;">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                   Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu"
                                <?=($cc-1==$key)?'style="position:relative!important"':''?> role="menu">
                                    <li><a class="btn btn-sm" data-toggle="modal" data-target="#myModal" onclick="edit_leave(<?= $r->id ?>)">Edit</a></li>
                                    <li><a onclick="return confirm('Are You Sure? To Permanently remove this record')" class="btn btn-sm" href="<?=base_url('entry_system_con/maternity_delete/'.$r->id)?>">Delete</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <?php }} else {?>
                    <tr>
                        <td colspan="12">Records not Found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title h4" id="myModalLabel"> Maternity Benifit Update</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Festival Bonus<span style="color: red;">*</span> </label>
                                    <input type="number" name="festival_bonus" id="festival_bonus" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 0px 0px !important">
                                <div class="form-group">
                                    <label>Festival Month <span style="color: red;">*</span> </label>
                                    <input type="month" name="festival_month" id="festival_month" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-md-3" style="padding: 0px 0px 0px 15px !important">
                                <div class="form-group">
                                    <label>Other Benifit <span style="color: red;">*</span> </label>
                                    <input type="number" name="ather_benifit" id="ather_benifit" class="form-control input-sm">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Benifit Month<span style="color: red;">*</span> </label>
                                    <input type="month" name="abenifit_month" id="abenifit_month" class="form-control input-sm">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="modal_leave_id" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-primary" id="updated_maternity">Save</button>
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    function edit_leave(id) {
        $('#modal_leave_id').val(id);
    }

    $('#updated_maternity').on('click', function() {
        var formData = {
            'id'               : $("#modal_leave_id").val(),
            'festival_bonus'   : $("#festival_bonus").val(),
            'ather_benifit'    : $("#ather_benifit").val(),
            'festival_month'    : $("#festival_month").val(),
            'abenifit_month'    : $("#abenifit_month").val(),
        };
        $.ajax({
            url: "<?php echo base_url('entry_system_con/updated_maternity'); ?>",
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (data) {
                var dataObj = (typeof data == "string") ? JSON.parse(data) : data;
                if(dataObj.success == true){
                    Swal.fire({
                    icon: 'success',
                    title: "updated Successfully"
                    }).then((result) => {
                        window.location.href = window.location.href;
                        setTimeout(function(){ $('#myModal').modal('hide'); }, 100);
                    });
                }
            },
            error: function(jqXHR, exception) {
                console.error('jqXHR:', jqXHR);
                console.error('exception:', exception);
            }
        });
    });
</script>



