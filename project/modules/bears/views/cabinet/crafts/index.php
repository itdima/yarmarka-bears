<?php

use yii\helpers\Html;
use \yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\bears\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>


<?php
echo Html::a(\Yii::t('app', 'Добавить работу'),
    ['user/cabinet', 'item' => 'crafts', 'id' => 'add'],
    // ['cabinet/crafts/add'],
    ['class' => 'btn', 'name' => 'add-button', 'pjax-link' => 1]);
?>

<?php
if (!$models) {
    echo '<div class="row"> <p>Sorry, search result is empty!</p></div>';
} else {
    echo '';
    foreach ($models as $model) {
        echo '<div class="thumbnail shadow">';
        echo '<img src="' .  $model->getImage()->getUrl('') . '">';
        echo '<div class="caption text-center">123</div>';
        echo '<div class="caption">123</div>';
        echo '</div>';
    }
}
?>










