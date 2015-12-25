<?php

namespace app\modules\bears;
use Yii;
use yii\helpers\Url;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\bears\controllers';

    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/web.php'));
/*
        Yii::$app->set('user', [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\bears\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'site/index',
            'identityCookie' => ['name' => 'bears', 'httpOnly' => true],
            'idParam' => 'bears_id',
        ]);

        Yii::$app->set('languagepicker', [
            'class' => 'lajax\languagepicker\Component',
            'languages' => ['en', 'ru'],
        ]);
*/
        //USER
        Yii::$app->user->identityClass = 'app\modules\bears\models\User';
        Yii::$app->user->enableAutoLogin = true;
        Yii::$app->user->loginUrl = 'site/index';
        Yii::$app->user->identityCookie = ['name' => 'bears', 'httpOnly' => true];
        Yii::$app->user->idParam = 'bears_id';
        //language
        Yii::$app->languagepicker->languages = ['en', 'ru'];

        //error
        Yii::$app->errorHandler->errorAction = 'bears/site/error';

    }
}
