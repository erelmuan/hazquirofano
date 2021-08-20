<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

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

 * @property Cirugiaequipo[] $cirugiaequipos
 * @property Anestesia $anestesia
 * @property Horas $cantHora
 * @property Medico $medico
 * @property Paciente $paciente
 * @property Procedimiento $procedimiento
 * @property Quirofano $quirofano
 * @property ObservacionCirugia[] $observacionCirugias
 * @property Estado $estado
 */
class Cirugiaprogramada extends \yii\db\ActiveRecord
{

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
    		           [['fecha_programada', 'hora_inicio', 'fecha_cirugia', 'cant_tiempo'], 'safe'],
    		           [['ayudantes', 'lado', 'observacion', 'diagnostico', 'material_protesis', 'otro_equpo', 'procedimiento'], 'string'],
            [['id_anestesia'], 'exist', 'skipOnError' => true, 'targetClass' => Anestesia::className(), 'targetAttribute' => ['id_anestesia' => 'id']],
            [['id_medico'], 'exist', 'skipOnError' => true, 'targetClass' => Medico::className(), 'targetAttribute' => ['id_medico' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
            [['id_quirofano'], 'exist', 'skipOnError' => true, 'targetClass' => Quirofano::className(), 'targetAttribute' => ['id_quirofano' => 'id']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
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
    public function getAnestesias()
    {
      return ArrayHelper::map(Anestesia::find()->all(), 'id','descripcion');
    }


    public function getCantTiempo()
    {
      return ArrayHelper::map(Horas::find()->all(), 'numero','numero');
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
  /**
   * @return \yii\db\ActiveQuery
   */
  public function getQuirofano()
  {
      return $this->hasOne(Quirofano::className(), ['id' => 'id_quirofano']);
  }
  public function getQuirofanos() {
      return ArrayHelper::map(Quirofano::find()->all(), 'id','nombre');
  }
}
