<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use \yii\helpers\Url;
use app\modules\bears\assets\BearsAsset;

use timurmelnikov\widgets\ShowLoading;

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

<?php
//---Виджет иконки загрузки
echo ShowLoading::widget(['loadingType' => 1]);

//----Виджет всплывающих сообщений
foreach (Yii::$app->session->getAllFlashes() as $message):;
    echo \kartik\growl\Growl::widget([
        'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
        'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
        'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
        //'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
        //'showSeparator' => true,
        'delay' => 1, //This delay is how long before the message shows
        'pluginOptions' => [
            'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
            'placement' => [
                'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
            ]
        ]
    ]);
endforeach;



?>
<?php
/*

 use raoul2000\widget\sidr\SidrAsset;
 use raoul2000\widget\sidr\Sidr;

//----Виджет всплывающего меню
SidrAsset::$theme = SidrAsset::THEME_LIGHT;
echo Sidr::widget([
    'selector' => '.sidr-selector',
    'pluginOptions' => [
        'name' => 'sidr',
        'source' => '#sidr',
        //'body' => '#content',
        'displace' => false,
        'onClose' => new yii\web\JsExpression('
            function() {
                $(".sidr-selector").html("<i class=\"fa fa-indent fa-2x\"></i>");
            }
        '),
        'onOpen' => new yii\web\JsExpression('
            function() {
                $(".sidr-selector").html("<i class=\"fa fa-outdent fa-2x\"></i>");
            }
        ')
    ]
]);



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

 <!-- Toggle для бокового меню  -->
            <div class="col-xs-2 col-sm-1 col-nav">
                <a class="sidr-selector navbar-left" href>
                    <i class="fa fa-indent fa-2x"></i>
                </a>
            </div>

*/

$controller = $this->context->id;
$action = $this->context->action->id;
?>
<!-- ----------- -->


<div class="wrap">

    <div class="row wrap-nav navbar-fixed-top">
        <div class="divider-bottom">
            <div class="col-xs-2 col-sm-1 col-nav">

            </div>
            <!-- <div class="col-xs-10 col-sm-11 col-nav"> -->
            <div class="col-xs-10 col-sm-11 col-nav">
                <!-- Navbar -->
                <nav class="navbar navbar-default" role="navigation" id="navigation">
                    <div class="container">
                        <div class="navbar-header">
                            <div id="logo">
                                <a class="navbar-brand hidden-xs" href="#">TeddyBears</a>
                                <a class="navbar-brand visible-xs" href="#">TeddyBears</a>
                            </div>
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                                    data-target="#navbar"
                                    aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-list fa-2x"></i>
                            </button>
                        </div>



                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav" id="fornavclick">
                                <li <?php echo ($action == 'index' and $controller=='site') ? "class='active'" : "class"; ?>>
                                    <a href="<?= Url::toRoute(['/'], true); ?>"><?= '<i class="fa fa-arrow-left" aria-hidden="true"></i> '.\Yii::t('app', 'Портал') ?></a>
                                </li>

                                <li <?php echo ($action == 'index' and $controller=='catalog/main') ? "class='active'" : "class"; ?>>
                                    <a href="<?= Url::toRoute(['catalog/main/index'], true); ?>"><?= \Yii::t('app', 'Каталог') ?></a>
                                </li>

                                <li <?php echo ($action == 'contact' and $controller=='site') ? "class='active'" : "class"; ?>>
                                    <a href="<?= Url::toRoute(['site/contact'], true); ?>"><?= \Yii::t('app', 'Контакт') ?></a>
                                </li>


                                <li <?php echo ($action == 'about' and $controller=='site') ? "class='active'" : "class"; ?>>
                                    <a href="<?= Url::toRoute(['site/about'], true); ?>"><?= \Yii::t('app', 'О нас') ?></a>
                                </li>


                            </ul>
                            <ul class="nav navbar-nav navbar-right" id="fornavclick">
                                <?php if (Yii::$app->user->isGuest) { ?>
                                    <li id="login" class="dropdown">
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                            <?= \Yii::t('app', 'Войти') ?>
                                            <span class="fa fa-caret-down"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
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
                                    </li>
                                <?php } else { ?>

                                    <li id="logout" class="dropdown">
                                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                                            <span class="fa fa-user fa-fw"></span>
                                            <?= Yii::$app->user->identity->username; ?>
                                            <span class="fa fa-caret-down"></span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="<?= Url::toRoute(['cabinet/info/index']); ?>" data-method="post">
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
                                    </li>

                                <?php } ?>
                                <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
                                    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
                                    // 'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_DROPDOWN,
                                    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_LARGE,
                                    'itemTemplate' => '<a href="{link}" title="{language}"><i class="{language}"></i> {name}</a>',
                                    'activeItemTemplate' => '<a href="{link}" title="{language}" class="active"><i class="{language}"></i> {name}</a>',
                                    'parentTemplate' => '<li id="lang-picker" class="language-picker button-list {size}">{items}</li>',
                                ]); ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                <!-- </div> --></div>

        </div>
    </div>
    <!-- Content -->
    <div id="content">
        <div class="container">

            <?= $content ?>

        </div>
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
