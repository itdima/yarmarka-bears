<?php
$this->title = \Yii::t('app', 'Сообщения');
$this->params['breadcrumbs'][] = $this->title;


?>

<div class="contacts">
    <div class="row">
        <div class="col-sm-4">
            <div  style="height:150px; overflow-y: scroll;">
                <?php foreach ($users as $user) { ?>
                    <div class="message well">
                        <img src="<?= $user->getImage()->getUrl('50x50') ?>" alt="Фото" class="img-circle">
                        <?= $user->username ?>
                    </div>
                <?php }; ?>
            </div>
        </div>
        <div class="col-sm-8">
        </div>
    </div>
</div>


<?php
/*
$this->registerJs(new \yii\web\JsExpression("
    $('#contacts').scrollspy({target: '#toscroll'});

"));
*/
?>
