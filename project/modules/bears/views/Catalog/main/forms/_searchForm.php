<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 15.11.2016
 * Time: 14:26
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;


?>
<div class="search-form">
    <div class="panel panel-default">

        <div class="panel-body">

            <?php
            $form = ActiveForm::begin([
                'id' => 'crafts-search',
                'options' => [
                    'enctype' => 'multipart/form-data'
                ],
                'enableClientValidation' => false,
                'enableAjaxValidation' => false,
                //'action' => \yii\helpers\Url::toRoute(['cabinet/crafts/update']),
                'type' => ActiveForm::TYPE_HORIZONTAL,
                //'formConfig' => ['deviceSize' => ActiveForm::SIZE_TINY],
                'fieldConfig' => [
                    //      'template' => "{label}\n<div class=\"col-sm-10\">{input}</div>\n<div class=\"col-sm-offset-2 col-sm-10\">{error}</div>",
                ],
            ]); ?>

            <div class="form-group">
                <div class="col-sm-4">
                    <?= $form->field($model, 'title', ['showLabels' => false])
                        ->textInput(['placeholder' => Yii::t('app', 'Заголовок')])
                        ->label(null);
                    ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'description', ['showLabels' => false])
                        ->textInput(['placeholder' => Yii::t('app', 'Описание')])
                        ->label(null);
                    ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'priceMin', ['showLabels' => false])
                        ->textInput(['placeholder' => Yii::t('app', 'Цена') . '(min)'])
                        ->label(null);
                    ?>
                </div>
                <div class="col-sm-2">
                    <?= $form->field($model, 'priceMax', ['showLabels' => false])
                        ->textInput(['placeholder' => Yii::t('app', 'Цена') . '(max)'])
                        ->label(null);
                    ?>
                </div>
            </div>
            <div class="form-group">

                <div class="col-sm-4">
                    <?= $form->field($model, 'tag', ['showLabels' => false])
                        ->textInput(['placeholder' => Yii::t('app', 'Тэги')])
                        ->label(null);
                    ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'type', ['showLabels' => false])
                        ->dropDownList(
                            [
                                '1' => Yii::t('app', 'Работы'),
                                '2' => Yii::t('app', 'Материалы и аксессуары'),
                            ],
                            [
                                'prompt' => Yii::t('app', 'Выберите вид продукта...'),
                            ])
                        ->label(null);
                    ?>
                </div>
                <div class="col-sm-4 text-right">
                    <?= Html::submitButton('<i class="fa fa-search"></i> &nbsp;' . \Yii::t('app', 'Найти'), [
                        'class' => 'btn',
                        'name' => 'save-button'
                    ]); ?>
                    <?= Html::a('<i class="fa fa-trash-o"></i> &nbsp;' . \Yii::t('app', 'Очистить'),
                        null,
                        ['class' => 'btn', 'name' => 'reset-button',
                            'onclick' => "clearForm('crafts-search');",
                            //'onclick'=>"$('#crafts-search').find('input:text, input:password, input:file, select, textarea').val('');",
                        ]);
                    ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>