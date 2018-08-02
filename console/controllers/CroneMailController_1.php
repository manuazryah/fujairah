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
        $users = \common\models\Task::find()->select('assigned_to')->distinct()->all();
        $arr = [0, 1];

        foreach ($arr as $value) {
            if ($value == 0) {
                foreach ($users as $user) {
                    $pendind_tasks = \common\models\Task::find()->where(['status' => 2, 'assigned_to' => $user->assigned_to])->all();
                    if (!empty($pendind_tasks)) {
                        $this->SendEmail($pendind_tasks, 2, $user->assigned_to);
                    }
                }
            } elseif ($value == 1) {
                foreach ($users as $user) {
                    $upcoming_tasks = \common\models\Task::find()->where(['status' => 3, 'assigned_to' => $user->assigned_to])->all();
                    if (!empty($upcoming_tasks)) {
                        $this->SendEmail($upcoming_tasks, 3, $user->assigned_to);
                    }
                }
            }
        }
    }

    public function SendEmail($task_datas, $status, $user) {
        $user_info = \common\models\Employee::findOne(['id' => $user]);

        $to = $user_info->email;
// subject
        if ($status == 2) {
            $task_name = 'Pending';
        } elseif ($status == 3) {
            $task_name = 'Upcoming';
        }
        $subject = ' Attenssion : ' . $user_info->name;
        $message = '<html><head></head><body><h4>Hi ' . $user_info->name . ',</h4><p><b>Here are some updates on tasks</b></p><p style="color: #b92f2f;font-size: 20px;"><b>Emperror Shipping Lines LL.C</b></p><table style="border-collapse: collapse;border: 1px solid black;">';
        foreach ($task_datas as $task_data) {
            $message .= "<tr><td style='border: 1px solid black;padding: 5px 12px;  '>" . $task_name . "</td><td style='border: 1px solid black;padding: 5px 12px;'>" . $task_data->follow_up_msg . "</td></tr>";
        }
        $message .= '<table></body></html>';
// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperror.com";
        mail($to, $subject, $message, $headers);


        return true;
    }

}
