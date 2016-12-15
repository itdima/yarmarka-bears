<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>
<div>
    <?= $this->render('forms/_searchForm', [
        'model' => $searchModel,
    ]) ?>
</div>

<div class="row">
    <?php
    if (!$models) {
        echo '<div><p>'.\Yii::t('app', 'Извините, но по запросу ничего не найдено.').'</p></div>';
    } else { foreach ($models as $model) {
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

        echo '</div></div>';
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