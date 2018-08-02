<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Expression;

/**
 * ExpensesController implements the CRUD actions for Expenses model.
 */
class TaskController extends Controller {
//    public function actionIndex() {
//        date_default_timezone_set("Asia/Dubai");
//        $current_date = date("Y-m-d");
//        $after_date = date('Y-m-d', strtotime('+1 days'));
//        $arr = [0, 1];
//        foreach ($arr as $value) {
//            if ($value == 0) {
//                $pendind_tasks = \common\models\Task::find()->where(['<', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->all();
//                if (!empty($pendind_tasks)) {
//                    $this->AddTask($pendind_tasks, 2);
//                }
//            } elseif ($value == 1) {
//                $pendind_tasks = \common\models\Task::find()->where(['>', 'date', $current_date])->andWhere(['<=', 'date', $after_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->all();
//                if (!empty($pendind_tasks)) {
//                    $this->AddTask($pendind_tasks, 3);
//                }
//            }
//        }
//    }
//
//    public function AddTask($task_datas, $status) {
//
//        foreach ($task_datas as $val) {
//            $data_exist = \common\models\Task::find()->where(['id' => $val->id])->one();
//            if (!empty($data_exist)) {
//                $data_exist->status = $status;
//                $data_exist->save();
//            }
//        }
//        return;
//    }
}
