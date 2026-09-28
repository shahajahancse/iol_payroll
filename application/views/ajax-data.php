
    <div class="col-md-8">
      <table class="table table-striped">


        <tbody>
              <tr>
                  <th>Emp. ID </th>
                  <th>Unit</th>
                  <th>Start Date</th>
                  <th>Leave Type</th>
                  <th>Leave Start</th>
                  <th>Leave End</th>
                  <th>Leave Desciption</th>

                  <th>Delete</th>

              </tr>

              <?php
            // print_r($pr_leave_trans);exit('keno?');


              if(!empty($pr_leave_trans)){ foreach($pr_leave_trans as $pr_leave_transs){?>

                  <tr>
                      <td><?php echo $pr_leave_transs['emp_id'] ?></td>
                      <td><?php echo $pr_leave_transs['unit_name'] ?></td>
                      <td><?php echo $pr_leave_transs['start_date'] ?></td>
                      <td><?php echo $pr_leave_transs['leave_type'] ?></td>
                      <td><?php echo $pr_leave_transs['leave_start'] ?></td>
                      <td><?php echo $pr_leave_transs['leave_end'] ?></td>
                      <td><?php echo $pr_leave_transs['leave_descrip'] ?></td>




                      <td>
                          <a href="<?=base_url('crud_con/leave_delete').'/'.$pr_leave_transs["id"]?>" class="btn btn-danger" role="button">Delete</a>

                      </td>
                  </tr>
              <?php } }else{?>

                  <tr>
                      <td colspan="12">Records not Found</td>
                  </tr>
              <?php }?>

        </tbody>
      </table>
      <!-- Render pagination links -->
      <?php echo $this->ajax_pagination->create_links(); ?>
    </div>




