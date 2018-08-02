<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BankDetailsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="bank-details-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'account_holder_name') ?>

    <?= $form->field($model, 'account_no') ?>

    <?= $form->field($model, 'iban') ?>

    <?= $form->field($model, 'bank_name') ?>

    <?php // echo $form->field($model, 'swift') ?>

    <?php // echo $form->field($model, 'branch') ?>

    <?php // echo $form->field($model, 'correspontant_bank') ?>

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
