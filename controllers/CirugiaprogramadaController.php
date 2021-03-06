<?php

namespace app\controllers;
use Yii;
use app\models\Cirugiaprogramada;
use app\models\DiasSemanales;
use app\models\CirugiaprogramadaSearch;
use app\models\WiewQuirofanosDisponiblesSearch;
use app\models\WiewHorasOcupadas;
use app\models\DiasSinCirugia;
use app\models\Anestesiologo;
use app\models\Observacionquirurgica;

use app\models\Usuario;
use app\models\Especialidad;
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

use app\models\Auditoria;

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
                  // 'content'=>$this->renderAjax('vieww', [
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


   public function cantidadTiempo($dia,$quirofano){

       $model = new Cirugiaprogramada();
       $modelParametrizacion = new Parametrizacion();

      if ( $quirofano->necesita_anestesiologo === false) {
         $sumTiempo= $model::find()->select(['cant_tiempo'])
         ->where(['and',"fecha_cirugia = '".$dia."' and id_quirofano =".$quirofano->id." and id_estado !=2 and id_estado !=3"  ])
         ->sum('cant_tiempo');
         if($sumTiempo==false)
            $sumTiempo='00:00:00';

     }else {
       $anestesiologo =$quirofano->anestesiologo($this->dia_semanal($dia),$quirofano->id );

       $sumTiempo='00:00:00';
       foreach ( $anestesiologo->quirofanoAnestesiologos as $quirofanoAnestesiologo) {

         $tiempo= $model::find()->select(['cant_tiempo'])
         ->where(['and',"fecha_cirugia = '".$dia."' and id_quirofano =".$quirofanoAnestesiologo->id_quirofano." and id_estado !=2 and id_estado !=3"  ])
         ->sum('cant_tiempo');
           if($tiempo==false){
              $tiempo='00:00:00';
           }else {
            $sumTiempo= $this->sumarHoras([$sumTiempo,$tiempo]);
           }
      }

     }


      $parametrizacion=Parametrizacion::find()
          ->select(['hora_inicio'])->one();
       return $this->sumarHoras([$parametrizacion->hora_inicio,$sumTiempo]);

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
             $quirofano = Quirofano::find()->where(["id"=>$id_quirofano])->one();
           $tiempo=  $this->cantidadTiempo($fecha,$quirofano);
           echo Json::encode([$tiempo]);
           return;

         }
       }
     }
     public function listadequipos($dia,$id_cirugia,  $accion){

       $usuario= Usuario::find()->where(['id'=>Yii::$app->user->identity->id])->one();

       if ($accion=="create"){
        $arrayEquipos= Equipo::find()->where('activo = true')->all();
          $list= ArrayHelper::map($arrayEquipos, 'id', 'descripcion');
             foreach ($arrayEquipos as $equipo) {
               if ($equipo->dias !=0){
                   $usado = Cirugiaequipo::find()
                   ->leftJoin('cirugiaprogramada', 'cirugiaprogramada.id = cirugiaequipo.id_cirugiaprogramada')
                   ->where(['and','cirugiaequipo.id_equipo = '.$equipo->id ])
                   ->andWhere(['and',"( date '".$dia."' -  fecha_cirugia )  <= ".$equipo->dias." and ( date '".$dia."' -  fecha_cirugia ) >= -".$equipo->dias])->count();

                   if ($usado>0){
                     $list[$equipo->id]=$equipo->descripcion." (No disponible)";
                   }
             }

              if (isset($equipo->especialidad->profesion) && !$usuario->isCargador() && $equipo->especialidad->profesion !== $usuario->medico->especialidad->profesion){
                      $list[$equipo->id]=$equipo->descripcion."(Reservado x esp)";

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

     public function dia_semanal($dia) {

         $nombreDias = array('DOMINGO','LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO');
         $nombre_del_dia = $nombreDias[date('N', strtotime($dia))];
         return $nombre_del_dia;

     }
     public function setearMensaje($mensaje){
       Yii::$app->getSession()->setFlash('warning', [
           'type' => 'danger',
           'duration' => 5000,
           'icon' => 'fa fa-warning',
           'message' => $mensaje,
           'title' => 'NOTIFICACI??N',
           'positonY' => 'top',
           'positonX' => 'right'
       ]);

     }


  public function validarAntes($dia, $model, $accion,$cargador){
       // Primero validar si tiene medico asociado
       $cirugiaprogramada = new Cirugiaprogramada();

       if ($cirugiaprogramada->quirofanos($dia)== null){
         $this->setearMensaje('DEBE PARAMETRIZAR LOS QUIROFANOS.');
         return false;
       }

       $tieneMedico= Medico::find()->where(['id_usuario' => Yii::$app->user->identity->id ])->count();
         if ($tieneMedico == 0 && !$cargador){
           $this->setearMensaje('NO HAY MEDICO ASOCIADO AL USUARIO.');
           return false;
         }

         //Validar que el medico que quiere modificar es el mismo que esta accediendo

         if ( $accion=="update"  && $model->medico->id_usuario !== Yii::$app->user->identity->id && !$cargador){
            $this->setearMensaje('LA CIRUGIA PERTENECE A OTRO MEDICO.');
            return false;
         }
         // SOLO PARA EL CREATE validar que el dia tiene que ser mayor al actualiza
         //Se deja a lo ultimo este metodo es usado tambien por el updateParametros
         // y en el mismo no hay restriccion  sobre el dia

         $fechahoy=date('Y-m-d');
         if($accion=="create"  && $fechahoy>=$dia && !$cargador ){
           $this->setearMensaje('LA FECHA CIRUG??A DEBE SER MAYOR AL D??A ACTUAL.');
           return false;
         }
         $parametrizacion= Parametrizacion::find()->one();

         $date_hoy = date('Y-m-d');
         $date_max = strtotime('+'.$parametrizacion->dias_creacion.' day', strtotime($date_hoy));
          $fecha_limite = date('Y-m-d', $date_max);
          $fecha_limite_form = date('d/m/Y', $date_max);

         if ($dia >= $fecha_limite ){
           $this->setearMensaje('LA FECHA LIMITE ES EL '.$fecha_limite_form);
           return false;

         }

         $dia_sin_cirugias=DiasSinCirugia::find()->
         andWhere(["and","fecha ='".$dia."'"])->one();

         if ($dia_sin_cirugias ){
           $this->setearMensaje('LA FECHA NO ESTA DISPONIBLE PARA CIRUGIAS');
           return false;

         }

         //tengo que a??adir la condicion para el cargador
        if(!$cargador){
           $medico= Medico::find()->where(['id_usuario' => Yii::$app->user->identity->id ])->one();
           $especialidad = Especialidad::find()->where(["id"=>$medico->id_especialidad])->one();
           $dia_semanal = $this->dia_semanal($dia );
           $permitido_dia=false;

           foreach ($especialidad->semanaespecialidads as $dia_sem) {
               if($dia_sem->semana->dia===$dia_semanal){
                 $permitido_dia=true;
               }
           }
         }
       if(!$cargador &&!$permitido_dia){
          $this->setearMensaje('LA ESPECIALIDAD DEL PROFESIONAL, NO TIENE HABILITADA EL DIA '.$dia_semanal);

          return false;
       }

       return true;
     }

     public function validarDespues($datos, $model ,$cargador){
                 if (!isset($datos["observacionquirurgica"]) ){
                   $this->setearMensaje( 'DEBE SELECCIONAR ALGUNA OBSERVACI??N');
                   return false;

                 }
                 if (!isset($datos["cirugiaequipos"]) && ($datos["Cirugiaprogramada"]["otro_equpo"])=="" ){
                   $this->setearMensaje( 'DEBE SELECCIONAR ALG??N EQUIPO');
                   return false;
                 }
                 $parametrizacion= Parametrizacion::find()->one();

                 if ($datos["Cirugiaprogramada"]["hora_inicio"] === $parametrizacion->hora_final ){
                   $this->setearMensaje( 'EL QUIROFANO ESTA TOTALMENTE OCUPADO');
                   return false;

                 }
                 // $mDateI= new \DateTime ( $datos["Cirugiaprogramada"]["cant_tiempo"]);
                 // $mDateF=new \DateTime($datos["Cirugiaprogramada"]["hora_inicio"]);

                 $parts1 = explode(":", $datos["Cirugiaprogramada"]["hora_inicio"]);
                 $cantTiempo = $parts1[2] + $parts1[1]*60 + $parts1[0]*3600;
                 $parts2 = explode(":", $datos["Cirugiaprogramada"]["cant_tiempo"]);
                 $cantTiempo += $parts2[2] + $parts2[1]*60 + $parts2[0]*3600;
                 $horas_usadas= gmdate("H:i:s", $cantTiempo);

                 if ($horas_usadas > $parametrizacion->hora_final && !$cargador ){
                   $this->setearMensaje('EXCEDE LA HORA FINAL PERMITIDA '.$parametrizacion->hora_final);
                   return false;

                 }
              //Verificar si la especialidad tiene  permitido crear una cirugia ese dia

              $medico= Medico::find()->where(["id"=>$datos["Cirugiaprogramada"]["id_medico"]])->one();
              $especialidad = Especialidad::find()->where(["id"=>$medico->id_especialidad])->one();
              $dia_semanal = $this->dia_semanal($datos["Cirugiaprogramada"]["fecha_cirugia"]);
              $permitido_dia=false;

              foreach ($especialidad->semanaespecialidads as $dia_sem) {
                  if($dia_sem->semana->dia===$dia_semanal){
                    $permitido_dia=true;
                  }
              }
            if(!$permitido_dia){
              $this->setearMensaje('LA ESPECIALIDAD DEL PROFESIONAL, NO TIENE HABILITADA EL DIA '.$dia_semanal);
               return false;
            }
             if ($model !==NULL  && ($datos["Cirugiaprogramada"]["hora_inicio"] != $model->horaInicio()) && ($datos["Cirugiaprogramada"]["hora_fin"] > $model->horaInicio())){
                 $this->setearMensaje('LA HORA ESTABLECIDA DE LA CIRUGIA ESTA SUPERPUESTA CON OTRA.');
                return false;

              }
              if ($datos["Cirugiaprogramada"]["fecha_programada"] > $datos["Cirugiaprogramada"]["fecha_cirugia"]){
                  $this->setearMensaje('LA FECHA PROGRAMADA DEBE SER MENOR QUE LA FECHA DE CIRUGIA .');
                 return false;

               }

            return true;

    }

    public function cargarObservaciones($obsquir,$model){
      foreach ($obsquir as $key => $id_obsquir) {
        $modelobservacion_cirugia = new ObservacionCirugia();
        $modelobservacion_cirugia->id_cirugiaprogramada=$model->id;
        $modelobservacion_cirugia->id_observacionquirurgica=$id_obsquir;
        $modelobservacion_cirugia->save();

      }
    }
    public function cargarEquipos($cirugiaequipos,$model){
      foreach ($cirugiaequipos as $key => $id_equipo) {
        $modelCirugiaEquipo = new Cirugiaequipo();
        $modelCirugiaEquipo->id_cirugiaprogramada=$model->id;
        $modelCirugiaEquipo->id_equipo=$id_equipo;
        $modelCirugiaEquipo->save();
      }
    }
    public function actualizarEquipo($diffMenosEquipo,$diffMasEquipo,$model){
      foreach ($diffMenosEquipo as $key => $id_equipo) {
        $modelCirugiaEquipo = Cirugiaequipo::find()->where(["and","id_cirugiaprogramada =".$model->id." and  id_equipo=".$id_equipo])->one();
        $modelCirugiaEquipo->delete();
      }
      foreach ($diffMasEquipo as $key => $id_equipo) {
        $modelCirugiaEquipo = new Cirugiaequipo();
        $modelCirugiaEquipo->id_cirugiaprogramada=$model->id;
        $modelCirugiaEquipo->id_equipo=$id_equipo;
        $modelCirugiaEquipo->save();
      }

    }
    public function actualizarObservacion($diffMenosObservacion,$diffMasObservacion,$model){
      foreach ($diffMenosObservacion as $key => $id_observacion) {
        $modelobservacion_cirugia = ObservacionCirugia::find()->where(["and","id_cirugiaprogramada =".$model->id." and  id_observacionquirurgica=".$id_observacion])->one();
        $modelobservacion_cirugia->delete();
      }
      foreach ($diffMasObservacion as $key => $id_observacion) {
        $modelobservacion_cirugia = new ObservacionCirugia();
        $modelobservacion_cirugia->id_cirugiaprogramada=$model->id;
        $modelobservacion_cirugia->id_observacionquirurgica=$id_observacion;
        $modelobservacion_cirugia->save();
      }

    }


    public function auditoriaCir($diffMasEquipo,$diffMenosEquipo ,$model ,$cloneModel ,$diffMasObservacion,$diffMenosObservacion){
        $despuesEquipos = "";
        $antesEquipos = "";
        $despuesObservacion = "";
        $antesObservacion = "";

        if (!empty($diffMasEquipo) || !empty($diffMenosEquipo) ){
          $cant=1;
          foreach ($model->cirugiaequipos as $cirequpAntes){
              $antesEquipos .="<b>".$cant.":</b>". $cirequpAntes->equipo->descripcion."<br>";
              $cant++;
          }
          $this->actualizarEquipo($diffMenosEquipo,$diffMasEquipo,$model);
            $cant=1;
            $modelActualizado = Cirugiaprogramada::find()->where(["and","id =".$model->id])->one();

            foreach ($modelActualizado->cirugiaequipos as $cirequpDespues) {
                $despuesEquipos .="<b>".$cant.":</b>". $cirequpDespues->equipo->descripcion."<br>";
                $cant++;
            }

        }

        if (!empty($diffMasObservacion) || !empty($diffMenosObservacion) ){
          $cant=1;
          foreach ($model->observacionCirugias as $observCirAntes){
              $antesObservacion .="<b>".$cant.":</b>". $observCirAntes->observacionquirurgica->descripcion."<br>";
              $cant++;
          }
            $this->actualizarObservacion($diffMenosObservacion,$diffMasObservacion,$model);

            $cant=1;
            $modelActualizado = Cirugiaprogramada::find()->where(["and","id =".$model->id])->one();

            foreach ($modelActualizado->observacionCirugias as $observCirDespues) {
                $despuesObservacion .="<b>".$cant.":</b>". $observCirDespues->observacionquirurgica->descripcion."<br>";
                $cant++;
            }

        }


        $differences = array_diff($cloneModel->getOldAttributes(), $model->getAttributes());
        if (  $despuesEquipos !=="" || !empty($differences) ||  $despuesObservacion!=="" ){
          $log=new Auditoria();
          $log->id_usuario= Yii::$app->user->identity->id_user;
          $log->accion= "MODIFICACI??N";
          $log->tabla=  "Cirugiaprogramada";
          $log->fecha= date("d/m/Y");
          $log->hora= date("H:i:s");
          $log->ip=  $_SERVER['REMOTE_ADDR'];
          $log->informacion_usuario= $_SERVER['HTTP_USER_AGENT'];
            // new attributes
              $newattributes = $model->getAttributes();
              $oldattributes = $cloneModel->getOldAttributes();
            // compare old and new
             $changes="";
             foreach ($newattributes as $name => $value) {
                if (!empty($oldattributes)) {
                    $old = $oldattributes[$name];
                    } else {
                          $old = '';
                    }
                    if ($value != $old) {
                       $changes = $changes .$name .' (Antes)='.$old.'</br>'.$name.' (Despu??s)='. $value.'</br>';
                      }
              }
              if (  $despuesEquipos !=="" ){
                      $changes = $changes .'Equipos  (Antes)= </br>'.$antesEquipos.'</br> Equipos (Despu??s)= </br>'. $despuesEquipos.'</br>';
                }
              if (  $despuesObservacion !=="" ){
                    $changes = $changes .'Observacion  (Antes)= </br>'.$antesObservacion.'</br> Observacion (Despu??s)= </br>'. $despuesObservacion.'</br>';
              }


            $registro=  Html::a( "Ver", ["cirugiaprogramada/view","id"=>  $model->getPrimaryKey()]

                ,[    'class' => 'text-success','title'=>'Datos', 'target'=>'_blank','data-toggle'=>'tooltip' ]
               ).'</br>';

          $log->cambios= "Registro modificado: " .$registro.$changes;

          $log->save();
        }

    }


    public function actionCreate($dia){
      //Verifico si es cargador de cir programadas sin ser medico
      $usuario= Usuario::find()->where(['id'=>Yii::$app->user->identity->id])->one();
      $cargador= $usuario->isCargador();
      ////////////PACIENTE/////////////////
      $modelPac= new Paciente();
      $searchModelPac = new PacienteSearch();
      $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
      $dataProviderPac->pagination->pageSize=7;
      ////////////MEDICO/////////////////
      $modelMed= new Medico();
      $searchModelMed = new MedicoSearch();
      $dataProviderMed = $searchModelMed->search(Yii::$app->request->queryParams);
      $dataProviderMed->pagination->pageSize=7;
      //Obtenemos los equipos
      $model = new Cirugiaprogramada();
      $equipos=[];
      $observacion=[];
      //Validacion antes de enviar los datos
        if(!$this->validarAntes($dia,  $model->load($this->request->post()),"create",$cargador)){
          return $this->redirect(["cirugiaprogramada/fecha", "dia"=>$dia ]);
        }
          //se valido en validarAntes si el resultado da vacio
          $quirofano= $model->quirofanos($dia)[0];

          $tiempo_default= $this->cantidadTiempo($dia,$quirofano);
          $list = $this->listadequipos($dia,null,"create") ;
          $listobs= ArrayHelper::map(Observacionquirurgica::find()->where('activo = true')->all(), 'id', 'descripcion');

          $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);

        if ($this->request->isPost) {

            (!isset($_POST["cirugiaequipos"]) )? $cirugiaequipos=[]: $cirugiaequipos=$_POST["cirugiaequipos"];
            (!isset($_POST["observacionquirurgica"]) )? $obsquir=[]: $obsquir=$_POST["observacionquirurgica"];
            $equipos=array_values($cirugiaequipos);
            $observacion=array_values($obsquir);
            //Validacion despues de enviar los datos

            if(!$this->validarDespues($_POST , null,$cargador)){
              $medico= Medico::findOne(['id' => $_POST["Cirugiaprogramada"]["id_medico"]]);
              $model->loadDefaultValues();

              return $this->render('_form', [
                  'model' => $model,
                  'searchModelPac' => $searchModelPac,
                  'dataProviderPac' => $dataProviderPac,
                  'searchModelMed' => $searchModelMed,
                  'dataProviderMed' => $dataProviderMed,
                  'dia'=>$dia,
                  'medico'=>$medico,
                  'tiempo' => $tiempo_default,
                  'list'=> $list,
                  'listobs' => $listobs,
                  'quirofano'=> $quirofano,
                   'cargador' => $cargador,
                   'estado'=>1,
                   'equipos'=>$equipos,
                   'observacion'=>$observacion

              ]);
            }


            if ($model->load($this->request->post()) && $model->save()) {
              $quirofano= Quirofano::find()->where(['id'=>$_POST["Cirugiaprogramada"]["id_quirofano"]])->one();

              if($quirofano->necesita_anestesiologo){
                $anestesiologo=$quirofano->anestesiologo($this->dia_semanal($dia),$quirofano->id );
                 $model->id_anestesiologo= $anestesiologo->id;
              }
              //estado PENDIENTE
                $model->id_estado= 1;

               $model->save();
              $this->cargarObservaciones($obsquir,$model);
              $this->cargarEquipos($cirugiaequipos,$model);
              // $historia_rang
              return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        else {
          //loadDefaultValues ??????() para completar los valores predeterminados definidos por la base de datos en los atributos de Active Record correspondientes
            $model->loadDefaultValues();
        }
        $model->loadDefaultValues();

        return $this->render('_form', [
            'model' => $model,
            'searchModelPac' => $searchModelPac,
            'dataProviderPac' => $dataProviderPac,
            'searchModelMed' => $searchModelMed,
            'dataProviderMed' => $dataProviderMed,
            'dia'=>$dia,
            'medico'=>$medico,
            'tiempo' => $tiempo_default,
            'list'=> $list,
            'listobs' => $listobs,
            'quirofano'=> $quirofano,
             'cargador' => $cargador,
             'estado'=>1,
             'equipos'=>$equipos,
             'observacion'=>$observacion

        ]);
    }

    /**
     * Updates an existing Cirugiaprogramada model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id){
      //Verifico si es cargador de cir programadas sin ser medicoV

        $usuario= Usuario::find()->where(['id'=>Yii::$app->user->identity->id])->one();
        $cargador= $usuario->isCargador();
        $model = $this->findModel($id);
        ////////////PACIENTE/////////////////
        $modelPac= new Paciente();
        $searchModelPac = new PacienteSearch();
        $dataProviderPac = $searchModelPac->search(Yii::$app->request->queryParams);
        $dataProviderPac->pagination->pageSize=7;
        ////////////MEDICO/////////////////
        $modelMed= new Medico();
        $searchModelMed = new MedicoSearch();
        $dataProviderMed = $searchModelMed->search(Yii::$app->request->queryParams);
        $dataProviderMed->pagination->pageSize=7;
        $list = $this->listadequipos($model->fecha_cirugia,$id,"update") ;
        $listobs= ArrayHelper::map(Observacionquirurgica::find()->where('activo = true')->all(), 'id', 'descripcion');
        $clonedModel = clone $model;
      if($this->request->isPost ){
            (!isset($_POST["cirugiaequipos"]) )? $cirugiaequipos=[]: $cirugiaequipos=$_POST["cirugiaequipos"];
            (!isset($_POST["observacionquirurgica"]) )? $obsquir=[]: $obsquir=$_POST["observacionquirurgica"];

          if(!$this->validarDespues($_POST,$model,$cargador)){

            return $this->render('_form', [
              'model' => $model,
              'searchModelPac' => $searchModelPac,
              'dataProviderPac' => $dataProviderPac,
              'searchModelMed' => $searchModelMed,
              'dataProviderMed' => $dataProviderMed,
              'cargador' => $cargador,
              'medico'=>$model->medico,
              'dia'=>$model->fecha_cirugia,
              'tiempo'=>$model->hora_inicio,
              'list'=>$list,
              'listobs' => $listobs,
              'estado'=>$model->id_estado,
              'equipos'=>$cirugiaequipos,
              'observacion'=>$obsquir


            ]);
        }
        //desde el form se restrige, que una vez modificada a REPROGRAMADA O ANULADA no se puede volver a modificar.
        if (($model->estado->descripcion=='PENDIENTE') && ($_POST["Cirugiaprogramada"]["id_estado"]==2 ||$_POST["Cirugiaprogramada"]["id_estado"] ==3 )) {
              $model->actualizarHora();
        }
        if ($model->load($this->request->post()) && $model->save()) {
          $cirEquiposBase= ArrayHelper::map(Cirugiaequipo::find()->where('id_cirugiaprogramada = '.$model->id)->all(), 'id', 'id_equipo');
          $cirObservacionBase= ArrayHelper::map(ObservacionCirugia::find()->where('id_cirugiaprogramada = '.$model->id)->all(), 'id', 'id_observacionquirurgica');

          $diffMasEquipo = array_diff($cirugiaequipos ,$cirEquiposBase );
          $diffMenosEquipo = array_diff($cirEquiposBase,$cirugiaequipos );

          $diffMasObservacion= array_diff($obsquir ,$cirObservacionBase );
          $diffMenosObservacion = array_diff($cirObservacionBase,$obsquir );

           $this->auditoriaCir($diffMasEquipo,$diffMenosEquipo ,$model ,$clonedModel ,$diffMasObservacion,$diffMenosObservacion );

            $quirofano= Quirofano::find()->where(['id'=>$_POST["Cirugiaprogramada"]["id_quirofano"]])->one();
            if($quirofano->necesita_anestesiologo){
              $anestesiologo=$quirofano->anestesiologo($this->dia_semanal($model->fecha_cirugia),$quirofano->id );
               $model->id_anestesiologo= $anestesiologo->id;
               $model->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }
      }
        // $medico= Medico::findOne(['id_usuario' => Yii::$app->user->identity->id ]);
        if(!$this->validarAntes($model->fecha_cirugia,  $model, "update",$cargador )){
          return $this->redirect(["index"]);
        }

        $listadoObservacion= ArrayHelper::map(ObservacionCirugia::find()->where(['id_cirugiaprogramada' => $id])->all(), 'id', 'id_observacionquirurgica');
        $observacion=array_values($listadoObservacion);
        $listadoEquipos= ArrayHelper::map(Cirugiaequipo::find()->where(['id_cirugiaprogramada' => $id])->all(), 'id', 'id_equipo');
        $equipos=array_values($listadoEquipos);

        return $this->render('_form', [
            'model' => $model,
            'searchModelPac' => $searchModelPac,
            'dataProviderPac' => $dataProviderPac,
            'searchModelMed' => $searchModelMed,
            'dataProviderMed' => $dataProviderMed,
            'cargador' => $cargador,
            'medico'=>$model->medico,
            'dia'=>$model->fecha_cirugia,
            'tiempo'=>$model->hora_inicio,
            'list'=>$list,
            'listobs' => $listobs,
            'estado'=>$model->id_estado,
            'equipos'=>$equipos,
            'observacion'=>$observacion
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

    public function calculoHoras($hora_inicio, $hora_final){

        $inicio= new \DateTime($hora_inicio);
        $fin=new \DateTime($hora_final);
        $tiempo = $inicio->diff($fin);
        $minutos=$tiempo->format('%i')/60;
        $hora=$tiempo->format('%h');
        $cantHoras= $hora +$minutos;
      return $cantHoras;

    }
  public function porcentaje($quirofano,$fecha){

      $historial_rango= HistorialRangoHorario::find()->where(["and","fecha <= '".$fecha."'"])->orderBy(['id'=>SORT_DESC])->one();

      $horas_disponibles= $this->calculoHoras($historial_rango->hora_inicio,$historial_rango->hora_final);

      $cirugia_programada= Cirugiaprogramada::find()
      ->where(["and","id_quirofano   =".$quirofano->id." and fecha_cirugia= '".$fecha."'"])
      ->orderBy(['id'=>SORT_DESC])
      ->one();
      // $HU= WiewHorasOcupadas::find()->select(['horas_ocupadas'])
      // ->where(["and","id_quirofano   =".$quirofano->id." and fecha_cirugia= '".$fecha."'"])->one();
      if(!$quirofano->necesita_anestesiologo and isset($cirugia_programada->hora_fin)){

              $horas_usadas= $this->calculoHoras($historial_rango->hora_inicio,$cirugia_programada->hora_fin);

      }elseif(isset($cirugia_programada->id_anestesiologo)){
        //Si existe la cirugia programada entonces selecciono aquella donde el anestesiologo este en dos o mas quirofanos
        //obtengo la cirugia programada donde la hora fin sea mayor, porque esta representara la hora de inicio para cualquier
        //quirofano donde este el anestesiologo, si este esta asociado a un solo quirofano igual la consulta sera valida
        $cirugia_programadaAnest= Cirugiaprogramada::find()->select(['hora_fin'])
        ->where(["and","id_anestesiologo   =".$cirugia_programada->id_anestesiologo." and fecha_cirugia= '".$fecha."'"])
        ->orderBy(['hora_fin'=>SORT_DESC])
        ->one();
        $horas_usadas= $this->calculoHoras($historial_rango->hora_inicio,$cirugia_programadaAnest->hora_fin);

      }else {
        $horas_usadas=0;
      }

      $porcentaje=100*$horas_usadas/$horas_disponibles;
      $porcentaje=round($porcentaje, 0);   // Quitar los decimales
      return ($porcentaje);

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
                    $valor=$this->porcentaje($quirofano,$fecha);
                    if(trim($valor) >='100'){
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
        $dataProvider->pagination->pageSize=7;
        $dias_semanales= DiasSemanales::find()->where(['habilitado'=>false])->all();
        $dias_habilitados=[];
        foreach ($dias_semanales as $dia_semanal) {
          $dias_habilitados[] = ($dia_semanal->numero_semanal ===7)? 0:$dia_semanal->numero_semanal;
        }
         return $this->render('calendario', [
            'events' => $tasks,
            'searchModel'=>$searchModel,
            'dataProvider' =>$dataProvider,
            'dias_habilitados' => $dias_habilitados
          ]);
        }


    public function actionBuscar(){
          $searchModel = new CirugiaprogramadaSearch();
          $dataProvider = $searchModel->searchdispo($this->request->queryParams);
        }
        //la fecha tiene que estar en formato d-m-y
    public function calcular_edad($id){

          $Solicitud =  Solicitud::findOne($id);
          list($ano,$mes,$dia) = explode("-",$Solicitud->paciente->fecha_nacimiento);
          list($anoR,$mesR,$diaR) = explode("-",$Solicitud->fecharealizacion);


          $ano_diferencia  = $anoR - $ano;
          $mes_diferencia = $mesR - $mes;
          $dia_diferencia   = $diaR - $dia;
          if ( $mes_diferencia < 0)
          {
            $ano_diferencia--;
          }
          elseif ( $mes_diferencia == 0){
            if ( $dia_diferencia < 0)
                $ano_diferencia--;
            }
            return $ano_diferencia;
          }


   public function actionInforme($id) {

          $request = Yii::$app->request;
          if($request->isAjax){
            $cirugia_programada=$this->findModel($id);
            return $this->render('pdfcirugia',['model' => $cirugia_programada, 'edad'=>4]); //$this->calcular_edad($biopsia->id_solicitudbiopsia) ]);
            }else {
              $cirugia_programada=$this->findModel($id);
              return $this->render('pdfcirugia',['model' => $cirugia_programada, 'edad'=>4]); //$this->calcular_edad($biopsia->id_solicitudbiopsia) ]);
            }

      }


}
