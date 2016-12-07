<?php
namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\Message;
use app\models\User;
use app\modules\bears\models\UserProfile;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;

class MessageController extends \app\modules\bears\controllers\CommonController
{
    public $layout = '_cabinet.php';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isPjax) {
            $userid = Yii::$app->request->post('user');
            if (!empty($userid)) {
                return $this->renderAjax('conversation', ['user' => $userid]);
            }
        }
        $user = Yii::$app->user->id;
        $query  = Yii::$app->db->createCommand("
                                select *
                                from bears_messages
                                WHERE sender = $user or receiver = $user
                                group by sender + receiver");
        $models = $query->queryAll();
        $models_user = UserProfile::find();
        foreach ($models as $model) {
            if ($model['sender'] != $user) {
                $models_user->orWhere(['id_user'=>$model['sender']]);
            };
            if ($model['receiver'] != $user) {
                $models_user->orWhere(['id_user'=>$model['receiver']]);
            };
        };
        $user_profiles = $models_user->all();
        return $this->render('index', ['users' => $user_profiles]);
    }


    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}