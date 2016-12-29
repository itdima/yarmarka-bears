<?php
use \kartik\icons\Icon;

?>

<div class="row">
    <div class="col-md-2">

        <div class="row">
            <?= '<img src="' . $model->getImage()->getUrl('') . '" class="img-thumbnail">'; ?>
        </div>
        <div class="row">
            <?= \yii\helpers\Html::button(
                '<i class="fa fa-paper-plane"></i> ' . \Yii::t('app', 'Сообщение'),
                ['class' => 'btn btn-block', 'name' => 'send-message-button']
            ) ?>
        </div>

    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-body">

                <p>

                <h3><?= $model->name ?></h3>
                <?php
                Icon::map($this, Icon::FI);
                echo Icon::show($model->country, null, Icon::FI) . $country
                ?>


                </p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    <a href="<?= $model->vk ?>"><i class="fa fa-vk fa-md" aria-hidden="true"></i></a>
                    <a href="<?= $model->facebook ?>"><i class="fa fa-facebook fa-md" aria-hidden="true"></i></a>
                    <a href="<?= $model->instagram ?>"><i class="fa fa-instagram fa-md" aria-hidden="true"></i></a>
                </p>
                <?= $model->about ?>


            </div>
        </div>

    </div>
</div>
