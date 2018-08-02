<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Debtor;
use yii\helpers\ArrayHelper;
use common\models\OnAccountOf;
use common\models\Contacts;

/* @var $this yii\web\View */
/* @var $model common\models\GenerateInvoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="generate-invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row" style="margin-top: 30px;">
        <div class="col-md-4">
            <?= $form->field($model, 'invoice')->dropDownList(ArrayHelper::map(Debtor::findAll(['status' => 1]), 'id', 'principal_name'), ['prompt' => '-Choose a Principal-']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'supplier')->dropDownList(ArrayHelper::map(Contacts::findAll(['status' => 1]), 'id', 'person'), ['prompt' => '-Choose a Supplier-']) ?>
        </div>
        <div class="col-md-4">
            <?php $model->date = date('Y-m-d'); ?>
            <?=
            $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
//            'value' => date('Y-m-d'),
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'oops_id')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'on_account_of')->dropDownList(ArrayHelper::map(OnAccountOf::findAll(['status' => 1]), 'id', 'on_account_of'), ['prompt' => '-Choose On Account-']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'customer_code')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'job')->dropDownList(['1' => 'SERVICE / ATTENDANCE', '2' => 'AGENTS / ATTENDANCE']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'payment_terms')->dropDownList(['1' => 'Cash', '2' => 'Cheque']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'cheque_no')->textInput() ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'to_address')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>
        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'currency')->dropDownList(['1' => 'AED', '2' => 'Dollar ']) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>
        </div>

    </div>

    <div class="row" style="margin-left: -6px;">
        <div class="col-md-12">
            <div class="form-group">
                <input type="checkbox" id="queue-order" name="bank_details" value="1" checked="checked" uncheckValue="0"><label>Bank Details</label>
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

<script>
    $("document").ready(function () {
        $("#generateinvoice-cheque_no").prop("disabled", true);
        $('#generateinvoice-invoice').change(function () {
            var invoice_id = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                data: {invoice_id: invoice_id},
                url: '<?= Yii::$app->homeUrl; ?>/invoice/generate-invoice/invoice-address',
                success: function (data) {
                    $('#generateinvoice-to_address').val(data);
                }
            });
        });

        $('#generateinvoice-payment_terms').change(function () {
            var payment_id = $(this).val();
            if (payment_id == 2) {
                $("#generateinvoice-cheque_no").prop("disabled", false);
            } else {
                $("#generateinvoice-cheque_no").prop("disabled", true);
            }
        });

        $('#generateinvoice-supplier').change(function () {
            var supplier_id = $(this).val();
            $.ajax({
                type: 'POST',
                cache: false,
                data: {supplier_id: supplier_id},
                url: '<?= Yii::$app->homeUrl; ?>/invoice/generate-invoice/supplier-address',
                success: function (data) {
                    $('#generateinvoice-to_address').val(data);
                }
            });
        });
    });
</script>
