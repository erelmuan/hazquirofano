<?php

namespace app\controllers;
use Yii;
use app\models\Cirugiaprogramada;
use app\models\CirugiaprogramadaSearch;
use app\models\WiewQuirofanosDisponiblesSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\PacienteSearch;
use app\models\Paciente;
use \yii\web\Response;
use yii\helpers\Html;

use app\models\MedicoSearch;
use app\models\Medico;
use app\models\Equipo;

use app\models\Cirugiaequipo;
use app\models\ObservacionCirugia;
use app\models\Parametrizacion;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

use kartik\widgets\Growl;


/**
 * CirugiaprogramadaController implements the CRUD actions for Cirugiaprogramada model.
 */
class CirugiaprogramadaController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cirugiaprogramada models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CirugiaprogramadaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cirugiaprogramada model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
      $request = Yii::$app->request;

      if($request->isAjax){
          Yii::$app->response->format = Response::FORMAT_JSON;
          return [
                  'title'=> "Cirugia Programada #".$id,
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
     * Creates a new Cirugiaprogramada model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


     public function sumarHoras($horas){
          $total = 0;
          foreach($horas as $h) {
              $parts = explode(":", $h);
              $total += $parts[2] + $parts[1]*60 + $parts[0]*3600;
          }
          return gmdate("H:i:s", $total);
      }
    public function actionTiempoajax(){
      if (Yii::$app->request->isAjax) {
        $out = [];
        if (isset($_POST['id'])) {

            $data = Yii::$app->request->post();
            $id= explode(":", $data['id']);
            $id_quirofano= $id[0];
            $dia= explode(":", $data['dia']);
            $fecha= $dia[0];
            if(!empty($data['id_model'])){
              $id_model= explode(":", $data['id_model']);
              $id_M= $id_model[0];
              $model=$this->findModel($id_M);
              if($model->id_quirofano==$id_quirofano){
                $tiempo=  $model->hora_inicio;
                echo Json::encode([$tiempo]);
                return;
              }
            }

          $tiempo=  $this->cantidadTiempo($fecha,$id_quirofano);
          echo Json::encode([$tiempo]);
          return;

        }
      }
    }
   public function cantidadTiempo($dia,$quirofano){

       $model = new Cirugiaprogramada();
       $modelParametrizacion = new Parametrizacion();

       $sumTiempo= $model::find()->select(['cant_tiempo'])
       ->where(['and',"fecha_cirugia = '".$dia."' and id_quirofano =".$quirofano  ])
       ->sum('cant_tiempo');
       $parametrizacion=$modelParametrizacion::find()
       ->select(['hora_inicio'])->one();
       if($sumTiempo==false)
          $sumTiempo='00:00:00';

       return $this->sumarHoras([$parametrizacion->hora_inicio,$sumTiempo]);

     }
     public function listadequipos($dia,$medico,  $accion){
       // $modelParametrizacion = new Parametrizacion();
       // $parametrizacion=$modelParametrizacion::find()
       // ->select(['hora_inicio'])->one();
       if ($accion="create"){
        $arrayEquipos= Equipo::find()->where('activo = true')->all();
          $list= ArrayHelper::map($arrayEquipos, 'id', 'descripcion');
             foreach ($arrayEquipos as $equipo) {
               if ($equipo->dias !=0){
                   $usado = Cirugiaequipo::find()
                   ->leftJoin('cirugiaprogramada', 'cirugiaprogramada.id = cirugiaequipo.id_cirugiaprogramada')
                   ->where(['and','cirugiaequipo.id_equipo = '.$equipo->id ])
                   //El numero 12 se debe parametrizar de acuerdo a fecha impuesta por cada equipo
                   // ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= 30 and id_medico <>".$medico->id ])->count();
                   ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= ".$equipo->dias])->count();

                   if ($usado>0){
                     $list[$equipo->id]=$equipo->descripcion." (No disponible)";
                   }
             }
           }
        }
           return $list;
   }




     public function validar($dia, $model){
       $tieneMedico= Medico::find()->where(['id_usuario' => Yii::$app->user->identity->id ])->count();
         if ($tieneMedico == 0){
           Yii::$app->getSession()->setFlash('warning', [
               'type' => 'danger',
               'duration' => 5000,
               'icon' => 'fa fa-warning',
               'message' => 'NO HAY MEDICO ASOCIADO AL USUARIO.',
               'title' => 'NOTIFICACIÓN',
               'positonY' => 'top',
               'positonX' => 'right'
           ]);
           return false;
         }
         $fechahoy=date('Y-m-d');
         if($fechahoy>=$dia ){
           Yii::$app->getSession()->setFlash('warning', [
               'type' => 'danger',
               'duration' => 5000,
               'icon' => 'fa fa-warning',
               'message' => 'LA FECHA CIRUGÍA DEBE SER MAYOR AL DÍA ACTUAL.',
               'title' => 'NOTIFICACIÓN',
               'positonY' => 'top',
               'positonX' => 'right'
           ]);
           return false;
         }

         // $modelParametrizacion = new Parametrizacion();
         // if ( !empty($model)){
         //
         //   $tiempo_default= $this->cantidadTiempo($dia,$model->id_quirofano);
         //
         //   $parametrizacion->hora_final;
         // }

       return true;
     }

    public function actionCreate($dia)
    {
      ////////////PACIENTE/////////////////
      $modelPac= new Paciente();
      $searchModelPac = new PacienteSearch();
      $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
      $dataProviderPac->pagination->pageSize=7;
      ////////////MEDICO/////////////////
      //El horario por defecto esta asociado al quirofano A
      //Quirofano A  id=2
      $tiempo_default= $this->cantidadTiempo($dia,2);

      $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);

      $list = $this->listadequipos($dia,$medico,"create") ;

        $model = new Cirugiaprogramada();

        if(!$this->validar($dia,  $model->load($this->request->post()))){
          return $this->redirect(["cirugiaprogramada/fecha", "dia"=>$dia ]);
        }

        if ($this->request->isPost) {

            (!isset($_POST["cirugiaequipos"]) )? $cirugiaequipos=[]: $cirugiaequipos=$_POST["cirugiaequipos"];
            (!isset($_POST["observacionquirurgica"]) )? $obsquir=[]: $obsquir=$_POST["observacionquirurgica"];

            // $model->load($this->request->post());
            if (!isset($_POST["cirugiaequipos"]) && ($_POST["Cirugiaprogramada"]["otro_equpo"])=="" ){
              Yii::$app->getSession()->setFlash('warning', [
                  'type' => 'danger',
                  'duration' => 5000,
                  'icon' => 'fa fa-warning',
                  'message' => 'DEBE SELECCIONAR ALGÚN EQUIPO',
                  'title' => 'NOTIFICACIÓN',
                  'positonY' => 'top',
                  'positonX' => 'right'
              ]);
              return $this->render('create', [
                  'model' => $model,
                  'searchModelPac' => $searchModelPac,
                  'dataProviderPac' => $dataProviderPac,
                  'modelPac' => $modelPac,
                  'dia'=>$dia,
                  'medico'=>$medico,
                  'tiempo' => $tiempo_default,
                    'list'=> $list

              ]);
            }
            if (!isset($_POST["observacionquirurgica"]) ){
              Yii::$app->getSession()->setFlash('warning', [
                  'type' => 'danger',
                  'duration' => 5000,
                  'icon' => 'fa fa-warning',
                  'message' => 'DEBE SELECCIONAR ALGUNA OBSERVACIÓN',
                  'title' => 'NOTIFICACIÓN',
                  'positonY' => 'top',
                  'positonX' => 'right'
              ]);              return $this->render('create', [
                  'model' => $model,
                  'searchModelPac' => $searchModelPac,
                  'dataProviderPac' => $dataProviderPac,
                  'modelPac' => $modelPac,
                  'dia'=>$dia,
                  'medico'=>$medico,
                  'tiempo' => $tiempo_default,
                    'list'=> $list

              ]);
            }

            if ($model->load($this->request->post()) && $model->save()) {
              foreach ($cirugiaequipos as $key => $id_equipo) {
                $modelCirugiaEquipo = new Cirugiaequipo();
                $modelCirugiaEquipo->id_cirugiaprogramada=$model->id;
                $modelCirugiaEquipo->id_equipo=$id_equipo;
                $modelCirugiaEquipo->save();
              }
              foreach ($obsquir as $key => $id_obsquir) {
                $modelobservacion_cirugia = new ObservacionCirugia();
                $modelobservacion_cirugia->id_cirugiaprogramada=$model->id;
                $modelobservacion_cirugia->id_observacionquirurgica=$id_obsquir;
                $modelobservacion_cirugia->save();

                 }
              return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        else {
          //loadDefaultValues ​​() para completar los valores predeterminados definidos por la base de datos en los atributos de Active Record correspondientes
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'searchModelPac' => $searchModelPac,
            'dataProviderPac' => $dataProviderPac,
             'modelPac' => $modelPac,
            'dia'=>$dia,
            'medico'=>$medico,
          'tiempo' => $tiempo_default,
            'list'=> $list
        ]);
    }

    public function actionPrueba(){

    }
    /**
     * Updates an existing Cirugiaprogramada model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        ////////////PACIENTE/////////////////
        $modelPac= new Paciente();
        $searchModelPac = new PacienteSearch();
        $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
        $dataProviderPac->pagination->pageSize=7;
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);
        $list = $this->listadequipos($model->fecha_cirugia,$model->medico,"update") ;

        return $this->render('_form', [
            'model' => $model,
            'searchModelPac' => $searchModelPac,
            'dataProviderPac' => $dataProviderPac,
            'medico'=>$model->medico,
            'dia'=>$model->fecha_cirugia,
            'tiempo'=>$model->hora_inicio,
            'list'=>$list

        ]);
    }

    /**
     * Deletes an existing Cirugiaprogramada model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cirugiaprogramada model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cirugiaprogramada the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cirugiaprogramada::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionFecha($dia)
    {
        $cirugiaprogramada = new Cirugiaprogramada();

        $arrayCirugias= $cirugiaprogramada::find()->where(['fecha_cirugia' => $dia])->all();

        $date = date_create($dia);
        $fecha_form = date_format($date, 'd/m/Y');

        return $this->render('fecha', [
        'dia' => $dia,
        'fecha'=>$fecha_form,
        'arrayCirugias'=>$arrayCirugias,
    ]);

    }

        public function actionCalendario()
        {
          $searchModel = new WiewQuirofanosDisponiblesSearch();
          $dataProvider = $searchModel->search($this->request->queryParams);

          $events= Cirugiaprogramada::find()->all();
          $tasks = [];
          foreach ($events as $eve) {
            $event= new \yii2fullcalendar\models\Event();
            $event->id=$eve->id;
            $event->title=$eve->quirofano->nombre;
            $event->start=date("Y-m-d H:i:s", strtotime($eve->fecha_cirugia.' '.$eve->hora_inicio));
            // $event->start=date("Y-m-d H:i:s", strtotime('2021-06-28 07:00'));
            // $event->end= date("Y-m-d H:i:s", strtotime('2021-06-28 10:00'));
            $event->url='index.php?r=cirugiaprogramada/fecha&dia='.$eve->fecha_cirugia;
            $event->color= "grey";
            $tasks[]=$event;
          }
            // $Event = new \yii2fullcalendar\models\Event();
            // $Event->id = 1;
            // $Event->title = 'Testing';
            //
            //
            // $Event->start=  date("Y-m-d H:i:s", strtotime('2021-06-28 07:00'));
            // $Event->end= date("Y-m-d H:i:s", strtotime('2021-06-28 10:00'));


            // $Event->timeStart= '07:00';
            // $Event->timeEnd= '10:00';
           // $Event->start = '2021-06-24 07:00';
           // $Event->end = '2021-06-24 10:00';
            // $Event->color= "red";
            // $Event->dow= [ 1, 2, 3, 4, 5 ] ;
            //s$Event->allDay=true;
            //habria que hacer un for???
            // $events[] = $Event;
            $dataProvider->pagination->pageSize=7;
         return $this->render('calendario', [
            'events' => $tasks,
            'searchModel'=>$searchModel,
            'dataProvider' =>$dataProvider
          ]);
        }


    public function actionBuscar(){
          $searchModel = new CirugiaprogramadaSearch();
          $dataProvider = $searchModel->searchdispo($this->request->queryParams);


        }
}
