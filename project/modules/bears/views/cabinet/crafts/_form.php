<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use \yii\widgets\MaskedInput;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\bears\models\Products */
/* @var $form yii\widgets\ActiveForm */

?>

<?php $form = ActiveForm::begin([
    'id' => 'crafts-form',
    'options' => [
        'data-pjax' => true,
        'enctype' => 'multipart/form-data'
    ],
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'action' => \yii\helpers\Url::toRoute(['user/cabinet', 'item' => 'crafts', 'id' => 'add']),
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
    'options'=>[
        'multiple'=>true
    ],
    'pluginOptions' => [
       // 'uploadUrl' => \yii\helpers\Url::to(['/site/file-upload']),
        /*
        'uploadExtraData' => [
            'album_id' => 20,
            'cat_id' => 'Nature'
        ],

        'initialPreview' => array_map(function ($img) {
            if (!empty($img->id)) {
                return Html::img($img->getUrl(), ['class' => 'file-preview-image']);
            } else {
                return null;
            }
        },
            $model->getImages()
        ),
        */
        'overwriteInitial' => false,
        //'initialPreviewShowDelete' => true,
        'browseClass' => 'btn btn-fileinput',
        'cancelClass'=> 'btn btn-fileinput',
        'removeClass'=>'btn btn-fileinput',
        'uploadClass'=>'btn btn-fileinput',
        'showUpload' => false,
        'maxFileCount' => 5,
        'layoutTemplates' => [
            'actions' => '<div class="file-actions"><div class="file-footer-buttons">{delete}</div></div>',
            'actionDelete'=> '<button type="button" class="kv-file-remove {removeClass}" title="{removeTitle}"{dataUrl}{dataKey}>{removeIcon}</button>',
        ],
        'fileActionSettings'=>[
            'removeClass'=>'btn btn-xs btn-fileinput',
            'removeIcon'=>'<i class="glyphicon glyphicon-trash"></i>',
        ]
    ]
]);
?>


    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::button(
                \Yii::t('app', 'Сохранить'),
                ['class' => 'btn', 'name' => 'add-button', 'id' => 'crafts-form-submit']
            ) ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>


<?php

$this->registerJs(new \yii\web\JsExpression('
    $("#crafts-form-submit").on("click", function (e) {
        e.preventDefault();
        $("#crafts-form-submit").submit();
    });
'));

?>