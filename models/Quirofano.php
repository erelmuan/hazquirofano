<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quirofano".
 *
 * @property int $id
 * @property string $nombre
 * @property string $observacion
 * @property bool $habilitado
* @property bool $necesita_anestesiologo
 * @property Cirugiaprogramada[] $cirugiaprogramadas
 * @property QuirofanoAnestesiologo[] $quirofanoAnestesiologos
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
            [['habilitado', 'necesita_anestesiologo'], 'boolean'],

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
            'habilitado' => 'Habilitado'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaprogramadas()
    {
        return $this->hasMany(Cirugiaprogramada::className(), ['id_quirofano' => 'id']);
    }
    /**
   * @return \yii\db\ActiveQuery
   */
  public function getQuirofanoAnestesiologos()
  {
      return $this->hasMany(QuirofanoAnestesiologo::className(), ['id_quirofano' => 'id']);
  }

  public function anestesiologo($dia , $id)
  {

    $quirofanoAnestesiologo=    Anestesiologo::find()
      ->leftJoin('quirofano_anestesiologo', 'anestesiologo.id = quirofano_anestesiologo.id_anestesiologo')
      ->leftJoin('anestesiologo_semana', 'anestesiologo_semana.id_anestesiologo =anestesiologo.id')
      ->leftJoin('dias_semanales', 'dias_semanales.id = anestesiologo_semana.id_semana')
      ->where(['and',"dias_semanales.dia='".$dia.
      "' and quirofano_anestesiologo.id_quirofano=".$id ])
      ->one();


      return $quirofanoAnestesiologo;
  }

}
