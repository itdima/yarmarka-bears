<?php
use kartik\form\ActiveForm;
use vova07\imperavi\Widget;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\Html;

?>


<?php

//echo Yii::getAlias('@web');
$form = ActiveForm::begin([
    'id' => 'crafts-form',
    'options' => [
        'enctype' => 'multipart/form-data'
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    //'action' => \yii\helpers\Url::toRoute(['cabinet/crafts/update']),
    'type' => ActiveForm::TYPE_HORIZONTAL,
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

<?= $form->field($model, 'article')->widget(Widget::classname(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 300,
        'pastePlainText' => true,
        'buttonSource' => true,
        'plugins' => [
            'fullscreen',
            'fontcolor',
            'fontfamily',
            'fontsize',
            'table'
        ],
        'imageUpload' => Url::to(['cabinet/blog/param-image-upload','id'=>$model->id]),
        'imageManagerJson' => Url::to(['cabinet/blog/param-images-get','id'=>$model->id]),
        'imageDeleteCallback' => new JsExpression('
                function(url, image){
                    $.ajax({
                        url: "' . Url::to(['cabinet/blog/imperavi-image-delete']) . '",
                        type: "post",
                        data: {"url":url},
                    });}'),
        //'fileManagerJson' => Url::to(['/blog/files-get']),
        // 'fileUpload' => Url::to(['/blog/file-upload'])


    ]
]); ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(
                \Yii::t('app', 'Сохранить'),
                ['class' => 'btn btn-block', 'name' => 'save-button']
            ) ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>