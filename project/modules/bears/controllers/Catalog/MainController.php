<?php
namespace app\modules\bears\controllers\catalog;

use app\models\Country;
use app\modules\bears\models\UserProfile;
use Yii;
use app\modules\bears\models\Crafts;



/**
 * Catalog/Main controller
 */
class MainController extends \app\modules\bears\controllers\CommonController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            /*
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            */
        ];
    }


    public function actionIndex()
    {
        $searchModel = new \app\modules\bears\models\Catalog();
        $query=null;
        if (\Yii::$app->request->isPost && $searchModel->load(\Yii::$app->request->post())) {
            if ($searchModel->validate()) {
                $query = $searchModel->search(\Yii::$app->request->post());

            };
        };
        if (!isset($query)){
            $query = $searchModel->search();
        }
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', ['models' => $models,  'pages' => $pages, 'searchModel' => $searchModel]);
    }

    public function actionShowCraft($item){
        $model = $this->findCraft($item);
        return $this->render('show-craft',['model'=>$model]);
    }

    public function actionShowUser($item){
        $model = $this->findUser($item);
        $country = $this->getCountry($model->country);
        return $this->render('show-user',['model'=>$model,'country'=>$country]);
    }

    protected function getCountry($user_lang){
        $name_lang = 'name_' . Yii::$app->language;
        $country = Country::find()->select([$name_lang])->where('alpha = :alpha',[':alpha'=>$user_lang])->one();
        return $country[$name_lang];
    }

    protected function findCraft($id)
    {
        if (($model = Crafts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findUser($id)
    {
        if (($model = UserProfile::find()->where('id_user = :id',[':id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}