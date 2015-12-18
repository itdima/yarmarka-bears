<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use \yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use app\modules\bears\assets\BearsAsset;

use raoul2000\widget\sidr\SidrAsset;
use raoul2000\widget\sidr\Sidr;

BearsAsset::register($this);
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


<!-- Всплывающее боковое меню -->
<?php
SidrAsset::$theme = SidrAsset::THEME_LIGHT;
echo Sidr::widget([
    'selector' => '#open-menu',
    'pluginOptions' => [
        'name' => 'sidr',
        'source' => '#sidr',
        'body' => '#content',
        'displace' => true,
        'onClose' => new yii\web\JsExpression('
            function() {
                //alert("bye bye side menu !");
            }
        ')
    ]
]);

?>

<div id="sidr-toggle">
    <a id="open-menu" href>
            <span class="fa-stack fa-lg">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-align-justify fa-stack-1x"></i>
            </span>
    </a>
</div>

<div id="sidr" class="sidr left">
    <div>
        <h1><?= \Yii::t('app', 'Меню') ?></h1>
    </div>
    <div>
        <ul>
            <li><a href="#"><?= \Yii::t('app', 'Каталог') ?></a>
                <ul>
                    <li><a href="#"><?= \Yii::t('app', 'Мишки') ?></a>
                    <li><a href="#"><?= \Yii::t('app', 'Куклы') ?></a>
                    <li><a href="#"><?= \Yii::t('app', 'Материалы') ?></a>
                </ul>
            </li>
            <li><a href="#"><?= \Yii::t('app', 'Блоги') ?></a></li>
            <li><a href="#"><?= \Yii::t('app', 'Мастера') ?></a></li>
        </ul>
    </div>
</div>
<!-- ----------- -->


<div class="wrap">

    <!-- Login & Languages -->
    <div class="container-inline">
        <div class="box-inline text-right">

            <div class="dropdown">
                <?php if (Yii::$app->user->isGuest) { ?>
                    <!--Гость-->
                    <div id="login">
                        <a id="login-dropdown" href="<?= Url::toRoute(['user/login']); ?>"
                           class="dropdown-toggle"
                           data-toggle="dropdown">
                            <?= \Yii::t('app', 'Войти') ?> <span class="fa fa-caret-down"></span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="login-dropdown">
                            <li>
                                <div id="form_wrap">
                                    <?php
                                    $model = new \app\modules\bears\models\LoginForm();
                                    echo $this->render('/user/forms/_loginForm', ['model' => $model]);
                                    ?>
                                </div>
                            </li>
                            <li role="separator" class="login-divider">
                                <div>
                                    <a href="<?= Url::toRoute(['user/signup']); ?>"><?= \Yii::t('app', 'Регистрация') ?></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                <?php } else { ?>
                    <!--Пользователь -->
                    <div id="logout">
                        <a id="logout-dropdown" href class="dropdown-toggle" data-toggle="dropdown">
                            <span class="fa fa-user fa-fw"></span>
                            <?= Yii::$app->user->identity->username; ?>
                            <span class="fa fa-caret-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="logout-dropdown">
                            <li>
                                <a href="<?= Url::toRoute(['user/cabinet']); ?>" data-method="post">
                                    <?= \Yii::t('app', 'Личный кабинет') ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?= Url::toRoute(['user/logout']); ?>" data-method="post">
                                    <?= \Yii::t('app', 'Выйти') ?>
                                </a>
                            </li>

                        </ul>
                    </div>
                <?php } ?>
            </div>

            <div>
                <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                    //  'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,SKIN_DROPDOWN
                    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
                    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE
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
                            <a href="<?= Url::toRoute(['site/index'], true); ?>"><?= \Yii::t('app', 'Главная') ?></a>
                        </li>

                        <li <?php echo ($this->context->action->id == 'about') ? "class='active'" : "class"; ?>>
                            <a href="<?= Url::toRoute(['site/about'], true); ?>"><?= \Yii::t('app', 'О нас') ?></a>
                        </li>

                        <li <?php echo ($this->context->action->id == 'contact') ? "class='active'" : "class"; ?>>
                            <a href="<?= Url::toRoute(['site/contact'], true); ?>"><?= \Yii::t('app', 'Контакт') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


    </div>

    <!-- Content -->
    <div id="content" class="--container">
        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        </div>
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