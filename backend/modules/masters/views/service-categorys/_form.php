<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\InvoiceType;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\ServiceCategorys */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-categorys-form index-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'category_name')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'invoice_type')->dropDownList(ArrayHelper::map(InvoiceType::findAll(['status' => 1]), 'id', 'invoice_type'), ['prompt' => '-Choose a Invoice Type-']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

    </div>


    <div class='col-md-12 col-sm-12 col-xs-12'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php if (!empty($model->id)) { ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-gray btn-reset', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
