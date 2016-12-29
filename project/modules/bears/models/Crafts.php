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
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!$insert){
                $this->addTags($this->tags);
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $this->addTags($this->tags);
        }
    }

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
            [['user','type'], 'integer'],
            [['price'], 'number'],
            [['title','price','currency','type'],'required'],
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
            'type' => Yii::t('app','Вид'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['id_user' => 'user']);
    }



    public function getTagsCrafts()
    {
        return $this->hasMany(TagsCrafts::className(), ['id_craft' => 'id']);
    }


    public function getTags()
    {
        $t = $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->via('tagsCrafts')->all();
        $res=null;
        foreach ($t as $tag){
            $res[] = $tag->tagname;
        }
       return $res;

    }

    public function getTagsRel(){
        return $this->hasMany(Tags::className(), ['id' => 'id_tag'])
            ->via('tagsCrafts');
    }

    public function setTags($tagnames){
        $this->tags = $tagnames;
    }


    /**
     * @return array of Tags
     * Выполняет добавление и привязку тегов к модели craft
     */
    private function addTags($tagnames){
        if (!empty($tagnames)) {
            foreach ($tagnames as $tagname) {
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
        }
    }
}
