<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BankDetails;

/**
 * BankDetailsSearch represents the model behind the search form about `common\models\BankDetails`.
 */
class BankDetailsSearch extends BankDetails {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'status', 'CB', 'UB'], 'integer'],
            [['account_holder_name', 'account_no', 'iban', 'bank_name', 'swift', 'branch', 'correspontant_bank', 'DOC', 'DOU'], 'safe'],
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
        $query = BankDetails::find()->orderBy(['id' => SORT_DESC]);

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
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'account_holder_name', $this->account_holder_name])
                ->andFilterWhere(['like', 'account_no', $this->account_no])
                ->andFilterWhere(['like', 'iban', $this->iban])
                ->andFilterWhere(['like', 'bank_name', $this->bank_name])
                ->andFilterWhere(['like', 'swift', $this->swift])
                ->andFilterWhere(['like', 'branch', $this->branch])
                ->andFilterWhere(['like', 'correspontant_bank', $this->correspontant_bank]);

        return $dataProvider;
    }

}
