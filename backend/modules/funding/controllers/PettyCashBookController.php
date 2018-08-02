<?php

namespace backend\modules\funding\controllers;

use Yii;
use common\models\PettyCashBook;
use common\models\PettyCashBookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Appointment;
use common\models\AppointmentSearch;
use common\models\CloseEstimate;
use common\models\CashInHand;

/**
 * PettyCashBookController implements the CRUD actions for PettyCashBook model.
 */
class PettyCashBookController extends Controller {

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
     * Lists all PettyCashBook models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PettyCashBook model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PettyCashBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new PettyCashBook();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PettyCashBook model.
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
     * Deletes an existing PettyCashBook model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PettyCashBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PettyCashBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PettyCashBook::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAdd($id) {
        $model = PettyCashBook::findAll(['appointment_id' => $id]);
        $appointment = Appointment::findOne($id);
        $close_estimates = CloseEstimate::findAll(['apponitment_id' => $id]);
        if (!empty($close_estimates)) {
            $this->SetData($close_estimates, $id);
        }
        $model_petty_cash = PettyCashBook::findAll(['appointment_id' => $id]);
        return $this->render('add', [
                    'model' => $model,
                    'model_petty_cash' => $model_petty_cash,
                    'close_estimates' => $close_estimates,
                    'appointment' => $appointment,
                    'id' => $id,
        ]);
    }

    protected function SetData($close_estimates, $id) {

        foreach ($close_estimates as $close_estimate) {
            $data_exist = PettyCashBook::find()->where(['appointment_id' => $close_estimate->apponitment_id, 'close_estimate_id' => $close_estimate->id])->one();
            if (empty($data_exist)) {
                $model = new PettyCashBook();
                $model->appointment_id = $id;
                $model->close_estimate_id = $close_estimate->id;
                $model->service_id = $close_estimate->service_id;
                $model->supplier = $close_estimate->supplier;
                $model->debtor_id = $close_estimate->principal;
                $model->fda_amount = $close_estimate->fda;
                $actual_funding = \common\models\ActualFunding::findOne(['close_estimate_id' => $close_estimate->id]);
                if ($actual_funding->actual_amount != '') {
                    $model->actual_amount = $actual_funding->actual_amount;
                } else {
                    $model->actual_amount = 0;
                }
                $model->status = 1;
                Yii::$app->SetValues->Attributes($model);
            } else {
                $model = PettyCashBook::find()->where(['appointment_id' => $close_estimate->apponitment_id, 'close_estimate_id' => $close_estimate->id])->one();
            }
            $model->save();
        }
        return $model;
    }

    public function actionSavePettyCash() {
        $id = $_POST['app_id'];
        $arr = [];
        $tot = 0;
        if (isset($_POST['amount_debit']) && $_POST['amount_debit'] != '') {
            foreach ($_POST['amount_debit'] as $key => $value) {
                $arr[$key]['amount_debit'] = $value;
                $tot += $value;
            }
        }
        if (isset($_POST['invoice_date']) && $_POST['invoice_date'] != '') {
            foreach ($_POST['invoice_date'] as $key => $value) {
                $arr[$key]['invoice_date'] = $value;
            }
        }
        $user_account = CashInHand::find()->orderBy(['id' => SORT_DESC])->where(['employee_id' => Yii::$app->user->identity->id])->one();
        if (!empty($user_account)) {
            if ($user_account->balance >= $tot) {
                $this->UpdatePettyCash($arr, $user_account);
            } else {
                Yii::$app->getSession()->setFlash('error', 'User account amount is Lower');
                return $this->redirect(['add', 'id' => $id]);
            }
        } else {
            Yii::$app->getSession()->setFlash('error', 'User account is empty');
            return $this->redirect(['add', 'id' => $id]);
        }
        return $this->redirect(['add', 'id' => $id]);
    }

    public function UpdatePettyCash($arr, $user_account) {
        foreach ($arr as $key => $value) {
            $petty_cash_model = PettyCashBook::findOne(['close_estimate_id' => $key]);
            if (isset($value['invoice_date'])) {
                $petty_cash_model->invoice_date = $value['invoice_date'];
            }
            if ($petty_cash_model->amount_debit == '') {
                $petty_cash_model->employee_id = Yii::$app->user->identity->id;
                $petty_cash_model->amount_debit = $value['amount_debit'];
                if ($petty_cash_model->save()) {
                    $this->UpdateUserAccount($petty_cash_model, $user_account);
                }
            } else {
                if ($value != '')
                    $this->AddPettyCash($petty_cash_model, $value);
            }
        }
        return TRUE;
    }

    public function UpdateUserAccount($petty_cash_model) {
        $user_account = CashInHand::find()->orderBy(['id' => SORT_DESC])->where(['employee_id' => Yii::$app->user->identity->id])->one();
        $model = new CashInHand();
        $model->employee_id = Yii::$app->user->identity->id;
        $model->transaction_type = 2;
//        $model->payment_type = $model_fund->payment_type;
//        $model->check_no = $model_fund->check_no;
        $model->amount = $petty_cash_model->amount_debit;
        $model->date = $petty_cash_model->invoice_date;
        $model->appointment_id = $petty_cash_model->appointment_id;
        $model->balance = $user_account->balance - $petty_cash_model->amount_debit;
        Yii::$app->SetValues->Attributes($model);
        $model->save();
        return;
    }

    public function AddPettyCash($petty_cash_model, $value) {
        $model_supplier = new PettyCashBook();
        $model_supplier->appointment_id = $petty_cash_model->appointment_id;
        $model_supplier->close_estimate_id = $petty_cash_model->close_estimate_id;
        $model_supplier->debtor_id = $petty_cash_model->debtor_id;
        $model_supplier->employee_id = Yii::$app->user->identity->id;
        $model_supplier->service_id = $petty_cash_model->service_id;
        $model_supplier->supplier = $petty_cash_model->supplier;
//        $model_supplier->actual_amount = $petty_cash_model->actual_amount;
        $model_supplier->amount_debit = $value['amount_debit'];
        $model_supplier->invoice_date = $petty_cash_model->invoice_date;
        $model_supplier->fda_amount = $petty_cash_model->fda_amount;
        $model_supplier->actual_amount = $petty_cash_model->actual_amount;
        $model_supplier->status = 1;
        Yii::$app->SetValues->Attributes($model_supplier);
        if ($model_supplier->save()) {
            $this->UpdateUserAccount($model_supplier);
        }
        return true;
    }

}
