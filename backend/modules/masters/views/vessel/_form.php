<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\VesselType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Vessel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vessel-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $dataList = ArrayHelper::map(VesselType::find()->asArray()->all(), 'id', 'vessel_type');
    ?>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'vessel_type')->dropDownList($dataList, ['prompt' => '--Choose a Vessel type--']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'vessel_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'imo_no')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'official')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'mmsi_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'land_line')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'direct_line')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'fax')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'mob_no')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'uae_no')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'picture')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'dwt')->textInput(['maxlength' => true, 'class' => 'mtpostfix form-control']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'grt')->textInput(['maxlength' => true, 'class' => 'mtpostfix form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'nrt')->textInput(['maxlength' => true, 'class' => 'mtpostfix form-control']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'loa')->textInput(['maxlength' => true, 'class' => 'mpostfix form-control']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'beam')->textInput(['maxlength' => true, 'class' => 'mpostfix form-control']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'owners_info')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'other')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
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

    <script>
        $(document).ready(function () {
            /*
             * To add decimal(.000) to the desired text fields
             */
            $('.mtpostfix').blur(function () {
                var str = $(this).val();
                if (str != '') {
                    if (str.toLowerCase().indexOf('mt') == -1) {
                        $(this).val(str + ' MT');
                    }
                }
            });


            $('.mpostfix').blur(function () {
                var str = $(this).val();
                if (str != '') {
                    if (str.toLowerCase().indexOf('m') == -1) {
                        $(this).val(str + ' M');
                    }
                }
            });



        });
    </script>

</div>
