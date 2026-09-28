<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>
        Separation Report
    </title>
</head>

<body>
    <?php 
        $data['unit_id'] = $unit_id;
        $this->load->view("head_english",$data);
        $this->db->where('training_type.id', $training_id);
        $training=$this->db->get('training_type')->row();
    ?>
    <div style="text-align: center;font-weight: bold;font-size: 18px;" >Training Name : <?= $training->title ?></div>

    <?php if ($type==0) { ?>
        <h3 align="center" height="auto" style="padding: 0;margin: 7px;">Done Training List</h3>
        <table class="heading" border="1" cellspacing="0" align="center" height="auto">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th >Employee ID</th>
                    <th style="width: 200px;">Employee Name</th>
                    <th style="width: 200px;">Training Name</th>
                    <th style="width: 200px;">Unit Name</th>
                    <th style="width: 200px;">Date</th>
                    <th style="width: 200px;">Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($done as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value->emp_id2; ?></td>
                    <td><?php echo $value->emp_name; ?></td>
                    <td><?php echo $value->training_name; ?></td>
                    <td><?php echo $value->unit_name; ?></td>
                    <td><?php echo $value->date; ?></td>
                    <td><?php echo $value->time; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } elseif ($type==1) { ?>
        <h3 align="center" height="auto" style="padding: 0;margin: 7px;">Not Done Training List</h3>
        <table class="heading" border="1" cellspacing="0" align="center" height="auto">
            <thead>
                <tr>
                    <th>SL.</th>
                    <th>Employee ID</th>
                    <th style="width: 200px;">Employee Name</th>
                    <th style="width: 200px;">Designation Name</th>
                    <th style="width: 200px;">Line Name</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($not_done as $key => $value) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $value->emp_id; ?></td>
                    <td><?php echo $value->name_en; ?></td>
                    <td><?php echo $value->desig_name; ?></td>
                    <td><?php echo $value->line_name_en; ?></td>
                    <td></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</body>

</html>