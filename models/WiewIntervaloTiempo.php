<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wiew_intervalo_tiempo".
 *
 * @property string $tiempo
 */
class WiewIntervaloTiempo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'wiew_intervalo_tiempo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tiempo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tiempo' => 'Tiempo',
        ];
    }
}
