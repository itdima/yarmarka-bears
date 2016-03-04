<?php

namespace app\modules\bears\models;

use Yii;

/**
 * This is the model class for table "bears_products".
 *
 * @property integer $id
 * @property integer $user
 * @property string $title
 * @property string $description
 * @property double $price
 *
 * @property BearsUserProfile $user0
 */
class Crafts extends \yii\db\ActiveRecord
{
    public $images;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crafts}}';
    }



    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'image' => [
                'class' => '\rico\yii2images\behaviors\ImageBehave',
            ],
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
                'value' => new \yii\db\Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user'], 'integer'],
            [['price'], 'number'],
            [['title','price','images','currency'],'required'],
            [['currency'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
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
            'user' => 'User',
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'images' => 'Photo',
            'currency' => 'Currency'
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
