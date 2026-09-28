
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Daily Roster Report</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/print.css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/SingleRow.css" />

</head>

<style>

        table {
            width: 80%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
      /*  th, td {
            padding: 4px;
            text-align: left;
        }*/
         @media print {
     	  table {
	            width: 100%;
	            border-collapse: collapse;
	        }
	        .shift-name {
	            page-break-after: always;
	        }
            .print-table {
            height: 0%; /* Set the maximum height for the table */
        }

        .print-table tr {
            height: 25px; /* Set the height of each row */
        	/*margin-bottom: 20px;*/
        }
    }
   		 
</style>

<body>
	<?php $this->load->view("head_english"); ?>
        <div style="text-align: center; font-weight: bold;">Date : <?php echo $firstdate; ?></div>
	      <br><br>
        <?php
			// Your array of data
			$groupedData = array();
			foreach ($values as $item) {
			    $shiftName = $item->shift_name;
			    // if (!isset($groupedData[$shiftName]) && $shiftName != 'Worker_HGL') {
			    if (!isset($groupedData[$shiftName])) {
			        $groupedData[$shiftName] =array();
			    }
			    // if($shiftName != 'Worker_HGL'){
			    // 	$groupedData[$shiftName][] = $item;
			    // }
			    $groupedData[$shiftName][] = $item;
			}
		?>
	<?php foreach ($groupedData as $shiftName => $shiftData) { ?>
        <table class="print-table" border="1" style="margin: 0 auto;width:50%">
            <tr>
                <td colspan="9"  style="text-align: center; margin-bottom: 20px;">
				    Shift Name: <?php echo $shiftName; ?>
				</td>
            </tr>
            <tr>
                <th style="width:">Sl.</th>
                <th style="width:">ID</th>
                <th style="width:">Full Name</th>
                <th style="width:">Designation</th>
                <th style="width:">Join Date</th>
                <th style="width:">Section</th>
                <th style="width:">Line</th>
            </tr>
            <?php $i=1; foreach ($shiftData as $item) { ?>
                <tr>
                    <td style="white-space:nowrap"><?php echo $i++?></td>
                    <td style="white-space:nowrap"><?php echo $item->emp_id; ?></td>
                    <td style="white-space:nowrap"><?php echo $item->name_en; ?></td>
                    <td style="white-space:nowrap"><?php echo $item->desig_name; ?></td>
                    <td style="white-space:nowrap"><?php echo $item->emp_join_date; ?></td>
                    <td style="white-space:nowrap"><?php echo $item->sec_name_en; ?></td>
                    <td style="white-space:nowrap"><?php echo $item->line_name_en; ?></td>
                </tr>
            <?php } ?>
        </table>
        <!-- <div class="shift-name"></div> -->
         <br><br>
    <?php } ?>
</body>
</html>
<?php exit();?>