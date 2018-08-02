<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdminPosts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'post_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'admin')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'masters')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'appointments')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'estimated_proforma')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'port_call_data')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'close_estimate')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'funding_allocation')->dropDownList(['1' => 'Yes', '0' => 'No']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group" style="float: left;">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px;margin-left: 20px;']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
