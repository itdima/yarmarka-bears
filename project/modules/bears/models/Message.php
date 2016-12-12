<?php

namespace app\modules\bears\models;

use Yii;

/**
 * This is the model class for table "bears_messages".
 *
 * @property integer $id
 * @property integer $sender
 * @property integer $receiver
 * @property string $message
 * @property integer $isnew
 * @property integer $created_at
 * @property integer $updated_at
 */
class Message extends commonModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%messages}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sender', 'receiver', 'isnew', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sender' => Yii::t('app','Отправитель'),
            'receiver' => Yii::t('app','Получатель'),
            'message' => Yii::t('app','Сообщение'),
            'isnew' => Yii::t('app','Новое'),
            'created_at' => Yii::t('app','Создано'),
            'updated_at' => Yii::t('app','Отредактировано'),
        ];
    }

    /**
     * Функция подсчета новых сообщений
     */
    public static function getNewMessageCount($sender = null){
        $models = Message::find();
        $models->andWhere('receiver = :receiver',[':receiver'=>Yii::$app->user->id]);
        $models->andWhere('isnew = 1');
        if (!empty($sender)){
            $models->andWhere('sender = :sender',[':sender'=>$sender]);
        }
        return $models->count();
    }

    public static function setNewToOldMessages($sender){
        if (!empty($sender)) {
            $query = \Yii::$app->db->createCommand()->update(
                Yii::$app->db->tablePrefix . "messages",
                ['isnew' => '0'],
                '(receiver = :me) and (sender = :sender)',
                [':me' => Yii::$app->user->id, ':sender' => $sender]
            );
            /*
            $query = Yii::$app->db->createCommand("
                                update ".Yii::$app->db->tablePrefix."messages
                                set isnew=0
                                where (receiver = :me) and (sender = :sender)
                                ");

            $query->bindValue(':me',Yii::$app->user->id);
            $query->bindValue(':sender',$sender);
            */
            return $query->execute();
        }
    }
}
