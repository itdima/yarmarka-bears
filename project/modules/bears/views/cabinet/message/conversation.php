
<?php
foreach ($models as $model) {
    ?>
    <div class="row">
        <?php if ($model->sender == $notme) { ?>
            <div class='col-xs-9'>
                <div class='well  notmymessage'>
                    <?= $model->message; ?>
                    <div class='text-right'> <?= date('d.m.y H:i', $model->created_at) ?> </div>
                </div>
            </div>
            <div class='col-xs-3'></div>
        <?php }; ?>
        <?php if ($model->sender == $me) { ?>
            <div class="col-xs-3"></div>
            <div class='col-xs-9'>
                <div class='well mymessage'>
                    <?= $model->message; ?>
                    <div class='text-right'><?= date('d.m.y H:i', $model->created_at); ?></div>
                </div>
            </div>
        <?php }; ?>
    </div>

    <?php
}
?>

