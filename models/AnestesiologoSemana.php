<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anestesiologo_semana".
 *
 * @property int $id
 * @property int $id_anestesiologo
 * @property int $id_semana
 *
 * @property Anestesiologo $anestesiologo
 * @property DiasSemanales $semana
 */
class AnestesiologoSemana extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'anestesiologo_semana';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_anestesiologo', 'id_semana'], 'default', 'value' => null],
            [['id_anestesiologo', 'id_semana'], 'integer'],
            [['id_anestesiologo'], 'exist', 'skipOnError' => true, 'targetClass' => Anestesiologo::className(), 'targetAttribute' => ['id_anestesiologo' => 'id']],
            [['id_semana'], 'exist', 'skipOnError' => true, 'targetClass' => DiasSemanales::className(), 'targetAttribute' => ['id_semana' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_anestesiologo' => 'Id Anestesiologo',
            'id_semana' => 'Id Semana',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnestesiologo()
    {
        return $this->hasOne(Anestesiologo::className(), ['id' => 'id_anestesiologo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemana()
    {
        return $this->hasOne(DiasSemanales::className(), ['id' => 'id_semana']);
    }
}
