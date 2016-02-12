<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "country".
 *
 * @property integer $id
 * @property integer $number
 * @property string $alpha
 * @property integer $calling
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_uk
 */
class Country extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'alpha', 'calling', 'name_en', 'name_ru', 'name_uk'], 'required'],
            [['number', 'calling'], 'integer'],
            [['alpha'], 'string', 'max' => 2],
            [['name_en', 'name_ru', 'name_uk'], 'string', 'max' => 255],
            [['alpha'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'alpha' => 'Alpha',
            'calling' => 'Calling',
            'name_en' => 'Name En',
            'name_ru' => 'Name Ru',
            'name_uk' => 'Name Uk',
        ];
    }
}
