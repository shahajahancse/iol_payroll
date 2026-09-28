
<div class="content">
<!-- Static navbar -->
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Update Shift Schedule</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <!-- <li class="active"><a href="<?php echo base_url('payroll_con') ?>">Home</a></li> -->
            </ul>

          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>

  <h3>Update Shift Schedule</h3>
  <hr>
  <form enctype="multipart/form-data" method="post" name="editshiftschedule" action="<?php echo base_url().'setup_con/shiftschedule_edit/'.$pr_emp_shift_schedule->id;?>">
  <div class="row">
    <div class="col-md-6">
      <input type="hidden" name="id"value="<?=$pr_emp_shift_schedule->id;?>" class="form-control">
      <div class="form-group">
          <select name="uname" id= "uname" class="form-control input-lg select22">
            <option value="">Select Unit</option>
            <?php
            foreach ($allUnit as  $row){?>
              <option value="<?=$row['unit_id']?>"<?php if($row['unit_id']==$pr_emp_shift_schedule->unit_id){echo 'selected';}?>><?=$row['unit_name']?></option>">Select Unit</option>
            <?php } ?>
          </select>
        </div>

     <div class="form-group">
        <label>Shift Type</label>
        <input type="text" name="stype"value="<?=set_value('sh_type',$pr_emp_shift_schedule->sh_type)?>" class="form-control">
        <?php echo form_error('stype');?>
      </div>
     <div class="form-group">

        <label>IN Start</label>
        <input type="text" name="instrt"value="<?=set_value('in_start',$pr_emp_shift_schedule->in_start)?>" class="form-control">
        <?php echo form_error('instrt');?>
      </div>
     <div class="form-group">

        <label>IN Time</label>
        <input type="text" name="intime"value="<?=set_value('in_time',$pr_emp_shift_schedule->in_time)?>" class="form-control">
        <?php echo form_error('intime');?>
      </div>
     <div class="form-group">

        <label>Late Start</label>
        <input type="text" name="ltstart"value="<?=set_value('late_start',$pr_emp_shift_schedule->late_start)?>" class="form-control">
        <?php echo form_error('ltstart');?>
      </div>
     <div class="form-group">

        <label>IN End</label>
        <input type="text" name="inend"value="<?=set_value('in_end',$pr_emp_shift_schedule->in_end)?>" class="form-control">
        <?php echo form_error('inend');?>
      </div>
     <div class="form-group">

        <label>OUT Start</label>
        <input type="text" name="outstart"value="<?=set_value('out_start',$pr_emp_shift_schedule->out_start)?>" class="form-control">
        <?php echo form_error('outstart');?>
      </div>
     <div class="form-group">

        <label>OUT End</label>
        <input type="text" name="outend"value="<?=set_value('out_end',$pr_emp_shift_schedule->out_end)?>" class="form-control">
        <?php echo form_error('outend');?>
      </div>
     <div class="form-group">
        <label>OT Start</label>
        <input type="text" name="otstart"value="<?=set_value('ot_start',$pr_emp_shift_schedule->ot_start)?>" class="form-control">
        <?php echo form_error('otstart');?>
      </div>
     <div class="form-group">
        <label>OT Minute</label>
        <input type="text" name="otminute"value="<?=set_value('ot_minute_to_one_hour',$pr_emp_shift_schedule->ot_minute_to_one_hour)?>" class="form-control">
        <?php echo form_error('otminute');?>
      </div>

     <div class="form-group">
        <label>One Hour OT Time</label>
        <input type="text" name="onehrottime"value="<?=set_value('one_hour_ot_out_time',$pr_emp_shift_schedule->one_hour_ot_out_time)?>" class="form-control">
        <?php echo form_error('onehrottime');?>
      </div>

     <div class="form-group">
        <label>Two Hour OT Time</label>
        <input type="text" name="twohrottime"value="<?=set_value('two_hour_ot_out_time',$pr_emp_shift_schedule->two_hour_ot_out_time)?>" class="form-control">
        <?php echo form_error('twohrottime');?>
      </div>

      <div class="form-group">
        <label>Lunch Start</label>
        <input type="text" name="lunch_start" value="<?=set_value('lunch_start',$pr_emp_shift_schedule->lunch_start)?>" class="form-control">
        <?php echo form_error('lunch_start');?>
      </div>

      <div class="form-group">
        <label>Lunch Minute</label>
        <input type="text" name="lunch_minute" value="<?=set_value('lunch_minute',$pr_emp_shift_schedule->lunch_minute)?>" class="form-control">
        <?php echo form_error('lunch_minute');?>
      </div>

      <div class="form-group">
        <label>Tiffin Break (Evening)</label>
        <input type="text" name="tiffin_break" value="<?=set_value('tiffin_break',$pr_emp_shift_schedule->tiffin_break)?>" class="form-control">
        <?php echo form_error('tiffin_break');?>
      </div>

      <div class="form-group">
        <label>Tiffin Minute (Evening)</label>
        <input type="text" name="tiffin_minute" value="<?=set_value('tiffin_minute',$pr_emp_shift_schedule->tiffin_minute)?>" class="form-control">
        <?php echo form_error('tiffin_minute');?>
      </div>

      <div class="form-group">
        <label>Tiffin Break Two</label>
        <input type="text" name="tiffin_break2" value="<?=set_value('tiffin_break2',$pr_emp_shift_schedule->tiffin_break2)?>" class="form-control">
        <?php echo form_error('tiffin_break2');?>
      </div>

      <div class="form-group">
        <label>Tiffin Minute Two</label>
        <input type="text" name="tiffin_minute2" value="<?=set_value('tiffin_minute2',$pr_emp_shift_schedule->tiffin_minute2)?>" class="form-control">
        <?php echo form_error('tiffin_minute2');?>
      </div>

      <div class="form-group">
        <label>Random Minute</label>
        <input type="text" name="random_minute" value="<?=set_value('random_minute',$pr_emp_shift_schedule->random_minute)?>" class="form-control">
        <?php echo form_error('random_minute');?>
      </div>

      <div class="form-group">
          <label> Off Days <i class="hrsale-asterisk"><span style="color:red">*</span></i></label>
          <select multiple="multiple" class="select22 sinput-sm" name="of_day[]" data-plugin="select_hrm" data-placeholder="select one" required >
              <option value="Fri">Friday</option>
              <option value="Sat">Saturday</option>
              <option value="Sun">Sunday</option>
              <option value="Mon">Monday</option>
              <option value="Tue">Tuesday</option>
              <option value="Wed">Wednesday</option>
              <option value="Thu">Thursday</option>
          </select>
      </div>
      <style>
          .sinput-sm {
              height: 40px !important;
              width: 100%;
          }
          .select2-container-multi .select2-choices {
              height: 40px !important;
              top: -1px;
              width: 101%;
              left: -1px;
          }
      </style>

      <div class="form-group">
        <button class="btn btn-primary">Update</button>
        <a href=""class="btn-warning btn">Cancel</a>
      </div>
    </div>
  </div>
</form>
</div>
