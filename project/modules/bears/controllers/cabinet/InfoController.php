<?php

namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\UserProfile;
use Yii;
use app\models\Country;
use yii\web\UploadedFile;

class InfoController extends \app\modules\bears\controllers\CommonController
{
    public $layout = '_cabinet.php';
    /**
     * Displays cabinet page.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        /*
        if (!\Yii::$app->user->can('contact')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
        }
        */
        $profile = UserProfile::getProfile(Yii::$app->user->id);
        $name_lang = 'name_' . Yii::$app->language;
        $country = Country::find()->select([$name_lang, 'alpha'])->all();
        $arr = [];
        foreach ($country as $c) {
            $arr[$c['alpha']] = $c[$name_lang];
        }
        //Фотография и информация о пользователе
        if (Yii::$app->request->post('UserProfile') && $profile->load(Yii::$app->request->post())) {
            $profile->images = UploadedFile::getInstance($profile, 'images');
            if ($profile->images) {
                $profile->removeImages();
                $profile->uploadImage($profile->images,'uploads');
            }
            if ($profile->save()){
                $this->setFlash(\Yii::t('app','Сохранено успешно'));
            } else {
                $this->setFlash(\Yii::t('app','Извините, во время сохранения произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
            }
        }

        return $this->render('index', ['model' => $profile, 'country' => $arr]);
    }
}