<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Appointment */

$this->title = 'Update Appointment: ' . $model->appointment_no;
$this->params['breadcrumbs'][] = ['label' => 'Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>

            </div>
            <div class="panel-body">

                <?= Html::a('<i class="fa-th-list"></i><span> Manage Appointment</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <?= Html::a('<i class="fa-th-list"></i><span> Create Appointment</span>', ['create'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>
                <?php
                if ($model->status == 0) {
                    ?>
                    <h2 style="text-align: center;color: red;">Appointment Closed</h2>
                    <?php
                }
                ?>
                <ul class="nav nav-tabs nav-tabs-justified">
                    <li  class="active">
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Appointment</span>', ['appointment/create', 'id' => $model->id]);
                        ?>

                    </li>
                    <li>
                        <?php
                        echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Estimated Proforma</span>', ['estimated-proforma/add', 'id' => $model->id]);
                        ?>

                    </li>
                    <li>
                        <?php
                        if ($model->estimate_status == 1) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Port call Data</span>', ['port-call-data/update', 'id' => $model->id]);
                        } else {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Port call Data</span>');
                        }
                        ?>

                    </li>
                    <li>
                        <?php
                        if ($model->estimate_status == 1) {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Close Estimate</span>', ['close-estimate/add', 'id' => $model->id]);
                        } else {
                            echo Html::a('<span class="visible-xs"><i class="fa-home"></i></span><span class="hidden-xs">Close Estimate</span>');
                        }
                        ?>
                        <?php
                        ?>

                    </li>
                </ul>
                <div class="panel-body"><div class="appointment-create">
                        <?=
                        $this->render('_form', [
                            'model' => $model,
                        ])
                        ?>
                    </div>
                    <br/>
                    <hr class="appoint_history" />
                    <div style="text-align: center;">
                        <h4 class="sub-heading">Uploaded Files</h4>
                        <br/>
                        <?php
                        $path = Yii::$app->basePath . '/../uploads/final_draft' . '/' . $model->id;

                        foreach (glob("{$path}/*") as $file) {
                            $arry = explode('/', $file);
                            ?>
                            <span class="upload_file_list"><?= Html::a(end($arry), Yii::$app->homeUrl . 'uploads/final_draft/' . $model->id . '/' . end($arry), ['target' => '_blank']) ?>&nbsp;&nbsp;&nbsp;&nbsp;<?= Html::a('<i class="fa fa-remove"></i>', Yii::$app->homeUrl . 'appointment/appointment/remove?path=uploads/final_draft/' . $model->id . '/' . end($arry)) ?></span>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
