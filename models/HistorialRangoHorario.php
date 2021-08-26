<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historial_rango_horario".
 *
 * @property int $id
 * @property string $hora_inicio
 * @property string $hora_final
 * @property string $fecha
 */
class HistorialRangoHorario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'historial_rango_horario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hora_inicio', 'hora_final', 'fecha'], 'required'],
            [['hora_inicio', 'hora_final', 'fecha'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hora_inicio' => 'Hora Inicio',
            'hora_final' => 'Hora Final',
            'fecha' => 'Fecha',
        ];
    }
}
