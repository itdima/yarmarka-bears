<?php
namespace app\modules\bears\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends \app\models\User
{
    const prefix = 'bears';
    public static $images;
    public static $about;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['about'], 'string', 'max' => 500],
            [['images'], 'file', 'maxFiles' => 0],
            [['prefix'], 'safe'],
            //[['created_at','updated_at','paypal_button_code'],'safe'],
        ];
    }

    public function setAttr($id, $params){
        $user = new User();
        $user->findOne($id)->updateAttributes([
            'about'=>$params['about'],
        ]);
    }
}
