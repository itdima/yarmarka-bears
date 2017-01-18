<?php
use \kartik\icons\Icon;

?>

<div class="row">
    <div class="col-md-2">

        <div class="row">
            <?= '<img src="' . $model->getImage()->getUrl('') . '" class="img-thumbnail">'; ?>
        </div>
        <div class="row">
            <?= \yii\helpers\Html::button(
                '<i class="fa fa-paper-plane"></i> ' . \Yii::t('app', 'Сообщение'),
                ['class' => 'btn btn-block', 'name' => 'send-message-button']
            ) ?>
        </div>

    </div>
    <div class="col-md-10">
        <div class="panel panel-default">
            <div class="panel-body">

                <p>

                <h3><?= $model->name ?></h3>
                <?php
                Icon::map($this, Icon::FI);
                echo Icon::show($model->country, null, Icon::FI) . $country
                ?>


                </p>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <p>
                    <a href="<?= $model->vk ?>"><i class="fa fa-vk fa-md" aria-hidden="true"></i></a>
                    <a href="<?= $model->facebook ?>"><i class="fa fa-facebook fa-md" aria-hidden="true"></i></a>
                    <a href="<?= $model->instagram ?>"><i class="fa fa-instagram fa-md" aria-hidden="true"></i></a>
                </p>
                <?= $model->about ?>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <p><?= Yii::t('app', 'Работы') ?></p>
                <?php
                $arr_img = [];
                foreach ($model->getCrafts() as $craft) {
                    foreach ($craft->getImages() as $img) {
                        $arr_img[] = '<a href="' . \yii\helpers\Url::toRoute(['show-craft', 'item' => $craft->id]) . '" style="outline: none;"><img src="' . $img->getUrl('x200px') . '" class="thumbnail" ></a>';
                        //echo '<img bbb='.$craft->id.' src="' . $img->getUrl('') . '" >';
                    }
                }
                echo \evgeniyrru\yii2slick\Slick::widget([
                    // HTML tag for container. Div is default.
                    'itemContainer' => 'div',
                    // HTML attributes for widget container
                    'containerOptions' => ['class' => ''],
                    // Items for carousel. Empty array not allowed, exception will be throw, if empty
                    'items' => $arr_img,
                    // HTML attribute for every carousel item
                    'itemOptions' => ['style' => 'outline: none; margin: 0px 20px;'],
                    // settings for js plugin
                    // @see http://kenwheeler.github.io/slick/#settings
                    'clientOptions' => [
                        'autoplay' => true,
                        'dots' => false,
                        'slidesToShow' => 3,
                        'slidesToScroll' => 3,
                        'speed' => 500,
                        'infinite' => false,
                        'variableWidth' => true,
                        'responsive' => [
                            [
                                'breakpoint' => 560,
                                'settings' => [
                                    'slidesToShow' => 1,
                                    'slidesToScroll' => 1,
                                    'autoplay' => true,
                                ],
                            ],
                        ],
                        // note, that for params passing function you should use JsExpression object
                        // 'onAfterChange' => new \yii\web\JsExpression('function() {}'),
                    ],

                ]);


                ?>


            </div>
        </div>

    </div>
</div>


