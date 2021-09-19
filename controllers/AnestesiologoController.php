<?php

namespace app\controllers;

use Yii;
use app\models\Anestesiologo;
use app\models\DiasSemanales;
use app\models\AnestesiologoSemana;

use app\models\AnestesiologoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
/**
 * AnestesiologoController implements the CRUD actions for Anestesiologo model.
 */
class AnestesiologoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Anestesiologo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnestesiologoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Anestesiologo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Anestesiologo #".$id,
                    'content'=>$this->renderAjax('vieww', [
                        'model' => $this->findModel($id),
                    ]),
                    'footer'=> Html::button('Cerrar',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function cargarDiasSemanales($semana,$model){
      foreach ($semana as $key => $id_semana) {
        $modelanestesiologo_semana = new AnestesiologoSemana();
        $modelanestesiologo_semana->id_anestesiologo=$model->id;
        $modelanestesiologo_semana->id_semana=$id_semana;
        $modelanestesiologo_semana->save();

      }
    }
    /**
     * Creates a new Anestesiologo model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Anestesiologo();

        $arraySemana = DiasSemanales::find()->where('habilitado = true')->orderBy("id")->all();
          $list= ArrayHelper::map($arraySemana, 'id', 'dia');
            if ($model->load($request->post()) && $model->save()) {
                (!isset($_POST["anestesiologo_semana"]) )? $semana=[]: $semana=$_POST["anestesiologo_semana"];

                $this->cargarDiasSemanales($semana,$model);

                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                  'list'=>  $list
                ]);
            }
    }

    /**
     * Updates an existing Anestesiologo model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        $arraySemana = DiasSemanales::find()->where('habilitado = true')->orderBy("id")->all();
          $list= ArrayHelper::map($arraySemana, 'id', 'dia');
            if ($model->load($request->post()) && $model->save()) {
                AnestesiologoSemana::deleteAll(['id_anestesiologo'=>$id]);
                (!isset($_POST["anestesiologo_semana"]) )? $semana=[]: $semana=$_POST["anestesiologo_semana"];

                $this->cargarDiasSemanales($semana,$model);
                return $this->redirect(['view', 'id' => $model->id]);

            } else {
                return $this->render('update', [
                    'model' => $model,
                    'list'=>  $list
                ]);
            }

    }

    /**
     * Delete an existing Anestesiologo model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }



    /**
     * Finds the Anestesiologo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Anestesiologo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Anestesiologo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
