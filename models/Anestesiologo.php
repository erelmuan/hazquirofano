<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anestesiologo".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property AnestesiologoSemana[] $anestesiologoSemanas
 * @property Quirofano[] $quirofanos
 */
class Anestesiologo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anestesiologo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnestesiologoSemanas()
    {
        return $this->hasMany(AnestesiologoSemana::className(), ['id_anestesiologo' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuirofanos()
    {
        return $this->hasMany(Quirofano::className(), ['id_anestesiologo' => 'id']);
    }
}
