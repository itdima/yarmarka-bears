<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use yii\web\JsExpression;
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]);?>

<div class="row">
    <div class="col-md-3">

        <?php
        echo $form->field($model, 'images[]')->label(false)->widget(FileInput::classname(), [
            'options' => [
                'multiple' => false,
                'accept' => 'image/*',
            ],
            'pluginOptions' => [
                'overwriteInitial'=> true,
                'maxFileSize' => 100,
                'allowedPreviewTypes' => ['image'],
                'allowedFileTypes' => ['image'],
                'showUpload' => false,
                'showCaption' => false,
                'showRemove' => false,
                'showClose' => false,
                'browseClass' => 'btn',
                'browseIcon' => '<i class="fa fa-camera"></i>',
                //'browseLabel' => 'Select Photo',
                'defaultPreviewContent' => [
                    '<div class="file-preview-frame"> '.
                    Html::img(Yii::getAlias('@web') . '/images/placeholder.jpg', ['class' => 'file-preview-image', 'alt' => '', 'title' => ''])
                    .'</div>'
                ],

                'initialPreview' => [
                    Html::img(Yii::getAlias('@web') . '/images/placeholder.jpg', ['class' => 'file-preview-image', 'alt' => '', 'title' => '']),
                ],

                'previewFileIcon' => [
                    Html::img(Yii::getAlias('@web') . '/images/placeholder.jpg', ['class' => 'file-preview-image', 'alt' => '', 'title' => '']),
                ],

                'layoutTemplates' => [
                    'main2' => '<div class="kv-avatar center-block text-center">{preview}{browse}</div>',
                    /*
                                        'preview' => '
                                            <div class="file-preview {class}">
                                                <div class="{dropClass}">
                                                    <div class="file-preview-thumbnails"></div>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        '
                    */
                ],
                'previewTemplates' => [
                    'image'=>'
                        <div class="file-preview-frame" id="{previewId}" data-fileindex="{fileindex}">
                            <img src="{data}" class="file-preview-image" title="{caption}" alt="{caption}"  STYLE_SETTING >
                        </div>
                    ',
                    'other'=>'
                        <div class="file-preview-frame{frameClass}" id="{previewId}" data-fileindex="{fileindex}" title="{caption}" STYLE_SETTING >
                            <div class="file-preview-other-frame">
                                <div style="border:none;opacity: 1;" class="file-preview-other">
                                    <span class="{previewFileIconClass}">{previewFileIcon}</span>
                                </div>
                            </div>
                        </div>
                    ',
                ],

            ],
            'pluginEvents' => [
                //  'fileerror' => 'function(event, key) { alert(123); }',
            ]
        ]);
        ?>
    </div>
    <div class="col-md-9">
        <?= $form->field($model, 'about')->textarea(['placeholder' => 'About','style'=>'height:185px;'])->label(false) ?>
        <?= Html::submitButton(\Yii::t('app', 'Сохранить'), ['class' => 'btn']) ?>
    </div>

</div>

<?php ActiveForm::end(); ?>
