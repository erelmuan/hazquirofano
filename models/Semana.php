<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "semana".
 *
 * @property int $id
 * @property string $dia
 *
 * @property Semanaespecialidad[] $semanaespecialidads
 */
class Semana extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'semana';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dia'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia' => 'Dia',
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
            'attribute'=>'dia',
          ],

        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSemanaespecialidads()
    {
        return $this->hasMany(Semanaespecialidad::className(), ['id_semana' => 'id']);
    }
}
