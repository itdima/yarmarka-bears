<?php
/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 11.03.2016
 * Time: 16:45
 */
namespace app\modules\bears\models;

use Yii;


class commonModel extends \yii\db\ActiveRecord
{
    public $uploadFilePath;

    public function init()
    {
        $this->uploadFilePath = Yii::getAlias('@webroot') . '/upload/';
        parent::init();
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
     * Прикрепление изображения к модели
     * @return image
     */
    public function uploadImage($image)
    {
        $tempName =  $this->uploadFilePath . Yii::$app->security->generateRandomString() . '.' . $image->extension;
        $image->saveAs($tempName);
        $uploadedImage = $this->attachImage($tempName);
        if ($uploadedImage && file_exists($tempName)) {
            unlink($tempName);
        }
        return $uploadedImage;
    }
}