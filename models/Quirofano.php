<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quirofano".
 *
 * @property int $id
 * @property string $nombre
 * @property string $observacion
 *
 * @property Cirugiaprogramada[] $cirugiaprogramadas
 */
class Quirofano extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quirofano';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'observacion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'observacion' => 'Observacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaprogramadas()
    {
        return $this->hasMany(Cirugiaprogramada::className(), ['id_quirofano' => 'id']);
    }
}
