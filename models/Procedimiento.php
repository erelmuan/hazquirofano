<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedimiento".
 *
 * @property string $descripcion
 * @property string $codigo
 * @property int $id
 *
 * @property Cirugiaprogramada[] $cirugiaprogramadas
 */
class Procedimiento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procedimiento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['codigo'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'descripcion' => 'Descripcion',
            'codigo' => 'Codigo',
            'id' => 'ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaprogramadas()
    {
        return $this->hasMany(Cirugiaprogramada::className(), ['id_procedimiento' => 'id']);
    }
}
