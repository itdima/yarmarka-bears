<?php

namespace app\modules\bears\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "blog".
 *
 * @property integer $id
 * @property string $article
 */
class Blog extends commonModel
{

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
            [['user'], 'integer'],
            [['title'],'required'],
            [['article','title'], 'string'],
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
            'article' => Yii::t('app','Статья'),
            'title' => Yii::t('app','Заголовок'),
        ];
    }
}
