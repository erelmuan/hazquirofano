<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\WiewQuirofanosDisponibles;

/**
 * WiewQuirofanosDisponiblesSearch represents the model behind the search form about `app\models\WiewQuirofanosDisponibles`.
 */
class WiewQuirofanosDisponiblesSearch extends WiewQuirofanosDisponibles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fecha_cirugia', 'hora_inicio', 'hora_final', 'descripcion'], 'safe'],
            [['id_quirofano'], 'integer'],
            ['fecha_cirugia', 'date', 'format' => 'dd/MM/yyyy'],
            ['hora_inicio', 'time', 'format' => 'hh:mm:ss'],
            ['hora_final', 'time', 'format' => 'hh:mm:ss'],

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
        $query = WiewQuirofanosDisponibles::find()
        ->innerJoinWith('quirofano', 'quirofano.id = WiewQuirofanosDisponibles.id_quirofano')
        // ->where(['and','fecha_cirugia not in (6,0) ' ])
// select to_char((date_trunc('week',current_date)::date) + i,'Day') as wkday from generate_series(5,6) i
        ;
// (select to_char((date_trunc("week",fecha_cirugia)::date) + i,"Day") as wkday from generate_series(5,6) i) != "Saturday"




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
            // 'fecha_cirugia' => $this->fecha_cirugia,
            // 'hora_inicio' => $this->hora_inicio,
            'hora_final' => $this->hora_final,
            'id_quirofano' => $this->id_quirofano,
        ]);
        $query->andFilterWhere(['>=', 'hora_inicio', $this->hora_inicio]);

        $query->andFilterWhere(['>=', 'fecha_cirugia', $this->fecha_cirugia]);


        $query->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
