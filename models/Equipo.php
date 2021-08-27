<?php

namespace app\models;

use Yii;
 use app\components\behaviors\AuditoriaBehaviors;
/**
 * This is the model class for table "equipo".
 *
 * @property int $id
 * @property string $descripcion
 * @property int $dias
 * @property bool $activo
 *
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
            [['dias'], 'default', 'value' => null],
            [['dias'], 'integer'],
            [['activo'], 'boolean'],
            [['descripcion'], 'string', 'max' => 35],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaequipos()
    {
        return $this->hasMany(Cirugiaequipo::className(), ['id_equipo' => 'id']);
    }
}
