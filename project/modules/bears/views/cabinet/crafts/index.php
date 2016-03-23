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
<?= Html::a('<i class="fa fa-plus"></i> &nbsp;' . \Yii::t('app', 'Добавить работу'),
    ['cabinet/crafts/add'],
    ['class' => 'btn btn-block', 'name' => 'add-button']);
?>


<div class="row">
    <?php

    if (!$models) {
        echo '<div><p>Sorry, search result is empty!</p></div>';
    } else {
        foreach ($models as $model) {
            $urlEdit = Url::toRoute(['cabinet/crafts/update', 'item' => $model->id]);
            echo '<div class="col-sm-6 col-md-4">
                            <div class="thumbnail shadow">
                                <a href="' . $urlEdit . '">';

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
            echo '</a>
                            <div class="caption text-center">
                                <a  href="' . $urlEdit . '">
                                    <h4>' . $model->title . '</h4>
                                </a>
                            </div>
                        </div>
                    </div>';

        }
    }
    ?>

</div>



