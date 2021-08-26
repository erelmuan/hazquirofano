<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dias_semanales".
 *
 * @property int $id
 * @property string $dia
 * @property int $numero_semanal
 * @property bool $habilitado
 */
class DiasSemanales extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dias_semanales';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dia'], 'string'],
            [['numero_semanal'], 'default', 'value' => null],
            [['numero_semanal'], 'integer'],
            [['habilitado'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia' => 'Dia',
            'numero_semanal' => 'Numero Semanal',
            'habilitado' => 'Habilitado',
        ];
    }
}
