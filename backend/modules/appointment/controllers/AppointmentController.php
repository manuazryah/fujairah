<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\Appointment;
use common\models\Ports;
use common\models\PortCallData;
use common\models\PortCallDataDraft;
use common\models\PortCallDataRob;
use common\models\EstimatedProforma;
use common\models\CloseEstimate;
use common\models\AppointmentSearch;
use common\models\PortBreakTimings;
use common\models\Currency;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ImigrationClearance;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * AppointmentController implements the CRUD actions for Appointment model.
 */
class AppointmentController extends Controller {

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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['addBasic'],
                'rules' => [
                    [
                        'actions' => ['appointmentNo'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Appointment models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!empty(Yii::$app->request->queryParams['AppointmentSearch']['stage'])) {
            $dataProvider->query->andWhere(['stage' => Yii::$app->request->queryParams['AppointmentSearch']['stage']]);
        } else {
            $dataProvider->query->andWhere(['<>', 'stage', 5]);
        }

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Appointment model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $estimates = EstimatedProforma::findAll(['apponitment_id' => $id]);
        $ports = PortCallData::findOne(['appointment_id' => $id]);
        $closeestimates = CloseEstimate::findAll(['apponitment_id' => $id]);
        $drafts = PortCallDataDraft::findOne(['appointment_id' => $id]);
        $rob = PortCallDataRob::findOne(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        $imigration = ImigrationClearance::findOne(['appointment_id' => $id]);
        return $this->render('view', [
                    'model' => $this->findModel($id),
                    'estimates' => $estimates,
                    'appointment' => $appointment,
                    'ports' => $ports,
                    'drafts' => $drafts,
                    'rob' => $rob,
                    'closeestimates' => $closeestimates,
                    'imigration' => $imigration,
        ]);
    }

    /**
     * Creates a new Appointment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Appointment();
        $model->setScenario('create');
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $this->Principal($model, $_POST['Appointment']['principal'])) {
            $files = UploadedFile::getInstance($model, 'final_draft_bl');
            if (!empty($files)) {
                $model->final_draft_bl = $files->extension;
            }
            $model->eta = Yii::$app->ChangeDateFormate->SingleDateFormat($model->eta);
            $model->stage = 1;
           if ($model->validate() && $model->save()) {
                $this->AddNotification($model);
                $user = \common\models\Employee::find()->where(['id' => Yii::$app->user->identity->id])->one();
                
                if (!empty($user)) {
                    $this->SendEmail($model, $user, $user->name);
                }
                $super_users = \common\models\Employee::find()->where(['status' => 1,'post_id'=>1])->andWhere(['<>', 'id', Yii::$app->user->identity->id])->all();
                if (!empty($super_users)) {
                    foreach ($super_users as $super_user) {
                        $this->SendEmail($model, $super_user, $user->name);
                    }
                }
                if (!empty($files)) {
                    $this->Upload($model, $files);
                }
                $this->PortCall($model);
                if (!empty($_POST['check'])) {
                    return $this->redirect(['/appointment/estimated-proforma/add', 'id' => $model->id, 'check' => true]);
                } else {
                    return $this->redirect(['/appointment/estimated-proforma/add', 'id' => $model->id]);
                }
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function SendEmail($model, $user_info, $user_name) {
        $to = $user_info->email;
        $subject = ' Attenssion : ' . $user_info->name . ' ( New Appointment Created )';
        $message = '<html><head></head><body>';
        $message .= '<p>New Appointment <span style="color: #2196F3;">' . $model->appointment_no . '</span> created by <span style="color: #2196F3;">' . $user_name . '</span> on <span style="color: #2196F3;">' . $model->DOC . ' </span></p>';
        $message .= '</body></html>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n" .
                "From: 'no-reply@emperorda.com";
        mail($to, $subject, $message, $headers);


        return true;
    }

    public function AddNotification($appointment) {
        $msg = 'New Appointment <span class="appno-highlite">' . $appointment->appointment_no . '</span> Created on <span class="appno-highlite">' . date('d-M-Y') . '</span>';
        $msg1 = 'New Appointment ' . $appointment->appointment_no . ' Created on ' . date('d-M-Y');
        $model = new \common\models\Notification();
        $model->notification_type = 3;
        $model->appointment_id = $appointment->id;
        $model->appointment_no = $appointment->appointment_no;
        $model->content = $msg;
        $model->message = $msg1;
        $model->status = 1;
        $model->date = date("Y-m-d H:i:s");
        $model->save();
        return;
    }

    public function Upload($model, $files) {
        $paths = Yii::$app->basePath . '/../uploads/final_draft' . '/' . $model->id;
        if (!is_dir($paths)) {
            mkdir($paths);
        }
        $path = Yii::$app->basePath . '/../uploads/final_draft' . '/' . $model->id . '/' . $files->name;
//                if (file_exists($path)) {
//                        unlink($path);
//                }
        $files->saveAs($path);
        return true;
    }

    /**
     * Updates an existing Appointment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $stage = $model->stage;
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $this->Principal($model, $_POST['Appointment']['principal'])) {
            $model->eta = Yii::$app->ChangeDateFormate->SingleDateFormat($model->eta);
            $files = UploadedFile::getInstance($model, 'final_draft_bl');
            if (!empty($files)) {
                $model->final_draft_bl = $files->extension;
                $this->Upload($model, $files);
            } else {
                $model_data = Appointment::findOne($id);
                $model->final_draft_bl = $model_data->final_draft_bl;
            }
            if ($stage == 5 && $model->status == 1) {
                $model->stage = 4;
            } elseif ($model->status == 0) {
                $model->stage = 5;
            }
            $model->save();
            $model->eta = Yii::$app->ChangeDateFormate->SingleDateFormat($model->eta);
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            $model->eta = Yii::$app->ChangeDateFormate->SingleDateFormat($model->eta);
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDisable($id) {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();
        return $this->redirect(['view', 'id' => $model->id]);
    }

    /*
     * This function create entry in port call data tables when creating a new appointment
     */

    public function PortCall($model) {
        $port_data = new PortCallData();
        $port_draft = new PortCallDataDraft();
        $port_rob = new PortCallDataRob();
        $port_imigration = new ImigrationClearance();
        $port_data->appointment_id = $model->id;
        $port_data->eta = Yii::$app->ChangeDateFormate->SingleDateFormat($model->eta);
        $port_draft->appointment_id = $model->id;
        $port_rob->appointment_id = $model->id;
        $port_imigration->appointment_id = $model->id;
        Yii::$app->SetValues->Attributes($port_imigration);
        Yii::$app->SetValues->Attributes($port_data);
        Yii::$app->SetValues->Attributes($port_draft);
        Yii::$app->SetValues->Attributes($port_rob);

        if ($port_imigration->save() && $port_data->save() && $port_draft->save() && $port_rob->save()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * This function get principal from multiple select box and implode it with comma
     * return principal as a string
     */

    public function Principal($model, $principle) {
        if ($model != null && $principle != '') {
            $model->principal = implode(",", $principle);
            Yii::$app->SetValues->Attributes($model);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     * Deletes an existing Appointment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Appointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Appointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Appointment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /*
     * This function generate appointment number basedon the previous appointment number
     * return appointment number
     */

    public function actionAppointmentNo() {
        if (Yii::$app->request->isAjax) {
            $port_id = $_POST['port_id'];
            $port_data = Ports::find()->where(['id' => $port_id])->one();
            $last_appointment = Appointment::find()->orderBy(['id' => SORT_DESC])->where(['port_of_call' => $port_id])->one();
            if (empty($last_appointment))
                echo 'ENESF' . $port_data->code . '0001';
            else {
                $last = substr($last_appointment->appointment_no, -4);
                $last = ltrim($last, '0');

                echo 'ENESF' . $port_data->code . (sprintf('%04d', ++$last));
            }
        } else {
            return '';
        }
    }

    /*
     * This function select vessel type
     * return result to the view
     */

    public function actionVesselType() {
        if (Yii::$app->request->isAjax) {
            $vessel_type = $_POST['vessel_type'];
            $vessel_datas = \common\models\Vessel::findAll(['vessel_type' => $vessel_type, 'status' => 1]);
            $options = '<option value="">-Choose a Vessel-</option>';
            foreach ($vessel_datas as $vessel_data) {
                $options .= "<option value='" . $vessel_data->id . "'>" . $vessel_data->vessel_name . "</option>";
            }

            echo $options;
        }
    }

    /*
     * This function generate report for all the appointment
     */

    public function actionSearch() {
        $appointment = Appointment::find()->all();
        return $this->render('search', [
                    'appointment' => $appointment,
        ]);
    }

    /*
     * This functio remove uploaded path
     */

    public function actionRemove($path) {
        if (Yii::$app->session['post']['id'] == 1) {
            unlink($path);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /*
     * This functio add popup form for adding new vessals
     */

    public function actionAddNewVessel() {
        if (Yii::$app->request->isAjax) {
            $vessel_type = $_POST['vessel_type'];
            $type = $_POST['type'];
            $vessel_model = new \common\models\Vessel();
            $data = $this->renderPartial('_form_add_vessel', [
                'vessel_model' => $vessel_model,
                'vessel_type' => $vessel_type,
                'type' => $type,
            ]);
            echo $data;
        }
    }

    public function actionUpdateVessel() {
        if (Yii::$app->request->isAjax) {
            $vessel_model = new \common\models\Vessel();
            if ($vessel_model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($vessel_model)) {
                $vessel_model->status = 1;
                if ($vessel_model->save(false)) {
                    $arr_variable = array('id' => $vessel_model->id, 'name' => $vessel_model->vessel_name);
                    $data['result'] = $arr_variable;
                    echo json_encode($data);
                }
            }
        }
    }

    public function actionUniqueVessel() {

        if (Yii::$app->request->isAjax) {

            $vessel_name = $_POST['vessel_name'];
            $imo_no = $_POST['imo_no'];
            $official = $_POST['official'];
            $vessel_name_exist = \common\models\Vessel::find()->where(['vessel_name' => $vessel_name])->one();
            $imo_no_exist = \common\models\Vessel::find()->where(['imo_no' => $imo_no])->one();
            $official_exist = \common\models\Vessel::find()->where(['official' => $official])->one();
            if (empty($vessel_name_exist) && empty($imo_no_exist) && empty($official_exist)) {
                echo '0';
                exit;
            } elseif (!empty($vessel_name_exist)) {
                echo '1';
                exit;
            } elseif (!empty($imo_no_exist)) {
                echo '2';
                exit;
            } elseif (!empty($official_exist)) {
                echo '3';
                exit;
            }
        }
    }

    /*
     * This functio add popup form for adding new contacts
     */

    public function actionAddNewContacts() {
        if (Yii::$app->request->isAjax) {
            $type = $_POST['type'];
            $contact_type = $type;
            $contact_model = new \common\models\Contacts();
            $data = $this->renderPartial('_form_add_contacts', [
                'contact_model' => $contact_model,
                'contact_type' => $contact_type,
                'type' => $type,
            ]);
            echo $data;
        }
    }

    public function actionUpdateContacts() {
        if (Yii::$app->request->isAjax) {
            $contact_model = new \common\models\Contacts();
            if ($contact_model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($contact_model)) {
                $contact_model->status = 1;
                $contact_model->contact_type = 1;
                if ($contact_model->save(false)) {
                    $arr_variable1 = array('id' => $contact_model->id, 'name' => $contact_model->name);
                    $data['result'] = $arr_variable1;
                    echo json_encode($data);
                }
            }
        }
    }

    public function actionAddNewPrincipals() {
    
        if (Yii::$app->request->isAjax) {
            $debtor_model = new \common\models\Debtor();
            $data = $this->renderPartial('_form_add_principals', [
                'debtor_model' => $debtor_model,
            ]);
            
            echo $data;
        }
    }

    public function actionUpdatePrincipals() {
        if (Yii::$app->request->isAjax) {
            $debtor_model = new \common\models\Debtor();
            if ($debtor_model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($debtor_model)) {
                $debtor_model->status = 1;
                if ($debtor_model->save(false)) {
                    $arr_variable2 = array('id' => $debtor_model->id, 'name' => $debtor_model->principal_name);
                    $data['result'] = $arr_variable2;
                    echo json_encode($data);
                }
            }
        }
    }

}
