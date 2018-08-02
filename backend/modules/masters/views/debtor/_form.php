<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Debtor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'principal_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'principal_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'principal_ref_no')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tele_phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'invoicing_address')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'epda_address')->textarea(['rows' => 4]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'da_dispatch_addresss_1')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'da_dispatch_addresss_2')->textarea(['rows' => 4]) ?>
        </div>

    </div>
    <div class="row">
        <<div class="col-md-6">
            <?= $form->field($model, 'tax')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
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
