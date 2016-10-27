<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use \yii\widgets\MaskedInput;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\modules\bears\models\Products */
/* @var $form yii\widgets\ActiveForm */

?>

<?php

$data = [
    /*
    "red" => "red",
    "green" => "green",
    "blue" => "blue",
    "orange" => "orange",
    "white" => "white",
    "black" => "black",
    "purple" => "purple",
    "cyan" => "cyan",
    "teal" => "teal"
    */
];

$form = ActiveForm::begin([
    'id' => 'crafts-form',
    'options' => [
        'enctype' => 'multipart/form-data'
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    //'action' => \yii\helpers\Url::toRoute(['cuser/cabinet']),
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

<?= $form->field($model, 'description')
    ->textarea(['style' => 'height:150px;'])
    ->label(null, [
        //          'class' => 'control-label col-sm-2',
    ]);
?>


<?=$form->field($model, 'tags_field')->label(null)->widget(Select2::classname(), [
    'name' => 'state_10',
    'data' => $model->list_tags,
    'language' => 'ru',
    'options' => [
        'placeholder' => Yii::t('app', 'Выберите...'),
        'multiple' => true,
    ],

    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 10,
        // 'width' => '200px',
        //'templateResult' => new JsExpression("$format"),
        // 'templateSelection' => new JsExpression("$format"),
        // 'escapeMarkup' => new JsExpression("function(m) { return m; }"),
    ],
]);
?>


    <div class="form-group">
        <?= Html::activeLabel($model, 'price', ['class' => 'col-sm-2 control-label']) ?>
        <div class="col-sm-3">
            <?= $form->field($model, 'price', [
                'showLabels' => false,
                //    'contentAfterInput' => Html::activeDropDownList($model, 'currency', ['RUB' => 'RUB', 'EUR' => 'EUR', 'USD' => 'USD']),
                'addon' => [
                    'append' => [
                        'content' => Html::activeDropDownList($model, 'currency', ['RUB' => 'RUB', 'EUR' => 'EUR', 'USD' => 'USD'])
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
                        'class' => 'form-control',
                    ]
                ])
            ?>
        </div>
    </div>
<?php


echo $form->field($model, 'images[]')->widget(FileInput::classname(), [
    // 'language' => 'ru',
    'options' => [
        'multiple' => true,
        'accept' => 'image/*',

    ],
    'pluginOptions' => [
        'allowedExtensions' => ['jpg','jpeg','gif','png'],
        'initialPreview' => array_map(function ($img) {
            if (!empty($img->id)) {
                return Html::img($img->getUrl(), ['class' => 'file-preview-image']);
            } else {
                return null;
            }
        },
            $model->getImages()
        ),
        'initialPreviewConfig' => array_map(function ($img) use ($model) {
            $config = [
                'url' => Url::toRoute(['cabinet/crafts/delete-image']),
                'key' => $img->id,
                'extra' => [
                    'idmodel' => $model->id,
                ],
            ];
            return $config;
        },
            $model->getImages()
        ),
        'dropZoneEnabled'=>false,
        'overwriteInitial' => false,
        //'initialPreviewShowDelete' => true,
        'browseClass' => 'btn btn-fileinput',
        'cancelClass' => 'btn btn-fileinput',
        'removeClass' => 'btn btn-fileinput',
        'uploadClass' => 'btn btn-fileinput',
        //'uploadUrl'=>'/',
        'showUpload' => false,
        'showRemove' => true,
        'deleteURL' => Url::toRoute(['cabinet/crafts/delete-image']),
        'deleteExtraData' => [
            'idmodel' => $model->id,
        ],
        'maxFileCount' => 5,
        'layoutTemplates' => [
            'actions' => '<div class="file-actions"><div class="file-footer-buttons">{delete}</div></div>',
           // 'actionDelete' => '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>',
        ],
        'fileActionSettings' => [
            'removeClass' => 'btn btn-xs btn-fileinput',
            'removeIcon' => '<i class="glyphicon glyphicon-trash"></i>',
        ]
    ]
]);
?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton(
                \Yii::t('app', 'Сохранить'),
                ['class' => 'btn btn-block', 'name' => 'save-button']
            ) ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>


<?php
/*
$this->registerJs(new \yii\web\JsExpression('
    $("#crafts-form-submit").on("click", function (e) {
        e.preventDefault();
        $("#crafts-form-submit").submit();
    });
'));
*/
?>