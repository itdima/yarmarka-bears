<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use \yii\helpers\Url;
use app\assets\AppAsset;

use raoul2000\widget\sidr\SidrAsset;
use raoul2000\widget\sidr\Sidr;

AppAsset::register($this);
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

<div class="wrap">

    <!-- Navbar -->
    <div class="navbar navbar-default divider-bottom" role="navigation" id="navigation">
        <div class="container">
            <div class="navbar-header">
                <div class="container-inline">
                    <div class="box-inline">
                        <div id="logo">
                            <a class="navbar-brand" href="#">masters portal</a>
                        </div>
                        <div>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#navbar"
                                    aria-expanded="false" aria-controls="navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="--container">
                <div id="navbar" class="navbar-collapse collapse navbar-right">
                    <ul class="nav nav-pills " id="fornavclick">

                        <li>
                            <a href="<?= Url::toRoute(['site/about'], true); ?>"><?= \Yii::t('app', 'О нас') ?></a>
                        </li>


                            <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                                 'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                               // 'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
                                'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE,
                                'itemTemplate' => '<a href="{link}" title="{language}"><i class="{language}"></i> {name}</a>',
                                'activeItemTemplate' => '<a href="{link}" title="{language}" class="active"><i class="{language}"></i> {name}</a>',
                                'parentTemplate' =>'<li id="lang-picker" class="language-picker button-list {size}">{items}</li>',
                            ]); ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>

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
