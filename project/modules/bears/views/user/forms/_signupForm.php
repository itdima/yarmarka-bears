<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableClientValidation' => false,

]); ?>

<?= $form->field($model, 'username') ?>

<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'password_repeat')->passwordInput() ?>

<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'verifyCode')->widget(\yii\captcha\Captcha::className(),[
    'captchaAction'=>['user/captcha'],
    'template'=>'<div class="form-inline">{input} <a id="refresh-captcha" href><i class="fa fa-refresh"></i></a>{image} </div>',
    'imageOptions'=>['style'=>'cursor:pointer','id'=>'img-captcha'],
]) ?>

<div class="form-group">
    <?= Html::submitButton(\Yii::t('app', 'Регистрация'), ['class' => 'btn', 'name' => 'signup-button']) ?>
</div>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs(new \yii\web\JsExpression('
    $("#refresh-captcha").click(function(e){
        e.preventDefault();
        $("#img-captcha").trigger( "click" );
    })
'));
?>

