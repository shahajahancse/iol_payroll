<html>
<head>
<title>Monthly Holiday Register</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />
</head>
<body>

    <?php
        $per_page_id = 11;
        $row_count=count($value);
        if($row_count > $per_page_id){
            $page=ceil($row_count/$per_page_id);
        } else {
            $page=1;
        }
        $i = 0;
    ?>
    <div class="head-container" style="padding:20px 0px;width: 100%;display: inline-block;">
        <div style="text-align:center; position:relative;padding-left:269px;width:50%; overflow:hidden; float:left; display:block;">
            <?php $this->load->view("head_bangla"); ?>
            <span style="font-size:13px; font-weight:bold;">Holiday Register of <?php echo  $year_month ?> </span>
        </div>
    </div>
    <table class="sal" border='1' cellpadding='0' cellspacing='0' style=" font-size:16px;">
        <tr>
            <th>SL #</th>
            <th>Emp Id </th>
            <th>Name</th>
            <th>designation</th>
            <th>Line</th>
            <?php
                $last_date = date("t", strtotime("$year_month"));
                for ( $k=1 ; $k <= $last_date; $k++ ){
                    echo "<th style='width:30px;'>$k</th>";
            } ?>

            <th>T. Day</th>
        </tr>
        <?php
        for($j=0; $j < $row_count; $j++){
            $key = $i + 1;
            echo "<tr><td style='text-align:center; white-space:nowrap'> $key </td><td style='text-align:center; white-space:nowrap'>";
            echo $value[$i]['emp_id'];
            echo "</td><td style='text-align:center; white-space:nowrap'>";
            echo $value[$i]['name_en'];
            echo "</td><td style='text-align:center;'>";
            echo $value[$i]['desig_name'];
            echo "</td><td style='text-align:center;'>";
            echo $value[$i]['line_name_en'];
            echo "</td>";
            $total_night_bill_allow = 0;

            for ($k=0; $k < $last_date; $k++ ){

                if($value[$i][$k] == 1){
                    echo "<td style='text-align:center;background-color: seagreen; color: white;'>";
                }
                else{
                    echo "<td style='text-align:center;'>";
                }
                echo $value[$i][$k];
                if($value[$i][$k] == 1){
                    $total_night_bill_allow++;
                }
                echo "</td>";
            }


            echo "<td style='text-align: center;'> $total_night_bill_allow </td>";

            // echo "<td style='text-align: center;'> $total_meot </td>";
          
            echo "</tr>";
            $i++;
        } ?>
    </table>
    <div style="page-break-after:always;"></div>
</body>
</html>
<br><br><br>
<?php exit(); ?>
