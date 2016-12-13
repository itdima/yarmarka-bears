<?php
use  \yii\widgets\Breadcrumbs;
use yii\helpers\Url;

$this->beginContent('@app/modules/bears/views/layouts/main.php'); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $this->render('/cabinet/_menu'); ?>
        </div>
        <div class="col-sm-9">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                'homeLink' => [
                    'label' => \Yii::t('app', 'Главная'),
                    'url' => Url::toRoute('cabinet/info/index')
                ]

            ]) ?>
            <?=$content?>

        </div>
    </div>

<?php $this->endContent(); ?>

