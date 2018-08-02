<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use common\models\Addresses;
use common\models\BankDetails;

/* @var $this yii\web\View */
/* @var $model common\models\ReportTemplate */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-template-form form-inline">
    <style>
        .form-inline .form-group {
            margin-left: 0px;
        }
    </style>
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'type')->dropDownList(['1' => 'EPDA', '2' => 'FDA']) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'left_logo')->fileInput() ?>
                <?php
                if ($model->left_logo != '') {
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $model->id . '/' . $model->left_logo;
                    if (file_exists($dirPath)) {
                        $img = '<img width="80px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $model->id . '/' . $model->left_logo . '"/>';
                    } else {
                        $img = '';
                    }
                } else {
                    $img = '';
                }
                echo $img;
                ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'right_logo')->fileInput() ?>
                <?php
                if ($model->right_logo != '') {
                    $dirPath = Yii::getAlias(Yii::$app->params['uploadPath']) . '/uploads/report_template/' . $model->id . '/' . $model->right_logo;
                    if (file_exists($dirPath)) {
                        $img = '<img width="80px" src="' . Yii::$app->homeUrl . 'uploads/report_template/' . $model->id . '/' . $model->right_logo . '"/>';
                    } else {
                        $img = '';
                    }
                } else {
                    $img = '';
                }
                echo $img;
                ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 report_description">
            <div class="col-md-12">
                <?=
                $form->field($model, 'report_description')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom'
                ])
                ?>
            </div>
        </div>
        <div class="col-md-12 report_footer">
            <div class="col-md-12">
                <?=
                $form->field($model, 'footer_content')->widget(CKEditor::className(), [
                    'options' => ['rows' => 6],
                    'preset' => 'custom',
                ])
                ?>
            </div>
        </div>

        <div class="col-md-4 report_address">
            <?php $adddrss = ArrayHelper::map(Addresses::findAll(['status' => 1]), 'id', 'tittle'); ?>
            <div class="col-md-12">
                <?= $form->field($model, 'address')->dropDownList($adddrss, ['prompt' => '-Choose address-']) ?>
            </div>
        </div>
        <div class="col-md-4 report_bank">
            <?php $bank = ArrayHelper::map(BankDetails::findAll(['status' => 1]), 'id', 'bank_name'); ?>
            <div class="col-md-12">
                <?= $form->field($model, 'bank')->dropDownList($bank, ['prompt' => '-Choose bank-']) ?>
            </div>
        </div>
        <div class="col-md-4 report_mang_email">
            <div class="col-md-12">
                <?= $form->field($model, 'account_mannager_email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4 report_mang_phone">
            <div class="col-md-12">
                <?= $form->field($model, 'account_mannager_phone')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'tax_id')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="col-md-12">
                <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-left: 3px;">
            <?= $form->field($model, 'default_address')->checkbox(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px;margin-right: 10px;float: right;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    $(document).ready(function () {
        var type_id = $('#reporttemplate-type').val();
        DisplayForm(type_id);
        $(document).on('change', '#reporttemplate-type', function (e) {
            var id = $(this).val();
            DisplayForm(id);
        });
        function DisplayForm(type_id) {
            if (type_id == 1) {
                $(".report_description").show();
                $(".report_-footer").show();
                $(".report_address").show();
                $(".report_bank").show();
                $(".report_mang_email").show();
                $(".report_mang_phone").show();
            } else if (type_id == 2) {
                $(".report_description").hide();
                $(".report_-footer").show();
                $(".report_address").hide();
                $(".report_bank").show();
                $(".report_mang_email").hide();
                $(".report_mang_phone").hide();
            }
        }
    });
</script>
