<?php

namespace backend\modules\funding\controllers;

use Yii;
use common\models\Debtor;
use common\models\FundingAllocation;

class DebtorWiseReportController extends \yii\web\Controller {

    public function actionIndex() {
        $debtors = Debtor::findAll(['status' => 1]);
        $princip = '';
        if (Yii::$app->request->post()) {
            $princip = Yii::$app->request->post('report-debtor-id');
            if (isset($princip) || $princip != '') {
                $model = FundingAllocation::find()->where(['between', 'fund_date', Yii::$app->request->post('from_date'), Yii::$app->request->post('to_date')])->andWhere(['principal_id' => $princip])->all();
            } else {
                $model = FundingAllocation::find()->where(['between', 'fund_date', Yii::$app->request->post('from_date'), Yii::$app->request->post('to_date')])->all();
            }
        } else {
            $model = FundingAllocation::find()->all();
        }
        foreach ($model as $key => $val) {
            $new_arr[] = $val['appointment_id'];
        }
        if (!empty($new_arr)) {
            $uniq_arr = array_unique($new_arr);
        }
        return $this->render('index', [
                    'debtors' => $debtors,
                    'model' => $model,
                    'uniq_arr' => $uniq_arr,
                    'princip' => $princip,
        ]);
    }

}
