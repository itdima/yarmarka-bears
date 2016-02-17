<?php

use yii\helpers\Html;
use \yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\bears\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>



<?php echo Html::a(\Yii::t('app', 'Добавить работу'),
    ['user/cabinet','item'=>'crafts','id'=>'add'],
    ['class' => 'btn', 'name' => 'add-button', 'pjax-link'=>1]);?>








