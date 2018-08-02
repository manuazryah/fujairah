<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Uploads */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uploads-form index-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'form_name')->textInput(['maxlength' => true]) ?>

    </div>

    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'upload_file')->fileInput() ?>

    </div>
    <div class='col-md-12 col-sm-12 col-xs-12'>
        <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    </div>

    <div class='col-md-12 col-sm-12 col-xs-12'>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
