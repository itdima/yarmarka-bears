<?php

namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\Crafts;
use Yii;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * ProductsController implements the CRUD actions for Products model.
 */
class CraftsController extends \app\controllers\CommonController
{

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

    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $models = Crafts::find()
            ->where('user = :user', [':user' => Yii::$app->user->id])
            ->all();
        return $this->renderAjax('index', ['models' => $models]);
    }


    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Crafts();
        //POST
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $model->user = Yii::$app->user->id;
            if ($model->save()) {
                $model->images = UploadedFile::getInstances($model, 'images');
                foreach ($model->images as $image) {
                    $model->uploadImage($image,'uploads');
                }

                $this->redirect(Url::toRoute(['user/cabinet','item'=>'crafts','id'=>'index']));
                return $this->renderAjax('index', [
                    'model' => $model,
                ]);
            }
        }
        //PJAX
        if (\Yii::$app->request->isPjax){
            return $this->renderAjax('create', [
                'model' => $model,
            ]);

        }

        //GET
        if (\Yii::$app->request->isGet){
            return $this->renderPartial('create', ['model' => $model,]);
        }



    }



    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
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
