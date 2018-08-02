<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Employee;
use common\models\AdminPosts;
use kartik\mpdf\Pdf;
use common\models\ForgotPasswordTokens;
use common\models\Appointment;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'index', 'home', 'report', 'forgot', 'new-password', 'exception', 'get-notification-task'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'Home', 'forgot', 'new'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {

    
        if (!Yii::$app->user->isGuest) {

            return $this->redirect(array('site/home'));
        }
        $this->layout = 'login';
        $model = new Employee();
        $model->scenario = 'login';
        if ($model->load(Yii::$app->request->post()) && $model->login() && $this->setSession()) {

            return $this->redirect(array('site/home'));
        } else {

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    public function setSession() {
        $post = AdminPosts::findOne(Yii::$app->user->identity->post_id);
        Yii::$app->session['post'] = $post->attributes;

        return true;
    }

    public function actionHome() {
        date_default_timezone_set("Asia/Dubai");
        $time = strtotime(date("H:i:s"));
        $startTime = date("Y-m-d H:i:s", strtotime('-31 minutes', $time));
        $endTime = date("Y-m-d H:i:s", strtotime('+31 minutes', $time));
        if (Yii::$app->user->isGuest) {
            return $this->redirect(array('site/index'));
        }
        $begin = date('Y-m-d H:i:s', strtotime($startTime . ' +1 day'));
        $end = date('Y-m-d H:i:s', strtotime($endTime . ' +1 day'));
        $expected_datas = \common\models\Appointment::find()->where(['<=', 'eta', $end])->andWhere(['>=', 'eta', $begin])->all();
        $sailed = Appointment::find()->where(['status' => 1, 'stage' => 4])->all();
        $inports = Appointment::find()->where(['status' => 1, 'stage' => 3])->all();
        return $this->render('index', [
                    'expected_datas' => $expected_datas,
                    'sailed' => $sailed,
                    'inports' => $inports,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin() {
        $this->layout = 'login';
        if (!Yii::$app->user->isGuest) {

            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();
        } else {

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        unset(Yii::$app->session['post']);
        return $this->goHome();
    }

    public function actionReport() {
        // get your HTML raw content without any layouts or scripts
        $content = $this->renderPartial('pdf');

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            //'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@backend/web/css/pdf.css',
            // any css to be embedded if required
            //'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            //'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['Krajee Report Header' . date("y-m-d h:m:s")],
                'SetFooter' => ['|page {PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

      public function actionForgot() {
        date_default_timezone_set("Asia/Dubai");
        $this->layout = 'login';
        $model = new Employee();
        if ($model->load(Yii::$app->request->post())) {
            $check_exists = Employee::find()->where(['user_name' => $model->user_name])->one();
            if (!empty($check_exists)) {
                $token_value = $this->tokenGenerator();
                $token = $check_exists->id . '_' . $token_value;
                $val = base64_encode($token);
                $token_model = new ForgotPasswordTokens();
                $token_model->user_id = $check_exists->id;
                $token_model->token = $token_value;
                $token_model->date = date('Y-m-d h:m:s');
                $token_model->save();
                $this->sendMail($val, $check_exists->email);
                $msg = "Reset password link has been sent to your email ID(" . $check_exists->email . "). The link will expire in 15 minutes. If you couldn't find the mail in your inbox check you spam box.";
                Yii::$app->getSession()->setFlash('success', $msg);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Invalid username');
            }
            return $this->render('forgot-password', [
                        'model' => $model,
            ]);
        } else {
            return $this->render('forgot-password', [
                        'model' => $model,
            ]);
        }
    }

    public function tokenGenerator() {

        $length = rand(1, 1000);
        $chars = array_merge(range(0, 9));
        shuffle($chars);
        $token = implode(array_slice($chars, 0, $length));
        return $token;
    }

    public function sendMail($val, $email) {

//        echo '<a href="' . Yii::$app->homeUrl . 'site/new-password?token=' . $val . '">Click here change password</a>';
//        exit;
        $to = $email;

// subject
        $subject = 'Change password';

// message
//                echo
        $message = '
<html>
<head>
  <title>Forgot Password</title>
</head>
<body>
  <p>As requested, here is a link to allow you to select a new Emperror password:</p>
  <table>

     <tr>
      <td><a href="' . Yii::$app->getRequest()->serverName . Yii::$app->homeUrl . 'site/new-password?token=' . $val . '">Click here for reset your password</a></td>
    </tr>

  </table>
  <p>This link will expire in 15 minutes.</p>
</body>
</html>
';
        
//                exit;
// To send HTML mail, the Content-type header must be set
       $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperorda.com";
        mail($to, $subject, $message, $headers);
    }

    public function actionNewPassword($token) {
        date_default_timezone_set("Asia/Dubai");
        $this->layout = 'login';
        $data = base64_decode($token);
        $values = explode('_', $data);
        $token_exist = ForgotPasswordTokens::find()->where("user_id = " . $values[0] . " AND token = " . $values[1])->one();
        if (!empty($token_exist)) {
            $to_time = strtotime(date('Y-m-d h:m:s'));
            $from_time = strtotime($token_exist->date);
            $diff = round(abs($to_time - $from_time) / 60, 2);
            if ($diff < 15) {
                $model = Employee::find()->where("id = " . $token_exist->user_id)->one();
                if (Yii::$app->request->post()) {
                    if (Yii::$app->request->post('new-password') == Yii::$app->request->post('confirm-password')) {
                        $model->password = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirm-password'));
                        if ($model->update()) {
                            Yii::$app->session['change-pwd-success-msg'] = 'password changed successfully';
//                        Yii::$app->getSession()->setFlash('success', 'password changed successfully');
                        }
                        $token_exist->delete();
                        $this->redirect('index');
                    } else {
                        Yii::$app->getSession()->setFlash('error', 'password mismatch  ');
                    }
                }
                return $this->render('new-password', [
                ]);
            } else {
                $token_exist->delete();
                Yii::$app->session['change-pwd-error-msg'] = "This password reset link is expired. Please try again.";
                $this->redirect('index');
            }
        } else {
            Yii::$app->session['change-pwd-error-msg'] = "This password reset link is expired. Please try again.";
            $this->redirect('index');
        }
    }

    public function actionException() {
        return $this->render('exception');
    }

    public function actionGetNotificationTask() {
        if (Yii::$app->request->isAjax) {
            $notifications = \common\models\Notification::find()->where(['status' => 1])->orderBy(['id' => SORT_DESC])->limit(10)->all();
            $notification_count = \common\models\Notification::find()->where(['status' => 1])->count();
            $my_tasks = \common\models\Task::find()->where(['status' => 3, 'assigned_to' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->limit(10)->all();
            $my_tasks_count = \common\models\Task::find()->where(['status' => 3, 'assigned_to' => Yii::$app->user->identity->id])->count();
            if (empty($my_tasks)) {
                $my_tasks = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->orderBy(['id' => SORT_DESC])->limit(10)->all();
                $my_tasks_count = \common\models\Task::find()->where(['status' => 1, 'assigned_to' => Yii::$app->user->identity->id])->count();
            }
            $options = '';
            $task_options = '';
            foreach ($notifications as $notification) {
                $options .= '<li class="active notification-success" id="notify-' . $notification->id . '" >
                                <a>
                                                    <span class="line notification-line" style="width: 85%;padding-left: 0;cursor: pointer;" id="' . $notification->appointment_id . '">
                                                        <strong style="line-height: 20px;">' . $notification->content . '</strong>
                                                    </span>
                                                    <span class="line small time" style="padding-left: 0;">' . $notification->date . '
                                                    </span>
                                                    <input type="checkbox" checked="" class="iswitch iswitch-secondary disable-notification" data-id= "' . $notification->id . '" style="margin-top: -35px;float: right;" title="Closed">
                                                </a>
                                </li>';
            }
            foreach ($my_tasks as $my_task) {
                $task_options .= '<li class="active notification-success" id="tassks-' . $my_task->id . '" >
                                <a href="#">
                                                    <span class="line" style="width: 85%;padding-left: 0;">
                                                        <strong style="line-height: 20px;">' . $my_task->follow_up_msg . '</strong>
                                                    </span>
                                                    <span class="line small time" style="padding-left: 0;">' . $my_task->date . '
                                                    </span>
                                                    <input type="checkbox" checked="" class="iswitch iswitch-blue close-task" data-id= "' . $my_task->id . '" style="margin-top: -35px;float: right;" title="Closed">
                                                </a>
                                </li>';
            }

            $arr_variables = array('notification-list' => $options, 'notificationcount' => $notification_count, 'task-list' => $task_options, 'taskcount' => $my_tasks_count);
            $data['result'] = $arr_variables;
            echo json_encode($data);
        }
    }

    public function getPrincipals($id) {
        $princip = explode(',', $id);
        $result = '';
        $i = 0;
        if (!empty($princip)) {
            foreach ($princip as $val) {

                if ($i != 0) {
                    $result .= ',';
                }
                $principals = \common\models\Debtor::findOne($val);
                $result .= $principals->principal_id;
                $i++;
            }
        }

        return $result;
    }

}
