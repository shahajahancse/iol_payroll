

<div class="col-md-12" style="display: flex;flex-wrap: wrap;">
    <div class=col-md-4 style="display: flex;flex-direction: column;">
        <?php $limit = 20; $offset=$limit; $i=0; foreach($access_list as $key => $value) { 
            if ($offset==$i) {
                echo '</div><div class=col-md-4 style="display: flex;flex-direction: column;">';
                $offset+=$limit;
            }
        ?>
        <div>
            <input type="checkbox" name="" onchange="check_level(<?=$value->id?>,<?=$user_id?>)" <?= in_array($value->id, $level_array) ? 'checked' : ''?>> <span><?php echo $value->acl_name; ?></span>
        </div>
        <?php $i++; } ?>
    </div>
</div>