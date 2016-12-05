<?php

namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\UserProfile;
use Yii;
use app\models\Country;
use yii\web\Response;
use yii\web\UploadedFile;


class InfoController extends \app\modules\bears\controllers\CommonController
{
    public $layout = '_cabinet.php';


    public function actions()
    {
        return [
            'crop'=>[
                'class' => 'hyii2\avatar\CropAction',
                'config'=>[
                    'bigImageWidth' => '200',
                    'bigImageHeight' => '200',
                    'middleImageWidth'=> '100',
                    'middleImageHeight'=> '100',
                    'smallImageWidth' => '50',
                    'smallImageHeight' => '50',

                    'uploadPath' => 'upload',
                ],
                'modelUser'=>UserProfile::getProfile(Yii::$app->user->id),
            ]
        ];

    }

    /**
     * Метод загрузки автара пользователя.
     *
     */
    public function actionAvatar()
    {
        if (Yii::$app->request->isPost) {
            $profile = UserProfile::getProfile(Yii::$app->user->id);
            $profile->image = UploadedFile::getInstanceByName($profile, 'image');
            $post = Yii::$app->request->post();
            $profile->imageData = $post['UserProfile']['imageData'];
            $profile->config = $this->config;
            if ($profile->image) {
                $profile->removeImages();
                $profile->uploadImage();
            }
            $result = [
                'state'=>200,
                'message'=>'succeed!',
                'result'=>$profile->getImage()->getUrl(),
            ];
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $result;
        }
    }

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
        if (Yii::$app->request->post('UserProfile') && $profile->load(Yii::$app->request->post())) {
            if ($profile->save()) {
                $this->setFlash(\Yii::t('app', 'Сохранено успешно'));
            } else {
                $this->setFlash(\Yii::t('app', 'Извините, во время сохранения произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
            }
        }
        return $this->render('index', ['model' => $profile, 'country' => $arr]);
    }
}