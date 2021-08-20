<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "horas".
 *
 * @property int $id
 * @property string $numero
 *
 * @property Cirugiaprogramada[] $cirugiaprogramadas
 */
class Horas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'numero' => 'Numero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaprogramadas()
    {
        return $this->hasMany(Cirugiaprogramada::className(), ['id_cant_hora' => 'id']);
    }
}
