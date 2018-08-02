<?php

namespace backend\modules\appointment\controllers;

use yii;
use common\models\CloseEstimateSearch;

class ServiceReportController extends \yii\web\Controller {

    public function actionIndex() {
        $searchModel = new CloseEstimateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (Yii::$app->request->post()) {
            if ($_POST['from_date'] != '') {
                $from_date = $_POST['from_date'];
            } else {
                $from_date = '';
            }
            if ($_POST['to_date'] != '') {
                $to_date = $_POST['to_date'];
            } else {
                $to_date = '';
            }
            if (isset($_POST['service_name']) && $_POST['service_name'] != '') {
                $service = $_POST['service_name'];
            } else {
                $service = '';
            }
            if ($from_date != '') {
                $dataProvider->query->andWhere(['>=', 'DOC', $from_date]);
            }
            if ($to_date != '') {
                $dataProvider->query->andWhere(['<=', 'DOC', $to_date]);
            }
            if (!empty($service) || $service != '') {
                $dataProvider->query->andWhere(['service_id' => $service]);
            }
        } else {
            $from_date = '';
            $to_date = '';
            $service = '';
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'from_date' => $from_date,
                    'to_date' => $to_date,
                    'service' => $service,
        ]);
    }

}
