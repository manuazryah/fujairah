<?php

namespace backend\modules\task\controllers;

use Yii;
use common\models\Task;
use common\models\TaskSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller {

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
     * Lists all Task models.
     * @return mixed
     */
    public function actionIndex($task = NULL) {
        $model = new Task();
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if (!empty($task) && $task != '') {
            if ($task == 'mytask') {
                $dataProvider->query->andWhere(['assigned_to' => Yii::$app->user->identity->id]);
            }
            if ($task == 'completedtask') {
                $dataProvider->query->andWhere(['status' => 4]);
            }
        } else {
            $dataProvider->query->andWhere(['<>', 'status', 4]);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->assigned_from = Yii::$app->user->identity->id;
            if ($model->follow_up != '') {
                $model->follow_up = implode(",", $model->follow_up);
                $model->appointment_id = implode(",", $model->appointment_id);
            }
            if ($model->save()) {
                $user_info = \common\models\Employee::findOne(['id' => $model->assigned_to]);
                $this->SendEmail($model, $user_info);
                $super_users = \common\models\Employee::find()->where(['post_id' => 1])->all();
                if (!empty($super_users)) {
                    foreach ($super_users as $super_user) {
                        $this->SendEmail($model, $super_user);
                    }
                }
            }
            return $this->redirect(['index']);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

    public function SendEmail($model, $user_info) {
        $assigned_from = \common\models\Employee::findOne($model->assigned_from)->name;
        $assigned_to = \common\models\Employee::findOne($model->assigned_to)->name;
        if (isset($model->follow_up) && $model->follow_up != '') {
            $followers = '';
            $arr = explode(",", $model->follow_up);
            foreach ($arr as $value) {
                $followers .= \common\models\Employee::findOne($value)->name . ',';
            }
        }
        $to = $user_info->email;
// subject
        $subject = ' Attenssion : ' . $user_info->name . 'Updated Tasks in dxb.esl-da.com';

        $message = '<html><head></head><body><h4>Hi ' . $user_info->name . ',</h4><p><b>Here are some updates on tasks</b></p><p style="color: #b92f2f;font-size: 20px;"><b>Emperror Shipping Lines LL.C</b></p><div style="border: 1px solid black;padding: 5px 30px 30px 30px;">';
//        $message .= "<tr><td style='border: 1px solid black;padding: 5px 12px;  '>New Task</td><td style='border: 1px solid black;padding: 5px 12px;'>" . $model->follow_up_msg . "</td></tr>";
        $message .= "<p><h3 style='color: #8e8b8b;margin-top: 0px;'>Task Details</p></h3><table>";
        $message .= "<tr style='font-size: 16px;'><td style='padding: 6px 0px;'>Assignee</td><td>  :  </td><td>" . $assigned_from . "</td></tr>";
        $message .= "<tr style='font-size: 16px;'><td style='padding: 6px 0px;'>Assigned To</td><td>  :  </td><td>" . $assigned_to . "</td></tr>";
        $message .= "<tr style='font-size: 16px;'><td style='padding: 6px 0px;'>Due Date</td><td>  :  </td><td>" . date("d-M-Y", strtotime($model->date)) . "</td></tr>";
        $message .= "<tr style='font-size: 16px;'><td style='padding: 6px 0px;'>Projects</td><td>  :  </td><td>" . Emperror . "</td></tr>";
        $message .= "<tr style='font-size: 16px;'><td style='padding: 6px 0px;'>Followers</td><td>  :  </td><td>" . rtrim($followers, ",") . "</td></tr>";
        $message .= '</table></div></body></html>';

// To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperorda.com";
        mail($to, $subject, $message, $headers);


        return true;
    }

    /**
     * Displays a single Task model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Task();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionTaskComplete($id) {
        $model = $this->findModel($id);
        $model->status = 4;
        $model->update();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Task::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateTask() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $task = \common\models\Task::findOne(['id' => $id]);
            $task->status = 4;
            $task->completed_date = date('Y-m-d');
            if ($task->save()) {
                $this->TaskCompleteEmail($task);
            }
            $tasks = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->limit(10)->all();
            $count = count($tasks);
            $i = 0;
            if ($count >= 10) {
                foreach ($tasks as $value) {
                    $i++;
                    if ($i == $count) {
                        $arr_variable = array('id' => $value->id, 'content' => $value->follow_up_msg, 'date' => $value->date);
                        $data['result'] = $arr_variable;
                        echo json_encode($data);
                    }
                }
            } else {
                echo 1;
                exit;
            }
        }
    }

    public function TaskCompleteEmail($model) {
        $from_user = \common\models\Employee::find()->where(['id' => $model->assigned_from])->one();
        $to_user = \common\models\Employee::find()->where(['id' => $model->assigned_to])->one();
        $to = $from_user->email;
        $subject = ' Attenssion : ' . $from_user->name . ' ( Task Completed )';
        $message = '<html><head></head><body>';
        $message .= '<p>Task <span style="color: #2196F3;">' . $model->follow_up_msg . '</span> completed by <span style="color: #2196F3;">' . $to_user->name . '</span> on <span style="color: #2196F3;">' . date('d-m-Y') . ' </span></p>';
        $message .= '</body></html>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperorda.com";
        mail($to, $subject, $message, $headers);
        return true;
    }

    public function actionUpdateAssignedPerson() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $assigned = $_POST['person_id'];
            $task = \common\models\Task::findOne(['id' => $id]);
            $task->assigned_to = $assigned;
            if ($task->save()) {
                echo $assigned;
            } else {
                echo '';
            }
        }
    }

    public function actionUpdateFollowups() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $followup = $_POST['followup_id'];
            $task = \common\models\Task::findOne(['id' => $id]);
            $task->follow_up = implode(",", $followup);
            if ($task->save()) {
                echo $followup;
            } else {
                echo '';
            }
        }
    }

    public function actionUpdateAssignDate() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $assign_date = $_POST['date'];
            $task = \common\models\Task::findOne(['id' => $id]);
            $task->date = $assign_date;
            if ($task->save()) {
                echo $assign_date;
            } else {
                echo '';
            }
        }
    }

}
