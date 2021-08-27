<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cirugiaprogramada;

/**
 * CirugiaprogramadaSearch represents the model behind the search form about `app\models\Cirugiaprogramada`.
 */
class CirugiaprogramadaSearch extends Cirugiaprogramada
{
  public $paciente;
  public $medico;
  public $fecha_desde;
  public $fecha_hasta;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'id_paciente', 'id_medico',  'id_anestesia',  'id_quirofano','id_estado'], 'integer'],
            [['fecha_desde','fecha_hasta','fecha_programada', 'hora_inicio','procedimiento', 'ayudantes', 'lado', 'fecha_cirugia', 'observacion', 'diagnostico', 'material_protesis','cant_tiempo', 'otro_equpo','paciente','medico'], 'safe'],
            ['fecha_programada', 'date', 'format' => 'dd/MM/yyyy'],
            ['fecha_cirugia', 'date', 'format' => 'dd/MM/yyyy'],

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
        $query = Cirugiaprogramada::find()
        ->innerJoinWith('paciente', 'paciente.id = cirugiaprogramada.id_paciente')
        ->innerJoinWith('medico', 'medico.id = cirugiaprogramada.id_medico')
        ->innerJoinWith('quirofano', 'quirofano.id = cirugiaprogramada.id_quirofano')

        ;

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
            'cirugiaprogramada.id' => $this->id,
            'procedimiento' => $this->procedimiento,
            'id_anestesia' => $this->id_anestesia,
            'fecha_programada' => $this->fecha_programada,
            'hora_inicio' => $this->hora_inicio,
            'cant_tiempo' => $this->cant_tiempo,
            'fecha_cirugia' => $this->fecha_cirugia,
            'id_estado' => $this->id_estado,
            'id_quirofano' => $this->id_quirofano,

        ]);

        if (is_numeric($this->paciente)){
            $query->orFilterWhere(["paciente.num_documento"=>$this->paciente]);
             }
        else {
            $query->andFilterWhere(['ilike', '("paciente"."apellido")',strtolower($this->paciente)]);

        }
        if (is_numeric($this->medico)){
            $query->orFilterWhere(["medico.num_documento"=>$this->medico]);
             }
        else {
            $query->andFilterWhere(['ilike', '("medico"."apellido")',strtolower($this->medico)]);

        }

        $query->andFilterWhere(['like', 'ayudantes', $this->ayudantes])
            ->andFilterWhere(['like', 'lado', $this->lado])
            ->andFilterWhere(['like', 'observacion', $this->observacion])
            ->andFilterWhere(['like', 'diagnostico', $this->diagnostico])
            ->andFilterWhere(['like', 'material_protesis', $this->material_protesis])
            ->andFilterWhere(['like', 'otro_equpo', $this->otro_equpo]);
        $query->andFilterWhere(['>=', 'fecha_cirugia', $this->fecha_desde]);
        $query->andFilterWhere(['<=', 'fecha_cirugia', $this->fecha_hasta]);
        return $dataProvider;
    }


    public function  searchdispo($params){
      $query = Cirugiaprogramada::find()
      ->innerJoinWith('paciente', 'paciente.id = cirugiaprogramada.id_paciente')
      ->innerJoinWith('medico', 'medico.id = cirugiaprogramada.id_medico')
      ;

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
          'procedimiento' => $this->procedimiento,
          'id_anestesia' => $this->id_anestesia,
          'fecha_programada' => $this->fecha_programada,
          'hora_inicio' => $this->hora_inicio,
          'cant_tiempo' => $this->cant_tiempo,
          'fecha_cirugia' => $this->fecha_cirugia,
          'id_quirofano' => $this->id_quirofano,
          'id_estado' => $this->id_estado,
      ]);
        return $dataProvider;

  }

}
