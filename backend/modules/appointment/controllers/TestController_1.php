<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\Test;
use common\models\TestSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TestController implements the CRUD actions for Test model.
 */
class TestController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        if (Yii::$app->session['post']['appointments'] != 1) {
            Yii::$app->getSession()->setFlash('exception', 'You have no permission to access this page');
            $this->redirect(['/site/exception']);
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Test models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Test model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Test model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Test();

        if ($model->load(Yii::$app->request->post())) {
            $this->dateformat($model, $_POST['Test']);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Test model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $this->dateformat($model);

            $model->save();
            $model = $this->dateformat($model);

            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model = $this->dateformat($model);
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function DateFormat($model) {
        if (!empty($model)) {
            $a = ['additional_info', 'comments', 'status'];
            foreach ($model->attributes as $key => $dta) {
                if (!in_array($key, $a)) {
                    if (strpos($dta, '-') == false) {

                        if (strlen($dta) < 16 && strlen($dta) >= 8 && $dta != NULL)
                            $model->$key = $this->ChangeFormat($dta);
                        //echo $model->$key;exit;
                    }else {
                        $year = substr($dta, 0, 4);
                        $month = substr($dta, 5, 2);
                        $day = substr($dta, 8, 2);
                        $hour = substr($dta, 11, 2) == '' ? '00' : substr($dta, 11, 2);
                        $min = substr($dta, 14, 2) == '' ? '00' : substr($dta, 14, 2);
                        $sec = substr($dta, 17, 2) == '' ? '00' : substr($dta, 17, 2);

                        if ($hour != '00' && $min != '00' && $sec != '00') {
                            $model->$key = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec;
                        } elseif ($hour != '00' && $min != '00') {
                            $model->$key = $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min;
                        } elseif ($hour != '00') {
                            $model->$key = $year . '-' . $month . '-' . $day . ' ' . $hour . ':00';
                        } else {
                            $model->$key = $year . '-' . $month . '-' . $day;
                        }
                    }
                }
            }
            return $model;
        }
    }

    public function ChangeFormat($data) {

        $day = substr($data, 0, 2);
        $month = substr($data, 2, 2);
        $year = substr($data, 4, 4);
        $hour = substr($data, 9, 2) == '' ? '00' : substr($data, 9, 2);
        $min = substr($data, 11, 2) == '' ? '00' : substr($data, 11, 2);
        $sec = substr($data, 13, 2) == '' ? '00' : substr($data, 13, 2);
        if ($hour != '00' && $min != '00' && $sec != '00') {
            //echo '1';exit;
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min . ':' . $sec;
        } elseif ($hour != '00' && $min != '00') {
            //echo '2';exit;
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':' . $min;
        } elseif ($hour != '00') {
            //echo '3';exit;
            return $year . '-' . $month . '-' . $day . ' ' . $hour . ':00';
        } else {

            return $year . '-' . $month . '-' . $day;
        }
    }

    /**
     * Deletes an existing Test model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Test model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Test the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Test::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCrone() {
        date_default_timezone_set("Asia/Kolkata");
        $time = strtotime(date("H:i:s"));
        $current_date = date("Y-m-d H:i:s");
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        $arr = [0, 6, 12, 24];
        foreach ($arr as $val) {
            if ($val == 0) {
                $eta_datas = \common\models\PortCallData::find()->where(['<', 'eta', $current_date])->andWhere(['not', ['cast_off' => null]])->andWhere(['not', ['cast_off' => '0000-00-00 00:00:00']])->all();
                $cast_off_datas = \common\models\PortCallData::find()->where(['<', 'cast_off', $current_date])->andWhere(['not', ['cast_off' => null]])->andWhere(['not', ['cast_off' => '0000-00-00 00:00:00']])->all();
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
                    $date1 = date("Y-m-d H:i:s");
                    $date2 = $value->eta;
                    echo $date1 . '<br/>';
                    echo $date2 . '<br/>';
                    $diff = strtotime($date1) - strtotime($date2);
                    $dd = gmdate("y m d H:i:s", $diff);
                    $day = gmdate("d", $diff);
                    $hours = gmdate("H", $diff);
                    echo $dd . '<br/>';
                    echo $day . '<br/>';
                    echo $hours . '<br/>';
                    exit;
                    if ($day > 0) {
                        $diff_in_hrs = $day . ' days ' . $hours . ' hours';
                    } else {
                        $diff_in_hrs = $hours . 'hours';
                    }
                    $msg = 'Castof for appointment <span class="appno-highlite">' . $app_no . '</span> is over about more than almost <span class="appno-highlite">' . $diff_in_hrs . '<span>';
                    $msg1 = 'Castof for appointment ' . $app_no . ' is over about more than almost ' . $diff_in_hrs;
                } else {
                    $msg = 'Castof for appointment <span class="appno-highlite">' . $app_no . '</span> in <span class="appno-highlite">' . $hour . '</span> hour';
                    $msg1 = 'Castof for appointment ' . $app_no . ' in ' . $hour . ' hour';
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
                $date1 = date("Y-m-d H:i:s");
                $date2 = $value->eta;
                $diff = strtotime($date1) - strtotime($date2);
                $day = gmdate("d", $diff);
                $hours = gmdate("H", $diff);
                if ($day > 0) {
                    $diff_in_hrs = $day . ' days ' . $hours . ' hours';
                } else {
                    $diff_in_hrs = $hours . 'hours';
                }
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

    public function functionName($eta) {
        $start_date = $eta;
        $end_date = date("Y-m-d H:i:s");
        $diff = abs(strtotime($end_date) - strtotime($start_date));
        $years = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        echo $years . ' Years ' . $months . ' Month ' . $days . ' Days ' . $hours . ' Hours';
        exit;
    }

}
