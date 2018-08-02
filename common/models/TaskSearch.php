<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'assigned_from', 'assigned_to', 'status'], 'integer'],
            [['date', 'follow_up', 'appointment_id'], 'safe'],
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
        $query = Task::find()->orderBy(['id' => SORT_DESC]);

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
            'assigned_from' => $this->assigned_from,
            'assigned_to' => $this->assigned_to,
            'date' => $this->date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'follow_up', $this->follow_up]);
        $query->andFilterWhere(['like', 'appointment_id', $this->appointment_id]);

        return $dataProvider;
    }

}
