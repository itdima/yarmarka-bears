<?php
/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\widgets\ActiveForm */

$this->title = \Yii::t('app', 'Обо мне');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('forms/_userInfoForm',['model'=>$model,'country'=>$country]); ?>




