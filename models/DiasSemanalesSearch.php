<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DiasSemanales;

/**
 * DiasSemanalesSearch represents the model behind the search form about `app\models\DiasSemanales`.
 */
class DiasSemanalesSearch extends DiasSemanales
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'numero_semanal'], 'integer'],
            [['dia'], 'safe'],
            [['habilitado'], 'boolean'],
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
        $query = DiasSemanales::find();

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
            'numero_semanal' => $this->numero_semanal,
            'habilitado' => $this->habilitado,
        ]);

        $query->andFilterWhere(['ilike', 'dia', $this->dia]);

        return $dataProvider;
    }
}
