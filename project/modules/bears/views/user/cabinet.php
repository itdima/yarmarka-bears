<?php
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

use \yii\helpers\Html;
use \yii\helpers\Url;
use \yii\widgets\Pjax;


?>


<div id="profile-form-loading"></div>
<?php Pjax::begin([
    'id'=>'profile-form-block',
   //'linkSelector'=>'[pjax-link=1]',
    'timeout'=>'10000',
    //'enablePushState' => true,
    //'enableReplaceState' => true,
    'clientOptions'=>[
        //  'type'=>'GET',
    ],
    'options'=>[
    ]
]); ?>
<?php echo $this->render('/user/forms/_profileForm', ['model' => $model,'country'=>$country]);?>
<?php Pjax::end(); ?>

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
            'id'=>'profile-content-block',
            'linkSelector'=>'[pjax-link=1]',
            'timeout'=>'10000',
            //'enablePushState' => true,
            //'enableReplaceState' => true,
            'clientOptions'=>[
              //  'type'=>'GET',
            ],
            'options'=>[
            ]
        ]); ?>

        <div id="profile-content-loading"></div>
        <?php
        echo isset($data)?$data:'';
        ?>
        <?php Pjax::end(); ?>
    </div>
</div>



<?php


$script = <<<JS

$('#profile-content-block').on('pjax:send', function(event) {
  $('#profile-content-loading').showLoading();
})
$('#profile-content-block').on('pjax:complete', function() {
  $('#profile-content-loading').hideLoading();
})

$('#profile-form-block').on('pjax:send', function(event) {
  $('#profile-form-loading').showLoading();
})
$('#profile-form-block').on('pjax:complete', function() {
  $('#profile-form-loading').hideLoading();
})
JS;
$this->registerJs($script);

\yii\widgets\MaskedInputAsset::register($this);


/*
$this->registerJs(new \yii\web\JsExpression('
    $("#cabinet-menu a").click(function(e){
        e.preventDefault();
        document.location.href = $(this).attr("href");
    })
'));
*/

?>


