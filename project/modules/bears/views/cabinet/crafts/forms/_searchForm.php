<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 15.11.2016
 * Time: 14:26
 */

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\form\ActiveForm;
use \yii\widgets\MaskedInput;
use kartik\file\FileInput;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
<div class="panel panel-default">
    <div class="panel-heading">
        <?= \Yii::t('app', 'Поиск') ?>
    </div>
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
    <div class="col-sm-6">
        <?= $form->field($model, 'title',['showLabels'=>false])
            ->textInput(['placeholder'=> Yii::t('app','Заголовок')])
            ->label(null);
        ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'description',['showLabels'=>false])
            ->textInput(['placeholder'=> Yii::t('app','Описание')])
            ->label(null);
        ?>
    </div>
</div>
    <div class="form-group">
        <div class="col-sm-2">
            <?= $form->field($model, 'priceMin',['showLabels'=>false])
                ->textInput(['placeholder'=> Yii::t('app','Цена(min)')])
                ->label(null);
            ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'priceMax',['showLabels'=>false])
                ->textInput(['placeholder'=> Yii::t('app','Цена(max)')])
                ->label(null);
            ?>
        </div>
        <div class="col-sm-8">

        </div>
    </div>
<div class="form-group">
    <div class="col-sm-offset-9 col-sm-3">

        <?= Html::submitButton(\Yii::t('app', 'Найти'),['class' => 'btn', 'name' => 'save-button']); ?>
        <?= Html::resetButton(\Yii::t('app', 'Очистить'),['class' => 'btn', 'name' => 'save-button']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

</div>
</div>