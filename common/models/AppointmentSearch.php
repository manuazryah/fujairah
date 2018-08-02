<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Appointment;
use yii\db\Expression;

/**
 * AppointmentSearch represents the model behind the search form about `common\models\Appointment`.
 */
class AppointmentSearch extends Appointment {

    /**
     * @inheritdoc
     */
    public $arrival_date;
    public $cast_off;

    public function rules() {
        return [
            [['id', 'vessel_type', 'vessel', 'port_of_call', 'terminal', 'nominator', 'charterer', 'shipper', 'sub_stages', 'stage', 'status', 'CB', 'UB', 'estimate_status'], 'integer'],
            [['birth_no', 'appointment_no', 'no_of_principal', 'purpose', 'arrival_date', 'cast_off', 'cargo', 'quantity', 'last_port', 'next_port', 'eta', 'DOC', 'DOU', 'principal'], 'safe'],
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
        if (isset($params["AppointmentSearch"]["principal"]) && $params["AppointmentSearch"]["principal"] != '') {
            $params["AppointmentSearch"]["principal"] = $params["AppointmentSearch"]["principal"];
            $query = Appointment::find()->where(new Expression('FIND_IN_SET(:principal, principal)'))->addParams([':principal' => $params["AppointmentSearch"]["principal"]])->orderBy(['id' => SORT_DESC]);
        } else {
            $query = Appointment::find()->orderBy(['id' => SORT_DESC]);
        }
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
            'port_of_call' => $this->port_of_call,
            'terminal' => $this->terminal,
//            'principal' => $this->principal,
            'nominator' => $this->nominator,
            'charterer' => $this->charterer,
            'shipper' => $this->shipper,
            'eta' => $this->eta,
            'stage' => $this->stage,
            'estimate_status' => $this->estimate_status,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'birth_no', $this->birth_no])
                ->andFilterWhere(['like', 'appointment_no', $this->appointment_no])
                ->andFilterWhere(['like', 'no_of_principal', $this->no_of_principal])
//                ->andFilterWhere(['in', 'principal', $this->principal])
                ->andFilterWhere(['like', 'purpose', $this->purpose])
                ->andFilterWhere(['like', 'cargo', $this->cargo])
                ->andFilterWhere(['like', 'quantity', $this->quantity])
                ->andFilterWhere(['like', 'last_port', $this->last_port])
                ->andFilterWhere(['like', 'next_port', $this->next_port]);
        return $dataProvider;
    }

}
