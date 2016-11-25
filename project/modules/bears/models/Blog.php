<?php
namespace app\modules\bears\models;

use Yii;


class Blog extends commonModel
{
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert){
                $this->user = \Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%blogs}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'],'required'],
            [['title'], 'string', 'max' => 255],
            [['article'], 'string'],
            [['created_at','updated_at'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => Yii::t('app','Пользователь'),
            'title' => Yii::t('app','Заголовок'),
            'article' => Yii::t('app','Статья'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(BearsUserProfile::className(), ['id_user' => 'user']);
    }

}
