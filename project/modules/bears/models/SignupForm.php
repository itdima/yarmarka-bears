<?php
namespace app\modules\bears\models;

use Yii;
use app\modules\bears\models\User;
use yii\base\Model;


/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 1],

            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t('app','Введенные пароли должны совпадать')],
            ['password_repeat', 'required'],

            ['verifyCode', 'captcha','captchaAction' => '/bears/user/captcha'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => \Yii::t('app', 'Логин'),
            'email'=>\Yii::t('app', 'email'),
            'password' =>\Yii::t('app', 'Пароль'),
            'password_repeat' =>\Yii::t('app', 'Повторите пароль'),
            'verifyCode' => \Yii::t('app', 'Код подтверждения'),
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new \app\modules\bears\models\User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            if ($user->save()) {
                $auth = Yii::$app->authManager;
                $authorRole = $auth->getRole('client');
                $auth->assign($authorRole, $user->getId());
                return $user;
            }
        }
        return null;
    }
}
