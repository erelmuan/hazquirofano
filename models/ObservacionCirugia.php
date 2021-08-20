<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "observacion_cirugia".
 *
 * @property int $id
 * @property int $id_cirugiaprogramada
 * @property int $id_observacionquirurgica
 *
 * @property Cirugiaprogramada $cirugiaprogramada
 * @property Observacionquirurgica $observacionquirurgica
 */
class ObservacionCirugia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'observacion_cirugia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cirugiaprogramada', 'id_observacionquirurgica'], 'default', 'value' => null],
            [['id_cirugiaprogramada', 'id_observacionquirurgica'], 'integer'],
            [['id_cirugiaprogramada'], 'exist', 'skipOnError' => true, 'targetClass' => Cirugiaprogramada::className(), 'targetAttribute' => ['id_cirugiaprogramada' => 'id']],
            [['id_observacionquirurgica'], 'exist', 'skipOnError' => true, 'targetClass' => Observacionquirurgica::className(), 'targetAttribute' => ['id_observacionquirurgica' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_cirugiaprogramada' => 'Id Cirugiaprogramada',
            'id_observacionquirurgica' => 'Id Observacionquirurgica',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCirugiaprogramada()
    {
        return $this->hasOne(Cirugiaprogramada::className(), ['id' => 'id_cirugiaprogramada']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObservacionquirurgica()
    {
        return $this->hasOne(Observacionquirurgica::className(), ['id' => 'id_observacionquirurgica']);
    }
}
