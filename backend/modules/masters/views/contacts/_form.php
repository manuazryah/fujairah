<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Contacts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'person')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'phone_1')->textInput(['maxlength' => true]) ?>
        </div>

    </div>
    <div class="row">

        <div class="col-md-4">
            <?= $form->field($model, 'phone_2')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'contact_type')->dropDownList(['1' => 'Nominator', '2' => 'Charterer', '3' => 'Shipper', '4' => 'Supplier'], ['options' => Yii::$app->SetValues->Selected($model->contact_type), 'multiple' => 'multiple']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textarea(['rows' => 4]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'comment')->textarea(['rows' => 4]) ?>
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

</div>
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>/js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>/js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>/js/select2/select2.min.js"></script>
<script>
    $("#contacts-contact_type").select2({
        placeholder: '--Select Branch--',
        allowClear: true
    }).on('select2-open', function ()
    {
        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
    });
</script>
