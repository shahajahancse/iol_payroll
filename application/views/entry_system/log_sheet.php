<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Job Card</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/table.css" />
</head>
<script src="<?=base_url()?>awedget/assets/plugins/jquery-3.2.1.min.js" type="text/javascript"></script>
<!--/.data table-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>

<body>
    <div align="center" style="height:100%; width:100%; overflow:hidden;">
        <?php $this->load->view('head_english'); ?>

        <span style='font-size:13px; font-weight:bold;'>
            Shift Log from <?php echo $first_date .' -TO- '. $second_date; ?>
        </span>
        <br /><br />

        <table border='0' style='font-size:13px;  width:600px;'>
            <tr>
                <td width=''><strong>Emp ID:</strong></td>
                <td width=''><?= $row->emp_id ?></td>

                <td width=''><strong>Name :</strong> </td>
                <td width=''><?= $row->name_en ?></td>
            </tr>

            <tr>
                <td width=''><strong>Proxi NO.</strong></td>
                <td width=''><?= $row->proxi_id ?></td>

                <td width=''><strong>Section :</strong> </td>
                <td width=''><?= $row->sec_name_en ?></td>
            </tr>

            <tr>
                <td width=''><strong>Line :</strong></td>
                <td width=''><?= $row->line_name_en ?></td>

                <td width=''><strong>Desig :</strong> </td>
                <td width=''><?= $row->desig_name ?></td>
            </tr>

            <tr>
                <td width=''><strong>DOJ :</strong></td>
                <td width=''><?= date('d-m-Y', strtotime($row->emp_join_date)) ?></td>

                <td width=''><strong>Dept :</strong> </td>
                <td width=''><?= $row->dept_name ?></td>
            </tr>
        <table>
        <br>
        <table width="800" border="1" bordercolor="#000000" cellspacing="0" cellpadding="2"
            style="text-align:center; font-size:13px; ">
            <tr>
                <th style="width: 20%">Date</th>
                <th style="width: 12%">In Time</th>
                <th style="width: 12%">Out Time</th>
                <th style="width: 30%">Shift</th>
                <th style="width: 10%">In Time [HH:MM:SS]</th>
                <th style="width: 10%">Out Time [HH:MM:SS]</th>
            </tr>
            <form method="post" id="log_form">
                <input type="hidden" name="emp_id" id="emp_id" value="<?= $row->emp_id ?>">
                <input type="hidden" name="proxi" id="proxi" value="<?= $row->proxi_id ?>">
                <input type="hidden" name="unit_id" id="unit_id" value="<?= $unit_id ?>">
                <?php foreach ($results as $key => $r) { ?>
                <tr>
                    <td style="">
                        <?= date('d-m-Y', strtotime($r['date'])) ?>
                        <input type="hidden" name="date[]" value="<?= $r['date'] ?>">
                    </td>
                    <?php if ($r['present_status'] == 'P') {
                        $in_time = $r['in_time'];
                        $out_time = $r['out_time'];
                    } else {
                        $in_time = '';
                        $out_time = '';
                    } ?>
                    <td style=""> <?= $in_time ?> </td>
                    <td style=""> <?= $out_time ?> </td>
                    <td style=""> <?= $r['shift_name'] ?> </td>

                    <td>
                        <input style="font-weight:bold;" class="in_time" name="in_time[]" value="<?= $rin_time ?>" >
                    </td>
                    <td>
                        <input style="font-weight:bold;" class="out_time" name="out_time[]" value="<?= $rout_time ?>">
                    </td>

                </tr>
                <?php } ?>
                <tr>
                    <td colspan="6"><input class="btn btn-info" onclick="log_update(event)" type="button" value="Save"></td>
                </tr>
            </form>
        </table>
    </div>
</body>

</html>


<script>
function log_update(e) {
    e.preventDefault();
    emp_id = document.getElementById('emp_id').value;
    proxi = document.getElementById('proxi').value;
    var formdata = $("#log_form").serialize();
    var data = "emp_id=" + emp_id + "&proxi=" + proxi + "&" + formdata;
    var valid = true;
    $('.in_time').each(function() {
        if ($(this).val() === "00:00:00") {
            $(this).css('border', '1px solid red');
            Swal.fire({
                toast: true,
                position: "top",
                icon: "error",
                title: "please fill the valid In Time",
                showConfirmButton: false,
                timer: 3000
            })
            valid = false;
        } else {
            $(this).css('border', '1px solid black');
        }
    });

    $('.out_time').each(function() {
        if ($(this).val() === "00:00:00") {
            $(this).css('border', '1px solid red');
            Swal.fire({
                toast: true,
                position: "top",
                icon: "error",
                title: "please fill the valid Out Time",
                showConfirmButton: false,
                timer: 3000
            })
            valid = false;
            // return false; // Exit each function if a condition is met
        } else {
            $(this).css('border', '1px solid black');
        }
    });

    if (valid == true) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('entry_system_con/log_update/') ?>",
            data: data,
            success: function(data) {
                Swal.fire({
                    toast: true,
                    position: "top",
                    icon: "success",
                    title: "Shift Log Updated Successfully",
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                  //  window.close();//
                });
            },
            error: function(data) {
                Swal.fire({
                    toast: true,
                    position: "top",
                    icon: "error",
                    title: "Shift Log Not Updated Successfully",
                    showConfirmButton: false,
                    timer: 3000
                }).then((result) => {
                   // window.close();
                });
            }
        })
    }
}
</script>
