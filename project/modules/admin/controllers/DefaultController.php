<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\admin\models\LoginForm;


class DefaultController extends Controller
{

    private $act;

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    \Yii::$app->user->logout();
                    return \Yii::$app->user->loginRequired();
                },
                /*
                'matchCallback' => function ($rule, $action) {
                    return !Yii::$app->user->can('admin');
                },
                */
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
     * Вывод всплывающих сообщений
     */
    private function setFlash($text, $type = 'success', $title = 'Complete!')
    {
        Yii::$app->getSession()->setFlash('productSaved', [
            'type' => $type,
            'duration' => 3000,
            'message' => $text,
            'title' => $title,
            // 'icon' => 'glyphicon glyphicon-ok-sign',
            'positonY' => 'top',
            'positonX' => 'right'
        ]);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            //return $this->goHome();
            return $this->redirect(\Yii::$app->urlManager->createUrl(['admin/default/index']));
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(\Yii::$app->urlManager->createUrl(['admin/default/index']));
            // return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(\Yii::$app->urlManager->createUrl(['admin/default/login']));

        //return $this->goHome();//redirect(\Yii::$app->urlManager->createUrl(['admin/default/index']));
    }


}
