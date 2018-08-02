<?php

namespace backend\modules\admin\controllers;

use Yii;
use common\models\Employee;
use common\models\EmployeeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use common\models\CashInHand;
use common\models\CashInHandSearch;
use common\models\ProfileUploads;
use common\models\ProfileUploadsSearch;

/**
 * EmployeeController implements the CRUD actions for Employee model.
 */
class EmployeeController extends Controller {

    public function beforeAction($action) {
        if (!parent::beforeAction($action)) {
            return false;
        }
        if (Yii::$app->user->isGuest) {
            $this->redirect(['/site/index']);
            return false;
        }
//        if (Yii::$app->session['post']['admin'] != 1) {
//            $this->redirect(['/site/home']);
//            return false;
//        }
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
     * Lists all Employee models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new EmployeeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employee model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Employee model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Employee();
        $model_upload = '';
        $model->setScenario('create');

        if ($model->load(Yii::$app->request->post())) {
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->date_of_join = date("Y-m-d", strtotime($model->date_of_join));
            $files = UploadedFile::getInstance($model, 'photo');
            if (!empty($files)) {
                $model->photo = $files->extension;
            }
            if ($model->validate() && $model->save() && $this->upload($model, $files)) {
                $this->Imageupload($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
                    'model' => $model,
                    'model_upload' => $model_upload,
        ]);
    }

    /**
     * Updates an existing Employee model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $photo_ = $model->photo;
        $model_upload = ProfileUploads::find()->where(['employee_id' => $model->id])->all();
        if ($model->load(Yii::$app->request->post())) {
            $model->date_of_join = date("Y-m-d", strtotime($model->date_of_join));
            $files = UploadedFile::getInstance($model, 'photo');
           
            if (empty($files)) {
                $model->photo = $photo_;
            } else {
                $model->photo = $files->extension;
            }
            if ($model->save()) {
                $this->upload($model, $files);
                $this->Imageupload($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'model_upload' => $model_upload,
            ]);
        }
    }

    /*
     * to upload image
     *  */

    public function Imageupload($model) {
        if (isset($_POST['creates']) && $_POST['creates'] != '') {


            $arrs = [];
            $i = 0;

            foreach ($_FILES['creates'] ['name'] as $row => $innerArray) {
                $i = 0;
                foreach ($innerArray as $innerRow => $value) {
                    $arrs[$i]['name'] = $value;
                    $i++;
                }
            }
            $i = 0;
            foreach ($_FILES['creates'] ['tmp_name'] as $row => $innerArray) {
                $i = 0;
                foreach ($innerArray as $innerRow => $value) {
                    $arrs[$i]['tmp_name'] = $value;
                    $i++;
                }
            }
            $i = 0;

            foreach ($_FILES['creates'] ['name'] as $row => $innerArray) {
                $i = 0;
                foreach ($innerArray as $innerRow => $value) {
                    $ext = pathinfo($value, PATHINFO_EXTENSION);
                    $arrs[$i]['extension'] = $ext;
                    $i++;
                }
            }
            $i = 0;
            foreach ($_POST['creates']['file_name'] as $val) {
                $arrs[$i]['file_name'] = $val;
                $i++;
            }
            $i = 0;
            foreach ($_POST['creates']['expiry_date'] as $val) {
                $arrs[$i]['expiry_date'] = $val;
                $i++;
            }
            if (!empty($arrs)) {
                $this->SaveAttachment($model, $arrs);
            }
        }
        return;
    }

    /*
     * to save the Attachment
     */

    public function SaveAttachment($model, $arrs) {
        foreach ($arrs as $val) {
            $model_upload = new ProfileUploads();
            $model_upload->employee_id = $model->id;
            if (isset($val['file_name']) && $val['file_name'] != '') {
                $model_upload->label = $val['file_name'];
            }
            if (isset($val['expiry_date']) && $val['expiry_date'] != '') {
                $model_upload->expiry_date = $val['expiry_date'];
            }
            if (isset($val['name']) && $val['name'] != '') {
                $model_upload->file = $val['name'];
            }
            if ($model_upload->label != '' && $model_upload->file != '') {
                $allowed = array('pdf', 'txt', 'doc', 'docx', 'xls', 'xlsx', 'msg', 'zip', 'eml', 'jpg', 'jpeg', 'png');
                if (in_array($val['extension'], $allowed)) {
                    if ($model_upload->save()) {
                        $file_name = $val['name'];
                        $root = Yii::$app->basePath . '/../uploads/employee/' . $model_upload->id;
                        if (!is_dir($root)) {
                            mkdir($root);
                        }
                        move_uploaded_file($val['tmp_name'], $root . '/' . $file_name);
                    }
                }
            }
        }
    }

    /**
     * Deletes an existing Employee model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionAttachmentDelete($id) {
        $model = ProfileUploads::find()->where(['id' => $id])->one();
        if (!empty($model)) {
            if ($model->delete()) {
                $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/employee/' . $model->id;
                $file_name = $dirPath . '/' . $model->file;
                if (file_exists($file_name)) {
                    unlink($file_name);
                }
                if (is_dir($dirPath)) {
                    rmdir($dirPath);
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Employee model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Employee the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Upload Material photos.
     * @return mixed
     */
    public function Upload($model, $files) {
   
        if (isset($files) && !empty($files)) {
            $files->saveAs(Yii::$app->basePath . '/../uploads/' . $model->id . '.' . $files->extension);
           
        }
        return TRUE;
    }

    public function Branch($model, $branch) {

        if ($model != null && $branch != '') {
            $model->date_of_join = date("Y-m-d", strtotime($model->date_of_join));
            $model->branch_id = implode(",", $branch);
            Yii::$app->SetValues->Attributes($model);

            if ($model->isNewRecord):
                $model->password = Yii::$app->security->generatePasswordHash($model->password);
            endif;
            return true;
        }else {
            return false;
        }
    }

  public function actionChangePassword($id = NULL) {
        if ($id == '') {
            $id = Yii::$app->user->identity->id;
        }
        $model = $this->findModel($id);
        if (Yii::$app->request->post()) {
            if (Yii::$app->request->post('new-password') == Yii::$app->request->post('confirm-password')) {

                Yii::$app->getSession()->setFlash('success', 'password changed successfully');
                $model->password = Yii::$app->security->generatePasswordHash(Yii::$app->request->post('confirm-password'));
                $model->update();
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                Yii::$app->getSession()->setFlash('error', 'password mismatch');
            }
        }
        return $this->render('new-password', [
                    'model' => $model,
        ]);
    }

    public function actionAdd($id, $fund_id = NULL) {
        $cash_in_hand = CashInHand::findAll(['employee_id' => $id]);
        if (!isset($fund_id)) {
            $model = new CashInHand();
        } else {
            $model = CashInHand::findOne($fund_id);
//            $model->date = Yii::$app->ChangeDateFormate->SingleDateFormat($model->date);
        }
        if ($model->load(Yii::$app->request->post()) && Yii::$app->SetValues->Attributes($model)) {
            $cash_in_hand = CashInHand::find()->orderBy(['id' => SORT_DESC])->where(['employee_id' => $id])->one();
            $model->employee_id = $id;
            $model->transaction_type = 1;
            if (!isset($fund_id)) {
                $model->balance = $cash_in_hand->balance + $model->amount;
            } else {
                $model->balance = $cash_in_hand->balance + ($model->amount - $cash_in_hand->amount);
            }
//            $model->date = Yii::$app->ChangeDateFormate->SingleDateFormat($model->date);

            if ($model->save()) {
                return $this->redirect(['add', 'id' => $id]);
            }
        }
        $searchModel = new CashInHandSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider->query->andWhere(['employee_id' => $id]);
        return $this->render('add', [
                    'model' => $model,
                    'cash_in_hand' => $cash_in_hand,
                    'id' => $id,
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAttachment() {
        if (Yii::$app->request->isAjax) {
            $data = $this->renderPartial('_form_add_attachment');
            echo $data;
        }
    }

}
