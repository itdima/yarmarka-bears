<?php

use yii\helpers\Html;
use \yii\widgets\Pjax;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\bears\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = \Yii::t('app', 'Работы');
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?= $this->render('forms/_searchForm', [
        'model' => $searchModel,
    ]) ?>
</div>

<div class="row">
    <?= Html::a('<i class="fa fa-plus"></i> &nbsp;' . \Yii::t('app', 'Добавить работу'),
        ['cabinet/crafts/add'],
        ['class' => 'btn btn-block', 'name' => 'add-button']);
    ?>
    <?php

    if (!$models) {
        echo '<div><p>'.\Yii::t('app', 'Извините, но по запросу ничего не найдено.').'</p></div>';
    } else {
        foreach ($models as $model) {
            $urlEdit = Url::toRoute(['cabinet/crafts/update', 'item' => $model->id]);
            echo '<div class="col-sm-6 col-md-4">
                            <div class="thumbnail shadow">';
                              //  <a href="' . $urlEdit . '">';
            $widget = \kotchuprik\fotorama\Widget::begin([
                'version' => '4.5.2',
                'options' => [
                    // 'nav' => 'thumbs',
                    'allowfullscreen' => 'true',
                    'fit' => 'scaledown',
                    'hash' => 'true',
                    'keyboard' => 'true',
                    //'navposition'=>'top',
                ],
                'htmlOptions' => [
                    'data-width' => "100%",
                    'data-height' => "50%"
                ],
            ]);
                echo '<img src="' . $model->getImage()->getUrl('') . '"/>';
            $widget->end();
            //echo '</a><div class="caption text-right"><p>'
             echo '<div class="caption text-right"><p>';
            echo Html::a('<i class="fa fa-edit"></i>',
                //['cabinet/crafts/update'],
                $urlEdit,
                [
                    'class' => 'btn',
                //    'name' => 'edit-button',
                    'title' => \Yii::t('app', 'Редактировать'),

                    'data'=>[
                        'method' => 'post',
                        'params'=>['item' => $model->id],
                    ]

                ]);
            echo Html::a('<i class="fa fa-trash"></i>' ,
                ['cabinet/crafts/delete'],
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
            echo '</p></div></div></div>';
        }
    }
    ?>

</div>
<div class="row text-center">
<?php
    echo yii\widgets\LinkPager::widget([
    'pagination' => $pages,
    ]);
?>
</div>



