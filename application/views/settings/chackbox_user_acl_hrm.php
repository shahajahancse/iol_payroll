<?php
// Determine category structure based on ACL type
if (isset($type) && $type == 3) {
    // ==========================================
    // TYPE 3: User Access HRM
    // ==========================================
    // Condition flag: set to true to display Final Settlement Reports if needed in future
    $show_final_settlement = false;

    $menu_categories = array(
        array(
            'title' => 'Daily Attendance Reports',
            'icon'  => 'fa fa-clock-o',
            'color' => '#1b75bb',
            'items' => array(
                array('id' => 70,  'name' => 'Actual Present Report', 'is_main' => false),
                array('id' => 62,  'name' => 'Absent Report', 'is_main' => false),
                array('id' => 64,  'name' => 'Late Report', 'is_main' => false),
                array('id' => 65,  'name' => 'OT Report', 'is_main' => false),
                array('id' => 71,  'name' => 'Actual Out & IN Report', 'is_main' => false),
                array('id' => 68,  'name' => 'Daily Out Punch Miss', 'is_main' => false),
                array('id' => 124, 'name' => 'Job Card Actual', 'is_main' => false),
                array('id' => 131, 'name' => 'Roster List', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Continuous & Periodical Reports',
            'icon'  => 'fa fa-line-chart',
            'color' => '#27ae60',
            'items' => array(
                array('id' => 84,  'name' => 'Present Report Continuous', 'is_main' => false),
                array('id' => 85,  'name' => 'Absent Report Continuous', 'is_main' => false),
                array('id' => 86,  'name' => 'Leave Report Continuous', 'is_main' => false),
                array('id' => 87,  'name' => 'Late Report Continuous', 'is_main' => false),
                array('id' => 92,  'name' => 'OT / EOT Report Continuous', 'is_main' => false),
                array('id' => 88,  'name' => 'Increment Report Continuous', 'is_main' => false),
                array('id' => 89,  'name' => 'Promotion Report Continuous', 'is_main' => false),
                array('id' => 94,  'name' => 'Last Increment Check', 'is_main' => false),
                array('id' => 95,  'name' => 'Last Promotion Check', 'is_main' => false),
                array('id' => 96,  'name' => 'Increment Able Employee', 'is_main' => false),
                array('id' => 105, 'name' => 'New Join Report', 'is_main' => false),
                array('id' => 106, 'name' => 'Resign Report Other', 'is_main' => false),
                array('id' => 107, 'name' => 'Left Report Other', 'is_main' => false),
                array('id' => 109, 'name' => 'General Report (Eng)', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Employee Cards & Official Letters',
            'icon'  => 'fa fa-id-card-o',
            'color' => '#f39c12',
            'items' => array(
                array('id' => 102, 'name' => 'ID Card (Bangla)', 'is_main' => false),
                array('id' => 103, 'name' => 'ID Card (English)', 'is_main' => false),
                array('id' => 113, 'name' => 'Job Application', 'is_main' => false),
                array('id' => 114, 'name' => 'Joining Letter', 'is_main' => false),
                array('id' => 118, 'name' => 'Employee Information', 'is_main' => false),
                array('id' => 119, 'name' => 'Increment Letter', 'is_main' => false),
                array('id' => 120, 'name' => 'Promotion Letter', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Final Settlement Reports',
            'icon'  => 'fa fa-calculator',
            'color' => '#8e44ad',
            'items' => array(
                array('id' => 132, 'name' => 'Final Settlement Acc.', 'is_main' => false, 'hidden' => !$show_final_settlement),
                array('id' => 133, 'name' => 'Final Settlement 7pm', 'is_main' => false, 'hidden' => !$show_final_settlement),
                array('id' => 134, 'name' => 'Final Settlement 10pm', 'is_main' => false, 'hidden' => !$show_final_settlement),
                array('id' => 135, 'name' => 'Final Settlement 12am', 'is_main' => false, 'hidden' => !$show_final_settlement),
                array('id' => 136, 'name' => 'Final Settlement All', 'is_main' => false, 'hidden' => !$show_final_settlement),
            )
        ),
        array(
            'title' => 'Delete & Maintenance Permissions',
            'icon'  => 'fa fa-trash',
            'color' => '#d9534f',
            'items' => array(
                array('id' => 137, 'name' => 'All Entry Absent', 'is_main' => false),
                array('id' => 138, 'name' => 'All Entry Delete', 'is_main' => false),
                array('id' => 139, 'name' => 'Delete Leave', 'is_main' => false),
                array('id' => 140, 'name' => 'Upload File Delete', 'is_main' => false),
                array('id' => 141, 'name' => 'Company Info Delete', 'is_main' => false),
                array('id' => 142, 'name' => 'Department Delete', 'is_main' => false),
                array('id' => 143, 'name' => 'Section Delete', 'is_main' => false),
                array('id' => 144, 'name' => 'Line Delete', 'is_main' => false),
                array('id' => 145, 'name' => 'Designation Delete', 'is_main' => false),
                array('id' => 146, 'name' => 'Attn Bonus Delete', 'is_main' => false),
                array('id' => 147, 'name' => 'Weekend Allowance Delete', 'is_main' => false),
                array('id' => 148, 'name' => 'Night Allowance Delete', 'is_main' => false),
                array('id' => 149, 'name' => 'Tiffin Bill Delete', 'is_main' => false),
                array('id' => 150, 'name' => 'Ifter Allowance Delete', 'is_main' => false),
                array('id' => 151, 'name' => 'Salary Grade Delete', 'is_main' => false),
                array('id' => 152, 'name' => 'Bonus Delete', 'is_main' => false),
                array('id' => 153, 'name' => 'Post Office Delete', 'is_main' => false),
                array('id' => 154, 'name' => 'Shift Schedule Delete', 'is_main' => false),
                array('id' => 155, 'name' => 'Shift Manage Delete', 'is_main' => false),
            )
        )
    );
} elseif (isset($type) && $type == 4) {
    // ==========================================
    // TYPE 4: User Access Payroll
    // ==========================================
    $menu_categories = array(
        array(
            'title' => 'Salary Sheets & Statements',
            'icon'  => 'fa fa-money',
            'color' => '#16a085',
            'items' => array(
                array('id' => 184, 'name' => 'Actual Salary Sheet', 'is_main' => false),
                array('id' => 185, 'name' => 'Actual Pay Slip', 'is_main' => false),
                array('id' => 186, 'name' => 'Actual Salary Summary', 'is_main' => false),
                array('id' => 187, 'name' => 'Actual Sec Salary Summary', 'is_main' => false),
                array('id' => 188, 'name' => 'Actual Salary Bank', 'is_main' => false),
                array('id' => 195, 'name' => 'Stop Salary Sheet', 'is_main' => false),
                array('id' => 211, 'name' => 'Comparative Statement', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Overtime & EOT Sheets',
            'icon'  => 'fa fa-clock-o',
            'color' => '#e67e22',
            'items' => array(
                array('id' => 189, 'name' => 'Actual EOT Sheet', 'is_main' => false),
                array('id' => 190, 'name' => 'Actual EOT Summary', 'is_main' => false),
                array('id' => 191, 'name' => 'Actual EOT Bank', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Bonus & Festival Sheets',
            'icon'  => 'fa fa-gift',
            'color' => '#8e44ad',
            'items' => array(
                array('id' => 206, 'name' => 'Festival Bonus', 'is_main' => false),
                array('id' => 207, 'name' => 'Festival Bonus Summary', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Salary Processing & Deletions',
            'icon'  => 'fa fa-cogs',
            'color' => '#d9534f',
            'items' => array(
                array('id' => 204, 'name' => 'Salary Final Process', 'is_main' => false),
                array('id' => 205, 'name' => 'Stop Salary', 'is_main' => false),
                array('id' => 202, 'name' => 'Salary Final Delete', 'is_main' => false),
                array('id' => 203, 'name' => 'Stop Salary Month Delete', 'is_main' => false),
            )
        )
    );
} else {
    // ==========================================
    // TYPE 1: Left Menu Access
    // ==========================================
    $menu_categories = array(
        array(
            'title' => 'HRM',
            'icon'  => 'fa fa-users',
            'color' => '#1b75bb',
            'items' => array(
                array('id' => 1,  'name' => 'HRM (Main Menu)', 'is_main' => true),
                array('id' => 11, 'name' => 'Employee List', 'is_main' => false),
                array('id' => 50, 'name' => 'Add Employee', 'is_main' => false),
                array('id' => 12, 'name' => 'Add Employee Short Form', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Entry System',
            'icon'  => 'fa fa-pencil-square-o',
            'color' => '#27ae60',
            'items' => array(
                array('id' => 2,  'name' => 'Entry System (Main Menu)', 'is_main' => true),
                array('id' => 13, 'name' => 'All Entry', 'is_main' => false),
                array('id' => 14, 'name' => 'Shift Change', 'is_main' => false),
                array('id' => 51, 'name' => 'Emp Shift Change', 'is_main' => false),
                array('id' => 16, 'name' => 'Holiday Add', 'is_main' => false),
                array('id' => 15, 'name' => 'Weekend Add', 'is_main' => false),
                array('id' => 21, 'name' => 'Left / Resign / Regular', 'is_main' => false),
                array('id' => 22, 'name' => 'Left List', 'is_main' => false),
                array('id' => 23, 'name' => 'Resign List', 'is_main' => false),
                array('id' => 24, 'name' => 'Increment / Promotion', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Leave',
            'icon'  => 'fa fa-calendar-check-o',
            'color' => '#f39c12',
            'items' => array(
                array('id' => 18, 'name' => 'Leave Transaction (Leave Entry)', 'is_main' => false),
                array('id' => 20, 'name' => 'Leave List', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Attendance',
            'icon'  => 'fa fa-clock-o',
            'color' => '#e74c3c',
            'items' => array(
                array('id' => 3,   'name' => 'Attendance (Main Menu)', 'is_main' => true),
                array('id' => 28,  'name' => 'File Upload', 'is_main' => false),
                array('id' => 29,  'name' => 'Attendance Process', 'is_main' => false),
                array('id' => 30,  'name' => 'Reports', 'is_main' => false),
                array('id' => 218, 'name' => 'Daily OT Approval', 'is_main' => false),
                array('id' => 52,  'name' => 'Attn. Regularization', 'is_main' => false),
                array('id' => 53,  'name' => 'Outside Duty (OD)', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Payroll',
            'icon'  => 'fa fa-money',
            'color' => '#16a085',
            'items' => array(
                array('id' => 4,  'name' => 'Payroll (Main Menu)', 'is_main' => true),
                array('id' => 31, 'name' => 'Salary Process', 'is_main' => false),
                array('id' => 54, 'name' => 'Arrear Salary', 'is_main' => false),
                array('id' => 32, 'name' => 'Advanced Salary', 'is_main' => false),
                array('id' => 33, 'name' => 'Salary Reports', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Setup Section',
            'icon'  => 'fa fa-cog',
            'color' => '#8e44ad',
            'items' => array(
                array('id' => 5,  'name' => 'Setup Section (Main Menu)', 'is_main' => true),
                array('id' => 34, 'name' => 'Company Information', 'is_main' => false),
                array('id' => 35, 'name' => 'Department', 'is_main' => false),
                array('id' => 55, 'name' => 'Section', 'is_main' => false),
                array('id' => 56, 'name' => 'Designation', 'is_main' => false),
                array('id' => 39, 'name' => 'Shift Schedules', 'is_main' => false),
                array('id' => 57, 'name' => 'Shift Manage', 'is_main' => false),
                array('id' => 40, 'name' => 'Roster Shift', 'is_main' => false, 'hidden' => true),
                array('id' => 42, 'name' => 'Salary Grade', 'is_main' => false),
                array('id' => 58, 'name' => 'Leave Setup', 'is_main' => false),
                array('id' => 59, 'name' => 'Bonus Setup', 'is_main' => false, 'hidden' => true),
                array('id' => 43, 'name' => 'Post Office', 'is_main' => false),
                array('id' => 38, 'name' => 'All Allowance', 'is_main' => false, 'hidden' => true),
            )
        ),
        array(
            'title' => 'Settings',
            'icon'  => 'fa fa-wrench',
            'color' => '#d35400',
            'items' => array(
                array('id' => 7,   'name' => 'Settings (Main Menu)', 'is_main' => true),
                array('id' => 44,  'name' => 'Left Menu Access', 'is_main' => false),
                array('id' => 60,  'name' => 'User Access HRM', 'is_main' => false),
                array('id' => 212, 'name' => 'User Access Payroll', 'is_main' => false),
                array('id' => 48,  'name' => 'User ACL', 'is_main' => false),
                array('id' => 49,  'name' => 'Activity Log', 'is_main' => false),
            )
        ),
        array(
            'title' => 'Administrator',
            'icon'  => 'fa fa-shield',
            'color' => '#34495e',
            'items' => array(
                array('id' => 10, 'name' => 'Administrator', 'is_main' => true),
            )
        )
    );
}

// Map all DB access list items by ID
$access_map = array();
$all_mapped_ids = array();
if (!empty($access_list)) {
    foreach ($access_list as $item) {
        $access_map[$item->id] = $item;
    }
}

// Collect mapped IDs
foreach ($menu_categories as $cat) {
    foreach ($cat['items'] as $item) {
        $all_mapped_ids[] = $item['id'];
    }
}

// Any items from DB that were not explicitly in menu categories (ensures NO permission is ever missed)
$other_items = array();
if (!empty($access_list)) {
    foreach ($access_list as $item) {
        if (!in_array($item->id, $all_mapped_ids)) {
            $other_items[] = array('id' => $item->id, 'name' => $item->acl_name, 'is_main' => false);
        }
    }
}
if (!empty($other_items)) {
    $menu_categories[] = array(
        'title' => 'Other Permissions',
        'icon'  => 'fa fa-th-list',
        'color' => '#7f8c8d',
        'items' => $other_items
    );
}

// Calculate total count (excluding conditionally hidden menus)
$total_items = 0;
$assigned_count = 0;
foreach ($menu_categories as $cat) {
    foreach ($cat['items'] as $item) {
        if (!empty($item['hidden'])) {
            continue; // Skip conditionally hidden menus
        }
        if (isset($access_map[$item['id']])) {
            $total_items++;
            if (in_array($item['id'], $level_array)) {
                $assigned_count++;
            }
        }
    }
}
?>

<div class="col-md-12" style="padding: 0;">
    <!-- Controls Bar -->
    <div style="background: #fff; padding: 12px 18px; border-radius: 6px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <span style="font-size: 14px; font-weight: 700; color: #222;">
                <i class="fa fa-shield" style="color: #1b75bb;"></i> Assigned Permissions:
            </span>
            <span id="assigned-counter-badge" style="background: #1b75bb; color: #ffffff !important; font-size: 13px; font-weight: 700; padding: 5px 12px; border-radius: 12px; display: inline-block; box-shadow: 0 1px 3px rgba(27,117,187,0.3);">
                <span id="active-count" style="color: #ffffff !important; font-weight: 700;"><?= $assigned_count ?></span> / <span style="color: #ffffff !important; font-weight: 700;"><?= $total_items ?></span> Active
            </span>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <div style="position: relative; width: 220px;">
                <input type="text" id="acl-quick-filter" class="form-control input-sm" placeholder="Search menu / permission..." onkeyup="filter_acl_items(this.value)" style="border-radius: 15px; padding-left: 28px; font-size: 13px; color: #222; font-weight: 500;">
                <i class="fa fa-search" style="position: absolute; left: 10px; top: 8px; color: #888;"></i>
            </div>
            <button type="button" class="btn btn-sm btn-info" id="btn-toggle-accordions" onclick="toggle_all_accordions()" style="border-radius: 4px; font-weight: 600;">
                <i class="fa fa-compress"></i> Collapse All
            </button>
            <button type="button" class="btn btn-sm btn-success" onclick="toggle_all_permissions(true, <?= $user_id ?>)" style="border-radius: 4px; font-weight: 600;">
                <i class="fa fa-check-square-o"></i> Select All
            </button>
            <button type="button" class="btn btn-sm btn-default" onclick="toggle_all_permissions(false, <?= $user_id ?>)" style="border-radius: 4px; font-weight: 600; color: #333;">
                <i class="fa fa-square-o"></i> Deselect All
            </button>
        </div>
    </div>

    <!-- Menu Sections in Single Serial (Accordion / Collapsible) -->
    <div class="acl-sections-container">
        <?php foreach ($menu_categories as $c_idx => $cat) { 
            // Filter only available items in DB (and not hidden)
            $valid_items = array();
            foreach ($cat['items'] as $it) {
                if (!empty($it['hidden'])) {
                    continue; // Skip conditionally hidden menus
                }
                if (isset($access_map[$it['id']])) {
                    $valid_items[] = $it;
                }
            }
            if (empty($valid_items)) continue;

            $cat_assigned = 0;
            foreach ($valid_items as $vi) {
                if (in_array($vi['id'], $level_array)) $cat_assigned++;
            }
        ?>
        <div class="col-md-12 acl-category-box" style="padding: 0; margin-bottom: 14px;">
            <div class="panel panel-default" style="border-radius: 6px; border: 1px solid #d5dbe0; border-top: 3px solid <?= $cat['color'] ?>; box-shadow: 0 1px 4px rgba(0,0,0,0.06); margin-bottom: 0;">
                <!-- Header with Accordion Toggler -->
                <div class="panel-heading acl-accordion-header" onclick="toggle_category_accordion(this)" style="background: #f8fafc; padding: 11px 16px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e2e8f0; cursor: pointer; user-select: none; transition: background 0.15s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    <div style="font-weight: 700; font-size: 15px; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                        <i class="fa fa-chevron-down acl-chevron" style="color: #64748b; font-size: 13px; width: 14px; text-align: center; transition: transform 0.2s ease;"></i>
                        <i class="<?= $cat['icon'] ?>" style="color: <?= $cat['color'] ?>; font-size: 16px; margin-right: 2px;"></i>
                        <span><?= htmlspecialchars($cat['title']) ?></span>
                        <span style="background: #ffffff; color: #334155 !important; border: 1px solid #cbd5e1; font-size: 11.5px; padding: 2px 9px; border-radius: 12px; margin-left: 6px; font-weight: 700;" id="badge-cat-<?= $c_idx ?>">
                            <span class="cat-checked-count" style="color: <?= $cat['color'] ?>; font-weight: 700;"><?= $cat_assigned ?></span> / <?= count($valid_items) ?>
                        </span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 8px;" onclick="event.stopPropagation();">
                        <button type="button" class="btn btn-xs btn-default" onclick="toggle_single_category(this, <?= $user_id ?>)" style="font-size: 11px; padding: 4px 10px; border-radius: 4px; font-weight: 600; color: #475569;">
                            Toggle All
                        </button>
                    </div>
                </div>

                <!-- Body (Collapsible) -->
                <div class="panel-body acl-category-body" style="padding: 12px 16px;">
                    <div class="row" style="margin-left: -5px; margin-right: -5px;">
                        <?php foreach ($valid_items as $item) { 
                            $is_checked = in_array($item['id'], $level_array);
                            $is_main = !empty($item['is_main']);
                        ?>
                        <div class="<?= $is_main ? 'col-md-12' : 'col-md-6 col-sm-12' ?> acl-item-row" data-name="<?= strtolower(htmlspecialchars($item['name'])) ?>" style="padding: 2px 5px; margin-bottom: 4px;">
                            <label style="display: flex; align-items: center; padding: 7px 10px; margin-bottom: 0; border-radius: 4px; cursor: pointer; transition: background 0.15s; <?= $is_main ? 'background: #f0f6fc; border-left: 4px solid ' . $cat['color'] . ';' : 'margin-left: 10px;' ?>" onmouseover="this.style.background='#e8f2fa'" onmouseout="this.style.background='<?= $is_main ? '#f0f6fc' : 'transparent' ?>'">
                                <input type="checkbox" class="acl-perm-checkbox" data-id="<?= $item['id'] ?>" onchange="check_level_status(<?= $item['id'] ?>, <?= $user_id ?>, this.checked, this)" <?= $is_checked ? 'checked' : '' ?> style="margin-top: 0; margin-right: 10px; width: 16px; height: 16px; cursor: pointer; flex-shrink: 0;">
                                <span style="font-size: 13.5px; line-height: 1.4; <?= $is_main ? 'font-weight: 700; color: #0f172a !important;' : 'font-weight: 600; color: #334155 !important;' ?>">
                                    <?= htmlspecialchars($item['name']) ?>
                                </span>
                            </label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<script>
    // Toggle single category accordion (collapse / expand)
    function toggle_category_accordion(header) {
        var $panel = $(header).closest('.panel');
        var $body = $panel.find('.acl-category-body');
        var $chevron = $(header).find('.acl-chevron');

        $body.slideToggle(200, function(){
            if ($body.is(':visible')) {
                $chevron.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            } else {
                $chevron.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            }
        });
    }

    // Toggle all accordions expanded / collapsed
    var allAccordionsExpanded = true;
    function toggle_all_accordions() {
        allAccordionsExpanded = !allAccordionsExpanded;
        if (allAccordionsExpanded) {
            $('.acl-category-body').slideDown(200);
            $('.acl-chevron').removeClass('fa-chevron-right').addClass('fa-chevron-down');
            $('#btn-toggle-accordions').html('<i class="fa fa-compress"></i> Collapse All');
        } else {
            $('.acl-category-body').slideUp(200);
            $('.acl-chevron').removeClass('fa-chevron-down').addClass('fa-chevron-right');
            $('#btn-toggle-accordions').html('<i class="fa fa-expand"></i> Expand All');
        }
    }

    // Live update permission via AJAX
    function check_level_status(id, user_id, is_checked, inputElem){
        $.ajax({
            type: "POST",
            url: "<?php echo base_url('setting_con/check_level') ?>",
            data: { id: id, user_id: user_id, status: is_checked ? 1 : 0 },
            success: function(data){
                update_live_counters();
                show_acl_toast('Permission ' + (is_checked ? 'Granted' : 'Revoked') + ' successfully');
            },
            error: function(){
                alert("Error updating permission!");
                if (inputElem) inputElem.checked = !is_checked;
            }
        });
    }

    // Toggle all items in a single category
    function toggle_single_category(btn, user_id) {
        var $panel = $(btn).closest('.panel');
        var $checkboxes = $panel.find('.acl-perm-checkbox');
        var allChecked = true;
        $checkboxes.each(function(){
            if (!this.checked) allChecked = false;
        });

        var newStatus = !allChecked;
        $checkboxes.each(function(){
            if (this.checked !== newStatus) {
                this.checked = newStatus;
                var aclId = $(this).data('id');
                check_level_status(aclId, user_id, newStatus, this);
            }
        });
    }

    // Toggle all permissions across all categories
    function toggle_all_permissions(status, user_id) {
        var $checkboxes = $('.acl-perm-checkbox');
        $checkboxes.each(function(){
            if (this.checked !== status) {
                this.checked = status;
                var aclId = $(this).data('id');
                check_level_status(aclId, user_id, status, this);
            }
        });
    }

    // Update count badges
    function update_live_counters() {
        var totalActive = 0;
        $('.acl-category-box').each(function(){
            var $box = $(this);
            var checkedInCat = $box.find('.acl-perm-checkbox:checked').length;
            $box.find('.cat-checked-count').text(checkedInCat);
            totalActive += checkedInCat;
        });
        $('#active-count').text(totalActive);
    }

    // Quick filter across items
    function filter_acl_items(val) {
        val = val.toLowerCase().trim();
        if (val === '') {
            $('.acl-item-row').show();
            $('.acl-category-box').show();
            return;
        }

        $('.acl-category-box').each(function(){
            var $box = $(this);
            var matchedInBox = 0;
            $box.find('.acl-item-row').each(function(){
                var name = $(this).data('name') || '';
                if (name.indexOf(val) !== -1) {
                    $(this).show();
                    matchedInBox++;
                } else {
                    $(this).hide();
                }
            });

            if (matchedInBox > 0) {
                $box.show();
                // Automatically expand category if hidden
                var $body = $box.find('.acl-category-body');
                if (!$body.is(':visible')) {
                    $body.slideDown(150);
                    $box.find('.acl-chevron').removeClass('fa-chevron-right').addClass('fa-chevron-down');
                }
            } else {
                $box.hide();
            }
        });
    }

    // Floating toast notification
    function show_acl_toast(msg) {
        var $toast = $('#acl-toast-popup');
        if ($toast.length === 0) {
            $toast = $('<div id="acl-toast-popup" style="position: fixed; bottom: 25px; right: 25px; background: #2c3e50; color: #fff; padding: 10px 18px; border-radius: 6px; box-shadow: 0 4px 15px rgba(0,0,0,0.25); z-index: 99999; display: none; font-size: 13px; font-weight: 500;"><i class="fa fa-check-circle" style="color: #2ecc71; margin-right: 6px;"></i><span></span></div>');
            $('body').append($toast);
        }
        $toast.find('span').text(msg);
        $toast.stop(true, true).fadeIn(150).delay(1200).fadeOut(350);
    }
</script>