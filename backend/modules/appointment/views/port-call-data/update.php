<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use common\models\Services;
use common\models\Currency;
use common\models\Contacts;
use common\models\Debtor;
use common\models\Appointment;
use common\models\PortBreakTimings;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use common\components\AppointmentWidget;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model common\models\PortCallData */
//echo $_GET['stat'];
//exit;
$stat = '';
$this->title = 'Update Port Call Data: ';
$this->params['breadcrumbs'][] = ['label' => 'Port Call Datas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) . ' # <b style="color: #008cbd;">' . $model->appointment->appointment_no . '</b>' ?></h3>

            </div>
            <div class="panel-body">
                <?= AppointmentWidget::widget(['id' => $model_appointment->id]) ?>

                <hr class="appoint_history" />

                <?php if (Yii::$app->session->hasFlash('porterror')): ?>
                    <div class="error">
                        <?= Yii::$app->session->getFlash('porterror'); ?>
                    </div>
                <?php endif; ?>
                <?php
                if ($model_appointment->status == 0) {
                    ?>
                    <h2 style="text-align: center;color: red;">Appointment Closed</h2>
                    <?php
                } else {
                    ?>
                    <div style="float:left;margin-right: 5px;">
                        <?= Html::beginForm(['port-call-data/reports'], 'post', ['target' => 'print_popup', 'onSubmit' => "window.open('about:blank','print_popup','width=1000,height=500');"]) ?>
                        <input type="hidden" name="app_id" value="<?= $model_appointment->id ?>">
                        <input type="checkbox" id="queue-order" name="check" value="1" checked="checked" uncheckValue="0">
                        <?= Html::submitButton('<i class="fa-print"></i><span>SOF Report</span>', ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                        <?= Html::endForm() ?>
                    </div>
                    <?php
                    $horm_url = rtrim(Yii::$app->homeUrl, '/');
                    //echo Html::a('<i class="fa-print"></i><span>SOF Report</span>', ['port-call-data/reports'], ['class' => 'btn btn-secondary btn-icon btn-icon-standalone', 'onclick' => "window.open('reports?id=$model_appointment->id', 'newwindow', 'width=750, height=800');return false;"]);
                    echo Html::a('<i class="fa-print"></i><span>Sailing Report</span>', [''], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone', 'onclick' => "window.open('$horm_url/appointment/port-call-data/sailing?id=$model_appointment->id', 'newwindow', 'width=750, height=500');return false;"]);
                    echo Html::a('<i class="fa-print"></i><span>Arrival Report</span>', [''], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone', 'onclick' => "window.open('$horm_url/appointment/port-call-data/arrival?id=$model_appointment->id', 'newwindow', 'width=750, height=500');return false;"]);
                }
                ?>
                <div style="float: left;">
                    <ul class="nav nav-tabs nav-tabs-justified">
                        <li>
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span>', ['appointment/update', 'id' => $model_appointment->id]);
                            ?>

                        </li>
                        <li>
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Estimated Proforma</span>', ['estimated-proforma/add', 'id' => $model_appointment->id]);
                            ?>

                        </li>
                        <li class="active">
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Port call Data</span>', ['port-call-data/update', 'id' => $model_appointment->id]);
                            ?>

                        </li>
                        <li>
                            <?php
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Close Estimate</span>', ['close-estimate/add', 'id' => $model_appointment->id]);
                            ?>
                        </li>
                    </ul>
                    <?php //Html::a('<i class="fa-th-list"></i><span> Manage Port Call Data</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone'])    ?>
                    <ul class="nav nav-tabs nav-tabs-justified colo" style="background-color:#f9f9f9;padding-top: 5px;">
                        <li class="<?= $stat == 1 || $stat == NULL ? 'active' : '' ?>">
                            <a  href="#port-data" data-toggle="tab">
                                <span class="visible-xs"><i class="fa-home"></i></span>
                                <span class="hidden-xs">Port Call Data</span>
                            </a>
                        </li>
                        <li class="<?= $stat == 2 ? 'active' : '' ?>">
                            <a href="#port-draft" data-toggle="tab">
                                <span class="visible-xs"><i class="fa-user"></i></span>
                                <span class="hidden-xs">Port Call Data Draft-Rob</span>
                            </a>
                        </li>
                        <li class="<?= $stat == 3 ? 'active' : '' ?>">
                            <a href="#port-rob" data-toggle="tab">
                                <span class="visible-xs"><i class="fa-user"></i></span>
                                <span class="hidden-xs">Cargo Details</span>
                            </a>
                        </li>
                    </ul>
                    <p class="mark-msg">Re: All fields marked with an asterisk (*) are required.</p>
                    <div class="tab-content">
                        <div class="tab-pane <?= $stat == 1 || $stat == NULL ? 'active' : '' ?>" id="port-data">
                            <div class="panel-body">
                                <div class="port-call-data-create">
                                    <?=
                                    $this->render('_form', [
                                        'model' => $model,
                                        'model_add' => $model_add,
                                        'model_imigration' => $model_imigration,
                                        'model_appointment' => $model_appointment,
                                        'model_additional' => $model_additional,
                                        'model_comments' => $model_comments,
                                    ])
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane <?= $stat == 2 ? 'active' : '' ?>" id="port-draft">
                            <div class="panel-body">
                                <div class="port-call-data-draft-create">
                                    <?=
                                    $this->render('_form_draft_rob', [
                                        'model_draft' => $model_draft,
                                        'model_rob' => $model_rob,
                                        'model_appointment' => $model_appointment,
                                        'model' => $model,
                                    ])
                                    ?>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane <?= $stat == 3 ? 'active' : '' ?>" id="port-rob">
                            <div class="panel-body">
                                <div class="port-call-data-port-break-create">
                                    <?=
                                    $this->render('_form_port_break', [
                                        'model_appointment' => $model_appointment,
                                        'model_port_break' => $model_port_break,
                                        'model_port_cargo_details' => $model_port_cargo_details,
                                        'model_port_stoppages' => $model_port_stoppages,
                                    ])
                                    ?>
                                </div>
                            </div>

                        </div>
                        <br/>
                        <?php
                        if ($model_appointment->status != 0) {
                            ?>
                            <hr class="appoint_history" />
                            <div class="panel-body upload-div">
                                <?php // Yii::$app->UploadFile->ListFile($model_appointment->id, Yii::$app->params['datPath']);  ?>
                                <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'action' => Yii::$app->homeUrl . 'appointment/port-call-data/uploads', 'method' => 'post']) ?>
                                <?php
                                $model_upload->appointment_id = $model_appointment->id;
                                $model_upload->type = Yii::$app->params['datPath'];
                                ?>
                                <?php //$form->field($model_upload, 'filee[]')->fileInput(['multiple' => true]) ?>
                                <?= $form->field($model_upload, 'filee[]')->fileInput(['multiple' => true, 'class' => 'upload-box']) ?>
                                <?= $form->field($model_upload, 'appointment_id')->hiddenInput()->label(false) ?>
                                <?= $form->field($model_upload, 'type')->hiddenInput()->label(false) ?>
                                <?= Html::submitButton('<i class="fa fa-upload"></i><span>Upload</span>', ['class' => 'btn btn-secondary btn-icon btn-icon-standalone']) ?>


                                <?php ActiveForm::end() ?>
                            </div>
                            <br/>
                            <?php
                        }
                        ?>
                        <hr class="appoint_history" />
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="sub-heading">Uploaded Files</h4>
                                <br/>
                                <?php
                                if (!empty(Yii::$app->UploadFile->ListFile($model_appointment->id, Yii::$app->params['datPath']))) {
                                    $string = Yii::$app->UploadFile->ListFile($model_appointment->id, Yii::$app->params['datPath']);
                                    $uploads = explode("|", $string);
                                    array_pop($uploads);
                                    foreach ($uploads as $upload) {
                                        ?>
                                        <span class="upload_file_list upload_file_list1"><?= $upload ?></span>
                                        <?php
                                    }
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div style="float:right;padding-top: 5px;">
                    <?php
                    if ($model_appointment->status != 0) {
                        echo Html::a('<span> Portcall Data Completed & Proceed to Close Estimate</span>', ['port-call-data/portcall-complete', 'id' => $model_appointment->id], ['class' => 'btn btn-secondary']);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <style>
        .colo.nav.nav-tabs>li.active>a {
            background-color: #f9f9f9;
        }
        .colo.nav.nav-tabs>li>a:hover {
            border: none;
            background-color: #eeeeee;
        }
        .form-control{
            border: 1px solid #cacaca;
        }
        .nav.nav-tabs+.tab-content {
            background-color: #f9f9f9 !important
                padding: 30px;
            margin-bottom: 30px;
        }
        .form .form-group.has-success .control-label, form .form-group.has-success .radio, form .form-group.has-success .checkbox, form .form-group.has-success .radio-inline, form .form-group.has-success .checkbox-inline {
            color: #8ef305;
        }
        .error{
            border-radius: 5px;
            padding: 5px 20px;
            color: white;
            font-size: 16px;
            background: #a00808;
            margin-bottom: 20px;
        }
        .display-uploads{
            margin-bottom: 25px;
            text-align: center;
            margin-left: 175px;
            margin-right: 100px;
        }
        .required-star{
            color: red;
            font-size: 14px;
        }
        .mark-msg{
            color: red;
            padding: 9px 0px 0px 23px;
            position: absolute;
            right: 30px;
        }
    </style>
</div>
