<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Addresses */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .form-inline .form-group {
        margin-left: 0px;
    }
</style>
<div class="addresses-form form-inline">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <?= $form->field($model, 'tittle')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <?=
                $form->field($model, 'main_office_address')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <?=
                $form->field($model, 'port_office_address')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="col-md-12">
                <?=
                $form->field($model, 'contact_details')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])
                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-12">
                <?=
                $form->field($model, 'emergency_contact_details')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
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
