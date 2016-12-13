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
                \Yii::t('app', 'Каталог'),
                ['cabinet/crafts/index'],
                [
               //     'id'=>'myCrafts',
                ]
            ) ?>

        </li>
        <li class="divider-bottom">
            <?= Html::a(
                \Yii::t('app', 'Блог'),
                ['cabinet/blog/index'],
                [
                    //     'id'=>'myCrafts',
                ]
            ) ?>
        </li>
        <li>
            <?= Html::a(
                \Yii::t('app', 'Сообщения')." <span title='menu_message_count' class='badge hidden'>".\app\modules\bears\models\Message::getNewMessageCount()."</span>",
                ['cabinet/message/index'],
                [
                    //     'id'=>'myCrafts',
                ]
            ) ?>
        </li>
    </ul>
</div>