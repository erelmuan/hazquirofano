<?php

namespace app\controllers;

use Yii;
use app\models\Medico;
use app\models\MedicoSearch;
use app\models\PacienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use app\models\Usuario;
use app\models\UsuarioSearch;


/**
 * MedicoController implements the CRUD actions for Medico model.
 */
class MedicoController extends Controller
{

    public function actionSearch()
    {
      $searchModelMed = new MedicoSearch();
      $searchModelMed->scenario = "search";
      $request = Yii::$app->request;
      if ($request->isAjax) {
      $searchModelMed->load(\Yii::$app->request->get());
      if ( $searchModelMed->validate()) {
            $dataProviderMed = $searchModelMed->search(\Yii::$app->request->get());
            if ($dataProviderMed->totalCount == 0)
               return Json::encode(['status' => 'error' ,'mensaje'=>"No se encontro el medico"]);
            else
              return Json::encode(['nombre'=>$dataProviderMed->getModels()[0]['nombre'],'apellido'=>$dataProviderMed->getModels()[0]['apellido'],'id'=>$dataProviderMed->getModels()[0]['id']]);
        } else {
            $errors = $searchModelMed->getErrors();
            return Json::encode(['status' => 'error' ,'mensaje'=>$errors['num_documento'][0]]);
        }
      }


    }


    /**
     * Lists all Medico models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MedicoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Medico model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'title'=> "Medico #".$id,
                    'content'=>$this->renderAjax('view', [
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
     * Creates a new Medico model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Medico();

                  ////////////USUARIO/////////////////
        $modelUsu= new Usuario();
        $searchModelUsu = new UsuarioSearch();
        $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
        $dataProviderUsu->pagination->pageSize=7;

            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                    'searchModelUsu' => $searchModelUsu,
                    'dataProviderUsu' => $dataProviderUsu,
                ]);
            }

    }

    /**
     * Updates an existing Medico model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        ////////////USUARIO/////////////////
        $modelUsu= new Usuario();
        $searchModelUsu = new UsuarioSearch();
        $dataProviderUsu = $searchModelUsu->search(Yii::$app->request->queryParams);
        $dataProviderUsu->pagination->pageSize=7;
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'searchModelUsu' => $searchModelUsu,
                    'dataProviderUsu' => $dataProviderUsu,
                ]);
            }

    }

    /**
     * Delete an existing Medico model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        // $this->findModel($id)->delete();

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            try {
                if ($this->findModel($id)->delete()){
                    return ['forceClose'=>true,'forceReload'=>'#crud-datatable-pjax'];
                }
            } catch (yii\db\Exception $e ) {
                Yii::$app->response->format = Response::FORMAT_HTML;
                // throw new NotFoundHttpException('Error en la base de datos.',500);
                throw new \yii\web\HttpException(500,
                    'No se puede eliminar el medico porque esta asociado a una solicitud',500);

            }


        }else{
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }


    }

     /**
     * Delete multiple existing Medico model.
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
     * Finds the Medico model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Medico the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Medico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
