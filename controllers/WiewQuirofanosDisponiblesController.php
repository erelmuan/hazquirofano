<?php

namespace app\controllers;

use Yii;
use app\models\WiewQuirofanosDisponibles;
use app\models\WiewQuirofanosDisponiblesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * WiewQuirofanosDisponiblesController implements the CRUD actions for WiewQuirofanosDisponibles model.
 */
class WiewQuirofanosDisponiblesController extends Controller
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
     * Lists all WiewQuirofanosDisponibles models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new WiewQuirofanosDisponiblesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single WiewQuirofanosDisponibles model.
     * @param string $fecha_cirugia
     * @param string $hora_inicio
     * @param string $hora_final
     * @param integer $id_quirofano
     * @return mixed
     */
    public function actionView($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "WiewQuirofanosDisponibles #".$fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano'=>$fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano),
            ]);
        }
    }

    /**
     * Creates a new WiewQuirofanosDisponibles model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new WiewQuirofanosDisponibles();  

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new WiewQuirofanosDisponibles",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new WiewQuirofanosDisponibles",
                    'content'=>'<span class="text-success">Create WiewQuirofanosDisponibles success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])
        
                ];         
            }else{           
                return [
                    'title'=> "Create new WiewQuirofanosDisponibles",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
        
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'fecha_cirugia' => $model->fecha_cirugia, 'hora_inicio' => $model->hora_inicio, 'hora_final' => $model->hora_final, 'id_quirofano' => $model->id_quirofano]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing WiewQuirofanosDisponibles model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $fecha_cirugia
     * @param string $hora_inicio
     * @param string $hora_final
     * @param integer $id_quirofano
     * @return mixed
     */
    public function actionUpdate($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano);       

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update WiewQuirofanosDisponibles #".$fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "WiewQuirofanosDisponibles #".$fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano'=>$fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];    
            }else{
                 return [
                    'title'=> "Update WiewQuirofanosDisponibles #".$fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];        
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'fecha_cirugia' => $model->fecha_cirugia, 'hora_inicio' => $model->hora_inicio, 'hora_final' => $model->hora_final, 'id_quirofano' => $model->id_quirofano]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing WiewQuirofanosDisponibles model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $fecha_cirugia
     * @param string $hora_inicio
     * @param string $hora_final
     * @param integer $id_quirofano
     * @return mixed
     */
    public function actionDelete($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano)
    {
        $request = Yii::$app->request;
        $this->findModel($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano)->delete();

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
     * Delete multiple existing WiewQuirofanosDisponibles model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $fecha_cirugia
     * @param string $hora_inicio
     * @param string $hora_final
     * @param integer $id_quirofano
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
     * Finds the WiewQuirofanosDisponibles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $fecha_cirugia
     * @param string $hora_inicio
     * @param string $hora_final
     * @param integer $id_quirofano
     * @return WiewQuirofanosDisponibles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($fecha_cirugia, $hora_inicio, $hora_final, $id_quirofano)
    {
        if (($model = WiewQuirofanosDisponibles::findOne(['fecha_cirugia' => $fecha_cirugia, 'hora_inicio' => $hora_inicio, 'hora_final' => $hora_final, 'id_quirofano' => $id_quirofano])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
