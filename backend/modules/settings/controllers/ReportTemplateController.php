<?php

namespace backend\modules\settings\controllers;

use Yii;
use common\models\ReportTemplate;
use common\models\ReportTemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ReportTemplateController implements the CRUD actions for ReportTemplate model.
 */
class ReportTemplateController extends Controller {

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
     * Lists all ReportTemplate models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new ReportTemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportTemplate model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ReportTemplate model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new ReportTemplate();
        $model->setScenario('create');

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {

            $model = $this->SetExtension($model);

            $data_exist = ReportTemplate::find()->where(['default_address' => 1, 'type' => $model->type])->one();
            if (isset($model->default_address) && $model->default_address == 1) {
                if (!empty($data_exist)) {
                    $data_exist->default_address = 0;
                    $data_exist->save();
                }
                $model->default_address = 1;
            } else {
                if (!empty($data_exist)) {

                    $model->default_address = 0;
                } else {
                    $model->default_address = 1;
                }
            }


            if ($model->validate() && $model->save()) {

                if (!empty($data_exist)) {
                    $data_exist->default_address = 0;
                    $data_exist->update();
                }
                $this->Upload($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReportTemplate model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $data = $this->findModel($id);
            $data_exist = ReportTemplate::find()->where(['default_address' => 1, 'type' => $model->type])->one();
            $data_count = ReportTemplate::find()->where(['default_address' => 1, 'type' => $model->type])->all();
            if (isset($model->default_address) && $model->default_address == 1) {
                if (!empty($data_exist)) {
                    if (count($data_count) > 1) {
                        $data_exist->default_address = 0;
                        $data_exist->save();
                    }
                }
                $model->default_address = 1;
            } else {
                if (!empty($data_exist)) {

                    $model->default_address = 0;
                } else {
                    $model->default_address = 1;
                }
            }
            if ($model->save()) {
                $this->Upload($model, $data);
                return $this->redirect(['update', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    public function SetExtension($model) {

        $file_left = UploadedFile::getInstance($model, 'left_logo');
        $file_right = UploadedFile::getInstance($model, 'right_logo');
        if (!empty($file_left)) {
            $model->left_logo = 'left.' . $file_left->extension;
        }
        if (!empty($file_right)) {
            $model->right_logo = 'right.' . $file_right->extension;
        }

        return $model;
    }

    public function Upload($model, $data_exist = NULL) {
        $file_left = UploadedFile::getInstance($model, 'left_logo');
        $file_right = UploadedFile::getInstance($model, 'right_logo');
        $dir = Yii::$app->basePath . '/../uploads/report_template/' . $model->id;
        if (!is_dir($dir)) {
            mkdir($dir);
        }
        if (!empty($file_left)) {
            if ($file_left->saveAs(Yii::$app->basePath . '/../uploads/report_template/' . $model->id . '/left.' . $file_left->extension)) {
                if (!$model->isNewRecord) {
                    $model->left_logo = 'left.' . $file_left->extension;
                    $model->save(FALSE);
                }
            }
        } else {
            $model->left_logo = $data_exist->left_logo;
            $model->save(FALSE);
        }
        if (!empty($file_right)) {
            if ($file_right->saveAs(Yii::$app->basePath . '/../uploads/report_template/' . $model->id . '/right.' . $file_right->extension)) {
                if (!$model->isNewRecord) {
                    $model->right_logo = 'right.' . $file_right->extension;
                    $model->save(FALSE);
                }
            }
        } else {
            $model->right_logo = $data_exist->right_logo;
            $model->save(FALSE);
        }
        return;
    }

    /**
     * Deletes an existing ReportTemplate model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportTemplate model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportTemplate the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ReportTemplate::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
