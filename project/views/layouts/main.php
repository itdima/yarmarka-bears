<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use \yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use raoul2000\widget\sidr\SidrAsset;
use raoul2000\widget\sidr\Sidr;

//AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-- // -->


<div class="wrap">


    <!-- Content -->
    <div id="content" class="container">
        <?= $content ?>
    </div>

</div>

<!-- Footer-->
<footer class="footer divider-top">
    <div class="container">
        <p class="pull-left">&copy; Portal <?= date('Y') ?></p>

        <p class="pull-right">Powered by <a href="#">ITDima</a></p>
    </div>
</footer>




<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
