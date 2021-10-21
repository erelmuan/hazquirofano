<?php

namespace app\controllers;

use Yii;
use app\models\Quirofano;
use app\models\QuirofanoSearch;
use app\models\Anestesiologo;
use app\models\AnestesiologoSearch;
use app\models\QuirofanoAnestesiologoSearch;
use app\models\QuirofanoAnestesiologo;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\helpers\Json;
use app\components\Metodos\Metodos;

/**
 * QuirofanoController implements the CRUD actions for Quirofano model.
 */
class QuirofanoController extends Controller
{


    /**
     * Lists all Quirofano models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QuirofanoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Quirofano model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Quirofano #".$id,
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

    /**
     * Creates a new Quirofano model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Quirofano();
        ////////////ANESTESILOGO/////////////////
        $modelUsu= new Anestesiologo();
        $searchModelAnes = new AnestesiologoSearch();
        $dataProviderAnes = $searchModelAnes->search(Yii::$app->request->queryParams);
        $dataProviderAnes->pagination->pageSize=7;
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'searchModelAnes' => $searchModelAnes,
                    'dataProviderAnes' => $dataProviderAnes,
                ]);
            }

    }

    /**
     * Updates an existing Quirofano model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        ////////////ANESTESILOGO/////////////////
        $modelUsu= new Anestesiologo();
        $searchModelAnes = new AnestesiologoSearch();
        $dataProviderAnes = $searchModelAnes->search(Yii::$app->request->queryParams);
        $dataProviderAnes->pagination->pageSize=7;
        if ($model->load($request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
              'model' => $model,
              'searchModelAnes' => $searchModelAnes,
              'dataProviderAnes' => $dataProviderAnes,
              ]);
        }

    }

    /**
     * Delete an existing Quirofano model.
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
     * Delete multiple existing Quirofano model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post( 'pks' )); // Array or selected records primary keys
        foreach ( $pks as $pk ) {
            $model = $this->findModel($pk);
            $model->delete();
        }

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
     * Finds the Quirofano model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Quirofano the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Quirofano::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

  public function  actionAnestesiologoajax(){
      if (Yii::$app->request->isAjax) {
        $out = [];
        if (isset($_POST['id'])) {

            $data = Yii::$app->request->post();
            $id= explode(":", $data['id']);
            $quirofano= $this->findModel($id) ;
          $id_anestesiologo= $quirofano->anestesiologo->id;
          $anestesiologo= $quirofano->anestesiologo->nombre;
          echo Json::encode([$id_anestesiologo,$anestesiologo]);
          return;

        }
      }
    }

    public function actionListdetalle()
    {

        if (isset($_POST['expandRowKey'])) {

            $searchModel = new QuirofanoAnestesiologoSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $dataProvider->query->where(['id_quirofano' => $_POST['expandRowKey']]);

            $dataProvider->setPagination(false);
            $dataProvider->setSort(false);

            return $this->renderPartial('_listDetalle', [
                'id_maestro' => $_POST['expandRowKey'],
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);

        } else {
            return '<div>No se encontraron resultados</div>';
        }
    }


    public function actionAddnombre(){

          if (isset($_POST['keylist']) AND isset($_POST['id_quirofano'])) {

              $lerror = false;
              $id_quirofano = $_POST['id_quirofano'];

              foreach ($_POST['keylist'] as $value) {

                  if ($modelQuirofanoAnestesiologo= new QuirofanoAnestesiologo()) {

                      $modelQuirofanoAnestesiologo->id_quirofano = $id_quirofano;
                      $modelQuirofanoAnestesiologo->id_anestesiologo = $value;
                      if (!$modelQuirofanoAnestesiologo->save()) {
                          $lerror = true;
                          break;
                      }
                      
                  } else {
                      $lerror = true;
                      break;
                  }

              }
              Yii::$app->response->format = Response::FORMAT_JSON;

              if ($lerror) {
                  return ['status' => 'error'];
              }
              return ['status' => 'success'];

              Yii::$app->end();
          }

          $modelDetalle = new Anestesiologo();
          $searchModel = new AnestesiologoSearch();
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          $columnas = Metodos::obtenerColumnas($modelDetalle);

                Yii::$app->response->format = Response::FORMAT_JSON;
              return [
                  'title' => 'Agregar Anestesiologo',
                  'content' => $this->renderAjax('_addnombre', [
                      'searchModel' => $searchModel,
                      'dataProvider' => $dataProvider,
                      'columns' => $columnas,
                      'id_quirofano' => $_GET['id_maestro'],
                  ]),

              ];

        }
        public function actionDeletedetalle($id_detalle, $id_maestro)
        {

            Yii::$app->response->format = Response::FORMAT_JSON;

            try {
                if ($modelQuirofanoAnestesiologo = QuirofanoAnestesiologo::findOne($id_detalle)) {
                    // borro registro en este caso por que es una relacion NN
                    if ($modelQuirofanoAnestesiologo->delete())
                        // return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
                        return ['forceClose' => true, 'success' => 'reloadDetalle(' . $id_maestro . ')'];

                }
            } catch (yii\db\Exception $e) {
                return ['forceClose' => false,
                    'title' => '<p style="color:red">ERROR</p>',
                    'content' => '<div style=" font-size: 14px">Errores en la operacion indicada. Verifique.</div>',
                    'success' => 'reloadDetalle(' . $id_maestro . ')'];
            }

        }


}
