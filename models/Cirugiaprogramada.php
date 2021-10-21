<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;
 use app\components\behaviors\AuditoriaBehaviors;
/**
 * This is the model class for table "cirugiaprogramada".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_medico
* @property string $procedimiento
 * @property int $id_anestesia
 * @property string $fecha_programada
 * @property string $hora_inicio
	* @property string $cant_tiempo
 * @property string $ayudantes
 * @property string $lado
 * @property string $fecha_cirugia
 * @property string $observacion
 * @property string $diagnostico
 * @property int $id_quirofano
 * @property string $material_protesis
 * @property string $otro_equpo
 * @property int $id_estado
 * @property int id_anestesiologo

 * @property string $hora_fin
* @property Anestesiologo $anestesiologo
 * @property Cirugiaequipo[] $cirugiaequipos
 * @property Anestesia $anestesia
 * @property WiewIntervaloTiempo $cant_tiempo
 * @property Medico $medico
 * @property Paciente $paciente
 * @property Procedimiento $procedimiento
 * @property Quirofano $quirofano
 * @property ObservacionCirugia[] $observacionCirugias
 * @property Estado $estado
 */

class Cirugiaprogramada extends \yii\db\ActiveRecord
{

  public function behaviors()
    {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cirugiaprogramada';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
          [['id_paciente', 'id_medico', 'id_anestesia', 'fecha_programada', 'hora_inicio', 'ayudantes', 'diagnostico', 'id_quirofano', 'procedimiento', 'id_estado'], 'required'],
    		           [['id_paciente', 'id_medico', 'id_anestesia', 'id_quirofano','id_estado'], 'default', 'value' => null],
    		           [['id_paciente', 'id_medico', 'id_anestesia', 'id_quirofano','id_estado'], 'integer'],
    		           [['fecha_programada', 'hora_inicio', 'fecha_cirugia', 'cant_tiempo','hora_fin'], 'safe'],
    		           [['ayudantes', 'lado', 'observacion', 'diagnostico', 'material_protesis', 'otro_equpo', 'procedimiento'], 'string'],
            [['id_anestesia'], 'exist', 'skipOnError' => true, 'targetClass' => Anestesia::className(), 'targetAttribute' => ['id_anestesia' => 'id']],
            [['id_medico'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['id_medico' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_quirofano'], 'exist', 'skipOnError' => true, 'targetClass' => Quirofano::className(), 'targetAttribute' => ['id_quirofano' => 'id']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_anestesiologo'], 'exist', 'skipOnError' => true, 'targetClass' => Anestesiologo::className(), 'targetAttribute' => ['id_anestesiologo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_paciente' => 'Id Paciente',
            'id_medico' => 'Id Medico',
            'procedimiento' => 'Procedimiento',
            'id_anestesia' => 'Id Anestesia',
            'fecha_programada' => 'Fecha Programada',
            'hora_inicio' => 'Hora Inicio',
           'cant_tiempo' => 'Cant Tiempo',
           'ayudantes' => 'Ayudantes',
            'lado' => 'Lado',
            'fecha_cirugia' => 'Fecha Cirugia',
            'observacion' => 'Observacion',
            'diagnostico' => 'Diagnostico',
            'id_quirofano' => 'Id Quirofano',
            'material_protesis' => 'Material Protesis',
            'otro_equpo' => 'Otro Equpo',
            'id_estado' => 'Id Estado',
            'id_anestesiologo' => 'Id Anestesiologo',
             'hora_fin' => 'Hora Fin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaequipos()
    {
        return $this->hasMany(Cirugiaequipo::className(), ['id_cirugiaprogramada' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnestesia()
    {
        return $this->hasOne(Anestesia::className(), ['id' => 'id_anestesia']);
    }
    public function getAnestesias()
    {
      return ArrayHelper::map(Anestesia::find()->all(), 'id','descripcion');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedico()
    {
        return $this->hasOne(Medico::className(), ['id' => 'id_medico']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacionCirugias()
    {
        return $this->hasMany(ObservacionCirugia::className(), ['id_cirugiaprogramada' => 'id']);
    }



    public function getCantTiempo()
    {
      return ArrayHelper::map(WiewIntervaloTiempo::find()->all(), 'tiempo','tiempo');
    }
    /**
   * @return \yii\db\ActiveQuery
   */
  public function getEstado()
  {
      return $this->hasOne(Estado::className(), ['id' => 'id_estado']);
  }
  public function getEstados()
  {
      return ArrayHelper::map(Estado::find()->all(), 'id','descripcion');
  }


  public function getAnestesiologo()
  {
 		 return $this->hasOne(Anestesiologo::className(), ['id' => 'id_anestesiologo']);
  }

  /**
   * @return \yii\db\ActiveQuery
   */
  public function getQuirofano()
  {
      return $this->hasOne(Quirofano::className(), ['id' => 'id_quirofano']);
  }
  public function getQuirofanos() {
    // cirugias y quirofano para este dia
      return
      ArrayHelper::map(
        Quirofano::find()
      ->orderBy(['id'=>SORT_ASC])
      ->where(['and','habilitado= true' ])
      ->all()
      , 'id','nombre');

  }
  public function dia_semanal($dia) {

      $nombreDias = array('DOMINGO','LUNES','MARTES','MIERCOLES','JUEVES','VIERNES','SABADO');
      $nombre_del_dia = $nombreDias[date('N', strtotime($dia))];
      return $nombre_del_dia;

  }
  public function quirofanos($dia) {
    // cirugias y quirofano para este dia
      return
        Quirofano::find()->orderBy(['id'=>SORT_ASC])
        ->leftJoin('quirofano_anestesiologo', 'quirofano.id = quirofano_anestesiologo.id_quirofano')
        ->leftJoin('anestesiologo_semana', 'anestesiologo_semana.id_anestesiologo = quirofano_anestesiologo.id_anestesiologo')
        ->leftJoin('dias_semanales', 'dias_semanales.id = anestesiologo_semana.id_semana')
        ->where(['and',"dias_semanales.dia='".$this->dia_semanal($dia)."' and quirofano.habilitado= true" ])
        ->orWhere(['or','necesita_anestesiologo= false' ])
        ->all();

  }
  public function horaInicio() {
    // cirugias y quirofano para este dia
      if($this->quirofano->necesita_anestesiologo){
          $cirugia=Cirugiaprogramada::find()->orderBy(['hora_inicio'=>SORT_DESC])
          ->where(['and',"fecha_cirugia='".$this->fecha_cirugia.
          "' and id_anestesiologo=".$this->id_anestesiologo ])
          ->one();
        }else {
          $cirugia=Cirugiaprogramada::find()->orderBy(['hora_inicio'=>SORT_DESC])
          ->where(['and',"fecha_cirugia='".$this->fecha_cirugia."' and id_quirofano=".$this->id_quirofano ])
          ->one();
        }
        return $cirugia->hora_inicio;
  }
  public function actualizarHora(){
    if($this->quirofano->necesita_anestesiologo){
        Yii::$app->db->createCommand("UPDATE cirugiaprogramada
          SET hora_inicio= hora_inicio - '".$this->cant_tiempo. "' , hora_fin= hora_fin - '".$this->cant_tiempo. "'
           WHERE fecha_cirugia ='".$this->fecha_cirugia."' AND hora_inicio > '". $this->hora_inicio ."' AND id !=".$this->id." AND id_anestesiologo=".$this->id_anestesiologo
        )
                    ->queryAll();
      }else {
        Yii::$app->db->createCommand("UPDATE cirugiaprogramada
          SET hora_inicio= hora_inicio - '".$this->cant_tiempo. "' , hora_fin= hora_fin - '".$this->cant_tiempo. "' WHERE fecha_cirugia ='"
        .$this->fecha_cirugia."' AND id_quirofano =".
        $this->id_quirofano ." AND hora_inicio > '". $this->hora_inicio ."' AND id !=".$this->id)
                    ->queryAll();
      }
  }



}
