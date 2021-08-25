<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wiew_horas_ocupadas".
 *
 * @property string $fecha_cirugia
 * @property string $horas_ocupadas
 * @property int $id_quirofano
 * @property string $descripcion
 */
class WiewHorasOcupadas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wiew_horas_ocupadas';
    }
    public static function primaryKey()
    {
    return ['fecha_cirugia','horas_ocupadas','id_quirofano'];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_cirugia'], 'safe'],
            [['horas_ocupadas', 'descripcion'], 'string'],
            [['id_quirofano'], 'default', 'value' => null],
            [['id_quirofano'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fecha_cirugia' => 'Fecha Cirugia',
            'horas_ocupadas' => 'Horas Ocupadas',
            'id_quirofano' => 'Id Quirofano',
            'descripcion' => 'Descripcion',
        ];
    }
}
