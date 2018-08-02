<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Report;

/**
 * AppointmentSearch represents the model behind the search form about `common\models\Appointment`.
 */
class ReportSearch extends Report {

    /**
     * @var string
     */
    public $createdFrom;
    public $tug;
    public $arrival_date;

    /**
     * @var string
     */
    public $createdTo;

    /**
     * @var string
     */
    public $etaFrom;

    /**
     * @var string
     */
    public $etaTo;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'vessel_type', 'vessel', 'port_of_call', 'terminal', 'principal', 'nominator', 'charterer', 'shipper', 'sub_stages', 'stage', 'status', 'CB', 'UB'], 'integer'],
            [['birth_no', 'appointment_no', 'no_of_principal', 'arrival_date', 'purpose', 'cargo', 'quantity', 'last_port', 'next_port', 'eta', 'DOC', 'DOU'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        if (!isset($params['ReportSearch']['tug'])) {
            $params['ReportSearch']['tug'] = '';
        }
        if (!isset($params['ReportSearch']['barge'])) {
            $params['ReportSearch']['barge'] = '';
        }
        if (!isset($params['ReportSearch']['etaFrom'])) {
            $params['ReportSearch']['etaFrom'] = '';
        }
        if (!isset($params['ReportSearch']['etaTo'])) {
            $params['ReportSearch']['etaTo'] = '';
        }if (!isset($params['ReportSearch']['createdFrom'])) {
            $params['ReportSearch']['createdFrom'] = '';
        }if (!isset($params['ReportSearch']['createdTo'])) {
            $params['ReportSearch']['createdTo'] = '';
        }



        $query = Appointment::find()->orderBy(['id' => SORT_DESC]);
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
            'vessel_type' => $this->vessel_type,
            'vessel' => $this->vessel,
            'tug' => $this->tug,
            'barge' => $this->barge,
            'port_of_call' => $this->port_of_call,
            'terminal' => $this->terminal,
            'principal' => $this->principal,
            'nominator' => $this->nominator,
            'charterer' => $this->charterer,
            'shipper' => $this->shipper,
            'eta' => $this->eta,
            'stage' => $this->stage,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'birth_no', $this->birth_no])
                ->andFilterWhere(['like', 'appointment_no', $this->appointment_no])
                ->andFilterWhere(['like', 'no_of_principal', $this->no_of_principal])
                ->andFilterWhere(['like', 'purpose', $this->purpose])
                ->andFilterWhere(['like', 'cargo', $this->cargo])
                ->andFilterWhere(['like', 'quantity', $this->quantity])
                ->andFilterWhere(['like', 'last_port', $this->last_port])
                ->andFilterWhere(['like', 'next_port', $this->next_port])
                ->andFilterWhere(['like', 'tug', $params['ReportSearch']['tug']])
                ->andFilterWhere(['like', 'barge', $params['ReportSearch']['barge']])
                ->andFilterWhere(['>=', 'eta', $params['ReportSearch']['etaFrom']])
                ->andFilterWhere(['<=', 'eta', $params['ReportSearch']['etaTo']])
                ->andFilterWhere(['>=', 'DOC', $params['ReportSearch']['createdFrom']])
                ->andFilterWhere(['<=', 'DOC', $params['ReportSearch']['createdTo']]);



        return $dataProvider;
    }

}
