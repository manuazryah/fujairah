<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notification;

/**
 * NotificationSearch represents the model behind the search form about `common\models\Notification`.
 */
class NotificationSearch extends Notification {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'notification_type', 'appointment_id', 'status'], 'integer'],
            [['content', 'appointment_no', 'date', 'message'], 'safe'],
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
        if ($params['NotificationSearch']['status'] == '' || $params['NotificationSearch']['status'] == 1) {
            $query = Notification::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC]);
        } else {
            $query = Notification::find()->orderBy(['id' => SORT_DESC]);
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
            'notification_type' => $this->notification_type,
            'appointment_id' => $this->appointment_id,
            'appointment_no' => $this->appointment_no,
            'status' => $this->status,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content]);
        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }

}
