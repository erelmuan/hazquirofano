<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parametrizacion".
 *
 * @property int $id
 * @property string $hora_inicio
 * @property string $hora_final
 * @property int $dias_anticipacion
 * @property int $dias_creacion
 * @property string $horario_minimo
  * @property int $niveles
 */
class Parametrizacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parametrizacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hora_inicio', 'hora_final', 'horario_minimo'], 'safe'],
            [['dias_anticipacion', 'dias_creacion'], 'default', 'value' => null],
            [['dias_anticipacion', 'dias_creacion','niveles'], 'integer'],
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
            'dias_anticipacion' => 'Dias Anticipacion',
            'dias_creacion' => 'Dias Creacion',
            'horario_minimo' => 'Horario Minimo',
            'niveles' => 'Niveles', 
        ];
    }
}
