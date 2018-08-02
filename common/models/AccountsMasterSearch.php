<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AccountsMaster;

/**
 * AccountsMasterSearch represents the model behind the search form about `common\models\AccountsMaster`.
 */
class AccountsMasterSearch extends AccountsMaster
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'aoointment_id', 'debtor_id', 'supplier_id', 'payment_type', 'bank_account', 'journal_type', 'status', 'CB', 'UB', 'DOC'], 'integer'],
            [['reference_id', 'comment', 'date', 'DOU'], 'safe'],
            [['credit_amount', 'debit_amount'], 'number'],
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
        $query = AccountsMaster::find();

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
            'type' => $this->type,
            'aoointment_id' => $this->aoointment_id,
            'debtor_id' => $this->debtor_id,
            'supplier_id' => $this->supplier_id,
            'payment_type' => $this->payment_type,
            'bank_account' => $this->bank_account,
            'credit_amount' => $this->credit_amount,
            'debit_amount' => $this->debit_amount,
            'journal_type' => $this->journal_type,
            'date' => $this->date,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'reference_id', $this->reference_id])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
