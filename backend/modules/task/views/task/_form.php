<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form index-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php
    $employees = ArrayHelper::map(\common\models\Employee::find()->where(['status' => 1])->all(), 'id', 'name');
    $appointment = ArrayHelper::map(\common\models\Appointment::find()->where(['status' => 1])->all(), 'id', 'appointment_no');
    ?>

    <div class='col-md-4'>
        <?= $form->field($model, 'follow_up_msg')->textarea(['rows' => 5]) ?>
    </div>
    <div class='col-md-4'>
        <?= $form->field($model, 'assigned_to')->dropDownList($employees, ['prompt' => '- Select -']) ?>
    </div>

    <div class='col-md-4'>
        <?= $form->field($model, 'appointment_id')->dropDownList($appointment, ['prompt' => '- Select -', 'multiple' => 'multiple']) ?>
    </div>
    <div class='col-md-4'>
        <?php
        if (!$model->date) {
            $model->date = date('Y-m-d H:m');
        }
        ?>
        <?php
        echo $form->field($model, 'date')->widget(DateTimePicker::classname(), [
            'options' => ['placeholder' => ''],
            'pluginOptions' => [
                'autoclose' => true
            ]
        ]);
        ?>
    </div>
    <div class='col-md-4'>
        <?= $form->field($model, 'follow_up')->dropDownList($employees, ['prompt' => '- Select -', 'id' => 'follow-ups', 'multiple' => 'multiple']) ?>
    </div>
    <div class='col-md-4 col-sm-6 col-xs-12' style="float:right;">
        <div class="form-group" style="float: right;">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'style' => 'margin-top: 18px; height: 36px; width:100px;']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2.css">
<link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>js/select2/select2-bootstrap.css">
<script src="<?= Yii::$app->homeUrl; ?>js/select2/select2.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function ($)
    {
        $("#task-assigned_to").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#task-appointment_id").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $("#follow-ups").select2({
            allowClear: true
        }).on('select2-open', function ()
        {
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
        });
        $('.task-link').click(function () {
            $('.hide-task-div').slideToggle();
        });
    });
</script>