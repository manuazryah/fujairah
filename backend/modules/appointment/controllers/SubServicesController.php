<?php

namespace backend\modules\appointment\controllers;

use Yii;
use common\models\SubServices;
use common\models\SubServicesSearch;
use common\models\MasterSubService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EstimatedProforma;
use common\models\Appointment;
use common\models\TaxMaster;

/**
 * SubServicesController implements the CRUD actions for SubServices model.
 */
class SubServicesController extends Controller {

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
     * Lists all SubServices models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SubServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SubServices model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SubServices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new SubServices();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    public function actionAdd($id, $sub_id = NULL) {

        $estimates = EstimatedProforma::findOne(['id' => $id]);
//                echo "<pre>";
//                var_dump($estimates);exit;
        $appointment = Appointment::findOne($estimates->apponitment_id);
        $mastersub = MasterSubService::findAll(['service_id' => $estimates->service_id]);

//                var_dump($sub_service);
//                exit;
        $subcat = SubServices::findAll(['estid' => $id]);

        $subtotal = 0;
        $subtotal_unit = 0;
        $subtotal_rate = 0;
        $tax_total = 0;
        if (!empty($subcat)) {
            foreach ($subcat as $sub) {
                if (isset($sub->service_id) && $sub->service_id != '') {
                    $service = \common\models\Services::find()->where(['id' => $sub->service_id])->one();
                    if (!empty($service)) {
                        if ($service->tax != '' && $service->tax > 0 && $sub->total != '' && $sub->total > 0) {
                            $tax_rate = TaxMaster::findOne($service->tax)->value;
                            if ($tax_rate > 0) {
                                $sub->tax_amount = ($tax_rate / 100) * $sub->total;
                                $sub->save(FALSE);
                                $tax_total += $sub->tax_amount;
                            }
                        }
                    }
                }
                $subtotal += $sub->total;
                if ($sub->total != '') {
                    $subtotal_unit += $sub->unit;
                    $subtotal_rate += $sub->unit_price;
                }
            }
            $estimates = EstimatedProforma::findOne(['id' => $sub->estid]);
            $estimates->epda = $subtotal;
            $estimates->tax_amount = $tax_total;
            $estimates->unit = $subtotal_unit;
            $estimates->unit_rate = $subtotal_rate;
            $estimates->save(false);
        }
        if (empty($subcat)) {
            if (!empty($mastersub)) {
                $this->SetData($mastersub, $id, $estimates->apponitment_id);
                $subcat = SubServices::findAll(['estid' => $id]);
            }
        }
        if (!isset($sub_id)) {
            $model = new SubServices;
        } else {
            $model = $this->findModel($sub_id);
        }

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->total = $model->unit * $model->unit_price;
            $model->service_id = $estimates->service_id;
            $model->appointment_id = $estimates->apponitment_id;
            $model->estid = $id;
            if (isset($model->service_id) && $model->service_id != '') {
                $service = \common\models\Services::find()->where(['id' => $model->service_id])->one();
                if (!empty($service)) {
                    if ($service->tax != '' && $service->tax > 0 && $model->total != '' && $model->total > 0) {
                        $tax_rate = TaxMaster::findOne($service->tax)->value;
                        if ($tax_rate > 0) {
                            $model->tax_amount = ($tax_rate / 100) * $model->total;
                        }
                    }
                }
            }
            if ($model->save()) {

                return $this->redirect(['add', 'id' => $id]);
            }
        }
        return $this->render('add', [
                    'model' => $model,
                    'appointment' => $appointment,
                    'subcat' => $subcat,
                    'estimates' => $estimates,
        ]);
    }

    protected function SetData($mastersub, $id, $appointment_id) {
        foreach ($mastersub as $value) {
            $model = new SubServices;
            $model->appointment_id = $appointment_id;
            $model->estid = $id;
            $model->service_id = $value->service_id;
            $model->sub_service = $value->id;
            $model->unit = $value->unit;
            $model->unit_price = $value->unit_price;
            $model->total = $value->total;
            if (isset($model->service_id) && $model->service_id != '') {
                $service = \common\models\Services::find()->where(['id' => $model->service_id])->one();
                if ($service->tax != '' && $service->tax > 0 && $model->total != '' && $model->total > 0) {
                    $tax_rate = TaxMaster::findOne($service->tax)->value;
                    if ($tax_rate > 0) {
                        $model->tax_amount = ($tax_rate / 100) * $model->total;
                    }
                }
            }
            $model->comments = $value->comments;
            $model->rate_to_category = $value->rate_to_category;
            $model->status = $value->status;
            Yii::$app->SetValues->Attributes($model);
            $model->save(false);
        }
        return true;
    }

    /**
     * Updates an existing SubServices model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $model->total = $model->unit * $model->unit_price;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function actionDeleteSub($id) {
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Deletes an existing SubServices model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SubServices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SubServices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = SubServices::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEditEstimateSub() {
        if (Yii::$app->request->isAjax) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $value = $_POST['valuee'];
            $service_id = $_POST['service'];
            $sub_service = SubServices::find()->where(['id' => $id])->one();
            if ($name == 'unit' || $name == 'unit_price' || $name == 'total') {
                if ($name == 'unit') {
                    $sub_service->total = $sub_service->unit_price * $value;
                } elseif ($name == 'unit_price') {
                    $sub_service->total = $sub_service->unit * $value;
                } elseif ($name == 'total') {
                    $sub_service->total = $value;
                }
                if ($service_id != '') {
                    $service = \common\models\MasterSubService::find()->where(['id' => $service_id])->one();
                    if (!empty($service)) {
                        if ($service->tax != '' && $service->tax > 0 && $sub_service->total != '' && $sub_service->total > 0) {
                            $tax_rate = TaxMaster::findOne($service->tax)->value;
                            if ($tax_rate > 0) {
                                $sub_service->tax_amount = ($tax_rate / 100) * $sub_service->total;
                            }
                        }
                    }
                }
            }
            if ($value != '') {
                $sub_service->$name = $value;
                if ($sub_service->save(false)) {
                    return $sub_service->tax_amount;
                } else {
                    return 0;
                }
            }
        }
    }

    public function actionTaxPercentage() {
        if (Yii::$app->request->isAjax) {
            $service_id = $_POST['service_id'];
            $service = \common\models\MasterSubService::find()->where(['id' => $service_id])->one();
            if (!empty($service) && $service->tax != '' && $service->tax > 0) {
                $tax_rate = TaxMaster::findOne($service->tax)->value;
            } else {
                $tax_rate = 0;
            }
            echo $tax_rate;
        }
    }

}
