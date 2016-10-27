<?php

namespace app\modules\bears\models;

use Yii;

/**
 * This is the model class for table "bears_tags_crafts".
 *
 * @property integer $ID
 * @property integer $id_craft
 * @property integer $id_tag
 */
class TagsCrafts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tags_crafts}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_craft', 'id_tag'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'id_craft' => 'Id Craft',
            'id_tag' => 'Id Tag',
        ];
    }
}
