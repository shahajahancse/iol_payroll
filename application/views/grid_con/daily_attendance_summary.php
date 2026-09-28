<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-size: 13px; }
        .table, th, td {
            border:1px solid black;
            border-collapse: collapse;
        }
        th, td {
            text-align: center;
            padding: 4px;
        }
        .header-sub {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <?php $this->load->view("head_english");?>
    <h4 style="text-align:center">Line Wise Attendance Summary Report <?php echo date('d/m/Y',strtotime($report_date))?></h4>

    <table class="table" align="center">
        <tr>
            <th rowspan="2" style="background: #dbf5f9; font-size:12px">Sl.</th>
            <th rowspan="2" style="background: #dbf5f9; font-size:12px">Line Name</th>
            <?php foreach($keys as $key): ?>
                <th colspan="6" style="background: #dbf5f9;font-size:12px"><?php echo $key; ?></th>
            <?php endforeach; ?>
            <th rowspan="2" style="background: #dbf5f9;font-size:12px">Remark</th>
        </tr>
        <tr>
            <?php foreach($keys as $key): ?>
                <th class="header-sub" style="background: #dbf5f9;">Budget</th>
                <th class="header-sub" style="background: #dbf5f9;">On-Roll</th>
                <th class="header-sub" style="background: #dbf5f9;">Diff</th>
                <th class="header-sub" style="background: #dbf5f9;">P</th>
                <th class="header-sub" style="background: #dbf5f9;">A</th>
                <th class="header-sub" style="background: #dbf5f9;">LV</th>
            <?php endforeach; ?>
        </tr>

        <?php
            $i = 1;
            $gb = $or = $dif = $tp = $ta = $tv = array();
            foreach($results as $row):
        ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row->line_name_en; ?></td>
                <?php foreach($keys as $key): 
                    $group_data = $row->group_data[$key] ?? (object)[
                        'group_budget'=>0, 'total_emp'=>0, 'emp_diff'=>0,
                        'emp_present'=>0, 'emp_absent'=>0, 'emp_leave'=>0
                    ];

                    $gb[$key] = ($gb[$key] ?? 0) + $group_data->group_budget;
                    $or[$key] = ($or[$key] ?? 0) + $group_data->total_emp;
                    $diff_val = $group_data->group_budget - $group_data->total_emp;
                    $dif[$key] = ($dif[$key] ?? 0) + $diff_val;
                    $tp[$key] = ($tp[$key] ?? 0) + $group_data->emp_present;
                    $ta[$key] = ($ta[$key] ?? 0) + $group_data->emp_absent;
                    $tv[$key] = ($tv[$key] ?? 0) + $group_data->emp_leave;
                ?>
                    <td><?php echo $group_data->group_budget ?: '0'; ?></td>
                    <td><?php echo $group_data->total_emp ?: '0'; ?></td>
                    <td style="<?php echo ($diff_val < 0) ? 'color:red;' : ''; ?>">
                        <?php echo abs($diff_val); ?>
                    </td>
                    <td><?php echo $group_data->emp_present ?: '0'; ?></td>
                    <td><?php echo $group_data->emp_absent  ?: '0'; ?></td>
                    <td><?php echo $group_data->emp_leave   ?: '0'; ?></td>
                <?php endforeach; ?>
                <td></td>
            </tr>
        <?php endforeach; ?>

        <!-- Total Row -->
        <tr style="font-weight:bold">
            <td colspan="2"  style="background: #dbf5f9;">Total</td>
            <?php foreach($keys as $key): ?>
                <td  style="background: #dbf5f9;"><?php echo $gb[$key]; ?></td>
                <td  style="background: #dbf5f9;"><?php echo $or[$key]; ?></td>
                <td  style="background: #dbf5f9;"><?php echo abs($dif[$key]); ?></td>
                <td  style="background: #dbf5f9;"><?php echo $tp[$key]; ?></td>
                <td  style="background: #dbf5f9;"><?php echo $ta[$key]; ?></td>
                <td  style="background: #dbf5f9;"><?php echo $tv[$key]; ?></td>
            <?php endforeach; ?>
            <td></td>
        </tr>
    </table>
</body>
</html>
<?php exit(); ?>
