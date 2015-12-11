

<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'form-signup',
    'enableClientValidation' => false,

]); ?>

                <?= $form->field($model, 'username') ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app','Регистрация'), ['class' => 'btn', 'name' => 'signup-button']) ?>
    </div>

<?php ActiveForm::end(); ?>