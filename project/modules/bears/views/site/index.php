<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">


</div>

<?php
$this->registerJs(new \yii\web\JsExpression('
    //jQuery.sidr("open","sidr-menu");
    $(".sidr-selector").click();'),
    \yii\web\View::POS_LOAD
);
?>