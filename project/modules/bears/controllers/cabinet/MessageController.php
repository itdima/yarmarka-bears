<?php
namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\Message;
use app\models\User;
use Yii;
use yii\filters\VerbFilter;

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
        $user = Yii::$app->user->id;
        $query = Yii::$app->db->createCommand("
                                select *
                                from bears_messages
                                WHERE sender = $user or receiver = $user
                                group by sender + receiver");
        $models = $query->queryAll();

        $users = [];
        foreach ($models as $model) {
            if ($model['sender'] != $user) {
                $users[] = $model['sender'];
            };
            if ($model['receiver'] != $user) {
                $users[] = $model['receiver'];
            };
        }
        $users = User::find($users)->select(['username'])->all();
        return $this->render('index', ['users' => $users]);
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