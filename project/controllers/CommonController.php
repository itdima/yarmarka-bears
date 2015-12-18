<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;


/**
 * Site controller
 */
class CommonController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Главная страница портала
     *
     * @return mixed
     */
    public function actionRefresh()
    {
        return $this->redirect(Yii::$app->request->referrer);
    }


    /**
     * Главная страница портала
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



}