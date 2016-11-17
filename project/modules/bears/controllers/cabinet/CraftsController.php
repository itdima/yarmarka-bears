<?php

namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\Crafts;
use app\modules\bears\models\Tags;
use app\modules\bears\models\TagsCrafts;
use Yii;
//use yii\data\Pagination;
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


    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \app\modules\bears\models\CraftsSearch();
        $query=null;
        if (\Yii::$app->request->isPost && $searchModel->load(\Yii::$app->request->post())) {
            if ($searchModel->validate()) {
                $query = $searchModel->search(\Yii::$app->request->post());

            };
        };
        if (!isset($query)){
            $query = $searchModel->search();
        }
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 12]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', ['models' => $models,  'pages' => $pages, 'searchModel' => $searchModel]);
    }

    /**
     * Creates a new Craft model.
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Crafts();
        if (\Yii::$app->request->isPost && $model->load(\Yii::$app->request->post())) {
            $model->user = Yii::$app->user->id;
            if ($model->save()) {
                $model->images = UploadedFile::getInstances($model, 'images');
                foreach ($model->images as $image) {
                    $model->uploadImage($image);
                }
                $this->setFlash(\Yii::t('app','Сохранено успешно'));
                return $this->redirect(['index']);
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
        //$item = Yii::$app->request->post('item');
        $model = $this->findModel($item);
        //POST
        if (\Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                //Обрабатываем картинки
                $model->images = UploadedFile::getInstances($model, 'images');
                foreach ($model->images as $image) {
                    $model->uploadImage($image);
                }
                //Выводим сообщения
                $this->setFlash(\Yii::t('app','Сохранено успешно'));
                return $this->redirect(['index']);
            } else {
                $this->setFlash(\Yii::t('app','Извините, во время сохранения произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
            }

            //return $this->redirect(Yii::$app->request->referrer);

        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }
    /**
     * Delete tag of Craft model.
     * @return mixed
     */
    public function actionDeletetag(){
        if (Yii::$app->request->isAjax) {
            $tagname = Yii::$app->request->post('id_tag');
            $id_craft = Yii::$app->request->post('id_craft');
            $tag = Tags::find()->where('tagname = :tagname',[':tagname'=>$tagname])->one();
            $this->unbinTags($id_craft,$tag->id);
        }
    }

    private function unbinTags($id_craft,$id_tag=null){
        $tc_models = TagsCrafts::find()->where('id_craft = :id_craft',[':id_craft' => $id_craft]);
        if (!empty($id_tag)){
            $tc_models->andWhere('id_tag = :id_tag',[':id_tag' => $id_tag]);
        }
        $models = $tc_models->all();
        foreach($models as $tc){
            $tc->delete();
        }
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
    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $model = $this->findModel($id);
        $model->removeImages();
        $this->unbinTags($model->id);
        $model->delete();
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
