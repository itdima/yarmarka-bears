<?php

namespace app\modules\bears\controllers\cabinet;

use app\modules\bears\models\Blog;
use vova07\imperavi\actions\GetAction;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


class BlogController extends \app\modules\bears\controllers\CommonController
{
    public $layout = '_cabinet.php';
    private $url;
    private $path;

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

    public function actions()
    {
        return [

            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url'=>$this->url,
                'path'=>$this->path,
               // 'url' => Yii::getAlias('@web') . '/images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/',
              //  'path' => 'images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/',
            ],
            'images-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url'=>$this->url,
                'path'=>$this->path,
               // 'url' => Yii::getAlias('@web') . '/images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/',
               // 'path' => 'images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/',
                'type' => GetAction::TYPE_IMAGES,
            ],
            /*
            'files-get' => [
                'class' => 'vova07\imperavi\actions\GetAction',
                'url' => 'files/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/blog/', // Or absolute path to directory where files are stored.
                'type' => '1',//GetAction::TYPE_FILES,
            ],
            'file-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => '/files/blog/', // Directory URL address, where files are stored.
                'path' => '@webroot/files/blog/' // Or absolute path to directory where files are stored.
            ],
            */
        ];
    }

    public function actionParamImageUpload($id){
        $this->url = Yii::getAlias('@web') . '/images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/'.$id.'/';
        $this->path = 'images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/'.$id.'/';
        return $this->runAction('image-upload');
    }

    public function actionParamImagesGet($id){
        $this->url = Yii::getAlias('@web') . '/images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/'.$id.'/';
        $this->path = 'images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/'.$id.'/';
        return $this->runAction('images-get');
    }


    public function actionImperaviImageDelete()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->post('url')) {
            $path_parts = pathinfo(Yii::$app->request->post('url'));
            $path = Yii::getAlias('@webroot') . '/images/imperavi/blog/' . $path_parts['basename'];
            if (file_exists($path)) {
                unlink($path);
            }
        }

    }


    /**
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new \app\modules\bears\models\BlogSearch();
        $query = null;
        if (\Yii::$app->request->isPost && $searchModel->load(\Yii::$app->request->post())) {
            if ($searchModel->validate()) {
                $query = $searchModel->search(\Yii::$app->request->post());

            };
        };
        if (!isset($query)) {
            $query = $searchModel->search();
        }
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 20]);
        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', ['models' => $models, 'pages' => $pages, 'searchModel' => $searchModel]);
    }

    /**
     * Creates a new Craft model.
     * @return mixed
     */
    public function actionAdd()
    {
        $model = new Blog();
        $model->user = Yii::$app->user->id;
        if ($model->save(false)) {
            return $this->redirect(['update', 'item' => $model->id]);
        } else {
            $this->setFlash(\Yii::t('app', 'Извините, во время операции произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
        }
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
                $this->setFlash(\Yii::t('app', 'Сохранено успешно'));
                return $this->redirect(['index']);
            } else {
                $this->setFlash(\Yii::t('app', 'Извините, во время сохранения произошла ошибка'), 'warning', 'glyphicon glyphicon-remove-sign');
            }

            //return $this->redirect(Yii::$app->request->referrer);

        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }


    private function removeDirectory($dir) {
        if ($objs = glob($dir."/*")) {
            foreach($objs as $obj) {
                is_dir($obj) ? removeDirectory($obj) : unlink($obj);
            }
        }
        rmdir($dir);
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
        $path = 'images/' . Yii::$app->params['currentWorld'] . '/User' . Yii::$app->user->id . '/imperavi/blog/'.$id.'/';
        $this->removeDirectory($path);
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
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
