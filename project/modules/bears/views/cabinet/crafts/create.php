<?php
$this->title = \Yii::t('app', 'Добавить');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Каталог'), 'url' => ['cabinet/crafts/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('forms/_form', [
            'model' => $model,
        ]) ?>
