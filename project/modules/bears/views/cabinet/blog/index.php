<?php

use yii\helpers\Html;
use \yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;


$this->title = \Yii::t('app', 'Мой блог');
$this->params['breadcrumbs'][] = $this->title;

//echo Yii::$app->params['currentWorld'];
?>


<div>
    <?= $this->render('forms/_searchForm', [
        'model' => $searchModel,
    ]) ?>
</div>



  <?php

  if (!$models) {
      echo '<div><p>'.\Yii::t('app', 'Извините, но по запросу ничего не найдено.').'</p></div>';
  } else {
    foreach ($models as $model) {?>


    <div class="panel panel-default">
        <div class="panel-heading">

            <div class="row">
                <div class="col-sm-8">
                    <h3 class="panel-title text-left">
                        <?= $model->title ?>
                    </h3>
                </div>
                <div class="col-sm-2">
                    <h5 class="panel-title text-right">
                        <?= \Yii::$app->formatter->asDate($model->created_at,'dd.M.yyyy') ?>

                    </h5>
                </div>
                <div class="col-sm-2 text-center">
                    <div class="btn-group btn-group-xs">

                    <?= Html::a('<i class="fa fa-edit"></i>',
                        //['cabinet/crafts/update'],
                        Url::toRoute(['cabinet/blog/update', 'item' => $model->id]),
                        [
                            'class' => 'btn',
                            //    'name' => 'edit-button',
                            'title' => \Yii::t('app', 'Редактировать'),

                            'data'=>[
                                'method' => 'post',
                                'params'=>['item' => $model->id],
                            ]

                        ]);
                    ?>

                    <?= Html::a('<i class="fa fa-trash"></i>' ,
                        ['cabinet/blog/delete'],
                        [
                            'class' => 'btn',
                            //   'name' => 'delete-button',
                            'title' => \Yii::t('app', 'Удалить'),
                            'data'=>[
                                'method' => 'post',
                                'confirm' => \Yii::t('app', 'Подтвердить удаление?'),
                                'params'=>['id' => $model->id],
                            ]
                        ]);
                    ?>
                        </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <?= $model->article ?>
        </div>
    </div>

        <?php }};  ?>





<?= Html::a('<i class="fa fa-plus"></i> &nbsp;' . \Yii::t('app', 'Добавить статью'),
    ['cabinet/blog/add'],
    ['class' => 'btn btn-block', 'name' => 'add-button']);
?>

<div class="row text-center">
    <?php
    echo yii\widgets\LinkPager::widget([
        'pagination' => $pages,
    ]);
    ?>
</div>

