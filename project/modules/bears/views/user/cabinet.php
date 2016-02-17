<?php
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

use \yii\helpers\Html;
use \yii\helpers\Url;
use \yii\widgets\Pjax;

?>


<?php
// Url::toRoute(['site/about'], true);

echo $this->render('/user/forms/_profileForm', ['model' => $model,'country'=>$country]);

?>

<div class="row">
    <div class="col-md-3">
        <div class="profile-nav-menu">
            <ul id="cabinet-menu" class="nav nav-pills nav-stacked">
                <li class="divider-bottom">
                    <?= Html::a(
                        'Мои работы',
                        ['cabinet','item'=>'crafts','id'=>'index'],
                        [
                            'pjax-link'=>1,
                            'id'=>'myCrafts'
                        ]
                    ) ?>

                </li>
                <li class="divider-bottom"><a href="#" data-toggle="pill">Мои товары</a></li>
                <li class="divider-bottom"><a href="#" data-toggle="pill">Мой блог</a></li>
                <li><a href="#" data-toggle="pill">Мой счет</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
        <?php Pjax::begin([
            'id'=>'profile-content',
            'linkSelector'=>'[pjax-link=1]',
            'timeout'=>'5000',
            //'enablePushState' => true,
            //'enableReplaceState' => true,
            'clientOptions'=>[
              //  'type'=>'GET',
            ],
            'options'=>[
                'aaa'=>'bbb',
            ]
        ]); ?>
        <?=isset($data)?$data:'';?>
        <?php Pjax::end(); ?>
    </div>
</div>



<?php

$script = <<<JS
$(document).on('pjax:send', function() {
  $('#profile-content').showLoading();
})
$(document).on('pjax:complete', function() {
  $('#profile-content').hideLoading();
})
JS;
$this->registerJs($script);

/*
$this->registerJs(new \yii\web\JsExpression('
    $("#cabinet-menu a").click(function(e){
        e.preventDefault();
        document.location.href = $(this).attr("href");
    })
'));
*/

?>