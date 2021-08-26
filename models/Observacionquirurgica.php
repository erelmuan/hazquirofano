<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observacionquirurgica".
 *
 * @property int $id
 * @property string $descripcion
 * @property bool $activo
 *
 * @property ObservacionCirugia[] $observacionCirugias
 */
class Observacionquirurgica extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'observacionquirurgica';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['activo'], 'boolean'],
            [['descripcion'], 'string', 'max' => 37],
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
            'activo' => 'Activo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacionCirugias()
    {
        return $this->hasMany(ObservacionCirugia::className(), ['id_observacionquirurgica' => 'id']);
    }
}
