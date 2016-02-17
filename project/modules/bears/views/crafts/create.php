<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\bears\models\Products */

?>
<div class="products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
