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
class Crafts extends commonModel
{
    public $tags_field; //теги текущей модели
    public $list_tags; //список всех тегов
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%crafts}}';
    }



    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user'], 'integer'],
            [['price'], 'number'],
            [['tags_field'], 'each', 'rule' => ['string']],
            [['title','price','currency'],'required'],
            [['currency'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['images'], 'file', 'maxFiles' => 5],
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
            'title' => Yii::t('app','Заголовок'),
            'description' => Yii::t('app','Описание'),
            'price' => Yii::t('app','Цена'),
            'images' => Yii::t('app','Фото'),
            'currency' => Yii::t('app','Валюта'),
            'tags_field' => Yii::t('app','Тэги'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser0()
    {
        return $this->hasOne(BearsUserProfile::className(), ['id_user' => 'user']);
    }



    public function getTagsCrafts()
    {
        return $this->hasMany(TagsCrafts::className(), ['id_craft' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->via('tagsCrafts');
    }

/*
    public function getTags()
    {
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->viaTable('bears_tags_crafts', ['id_craft' => 'id']);
    }
*/

}
