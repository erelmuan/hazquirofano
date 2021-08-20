<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Medico;

/**
 * MedicoSearch represents the model behind the search form about `app\models\Medico`.
 */
class MedicoSearch extends Medico
{

  public $tipodoc;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipodoc','apellido', 'nombre', 'num_documento', 'matricula'], 'safe'],
          // SCESNARIO //
          [['num_documento',],'integer','on'=>'search'],
          [['num_documento',],'required','on'=>'search'],
          // SCESNARIO //
            [['id', 'id_tipodoc', 'id_especialidad'], 'integer'],
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
        $query = Medico::find()->JoinWith('tipodoc', true);

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
            'id_tipodoc' => $this->id_tipodoc,
            'id_especialidad' => $this->id_especialidad,
        ]);

        $query->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'num_documento', $this->num_documento])
            ->andFilterWhere(['ilike', 'tipodoc.documento', $this->tipodoc])
            ->andFilterWhere(['like', 'matricula', $this->matricula]);

        return $dataProvider;
    }
}
