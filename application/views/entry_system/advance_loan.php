<div class="content">

    <nav class="navbar navbar-inverse bg_none">
        <div class="container-fluid nav_head">
            <div class="navbar-header col-md-5">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">
                    <a class="btn btn-info" href="<?php echo base_url('entry_system_con/advance_loan_form') ?>">Add Tax</a>
                </div>
            </div>
            <div class="col-md-7">
                <div id="navbar" class="navbar-collapse collapse">
                    <form class="navbar-form pull-right" role="search">
                        <div class="input-group">
                            <input id="deptSearch" type="text" class="form-control" placeholder="Search">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12">
            <?php
                $success = $this->session->flashdata('success');
                if ($success != "") { ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
            <?php }
                $failuer = $this->session->flashdata('failuer');
                if ($failuer) { ?>
            <div class="alert alert-failuer"><?php echo $failuer; ?></div>
            <?php } ?>
        </div>
    </div>

    <div class="row tablebox">
        <div class="col-md-12">
            <table class="table table-bordered" id="mytable">
                <thead style="font-size: 11px !important;">
                    <tr>
                        <th>SL</th>
                        <th>ID</th>
                        <th>Emp ID</th>
                        <th>Emp Name</th>
                        <th style="width:110px;">Amount</th>
                        <th style="width:110px;">Effect Date</th>
                        <th>Status</th>
                        <th style="width:130px;">Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)) { foreach ($results as $key => $r) { ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td><?php echo $r->id ?></td>
                        <td><?php echo $r->emp_id ?></td>
                        <td style="white-space:nowrap;"><?php echo $r->name_en ?></td>
                        <td><?php echo number_format($r->amount, 2) ?></td>
                        <td><?php echo $r->effect_date ? date('d M Y', strtotime($r->effect_date)) : '' ?></td>
                        <td>
                            <?php if ($r->status == 1) echo '<span class="label label-success" style="background:#28a745 !important;">Active</span>';
                                  else echo '<span class="label label-danger">Inactive</span>'; ?>
                        </td>
                        <td><?php echo $r->created_date ? date('d M Y', strtotime($r->created_date)) : '' ?></td>
                        <td style="white-space:nowrap;">
                            <button type="button" class="btn btn-info btn-view-record"
                                data-id="<?php echo $r->id ?>"
                                title="View Details" style="padding:5px 10px !important">
                                <i class="fa fa-eye" style="color:white !important"></i>
                            </button>
                            <button type="button" class="btn btn-warning btn-edit-record"
                                data-id="<?php echo $r->id ?>"
                                title="Edit Record" style="padding:5px 10px !important">
                                <i class="fa fa-pencil" style="color:white !important"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-delete-record"
                                data-id="<?php echo $r->id ?>"
                                data-name="<?php echo htmlspecialchars($r->name_en) ?>"
                                title="Delete Record" style="padding:5px 10px !important">
                                <i class="fa fa-trash" style="color:white !important"></i>
                            </button>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="9">Records not Found</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</div>

<!-- ===================== VIEW MODAL ===================== -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#0177bc; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"><b>Tax Entry Details</b></h4>
            </div>
            <div class="modal-body" id="view-modal-body">
                <div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- ===================== EDIT MODAL ===================== -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#006ba3; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:white;font-weight:bold"><i class="fa fa-pencil"></i> Edit Tax Entry</h4>
            </div>
            <form id="editForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" id="edit_name_en" class="form-control input-sm" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Employee ID</label>
                                <input type="text" id="edit_emp_id" class="form-control input-sm" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Amount <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" id="edit_amount" name="amount" class="form-control input-sm" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Effect Date <span class="text-danger">*</span></label>
                                <input type="month" id="edit_effect_date" name="effect_date" class="form-control input-sm" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select id="edit_status" name="status" class="form-control input-sm" required>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="btn-save-edit"><i class="fa fa-floppy-o"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===================== DELETE CONFIRM MODAL ===================== -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background:#d9534f; color:#fff;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#fff; opacity:1;">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" style="color:white;font-weight:bold"><i class="fa fa-trash"></i> Confirm Delete</h4>
            </div>
            <div class="modal-body">
                <p>Delete tax record for <strong id="delete-emp-name"></strong>?</p>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
                <input type="hidden" id="delete_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-delete"><i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    var oTable = $('#mytable').DataTable({
        columnDefs: [{ orderable: false, targets: [0, 8] }],
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100]
    });
    $('#mytable_filter').css({"display": "none"});
    $('#deptSearch').keyup(function() {
        oTable.search($(this).val()).draw();
    });

    // ---- VIEW ----
    $(document).on('click', '.btn-view-record', function() {
        var id = $(this).data('id');
        $('#view-modal-body').html('<div class="text-center"><i class="fa fa-spinner fa-spin"></i> Loading...</div>');
        $('#viewModal').modal('show');
        $.ajax({
            url: hostname + 'entry_system_con/advance_loan_get/' + id,
            type: 'GET', dataType: 'json',
            success: function(data) {
                if (data) {
                    var statusBadge = data.status == 1
                        ? '<span class="label label-success" style="background:#28a745 !important;">Active</span>'
                        : '<span class="label label-danger">Inactive</span>';
                    var th = 'style="background:#f5f5f5;width:30%;white-space:nowrap;"';
                    var html = '<table class="table table-bordered table-condensed" style="font-size:13px;">' +
                        '<tr><th ' + th + '>ID</th><td>' + data.id + '</td></tr>' +
                        '<tr><th ' + th + '>Employee ID</th><td>' + (data.emp_id || 'N/A') + '</td></tr>' +
                        '<tr><th ' + th + '>Employee Name</th><td>' + (data.name_en || 'N/A') + '</td></tr>' +
                        '<tr><th ' + th + '>Amount</th><td>' + parseFloat(data.amount || 0).toFixed(2) + '</td></tr>' +
                        '<tr><th ' + th + '>Effect Date</th><td>' + (data.effect_date || 'N/A') + '</td></tr>' +
                        '<tr><th ' + th + '>Status</th><td>' + statusBadge + '</td></tr>' +
                        '<tr><th ' + th + '>Created Date</th><td>' + (data.created_date || 'N/A') + '</td></tr>' +
                        '</table>';
                    $('#view-modal-body').html(html);
                } else {
                    $('#view-modal-body').html('<div class="alert alert-danger">Record not found.</div>');
                }
            },
            error: function() {
                $('#view-modal-body').html('<div class="alert alert-danger">Error loading record.</div>');
            }
        });
    });

    // ---- EDIT ----
    $(document).on('click', '.btn-edit-record', function() {
        var id = $(this).data('id');
        $.ajax({
            url: hostname + 'entry_system_con/advance_loan_get/' + id,
            type: 'GET', dataType: 'json',
            success: function(data) {
                if (data) {
                    $('#edit_id').val(data.id);
                    $('#edit_name_en').val(data.name_en || '');
                    $('#edit_emp_id').val(data.emp_id || '');
                    $('#edit_amount').val(data.amount || '');
                    if (data.effect_date) $('#edit_effect_date').val(data.effect_date.substring(0, 7));
                    $('#edit_status').val(data.status || '1');
                    $('#editModal').modal('show');
                } else { alert('Record not found.'); }
            },
            error: function() { alert('Error loading record.'); }
        });
    });

    // ---- SAVE EDIT ----
    $('#btn-save-edit').click(function() {
        var id          = $('#edit_id').val();
        var amount      = $('#edit_amount').val();
        var effect_date = $('#edit_effect_date').val();
        var status      = $('#edit_status').val();

        if (!amount || !effect_date) { alert('Please fill all required fields.'); return; }

        $.ajax({
            url: hostname + 'entry_system_con/advance_loan_update',
            type: 'POST',
            data: { id: id, amount: amount, effect_date: effect_date, status: status },
            success: function(response) {
                if (response === 'success') {
                    $('#editModal').modal('hide');
                    showMessage('success', 'Record updated successfully.');
                    setTimeout(function() { location.reload(); }, 1500);
                } else { showMessage('error', 'Update failed: ' + response); }
            },
            error: function() { showMessage('error', 'Error updating record.'); }
        });
    });

    // ---- DELETE ----
    $(document).on('click', '.btn-delete-record', function() {
        $('#delete_id').val($(this).data('id'));
        $('#delete-emp-name').text($(this).data('name'));
        $('#deleteModal').modal('show');
    });

    $('#btn-confirm-delete').click(function() {
        var id = $('#delete_id').val();
        $.ajax({
            url: hostname + 'entry_system_con/advance_loan_delete_by_id',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                if (response === 'success') {
                    $('#deleteModal').modal('hide');
                    showMessage('success', 'Record deleted successfully.');
                    setTimeout(function() { location.reload(); }, 1500);
                } else { showMessage('error', 'Delete failed: ' + response); }
            },
            error: function() { showMessage('error', 'Error deleting record.'); }
        });
    });
});
</script>
