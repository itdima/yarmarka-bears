<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

echo Yii::$app->user->id;
?>
<div class="site-index">




</div>

<?php
$this->registerJs(new \yii\web\JsExpression('
    //jQuery.sidr("open","sidr-menu");
    $("#open-menu").click();'),
    \yii\web\View::POS_LOAD
);
?>