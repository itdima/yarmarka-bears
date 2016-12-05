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
class Message extends \yii\db\ActiveRecord
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
}
