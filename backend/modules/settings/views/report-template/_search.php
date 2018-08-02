<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReportTemplateSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-template-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'left_logo') ?>

    <?= $form->field($model, 'right_logo') ?>

    <?= $form->field($model, 'report_description') ?>

    <?php // echo $form->field($model, 'footer_content') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'bank') ?>

    <?php // echo $form->field($model, 'account_mannager_email') ?>

    <?php // echo $form->field($model, 'account_mannager_phone') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'CB') ?>

    <?php // echo $form->field($model, 'UB') ?>

    <?php // echo $form->field($model, 'DOC') ?>

    <?php // echo $form->field($model, 'DOU') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
