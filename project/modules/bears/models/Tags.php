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
                return self::getEditedTag($value);
            }],
        ];
    }

    public function getTagsCrafts()
    {
        return $this->hasMany(TagsCrafts::className(), ['id_tag' => 'id']);
    }

    public function getCrafts()
    {
        return $this->hasMany(Crafts::className(), ['id' => 'id_craft'])
            ->via('tagsCrafts');
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

    /**
     * Функция изменения тэга (убираем пробелы, добавляем #)
     */
    public static function getEditedTag($tag){
        $res = str_replace(' ', '', $tag);
        $res = '#'.str_replace('#', '', $res);
        return $res;
    }

    public static function getTagNamesAsArray(){
            $tags = self::find()->select('tagname')->all();
            foreach ($tags as $t) {
               $tags_arr[$t['tagname']] = $t['tagname'];
            }
        return $tags_arr;
    }


}
