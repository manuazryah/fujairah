<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Ports */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ports-form index-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'value')->textInput(['maxlength' => true])->label('Tax %') ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Enabled', '0' => 'Disabled']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:86px;']) ?>
            <?php if (!empty($model->id)) { ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-gray btn-reset', 'style' => 'margin-top: 18px; height: 36px; width:86px;']) ?>
            <?php }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
