<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Services;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\MasterSubService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="master-sub-service-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'service_id')->dropDownList(ArrayHelper::map(Services::findAll(['status' => 1]), 'id', 'service'), ['prompt' => '-Service-']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'sub_service')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'unit')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'unit_price')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'total')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'rate_to_category')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'comments')->textarea(['rows' => 4]) ?>
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
            $("#mastersubservice-unit").keyup(function () {
                multiply();
            });
            $("#mastersubservice-unit_price").keyup(function () {
                multiply();
            });
        });
        function multiply() {
            var unit = $("#mastersubservice-unit").val();
            var unit_price = $("#mastersubservice-unit_price").val();
            if (unit != '' && unit_price != '') {
                $("#mastersubservice-total").val(unit * unit_price);
            }

        }
        $("#mastersubservice-total").prop("disabled", true);
    </script>
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
    <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
    <script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($)
        {
            $("#mastersubservice-service_id").select2({
                //placeholder: 'Select your country...',
                allowClear: true
            }).on('select2-open', function ()
            {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            });
        });</script>


</div>
