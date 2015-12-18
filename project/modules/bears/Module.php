<?php

namespace app\modules\bears;
use Yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\bears\controllers';

    public function init()
    {
        parent::init();

        \Yii::configure($this, require(__DIR__ . '/config/web.php'));

        Yii::$app->set('user', [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\bears\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => 'site/index',
            'identityCookie' => ['name' => 'bears', 'httpOnly' => true],
            'idParam' => 'bears_id',
        ]);


    }
}
