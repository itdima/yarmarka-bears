<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;
?>
<div class="search-form">

<div class="panel panel-default">

<div class="panel-body">

<?php

$form = ActiveForm::begin([
    'id' => 'blog-search',
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
        <?= $form->field($model, 'article',['showLabels'=>false])
            ->textInput(['placeholder'=> Yii::t('app','Статья')])
            ->label(null);
        ?>
    </div>
</div>
    <div class="form-group">
        <div class="col-sm-4">
            <?= $form->field($model, 'date_from',['showLabels'=>false])->widget(DatePicker::className(),[
              //  'name' => 'check_issue_date',
                'value' => date('dd.mm.yyyy'),
                'options' => ['placeholder' => \Yii::t('app','Дата от')],
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                ]
            ]);
            ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'date_to',['showLabels'=>false])->widget(DatePicker::className(),[
                //  'name' => 'check_issue_date',
                'value' => date('dd.mm.yyyy'),
                'options' => ['placeholder' => \Yii::t('app','Дата до')],
                'pluginOptions' => [
                    'format' => 'dd.mm.yyyy',
                    'todayHighlight' => true,
                    'autoclose'=>true,
                ]
            ]);

            ?>
        </div>

        <div class="col-sm-4 text-right">
            <?= Html::submitButton('<i class="fa fa-search"></i> &nbsp;' .\Yii::t('app', 'Найти'),[
                'class' => 'btn',
                'name' => 'find-button'
            ]); ?>
            <?= Html::a('<i class="fa fa-trash-o"></i> &nbsp;' . \Yii::t('app', 'Очистить'),
                null,
                ['class' => 'btn', 'name' => 'reset-button',
                    'onclick'=>"clearForm('blog-search');",
                    //'onclick'=>"$('#blog-search').find('input:text, input:password, input:file, select, textarea').val('');",
                ]);
            ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>

</div>
</div>
</div>