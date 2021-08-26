<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WiewHorasOcupadas;

/**
 * WiewHorasOcupadasSearch represents the model behind the search form about `app\models\WiewHorasOcupadas`.
 */
class WiewHorasOcupadasSearch extends WiewHorasOcupadas
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_cirugia', 'horas_ocupadas', 'descripcion'], 'safe'],
            [['id_quirofano'], 'integer'],
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
        $query = WiewHorasOcupadas::find();

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
            'fecha_cirugia' => $this->fecha_cirugia,
            'id_quirofano' => $this->id_quirofano,
        ]);

        $query->andFilterWhere(['like', 'horas_ocupadas', $this->horas_ocupadas])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
