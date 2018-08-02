<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Expression;

/**
 * ExpensesController implements the CRUD actions for Expenses model.
 */
class CroneMailController extends Controller {

    public function actionIndex() {
        date_default_timezone_set("Asia/Dubai");
        $time = strtotime(date("H:i:s"));
        $current_date = date("Y-m-d H:i:s");
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        $users = \common\models\Employee::find()->where(['status' => 1])->all();
        $super_users = \common\models\Employee::find()->where(['post_id' => 1])->all();
        foreach ($users as $user) {
//            $pending = \common\models\Task::find()->where(['>', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->id])->all();
            $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +1 day'));
            $end = date('Y-m-d H:i:s', strtotime($endTime . ' +1 day'));
            $upcoming = \common\models\Task::find()->where(['<=', 'date', $end])->andWhere(['>=', 'date', $begin])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->id])->all();
//            $upcoming_followers = \common\models\Task::find()->where(['<=', 'date', $end])->andWhere(['>=', 'date', $begin])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(new Expression('FIND_IN_SET(:follow_up, follow_up)'))->addParams([':follow_up' => $user->id])->all();
            $over_due = \common\models\Task::find()->where(['<', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(['assigned_to' => $user->id])->all();
            $over_due_followers = \common\models\Task::find()->where(['<', 'date', $current_date])->andWhere(['<>', 'status', 4])->andWhere(['not', ['date' => null]])->andWhere(['not', ['date' => '0000-00-00']])->andWhere(new Expression('FIND_IN_SET(:follow_up, follow_up)'))->addParams([':follow_up' => $user->id])->all();
            if (!empty($upcoming)) {
                $this->AddTask($upcoming, 2);
                $this->SendEmail($upcoming, $user, 2);
            }
            if (!empty($over_due)) {
                $this->AddTask($over_due, 3);
                $this->SendEmail($over_due, $user, 3);
                foreach ($super_user as $super_user) {
                    $this->SendEmail($over_due, $super_user, 3);
                }
            }
            if (!empty($over_due_followers)) {
                $this->SendEmail($over_due_followers, $user, 3);
            }
        }
    }

    public function AddTask($task_datas, $status) {

        foreach ($task_datas as $val) {
            $data_exist = \common\models\Task::find()->where(['id' => $val->id])->one();
            if (!empty($data_exist)) {
                $data_exist->status = $status;
                $data_exist->save();
            }
        }
        return;
    }

    public function SendEmail($task_datas, $status, $user) {
        $user_info = \common\models\Employee::findOne(['id' => $user]);

        $to = $user_info->email;
// subject
        if ($status == 2) {
            $task_name = 'Upcoming';
        } elseif ($status == 3) {
            $task_name = 'Overdue';
        }
        $subject = ' Attenssion : ' . $user_info->name . 'Updated Tasks in dxb.esl-da.com';
        $message = '<html><head></head><body><h4>Hi ' . $user_info->name . ',</h4><p><b>Here are some updates on tasks</b></p><p style="color: #b92f2f;font-size: 20px;"><b>Emperror Shipping Lines LL.C</b></p><table style="border-collapse: collapse;border: 1px solid black;">';
        foreach ($task_datas as $task_data) {
            $assigned_from = \common\models\Employee::findOne($task_data->assigned_from)->name;
            $assigned_to = \common\models\Employee::findOne($task_data->assigned_to)->name;
//            $message .= "<tr><td style='border: 1px solid black;padding: 5px 12px;  '><span style='background: #FFC107;padding: 3px;'>" . $task_name . "</span><span style='color: #2196F3;padding: 0px 15px;'>" . $task_data->follow_up_msg . "</span><span>" . $assigned_from . "  assigned to " . $assigned_to . "</span></td></tr>";
            $message .= "<tr style='border: 1px solid;'><td style='padding: 5px;'><span style='background: #FFC107;padding: 3px;'>" . $task_name . "</span></td><td style=''><span style='color: #2196F3;padding: 0px 15px;font-size: 12px;'>" . $task_data->follow_up_msg . "</span></td><td style='padding: 5px 12px;'><span>" . $assigned_from . "  assigned to " . $assigned_to . "</span></td></tr>";
        }
        $message .= '</table></body></html>';
// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperror.com";
        mail($to, $subject, $message, $headers);


        return true;
    }

}
