<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;


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

<?=Yii::$app->language?>
    <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
      //  'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,SKIN_DROPDOWN
        'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
        'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
    ]); ?>

    <!-- Панель меню (navbar) -->
    <div class="navbar-wrapper">
        <div class="navbar navbar-default" role="navigation" id="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar"
                        aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav nav-pills nav-justified">


                    <li class="">
                        <a href="<?= Url::toRoute(['/site/index']); ?>">Главная</a>
                    </li>

                    <li class="">
                        <a href="<?= Url::toRoute(['/site/about']); ?>"><?= \Yii::t('app', 'О нас') ?></a>
                    </li>

                    <li class="">
                        <a href="<?= Url::toRoute(['/site/contact']); ?>">Контакт</a>
                    </li>

                    <?php if (Yii::$app->user->isGuest) { ?>
                        <li class="">
                            <a href="<?= Url::toRoute(['/site/signup']); ?>">Зарегистрироваться</a>
                        </li>
                        <li class="">
                            <a href="<?= Url::toRoute(['/site/login']); ?>">Войти</a>
                        </li>
                    <?php } else { ?>
                        <li class="">
                            <a href="<?= Url::toRoute(['/site/logout']); ?>" data-method="post">Выйти
                                (<?= Yii::$app->user->identity->username; ?>)</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
