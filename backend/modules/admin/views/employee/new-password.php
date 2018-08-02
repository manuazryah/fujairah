<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Employee */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<style>
    .form-group {
        margin-bottom: 15px;
    }
</style>
<div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>


            </div>
            <div class="panel-body">
                <?php // Html::a('<i class="fa-th-list"></i><span> Manage Admin Users</span>', ['index'], ['class' => 'btn btn-warning  btn-icon btn-icon-standalone']) ?>

                <div class="panel-body">
                    <div class="employee-create">
                        <?php
                        $form = ActiveForm::begin(
                                        [
                                            'id' => 'forgot-email',
                                            'method' => 'post',
                                            'options' => [
                                                'class' => 'login-form fade-in-effect'
                                            ]
                                        ]
                        );
                        ?>
                        <?php if (Yii::$app->session->hasFlash('success')):
                            ?>
                            <div class="alert alert-success" role="alert" style="padding: 7px;">
                                <?= Yii::$app->session->getFlash('success') ?>
                            </div>
                        <?php endif; ?>

                        <?php if (Yii::$app->session->hasFlash('error')): ?>
                            <div class="alert alert-danger" role="alert" style="padding: 7px;">
                                <?= Yii::$app->session->getFlash('error') ?>
                            </div>
                        <?php endif; ?>
                        <div class="row">
                            <div class = "form-group col-md-12">
                                <div class = "form-group field-adminusers-password" style="width: 100%">
                                    <label style = "font-weight:bold;">Enter new Password:</label>
                                    <input type = "password" id = "new-password" class = "form-control" name = "new-password" autofocus = "false" required>
                                    <p class = "help-block help-block-error"></p>
                                </div>

                            </div>
                            <div class = "form-group col-md-12">
                                <div class = "form-group field-adminusers-password" style="width: 100%">
                                    <label style = "font-weight:bold;">Confirm Password:</label>
                                    <input type = "password" id = "confirm-password" class = "form-control" name = "confirm-password" autofocus = "false" required>
                                    <p class = "help-block help-block-error"></p>
                                </div>

                            </div>
                        </div>

                        <div class = "form-group">
                            <button type = "submit" class = "btn btn-secondary">Reset</button>
                        </div>
                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4"></div>
</div>