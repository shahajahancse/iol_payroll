<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Earn Leave List Report</title>

</head>
<body>

<div class="container">
    <?php $this->load->view("head_english");?><br>
    <table class="table table-sm table-hover" style="font-size: 0.8em;" border="1">
        <thead>
            <tr style="text-align: center;">
                <th>SL No.</th>
                <th>Emp ID</th>
                <th style="white-space: nowrap;">Name (EN)</th>
                <th >Designation</th>
                <th style="white-space: nowrap;">Department</th>
                <th style="white-space: nowrap;">Section</th>
                <th style="white-space: nowrap;">Line </th>
                <th style="white-space: nowrap;">Join Date</th>
                <th>Actual Gross Sal</th>
                <th>Com Gross Sal</th>
                <th>Actual Paid</th>
                <th>Com Paid</th>
                <th>Paid Leave</th>
                <th style="white-space: nowrap;">Year</th>
                <th style="white-space: nowrap;">Paid Date</th>

                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach($values as $row){?>
            <tr style="text-align: center;">
                <td><?php echo $i++?></td>
                <td ><?php echo $row->emp_id?></td>
                <td><?php echo $row->name_en?></td>
                <td><?php echo $row->desig_name?></td>
                <td><?php echo $row->dept_name?></td>
                <td ><?php echo $row->sec_name_en?></td>
                <td ><?php echo $row->line_name_en?></td>
                <td style="white-space: nowrap;"><?php echo $row->emp_join_date?></td>
                <td style="white-space: nowrap;"><?php echo $row->actual_gross_sal?></td>
                <td style="white-space: nowrap;"><?php echo $row->com_gross_sal?></td>
                <td style="white-space: nowrap;"><?php echo $row->actual_paid?></td>
                <td style="white-space: nowrap;"><?php echo $row->com_paid?></td>
                <td style="white-space: nowrap;"><?php echo $row->paid_leave?></td>
                <td style="white-space: nowrap;"><?php echo $row->year?></td>
                <td style="white-space: nowrap;"><?php echo $row->paid_date?></td>

                <td >
                    <!-- <a href="<?php echo $row->id?>" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil"></i> </a> &nbsp;&nbsp; -->
                    <a href="<?php echo base_url()?>grid_con/delete?id=<?php echo $row->id?>" onclick="return confirm('Are you sure to delete this record?')" style="color:red;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>

            <?php }?>
        </tbody>
    </table>

</div>
<!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Earn Leave Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        ...
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
        </div>
    </div>
    </div>
</div> -->

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>


