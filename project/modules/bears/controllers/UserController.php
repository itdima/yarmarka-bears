<?php
namespace app\modules\bears\controllers;



use app\models\Country;
use app\modules\bears\models\UserProfile;
use app\modules\bears\models\User;
use Yii;
use app\modules\bears\models\LoginForm;
use app\modules\bears\models\PasswordResetRequestForm;
use app\modules\bears\models\ResetPasswordForm;
use app\modules\bears\models\SignupForm;
use yii\base\InvalidParamException;
use yii\db\ActiveRecord;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;


/**
 * Site controller
 */
class UserController extends \app\controllers\CommonController
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'minLength' => 5,
                'maxLength' => 5,
                'transparent' => true,
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'captcha'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /*
    * Действие обрабатывающее вход пользователя (ajax)
    */
    public function actionLogin()
    {
        $model = new LoginForm();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            //\Yii::$app->response->format = Response::FORMAT_JSON;
            if (!$model->validate()) {
                return $this->renderAjax('/user/forms/_loginForm', ['model' => $model]);
            }
            if ($model->login()){
                $success=true;
                return json_encode($success);
            } else {
                return $this->renderAjax('/user/forms/_loginForm', ['model' => $model]);
            }
        }
    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        parent::actionRefresh();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays cabinet page.
     *
     * @return mixed
     */
    public function actionCabinet($item=null,$id=null)
    {
        /*
        if (!\Yii::$app->user->can('contact')) {
            throw new \yii\web\ForbiddenHttpException('You are not allowed to access this page');
        }
        */
        $profile = UserProfile::getProfile(Yii::$app->user->id);
        $name_lang = 'name_'.Yii::$app->language;
        $country = Country::find()->select([$name_lang,'alpha'])->all();
        $arr=[];
        $data='';
        foreach ($country as $c){
            $arr[$c['alpha']] = $c[$name_lang];
        }
        if (Yii::$app->request->isPost && $profile->load(Yii::$app->request->post())){
            $profile->images = UploadedFile::getInstance($profile, 'images');
            if ($profile->images){
                $profile->removeImages();
                $profile->uploadImage($profile->images);
            }
            $profile->save();
        }
        if ($item && $id){
            $data = $this->run($item.'/'.$id);
        }

        return $this->render('cabinet',['model'=>$profile,'country'=>$arr, 'data' => $data]);
    }



}