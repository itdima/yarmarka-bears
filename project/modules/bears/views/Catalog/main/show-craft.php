<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 18.09.2015
 * Time: 10:27
 */
use yii\helpers\Url;

?>
<div class="row">
    <div class="col-md-6">
        <?php
        $widget = \kotchuprik\fotorama\Widget::begin([
            'version' => '4.5.2',
            'options' => [
                'nav' => 'thumbs',
                'allowfullscreen' => 'true',
                'fit' => 'scaledown',
                'hash' => 'true',
                'keyboard' => 'true',
                //'navposition'=>'top',

            ],
            'htmlOptions' => [
                //   'class' => 'anotherCssClass',
                //  'data-ratio'=>"1.3333333333",
                'data-width' => "100%",
                'data-height' => "80%"
                //'data-ratio' => "800/600",

            ],
        ]);
        $images = $model->getImages();
        foreach ($images as $img) {
            echo '<img src="' . $img->getUrl('') . '">';
        }
        $widget->end();
        ?>

    </div>
    <div class="col-md-6">

        <h3><p class="text-center"><?= $model->title ?></p></h3>
        <p><?= $model->description ?></p>
        <p><?= \Yii::t('app','Цена').': '.$model->price.' '. $model->currency?></p>
        <a href="<?=Url::toRoute(['show-user','item'=>$model->userProfile->id_user])?>">
            <p class="text-right signer"><?= $model->userProfile->name ?></p>
        </a>
    </div>
</div>