<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Branch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'branch_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'branch_code')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'responisible_peerson')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
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
