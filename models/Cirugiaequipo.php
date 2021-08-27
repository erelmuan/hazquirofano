<?php

namespace app\models;

use Yii;
use app\components\behaviors\AuditoriaBehaviors;

/**
 * This is the model class for table "cirugiaequipo".
 *
 * @property int $id
 * @property int $id_cirugiaprogramada
 * @property int $id_equipo
 *
 * @property Cirugiaprogramada $cirugiaprogramada
 * @property Equipo $equipo
 */
class Cirugiaequipo extends \yii\db\ActiveRecord
{
  // SE DEBE CAMBIAR ESTE COMPORTAMIENTO!!!! PARA CON UAN AUDITORIA BEHAVIORS
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
        return 'cirugiaequipo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cirugiaprogramada', 'id_equipo'], 'required'],
            [['id_cirugiaprogramada', 'id_equipo'], 'default', 'value' => null],
            [['id_cirugiaprogramada', 'id_equipo'], 'integer'],
            [['id_cirugiaprogramada'], 'exist', 'skipOnError' => true, 'targetClass' => Cirugiaprogramada::className(), 'targetAttribute' => ['id_cirugiaprogramada' => 'id']],
            [['id_equipo'], 'exist', 'skipOnError' => true, 'targetClass' => Equipo::className(), 'targetAttribute' => ['id_equipo' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cirugiaprogramada' => 'Id Cirugiaprogramada',
            'id_equipo' => 'Id Equipo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaprogramada()
    {
        return $this->hasOne(Cirugiaprogramada::className(), ['id' => 'id_cirugiaprogramada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEquipo()
    {
        return $this->hasOne(Equipo::className(), ['id' => 'id_equipo']);
    }
}
