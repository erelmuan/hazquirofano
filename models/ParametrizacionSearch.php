<?php

namespace app\models;

use Yii; 
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Parametrizacion;

/**
 * ParametrizacionSearch represents the model behind the search form of `app\models\Parametrizacion`.
 */
class ParametrizacionSearch extends Parametrizacion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'dias_anticipacion', 'dias_creacion', 'niveles'], 'integer'],
            [['hora_inicio', 'hora_final', 'horario_minimo'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Parametrizacion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'hora_inicio' => $this->hora_inicio,
            'hora_final' => $this->hora_final,
            'dias_anticipacion' => $this->dias_anticipacion,
            'dias_creacion' => $this->dias_creacion,
            'horario_minimo' => $this->horario_minimo,
            'niveles' => $this->niveles,
        ]);

        return $dataProvider;
    }
}
