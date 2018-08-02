<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Notification */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="notification-form index-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'notification_type')->dropDownList(['1' => 'ETA', '2' => 'Cast Off'], ['prompt' => 'Notification Type', 'readonly' => 'true']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'appointment_id')->textInput(['maxlength' => true, 'readonly' => 'true']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'content')->textarea(['rows' => 2]) ?>
    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'status')->dropDownList(['1' => 'Open', '2' => 'Ignore', '3' => 'Close'], ['prompt' => 'Choose Status']) ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php if (!empty($model->id)) { ?>
                <?= Html::a('Reset', ['index'], ['class' => 'btn btn-gray btn-reset', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
            <?php }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
