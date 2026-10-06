<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Daily Movement Report (Punch Log)</title>
    <style>
        @media print {
            #btnExport {
                display: none;
            }
        }
        .sal_table {
            border-collapse: collapse;
            font-size: 12px;
            width: 950px;
            margin-bottom: 20px;
        }
        .sal_table th, .sal_table td {
            border: 1px solid #777777;
        }
    </style>
</head>

<body style="margin: 0px;" id="report-data">
    <?php $this->load->view("head_english"); ?>
    <div style="margin-left: 50px; margin-bottom: 10px;">
        <button id="btnExport" style="padding: 5px 12px; cursor: pointer; background: #0c74bf; color: #fff; border: none; border-radius: 3px;">Download as Excel</button>
    </div>

    <div align="center" style="margin:0 auto; overflow:hidden; font-family: 'Times New Roman', Times, serif;">
        <span style="font-size:14px; font-weight:bold;">
            Daily Movement Report (Punch Log) , Date: <?php echo date("d/m/Y", strtotime($grid_firstdate)); ?>
        </span>
        <br><br>

        <table class="sal_table" border="1" cellpadding="0" cellspacing="0" style="font-size:12px; width:950px; margin-bottom:20px; border-collapse:collapse;">
            <?php
            if (!empty($values) && is_array($values)) {
                foreach ($values as $emp_index => $emp) {
                    ?>
                    <!-- Employee Header Row -->
                    <tr bgcolor="#CCCCCC">
                        <td colspan="4" style="font-size:13px; font-weight:bold; padding:6px 10px; text-align:left;">
                            ID: <?php echo $emp['emp_id']; ?> &nbsp;&nbsp;|&nbsp;&nbsp;
                            Name: <?php echo $emp['emp_full_name']; ?> &nbsp;&nbsp;|&nbsp;&nbsp;
                            Designation: <?php echo $emp['desig_name']; ?> &nbsp;&nbsp;|&nbsp;&nbsp;
                            Section: <?php echo $emp['sec_name']; ?> &nbsp;&nbsp;|&nbsp;&nbsp;
                            Card No: <?php echo $emp['proxi_id']; ?>
                        </td>
                    </tr>

                    <!-- Punch Sub-headers -->
                    <tr bgcolor="#EFEFEF">
                        <th style="padding:4px; width:60px; text-align:center;">SL</th>
                        <th style="padding:4px; width:180px; text-align:center;">Date</th>
                        <th style="padding:4px; width:220px; text-align:center;">Punch Time</th>
                        <th style="padding:4px; text-align:center;">Log Status</th>
                    </tr>

                    <?php
                    $punches = isset($emp['punches']) ? $emp['punches'] : array();
                    if (!empty($punches)) {
                        $p_count = count($punches);
                        foreach ($punches as $k => $p) {
                            $status = ($k == 0) ? 'In Punch' : (($k == $p_count - 1) ? 'Out Punch' : 'Punch Log');
                            ?>
                            <tr>
                                <td style="text-align:center; padding:3px;"><?php echo $k + 1; ?></td>
                                <td style="text-align:center; padding:3px;"><?php echo $p['date']; ?></td>
                                <td style="text-align:center; padding:3px; font-weight:bold; color:#0055aa;"><?php echo $p['time']; ?></td>
                                <td style="text-align:center; padding:3px;"><?php echo $status; ?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="4" style="text-align:center; padding:6px; color:#aa0000; font-style:italic;">No punch log recorded for this date</td>
                        </tr>
                        <?php
                    }
                    ?>
                    <!-- Divider row between employees -->
                    <tr style="border:none;">
                        <td colspan="4" style="height:12px; border:none; background-color:#ffffff;"></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="4" style="text-align:center; padding:10px;">No Data Found</td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
    <br><br>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>
    <script>
        function convert_excel(type, fn, dl) {
            var elt = document.getElementById('report-data');
            var wb = XLSX.utils.table_to_book(elt, {sheet:"Punch Log"});
            return dl ?
                XLSX.write(wb, {bookType:type, bookSST:true, type: 'base64'}) :
                XLSX.writeFile(wb, fn || ('Daily_Movement_Punch_Log_' + '<?php echo date("Y_m_d", strtotime($grid_firstdate)); ?>.' + (type || 'xlsx')));
        }
        $("#btnExport").click(function(event) {
            convert_excel('xlsx');
        });
    </script>
</body>
</html>
<?php exit(); ?>
