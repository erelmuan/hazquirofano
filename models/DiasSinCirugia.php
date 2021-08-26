<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dias_sin_cirugia".
 *
 * @property int $id
 * @property string $fecha
 * @property string $motivo
 */
class DiasSinCirugia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dias_sin_cirugia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha','motivo'], 'required'],
            [['fecha'], 'safe'],
            [['motivo'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fecha' => 'Fecha',
            'motivo' => 'Motivo',
        ];
    }
}
