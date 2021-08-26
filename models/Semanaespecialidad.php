<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semanaespecialidad".
 *
 * @property int $id
 * @property int $id_semana
 * @property int $id_especialidad
 *
 * @property Especialidad $especialidad
 * @property Semana $semana
 */
class Semanaespecialidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semanaespecialidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_semana', 'id_especialidad'], 'default', 'value' => null],
            [['id_semana', 'id_especialidad'], 'integer'],
            [['id_especialidad'], 'exist', 'skipOnError' => true, 'targetClass' => Especialidad::className(), 'targetAttribute' => ['id_especialidad' => 'id']],
            [['id_semana'], 'exist', 'skipOnError' => true, 'targetClass' => Semana::className(), 'targetAttribute' => ['id_semana' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_semana' => 'Id Semana',
            'id_especialidad' => 'Id Especialidad',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEspecialidad()
    {
        return $this->hasOne(Especialidad::className(), ['id' => 'id_especialidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemana()
    {
        return $this->hasOne(Semana::className(), ['id' => 'id_semana']);
    }
}
