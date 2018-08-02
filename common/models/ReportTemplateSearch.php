<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReportTemplate;

/**
 * ReportTemplateSearch represents the model behind the search form about `common\models\ReportTemplate`.
 */
class ReportTemplateSearch extends ReportTemplate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'address', 'bank', 'status', 'CB', 'UB'], 'integer'],
            [['left_logo', 'right_logo', 'report_description', 'footer_content', 'account_mannager_email', 'account_mannager_phone', 'DOC', 'DOU'], 'safe'],
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
        $query = ReportTemplate::find();

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
            'address' => $this->address,
            'bank' => $this->bank,
            'status' => $this->status,
            'CB' => $this->CB,
            'UB' => $this->UB,
            'DOC' => $this->DOC,
            'DOU' => $this->DOU,
        ]);

        $query->andFilterWhere(['like', 'left_logo', $this->left_logo])
            ->andFilterWhere(['like', 'right_logo', $this->right_logo])
            ->andFilterWhere(['like', 'report_description', $this->report_description])
            ->andFilterWhere(['like', 'footer_content', $this->footer_content])
            ->andFilterWhere(['like', 'account_mannager_email', $this->account_mannager_email])
            ->andFilterWhere(['like', 'account_mannager_phone', $this->account_mannager_phone]);

        return $dataProvider;
    }
}
