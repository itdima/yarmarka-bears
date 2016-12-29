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
        echo '<div><p>' . \Yii::t('app', 'Извините, но по запросу ничего не найдено.') . '</p></div>';
    } else {
        foreach ($models as $model) {
            $urlEdit = Url::toRoute(['cabinet/crafts/update', 'item' => $model->id]);
            ?>


            <div class="col-sm-4 col-md-3">
                <div class="thumbnail shadow">

                    <?php
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
                    ?>
                    <div class="">
                        <a href="<?=Url::toRoute(['show-craft','item'=>$model->id])?>">
                            <h5><?php echo $model->title ?></h5>
                        </a>
                        <h6><p class="text-right"><?php echo 'by '.$model->userProfile->name ?></p></h6>
                    </div>
                </div>
            </div>
        <?php }
    } ?>


    <div class="row text-center">


        <?php
        echo yii\widgets\LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>
</div>

