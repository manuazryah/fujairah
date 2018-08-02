<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\db\Expression;

/**
 * ExpensesController implements the CRUD actions for Expenses model.
 */
class TestController extends Controller {

    public function actionIndex() {

        date_default_timezone_set("Asia/Dubai");
        $time = strtotime(date("H:i:s"));
        $current_date = date("Y-m-d H:i:s");
        $before_date = date('Y-m-d H:i:s', strtotime('-30 days'));
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        $arr = [0, 6, 12, 24];
        foreach ($arr as $val) {
            if ($val == 0) {
                $eta_datas = \common\models\PortCallData::find()->where(['<', 'eta', $current_date])->andWhere(['>', 'eta', $before_date])->andWhere(['not', ['cast_off' => null]])->andWhere(['not', ['cast_off' => '0000-00-00 00:00:00']])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<', 'cast_off', $current_date])->andWhere(['>', 'eta', $before_date])->andWhere(['not', ['cast_off' => null]])->andWhere(['not', ['cast_off' => '0000-00-00 00:00:00']])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 0);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 0);
                }
            } elseif ($val == 6) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +6 hour'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +6 hour'));
                $eta_datas = \common\models\PortCallData::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<=', 'cast_off', $end])->andWhere(['>=', 'cast_off', $begin])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 6);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 6);
                }
            } elseif ($val == 12) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +12 hour'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +12 hour'));
                $eta_datas = \common\models\PortCallData::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<=', 'cast_off', $end])->andWhere(['>=', 'cast_off', $begin])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 12);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 12);
                }
            } elseif ($val == 24) {
                $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +1 day'));
                $end = date('Y-m-d H:i:s', strtotime($endTime . ' +1 day'));
                $eta_datas = \common\models\PortCallData::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<=', 'cast_off', $end])->andWhere(['>=', 'cast_off', $begin])->all();
                if (!empty($eta_datas)) {
                    $this->AddNotification($eta_datas, 24);
                }
                if (!empty($cast_off_datas)) {
                    $this->AddCastOfNotification($cast_off_datas, 24);
                }
            }
        }
    }

    public function AddCastOfNotification($eta_datas, $hour) {
        foreach ($eta_datas as $value) {
            $appointment = \common\models\Appointment::find()->where(['id' => $value->appointment_id, 'status' => 0, 'stage' => 5])->one();
            if (empty($appointment)) {
                $data_exist = \common\models\Notification::find()->where(['appointment_id' => $value->appointment_id, 'notification_type' => 2])->one();
                $app_no = \common\models\Appointment::findOne(['id' => $value->appointment_id])->appointment_no;
                if ($hour == 0) {
                    $diff_in_hrs = $this->CalculateDateDiff($value->eta);
                    $msg = 'Cast off for appointment <span class="appno-highlite">' . $app_no . '</span> is over about more than almost <span class="appno-highlite">' . $diff_in_hrs . '<span>';
                    $msg1 = 'Cast off for appointment ' . $app_no . ' is over about more than almost ' . $diff_in_hrs;
                } else {
                    $msg = 'Cast off for appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour';
                    $msg1 = 'Cast off for appointment ' . $app_no . ' in ' . $hour . ' hour';
                }
                if (empty($data_exist)) {
                    $model = new \common\models\Notification();
                    $model->notification_type = 2;
                    $model->appointment_id = $value->appointment_id;
                    $model->appointment_no = $app_no;
                    $model->content = $msg;
                    $model->message = $msg1;
                    $model->status = 1;
                    $model->date = date("Y-m-d H:i:s");
                    $model->save();
                } else {
                    $data_exist->status = 1;
                    $data_exist->content = $msg;
                    $data_exist->message = $msg1;
                    $data_exist->date = date("Y-m-d H:i:s");
                    $data_exist->save();
                }
            }
        }
        return;
    }

    public function AddNotification($eta_datas, $hour) {
        foreach ($eta_datas as $value) {
            $data_exist = \common\models\Notification::find()->where(['appointment_id' => $value->appointment_id, 'notification_type' => 1])->one();
            $app_no = \common\models\Appointment::findOne(['id' => $value->appointment_id])->appointment_no;
            if ($hour == 0) {
                $diff_in_hrs = $this->CalculateDateDiff($value->eta);
                $msg = 'ETA for Appointment <span class="appno-highlite">' . $app_no . '</span> is over <span class="appno-highlite">' . $diff_in_hrs . '</span> ago';
                $msg1 = 'ETA for Appointment ' . $app_no . ' is over ' . $diff_in_hrs . ' ago';
            } else {
                $msg = 'ETA for Appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour ';
                $msg1 = 'ETA for Appointment ' . $app_no . ' in ' . $hour . ' hour ';
            }
            if (empty($data_exist)) {
                $model = new \common\models\Notification();
                $model->notification_type = 1;
                $model->appointment_id = $value->appointment_id;
                $model->appointment_no = $app_no;
                $model->content = $msg;
                $model->message = $msg1;
                $model->status = 1;
                $model->date = date("Y-m-d H:i:s");
                $model->save();
            } else {
                $data_exist->status = 1;
                $data_exist->content = $msg;
                $data_exist->message = $msg1;
                $data_exist->date = date("Y-m-d H:i:s");
                $data_exist->save();
            }
        }
        return;
    }

    public function CalculateDateDiff($eta) {
        $start_date = $eta;
        $end_date = date("Y-m-d H:i:s");
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        if ($years > 0) {
            $new_date = $years . ' Years ' . $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        } elseif ($years < 0 && $months > 0) {
            $new_date = $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        } elseif ($years < 0 && $months < 0 && $days > 0) {
            $new_date = $days . ' Days ' . $hours . ' Hours';
        } else {
            $new_date = $hours . ' Hours';
        }
        return $new_date;
    }

}
