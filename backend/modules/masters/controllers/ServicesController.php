<?php

namespace backend\modules\masters\controllers;

use Yii;
use common\models\Services;
use common\models\ServicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
        if (Yii::$app->session['post']['masters'] != 1) {
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
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Services();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $this->Supplier($model, $_POST['Services']['supplier']) && $this->Invoice($model, $_POST['Services']['invocie_type']) && $model->save(false)) {
            if ($model->tax != '') {
                $this->UpdateSubService($model);
            }
            Yii::$app->getSession()->setFlash('success', 'Services Details created Successfully');
            $model = new Services();
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function UpdateSubService($model) {
        $sub_services = \common\models\MasterSubService::find()->where(['service_id' => $model->id])->all();
        if (!empty($sub_services)) {
            foreach ($sub_services as $value) {
                $value->tax = $model->tax;
                $value->update();
            }
        }
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model) && $this->Supplier($model, $_POST['Services']['supplier']) && $this->Invoice($model, $_POST['Services']['invocie_type']) && $model->save()) {
            if ($model->tax != '') {
                $this->UpdateSubService($model);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Services model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function Supplier($model, $supplier) {
        if ($model != null && $supplier != '') {
            $model->supplier = implode(",", $supplier);
            Yii::$app->SetValues->Attributes($model);
            return TRUE;
        } else {
            return TRUE;
        }
    }

    public function Invoice($model, $invocie_type) {
        if ($model != null && $invocie_type != '') {
            $model->invocie_type = implode(",", $invocie_type);
            Yii::$app->SetValues->Attributes($model);
            return TRUE;
        } else {
            return TRUE;
        }
    }

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
