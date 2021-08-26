<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "especialidad".
 *
 * @property int $id
 * @property string $profesion
 *
 * @property Medico[] $medicos
 * @property Semanaespecialidad[] $semanaespecialidads
 */
class Especialidad extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'especialidad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profesion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'profesion' => 'Profesion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMedicos()
    {
        return $this->hasMany(Medico::className(), ['id_tipoprofesional' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemanaespecialidads()
    {
        return $this->hasMany(Semanaespecialidad::className(), ['id_tipoprofesional' => 'id']);
    }
}
