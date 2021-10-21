<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quirofano_anestesiologo".
 *
 * @property int $id
 * @property int $id_anestesiologo
 * @property int $id_quirofano
 *
 * @property Anestesiologo $anestesiologo
 * @property Quirofano $quirofano
 */
class QuirofanoAnestesiologo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quirofano_anestesiologo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_anestesiologo', 'id_quirofano'], 'required'],
            [['id_anestesiologo', 'id_quirofano'], 'default', 'value' => null],
            [['id_anestesiologo', 'id_quirofano'], 'integer'],
            [['id_anestesiologo'], 'exist', 'skipOnError' => true, 'targetClass' => Anestesiologo::className(), 'targetAttribute' => ['id_anestesiologo' => 'id']],
            [['id_quirofano'], 'exist', 'skipOnError' => true, 'targetClass' => Quirofano::className(), 'targetAttribute' => ['id_quirofano' => 'id']],
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
            'id_quirofano' => 'Id Quirofano',
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
    public function getQuirofano()
    {
        return $this->hasOne(Quirofano::className(), ['id' => 'id_quirofano']);
    }
}
