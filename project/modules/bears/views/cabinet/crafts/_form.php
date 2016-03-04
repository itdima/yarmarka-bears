<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use \yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\modules\bears\models\Products */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'pjax-form',
    'options' => ['data-pjax' => true],
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'action' => \yii\helpers\Url::toRoute(['user/cabinet', 'item' => 'crafts', 'id' => 'add']),
    'type' =>ActiveForm::TYPE_HORIZONTAL,
    'fieldConfig' => [
        //      'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-sm-offset-2 col-sm-10\">{error}</div>",
    ],
]); ?>


<?= $form->field($model, 'title')
    ->textInput()
    ->label(null, [
        //     'class' => 'control-label col-sm-2',
    ]);

?>

<?= $form->field($model, 'description')
    ->textarea()
    ->label(null, [
        //          'class' => 'control-label col-sm-2',
    ]);
?>
    <div class="form-group">
        <?= Html::activeLabel($model, 'price', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-3">
            <?= $form->field($model, 'price', [
                'showLabels' => false,
               // 'contentAfterInput' => Html::activeDropDownList($model, 'currency', ['RUB' => 'RUB', 'EUR' => 'EUR', 'USD' => 'USD']),
                   'addon' => [
                    'append' => [
                 'content' => Html::activeDropDownList($model, 'currency',['RUB' => 'RUB', 'EUR' => 'EUR', 'USD' => 'USD'])
                      ],
                       ]
            ])
                ->widget(MaskedInput::className(), [
                    'mask' => '9{1,7}.99',
                    'clientOptions' => [
                        'placeholder' => '0',
                    ],
                    'options' => [
                       //   'style' => 'width:85px',
                      //  'maxlength' => true,
                        'class'=>'form-control',
                    ]
                ])
            ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::button(
                \Yii::t('app', 'Сохранить'),
                ['class' => 'btn', 'name' => 'add-button', 'id' => 'submitForm']
            ) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>


<?php


$this->registerJs(new \yii\web\JsExpression('
    $("#submitForm").on("click", function (e) {
        e.preventDefault();
        $("#pjax-form").submit();
    });
'));

?>