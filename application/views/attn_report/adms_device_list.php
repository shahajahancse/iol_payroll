<div class="content">
    <div class="col-md-10 col-md-offset-1">
        <div class="row tablebox" style="display: block; padding: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="font-weight: 600; margin: 0;">ADMS Devices (SenseFace 4A Push Server)</h3>
                <span class="label label-success" style="font-size: 14px; padding: 6px 12px;">Push Server Active</span>
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
                                <td><span class="badge badge-info" style="font-size:14px; background:#007bff;"><?= $dev->total_records ?></span></td>
                                <td><?= date('d-M-Y h:i:s A', strtotime($dev->last_activity)) ?></td>
                                <td>
                                    <?php if ($is_online) { ?>
                                        <span class="label label-success" style="padding: 4px 8px;">Online</span>
                                    <?php } else { ?>
                                        <span class="label label-default" style="padding: 4px 8px; background: #6c757d; color:white;">Offline</span>
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
        </div>
    </div>
</div>
