<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HistorialRangoHorario;

/**
 * HistorialRangoHorarioSearch represents the model behind the search form about `app\models\HistorialRangoHorario`.
 */
class HistorialRangoHorarioSearch extends HistorialRangoHorario
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_cirugia_programada'], 'integer'],
            [['hora_inicio', 'hora_final'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = HistorialRangoHorario::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_cirugia_programada' => $this->id_cirugia_programada,
            'hora_inicio' => $this->hora_inicio,
            'hora_final' => $this->hora_final,
        ]);

        return $dataProvider;
    }
}
