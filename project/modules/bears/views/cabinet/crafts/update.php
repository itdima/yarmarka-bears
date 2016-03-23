<?php
$this->title = \Yii::t('app', 'Редактировать');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Работы'), 'url' => ['cabinet/crafts/index']];
$this->params['breadcrumbs'][] = $this->title;
?>


        <?= $this->render('forms/_form', [
            'model' => $model,
        ]) ?>


