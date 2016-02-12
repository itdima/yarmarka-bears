<?php
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

?>


<?php


echo $this->render('/user/forms/_profileForm', ['model' => $model,'country'=>$country]);

?>

<div class="row">
    <div class="col-md-3">
        <div class="profile-nav-menu">
            <ul class="nav nav-pills nav-stacked">
                <li class="active divider-bottom"><a href="#" data-toggle="pill">Мои работы</a></li>
                <li class="divider-bottom"><a href="#" data-toggle="pill">Мои товары</a></li>
                <li class="divider-bottom"><a href="#" data-toggle="pill">Мой блог</a></li>
                <li><a href="#" data-toggle="pill">Мой счет</a></li>
            </ul>
        </div>
    </div>
</div>

