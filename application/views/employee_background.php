<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Background</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }
            .table-wrapper {
                width: 100%;
                /* margin: 0 auto; */
            }
            .table-custom {
                background-color: white;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
                border-radius: 0px;
                /* overflow: hidden; */
                padding: 1rem;
            }
            .table {
                width: 100%;
                border-collapse: collapse;
            }
            .table thead th {
                background-color: #007bff;
                color: white;
                text-align: center;
                font-size: 1rem;
            }
            .table th, .table td {
                vertical-align: middle !important;
                padding: 5px;
            }
            .section-title {
                background-color: #006ba3 !important;
                color: white;
                text-align: center;
                padding: 5px;
                font-size: 16px;
                font-weight: bold;
            }
            /* .container {
                margin-top: 40px;
                margin-bottom: 40px;
            } */

            /* PRINT STYLES */
            @media print {
                body {
                    margin: 0;
                    padding: 0;
                }
                @page {
                    margin: 0;
                    padding: 0;
                    size: A4 portrait;
                }

                .table-wrapper {
                    width: 100% !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
                .table-custom {
                    padding: 0 !important;
                    box-shadow: none !important;
                }
                .table {
                    width: 100% !important;
                    table-layout: fixed !important;
                }
                .table th, .table td {
                    word-wrap: break-word;
                    font-size: 12px; /* You can adjust */
                }
                .section-title {
                    background-color: #006ba3 !important;
                    color: white !important;
                }
            }
        </style>

</head>
<body>
    <br>
    <?php $this->load->view('head_english');?>
    <h4 class="col-md-12 text-center" style="margin-bottom:0px">Employee Background</h4>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-custom">
                <!-- Personal Information Section -->
                <div class="section-title">Personal Information</div>
                <table class="table table-bordered" style="margin-bottom:0px">
                    <tbody>
                        <tr>
                            <th style="width:25%">Employee Name</th>
                            <td style="width:25%;white-space:nowrap"><?= $values->name_en ?></td>
                            <th style="width:25%" colspan="2" rowspan="3">
                                <div style="display: flex; align-items: center; justify-content: center;">
                                    <img src="<?= base_url('uploads/photo/' . $values->img_source) ?>" width="100px" height="100px">
                                </div>
                            </th>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <td><?= $values->father_name ?></td>
                        </tr>
                        <tr>
                            <th>Mother's Name</th>
                            <td><?= $values->mother_name ?></td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td><?= date('d-m-Y', strtotime($values->emp_dob)) ?></td>
                            <th>Gender</th>
                            <td><?= $values->gender ?></td>
                        </tr>
                        <tr>
                            <th>Present Address</th>
                            <td><?= $values->pre_village . ', ' . $values->pre_post_name_en . ', ' . $values->pre_upa_name_en . ', ' . $values->pre_dis_name_en ?></td>
                            <th>Permanent Address</th>
                            <td><?= $values->per_village . ', ' . $values->per_post_name_en . ', ' . $values->per_upa_name_en . ', ' . $values->per_dis_name_en ?></td>
                        </tr>
                        <tr>
                            <th>Marital Status</th>
                            <td><?= $values->marital_status ?></td>
                            <th>Spouse Name</th>
                            <td><?= $values->spouse_name ?? '-' ?></td>
                        </tr>
                        <tr>
                            <th>Male Child</th>
                            <td><?= $values->m_child ?? '-' ?></td>
                            <th>Female Child</th>
                            <td><?= $values->f_child ?? '-' ?></td>
                        </tr>
                        <tr>
                            <th>Blood Group</th>
                            <td><?= $values->blood ?></td>
                            <th>Religion</th>
                            <td><?= $values->religion ?></td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td><?= $values->personal_mobile ?></td>
                            <th>NID/Birth Certificate</th>
                            <td><?= $values->nid_dob_id ?></td>
                        </tr>
                        <tr>
                            <th>Education</th>
                            <td><?= $values->education ?></td>
                            <th>Height</th>
                            <td><?= $values->hight . ' cm' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-custom">
                    
                <!-- Official Information Section -->
                <div class="section-title">Official Information</div>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Employee ID</th>
                            <td><?= $values->emp_id ?></td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td><?= $values->dept_name ?></td>
                            <th>Section</th>
                            <td><?= $values->sec_name_en ?></td>
                        </tr>
                        <tr>
                            <th>Line</th>
                            <td><?= $values->line_name_en ?></td>
                            <th>Designation</th>
                            <td><?= $values->desig_name ?></td>
                        </tr>
                        <tr>
                            <th>Employee Status</th>
                            <td><?= $values->emp_cat_id == 1 ? 'Regular' : ($values->emp_cat_id == 2 ? 'Left' : ($values->emp_cat_id == 3 ? 'Resign' : ($values->emp_cat_id == 4 ? 'New' : '-'))) ?></td>
                            <th>Shift</th>
                            <td><?= $values->shift_name ?></td>
                        </tr>
                        <tr>
                            <th>Joining Date</th>
                            <td><?= date('d-m-Y', strtotime($values->emp_join_date)) ?></td>
                            <th>Salary Grade</th>
                            <td><?= $values->gr_name ?></td>
                        </tr>
                        <tr>
                            <th>Salary Type</th>
                            <td><?= $values->salary_type == 1 ? 'Fixed' : 'Production' ?></td>
                            <th>Current Salary</th>
                            <td><?= $values->gross_sal ?></td>
                        </tr>

                        <!-- Job Duration and Left/Resign Date -->
                        <tr>
                            <th>Job Duration</th>
                            <td>
                                <?php
                                $join_date = new DateTime($values->emp_join_date);

                                $this->db->select('left_date')->from('pr_emp_left_history')->where('emp_id', $values->emp_id);
                                $left_data = $this->db->get()->row();

                                $this->db->select('resign_date')->from('pr_emp_resign_history')->where('emp_id', $values->emp_id);
                                $resign_data = $this->db->get()->row();

                                if ($values->emp_cat_id == 2 && $left_data) {
                                    $current_date = new DateTime($left_data->left_date);
                                } elseif ($values->emp_cat_id == 3 && $resign_data) {
                                    $current_date = new DateTime($resign_data->resign_date);
                                } else {
                                    $current_date = new DateTime(date('Y-m-d'));
                                }

                                $interval = $current_date->diff($join_date);
                                echo $interval->y . ' Years, ' . $interval->m . ' Months, ' . $interval->d . ' Days';
                                ?>
                            </td>
                                <?php 
                                    if ($values->emp_cat_id == 2 && $left_data) {
                                        echo "<th>Left Date</th><td>" . date('d-m-Y', strtotime($left_data->left_date)) . "</td>";
                                    } elseif ($values->emp_cat_id == 3 && $resign_data) {
                                        echo "<th>Resign Date</th><td>" . date('d-m-Y', strtotime($resign_data->resign_date)) . "</td>";
                                    }
                                ?>
                        </tr>

                        <!-- Attendance Summary -->
                        <?php
                            $emp_info = $this->db->select('
                                SUM(CASE WHEN present_status = "P" THEN 1 ELSE 0 END) as total_present,
                                SUM(CASE WHEN present_status = "A" THEN 1 ELSE 0 END) as total_absent,
                                SUM(CASE WHEN present_status = "W" THEN 1 ELSE 0 END) as total_weekend,
                                SUM(CASE WHEN present_status = "H" THEN 1 ELSE 0 END) as total_holiday,
                                SUM(CASE WHEN late_status = 1 THEN 1 ELSE 0 END) as total_late,
                                SUM(CASE WHEN present_status = "L" THEN 1 ELSE 0 END) as total_leave
                            ')
                            ->from('pr_emp_shift_log')
                            ->where('emp_id', $values->emp_id)
                            ->get()->row();
                        ?>
                        <tr>
                            <td colspan="2">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Present</th><td><?= $emp_info->total_present ?></td>
                                        <th>Absent</th><td><?= $emp_info->total_absent ?></td>
                                        <th>Weekend</th><td><?= $emp_info->total_weekend ?></td>
                                    </tr>
                                </table>
                            </td>
                            <td colspan="2">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Holiday</th><td><?= $emp_info->total_holiday ?></td>
                                        <th>Late</th><td><?= $emp_info->total_late ?></td>
                                        <th>Leave</th><td><?= $emp_info->total_leave ?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <!-- Increment History -->
                        <tr>
                            <th colspan="4" class="text-center" style='background-color: #006ba3 !important;color:white !important;font-size:16px'>Increment History</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SL. No</th>
                                        <th>Previous Salary</th>
                                        <th>New Salary</th>
                                        <th>Difference</th>
                                        <th>Effective Month</th>
                                    </tr>
                                    <?php
                                    $increment_lists = $this->db->where('prev_emp_id', $values->emp_id)->where('status', 1)->get('pr_incre_prom_pun')->result();
                                    $i = 1;
                                    foreach ($increment_lists as $inc) {
                                        echo "<tr>";
                                        echo "<td>$i</td>";
                                        echo "<td>$inc->prev_salary</td>";
                                        echo "<td>$inc->new_salary</td>";
                                        echo "<td>" . ($inc->new_salary - $inc->prev_salary) . "</td>";
                                        echo "<td>" . date('F Y', strtotime($inc->effective_month)) . "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    if ($i == 1) {
                                        echo "<tr><td colspan='5' class='text-center'>No Data Found</td></tr>";
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>

                        <!-- Promotion History -->
                        <tr>
                            <th colspan="4" class="text-center" style='background-color: #006ba3 !important;color:white !important;font-size:16px'>Promotion History</th>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>SL. No</th>
                                        <th>Previous Department</th>
                                        <th>Previous Section</th>
                                        <th>Previous Line</th>
                                        <th>Previous Designation</th>
                                        <th>Previous Salary</th>
                                        <th>New Department</th>
                                        <th>New Section</th>
                                        <th>New Line</th>
                                        <th>New Designation</th>
                                        <th>New Salary</th>
                                        <th>Difference</th>
                                        <th>Effective Month</th>
                                    </tr>
                                    <?php
                                    $promotion_list = $this->db->where('prev_emp_id', $values->emp_id)->where('status', 2)->get('pr_incre_prom_pun')->result();
                                    $i = 1;
                                    foreach ($promotion_list as $pro) {
                                        echo "<tr>";
                                        echo "<td>$i</td>";
                                        echo "<td>$pro->prev_dept</td>";
                                        echo "<td>$pro->prev_section</td>";
                                        echo "<td>$pro->prev_line</td>";
                                        echo "<td>$pro->prev_desig</td>";
                                        echo "<td>$pro->prev_salary</td>";
                                        echo "<td>$pro->new_dept</td>";
                                        echo "<td>$pro->new_section</td>";
                                        echo "<td>$pro->new_line</td>";
                                        echo "<td>$pro->new_desig</td>";
                                        echo "<td>$pro->new_salary</td>";
                                        echo "<td>" . ($pro->new_salary - $pro->prev_salary) . "</td>";
                                        echo "<td>" . date('F Y', strtotime($pro->effective_month)) . "</td>";
                                        echo "</tr>";
                                        $i++;
                                    }
                                    if ($i == 1) {
                                        echo "<tr><td colspan='13' class='text-center'>No Data Found</td></tr>";
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            </div>
        </div>
    </div>
</body>
</html>
