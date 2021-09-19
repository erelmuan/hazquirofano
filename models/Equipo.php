<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;
 use app\components\behaviors\AuditoriaBehaviors;
/**
 * This is the model class for table "equipo".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $dias
 * @property bool $activo
 * @property int $id_especialidad
 * @property Especialidad $especialidad
 * @property Cirugiaequipo[] $cirugiaequipos
 */
class Equipo extends \yii\db\ActiveRecord
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
        return 'equipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dias', 'id_especialidad'], 'default', 'value' => null],
            [['dias', 'id_especialidad'], 'integer'],
            [['activo'], 'boolean'],
            [['descripcion'], 'string', 'max' => 35],
             		           [['id_especialidad'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['id_especialidad' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'dias' => 'Dias',
            'activo' => 'Activo',
           'id_especialidad' => 'Id Especialidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaequipos()
    {
        return $this->hasMany(Cirugiaequipo::className(), ['id_equipo' => 'id']);
    }
    /**
      * @return \yii\db\ActiveQuery
      */
     public function getEspecialidad()
     {
         return $this->hasOne(Especialidad::className(), ['id' => 'id_especialidad']);
     }
     public function getEspecialidades() {
         return ArrayHelper::map(Especialidad::find()->orderBy(['id'=>SORT_ASC])->all(), 'id','profesion');

     }
}
