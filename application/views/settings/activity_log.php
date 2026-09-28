<div class="content" style="display: flex;flex-direction: column;gap: 10px">

    <div class="row tablebox table-responsive">
      <h3 class="col-md-12">Activity Log</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Member</th>
                    <th>Ip</th>
                    <th>Location</th>
                    <th>Address</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $log): ?>
                <tr>
                    <td><?php echo @$i = $i+1 ?></td>
                    <td><?php echo $log->id_number ?></td>
                    <td><?php echo $log->ip ?></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="<?= 'https://'.$log->location ?>" target="_blank">
                            <i class="fa fa-map-marker"></i> Go
                        </a>
                    </td>
                    <td><?php echo $log->address ?></td>
                    <td><?php echo $log->status==0 ? '<span class="label label-danger">Logged Out</span>' : '<span class="label label-warning">Logged In now</span>' ?></td>
                    <td><?php echo $log->date ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>
</div>