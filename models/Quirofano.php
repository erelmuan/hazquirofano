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
 * @property Cirugiaprogramada[] $cirugiaprogramadas
*  @property int $id_anestesiologo
* @property Anestesiologo $anestesiologo
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
            [['habilitado'], 'boolean'],
           [['id_anestesiologo'], 'exist', 'skipOnError' => true,
           'targetClass' => Anestesiologo::className(),
           'targetAttribute' => ['id_anestesiologo' => 'id']],
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
            'habilitado' => 'Habilitado',
            'id_anestesiologo' => 'Id Anestesiologo',
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
      public function getAnestesiologo()
      {
          return $this->hasOne(Anestesiologo::className(), ['id' => 'id_anestesiologo']);
      }
      public function getAnestesiologos() {
          return ArrayHelper::map(Anestesiologo::find()->orderBy(['id'=>SORT_ASC])->all(), 'id','nombre');

      }
}
