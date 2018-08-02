<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BankDetails */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-inline .form-group {
        margin-left: 0px;
    }
</style>
<div class="bank-details-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'account_holder_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'account_no')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'iban')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'swift')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'branch')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'correspontant_bank')->textInput(['maxlength' => true]) ?>
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
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px;margin-right: 10px;float: right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
