<?php
$this->title = \Yii::t('app', 'Добавить статью');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Статьи'), 'url' => ['cabinet/blog/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

        <?= $this->render('forms/_form', [
            'model' => $model,
        ]) ?>
