<?php
use \yii\helpers\Html;
?>

<div class="profile-nav-menu">
    <ul id="cabinet-menu" class="nav nav-pills nav-stacked">
        <li class="divider-bottom">
            <?= Html::a(
                \Yii::t('app', 'Обо мне'),
                ['cabinet/info/index'],
                [
                 //   'id'=>'myCrafts',
                ]
            ) ?>

        </li>
        <li class="divider-bottom">
            <?= Html::a(
                \Yii::t('app', 'Работы'),
                ['cabinet/crafts/index'],
                [
               //     'id'=>'myCrafts',
                ]
            ) ?>

        </li>
        <li class="divider-bottom"><a href="#" data-toggle="pill">Товары</a></li>
        <li class="divider-bottom">
            <?= Html::a(
                \Yii::t('app', 'Блог'),
                ['cabinet/blog/index'],
                [
                    //     'id'=>'myCrafts',
                ]
            ) ?>
        </li>
        <li><a href="#" data-toggle="pill">Счет</a></li>
    </ul>
</div>