<?php

namespace app\modules\bears\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "bears_tags".
 *
 * @property integer $id
 * @property string $tagname
 */
class Tags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tagname'], 'string', 'max' => 255],
            [['tagname'], 'filter', 'filter' => function($value){
                $res = str_replace(' ', '', $value);
                $res = '#'.str_replace('#', '', $res);
                return $res;
            }]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagname' => 'Tagname',
        ];
    }

    public static function getTags($tags = null){
        $tags_arr = array();
        if ($tags===null){
            $tags = self::find()->select('tagname')->all();
            foreach ($tags as $t) {
                $tags_arr[$t['tagname']] = $t['tagname'];
            }
        } else {
            foreach ($tags as $f) {
                $tags_arr[] = $f['tagname'];
            }
        }
        return $tags_arr;
    }

    public static function setNewTagsFromArray(array $tags, $idcraft){
        foreach ($tags as $t){
            if (!self::find()->where('tagname=:tagname',[':tagname'=>$t])->exists()){ //если тега нет
                //добавить тег
                $tag = new Tags();
                $tag->tagname = $t;
                if ($tag->save()) {
                    //добавить связь
                    $tc = new TagsCrafts();
                    $tc->id_craft = $idcraft;
                    $tc->id_tag = $tag->id;
                    $tc->save();
                }
            }
        }
    }
}
