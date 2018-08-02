<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CashInHand;

/**
 * CashInHandSearch represents the model behind the search form about `common\models\CashInHand`.
 */
class CashInHandSearch extends CashInHand {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'employee_id', 'transaction_type', 'payment_type', 'appointment_id', 'debtor_id', 'status', 'CB', 'UB'], 'integer'],
            [['date', 'check_no', 'comment', 'DOC', 'DOU'], 'safe'],
            [['amount', 'balance'], 'number'],
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
        $query = CashInHand::find();

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

        if (!empty($this->date) && strpos($this->date, '-') !== false) {
            list($start_date, $end_date) = explode(' - ', $this->date);
            $query->andFilterWhere(['between', 'date(date)', $start_date, $end_date]);
            $this->date = "";
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'date' => $this->date,
            'transaction_type' => $this->transaction_type,
            'payment_type' => $this->payment_type,
            'amount' => $this->amount,
            'balance' => $this->balance,
            'appointment_id' => $this->appointment_id,
            'debtor_id' => $this->debtor_id,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'check_no', $this->check_no])
                ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

}
