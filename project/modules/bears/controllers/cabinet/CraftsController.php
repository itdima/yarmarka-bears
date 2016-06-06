<?php

namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\Crafts;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use rico\yii2images\models\Image;



class CraftsController extends \app\modules\bears\controllers\CommonController {
    public $layout = '_cabinet.php';
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    private function getAllCrafts()
    {
        return Crafts::find()
            ->where('user = :user', [':user' => Yii::$app->user->id])
            ->all();
    }

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', ['models' => $this->getAllCrafts()]);
    }


    /**
     * Creates a new Craft model.
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Crafts();
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->user = Yii::$app->user->id;
            if ($model->save()) {
                $model->images = UploadedFile::getInstances($model, 'images');
                foreach ($model->images as $image) {
                    $model->uploadImage($image);
                }
                $this->setFlash(\Yii::t('app','Сохранено успешно'));
            } else {
                $this->setFlash(\Yii::t('app','Извините, во время сохранения произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing Craft model.
     * @param integer $p
     * @return mixed
     */
    public function actionUpdate($item)
    {
        $model = $this->findModel($item);
        //POST
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            //$model->user = Yii::$app->user->id;
            if ($model->save()) {
                $model->images = UploadedFile::getInstances($model, 'images');
                foreach ($model->images as $image) {
                    $model->uploadImage($image);
                }
                $this->setFlash(\Yii::t('app','Сохранено успешно'));
            } else {
                $this->setFlash(\Yii::t('app','Извините, во время сохранения произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Delete image of Craft model.
     * @return mixed
     */
    public function actionDeleteImage()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post('key', -1) >= 0) {
            $image = Image::findOne((int)Yii::$app->request->post('key'));
            $model = Crafts::findOne((int)Yii::$app->request->post('idmodel'));
            if ($model){
                $model->removeImage($image);
                //Если изображение главное - меняем его
                $newMainImg = Image::find()
                    ->where('itemId = :idmodel',[':idmodel'=>$model->id])
                    ->orderBy(['id' => SORT_ASC])
                    ->one()
                ;
                if ($newMainImg){
                    $newMainImg->isMain = 1;
                    $newMainImg->save();
                }
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $items = [];
            return $items;
        } else {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $items = ['error' => ['Ошибка удаления. Обратитесь к администратору.']];
            return $items;
        }
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Crafts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
