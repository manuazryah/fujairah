<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DeliveryOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'to')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'po_box')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'arrived_from')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?=
            $form->field($model, 'arrived_on')->widget(\yii\jui\DatePicker::classname(), [
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
                'value' => date('Y-m-d'),
                'options' => ['class' => 'form-control']
            ])
            ?>
        </div>
    </div>
    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'vessel_name')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'voyage_no')->textInput(['maxlength' => true]) ?>
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
