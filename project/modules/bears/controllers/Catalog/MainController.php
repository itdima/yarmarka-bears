<?php
namespace app\modules\bears\controllers\catalog;

use Yii;



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
}