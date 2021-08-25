<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "historial_rango_horario".
 *
 * @property int $id
 * @property int $id_cirugia_programada
 * @property string $hora_inicio
 * @property string $hora_final
 *
 * @property Cirugiaprogramada $cirugiaProgramada
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
            [['id_cirugia_programada'], 'default', 'value' => null],
            [['id_cirugia_programada'], 'integer'],
            [['hora_inicio', 'hora_final'], 'safe'],
            [['id_cirugia_programada'], 'exist', 'skipOnError' => true, 'targetClass' => Cirugiaprogramada::className(), 'targetAttribute' => ['id_cirugia_programada' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cirugia_programada' => 'Id Cirugia Programada',
            'hora_inicio' => 'Hora Inicio',
            'hora_final' => 'Hora Final',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaProgramada()
    {
        return $this->hasOne(Cirugiaprogramada::className(), ['id' => 'id_cirugia_programada']);
    }
}
