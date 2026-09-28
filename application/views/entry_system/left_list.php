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
                    <a class="btn btn-info" href="<?php echo base_url('entry_system_con/left_resign_entry') ?>">Add Left</a>
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
    <!-- <br> -->
    <div class="row tablebox">

        <div class="col-md-12">

            <table class="table table-striped" id="">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>Emp Name </th>
                        <th>Emp Id</th>
                        <th>Unit name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Delete</th>
                    </tr>
                </thead>

                </thead>

                <tbody id="tbody">

                    <!-- <?php

                  if (!empty($results)) {foreach ($results as $key => $r) {?>

                    <tr>
                        <td style="padding: 5px !important"><?php echo $key + 1  ?></td>
                        <td style="padding: 5px !important"><?php echo $r->user_name ?></td>
                        <td style="padding: 5px !important"><?php echo $r->emp_id ?></td>
                        <td style="padding: 5px !important"><?php echo $r->unit_name ?></td>
                        <td style="padding: 5px !important"><?php echo date('d-m-Y', strtotime($r->left_date))?></td>
                        <?php if ($r->status == 1) { ?>
                            <td style="padding: 5px; color: #f30968;">No Letter Print</td>
                        <?php } else if($r->status == 2) { ?>
                            <td style="padding: 5px; color: #3c0eeb;">One Letter Print</td>
                        <?php } else if($r->status == 3) { ?>
                            <td style="padding: 5px; color: #9807b1;">Two Letter Print</td>
                        <?php } else if($r->status == 4) { ?>
                            <td style="padding: 5px; color: #08ad9d;">Four Letter Print</td>
                        <?php } ?>

                        <td style="padding: 5px !important">
                            <div class="btn-group">
                                <button style="padding: 5px 10px;" type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <?php
                                        $user_id = $this->session->userdata('data')->id;
                                        $acl = check_acl_list($user_id);
                                    ?>
                                    <?php if ($r->status == 1) { ?>
                                        <li><a class="btn btn-sm">No Letter </a></li>
                                    <?php } else if($r->status == 2) { ?>
                                        <li><a onclick="report(<?= $r->emp_id ?>, 2)" class="btn btn-sm">One Letter Print</a></li>
                                    <?php } else if($r->status == 3) { ?>
                                        <li><a onclick="report(<?= $r->emp_id ?>, 2)" class="btn btn-sm">One Letter Print</a></li>
                                        <li><a onclick="report(<?= $r->emp_id ?>, 3)" class="btn btn-sm">Two Letter Print</a></li>
                                    <?php } else if($r->status == 4) { ?>
                                        <li><a onclick="report(<?= $r->emp_id ?>, 2)" class="btn btn-sm">One Letter Print</a></li>
                                        <li><a onclick="report(<?= $r->emp_id ?>, 3)" class="btn btn-sm">Two Letter Print</a></li>
                                        <li><a onclick="report(<?= $r->emp_id ?>, 4)" class="btn btn-sm">Three Letter Print</a></li>
                                    <?php } ?>
                                    <li>
                                        <a href="<?=base_url('entry_system_con/left_delete/'.$r->emp_id)?>" class="btn btn-sm" role="button">Delete</a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                    </tr>
                    <?php }} else {?>

                    <tr>
                        <td colspan="12">Records not Found</td>
                    </tr>
                    <?php }?> -->

                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>

<script type="text/javascript">
function report(emp_id, status) {
    var ajaxRequest; // The variable that makes Ajax possible!
    try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }

    // document.getElementById('loaader').style.display = 'flex';
    var queryString = "emp_id=" + emp_id + "&status=" + status;
    url = hostname + "grid_con/grid_letter_report_print/";
    ajaxRequest.open("POST", url, true);
    ajaxRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded;charset=utf-8");
    ajaxRequest.send(queryString);
    ajaxRequest.onreadystatechange = function() {
        // document.getElementById('loaader').style.display = 'none';
        if (ajaxRequest.readyState == 4) {
            var resp = ajaxRequest.responseText;
            letter_1 = window.open('', '_blank', 'menubar=1,resizable=1,scrollbars=1,width=1600,height=800');
            letter_1.document.write(resp);
        }
    }
}
</script>

<!-- <script type="text/javascript">
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
</script> -->


<script>
var offset = 0
var limit = 15
var i = 0
$(document).ready(function() {
    get_data(offset)
})

function get_data(offset=0) {

    var deptSearch = $('#deptSearch').val()
    $.ajax({
        url: "<?php echo base_url('entry_system_con/left_list_ajax') ?>",
        type: "post",
        data: {
            offset: offset,
            limit: limit,
            deptSearch: deptSearch
        },
        success: function(data) {
            var obj = JSON.parse(data)

            obj.forEach(element => {
                if (element.status == 1) {
                    var s_at = 'No Letter'
                    var s=`<li><a class="btn btn-sm">No Letter </a></li>`
                } else if (element.status == 2) {
                    s_at = 'One Letter Print'
                    s = `<li><a onclick="report(${element.emp_id}, 2)" class="btn btn-sm">One Letter Print</a></li>`
                } else if (element.status == 3) {
                    s_at = 'Two Letter Print'
                    s = `<li><a onclick="report(${element.emp_id}, 2)" class="btn btn-sm">One Letter Print</a></li>
                        <li><a onclick="report(${element.emp_id}, 3)" class="btn btn-sm">Two Letter Print</a></li>`
                } else if (element.status == 4) {
                    s_at = 'Three Letter Print'
                    s = `<li><a onclick="report(${element.emp_id}, 2)" class="btn btn-sm">One Letter Print</a></li>
                        <li><a onclick="report(${element.emp_id}, 3)" class="btn btn-sm">Two Letter Print</a></li>
                        <li><a onclick="report(${element.emp_id}, 4)" class="btn btn-sm">Three Letter Print</a></li>`
                }

                var left_date = element.left_date
                left_date = left_date.split('-')
                left_date = left_date[2] + '-' + left_date[1] + '-' + left_date[0]
                $('#tbody').append(`<tr>
                <td>${++i}</td>
                <td style="padding: 5px !important">${element.user_name}</td>
                <td style="padding: 5px !important">${element.emp_id}</td>
                <td style="padding: 5px !important">${element.unit_name}</td>
                <td style="padding: 5px !important">${left_date}</td>
                <td>${s_at}</td>
                <td style="padding: 5px !important">
                    <div class="btn-group">
                        <button style="padding: 5px 10px;" type="button" class="btn btn-sm btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Action <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                        ${s}
                            <li><a href="<?=base_url('entry_system_con/print_envelope/')?>${element.emp_id}" class="btn btn-sm" role="button">Print Envelope</a></li>
                            <li><a href="<?=base_url('entry_system_con/left_delete/')?>${element.emp_id}" class="btn btn-sm" role="button">Delete</a></li>
                        </ul>
                    </div>
                </td>

            </tr>`)
            });
        }
    })
}
window.onscroll = function() {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        offset += limit
        get_data(offset)
    }
}

$('#deptSearch').keyup(function() {
    offset = 0
    i = 0
    get_data(offset)
    $('#tbody').empty()
})
</script>
