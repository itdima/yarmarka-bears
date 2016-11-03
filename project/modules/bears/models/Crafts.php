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
         //   [['tags_field'], 'each', 'rule' => ['string']],
            [['title','price','currency'],'required'],
            [['currency'], 'string', 'max' => 3],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['images'], 'file', 'maxFiles' => 5],
            [['created_at','updated_at','tags'],'safe'],
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
            'tags' => Yii::t('app','Тэги'),
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

    public function setTags($tagnames){
        foreach ($tagnames as $tagname){
            $tag = Tags::find()
                ->where('tagname = :tagname', [':tagname' => Tags::getEditedTag($tagname)])
                ->one();
            if (!empty($tag)) {

                $tag_craft = TagsCrafts::find()
                    ->where('id_tag=:id_tag and id_craft=:id_craft', [':id_tag' => $tag->id, ':id_craft' => $this->id])
                    ->one();
                if (!$tag_craft) {
                    $tc = new TagsCrafts();
                    $tc->id_craft = $this->id;
                    $tc->id_tag = $tag->id;
                    $tc->save();
                }
            } else {
                $tag = new Tags();
                $tag->tagname = $tagname;
                if ($tag->save()) {
                    $tc = new TagsCrafts();
                    $tc->id_craft = $this->id;
                    $tc->id_tag = $tag->id;
                    $tc->save();
                }
            }
        }
        $res=null;;
        foreach ($this->tags as $tag){
           $res[] = $tag->tagname;
        }
        $this->tags = $res;

    }



}
