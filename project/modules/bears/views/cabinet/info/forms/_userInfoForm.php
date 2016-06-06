<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\icons\Icon;


?>
<?php $form = ActiveForm::begin([
    'id' => 'profile-form',
    'options' => [
        'enctype' => 'multipart/form-data',
    ],
]); ?>
    <!--
    <div class="row">
        <div class="col-md-3">
    -->


    <div class="row">

        <div class="center-block avatar-block">
                <?php
                if ($model->getImage()) {
                    echo Html::img($model->getImage()->getUrl(), ['id' => 'avatar-img', 'class'=>'img-thumbnail', 'alt' => '', 'title' => '']);
                    //echo Html::img(Yii::getAlias('@web') . '/images/placeholder.jpg', ['id' => 'avatar-img', 'alt' => '', 'title' => '']);
                } else {
                    echo Html::img(Yii::getAlias('@web') . '/images/placeholder.jpg', ['id' => 'avatar-img', 'class'=>'img-thumbnail', 'alt' => '', 'title' => '']);
                }
                ?>


                <?php
                echo $form->field($model, 'image', [
                    'options' => [
                        //   'class'=>'avatar-block',
                        //     'style' => 'width:160px;',
                    ]
                ])->label(false)->widget(
                    \vova07\fileapi\Widget::className(),
                    [
                        'options' => [
                            //    'style'=>'width:160px;',
                        ],
                        'settings' => [
                            'url' => ['cabinet/info/avatar'],
                            'accept' => 'image/*',
                            'maxSize' => (1024 * 200),
                            'elements' => [
                                'progress' => '[data-fileapi="progress"]',
                                'active' => [
                                    'show' => '[data-fileapi="active.show"]',
                                    'hide' => '[data-fileapi="active.hide"]'
                                ],
                                'name' => '[data-fileapi="name"]',
                                /*
                                'preview' => [
                                    'el' => '[data-fileapi="preview"]',
                                    'width' => 100,
                                    'height' => 100
                                ]
                                */
                            ],

                        ],
                        'callbacks' => [
                            'filecomplete' => [new JsExpression('function (evt, uiEvt) {

             if (uiEvt.result.error) {
                alert(uiEvt.result.error);
             } else {
                jQuery("#avatar-img").attr("src", uiEvt.result.avatar);
             };

            }')],
                        ],
                        'crop' => true,

                        'preview' => false,
                        // 'cropResizeWidth' => 500,
                        // 'cropResizeHeight' => 100,
                    ]
                );

                ?>

        </div>
    </div>

    <!--
    </div>
    <div class=" col-md-9">
-->
<?= $form->field($model, 'about')->textarea(['placeholder' => 'About', 'style' => 'height:170px;'])->label(false) ?>
    <!--
        <div class="row">
            <div class="col-sm-4">
            -->
<?php
Icon::map($this, Icon::FI);
//echo Icon::show('ru', null, Icon::FI);
$format = "function format(state) {if (!state.id) return state.text; return '<span class=\'flag-icon flag-icon-'+state.id+' \'></span>  ' + state.text;}";
echo $form->field($model, 'country')->label(false)->widget(Select2::classname(), [
    'name' => 'state_10',
    'data' => $country,
    'options' => [
        'placeholder' => Yii::t('app', 'Выберите страну...'),
        'multiple' => false,
    ],
    'pluginOptions' => [
        'width' => '200px',
        'templateResult' => new JsExpression("$format"),
        'templateSelection' => new JsExpression("$format"),
        'escapeMarkup' => new JsExpression("function(m) { return m; }"),
    ],
]);
?>
    <!--
            </div>
            <div class="col-sm-3">
            -->
<?= Html::submitButton(
    \Yii::t('app', 'Сохранить'),
    ['class' => 'btn', 'name' => 'add-button', 'style' => 'width:100%']
) ?>
    <!--
            </div>
        </div>
    </div>

</div>
-->
<?php ActiveForm::end(); ?>

<?php

/*
$this->registerJs(new \yii\web\JsExpression('
    $("#avatar-change").on("click", function (e) {
       // e.preventDefault();
        $("#test").click();
    });
'));
*/
?>