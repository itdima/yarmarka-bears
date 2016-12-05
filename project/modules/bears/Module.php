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

        Yii::$app->params['currentWorld']='bears';

        $this->setModules([
            'yii2images'=>[
                'class' => '\rico\yii2images\Module',
                //if you cant avoid permission errors you have to create "images" folder in web root manually and set 777 permissions
                'imagesStorePath' => '@webroot/images/'.\Yii::$app->params['currentWorld'].'/'.'User'.\Yii::$app->user->id.'/yii2images_store', //path to origin images
                'imagesCachePath' => '@webroot/images/'.\Yii::$app->params['currentWorld'].'/'.'User'.\Yii::$app->user->id.'/yii2images_cache',  //path to resized copies
                'graphicsLibrary' => 'GD', //but really its better to use 'Imagick'
                'placeHolderPath' => '@webroot/images/'.\Yii::$app->params['currentWorld'].'/placeholder.jpg', // if you want to get placeholder when image not exists, string will be processed by Yii::getAlias

            ]
        ]);



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
        /*
        Yii::$app->user->identityClass = 'app\modules\bears\models\User';
        Yii::$app->user->enableAutoLogin = true;
        Yii::$app->user->loginUrl = 'site/index';
        Yii::$app->user->identityCookie = ['name' => 'bears', 'httpOnly' => true];
        Yii::$app->user->idParam = 'bears_id';
        */
        //language
        Yii::$app->languagepicker->languages = ['en', 'ru'];

        //DB
        Yii::$app->db->tablePrefix = Yii::$app->params['currentWorld'].'_';

        //error
        Yii::$app->errorHandler->errorAction = Yii::$app->params['currentWorld'].'/site/error';

    }
}
