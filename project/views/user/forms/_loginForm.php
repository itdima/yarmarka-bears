<?php
use yii\bootstrap\ActiveForm;
use \yii\helpers\Url;
use yii\helpers\Html;
use yii\web\JsExpression;


$form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
    //'enableAjaxValidation' => true,
    'enableClientValidation' => false,
   // 'action' => Url::to(['']),
    //'validationUrl' => Url::toRoute(['/user/validate']),

]); ?>

<?= $form->field($model, 'username')->textInput(['placeholder' => 'email'])->label(false) ?>
<?= $form->field($model, 'password')->passwordInput(['placeholder' => \Yii::t('app', 'Пароль')])->label(false) ?>
<div class="form-group">
    <?= Html::a( \Yii::t('app', 'Забыли пароль'), ['/user/request-password-reset']) ?>
</div>

<div class="form-inline">
    <?= $form->field($model, 'rememberMe')->checkbox()->label(\Yii::t('app', 'Запомнить')) ?>
    <div>
        <?= Html::submitButton(\Yii::t('app', 'Войти'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        <i id="spinner" class="fa fa-spinner fa-pulse hidden"></i>
    </div>

</div>
<?php ActiveForm::end(); ?>

<?php

$this->registerJs(new JsExpression('
$("#login-form").on("submit", function (e) {
 e.preventDefault();
 var form = $(this);
  $.ajax({
   url: "' .  Url::toRoute(['/user/login']) . '",
   type: "POST",
   data: form.serialize(),
   beforeSend: function () {
        $("#spinner").removeClass("hidden");
    },
   success: function (result) {
        $("#spinner").addClass("hidden");
        if (result == "true"){
            location.reload();
        } else {
            $("#form_wrap").html(result);
        }
   },
  });
});
'));
?>
