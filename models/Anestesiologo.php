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
 * @property Cirugiaprogramada[] $cirugiaprogramadas
 * @property QuirofanoAnestesiologo[] $quirofanoAnestesiologos
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
    public function attributeColumns()
    {
        return [
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'id',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'nombre',
          ],

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnestesiologoSemanas()
    {
        return $this->hasMany(AnestesiologoSemana::className(), ['id_anestesiologo' => 'id']);
    }

    public function getCirugiaprogramadas()
 		   {
 		       return $this->hasMany(Cirugiaprogramada::className(), ['id_anestesiologo' => 'id']);
 		   }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuirofanoAnestesiologos()
    {
        return $this->hasMany(QuirofanoAnestesiologo::className(), ['id_anestesiologo' => 'id']);
    }
}
