<?php

namespace app\controllers;
use Yii;
use app\models\Cirugiaprogramada;
use app\models\CirugiaprogramadaSearch;
use app\models\WiewQuirofanosDisponiblesSearch;
use app\models\WiewHorasOcupadas;
use app\models\DiasSinCirugia;


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
use app\models\HistorialRangoHorario;


use app\models\Cirugiaequipo;
use app\models\ObservacionCirugia;
use app\models\Parametrizacion;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

use kartik\widgets\Growl;
use app\models\Quirofano;


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
       $parametrizacion=Parametrizacion::find()
       ->select(['hora_inicio'])->one();
       if($sumTiempo==false)
          $sumTiempo='00:00:00';

       return $this->sumarHoras([$parametrizacion->hora_inicio,$sumTiempo]);

     }
     public function listadequipos($dia,$id_cirugia,  $accion){
       // $modelParametrizacion = new Parametrizacion();
       // $parametrizacion=$modelParametrizacion::find()
       // ->select(['hora_inicio'])->one();
       if ($accion=="create"){
        $arrayEquipos= Equipo::find()->where('activo = true')->all();
          $list= ArrayHelper::map($arrayEquipos, 'id', 'descripcion');
             foreach ($arrayEquipos as $equipo) {
               if ($equipo->dias !=0){
                   $usado = Cirugiaequipo::find()
                   ->leftJoin('cirugiaprogramada', 'cirugiaprogramada.id = cirugiaequipo.id_cirugiaprogramada')
                   ->where(['and','cirugiaequipo.id_equipo = '.$equipo->id ])
                   //El numero 12 se debe parametrizar de acuerdo a fecha impuesta por cada equipo
                   // ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= 30 and id_medico <>".$medico->id ])->count();
                   ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= ".$equipo->dias." and ( date '".$dia."' -  fecha_cirugia ) >= -".$equipo->dias])->count();

                   if ($usado>0){
                     $list[$equipo->id]=$equipo->descripcion." (No disponible)";
                   }
             }
           }
        }
        if ($accion=="update"){
         $arrayEquipos= Equipo::find()->where('activo = true')->all();
           $list= ArrayHelper::map($arrayEquipos, 'id', 'descripcion');
              foreach ($arrayEquipos as $equipo) {
                if ($equipo->dias !=0){
                    $usado = Cirugiaequipo::find()
                    ->leftJoin('cirugiaprogramada', 'cirugiaprogramada.id = cirugiaequipo.id_cirugiaprogramada')
                    ->where(['and','cirugiaequipo.id_equipo = '.$equipo->id ])
                    //El numero 12 se debe parametrizar de acuerdo a fecha impuesta por cada equipo
                    // ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= 30 and id_medico <>".$medico->id ])->count();
                    ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= ".$equipo->dias." and ( date '".$dia."' -  fecha_cirugia ) >= -".$equipo->dias." and id_cirugiaprogramada <> ".$id_cirugia ])->count();

                    if ($usado>0){
                      $list[$equipo->id]=$equipo->descripcion." (No disponible)";
                    }
              }
            }
         }
           return $list;
   }




     public function validar($dia, $model, $accion){
       // Primero validar si tiene medico asociado
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

         //Validar que el medico que quiere modificar es el mismo que esta accediendo

         if ( $accion=="update"  && $model->medico->id_usuario !== Yii::$app->user->identity->id ){
           Yii::$app->getSession()->setFlash('warning', [
               'type' => 'danger',
               'duration' => 5000,
               'icon' => 'fa fa-warning',
               'message' => 'LA CIRUGIA PERTENECE A OTRO MEDICO.',
               'title' => 'NOTIFICACIÓN',
               'positonY' => 'top',
               'positonX' => 'right'
           ]);
           return false;
         }
         // SOLO PARA EL CREATE validar que el dia tiene que ser mayor al actualiza
         //Se deja a lo ultimo este metodo es usado tambien por el updateParametros
         // y en el mismo no hay restriccion  sobre el dia

         $fechahoy=date('Y-m-d');
         if($accion=="create"  && $fechahoy>=$dia ){
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
      //El primer quirofano disponible que encuentre
      $quirofano=Quirofano::find()->orderBy(['id'=>SORT_ASC])->where(['and','habilitado= true' ])->one();
      $tiempo_default= $this->cantidadTiempo($dia,$quirofano->id);


      $list = $this->listadequipos($dia,null,"create") ;
        $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);
        $model = new Cirugiaprogramada();

        if(!$this->validar($dia,  $model->load($this->request->post()),"create")){
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

              // $historia_rang
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
          (!isset($_POST["cirugiaequipos"]) )? $cirugiaequipos=[]: $cirugiaequipos=$_POST["cirugiaequipos"];
          (!isset($_POST["observacionquirurgica"]) )? $obsquir=[]: $obsquir=$_POST["observacionquirurgica"];

          Cirugiaequipo::deleteAll(['id_cirugiaprogramada'=>$id]);
            //Esto se tiene que hacer una vez
        foreach ($cirugiaequipos as $key => $id_equipo) {
            $modelCirugiaEquipo = new Cirugiaequipo();
            $modelCirugiaEquipo->id_cirugiaprogramada=$model->id;
            $modelCirugiaEquipo->id_equipo=$id_equipo;
            $modelCirugiaEquipo->save();
          }
          ObservacionCirugia::deleteAll(['id_cirugiaprogramada'=>$id]);
          foreach ($obsquir as $key => $id_obsquir) {
            $modelobservacion_cirugia = new ObservacionCirugia();
            $modelobservacion_cirugia->id_cirugiaprogramada=$model->id;
            $modelobservacion_cirugia->id_observacionquirurgica=$id_obsquir;
            $modelobservacion_cirugia->save();

             }
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);
        if(!$this->validar(null,  $model, "update")){
          return $this->redirect(["index"]);
        }
        $list = $this->listadequipos($model->fecha_cirugia,$id,"update") ;

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
    public function porcentaje($id_quirofano,$fecha){

      $historial_rango= HistorialRangoHorario::find()->where(["and","fecha <= '".$fecha."'"])->orderBy(['id'=>SORT_DESC])->one();

      $inicio= new \DateTime($historial_rango->hora_inicio);
      $fin=new \DateTime($historial_rango->hora_final);
      $tiempo = $inicio->diff($fin);
      $minutos=$tiempo->format('%i')/60;
      $hora=$tiempo->format('%h');
      $horas_disponibles= $hora +$minutos;

      $HU= WiewHorasOcupadas::find()->select(['horas_ocupadas'])->where(["and","id_quirofano   =".$id_quirofano." and fecha_cirugia= '".$fecha."'"])->one();
      if(!isset($HU->horas_ocupadas)){
        $horas_usadas=0;
      }else {
        $mDateI= new \DateTime ( $HU->horas_ocupadas);
        $mDateF=new \DateTime('00:00:00');

        $horas_ocupadas=$mDateI->diff($mDateF);
        $minutos=$horas_ocupadas->format('%i')/60;
        $hora=$horas_ocupadas->format('%h');
        $horas_usadas= $hora +$minutos;
      }


      $porcentaje=100*$horas_usadas/$horas_disponibles;
      $porcentaje=round($porcentaje, 0);   // Quitar los decimales
      return ($porcentaje);
      //Obtener el valor total de horas disponibles
      //obtener la cantidad de horas usadas en el quierofano
      //calcular el porcentaje  horas_disponibles * horas_usadas /100
    }

        public function actionCalendario(){
          $searchModel = new WiewQuirofanosDisponiblesSearch();
          $dataProvider = $searchModel->search($this->request->queryParams);
            $parametrizacion= Parametrizacion::find()->one();
          // ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= ".$equipo->dias])->count();

          $cirugias= Cirugiaprogramada::find()->select("fecha_cirugia")->distinct()
          ->andWhere(["and","fecha_cirugia >= (current_date::date - interval '60 day') and id_estado !=2 and id_estado !=3 "])->all();
          //NO TIENE QUE SER ANULADA ID 2 NI REPROGRAMADA ID REPROGRAMADA
          $quirofanos= Quirofano::find()->all();
          $tasks = [];
          foreach ($cirugias as $cirugia) {
            foreach ($quirofanos as $quirofano) {
              $event= new \yii2fullcalendar\models\Event();
                $event->id= $quirofano->id;
                $fecha=date("Y-m-d", strtotime($cirugia->fecha_cirugia));
                    $valor=$this->porcentaje($quirofano->id,$fecha);
                    if(trim($valor)==='100'){
                      $event->color= "red";
                    }else {
                      if ($valor>=$parametrizacion->niveles){
                        $event->color= '#d1b50b';
                      }else {
                        $event->color= "green";

                      }
                    }

                $event->title= $quirofano->nombre." - ".$valor."%";

                $event->start=$fecha;
                $event->url='index.php?r=cirugiaprogramada/fecha&dia='.$fecha;
                if ($valor!='0'){
                    $tasks[]=$event;
                }

            }
        }
        //Entra si el quirofano tiene una cirugia programada
        $dia_sin_cirugias=DiasSinCirugia::find()->
        andWhere(["and","fecha >= (current_date::date - interval '60 day')"])->all();
        foreach ($dia_sin_cirugias as $dia_sin_cirugia) {
            $event= new \yii2fullcalendar\models\Event();
            $event->title=$dia_sin_cirugia->motivo;
            $event->start=$dia_sin_cirugia->fecha;
            $event->color= "blue";
            $tasks[]=$event;
        }
        //   $event= new \yii2fullcalendar\models\Event();
        //     $event->id=1;
        //     $event->title='QUIROFANO A';
        //     $event->start=date("Y-m-d");
        //   $event->url='index.php?r=cirugiaprogramada/fecha&dia=';
        //   $event->color= "grey";
        //   $tasks[]=$event;
        //   $event= new \yii2fullcalendar\models\Event();
        //
        //   $event->id=2;
        //   $event->title='QUIROFANO B';
        //   $event->start=date("Y-m-d");
        // $event->url='index.php?r=cirugiaprogramada/fecha&dia=';
        // $event->color= "blue";
        //   $tasks[]=$event;
        //   $event= new \yii2fullcalendar\models\Event();
        //
        //   $event->id=3;
        //   $event->title='QUIROFANO C';
        //   $event->start=date("Y-m-d");
        // $event->url='index.php?r=cirugiaprogramada/fecha&dia=';
        // $event->color= "red";
        //   $tasks[]=$event;
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
