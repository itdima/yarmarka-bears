<?php

namespace app\modules\bears\models;

use app\models\Country;
use app\models\User;
use Yii;


/**
 * This is the model class for table "bears_user_profile".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $about
 * @property string $images
 *
 * @property User $idUser
 */
class UserProfile extends \yii\db\ActiveRecord
{
    //const prefix = 'bears';
    public $images;



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user'], 'integer'],
            [['about'], 'string', 'max' => 500],
            [['country'], 'string', 'max' => 2],
            [['images'], 'file', 'maxFiles' => 0],
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
            'id_user' => 'Id User',
            'about' => 'About',
            'country' => 'Country',
            'images' => 'Photo',
        ];
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
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getProfile($idUser)
    {
        $profile = UserProfile::findOne(['id_user'=>$idUser]);
        if ($profile === null){
            $profile = new UserProfile();
        }
        if (!$profile->id_user){
            $profile->id_user = $idUser;
        }
        return $profile;
    }

    /**
     * Прикрепление изображения к модели
     * @return image
     */
    public function uploadImage($image)
    {
        $tempName = Yii::$app->basePath . '/temp_uploads/' . Yii::$app->security->generateRandomString() .'.'. $image->extension;
        $image->saveAs($tempName);
        $uploadedImage = $this->attachImage($tempName);
        if ($uploadedImage && file_exists($tempName)) {
            unlink($tempName);
        }
        return $uploadedImage;
    }


}
