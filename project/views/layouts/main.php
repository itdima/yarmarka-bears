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

    <!-- Login & Languages -->
    <div class="container-inline">
        <div class="box-inline text-right">
            <div id="login">
                <div class="dropdown">
                    <?php if (Yii::$app->user->isGuest) { ?>
                        <a href="<?= Url::toRoute(['/user/login']); ?>"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            <?= \Yii::t('app', 'Войти') ?> <span class="caret"></span>
                        </a>
                    <?php } else { ?>
                        <a href="<?= Url::toRoute(['/user/logout']); ?>"
                           data-method="post"><?= \Yii::t('app', 'Выйти') ?>
                            (<?= Yii::$app->user->identity->username; ?>)</a>
                    <?php } ?>
                    <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="dLabel">
                        <li>
                            <div id="form_wrap">
                                <?php
                                $model = new \app\models\LoginForm();
                                echo $this->render('/user/forms/_loginForm', ['model' => $model]);
                                ?>
                            </div>
                        </li>
                        <li role="separator" class="login-divider">
                            <div>
                                <a href="<?= Url::toRoute(['/user/signup']); ?>"><?= \Yii::t('app', 'Регистрация') ?></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div>
                <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                    //  'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,SKIN_DROPDOWN
                    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
                ]); ?>
            </div>
        </div>
    </div>

    <!-- Navbar -->
    <div class="navbar navbar-default divider-bottom" role="navigation" id="navigation">
        <div class="container">
            <div class="navbar-header">
                <div class="container-inline">
                    <div class="box-inline">
                        <div id="logo">
                            <a class="navbar-brand" href="#">TeddyBears</a>
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
                        <li <?php echo ($this->context->action->id == 'index') ? "class='active'" : "class"; ?>>
                            <a href="<?= Url::toRoute(['/site/index'], true); ?>"><?= \Yii::t('app', 'Главная') ?></a>
                        </li>

                        <li <?php echo ($this->context->action->id == 'about') ? "class='active'" : "class"; ?>>
                            <a href="<?= Url::toRoute(['/site/about'], true); ?>"><?= \Yii::t('app', 'О нас') ?></a>
                        </li>

                        <li <?php echo ($this->context->action->id == 'contact') ? "class='active'" : "class"; ?>>
                            <a href="<?= Url::toRoute(['/site/contact'], true); ?>"><?= \Yii::t('app', 'Контакт') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div id="content" class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<!-- Footer-->
<footer class="footer divider-top">
    <div class="container">
        <p class="pull-left">&copy; TeddyBears <?= date('Y') ?></p>

        <p class="pull-right">Powered by <a href="#">ITDima</a></p>
    </div>
</footer>


<?php
$this->registerJs(new \yii\web\JsExpression('
    $("#fornavclick a").click(function(e){
        e.preventDefault();
        document.location.href = $(this).attr("href");
    })
'));
?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
