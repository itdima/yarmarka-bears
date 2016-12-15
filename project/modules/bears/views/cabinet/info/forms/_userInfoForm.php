<?php
use yii\helpers\Html;

use yii\web\JsExpression;
use kartik\select2\Select2;
use kartik\icons\Icon;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget as imperavi;

?>
    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <?= \hyii2\avatar\AvatarWidget::widget([
                    'imageUrl' => $model->getImage()->getUrl(''),
                ]);
                ?>
            </div>
            <div class="row">
                <?= Html::button(
                    '<i class="fa fa-pencil-square-o"></i> ' . \Yii::t('app', 'Редактировать'),
                    ['class' => 'change-avatar btn', 'name' => 'change-button']
                ) ?>
            </div>

        </div>

        <div class="col-sm-9">
            <?php
            $form = ActiveForm::begin([
                'id' => 'profile-form',
                'options' => [
                    'enctype' => 'multipart/form-data',
                ],
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
            ]); ?>


            <?= $form->field($model, 'about')->widget(imperavi::classname(), [
                'settings' => [
                    'lang' => 'ru',
                    'minHeight' => 250,
                    'pastePlainText' => true,
                    'buttonSource' => true,
                    'plugins' => [
                        'fullscreen',
                        'fontcolor',
                        'fontfamily',
                        'fontsize',
                        'table'
                    ],
                ],
                'options' =>['placeholder'=>Yii::t('app','Обо мне')],
            ])->label(false); ?>


            <?=$form->field($model,'vk', [
                'showLabels' => false,
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="fa fa-vk fa-lg" aria-hidden="true"></i>'
                    ],
                ]
            ])
                ->textInput(['placeholder' => Yii::t('app', 'Ссылка на страницу').' VK'])
        //        ->label(null);
            ?>

            <?=$form->field($model,'facebook', [
                'showLabels' => false,
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="fa fa-facebook-square fa-lg" aria-hidden="true"></i>'
                    ],
                ]
            ])
                ->textInput(['placeholder' => Yii::t('app', 'Ссылка на страницу').' Facebook'])
            //        ->label(null);
            ?>

            <?=$form->field($model,'facebook', [
                'showLabels' => false,
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="fa fa-instagram fa-lg" aria-hidden="true"></i>'
                    ],
                ]
            ])
                ->textInput(['placeholder' => Yii::t('app', 'Ссылка на страницу').' Instagram'])
            //        ->label(null);
            ?>


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

            <?= Html::submitButton(
                '<i class="fa fa-floppy-o"></i> ' . \Yii::t('app', 'Сохранить'),
                ['class' => 'btn', 'name' => 'add-button', 'style' => 'width:100%']
            ) ?>

        </div>
    </div>

<?php ActiveForm::end(); ?>

<?php

$this->registerJs(new \yii\web\JsExpression('
    $(".change-avatar").on("click", function (e) {
        e.preventDefault();
        $("[data-original-title]").click();
    });
'));

?>