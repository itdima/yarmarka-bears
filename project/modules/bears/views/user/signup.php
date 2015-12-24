<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */



$this->title = \Yii::t('app', 'Регистрация');
$this->params['breadcrumbs'][] = $this->title;
?>


    <div class="row">
        <div class="col-lg-5">
            <?php
            //$model = new \app\models\LoginForm();
            echo $this->render('/user/forms/_signupForm', ['model' => $model]);
            ?>
        </div>
    </div>

