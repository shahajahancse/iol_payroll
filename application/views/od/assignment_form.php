<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$is_edit = isset($od) && !empty($od);
$od_id   = $is_edit ? $od->id : 0;
$sel_emp_id = $is_edit ? $od->emp_id : '';
$current_dates = ($is_edit && !empty($od->dates_list)) ? $od->dates_list : array();
$mode = ($is_edit && !empty($od->assignment_mode)) ? $od->assignment_mode : 'range';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ========================================================================= */
/* OUTSIDE DUTY (OD) FORM - EXECUTIVE THEME                                  */
/* ========================================================================= */
.page-content .content.od-form-wrapper {
    padding-top: 85px !important;
    padding-left: 20px !important;
    padding-right: 20px !important;
    padding-bottom: 50px !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #1e293b;
    background-color: transparent;
    min-height: calc(100vh - 100px);
}

.od-header-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 20px 24px;
    margin-bottom: 22px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.od-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}
.od-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    flex-shrink: 0;
}
.od-header-text h2 {
    margin: 0 0 4px 0;
    font-size: 20px;
    font-weight: 700;
    color: #0f172a;
    letter-spacing: -0.3px;
}
.od-header-text p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}
.btn-action-outline {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 7px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    transition: all 0.2s;
}
.btn-action-outline:hover {
    background: #f1f5f9;
    color: #0f172a;
    text-decoration: none;
}

/* Card & Sections */
.form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    box-shadow: 0 4px 18px -2px rgba(15, 23, 42, 0.04);
    margin-bottom: 22px;
    overflow: hidden;
}
.form-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f1f5f9;
    background: #ffffff;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.form-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 9px;
    margin: 0;
}
.form-card-title i {
    color: #0284c7;
    font-size: 16px;
}
.form-card-body {
    padding: 22px;
}

/* Form Controls */
.form-group {
    margin-bottom: 18px;
}
.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    margin-bottom: 6px;
    display: block;
}
.form-label .required {
    color: #ef4444;
    margin-left: 2px;
}
.form-control-custom {
    width: 100%;
    height: 38px;
    padding: 7px 12px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    color: #1e293b;
    background: #ffffff;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
    box-shadow: none;
    box-sizing: border-box;
}
.form-control-custom:focus {
    border-color: #0284c7;
    box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
}
input[type="date"].form-control-custom,
input[type="time"].form-control-custom {
    height: 38px;
    min-height: 38px;
    line-height: 22px;
}
textarea.form-control-custom {
    height: auto;
    min-height: 80px;
    resize: vertical;
}
.form-hint {
    font-size: 11px;
    color: #64748b;
    margin-top: 4px;
    display: block;
}

/* Employee Profile Badge */
.emp-preview-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 18px;
    display: flex;
    align-items: center;
    gap: 18px;
    margin-top: 10px;
    transition: all 0.2s;
}
.emp-avatar {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    font-weight: 700;
    flex-shrink: 0;
    box-shadow: 0 4px 10px rgba(59, 130, 246, 0.25);
}
.emp-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 10px 16px;
    width: 100%;
}
.emp-meta-item .meta-lbl {
    font-size: 11px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}
.emp-meta-item .meta-val {
    font-size: 13px;
    color: #0f172a;
    font-weight: 600;
}

/* Mode Switcher Buttons */
.mode-toggle-group {
    display: inline-flex;
    background: #f1f5f9;
    border-radius: 10px;
    padding: 4px;
    border: 1px solid #e2e8f0;
    margin-bottom: 16px;
}
.mode-btn {
    border: none;
    background: transparent;
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.mode-btn.active {
    background: #0284c7;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);
}
.step-badge {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Date Tags Container */
.dates-tags-wrapper {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;
    padding: 12px 14px;
    min-height: 52px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
    margin-top: 10px;
}
.date-tag {
    background: #e0f2fe;
    color: #0369a1;
    border: 1px solid #bae6fd;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.date-tag .remove-date {
    cursor: pointer;
    color: #0284c7;
    font-weight: bold;
    font-size: 14px;
}
.date-tag .remove-date:hover {
    color: #ef4444;
}

/* Conflict Alert Box */
.conflict-alert {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
    border-radius: 10px;
    padding: 12px 16px;
    margin-top: 12px;
    display: none;
    font-size: 13px;
}
.conflict-alert strong {
    font-weight: 700;
}

/* Search Dropdown Results */
.emp-search-results {
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    background: #ffffff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    z-index: 1050;
    max-height: 280px;
    overflow-y: auto;
    display: none;
}
.emp-search-item {
    padding: 10px 14px;
    border-bottom: 1px solid #f1f5f9;
    cursor: pointer;
    transition: background 0.15s;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.emp-search-item:hover {
    background: #f0fdf4;
}
.emp-search-item:last-child {
    border-bottom: none;
}
.search-name {
    font-weight: 600;
    color: #0f172a;
    font-size: 13px;
}
.search-sub {
    font-size: 11px;
    color: #64748b;
}

/* Submit Footer */
.form-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 12px;
    padding: 16px 22px;
    background: #f8fafc;
    border-top: 1px solid #e2e8f0;
    border-radius: 0 0 14px 14px;
}
.btn-submit {
    background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
    color: #ffffff;
    border: none;
    padding: 10px 24px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 12px rgba(2, 132, 199, 0.25);
    transition: all 0.2s;
}
.btn-submit:hover {
    box-shadow: 0 6px 16px rgba(2, 132, 199, 0.35);
    transform: translateY(-1px);
}
.btn-cancel {
    background: #ffffff;
    border: 1px solid #cbd5e1;
    color: #475569;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-cancel:hover {
    background: #f1f5f9;
    color: #0f172a;
}
</style>

<div class="content od-form-wrapper">

        <!-- Top Header Card -->
        <div class="od-header-card">
            <div class="od-header-left">
                <div class="od-header-icon">
                    <i class="fa fa-map-marker"></i>
                </div>
                <div class="od-header-text">
                    <h2><?= $is_edit ? 'Edit Outside Duty (OD) Assignment #' . $od_id : 'Create Outside Duty (OD) Assignment' ?></h2>
                    <p>Assign official off-premises duty dates for employees with automatic attendance status integration</p>
                </div>
            </div>
            <div>
                <a href="<?= base_url('od_management_con/list') ?>" class="btn-action-outline">
                    <i class="fa fa-arrow-left"></i> Back to OD List
                </a>
            </div>
        </div>

        <form id="odAssignmentForm" autocomplete="off">
            <input type="hidden" name="od_id" id="od_id" value="<?= $od_id ?>">
            <input type="hidden" name="emp_id" id="emp_id" value="<?= htmlspecialchars($sel_emp_id) ?>">
            <input type="hidden" name="assignment_mode" id="assignment_mode" value="<?= htmlspecialchars($mode) ?>">

            <!-- 1. Employee Selection Section -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">
                        <i class="fa fa-user"></i> 1. Select Employee
                    </h3>
                    <span class="step-badge">Step 1</span>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <!-- Filters for quick narrow down -->
                        <?php if (empty($unit_id) || $unit_id === 'All'): ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Branch / Unit</label>
                                <select class="form-control-custom" id="filter_unit">
                                    <option value="">-- All Units --</option>
                                    <?php if (!empty($units)): foreach ($units as $u): ?>
                                        <option value="<?= $u->unit_id ?>" <?= (isset($employee) && $employee->unit_id == $u->unit_id) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($u->unit_name) ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Department</label>
                                <select class="form-control-custom" id="filter_dept">
                                    <option value="">-- All Departments --</option>
                                    <?php if (!empty($departments)): foreach ($departments as $d): ?>
                                        <option value="<?= $d->dept_id ?>"><?= htmlspecialchars($d->dept_name) ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Designation</label>
                                <select class="form-control-custom" id="filter_desig">
                                    <option value="">-- All Designations --</option>
                                    <?php if (!empty($designations)): foreach ($designations as $ds): ?>
                                        <option value="<?= $ds->desig_id ?>"><?= htmlspecialchars($ds->desig_name) ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Live Search Bar -->
                        <div class="col-md-<?= (empty($unit_id) || $unit_id === 'All') ? '3' : '6' ?>">
                            <div class="form-group" style="position:relative;">
                                <label class="form-label">Search Employee ID or Name <span class="required">*</span></label>
                                <div style="display:flex; gap:6px;">
                                    <input type="text" class="form-control-custom" id="emp_search_input" 
                                           placeholder="Type ID or Name (e.g. 2001 or Rahim)..."
                                           value="<?= isset($employee) ? htmlspecialchars($employee->emp_id . ' - ' . $employee->name_en) : '' ?>"
                                           <?= $is_edit ? 'readonly' : '' ?>>
                                    <?php if (!$is_edit): ?>
                                    <button type="button" id="btn_search_emp" style="height:38px; min-width:42px; border-radius:8px; border:1px solid #cbd5e1; background:#f8fafc; color:#475569; display:inline-flex; align-items:center; justify-content:center; cursor:pointer;" title="Search Employee">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <?php endif; ?>
                                </div>
                                <div class="emp-search-results" id="emp_search_dropdown"></div>
                                <span class="form-hint">Type at least 2 characters to trigger live search</span>
                            </div>
                        </div>
                    </div>

                    <!-- Selected Employee Profile Preview Box -->
                    <div id="emp_preview_container" style="<?= empty($employee) ? 'display:none;' : '' ?>">
                        <div class="emp-preview-card">
                            <div class="emp-avatar" id="prev_avatar">
                                <?= isset($employee) ? strtoupper(substr($employee->name_en, 0, 2)) : 'EMP' ?>
                            </div>
                            <div class="emp-meta-grid">
                                <div class="emp-meta-item">
                                    <div class="meta-lbl">Employee ID</div>
                                    <div class="meta-val" id="prev_emp_id"><?= isset($employee) ? htmlspecialchars($employee->emp_id) : '-' ?></div>
                                </div>
                                <div class="emp-meta-item">
                                    <div class="meta-lbl">Full Name</div>
                                    <div class="meta-val" id="prev_emp_name"><?= isset($employee) ? htmlspecialchars($employee->name_en) : '-' ?></div>
                                </div>
                                <div class="emp-meta-item">
                                    <div class="meta-lbl">Designation</div>
                                    <div class="meta-val" id="prev_emp_desig"><?= isset($employee) ? htmlspecialchars($employee->desig_name) : '-' ?></div>
                                </div>
                                <div class="emp-meta-item">
                                    <div class="meta-lbl">Department</div>
                                    <div class="meta-val" id="prev_emp_dept"><?= isset($employee) ? htmlspecialchars($employee->dept_name) : '-' ?></div>
                                </div>
                                <div class="emp-meta-item">
                                    <div class="meta-lbl">Branch / Unit</div>
                                    <div class="meta-val" id="prev_emp_unit"><?= isset($employee) ? htmlspecialchars($employee->unit_name) : '-' ?></div>
                                </div>
                                <div class="emp-meta-item">
                                    <div class="meta-lbl">Mobile No</div>
                                    <div class="meta-val" id="prev_emp_phone"><?= isset($employee) ? htmlspecialchars($employee->personal_mobile ?: '-') : '-' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 2. OD Dates Configuration Section -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">
                        <i class="fa fa-calendar-check-o"></i> 2. Outside Duty Dates & Schedule
                    </h3>
                    <span class="step-badge">Step 2</span>
                </div>
                <div class="form-card-body">
                    
                    <!-- Mode Switcher -->
                    <div>
                        <label class="form-label" style="margin-bottom:8px;">Assignment Mode</label>
                        <div class="mode-toggle-group">
                            <button type="button" class="mode-btn <?= ($mode === 'range') ? 'active' : '' ?>" id="btn_mode_range" onclick="switchMode('range')">
                                <i class="fa fa-arrows-h"></i> Continuous Date Range
                            </button>
                            <button type="button" class="mode-btn <?= ($mode === 'individual') ? 'active' : '' ?>" id="btn_mode_individual" onclick="switchMode('individual')">
                                <i class="fa fa-calendar-plus-o"></i> Specific Individual Dates
                            </button>
                        </div>
                    </div>

                    <!-- Range Inputs -->
                    <div id="section_range" style="<?= ($mode === 'range') ? '' : 'display:none;' ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">OD Start Date <span class="required">*</span></label>
                                    <input type="date" class="form-control-custom" name="start_date" id="start_date" 
                                           value="<?= ($is_edit && !empty($od->start_date)) ? $od->start_date : date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">OD End Date <span class="required">*</span></label>
                                    <input type="date" class="form-control-custom" name="end_date" id="end_date"
                                           value="<?= ($is_edit && !empty($od->end_date)) ? $od->end_date : date('Y-m-d') ?>">
                                    <span class="form-hint">For a single day OD, keep Start Date and End Date identical.</span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Total OD Days</label>
                                    <input type="text" class="form-control-custom" id="range_days_count" readonly 
                                           value="<?= ($is_edit && !empty($od->total_days)) ? $od->total_days . ' Day(s)' : '1 Day(s)' ?>" 
                                           style="background:#f1f5f9; font-weight:700; color:#0284c7;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Individual Multiple Dates Inputs -->
                    <div id="section_individual" style="<?= ($mode === 'individual') ? '' : 'display:none;' ?>">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="form-label">Pick a Date to Add</label>
                                    <div style="display:flex; gap:8px;">
                                        <input type="date" class="form-control-custom" id="single_date_picker" value="<?= date('Y-m-d') ?>">
                                        <button type="button" class="btn btn-info" id="btn_add_date" style="border-radius:8px; font-weight:600; padding:8px 16px;">
                                            <i class="fa fa-plus"></i> Add Date
                                        </button>
                                    </div>
                                    <span class="form-hint">Add individual non-consecutive dates (e.g. 25 Oct and 28 Oct). Intervening dates won't be marked as OD.</span>
                                </div>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label">Selected OD Dates (<span id="custom_dates_count"><?= count($current_dates) ?></span> dates)</label>
                                <div class="dates-tags-wrapper" id="dates_tags_container">
                                    <?php if (!empty($current_dates)): foreach ($current_dates as $cd): ?>
                                        <span class="date-tag" data-date="<?= $cd ?>">
                                            <i class="fa fa-calendar-o"></i> <?= date('d M Y', strtotime($cd)) ?>
                                            <span class="remove-date" onclick="removeDateTag('<?= $cd ?>')">&times;</span>
                                        </span>
                                    <?php endforeach; else: ?>
                                        <span class="text-muted" id="no_dates_msg" style="font-size:12px;">No dates added yet. Pick a date above and click "Add Date".</span>
                                    <?php endif; ?>
                                </div>
                                <input type="hidden" name="custom_dates" id="custom_dates_input" value="<?= implode(',', $current_dates) ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Conflict alert -->
                    <div class="conflict-alert" id="conflict_alert_box">
                        <i class="fa fa-exclamation-triangle"></i> <strong>Schedule Warning:</strong>
                        <span id="conflict_message_text"></span>
                    </div>

                </div>
            </div>

            <!-- 3. Assignment Details Section -->
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="form-card-title">
                        <i class="fa fa-briefcase"></i> 3. Duty Assignment Details
                    </h3>
                    <span class="step-badge">Step 3</span>
                </div>
                <div class="form-card-body">
                    <div class="row">
                        <!-- Purpose -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">OD Type / Purpose <span class="required">*</span></label>
                                <select class="form-control-custom" name="purpose" id="purpose" required>
                                    <option value="">-- Select Purpose --</option>
                                    <?php if (!empty($od_purposes)): foreach ($od_purposes as $pval => $plbl): ?>
                                        <option value="<?= htmlspecialchars($pval) ?>" <?= ($is_edit && $od->purpose === $pval) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($plbl) ?>
                                        </option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div>

                        <!-- Outside Duty Location -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Outside Duty Location <span class="required">*</span></label>
                                <input type="text" class="form-control-custom" name="location" id="location" required
                                       placeholder="e.g. Bangladesh Bank, Motijheel / Chattogram Factory / Customer Site"
                                       value="<?= $is_edit ? htmlspecialchars($od->location) : '' ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Work Description -->
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Official Work Description / Responsibilities <span class="required">*</span></label>
                                <textarea class="form-control-custom" name="work_description" id="work_description" rows="3" required
                                          placeholder="Detail the official business activities, tasks, and meetings to be executed outside the office..."><?= $is_edit ? htmlspecialchars($od->work_description) : '' ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Expected Departure Time -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Expected Departure Time (Optional)</label>
                                <input type="time" class="form-control-custom" name="departure_time" id="departure_time"
                                       value="<?= ($is_edit && !empty($od->departure_time)) ? substr($od->departure_time, 0, 5) : '' ?>">
                            </div>
                        </div>

                        <!-- Expected Return Time -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="form-label">Expected Return Time (Optional)</label>
                                <input type="time" class="form-control-custom" name="return_time" id="return_time"
                                       value="<?= ($is_edit && !empty($od->return_time)) ? substr($od->return_time, 0, 5) : '' ?>">
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Remarks / Special Notes</label>
                                <input type="text" class="form-control-custom" name="remarks" id="remarks"
                                       placeholder="Any additional notes or instructions"
                                       value="<?= $is_edit ? htmlspecialchars($od->remarks) : '' ?>">
                            </div>
                        </div>
                    </div>

                    <?php if ($is_admin): ?>
                    <div class="row" style="margin-top:10px;">
                        <div class="col-md-6">
                            <div class="form-group" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:12px 16px;">
                                <label class="form-label" style="margin-bottom:6px;">Approval Action</label>
                                <div style="display:flex; gap:20px; align-items:center;">
                                    <label style="font-weight:600; cursor:pointer; font-size:13px; color:#1e293b;">
                                        <input type="radio" name="status" value="approved" <?= (!$is_edit || $od->status === 'approved') ? 'checked' : '' ?>>
                                        <span style="color:#059669;"><i class="fa fa-check-circle"></i> Approve Immediately</span>
                                    </label>
                                    <label style="font-weight:600; cursor:pointer; font-size:13px; color:#1e293b;">
                                        <input type="radio" name="status" value="pending" <?= ($is_edit && $od->status === 'pending') ? 'checked' : '' ?>>
                                        <span style="color:#d97706;"><i class="fa fa-clock-o"></i> Submit as Pending</span>
                                    </label>
                                </div>
                                <span class="form-hint">Approved assignments automatically mark attendance as "OD" without affecting punch records.</span>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <input type="hidden" name="status" value="pending">
                    <?php endif; ?>

                </div>

                <!-- Form Submit Footer -->
                <div class="form-footer">
                    <a href="<?= base_url('od_management_con/list') ?>" class="btn-cancel">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                    <button type="submit" class="btn-submit" id="btn_submit_od">
                        <i class="fa fa-save"></i> <?= $is_edit ? 'Update OD Assignment' : 'Save & Assign Outside Duty' ?>
                    </button>
                </div>
            </div>

        </form>

    </div>

<script>
var selectedDates = <?= !empty($current_dates) ? json_encode(array_values($current_dates)) : '[]' ?>;

function switchMode(mode) {
    $('#assignment_mode').val(mode);
    $('.mode-btn').removeClass('active');
    if (mode === 'range') {
        $('#btn_mode_range').addClass('active');
        $('#section_range').slideDown(200);
        $('#section_individual').slideUp(200);
    } else {
        $('#btn_mode_individual').addClass('active');
        $('#section_range').slideUp(200);
        $('#section_individual').slideDown(200);
    }
    triggerConflictCheck();
}

function calculateRangeDays() {
    var s = $('#start_date').val();
    var e = $('#end_date').val();
    if (s && e) {
        var d1 = new Date(s);
        var d2 = new Date(e);
        if (d2 < d1) {
            $('#range_days_count').val('Invalid (End < Start)');
            return;
        }
        var diffTime = Math.abs(d2 - d1);
        var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        $('#range_days_count').val(diffDays + ' Day(s)');
    }
}

function renderDateTags() {
    var html = '';
    selectedDates.sort();
    if (selectedDates.length === 0) {
        html = '<span class="text-muted" id="no_dates_msg" style="font-size:12px;">No dates added yet. Pick a date above and click "Add Date".</span>';
    } else {
        selectedDates.forEach(function(d) {
            var parts = d.split('-');
            var dt = new Date(parts[0], parts[1]-1, parts[2]);
            var formatted = dt.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
            html += '<span class="date-tag" data-date="' + d + '"><i class="fa fa-calendar-o"></i> ' + formatted + 
                    ' <span class="remove-date" onclick="removeDateTag(\'' + d + '\')">&times;</span></span> ';
        });
    }
    $('#dates_tags_container').html(html);
    $('#custom_dates_count').text(selectedDates.length);
    $('#custom_dates_input').val(selectedDates.join(','));
    triggerConflictCheck();
}

function removeDateTag(dateStr) {
    selectedDates = selectedDates.filter(function(d) { return d !== dateStr; });
    renderDateTags();
}

function triggerConflictCheck() {
    var empId = $('#emp_id').val();
    if (!empId) return;

    var mode = $('#assignment_mode').val();
    var dates = [];
    if (mode === 'range') {
        var s = $('#start_date').val();
        var e = $('#end_date').val() || s;
        if (!s) return;
        var cur = new Date(s);
        var last = new Date(e);
        if (last < cur) return;
        while (cur <= last) {
            var y = cur.getFullYear();
            var m = String(cur.getMonth() + 1).padStart(2, '0');
            var d = String(cur.getDate()).padStart(2, '0');
            dates.push(y + '-' + m + '-' + d);
            cur.setDate(cur.getDate() + 1);
        }
    } else {
        dates = selectedDates;
    }

    if (dates.length === 0) {
        $('#conflict_alert_box').hide();
        return;
    }

    $.ajax({
        url: '<?= base_url("od_management_con/check_conflicts_ajax") ?>',
        type: 'POST',
        data: {
            emp_id: empId,
            dates: dates,
            exclude_id: $('#od_id').val()
        },
        dataType: 'json',
        success: function(res) {
            if (res.status === 'success' && res.has_conflict) {
                var msgs = [];
                if (res.conflicts.existing_ods && res.conflicts.existing_ods.length > 0) {
                    res.conflicts.existing_ods.forEach(function(o) {
                        msgs.push('Existing OD on ' + o.date + ' (' + o.status + ')');
                    });
                }
                if (res.conflicts.leaves && res.conflicts.leaves.length > 0) {
                    res.conflicts.leaves.forEach(function(l) {
                        msgs.push('Approved Leave on ' + l.date + ' (' + l.leave_type + ')');
                    });
                }
                $('#conflict_message_text').html(msgs.join('<br>'));
                $('#conflict_alert_box').slideDown(150);
            } else {
                $('#conflict_alert_box').slideUp(150);
            }
        }
    });
}

function selectEmployee(emp) {
    $('#emp_id').val(emp.emp_id);
    $('#emp_search_input').val(emp.emp_id + ' - ' + emp.name_en);
    $('#emp_search_dropdown').hide();

    // Populate profile card
    var initials = emp.name_en ? emp.name_en.substring(0, 2).toUpperCase() : 'EM';
    $('#prev_avatar').text(initials);
    $('#prev_emp_id').text(emp.emp_id);
    $('#prev_emp_name').text(emp.name_en || '-');
    $('#prev_emp_desig').text(emp.desig_name || '-');
    $('#prev_emp_dept').text(emp.dept_name || '-');
    $('#prev_emp_unit').text(emp.unit_name || '-');
    $('#prev_emp_phone').text(emp.personal_mobile || '-');
    $('#emp_preview_container').slideDown(200);

    triggerConflictCheck();
}

$(document).ready(function() {
    calculateRangeDays();

    $('#start_date, #end_date').on('change', function() {
        calculateRangeDays();
        triggerConflictCheck();
    });

    // Add Date to individual list
    $('#btn_add_date').on('click', function() {
        var d = $('#single_date_picker').val();
        if (!d) {
            Swal.fire('Error', 'Please pick a date first.', 'warning');
            return;
        }
        if (selectedDates.indexOf(d) !== -1) {
            Swal.fire('Notice', 'Date ' + d + ' is already added.', 'info');
            return;
        }
        selectedDates.push(d);
        renderDateTags();
    });

    // Live search employee
    var searchTimer = null;
    $('#emp_search_input').on('keyup', function() {
        var term = $(this).val().trim();
        clearTimeout(searchTimer);
        if (term.length < 2) {
            $('#emp_search_dropdown').hide();
            return;
        }

        searchTimer = setTimeout(function() {
            var unitId = $('#filter_unit').length ? $('#filter_unit').val() : '';
            var deptId = $('#filter_dept').val();
            var desigId = $('#filter_desig').val();

            $.ajax({
                url: '<?= base_url("od_management_con/employee_search_ajax") ?>',
                type: 'POST',
                data: {
                    q: term,
                    unit_id: unitId,
                    dept_id: deptId,
                    desig_id: desigId
                },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success' && res.data.length > 0) {
                        var html = '';
                        res.data.forEach(function(emp) {
                            html += '<div class="emp-search-item" onclick=\'selectEmployee(' + JSON.stringify(emp) + ')\'>' +
                                    '<div>' +
                                    '<div class="search-name">' + emp.emp_id + ' - ' + emp.name_en + '</div>' +
                                    '<div class="search-sub">' + (emp.desig_name || '') + ' | ' + (emp.dept_name || '') + '</div>' +
                                    '</div>' +
                                    '<span class="badge" style="background:#e0f2fe; color:#0369a1;">' + (emp.unit_name || '') + '</span>' +
                                    '</div>';
                        });
                        $('#emp_search_dropdown').html(html).show();
                    } else {
                        $('#emp_search_dropdown').html('<div style="padding:10px 14px; color:#64748b; font-size:12px;">No employees found.</div>').show();
                    }
                }
            });
        }, 300);
    });

    $('#btn_search_emp').on('click', function() {
        $('#emp_search_input').trigger('keyup');
    });

    // Hide search dropdown on outside click
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.emp-search-results, #emp_search_input, #btn_search_emp').length) {
            $('#emp_search_dropdown').hide();
        }
    });

    // Form Submit Handler
    $('#odAssignmentForm').on('submit', function(e) {
        e.preventDefault();

        var empId = $('#emp_id').val();
        if (!empId) {
            Swal.fire('Validation Error', 'Please select an employee first.', 'error');
            return false;
        }

        var mode = $('#assignment_mode').val();
        if (mode === 'individual' && selectedDates.length === 0) {
            Swal.fire('Validation Error', 'Please add at least one OD date.', 'error');
            return false;
        }

        var purpose = $('#purpose').val();
        if (!purpose) {
            Swal.fire('Validation Error', 'Please select OD purpose / category.', 'error');
            return false;
        }

        var loc = $('#location').val().trim();
        if (!loc) {
            Swal.fire('Validation Error', 'Please enter outside duty location.', 'error');
            return false;
        }

        var workDesc = $('#work_description').val().trim();
        if (!workDesc) {
            Swal.fire('Validation Error', 'Please enter official work description.', 'error');
            return false;
        }

        var btn = $('#btn_submit_od');
        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

        var formData = $(this).serialize();

        $.ajax({
            url: window.location.href,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save & Assign Outside Duty');
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Success!',
                        text: res.message,
                        icon: 'success',
                        confirmButtonText: 'Go to OD List',
                        showCancelButton: true,
                        cancelButtonText: 'Create Another'
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            window.location.href = '<?= base_url("od_management_con/list") ?>';
                        } else {
                            window.location.href = '<?= base_url("od_management_con/create") ?>';
                        }
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                btn.prop('disabled', false).html('<i class="fa fa-save"></i> Save & Assign Outside Duty');
                Swal.fire('Server Error', 'An unexpected error occurred. Please try again.', 'error');
            }
        });
    });
});
</script>
