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
class UserProfile extends commonModel
{
    public $image;

    public function behaviors()
    {
        return array_merge(parent::behaviors(),[
/*
            'uploadBehavior' => [
                'class' => \vova07\fileapi\behaviors\UploadBehavior::className(),
                'attributes' => [
                    'image' => [
                        'path' => $this->uploadFilePath,
                        'tempPath' => $this->uploadFilePath,
                    ],
                ]
            ],
*/
        ]);
    }

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
          //  [['image'], 'file','extensions' => 'jpeg, gif, png, jpg'],
           // [['image'], 'file'],
            [['created_at','updated_at','image'],'safe'],
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
            'image' => 'Photo',
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




}
