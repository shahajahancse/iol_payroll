<div class="content">
    <div class="col-md-10 col-md-offset-1">
        <div class="row tablebox" style="display: block; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-weight: 600; margin: 0;">ADMS Devices (SenseFace 4A Push Server)</h3>
                <span class="label label-success" style="font-size: 14px; padding: 6px 12px; background-color: #28a745; color: #ffffff; border-radius: 4px; display: inline-block;">Push Server Active</span>
            </div>

            <div class="alert alert-info">
                <strong><i class="fa fa-info-circle"></i> Device Setup Instructions for SenseFace 4A / ZKTeco Devices:</strong><br>
                1. Go to Device <strong>Menu</strong> &gt; <strong>Comm. (Communication)</strong> &gt; <strong>Cloud Server Setup / ADMS</strong>.<br>
                2. Set <strong>Server Address</strong>: <code>iol.hrsheba.com</code> (or server IP / localhost)<br>
                3. Set <strong>Server Port</strong>: <code>80</code> (or <code>443</code> for HTTPS)<br>
                4. Set <strong>Enable Domain Name</strong>: <code>ON / Yes</code><br>
                5. Device Push Path: Default <code>/iclock/</code> or <code>/</code>
            </div>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr style="background: #0177bc; color: white;">
                        <th>#</th>
                        <th>Device SN (Serial Number)</th>
                        <th>Device Model</th>
                        <th>IP Address</th>
                        <th>Total Punches Uploaded</th>
                        <th>Last Activity / Heartbeat</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($devices)) {
                        foreach ($devices as $key => $dev) {
                            $is_online = (strtotime($dev->last_activity) >= strtotime('-5 minutes'));
                    ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td><strong><?= $dev->sn ?></strong></td>
                                <td><?= $dev->device_name ?></td>
                                <td><?= $dev->ip_address ?></td>
                                <td><span class="badge badge-info" style="font-size:14px; background:#007bff; color:#ffffff; padding:4px 8px; border-radius:10px;"><?= $dev->total_records ?></span></td>
                                <td><?= date('d-M-Y h:i:s A', strtotime($dev->last_activity)) ?></td>
                                <td>
                                    <?php if ($is_online) { ?>
                                        <span class="label label-success" style="padding: 4px 10px; background-color: #28a745; color: #ffffff; border-radius: 4px; font-weight: 600; display: inline-block;">Online</span>
                                    <?php } else { ?>
                                        <span class="label label-danger" style="padding: 4px 10px; background-color: #dc3545; color: #ffffff; border-radius: 4px; font-weight: 600; display: inline-block;">Offline</span>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted" style="padding: 30px;">
                                <em>No ADMS devices connected yet. Configure your SenseFace 4A device to push data to <code>http://iol.hrsheba.com/iclock/cdata</code></em>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div style="margin-top: 30px; border-top: 2px solid #e9ecef; padding-top: 20px;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                    <h4 style="font-weight: 600; margin: 0;"><i class="fa fa-terminal"></i> Live ADMS Request & Punch Log Debugger</h4>
                    <div>
                        <a href="<?= site_url('iclock/device_list') ?>" class="btn btn-sm btn-primary" style="margin-right: 5px;"><i class="fa fa-refresh"></i> Refresh Log</a>
                        <a href="<?= site_url('iclock/view_log?action=clear') ?>" class="btn btn-sm btn-danger" onclick="return confirm('Clear debug log?');" style="margin-right: 5px;"><i class="fa fa-trash"></i> Clear Log</a>
                        <a href="<?= site_url('iclock/view_log') ?>" target="_blank" class="btn btn-sm btn-default"><i class="fa fa-external-link"></i> Raw File</a>
                    </div>
                </div>
                <p class="text-muted" style="font-size: 13px;">
                    This log captures every HTTP GET/POST request sent by your SenseFace 4A device to <code>/iclock/cdata</code>. Use this to inspect exact payload formats when punches are made.
                </p>
                <div style="background: #1e1e1e; color: #00ff66; padding: 15px; border-radius: 6px; font-family: monospace; font-size: 12px; max-height: 400px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;">
                    <?= !empty($log_content) ? htmlspecialchars($log_content) : 'No incoming ADMS device requests logged yet. Perform a punch on the device or wait for next heartbeat interval.' ?>
                </div>
            </div>
        </div>
    </div>
</div>
