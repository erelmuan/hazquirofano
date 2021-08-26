<?php

namespace app\controllers;

use Yii;
use app\models\WiewHorasOcupadas;
use app\models\WiewHorasOcupadasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * WiewHorasOcupadasController implements the CRUD actions for WiewHorasOcupadas model.
 */
class WiewHorasOcupadasController extends Controller
{

    /**
     * Lists all WiewHorasOcupadas models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WiewHorasOcupadasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single WiewHorasOcupadas model.
     * @param string $fecha_cirugia
     * @param string $horas_ocupadas
     * @param integer $id_quirofano
     * @return mixed
     */
    public function actionView($fecha_cirugia, $horas_ocupadas, $id_quirofano)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "WiewHorasOcupadas #".$fecha_cirugia, $horas_ocupadas, $id_quirofano,
                    'content'=>$this->renderAjax('view', [
                        'model' => $this->findModel($fecha_cirugia, $horas_ocupadas, $id_quirofano),
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','fecha_cirugia, $horas_ocupadas, $id_quirofano'=>$fecha_cirugia, $horas_ocupadas, $id_quirofano],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
        }else{
            return $this->render('view', [
                'model' => $this->findModel($fecha_cirugia, $horas_ocupadas, $id_quirofano),
            ]);
        }
    }

    /**
     * Creates a new WiewHorasOcupadas model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new WiewHorasOcupadas();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Create new WiewHorasOcupadas",
                    'content'=>$this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])

                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "Create new WiewHorasOcupadas",
                    'content'=>'<span class="text-success">Create WiewHorasOcupadas success</span>',
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Create More',['create'],['class'=>'btn btn-primary','role'=>'modal-remote'])

                ];
            }else{
                return [
                    'title'=> "Create new WiewHorasOcupadas",
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
                return $this->redirect(['view', 'fecha_cirugia' => $model->fecha_cirugia, 'horas_ocupadas' => $model->horas_ocupadas, 'id_quirofano' => $model->id_quirofano]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }

    }

    /**
     * Updates an existing WiewHorasOcupadas model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param string $fecha_cirugia
     * @param string $horas_ocupadas
     * @param integer $id_quirofano
     * @return mixed
     */
    public function actionUpdate($fecha_cirugia, $horas_ocupadas, $id_quirofano)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($fecha_cirugia, $horas_ocupadas, $id_quirofano);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'title'=> "Update WiewHorasOcupadas #".$fecha_cirugia, $horas_ocupadas, $id_quirofano,
                    'content'=>$this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                                Html::button('Save',['class'=>'btn btn-primary','type'=>"submit"])
                ];
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'forceReload'=>'#crud-datatable-pjax',
                    'title'=> "WiewHorasOcupadas #".$fecha_cirugia, $horas_ocupadas, $id_quirofano,
                    'content'=>$this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer'=> Html::button('Close',['class'=>'btn btn-default pull-left','data-dismiss'=>"modal"]).
                            Html::a('Edit',['update','fecha_cirugia, $horas_ocupadas, $id_quirofano'=>$fecha_cirugia, $horas_ocupadas, $id_quirofano],['class'=>'btn btn-primary','role'=>'modal-remote'])
                ];
            }else{
                 return [
                    'title'=> "Update WiewHorasOcupadas #".$fecha_cirugia, $horas_ocupadas, $id_quirofano,
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
                return $this->redirect(['view', 'fecha_cirugia' => $model->fecha_cirugia, 'horas_ocupadas' => $model->horas_ocupadas, 'id_quirofano' => $model->id_quirofano]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing WiewHorasOcupadas model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $fecha_cirugia
     * @param string $horas_ocupadas
     * @param integer $id_quirofano
     * @return mixed
     */
    public function actionDelete($fecha_cirugia, $horas_ocupadas, $id_quirofano)
    {
        $request = Yii::$app->request;
        $this->findModel($fecha_cirugia, $horas_ocupadas, $id_quirofano)->delete();

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
     * Delete multiple existing WiewHorasOcupadas model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $fecha_cirugia
     * @param string $horas_ocupadas
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
     * Finds the WiewHorasOcupadas model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $fecha_cirugia
     * @param string $horas_ocupadas
     * @param integer $id_quirofano
     * @return WiewHorasOcupadas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($fecha_cirugia, $horas_ocupadas, $id_quirofano)
    {
        if (($model = WiewHorasOcupadas::findOne(['fecha_cirugia' => $fecha_cirugia, 'horas_ocupadas' => $horas_ocupadas, 'id_quirofano' => $id_quirofano])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
