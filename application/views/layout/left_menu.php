<!-- BEGIN SIDEBAR MENU -->
<div class="page-sidebar" id="main-menu">
  <!-- BEGIN MINI-PROFILE -->
  <div class="page-sidebar-wrapper" id="main-menu-wrapper">
    <!-- <div class="slimScrollDiv"> -->
    <!-- <div class="user-info-wrapper text-center" style=" padding-bottom: 10px; border-bottom: 1px solid #db0424;"></div> -->

    <!-- BEGIN SIDEBAR MENU -->
    <ul class="pull-left" style="margin-top: 5px">
      <li class="start <?= activate_class('payroll_con') ?>">
         <a href="<?=base_url('payroll_con')?>"> <i class="fa fa-tachometer"></i><span class="title">DashBoard</span></a>
      </li>

      <?php
        $user_id = $this->session->userdata('data')->id;
        $acl = check_acl_list($user_id);
      ?>

      <!-- Personal -->
      <?php if(in_array(1,$acl)) { ?>
      <li class="start <?= activate_class('emp_info_con') ?>"> <a href="javascript:;"> <i class="fa fa-users"></i>
        <span class="title">HRM</span> <span class="selected"></span> <span class="arrow <?= arrow_open('emp_info_con') ?>"></span> </a>
        <ul class="sub-menu">
          <?php if(in_array(11,$acl)) { ?>
            <li class="start <?= activate_method('personal_info') ?>">
              <a href="<?=base_url('emp_info_con/personal_info')?>">
                <i class="fa fa-id-card"></i> Emp Information
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(12,$acl)) { ?>
            <li class="start <?= activate_method('personal_info_short') ?>">
              <a href="<?=base_url('emp_info_con/personal_info_short')?>">
                <i class="fa fa-address-book"></i> Emp Short Information
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <!-- Enty System -->
      <?php if(in_array(2,$acl)) { ?>
      <li class="start <?= activate_class('entry_system_con') ?>"> <a href="javascript:;"> <i class="fa fa-pencil-square-o"></i>
        <span class="title">Entry System</span> <span class="selected"></span> <span class="arrow <?= arrow_open('entry_system_con') ?>"></span> </a>
        <ul class="sub-menu">
          <?php if(in_array(13,$acl)) { ?>
            <li class="<?= activate_method('grid_entry_system') ?>">
              <a href="<?= base_url('entry_system_con/grid_entry_system')?>" class="anchor_cls">
                <i class="fa fa-list-alt"></i> All Entry
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(14,$acl)) { ?>
            <li class="<?= activate_method('shift_change') ?>">
              <a href="<?= base_url('entry_system_con/shift_change')?>" class="anchor_cls">
                <i class="fa fa-exchange"></i> Shift Change
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(15,$acl)) { ?>
            <li class="<?= activate_method('emp_weekend_add') ?>">
              <a href="<?= base_url('entry_system_con/emp_weekend_add')?>" class="anchor_cls">
                <i class="fa fa-calendar-plus-o"></i> Weekend Add
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(16,$acl)) { ?>
            <li class="<?= activate_method('emp_holiday_add') ?>">
              <a href="<?= base_url('entry_system_con/emp_holiday_add')?>" class="anchor_cls">
                <i class="fa fa-calendar-check-o"></i> Holiday Add
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(17,$acl)) { ?>
            <li class="<?= activate_method('gov_holiday_list') ?>">
              <a href="<?= base_url('entry_system_con/gov_holiday_list')?>" class="anchor_cls">
                <i class="fa fa-flag"></i> Gov. Holiday
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(18,$acl)) { ?>
            <li class="<?= activate_method('leave_transation') ?>">
              <a href="<?= base_url('entry_system_con/leave_transation')?>" class="anchor_cls">
                <i class="fa fa-random"></i> Leave Transaction
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(19,$acl)) { ?>
            <li class="<?= activate_method('maternity_entry') ?>">
              <a href="<?= base_url('entry_system_con/maternity_entry')?>" class="anchor_cls">
                <i class="fa fa-female"></i> Maternity Entry
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(20,$acl)) { ?>
            <li class="<?= activate_method('leave_list') ?>">
              <a href="<?= base_url('entry_system_con/leave_list')?>" class="anchor_cls">
                <i class="fa fa-list"></i> Leave List
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(21,$acl)) { ?>
            <li class="<?= activate_method('left_resign_entry') ?>">
              <a href="<?= base_url('entry_system_con/left_resign_entry')?>" class="anchor_cls">
                <i class="fa fa-sign-out"></i> Left / Resign / Regular
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(22,$acl)) { ?>
            <li class="<?= activate_method('left_list') ?>">
              <a href="<?= base_url('entry_system_con/left_list')?>" class="anchor_cls">
                <i class="fa fa-user-times"></i> Left List
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(23,$acl)) { ?>
            <li class="<?= activate_method('resign_list') ?>">
              <a href="<?= base_url('entry_system_con/resign_list')?>" class="anchor_cls">
                <i class="fa fa-user-times"></i> Resign List
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(24,$acl)) { ?>
            <li class="<?= activate_method('incre_prom_entry') ?>">
              <a href="<?= base_url('entry_system_con/incre_prom_entry')?>" class="anchor_cls">
                <i class="fa fa-line-chart"></i> Increment / Promotion
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(25,$acl)) { ?>
            <li class="<?= activate_method('inter_unit_transfer') ?>">
              <a href="<?= base_url('entry_system_con/inter_unit_transfer')?>" class="anchor_cls">
                <i class="fa fa-retweet"></i> Unit Transfer
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(26,$acl)) { ?>
            <li class="<?= activate_method('advance_salary') ?>">
              <a href="<?= base_url('entry_system_con/advance_salary')?>" class="anchor_cls">
                <i class="fa fa-money"></i> Advance Salary
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(27,$acl)) { ?>
            <li class="<?= activate_method('advance_loan') ?>">
              <a href="<?= base_url('entry_system_con/advance_loan')?>" class="anchor_cls">
                <i class="fa fa-bank"></i> Advance Loan & Tax
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <!-- Attendance -->
      <?php if(in_array(3,$acl)) { ?>
      <li class="start <?= activate_class('attn_process_con') ?>">
        <a href="javascript:;">
          <i class="fa fa-clock-o"></i>
          <span class="title">Attendance</span>
          <span class="selected"></span>
          <span class="arrow <?= arrow_open('attn_process_con') ?>"></span>
        </a>

        <ul class="sub-menu">
          <?php if(in_array(28,$acl)) { ?>
            <li class="<?= activate_method('file_upload') ?>">
              <a href="<?=base_url('attn_process_con/file_upload')?>">
                <i class="fa fa-upload"></i> File Upload
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(29,$acl)) { ?>
            <li class="<?= activate_method('attn_process_form') ?>">
              <a href="<?=base_url('attn_process_con/attn_process_form')?>" class="anchor_cls">
                <i class="fa fa-cogs"></i> Attendance Process
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(30,$acl)) { ?>
            <li class="<?= activate_method('alert_msg_list') ?>">
              <a href="<?=base_url('attn_process_con/alert_msg_list')?>" class="anchor_cls">
                <i class="fa fa-bell"></i> Alert List
                <span class="badge badge-danger pull-right" style="margin-right:10px;">
                  <?= alt_ntf(); ?>
                </span>
              </a>
            </li>

            <li class="<?= activate_method('grid_window') ?>">
              <a href="<?=base_url('attn_process_con/grid_window')?>" class="anchor_cls">
                <i class="fa fa-bar-chart"></i> Reports
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <!-- Payroll -->
      <?php if(in_array(4,$acl)) { ?>
      <li class="start <?= activate_class('salary_process_con') ?>"> <a href="javascript:;"> <i class="fa fa-money"></i>
        <span class="title">Payroll </span> <span class="selected"></span> <span class="arrow <?= arrow_open('salary_process_con') ?>"></span> </a>
        <ul class="sub-menu">
          <?php if(in_array(31,$acl)) { ?>
            <li class="<?= activate_method('salary_process_form') ?>">
              <a href="<?=base_url('salary_process_con/salary_process_form')?>" class="anchor_cls" id="acl">
                <i class="fa fa-cogs"></i> Process
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(32,$acl)) { ?>
            <li class="<?= activate_method('adv_salary_report') ?>">
              <a href="<?=base_url('salary_process_con/adv_salary_report')?>" class="anchor_cls">
                <i class="fa fa-hand-o-right"></i> Adv. Salary
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(33,$acl)) { ?>
            <li class="<?= activate_method('grid_salary_report') ?>">
              <a href="<?=base_url('salary_process_con/grid_salary_report')?>" class="anchor_cls">
                <i class="fa fa-bar-chart"></i> Reports
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <!-- Training -->
      <?php if(in_array(6,$acl)) { ?>
        <li class="start <?= activate_class('training_con') ?>"> <a href="javascript:;"> <i class="fa fa-book fa-fw"></i>
          <span class="title">Training</span> <span class="selected"></span> <span class="arrow <?= arrow_open('training_con') ?>"></span> </a>
          <ul class="sub-menu">
            <li class="<?= activate_method('training_list') ?>">
              <a href="<?=base_url('training_con/training_list')?>">
                <i class="fa fa-list-ul"></i> Training List
              </a>
            </li>

            <li class="<?= activate_method('training') ?>">
              <a href="<?=base_url('training_con/training')?>">
                <i class="fa fa-tags"></i> Training Type
              </a>
            </li>

            <li class="<?= activate_method('training_report') ?>">
              <a href="<?=base_url('training_con/training_report')?>">
                <i class="fa fa-bar-chart"></i> Training Report
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>

      <!-- Monitoring / Audit Log -->
      <?php if(in_array(8,$acl)) { ?>
        <li class="start <?= activate_class('monitoring_con') ?>"><a href="javascript:;"><i class="fa fa-desktop"></i>
          <span class="title">Audit Log</span> <span class="selected"></span> <span class="arrow <?= arrow_open('monitoring_con') ?>"></span> </a>
          <ul class="sub-menu">
            <li class="<?= activate_method('entry_list') ?>">
              <a href="<?=base_url('monitoring_con/entry_list')?>">
                <i class="fa fa-keyboard-o"></i> Manual Entry
              </a>
            </li>

            <li class="<?= activate_method('emp_list') ?>">
              <a href="<?=base_url('monitoring_con/emp_list')?>">
                <i class="fa fa-users"></i> Employee List
              </a>
            </li>

            <li class="<?= activate_method('emp_inc_list') ?>">
              <a href="<?=base_url('monitoring_con/emp_inc_list')?>">
                <i class="fa fa-line-chart"></i> Increment / Promotion
              </a>
            </li>

            <li class="<?= activate_method('left_list') ?>">
              <a href="<?=base_url('monitoring_con/left_list')?>">
                <i class="fa fa-user-times"></i> Left List
              </a>
            </li>

            <li class="<?= activate_method('resign_list') ?>">
              <a href="<?=base_url('monitoring_con/resign_list')?>">
                <i class="fa fa-sign-out"></i> Resign List
              </a>
            </li>
          </ul>
        </li>
      <?php } ?>

      <!-- Setup -->
      <?php if(in_array(5,$acl)) { ?>
      <li class="start <?= activate_class('setup_con') ?>"> <a href="javascript:;"> <i class="fa fa-cog"></i>
        <span class="title">Setup Section </span> <span class="selected"></span> <span class="arrow <?= arrow_open('setup_con') ?>"></span> </a>
        <ul class="sub-menu">
          <?php if(in_array(34,$acl)) { ?>
            <li class="<?= activate_method('company_info_setup') ?>">
              <a href="<?=base_url('setup_con/company_info_setup')?>" class="anchor_cls">
                <i class="fa fa-building"></i> Company Information
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(35,$acl)) { ?>
            <li class="<?= activate_method('department') ?>">
              <a href="<?=base_url('setup_con/department')?>" class="anchor_cls">
                <i class="fa fa-sitemap"></i> Department
              </a>
            </li>

            <li class="<?= activate_method('section') ?>">
              <a href="<?=base_url('setup_con/section')?>" class="anchor_cls">
                <i class="fa fa-th-large"></i> Section
              </a>
            </li>

            <li class="<?= activate_method('line') ?>">
              <a href="<?=base_url('setup_con/line')?>" class="anchor_cls">
                <i class="fa fa-arrows-h"></i> Line
              </a>
            </li>

            <li class="<?= activate_method('designation') ?>">
              <a href="<?=base_url('setup_con/designation')?>" class="anchor_cls">
                <i class="fa fa-id-badge"></i> Designation
              </a>
            </li>

            <li class="<?= activate_method('position') ?>">
              <a href="<?=base_url('setup_con/position')?>" class="anchor_cls">
                <i class="fa fa-map-marker"></i> Position
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(36,$acl)) { ?>
            <li class="<?= activate_method('manage_designation') ?>">
              <a href="<?=base_url('setup_con/manage_designation')?>" class="anchor_cls">
                <i class="fa fa-tasks"></i> Manage Designation
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(37,$acl)) { ?>
            <li class="<?= activate_method('attendance_bonus') ?>">
              <a href="<?=base_url()?>setup_con/attendance_bonus" class="anchor_cls">
                <i class="fa fa-gift"></i> Attendance Bonus
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(38,$acl)) { ?>
            <li class="<?= activate_method('weekend_allowance_setup') ?>">
              <a href="<?=base_url()?>setup_con/weekend_allowance_setup">
                <i class="fa fa-calendar"></i> Weekend Allowance
              </a>
            </li>

            <li class="<?= activate_method('night_allowance_setup') ?>">
              <a href="<?=base_url('setup_con/night_allowance_setup')?>">
                <i class="fa fa-moon-o"></i> Night Allowance
              </a>
            </li>

            <li class="<?= activate_method('tiffin_bill_setup') ?>">
              <a href="<?=base_url('setup_con/tiffin_bill_setup')?>">
                <i class="fa fa-cutlery"></i> Tiffin Bill
              </a>
            </li>

            <li class="<?= activate_method('iftar_bill_setup') ?>">
              <a href="<?=base_url('setup_con/iftar_bill_setup')?>">
                <i class="fa fa-coffee"></i> Iftar Allowance
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(38,$acl)) { ?>
            <li class="<?= activate_method('shift_schedule') ?>">
              <a href="<?=base_url('setup_con/shift_schedule')?>" class="anchor_cls">
                <i class="fa fa-clock-o"></i> Shift Schedules
              </a>
            </li>

            <li class="<?= activate_method('shift_management') ?>">
              <a href="<?=base_url('setup_con/shift_management')?>" class="anchor_cls">
                <i class="fa fa-random"></i> Shift Manage
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(40,$acl)) { ?>
            <li class="<?= activate_method('emp_roster_shift') ?>">
              <a href="<?=base_url('setup_con/emp_roster_shift')?>" class="anchor_cls">
                <i class="fa fa-calendar-check-o"></i> Roster Shift
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(41,$acl)) { ?>
            <li class="<?= activate_method('alternet_day') ?>">
              <a href="<?=base_url('setup_con/alternet_day')?>">
                <i class="fa fa-exchange"></i> Alternet Day
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(42,$acl)) { ?>
            <li class="<?= activate_method('salary_grade') ?>">
              <a href="<?=base_url('setup_con/salary_grade')?>" class="anchor_cls">
                <i class="fa fa-money"></i> Salary Grade
              </a>
            </li>

            <li class="<?= activate_method('leave_setup') ?>">
              <a href="<?=base_url()?>setup_con/leave_setup" class="anchor_cls">
                <i class="fa fa-plane"></i> Leave
              </a>
            </li>

            <li class="<?= activate_method('bonus_setup') ?>">
              <a href="<?=base_url()?>setup_con/bonus_setup" class="anchor_cls">
                <i class="fa fa-gift"></i> Bonus
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(43,$acl)) { ?>
            <li class="<?= activate_method('post_office') ?>">
              <a href="<?=base_url('setup_con/post_office')?>" class="anchor_cls">
                <i class="fa fa-envelope-o"></i> Post Office
              </a>
            </li>
          <?php } ?>

        </ul>
      </li>
      <?php } ?>

      <!-- Setting -->
      <?php if($this->session->userdata('data')->level == "All" || in_array(7,$acl)) { ?>
      <li class="start <?= activate_class('setting_con') ?>"> <a href="javascript:;"> <i class="fa fa-wrench"></i>
        <span class="title">Settings </span> <span class="selected"></span> <span class="arrow <?= arrow_open('setting_con') ?>"></span> </a>
        <ul class="sub-menu">
          <?php if(in_array(44,$acl)) { ?>
            <li class="<?= activate_method('crud') ?>">
              <a href="<?=base_url('setting_con/crud')?>" class="anchor_cls" id="acl">
                <i class="fa fa-key"></i> Access
              </a>
            </li>

            <li class="<?= activate_method('left_menu_acl') ?>">
              <a href="<?=base_url('setting_con/left_menu_acl')?>" class="anchor_cls" id="acl">
                <i class="fa fa-bars"></i> Left Menu Access
              </a>
            </li>

            <li class="<?= activate_method('user_acl_hrm') ?>">
              <a href="<?=base_url('setting_con/user_acl_hrm')?>" class="anchor_cls" id="acl">
                <i class="fa fa-user"></i> User Access HRM
              </a>
            </li>

            <li class="<?= activate_method('user_acl_pr') ?>">
              <a href="<?=base_url('setting_con/user_acl_pr')?>" class="anchor_cls" id="acl">
                <i class="fa fa-money"></i> User Access Payroll
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(45,$acl)) { ?>
            <li class="<?= activate_method('report_setting') ?>">
              <a href="<?=base_url('setting_con/report_setting')?>" class="anchor_cls" id="acl">
                <i class="fa fa-file-text-o"></i> Report Setting
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(46,$acl)) { ?>
            <li class="<?= activate_method('hide_designation_employee') ?>">
              <a href="<?=base_url('setting_con/hide_designation_employee')?>" class="anchor_cls" id="acl">
                <i class="fa fa-eye-slash"></i> Hide Designation
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(47,$acl)) { ?>
            <li class="<?= activate_method('dasig_group') ?>">
              <a href="<?=base_url('setting_con/dasig_group')?>" class="anchor_cls" id="acl">
                <i class="fa fa-object-group"></i> Group Designation
              </a>
            </li>

            <li class="<?= activate_method('line_wise_atn_desig') ?>">
              <a href="<?=base_url('setting_con/line_wise_atn_desig')?>" class="anchor_cls" id="acl">
                <i class="fa fa-sitemap"></i> Line wise Designation
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(48,$acl)) { ?>
            <li class="<?= activate_method('acl') ?>">
              <a href="<?=base_url('setting_con/acl')?>" class="anchor_cls" id="acl">
                <i class="fa fa-shield"></i> User ACL
              </a>
            </li>
          <?php } ?>

          <?php if(in_array(49,$acl)) { ?>
            <li class="<?= activate_method('activity_log') ?>">
              <a href="<?=base_url('setting_con/activity_log')?>" class="anchor_cls" id="activity_log">
                <i class="fa fa-history"></i> Activity Log
              </a>
            </li>
          <?php } ?>
        </ul>
      </li>
      <?php } ?>

      <li class="start">
         <a href="<?=base_url('payroll_con/first_body')?>"> <i class="fa fa-phone"></i>  <span class="title">Support</span></a>
      </li>
      <li class="start"><a href="<?=base_url('logout_FE')?>"> <i class="fa fa-power-off"></i>  <span class="title">Log Out</span></a>
      </li>

    </ul>
    <div id="notification_div"></div>
    <div class="clearfix"></div>
    <!-- END SIDEBAR MENU -->
  </div>
</div>

<a href="#" class="scrollup">Scroll</a>
<div class="footer-widget">
  <div class="copyrights" style="width: 100%;display: flex;align-items: center;justify-content: space-around;">
    <div style="border-right: 2px solid white;padding-right: 15px;color: white;">Developed By</div>
    <div><img src="<?=base_url()?>awedget/assets/img/mysoft-logo_full.png" alt="" style="height: 34px;"></div>

  </div>
</div>
<!-- END SIDEBAR -->

