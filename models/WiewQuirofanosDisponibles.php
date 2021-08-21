<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "wiew_quirofanos_disponibles".
 *
 * @property string $fecha_cirugia
 * @property string $hora_inicio
 * @property string $hora_final
 * @property int $id_quirofano
 * @property string $descripcion
 * @property Quirofano $quirofano
 */
class WiewQuirofanosDisponibles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wiew_quirofanos_disponibles';
    }
    public static function primaryKey()
    {
    return ['fecha_cirugia','hora_inicio','hora_final','id_quirofano'];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_cirugia', 'hora_inicio', 'hora_final'], 'safe'],
            [['id_quirofano'], 'default', 'value' => null],
            [['id_quirofano'], 'integer'],
            [['descripcion'], 'string'],
            [['id_quirofano'], 'exist', 'skipOnError' => true, 'targetClass' => Quirofano::className(), 'targetAttribute' => ['id_quirofano' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fecha_cirugia' => 'Fecha Cirugia',
            'hora_inicio' => 'Hora Inicio',
            'hora_final' => 'Hora Final',
            'id_quirofano' => 'Id Quirofano',
            'descripcion' => 'Descripcion',
        ];
    }
    public function getQuirofano()
    {
        return $this->hasOne(Quirofano::className(), ['id' => 'id_quirofano']);
    }
    public function getQuirofanos() {
        return ArrayHelper::map(Quirofano::find()->where(['and','habilitado= true' ])->all(), 'id','nombre');
    }
}
