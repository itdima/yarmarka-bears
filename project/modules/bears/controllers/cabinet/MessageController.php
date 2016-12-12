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
        $user = Yii::$app->user->id;
        //Pjax при выборе собеседника
        if (Yii::$app->request->isPjax) {
            $userid = Yii::$app->request->post('user');
            if (!empty($userid)) {
                $messages = Message::find()
                    ->andWhere('((sender = :sender) and (receiver = :currentuser1))', [':sender' => $userid, ':currentuser1' => $user])
                    ->orWhere('((receiver = :receiver) and (sender = :currentuser2))', [':receiver' => $userid, ':currentuser2' => $user])
                    ->orderBy('created_at')
                    ->all();
                Message::setNewToOldMessages($userid);
                return $this->renderAjax('conversation', ['models' => $messages, 'me' => $user, 'notme' => $userid]);
            }
        }

        $query = Yii::$app->db->createCommand("
                                select *
                                from " . Yii::$app->db->tablePrefix . "messages
                                WHERE sender = :sender or receiver = :receiver
                                group by sender + receiver
                                order by isnew DESC, created_at DESC
                                ");
        $query->bindValue(':sender',$user);
        $query->bindValue(':receiver',$user);
       // echo $query->getRawSql();
        $models = $query->queryAll();
        $models_user = UserProfile::find();
        $fl=0;
        foreach ($models as $model) {
        //    if ($model['sender'] != $user) {
                $models_user->orWhere(['id_user' => $model['sender']]);
                $fl=1;
        //    };
        //    if ($model['receiver'] != $user) {
                $models_user->orWhere(['id_user' => $model['receiver']]);
                $fl=1;
        //    };
        };
        if ($fl == 1){
            $user_profiles = $models_user->all();
        } else {
            $user_profiles = null;
        }

        return $this->render('index', ['users' => $user_profiles]);
    }

    /**
     * Отправка сообщения
     */
    public function actionSend()
    {
        if (Yii::$app->request->isAjax) {
            if (!empty(Yii::$app->request->post('text')) and (!empty(Yii::$app->request->post('receiver')))) {
                $model = new Message();
                $model->message = Yii::$app->request->post('text');
                $model->receiver = Yii::$app->request->post('receiver');
                $model->sender = Yii::$app->user->id;
                $model->isnew = 1;
                if ($model->save()) {
                    echo Yii::$app->request->post('receiver');
                } else {
                    echo '0';
                }
            }
        }
    }

    public function actionRefreshCount(){
        if (Yii::$app->request->isAjax) {
            if (!empty(Yii::$app->request->post('user'))){
                return Message::getNewMessageCount(Yii::$app->request->post('user'));
            }
        }
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